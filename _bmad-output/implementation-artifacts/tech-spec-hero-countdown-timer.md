# Tech-Spec: Hero Countdown Timer with Auto-Extend

**Created:** 2025-12-25
**Status:** Ready for Development
**Branch:** `feature/hero-countdown-timer`

---

## Overview

### Problem Statement

The dental practice opening date ("January 2026") is hardcoded in 15+ locations across the theme. Due to ongoing compliance and licensing delays, this date has changed multiple times. The client needs:

1. A visual countdown timer on the homepage to build anticipation
2. Automatic date extension logic to avoid manual updates when delays occur
3. A single source of truth for the opening date across all pages

### Solution

Implement a modern, minimal countdown timer component in the hero section that:
- Displays days, hours, minutes, and seconds until opening
- Auto-extends the target date by 1 month if the date passes (with 3-day grace period)
- Centralizes all date references through a single PHP function
- Supports all 4 languages (EN, ES, ZH-CN, ZH-TW)

### Scope

| In Scope | Out of Scope |
|----------|--------------|
| Hero countdown timer component | WordPress admin settings UI |
| Auto-extend PHP logic (3-day grace, +1 month) | Email notifications on extension |
| Centralized date function | Complex animation effects |
| Update all 15+ hardcoded date references | Database storage for date |
| Translation-ready labels | Third-party countdown plugins |
| Mobile-responsive design (2x2 grid) | Backend date management dashboard |
| "Opening Very Soon!" fallback during grace period | |

---

## Context for Development

### Codebase Patterns

| Pattern | Implementation |
|---------|----------------|
| **Translation** | Use `__t('text')` function for all user-facing strings |
| **JS Architecture** | jQuery IIFE pattern, enqueue via `wp_enqueue_script()` |
| **CSS** | Use existing CSS custom properties (`:root` vars) |
| **Script Data** | Use `wp_localize_script()` to pass PHP data to JS |
| **File Naming** | `assets/js/countdown.js` for new JS file |

### Files to Reference

| File | Purpose |
|------|---------|
| `simple-dental-theme/functions.php` | Add date functions, script localization |
| `simple-dental-theme/front-page.php` | Insert countdown component (lines 14-25 hero section) |
| `simple-dental-theme/style.css` | Add countdown styles (after line 1210 `.hero-buttons`) |
| `simple-dental-theme/page-contact.php` | Replace 7 hardcoded dates |
| `simple-dental-theme/page-about.php` | Replace 4 hardcoded dates |
| `simple-dental-theme/footer.php` | Replace 1 hardcoded date (line 45) |
| `simple-dental-theme/includes/translator.php` | Reference for translation pattern |
| `simple-dental-theme/translations/*.json` | Add new translation strings |

### Technical Decisions

| Decision | Choice | Rationale |
|----------|--------|-----------|
| **Date Storage** | PHP constant `SIMPLE_DENTAL_BASE_OPENING_DATE` | Simple, version controlled, no DB queries |
| **Auto-Extend Trigger** | Server-side PHP on page render | Consistent across all date references |
| **Grace Period** | 3 days | Short enough to extend quickly, long enough to update if actually opening |
| **Extension Amount** | Exactly +1 month | Predictable, easy to communicate |
| **Countdown Update** | Client-side JS, 1-second interval | Smooth real-time updates |
| **Fallback Display** | "Opening Very Soon!" during grace period | Handles edge case gracefully |
| **Mobile Layout** | 2x2 grid for 4 units | Prevents cramped horizontal layout |

---

## Implementation Plan

### Tasks

- [ ] **Task 1: Create centralized date functions in functions.php**
  - Add constant: `SIMPLE_DENTAL_BASE_OPENING_DATE = '2026-01-15'`
  - Add function: `simple_dental_get_opening_date()` - returns timestamp with auto-extend logic
  - Add function: `simple_dental_get_opening_date_display()` - returns formatted date string for current locale
  - Add function: `simple_dental_is_in_grace_period()` - returns boolean for fallback display
  - Auto-extend logic: if `current_time > base_date + 3 days`, extend by 1 month (repeat as needed)

- [ ] **Task 2: Add countdown data localization to script enqueue**
  - In `simple_dental_scripts()`, add `wp_localize_script()` after countdown.js enqueue
  - Pass: `targetTimestamp`, `labels` (Days/Hours/Minutes/Seconds translated), `gracePeriodMessage`

- [ ] **Task 3: Create countdown.js**
  - Create new file: `assets/js/countdown.js`
  - Implement countdown logic with `setInterval(updateCountdown, 1000)`
  - Handle zero/negative countdown: show grace period message
  - Update DOM elements: `.countdown-days`, `.countdown-hours`, `.countdown-mins`, `.countdown-secs`

- [ ] **Task 4: Add countdown component to front-page.php**
  - Insert between subtitle (line 18) and hero-buttons (line 19)
  - Structure:
    ```html
    <div class="countdown-wrapper">
      <p class="countdown-label">🎉 <?php echo __t('Opening Soon'); ?></p>
      <div class="countdown-timer" data-grace-message="<?php echo esc_attr(__t('Opening Very Soon!')); ?>">
        <div class="countdown-unit"><span class="countdown-days">--</span><span class="countdown-unit-label"><?php echo __t('Days'); ?></span></div>
        <div class="countdown-unit"><span class="countdown-hours">--</span><span class="countdown-unit-label"><?php echo __t('Hours'); ?></span></div>
        <div class="countdown-unit"><span class="countdown-mins">--</span><span class="countdown-unit-label"><?php echo __t('Mins'); ?></span></div>
        <div class="countdown-unit"><span class="countdown-secs">--</span><span class="countdown-unit-label"><?php echo __t('Secs'); ?></span></div>
      </div>
    </div>
    ```

