#!/usr/bin/env bash
set -euo pipefail

WP_URL="${WP_URL:-http://simpledental.local:8090}"
WP_TITLE="${WP_TITLE:-Simple Dental Dev}"
WP_ADMIN_USER="${WP_ADMIN_USER:-admin}"
WP_ADMIN_PASSWORD="${WP_ADMIN_PASSWORD:-admin123}"
WP_ADMIN_EMAIL="${WP_ADMIN_EMAIL:-admin@example.com}"

if ! docker compose run --rm wpcli wp core is-installed >/dev/null 2>&1; then
  docker compose run --rm wpcli wp core install \
    --url="$WP_URL" \
    --title="$WP_TITLE" \
    --admin_user="$WP_ADMIN_USER" \
    --admin_password="$WP_ADMIN_PASSWORD" \
    --admin_email="$WP_ADMIN_EMAIL"
fi

docker compose run --rm wpcli wp theme activate simple-dental-theme
