#!/usr/bin/env bash
set -euo pipefail

# verify-image.sh — Inspect the running image for a service across platforms
# Supported platforms: k8s (Kubernetes), ecs (AWS ECS), compose (Docker Compose), aca (Azure Container Apps)
#
# Usage examples:
#   ./tools/verify-image.sh k8s --namespace prod --deploy myapp --expected v1.2.3
#   ./tools/verify-image.sh k8s --namespace prod --selector app=myapp
#   ./tools/verify-image.sh ecs --cluster prod --service myapp --expected sha256:abc...
#   ./tools/verify-image.sh compose --project-name myapp --expected v1.2.3
#
# Output includes: declared image, running digest/ID, and match status vs expected.

red()   { printf "\033[31m%s\033[0m\n" "$*"; }
green() { printf "\033[32m%s\033[0m\n" "$*"; }
yellow(){ printf "\033[33m%s\033[0m\n" "$*"; }

usage() {
  cat <<EOF
verify-image.sh <platform> [options]

Platforms and options:
  k8s:
    --namespace <ns>             Kubernetes namespace
    --deploy <deployment>        Deployment name (optional if --selector used)
    --selector <labelSel>        Label selector, e.g. app=myapp
    --container <name>           Container name (if multiple)
    --expected <tag|sha>         Expected image tag or digest (optional)

  ecs:
    --cluster <name>             ECS cluster name
    --service <name>             ECS service name
    --expected <tag|sha>         Expected image tag or digest (optional)

  compose:
    --project-name <name>        Compose project name (or use --file)
    --file <compose.yml>         Compose file path (defaults: docker-compose.yml)
    --expected <tag|sha>         Expected image tag or digest (optional)

  aca (Azure Container Apps):
    --resource-group <rg>        Resource group name
    --app <name>                 Container App name
    --expected <tag>             Expected image tag (optional)

Examples:
  $0 k8s --namespace prod --deploy api --expected v1.2.3
  $0 k8s --namespace prod --selector app=api
  $0 ecs --cluster prod --service api --expected sha256:abc123
  $0 compose --project-name web --expected v1.2.3
EOF
}

