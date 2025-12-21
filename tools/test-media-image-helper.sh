#!/usr/bin/env bash
set -euo pipefail

if ! rg -q "function simple_dental_media_image" simple-dental-theme/functions.php; then
  echo "Missing simple_dental_media_image helper in functions.php" >&2
  exit 1
fi

for file in simple-dental-theme/front-page.php simple-dental-theme/page-about.php simple-dental-theme/page-services.php simple-dental-theme/page-contact.php simple-dental-theme/page.php; do
  if ! rg -q "simple_dental_media_image\\(" "$file"; then
    echo "Missing simple_dental_media_image usage in $file" >&2
    exit 1
  fi
done

echo "Media image helper and usage verified."
