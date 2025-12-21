#!/usr/bin/env bash
set -euo pipefail

if ! rg -n "Charles-Portrait-1.jpg" simple-dental-theme/page-about.php; then
  echo "Missing Charles-Portrait-1.jpg reference in About page." >&2
  exit 1
fi

if rg -n "about-page-bio.png" simple-dental-theme/page-about.php; then
  echo "Found about-page-bio.png reference in About page." >&2
  exit 1
fi

echo "About page portrait reference is updated."
