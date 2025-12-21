#!/usr/bin/env bash
set -euo pipefail

inventory_file="tools/image-inventory.txt"
if [[ ! -f "$inventory_file" ]]; then
  echo "Missing inventory file: $inventory_file" >&2
  exit 1
fi

tmp_expected="$(mktemp)"
tmp_actual="$(mktemp)"

rg --files simple-dental-theme/assets/images | sort > "$tmp_expected"
grep -v '^[[:space:]]*$' "$inventory_file" | sort > "$tmp_actual"

if ! diff -u "$tmp_expected" "$tmp_actual"; then
  echo "Inventory list does not match assets/images contents." >&2
  rm -f "$tmp_expected" "$tmp_actual"
  exit 1
fi

rm -f "$tmp_expected" "$tmp_actual"
echo "Inventory matches assets/images contents."
