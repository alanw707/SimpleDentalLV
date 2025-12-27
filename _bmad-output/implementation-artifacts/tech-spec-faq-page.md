# Tech-Spec: FAQ Page

**Created:** 2025-12-26
**Status:** In Progress (Paused)

## Overview

### Problem Statement
Patients need a dedicated FAQ page that answers common questions in plain language. The site currently lacks a standalone Q&A page, and the content must be available in all supported locales (en, es, zh-TW, zh-CN).

### Solution
Create a new `/faq/` page with a custom template that renders the provided Q&A content using simple headings. Wrap all copy with the theme's `__t()` helper and add translations in the locale JSON files. Add the FAQ link to the primary navigation (desktop and mobile) via the fallback menu.

### Scope (In/Out)

**In Scope**
- New FAQ page at `/faq/` using a custom template in the theme.
- Hardcoded FAQ content with simple headings and paragraphs.
- Translation coverage for `es`, `zh-TW`, `zh-CN` via `translations/*.json`.
- Add FAQ link to navigation fallback for both desktop and mobile.
- Minimal styling to match existing page patterns.

**Out of Scope**
- New multilingual plugin or WP editor-based translations.
- New FAQ search, accordions, or advanced UI.
- Content changes outside the provided Q&A list.

## Context for Development

### Codebase Patterns
- Custom page templates live in `simple-dental-theme/` (e.g., `page-about.php`, `page-services.php`, `page-contact.php`).
- Default page layout is in `simple-dental-theme/page.php` with shared hero/strip/content sections.
- Translations use `__t()` and JSON in `simple-dental-theme/translations/`.
- Navigation fallback is hardcoded in `simple-dental-theme/header.php`.

### Files to Reference
- `simple-dental-theme/page.php` (default layout and structure).
- `simple-dental-theme/page-about.php` (custom template pattern and `__t()` usage).
- `simple-dental-theme/includes/translator.php` (translation system).
- `simple-dental-theme/header.php` (fallback menu).
- `simple-dental-theme/style.css` (page styles).
- `simple-dental-theme/translations/es.json`
- `simple-dental-theme/translations/zh-TW.json`
- `simple-dental-theme/translations/zh-CN.json`

### Technical Decisions
- Use a new custom template `page-faq.php` so all copy can be localized through `__t()` and JSON translations (no WP editor dependency).
- Name the WordPress page `FAQ` with slug `faq`; WordPress will automatically use `page-faq.php`.
- Keep layout consistent with other pages: hero header, optional image strip, then content.
- Add FAQ to the fallback menu to ensure it appears in both desktop and mobile navigation when no WP menu is set.

## Implementation Plan

### Tasks

- [x] Create `simple-dental-theme/page-faq.php` modeled after `page.php` and `page-about.php`:
  - Use a hero header with the title `Simple Dental: Honest Answers for Our Las Vegas Patients`.
  - Render FAQ content grouped by section headings (h2) and questions (h3) with paragraph answers.
  - Wrap all strings in `__t()` for localization.
- [x] Add FAQ link to the fallback menu in `simple-dental-theme/header.php`:
  - Add a list item linking to `simple_dental_with_lang(home_url('/faq/'))`.
  - Label with `__t('FAQ')` (or translated equivalent).
- [x] Update `simple-dental-theme/translations/es.json`, `zh-TW.json`, `zh-CN.json` with translations for:
  - `FAQ`
  - Page title and all section headings, questions, and answers.
- [x] Add minimal FAQ styling in `simple-dental-theme/style.css` to keep a simple, readable hierarchy (e.g., spacing between questions, section headings).

### Acceptance Criteria

- [x] Given the `/faq/` page, when loaded in English, then the page shows the provided FAQ content with section headings and questions in the correct order.
- [x] Given the language switcher or `?lang=es`, `?lang=zh-TW`, `?lang=zh-CN`, when visiting `/faq/`, then all FAQ content is translated (no English fallbacks).
- [x] Given no WordPress menu is set, when viewing desktop or mobile nav, then the FAQ link appears alongside existing items.
- [x] Given standard screen widths (mobile and desktop), the FAQ layout is readable and consistent with other site pages.