- [ ] **Task 5: Add countdown styles to style.css**
  - Add styles after `.hero-buttons` section (~line 1210)
  - Use existing CSS variables: `--white`, `--shadow-light`, `--primary-brown`
  - Desktop: 4 boxes in a row, centered
  - Mobile (max-width 480px): 2x2 grid
  - Box styling: white background, rounded corners (8px), subtle shadow
  - Number styling: large (2.5rem), bold (700), dark text
  - Label styling: small (0.75rem), uppercase, muted color

- [ ] **Task 6: Replace hardcoded dates in page-contact.php**
  - Line 63: `<?php echo __t('January 2026'); ?>` → `<?php echo simple_dental_get_opening_date_display(); ?>`
  - Line 100: `<?php echo __t('🎉 Coming January 2026!'); ?>` → `<?php echo '🎉 ' . sprintf(__t('Coming %s!'), simple_dental_get_opening_date_display()); ?>`
  - Line 101, 115, 120, 135: Similar replacements (7 total)

- [ ] **Task 7: Replace hardcoded dates in page-about.php**
  - Line 98: `<?php echo __t('🎉 Opening January 2026!'); ?>` → dynamic version
  - Line 107, 133: Similar replacements (4 total)

- [ ] **Task 8: Replace hardcoded date in footer.php**
  - Line 45: `<?php echo __t('Opening January 2026 | Las Vegas, Nevada'); ?>` → `<?php echo sprintf(__t('Opening %s | Las Vegas, Nevada'), simple_dental_get_opening_date_display()); ?>`

- [ ] **Task 9: Update SEO meta description in functions.php**
  - Line 101: Update meta description to use dynamic date

- [ ] **Task 10: Add translation strings to all language files**
  - `translations/es.json`: Add "Opening Soon", "Days", "Hours", "Mins", "Secs", "Opening Very Soon!", "Coming %s!"
  - `translations/zh-CN.json`: Same strings in Simplified Chinese
  - `translations/zh-TW.json`: Same strings in Traditional Chinese

- [ ] **Task 11: Test in Docker environment**
  - Verify countdown displays correctly on homepage
  - Test auto-extend by temporarily setting past date
  - Test grace period fallback message
  - Test all 4 languages
  - Test mobile responsive layout
  - Verify all pages show correct dynamic date

### Acceptance Criteria

- [ ] **AC 1:** Given I am on the homepage, When I view the hero section, Then I see a countdown timer showing days, hours, minutes, and seconds until opening date
- [ ] **AC 2:** Given the countdown timer is displayed, When 1 second passes, Then the seconds value decrements by 1 (live update)
- [ ] **AC 3:** Given the base opening date has passed by more than 3 days, When the page loads, Then the target date is automatically extended by 1 month
- [ ] **AC 4:** Given the opening date has passed but within 3-day grace period, When I view the countdown, Then I see "Opening Very Soon!" instead of 00:00:00:00
- [ ] **AC 5:** Given I am viewing the contact page, When I look for the opening date, Then I see the dynamically calculated date (not hardcoded "January 2026")
- [ ] **AC 6:** Given I switch to Spanish/Chinese language, When I view the countdown timer, Then all labels are properly translated
- [ ] **AC 7:** Given I am on a mobile device (< 480px), When I view the countdown timer, Then the 4 units display in a 2x2 grid layout
- [ ] **AC 8:** Given I am on desktop, When I view the countdown timer, Then the 4 units display in a single row, centered below the subtitle

---

## Additional Context

### Dependencies

- jQuery (already loaded by theme)
- No external libraries required
- No build process changes needed

### Testing Strategy

| Test Type | Scope |
|-----------|-------|
| **Visual** | Verify countdown appearance matches design on desktop/mobile |
| **Functional** | Confirm countdown decrements correctly |
| **Auto-extend** | Set past date, verify extension logic works |
| **Grace period** | Set date within 3-day window, verify fallback message |
| **Translation** | Switch languages, verify all labels translate |
| **Integration** | Check all pages (contact, about, footer) show dynamic date |
| **Cross-browser** | Test Chrome, Firefox, Safari, Edge |

### Notes

1. **Initial Target Date:** Set to January 15, 2026 (mid-month provides buffer)
2. **To change base date:** Update `SIMPLE_DENTAL_BASE_OPENING_DATE` constant in functions.php
3. **Translation keys:** Use short labels ("Mins", "Secs") to fit in small boxes
4. **Performance:** Countdown JS is lightweight (~2KB), no external dependencies
5. **SEO:** Dynamic date in meta description will update automatically

### Design Reference

```
┌─────────────────────────────────────────────────────────────┐
│                                                             │
│        Straightforward Dentistry from one                   │
│              Experienced Doctor.                            │
│                                                             │
│   No pressure. No upsell. Just honest, transparent          │
│   dental care with modern technology and fair pricing.      │
│                                                             │
│              🎉 Opening Soon                                │
│                                                             │
│    ┌────────┐  ┌────────┐  ┌────────┐  ┌────────┐         │
│    │   42   │  │   08   │  │   35   │  │   47   │         │
│    │  Days  │  │ Hours  │  │  Mins  │  │  Secs  │         │
│    └────────┘  └────────┘  └────────┘  └────────┘         │
│                                                             │
│     [ View Our Services ]    [ Call (702) 302-4787 ]       │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### Git Workflow

```bash
# Create feature branch
git checkout -b feature/hero-countdown-timer

# After implementation, test in Docker
docker compose up -d
# Visit http://simpledental.local:8090

# When ready, deploy to staging/production
python3 deploy-robust.py
```

---

**End of Tech Spec**
