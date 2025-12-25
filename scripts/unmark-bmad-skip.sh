#!/usr/bin/env bash
set -euo pipefail
dir="_bmad"
if [ ! -d "$dir" ]; then
  echo "Directory $dir not found"
  exit 1
fi
echo "Clearing skip-worktree for tracked files under $dir..."
git ls-files "$dir" | xargs -r git update-index --no-skip-worktree
echo "Done." 
