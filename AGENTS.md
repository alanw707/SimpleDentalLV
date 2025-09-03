# Repository Guidelines

## Project Structure & Modules
- `simple-dental-theme/`: WordPress theme (PHP templates, styles, scripts).
  - `assets/css|js|images/`: static assets.
  - `includes/`: helpers (e.g., `translator.php`).
  - `translations/`: locale assets.
- `tools/`: utility scripts (e.g., image verification across platforms).
- `deploy-robust.py`: FTP deployer for the theme.
- `deployconfig.py`: local-only credentials (ignored by git).
- Documentation: `DEVELOPER_GUIDE.md`, `USER_GUIDE.md`, `TECHNICAL_REFERENCE.md`.

## Build, Test, and Dev Commands
- Run locally: install WordPress; place/symlink `simple-dental-theme/` into `wp-content/themes/`, then activate in wp-admin.
- Lint PHP: `find simple-dental-theme -name "*.php" -print0 | xargs -0 -n1 php -l`.
- Deploy theme (all files): `python3 deploy-robust.py`.
- Deploy single file: `python3 deploy-robust.py assets/js/navigation.js` (path relative to `simple-dental-theme/`).
- Verify images (ops util): `./tools/verify-image.sh k8s --namespace prod --deploy web --expected v1.2.3` (see `tools/verify-image.sh --help`).

## Coding Style & Naming
- PHP: 4-space indent, single quotes for strings where possible, WordPress esc_* and sanitize_* APIs, functions prefixed `simple_dental_`.
- JS: camelCase, keep DOM operations minimal; place in `assets/js/` and enqueue via `functions.php`.
- CSS: co-locate in `style.css` or `assets/css/`; prefer BEM-like class names for components.
- Templates: use WordPress patterns (`front-page.php`, `page-*.php`), avoid direct exit unless guarding `ABSPATH`.

## Testing Guidelines
- Manual flows: mobile navigation, language switcher, contact form (AJAX + CAPTCHA), services display.
- PHP sanity: run the lint command and load pages with `WP_DEBUG` enabled.
- Cross-browser spot checks for header/footer and homepage hero.

## Commit & Pull Request Guidelines
- Commit style: short, imperative line with a category in caps when helpful (seen in history): e.g., `MOBILE UX FIX: Center logo`, `CRITICAL FIX: Restore menu JS`.
- Group related changes; avoid mixed refactors + features.
- PRs must include: summary, linked issue, before/after screenshots for UI, test steps (including mobile), and deployment notes (risk/rollback).

## Security & Configuration
- Never commit credentials. `deployconfig.py` is git-ignored; copy from `deploy-config.example.py` and edit locally.
- Review diff for accidental secrets; rotate keys immediately if exposed.
