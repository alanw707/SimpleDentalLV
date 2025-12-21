#!/usr/bin/env bash
set -euo pipefail

if rg -n -F "background-image: url('http" simple-dental-theme/front-page.php simple-dental-theme/page-about.php simple-dental-theme/page-services.php simple-dental-theme/page-contact.php simple-dental-theme/page.php; then
  echo "Found external hero background URLs in templates." >&2
  exit 1
fi

echo "Hero backgrounds use local URLs."
