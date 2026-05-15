# SimpleDentalLV SEO Plan

## Current state

- FAQ page already exists: `https://www.simpledentallv.com/faq/` using `simple-dental-theme/page-faq.php`.
- Rank Math cleanup is complete: production pages now emit one title, one description, one canonical, one robots tag, one OG/Twitter set, and one JSON-LD script.
- Current multilingual routing uses query parameters, e.g. `/services/?lang=es`.
- Current hreflang output points to query-param language URLs.
- Primary SEO goal: local dental search visibility for Las Vegas first, North Las Vegas second.
- Primary conversion action: phone calls first, online booking second.

## Decisions

1. Do not create a second general FAQ page.
   - Use the existing `/faq/` page as the global FAQ hub.
   - Add service-specific FAQ sections on service pages only when they match that page's search intent.
   - Add matching FAQ schema through Rank Math JSON-LD filters.

2. Move multilingual pages from `?lang=` URLs to direct locale routes.
   - Preferred route pattern:
     - English/default: `/services/`
     - Spanish: `/es/services/`
     - Simplified Chinese: `/zh-cn/services/`
     - Traditional Chinese: `/zh-tw/services/`
   - Keep old `?lang=` URLs working during transition.
   - 301 redirect old query-param URLs to direct locale URLs after validation.

3. Keep Rank Math as the SEO output owner.
   - Theme supplies SEO values to Rank Math via filters.
   - Theme should not duplicate title/meta/canonical/OG/Twitter/schema when Rank Math is active.

## Phase 1 — Locale routing foundation

**Status**: Implemented and deployed. Production verified for `/es/`, `/es/services/`, `/zh-cn/about/`, `/zh-tw/faq/`, and legacy `?lang=` redirects.

### Goal
Replace query-string language URLs with clean, crawlable locale paths while preserving current translation behavior.

### Tasks
- Add WordPress rewrite rules for locale prefixes:
  - `/es/`
  - `/zh-cn/`
  - `/zh-tw/`
- Add query vars for locale routing.
- Update language detection to read locale route before `?lang=` and cookie.
- Update `simple_dental_with_lang()` to generate locale paths instead of `?lang=`.
- Update language switcher links to use direct locale routes.
- Update canonical URL logic:
  - English canonical: base page URL.
  - Non-English canonical: locale-prefixed URL.
- Update hreflang:
  - `en`: base URL.
  - `es`: `/es/...`
  - `zh-Hans`: `/zh-cn/...`
  - `zh-Hant`: `/zh-tw/...`
  - `x-default`: base URL.
- Keep `?lang=` support temporarily for backward compatibility.
- Add 301 redirects from old query URLs to direct locale routes after smoke tests pass.

### Validation
- `/es/`, `/es/services/`, `/zh-cn/about/`, and `/zh-tw/faq/` return `200` in production.
- Old `?lang=` URLs redirect with `301` to direct locale routes.
- Canonicals and hreflang point to direct locale routes.
- Internal navigation preserves locale path.
- Language switcher changes route without breaking current page.
- Rank Math still outputs a single canonical and one metadata set.
- Verified locale metadata has one title, one description, one canonical, one JSON-LD script, and five hreflang alternates.

## Phase 2 — Sitemap and indexing cleanup

**Status**: Implemented and deployed for sitemap/indexing architecture. Manual Google Search Console submission remains.

### Goal
Make direct locale URLs discoverable and avoid indexing duplicate query-param URLs.

### Tasks
- Confirm Rank Math sitemap includes desired English URLs.
- Add or configure locale URL inclusion if Rank Math does not discover rewrite-only routes.
- Add `noindex` or 301 strategy for `?lang=` URLs after direct routes are stable.
- Submit updated sitemap in Google Search Console.
- Request indexing for homepage, services, about, contact, FAQ, and priority service pages.

### Validation
- `https://www.simpledentallv.com/locale-sitemap.xml` returns `200` and valid XML.
- Locale sitemap contains 15 direct locale URLs: 5 pages × 3 locales.
- Locale sitemap contains no `?lang=` URLs.
- `https://www.simpledentallv.com/sitemap_index.xml` includes `locale-sitemap.xml`.
- `https://www.simpledentallv.com/robots.txt` includes both Rank Math sitemap index and locale sitemap.
- All locale sitemap URLs return `200`.
- Search Console has no hreflang errors. _Manual check required after Google recrawls._

