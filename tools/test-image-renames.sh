#!/usr/bin/env bash
set -euo pipefail

map_file="tools/image-placement-map.md"
if [[ ! -f "$map_file" ]]; then
  echo "Missing placement map: $map_file" >&2
  exit 1
fi

if rg --files -g 'IMG_*.jpg' simple-dental-theme/assets/images | rg -q 'IMG_'; then
  echo "Found IMG_* files that should be renamed." >&2
  exit 1
fi

missing=0
while IFS= read -r name; do
  if [[ -z "$name" || "$name" == "(unchanged)" ]]; then
    continue
  fi
  if [[ ! -f "simple-dental-theme/assets/images/$name" ]]; then
    echo "Missing renamed file: $name" >&2
    missing=1
  fi
done < <(awk -F'|' 'NR>2 {gsub(/^ +| +$/, "", $3); print $3}' "$map_file")

if [[ "$missing" -ne 0 ]]; then
  exit 1
fi

echo "Renamed images verified."
