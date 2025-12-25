# Tech-Spec: Local WordPress Docker Dev Environment

**Created:** 2025-12-20
**Status:** Completed

## Overview

### Problem Statement
We need a local, reproducible WordPress environment in Docker to preview theme changes before deploying to production. The setup must use the existing `simple-dental-theme/` in this repo and serve as a staging-like dev sandbox.

### Solution
Add a Docker Compose stack with WordPress (latest), MySQL, and wp-cli. Mount `simple-dental-theme/` into `wp-content/themes/`, persist database and uploads via named volumes, and set a local domain `simpledental.local` via hosts entry. Provide minimal, documented commands to install WordPress and activate the theme.

### Scope (In/Out)
**In**
- Local-only Docker Compose environment (Ubuntu + Docker Compose v2).
- WordPress latest + MySQL + wp-cli services.
- Bind mount theme from `simple-dental-theme/` into the container.
- Fresh install with wp-cli.
- Local docs for setup and usage.

**Out**
- Production or hosted staging deployment.
- CI/CD or automated remote deploy.
- Data migration or importing production content.

## Context for Development

### Codebase Patterns
- Theme resides in `simple-dental-theme/` and follows standard WordPress structure.
- No existing Docker/Compose setup is present.
- Deployment uses `deploy-robust.py` to FTP; credentials are local-only (`deployconfig.py`).

### Files to Reference
- `simple-dental-theme/README.md` (theme activation + required pages).
- `DEVELOPER_GUIDE.md` (local testing guidance).
- `AGENTS.md` (project structure and theme path).

### Technical Decisions
- **Docker Compose v2** with services: `wordpress`, `db` (MySQL 8), and `wpcli`.
- **WordPress image:** `wordpress:latest`.
- **DB image:** `mysql:8.0` (or latest 8.x tag).
- **Local domain:** `simpledental.local` mapped in `/etc/hosts`.
- **Port:** expose WordPress on `8080` to avoid requiring root.
- **Config:** use `WORDPRESS_CONFIG_EXTRA` to set `WP_HOME`, `WP_SITEURL`, and `WP_DEBUG`.
- **Volumes:** named volumes for WordPress core and uploads; bind mount the theme directory.

## Implementation Plan

### Tasks

- [x] Task 1: Add `docker-compose.yml` at repo root
  - Services: `db`, `wordpress`, `wpcli`
  - Volumes: `wp_data`, `wp_uploads`
  - Bind mount `./simple-dental-theme` to `/var/www/html/wp-content/themes/simple-dental-theme`
  - Environment: DB creds, site URL, debug config
  - Expose port `8080:80`
- [x] Task 2: Add `.env.example` (or `.env`) and ignore `.env`
  - Variables: DB name, user, password, root password
  - Document values for local use only
- [x] Task 3: Add local setup doc (new `docs/local-dev.md` or update `DEVELOPER_GUIDE.md`)
  - Hosts entry: `127.0.0.1 simpledental.local`
  - `docker compose up -d`
  - `docker compose run --rm wpcli wp core install ...`
  - `docker compose run --rm wpcli wp theme activate simple-dental-theme`
  - Optional: create required pages + menu with wp-cli commands
- [x] Task 4: Provide wp-cli helpers (optional)
  - Simple shell script like `tools/wp-init.sh` to install + activate theme
  - Keep it idempotent where possible

### Acceptance Criteria
- [ ] `docker compose up -d` brings up WordPress + MySQL + wp-cli without errors.
- [ ] Site loads at `http://simpledental.local:8090` after adding `/etc/hosts` entry.
- [ ] WP core is installed via wp-cli and admin login works.
- [ ] Theme `simple-dental-theme` is active and changes in local files reflect live.
- [ ] No secrets committed; `.env` excluded from git.

## Additional Context

### Dependencies
- Docker Engine + Docker Compose v2 on Ubuntu.
- Hosts file edit access (`/etc/hosts`).
- Internet access to pull images.

### Testing Strategy
- Bring stack up: `docker compose up -d`.
- Install WP: `docker compose run --rm wpcli wp core install --url=http://simpledental.local:8090 --title="Simple Dental Dev" --admin_user=admin --admin_password=admin123 --admin_email=admin@example.com`.
- Activate theme: `docker compose run --rm wpcli wp theme activate simple-dental-theme`.
- Verify key pages load and the theme renders (Home/About/Services/Contact).

### Notes
- Keep ports and domain consistent in docs and `WORDPRESS_CONFIG_EXTRA`.
- Use named volumes so DB and uploads persist between runs.
