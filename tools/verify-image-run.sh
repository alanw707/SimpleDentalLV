#!/usr/bin/env bash
set -euo pipefail

# Orchestrates verification across environments using a JSON config.
# Depends on: jq, and platform CLIs (kubectl/aws/docker) as needed.

if ! command -v jq >/dev/null 2>&1; then
  echo "jq is required (brew install jq | apt-get install jq)" >&2
  exit 1
fi

CONFIG_FILE=${1:-tools/verify-image.config.json}
ACTION=${2:-verify} # verify | fix (fix will attempt rollout/force deploy when mismatch)

if [[ ! -f "$CONFIG_FILE" ]]; then
  echo "Config not found: $CONFIG_FILE" >&2
  echo "Copy tools/verify-image.config.example.json to $CONFIG_FILE and edit." >&2
  exit 1
fi

PLATFORM=$(jq -r '.platform' "$CONFIG_FILE")

echo "== Verify Images (platform: $PLATFORM) =="

ENV_KEYS=$(jq -r '.environments | keys[]' "$CONFIG_FILE")

declare -A DECLARED
declare -A RUNNING
declare -A EXPECTED

for ENV in $ENV_KEYS; do
  echo
  echo "--- Environment: $ENV ---"
  EXPECTED[$ENV]=$(jq -r ".environments[\"$ENV\"].expected // \"\"" "$CONFIG_FILE")

  case "$PLATFORM" in
    aca)
      RG=$(jq -r ".environments[\"$ENV\"].resourceGroup" "$CONFIG_FILE")
      APP=$(jq -r ".environments[\"$ENV\"].app" "$CONFIG_FILE")
      CMD=("$(dirname "$0")/verify-image.sh" aca --resource-group "$RG" --app "$APP")
      [[ -n "${EXPECTED[$ENV]}" ]] && CMD+=(--expected "${EXPECTED[$ENV]}")
      "${CMD[@]}"
      if command -v az >/dev/null 2>&1; then
        DECLARED[$ENV]=$(az containerapp show -g "$RG" -n "$APP" --query "properties.template.containers[0].image" -o tsv 2>/dev/null || true)
        RUNNING[$ENV]=$(az containerapp revision list -g "$RG" -n "$APP" --query "[?properties.active].properties.template.containers[0].image | [0]" -o tsv 2>/dev/null || true)
      fi
      ;;
    k8s)
      NS=$(jq -r ".environments[\"$ENV\"].namespace" "$CONFIG_FILE")
      DEPLOY=$(jq -r ".environments[\"$ENV\"].deployment // \"\"" "$CONFIG_FILE")
      SELECTOR=$(jq -r ".environments[\"$ENV\"].selector // \"\"" "$CONFIG_FILE")
      CMD=("$(dirname "$0")/verify-image.sh" k8s --namespace "$NS")
      [[ -n "$DEPLOY" && "$DEPLOY" != "null" ]] && CMD+=(--deploy "$DEPLOY")
      [[ -n "$SELECTOR" && "$SELECTOR" != "null" ]] && CMD+=(--selector "$SELECTOR")
      [[ -n "${EXPECTED[$ENV]}" ]] && CMD+=(--expected "${EXPECTED[$ENV]}")
      "${CMD[@]}"

      HEALTH=$(jq -r ".environments[\"$ENV\"].healthUrl // \"\"" "$CONFIG_FILE")
      if [[ -n "$HEALTH" && "$HEALTH" != "null" ]]; then
        echo "Health check: $HEALTH"
        curl -fsS "$HEALTH" | sed -e 's/{/\n{/g' -e 's/,/\n  ,/g' || echo "(health request failed)"
      fi

      # Capture declared image from deployment if provided
      if command -v kubectl >/dev/null 2>&1 && [[ -n "$DEPLOY" ]]; then
        DECLARED[$ENV]=$(kubectl -n "$NS" get deploy "$DEPLOY" -o jsonpath='{.spec.template.spec.containers[*].image}' || true)
        RUNNING[$ENV]=$(kubectl -n "$NS" get pods -l app="$DEPLOY" -o jsonpath='{range .items[*]}{.status.containerStatuses[0].imageID}{"\n"}{end}' 2>/dev/null | head -n1 || true)
      fi
      ;;

    ecs)
      CLUSTER=$(jq -r ".environments[\"$ENV\"].cluster" "$CONFIG_FILE")
      SERVICE=$(jq -r ".environments[\"$ENV\"].service" "$CONFIG_FILE")
      CMD=("$(dirname "$0")/verify-image.sh" ecs --cluster "$CLUSTER" --service "$SERVICE")
      [[ -n "${EXPECTED[$ENV]}" ]] && CMD+=(--expected "${EXPECTED[$ENV]}")
      "${CMD[@]}"

      HEALTH=$(jq -r ".environments[\"$ENV\"].healthUrl // \"\"" "$CONFIG_FILE")
      if [[ -n "$HEALTH" && "$HEALTH" != "null" ]]; then
        echo "Health check: $HEALTH"
        curl -fsS "$HEALTH" | sed -e 's/{/\n{/g' -e 's/,/\n  ,/g' || echo "(health request failed)"
      fi

      if command -v aws >/dev/null 2>&1 && command -v jq >/dev/null 2>&1; then
        TD=$(aws ecs describe-services --cluster "$CLUSTER" --services "$SERVICE" | jq -r '.services[0].taskDefinition')
        DECLARED[$ENV]=$(aws ecs describe-task-definition --task-definition "$TD" | jq -r '.taskDefinition.containerDefinitions[0].image')
        RUNNING[$ENV]=$(aws ecs list-tasks --cluster "$CLUSTER" --service-name "$SERVICE" --desired-status RUNNING | jq -r '.taskArns[0] // empty' | xargs -r -I{} aws ecs describe-tasks --cluster "$CLUSTER" --tasks {} | jq -r '.tasks[0].containers[0].image // empty')
      fi
      ;;

    compose)
      PROJ=$(jq -r ".environments[\"$ENV\"].projectName // \"\"" "$CONFIG_FILE")
      FILE=$(jq -r ".environments[\"$ENV\"].file // \"\"" "$CONFIG_FILE")
      ARGS=()
      [[ -n "$PROJ" && "$PROJ" != "null" ]] && ARGS+=(--project-name "$PROJ")
      [[ -n "$FILE" && "$FILE" != "null" ]] && ARGS+=(--file "$FILE")
      CMD=("$(dirname "$0")/verify-image.sh" compose ${ARGS[@]})
      [[ -n "${EXPECTED[$ENV]}" ]] && CMD+=(--expected "${EXPECTED[$ENV]}")
      "${CMD[@]}"
      HEALTH=$(jq -r ".environments[\"$ENV\"].healthUrl // \"\"" "$CONFIG_FILE")
      if [[ -n "$HEALTH" && "$HEALTH" != "null" ]]; then
        echo "Health check: $HEALTH"
        curl -fsS "$HEALTH" | sed -e 's/{/\n{/g' -e 's/,/\n  ,/g' || echo "(health request failed)"
      fi
      DECLARED[$ENV]=$(docker compose ${ARGS[@]} images 2>/dev/null | awk 'NR>1 {print $2; exit}')
      RUNNING[$ENV]=$(docker ps --format '{{.Image}}' | head -n1)
      ;;

    *)
      echo "Unknown platform in config: $PLATFORM" >&2; exit 1;;
  esac