## Review Notes
- Adversarial review completed
- Findings: 10 total, 5 fixed, 5 skipped (intentional or uncertain)
- Resolution approach: auto-fix
- Tests: PHP lint on `simple-dental-theme/page-faq.php`
- FAQ layout updated with intro panel and full-width photo strip between sections.

## Progress Snapshot (Paused)

### Completed
- Reworked FAQ layout into left-side sticky panel + right-side accordion list.
- Added jump-to section anchors and mobile collapsible panel behavior.
- Restyled accordion cards with open/hover/focus states.
- Fixed mobile hamburger visibility and restored menu toggles.
- Updated internal menu links to open in same tab via JS.
- Adjusted hero header + panel styling to match site palette.

### In Progress / Needs Follow-up
- Verify jump-to links no longer open new browser after cache refresh.
- Confirm smooth scroll behavior for jump-to links feels instant.
- Check desktop jump-to list spacing and visual rhythm on live page.

### Files Touched
- `simple-dental-theme/page-faq.php`
- `simple-dental-theme/style.css`
- `simple-dental-theme/assets/js/navigation.js`
- `simple-dental-theme/functions.php`
- `simple-dental-theme/translations/es.json`
- `simple-dental-theme/translations/zh-TW.json`
- `simple-dental-theme/translations/zh-CN.json`

## Additional Context

### Dependencies
- Translation JSON files must be updated for all new strings.

### Testing Strategy
- Manual: load `/faq/` in EN/ES/ZH-TW/ZH-CN; verify all headings and answers translate.
- Manual: verify nav link exists on desktop and mobile; link preserves language parameter.
- Manual: check spacing and typography match other pages.

### Notes
- FAQ content (English) to render in template:

  **Title**
  - Simple Dental: Honest Answers for Our Las Vegas Patients

  **The "Simple & Honest" Philosophy**
  - Why is Simple Dental different from other Las Vegas dentists?
    - Most dental offices today are owned by large corporations where you see a different doctor every time and feel pressured to buy services you don’t need. Simple Dental is different. You will see the same experienced dentist every time. We offer a "No Pressure, No Upsell" guarantee. We only recommend what you truly need for a healthy smile.
  - Do I have to worry about hidden fees or "bait and switch" pricing?
    - No. Our name is Simple Dental because we keep pricing simple. We provide upfront, flat-rate pricing for our most common services, like our $199 New Patient Special and our $899 Same-Day Crowns. You will know exactly what you are paying before we ever start treatment.

  **Focus on Crowns & Restorative Care**
  - How can Simple Dental offer a permanent crown in just one visit?
    - We use advanced digital technology to design and mill your ceramic crown right here in our Las Vegas office. This means you don't have to wear a temporary crown for two weeks or come back for a second appointment. You walk in with a problem and walk out with a permanent, high-quality crown in about two hours.
  - How much does a dental crown cost at Simple Dental?
    - We offer high-quality, permanent ceramic crowns for $899. This is an all-inclusive, fair price designed for patients who want quality work without the "strip mall" markup.
  - What if I need a crown but I am worried about the cost?
    - We specialize in helping patients get the care they need without breaking the bank. Because we are an efficient, doctor-owned practice, we keep our overhead low and pass those savings to you. We also offer flexible financing through CareCredit to make your treatment affordable.

  **Insurance & Payments (For Cash & PPO Patients)**
  - Do you accept patients without dental insurance?
    - Yes! A huge portion of our patients are "cash patients" or self-pay. We have designed our pricing to be affordable for the everyday person who doesn't have a big corporate insurance plan. Our $199 New Patient Special is a great way to get started.
  - Which insurance plans does Simple Dental accept?
    - We work with most major PPO dental insurance plans. We are happy to verify your benefits for you before your appointment so there are no surprises. Please call us at (702) 302-4787 with your insurance information, and we’ll do the legwork for you.

  **Convenience & Location**
  - Where is your office located and is there parking?
    - Simple Dental is located at 204 S Jones Blvd, Las Vegas, NV 89107. We chose this location because it is easy to access with plenty of free parking right in back of the office. You won't have to deal with parking garages or long walks.
  - What languages does the staff speak?
    - To serve all of Las Vegas, we are a multilingual office. We speak English, Spanish (Español), and Chinese (繁體中文 and 简体中文).
  - How do I book an appointment?
    - Call us at (702) 302-4787 to book an appointment. Our team will find a time that works for you and answer any questions.
