# Tech-Spec: Extend Countdown to 60 Days (Auto-Extend Preserved)

**Created:** 2025-12-25
**Status:** Completed

## Overview

### Problem Statement

The homepage countdown and site copy currently point to a fixed “January 2026” opening date. The client now wants the launch countdown to start at **60 days from today**, while keeping the existing 3-day grace period and auto-extend logic (push back 1 month on reset). All “opening in January” copy across the site should reflect the new dynamic date.

### Solution

Update the opening date logic to compute a **rolling 60-day target** from the current date (server time). Preserve the existing grace period and auto-extend (+1 month) behavior when the target date passes. Scan and update any copy that still references fixed “January 2026” text so it uses the centralized dynamic opening date string.

### Scope (In/Out)

**In Scope**
- Change opening date base logic from fixed date to “today + 60 days”
- Keep 3-day grace period and +1 month auto-extend behavior unchanged
- Ensure all opening date mentions resolve from the dynamic date function
- Confirm countdown uses the updated target date

**Out of Scope**
- WordPress admin settings UI
- New translation entries (existing dynamic strings already in place)
- Visual redesign of the countdown

## Context for Development

### Codebase Patterns

- Translation: use `__t('text')` for all user-facing strings
- JS: countdown uses localized data from PHP via `wp_localize_script()`
- Date logic: centralized in `simple_dental_get_opening_date()` in `simple-dental-theme/functions.php`

### Files to Reference

- `simple-dental-theme/functions.php` (opening date logic, meta description)
- `simple-dental-theme/assets/js/countdown.js` (uses localized timestamp)
- `simple-dental-theme/page-about.php` (dynamic opening date copy)
- `simple-dental-theme/page-contact.php` (dynamic opening date copy)
- `simple-dental-theme/footer.php` (dynamic opening date copy)
- `simple-dental-theme/translations/*.json` (verify no fixed “January 2026” references needed)

### Technical Decisions

- **Base Date Source:** `current_time('timestamp') + 60 days` (server time)
- **Grace Period:** 3 days (unchanged)
- **Auto-Extend:** +1 month when date passes + grace (unchanged)
- **Display:** `simple_dental_get_opening_date_display()` for all copy

## Implementation Plan

### Tasks

- [x] **Task 1: Update opening date base logic**
  - In `simple-dental-theme/functions.php`, remove fixed `SIMPLE_DENTAL_BASE_OPENING_DATE`
  - Compute `$base_date` as `current_time('timestamp') + (60 * DAY_IN_SECONDS)`
  - Keep the existing grace period loop and +1 month extension as-is

- [x] **Task 2: Verify date references**
  - Confirm all templates use `simple_dental_get_opening_date_display()`
  - Remove or replace any remaining hardcoded “January 2026” if found

- [x] **Task 3: Smoke check countdown**
  - `simple-dental-theme/assets/js/countdown.js` should remain unchanged since it reads the updated timestamp

### Acceptance Criteria

- [ ] **AC 1:** Given the site loads today, the opening date is 60 days from now (server time)
- [ ] **AC 2:** Given the countdown is visible, it counts down to the 60-day target
- [ ] **AC 3:** Given the opening date passes, the system waits 3 days (grace), then auto-extends by 1 month (repeat as needed)
- [ ] **AC 4:** Given any page mentions the opening date, it displays the dynamic date string (no “January 2026” hardcodes)

## Additional Context

### Dependencies

- None new; existing JS and PHP only

### Testing Strategy

- Visual: Load homepage; confirm countdown matches 60-day target
- Logic: Temporarily adjust system date (or set base to past date) to verify grace and auto-extend
- Content: Search for “January 2026” in theme files; ensure no user-visible hardcodes remain
