Helper scripts for managing local-only `_bmad` behavior.

Scripts
- `mark-bmad-skip.sh`: Mark tracked `_bmad` files with `skip-worktree` so local edits are ignored.
- `unmark-bmad-skip.sh`: Clear the `skip-worktree` flags.
- `install-hooks.sh`: Install a pre-push hook that blocks pushes from the `local-bmad` branch.
- `uninstall-hooks.sh`: Remove the pre-push hook.

Usage
Run scripts from the repo root:
```
./scripts/install-hooks.sh
./scripts/mark-bmad-skip.sh
# ... run your workflows
./scripts/unmark-bmad-skip.sh
./scripts/uninstall-hooks.sh
```

Notes
- These scripts operate on tracked files. If `_bmad` is ignored by `.gitignore`, use `git add -f _bmad` to add it to a local branch.
- Hooks are local; distribute `scripts/install-hooks.sh` to teammates if they want the same protection.
