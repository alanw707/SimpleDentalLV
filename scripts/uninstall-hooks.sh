#!/usr/bin/env bash
set -euo pipefail
HOOK=".git/hooks/pre-push"
if [ -f "$HOOK" ]; then
  rm -f "$HOOK"
  echo "Removed $HOOK"
else
  echo "No pre-push hook to remove"
fi
