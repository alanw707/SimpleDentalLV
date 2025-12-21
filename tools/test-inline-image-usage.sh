#!/usr/bin/env bash
set -euo pipefail

require_in_file() {
  local needle="$1"
  local file="$2"
  if ! rg -q "$needle" "$file"; then
    echo "Missing $needle in $file" >&2
    exit 1
  fi
}

require_in_file "front-preview-lobby-seating.jpg" "simple-dental-theme/front-page.php"
require_in_file "front-preview-dentist-wall.jpg" "simple-dental-theme/front-page.php"

require_in_file "Charles-Portrait-1.jpg" "simple-dental-theme/page-about.php"
require_in_file "about-gallery-dentist-wall.jpg" "simple-dental-theme/page-about.php"
require_in_file "about-gallery-front-desk.jpg" "simple-dental-theme/page-about.php"

require_in_file "services-tech-lab-milling.jpg" "simple-dental-theme/page-services.php"
require_in_file "services-tech-operatory.jpg" "simple-dental-theme/page-services.php"

require_in_file "contact-office-hallway.jpg" "simple-dental-theme/page-contact.php"
require_in_file "contact-operatory-side.jpg" "simple-dental-theme/page-contact.php"

require_in_file "page-feature-sterilization.jpg" "simple-dental-theme/page.php"

echo "Inline image references verified."
