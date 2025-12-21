#!/usr/bin/env bash
set -euo pipefail

require_css() {
  local selector="$1"
  if ! rg -q "$selector" simple-dental-theme/style.css; then
    echo "Missing CSS for $selector in style.css" >&2
    exit 1
  fi
}

require_css "\\.office-preview"
require_css "\\.about-gallery"
require_css "\\.services-tech-gallery"
require_css "\\.contact-gallery"
require_css "\\.page-image-strip"

echo "Image layout CSS selectors verified."
