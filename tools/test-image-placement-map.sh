#!/usr/bin/env bash
set -euo pipefail

map_file="tools/image-placement-map.md"
if [[ ! -f "$map_file" ]]; then
  echo "Missing placement map: $map_file" >&2
  exit 1
fi

asset_count="$(rg --files simple-dental-theme/assets/images | wc -l | tr -d '[:space:]')"
row_count="$(rg -n '^\\|' "$map_file" | tail -n +3 | wc -l | tr -d '[:space:]')"

if [[ "$row_count" -ne "$asset_count" ]]; then
  echo "Placement map rows ($row_count) do not match asset count ($asset_count)." >&2
  exit 1
fi

echo "Placement map rows match asset count."