if [[ $# -lt 1 ]]; then
  usage; exit 1
fi

PLATFORM="$1"; shift

EXPECTED=""

case "$PLATFORM" in
  k8s)
    NS=""; DEPLOY=""; SELECTOR=""; CONTAINER=""
    while [[ $# -gt 0 ]]; do
      case "$1" in
        --namespace) NS="$2"; shift 2;;
        --deploy) DEPLOY="$2"; shift 2;;
        --selector) SELECTOR="$2"; shift 2;;
        --container) CONTAINER="$2"; shift 2;;
        --expected) EXPECTED="$2"; shift 2;;
        -h|--help) usage; exit 0;;
        *) red "Unknown option: $1"; usage; exit 1;;
      esac
    done
    if ! command -v kubectl >/dev/null 2>&1; then
      red "kubectl not found in PATH"; exit 1
    fi
    if [[ -z "$NS" ]]; then red "--namespace required"; exit 1; fi
    if [[ -z "$DEPLOY" && -z "$SELECTOR" ]]; then
      red "Provide --deploy <name> or --selector <labelSel>"; exit 1
    fi
    
    yellow "Context: $(kubectl config current-context 2>/dev/null || echo unknown)"
    yellow "Namespace: $NS"

    if [[ -n "$DEPLOY" ]]; then
      IMG=$(kubectl -n "$NS" get deploy "$DEPLOY" -o jsonpath='{.spec.template.spec.containers[*].image}' 2>/dev/null || true)
      if [[ -z "$IMG" ]]; then red "Deployment not found: $DEPLOY"; exit 1; fi
      echo "Declared image(s): $IMG"
      PODS=$(kubectl -n "$NS" get pods -l app="$DEPLOY" -o name 2>/dev/null || true)
    else
      echo "Selector: $SELECTOR"
      # Show images for all matching deployments
      kubectl -n "$NS" get deploy -l "$SELECTOR" -o jsonpath='{range .items[*]}{.metadata.name}{" -> "}{.spec.template.spec.containers[*].image}{"\n"}{end}'
      PODS=$(kubectl -n "$NS" get pods -l "$SELECTOR" -o name 2>/dev/null || true)
    fi

    if [[ -z "$PODS" ]]; then yellow "No matching pods found (might be scaling or different labels)."; fi
    echo "Running containers and imageIDs:"
    kubectl -n "$NS" get pods ${SELECTOR:+-l "$SELECTOR"} ${DEPLOY:+-l app="$DEPLOY"} \
      -o jsonpath='{range .items[*]}{.metadata.name}{" -> "}{range .status.containerStatuses[*]}{.name}{": "}{.image}{" | "}{.imageID}{"\n"}{end}{end}' 2>/dev/null || true

    echo
    echo "Rollout history (if available):"
    if [[ -n "$DEPLOY" ]]; then
      kubectl -n "$NS" rollout history deploy/"$DEPLOY" || true
    else
      yellow "Skip rollout history (no single deployment specified)."
    fi

    if [[ -n "$EXPECTED" ]]; then
      echo
      echo "Compare against expected: $EXPECTED"
      if echo "$IMG" | grep -q "$EXPECTED"; then
        green "MATCH: Declared image contains expected tag/digest"
      else
        red "MISMATCH: Declared image does not contain expected"
      fi
    fi
    ;;

  ecs)
    CLUSTER=""; SERVICE=""
    while [[ $# -gt 0 ]]; do
      case "$1" in
        --cluster) CLUSTER="$2"; shift 2;;
        --service) SERVICE="$2"; shift 2;;
        --expected) EXPECTED="$2"; shift 2;;
        -h|--help) usage; exit 0;;
        *) red "Unknown option: $1"; usage; exit 1;;
      esac
    done
    if ! command -v aws >/dev/null 2>&1; then red "aws CLI not found"; exit 1; fi
    if ! command -v jq >/dev/null 2>&1; then red "jq is required for ECS output (brew install jq | apt-get install jq)"; exit 1; fi
    if [[ -z "$CLUSTER" || -z "$SERVICE" ]]; then red "--cluster and --service required"; exit 1; fi
    yellow "ECS Cluster: $CLUSTER | Service: $SERVICE"
    SVC_JSON=$(aws ecs describe-services --cluster "$CLUSTER" --services "$SERVICE")
    TD_ARN=$(echo "$SVC_JSON" | jq -r '.services[0].taskDefinition')
    echo "Task definition: $TD_ARN"
    TD_JSON=$(aws ecs describe-task-definition --task-definition "$TD_ARN")
    echo "Container images:"
    echo "$TD_JSON" | jq -r '.taskDefinition.containerDefinitions[] | "- " + .name + ": " + .image'
    echo
    echo "Currently running tasks imageIDs:"
    TASKS=$(aws ecs list-tasks --cluster "$CLUSTER" --service-name "$SERVICE" --desired-status RUNNING | jq -r '.taskArns[]?')
    if [[ -n "$TASKS" ]]; then
      aws ecs describe-tasks --cluster "$CLUSTER" --tasks $TASKS | jq -r '.tasks[] | .taskArn + " -> " + (.containers[] | .name + ": " + .image)'
    else
      yellow "No running tasks found"
    fi
    if [[ -n "$EXPECTED" ]]; then
      echo
      echo "Compare against expected: $EXPECTED"
      if echo "$TD_JSON" | grep -q "$EXPECTED"; then
        green "MATCH: Task definition image contains expected"
      else
        red "MISMATCH: Task definition image does not contain expected"
      fi
    fi
    ;;

  compose)
    PROJ=""; FILE=""
    while [[ $# -gt 0 ]]; do
      case "$1" in
        --project-name) PROJ="$2"; shift 2;;
        --file) FILE="$2"; shift 2;;
        --expected) EXPECTED="$2"; shift 2;;
        -h|--help) usage; exit 0;;
        *) red "Unknown option: $1"; usage; exit 1;;
      esac
    done
    if ! command -v docker >/dev/null 2>&1; then red "docker not found"; exit 1; fi
    ARGS=()
    [[ -n "$PROJ" ]] && ARGS+=(--project-name "$PROJ")
    [[ -n "$FILE" ]] && ARGS+=(--file "$FILE")
    echo "Compose images:"
    docker compose ${ARGS[@]} images || true
    echo
    echo "Running containers:"
    docker ps --format 'table {{.Names}}\t{{.Image}}\t{{.RunningFor}}' | sed '1!b; s/\t/\t/g'
    if [[ -n "$EXPECTED" ]]; then
      echo
      echo "Compare against expected: $EXPECTED"
      if docker compose ${ARGS[@]} images | grep -q "$EXPECTED"; then
        green "MATCH: Compose references expected"
      else
        red "MISMATCH: Compose does not reference expected"
      fi
    fi
    ;;

  aca)
    RG=""; APP=""
    while [[ $# -gt 0 ]]; do
      case "$1" in
        --resource-group) RG="$2"; shift 2;;
        --app) APP="$2"; shift 2;;
        --expected) EXPECTED="$2"; shift 2;;
        -h|--help) usage; exit 0;;
        *) red "Unknown option: $1"; usage; exit 1;;
      esac
    done
    if ! command -v az >/dev/null 2>&1; then red "Azure CLI (az) not found"; exit 1; fi
    if [[ -z "$RG" || -z "$APP" ]]; then red "--resource-group and --app required for aca"; exit 1; fi
    echo "Subscription: $(az account show --query name -o tsv 2>/dev/null || echo unknown)"
    echo "Resource Group: $RG | App: $APP"
    echo "Declared image:" 
    IMG=$(az containerapp show -g "$RG" -n "$APP" --query "properties.template.containers[0].image" -o tsv)
    echo "$IMG"
    echo
    echo "Revisions:" 
    az containerapp revision list -g "$RG" -n "$APP" --query "[].{name:name,active:properties.active,image:properties.template.containers[0].image,created:properties.createdTimeUtc}" -o table || true
    if [[ -n "$EXPECTED" ]]; then
      echo
      echo "Compare against expected: $EXPECTED"
      if echo "$IMG" | grep -q ":$EXPECTED$\|$EXPECTED"; then
        green "MATCH: Declared image contains expected tag"
      else
        red "MISMATCH: Declared image does not contain expected"
      fi
    fi
    ;;

  *)
    red "Unknown platform: $PLATFORM"; usage; exit 1;;
esac
