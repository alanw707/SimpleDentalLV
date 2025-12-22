# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Lint PHP files
find simple-dental-theme -name "*.php" -print0 | xargs -0 -n1 php -l

# Deploy entire theme to production
python3 deploy-robust.py

# Deploy single file (path relative to simple-dental-theme/)
python3 deploy-robust.py assets/js/navigation.js

# Local development with Docker
cp .env.example .env  # configure DB credentials
docker compose up -d
# WordPress available at http://simpledental.local:8090
# Theme files are mounted for live editing
```

## Architecture

**WordPress custom theme** for a dental practice - no build process, no Node.js.

### Core Files
- `simple-dental-theme/functions.php` - All theme functionality (~800 lines): shortcodes, AJAX handlers, customizer settings, service data
- `simple-dental-theme/style.css` - Single stylesheet with CSS custom properties for theming
- `simple-dental-theme/includes/translator.php` - Multilingual support (EN, ES, ZH-CN, ZH-TW)

### Template Structure
- `front-page.php` - Homepage
- `page-about.php`, `page-services.php`, `page-contact.php` - Custom page templates
- `header.php`, `footer.php` - Site structure

### Key Systems
- **Contact Form**: AJAX-based (`wp_ajax_simple_dental_contact`) with reCAPTCHA integration
- **Services**: Data in `get_dental_services_data()`, displayed via `[featured_services]` and `[services_by_category]` shortcodes
- **Deployment**: FTP via `deploy-robust.py`, credentials in `deployconfig.py` (git-ignored)

## Coding Standards

- **PHP**: 4-space indent, single quotes, prefix functions with `simple_dental_`, use WordPress `esc_*` and `sanitize_*` APIs
- **JS**: camelCase, place in `assets/js/`, enqueue via `functions.php`
- **CSS**: BEM-like class names, co-locate in `style.css` or `assets/css/`
- **Templates**: Use WordPress patterns (`front-page.php`, `page-*.php`), guard with `ABSPATH` check

## Commit Style

Short imperative with optional category prefix:
- `MOBILE UX FIX: Center logo`
- `CRITICAL FIX: Restore menu JS`
- `SITE UPDATE: Sync assets`

## Testing

- Manual flows: mobile navigation, language switcher, contact form (AJAX + CAPTCHA), services display
- PHP sanity: run lint command, load pages with `WP_DEBUG` enabled
- Cross-browser checks for header/footer and homepage hero

## Documentation

- `DEVELOPER_GUIDE.md` - Theme customization patterns, hooks, extending functionality
- `TECHNICAL_REFERENCE.md` - Shortcode reference, PHP functions, CSS architecture, AJAX endpoints
- `FTP_DEPLOYMENT.md` - Deployment setup and troubleshooting
