#!/usr/bin/env bash
set -euo pipefail
dir="_bmad"
if [ ! -d "$dir" ]; then
  echo "Directory $dir not found"
  exit 1
fi
echo "Marking tracked files under $dir as skip-worktree..."
git ls-files "$dir" | xargs -r git update-index --skip-worktree
echo "Done. Use scripts/unmark-bmad-skip.sh to clear the flags."