## Phase 3 — Existing FAQ cleanup

**Status**: Implemented and deployed. Production verified for English, Spanish, Simplified Chinese, and Traditional Chinese FAQ routes.

### Goal
Use `/faq/` as the canonical FAQ hub and reuse selected questions on service pages without duplication problems.

### Tasks
- Keep `/faq/` as the global FAQ page.
- Review FAQ content for local SEO and conversion:
  - Las Vegas dentist differentiation.
  - Same-day crowns.
  - Transparent pricing.
  - PPO/cash patients.
  - Scheduling by phone.
  - Location/parking.
- Add internal links from FAQ answers to relevant pages:
  - Services page.
  - Contact page.
  - Future Same-Day Crowns page.
- Ensure FAQ schema includes only visible FAQ questions on the page.
- Avoid adding generic FAQ sections that compete with service pages.

### Validation
- `/faq/`, `/es/faq/`, `/zh-cn/faq/`, and `/zh-tw/faq/` return `200`.
- Each FAQ route has 10 visible FAQ questions and 10 FAQ schema questions.
- FAQ schema matches visible FAQ content.
- FAQ page links support patient conversion and service discovery.
- FAQ page includes services links, contact links, phone links, and a phone-first final CTA.

## Phase 4 — Priority service pages

**Status**: Same-Day Crowns page implemented, localized, deployed, and production verified.

### Goal
Build service pages for high-intent searches without creating thin or duplicate content.

### Priority order
1. Same-Day Crowns Las Vegas
2. Teeth Cleaning Las Vegas
3. Root Canal Las Vegas

### Same-Day Crowns page scope
- URL: `/same-day-crowns-las-vegas/`
- H1: `Same-Day Crowns in Las Vegas`
- Primary CTA: `Call (702) 302-4787`
- Secondary CTA: online booking.
- Include:
  - What same-day crowns are.
  - Why one visit matters.
  - Digital scan and in-office milling workflow.
  - $899 transparent pricing, with caveat for buildup if needed.
  - Who may need a crown.
  - What to expect during the visit.
  - Local trust proof: one doctor, no pressure, Las Vegas office.
  - Short service-specific FAQ.
- Schema:
  - MedicalProcedure or Service node.
  - FAQPage node for visible page FAQ.
  - Link provider to Rank Math organization/dentist node.

### Validation
- `/same-day-crowns-las-vegas/`, `/es/same-day-crowns-las-vegas/`, `/zh-cn/same-day-crowns-las-vegas/`, and `/zh-tw/same-day-crowns-las-vegas/` return `200`.
- Each route has one title, one meta description, one canonical, one Rank Math JSON-LD script, Service schema, and 4 FAQ schema questions.
- Each route has phone-first CTAs, `/book-now/` online booking links, and visible `$899` pricing.
- Locale sitemap includes all four same-day crown URLs and no `?lang=` URLs.
- Homepage, services page, and FAQ page link to the same-day crowns page in all supported languages.

## Phase 5 — Local SEO operations

**Status**: Website-side local trust cleanup implemented and deployed. Ongoing GBP/Search Console operations remain.

### Goal
Connect website SEO with local search signals.

### Tasks
- Website local trust signals:
  - Verified Google Business Profile map embed is live on Contact page.
  - Google Maps share link is added to Contact page.
  - NAP is consistent on Contact page and Dentist schema.
  - Dentist schema includes updated geo coordinates and `hasMap`.
- Google Business Profile:
  - Verify categories.
  - Add services matching website service catalog.
  - Add photos.
  - Add appointment URL.
  - Add UTM parameters to website and booking URLs.
- Search Console:
  - Submit sitemap.
  - Inspect key URLs.
  - Monitor queries and coverage.
- Analytics:
  - Track phone clicks.
  - Track online booking clicks.
  - Track contact form submissions.

## Rollback plan

- Locale routing:
  - Disable rewrite rules and revert `simple_dental_with_lang()` to `?lang=` links.
  - Flush permalinks.
- SEO metadata:
  - Remove Rank Math filters from `functions.php`; Rank Math falls back to plugin settings.
- Service pages:
  - Unpublish page or remove internal links.

## Next implementation recommendation

Implement Phase 1 first: direct locale routing. It affects canonical/hreflang/sitemap architecture and should be stable before adding new service pages.
