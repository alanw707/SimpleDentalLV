#!/usr/bin/env bash
set -euo pipefail
HOOK_DIR=".git/hooks"
mkdir -p "$HOOK_DIR"
cat > "$HOOK_DIR/pre-push" <<'HOOK'
#!/bin/sh
branch=$(git rev-parse --abbrev-ref HEAD)
if [ "$branch" = "local-bmad" ]; then
  echo "Push blocked: local-bmad branch is local-only to avoid pushing _bmad."
  exit 1
fi
exit 0
HOOK
chmod +x "$HOOK_DIR/pre-push"
echo "Installed pre-push hook to block pushes from local-bmad"