done

echo
echo "== Environment Comparison =="
for ENV in $ENV_KEYS; do
  echo "[$ENV] declared: ${DECLARED[$ENV]:-n/a}"
  echo "[$ENV] running:  ${RUNNING[$ENV]:-n/a}"
  if [[ -n "${EXPECTED[$ENV]}" ]]; then
    if echo "${DECLARED[$ENV]:-}" | grep -q "${EXPECTED[$ENV]}"; then
      echo "[$ENV] expected match: YES"
    else
      echo "[$ENV] expected match: NO"
    fi
  fi
done

echo
if [[ "$ACTION" == "fix" ]]; then
  echo "== Attempting remediation for mismatches =="
  case "$PLATFORM" in
    aca)
      if [[ -z "${EXPECTED[prod]:-}" && -z "${EXPECTED[dev]:-}" ]]; then
        echo "No expected tag provided; skip remediation for ACA."; break
      fi
      for ENV in $ENV_KEYS; do
        RG=$(jq -r ".environments[\"$ENV\"].resourceGroup" "$CONFIG_FILE")
        APP=$(jq -r ".environments[\"$ENV\"].app" "$CONFIG_FILE")
        EXP="${EXPECTED[$ENV]:-}"
        if [[ -n "$EXP" ]]; then
          CURRENT=$(az containerapp show -g "$RG" -n "$APP" --query "properties.template.containers[0].image" -o tsv)
          if ! echo "$CURRENT" | grep -q "$EXP"; then
            REPO=${CURRENT%:*}
            echo "[$ENV] Updating $APP to ${REPO}:$EXP"
            az containerapp update -g "$RG" -n "$APP" --image "${REPO}:$EXP" >/dev/null || true
          else
            echo "[$ENV] Already on expected: $CURRENT"
          fi
        fi
      done
      ;;
    k8s)
      for ENV in $ENV_KEYS; do
        NS=$(jq -r ".environments[\"$ENV\"].namespace" "$CONFIG_FILE")
        DEPLOY=$(jq -r ".environments[\"$ENV\"].deployment // \"\"" "$CONFIG_FILE")
        if [[ -n "$DEPLOY" ]]; then
          echo "[$ENV] rollout restart deploy/$DEPLOY in ns/$NS"
          kubectl -n "$NS" rollout restart deploy/"$DEPLOY" || true
        fi
      done
      ;;
    ecs)
      for ENV in $ENV_KEYS; do
        CLUSTER=$(jq -r ".environments[\"$ENV\"].cluster" "$CONFIG_FILE")
        SERVICE=$(jq -r ".environments[\"$ENV\"].service" "$CONFIG_FILE")
        echo "[$ENV] ECS force new deployment: $SERVICE"
        aws ecs update-service --cluster "$CLUSTER" --service "$SERVICE" --force-new-deployment >/dev/null || true
      done
      ;;
    compose)
      echo "Compose remediation: pulling and recreating containers"
      docker compose pull || true
      docker compose up -d --remove-orphans || true
      ;;
  esac
fi

echo "\nDone."
