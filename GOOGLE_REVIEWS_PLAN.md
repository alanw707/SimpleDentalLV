# Google Reviews & Testimonials Plan

## Goal
Add social proof to Simple Dental with a polished Google Reviews experience:

1. Homepage review teaser section.
2. Dedicated `/testimonials/` page.
3. Static review data stored in theme code for full design control and no API dependency.

## Agreed Direction

- Data source: static/manual reviews copied from Google Business Profile.
- No Google Places API for now.
- No third-party review widget.
- Use real Google review content once provided.
- Match current Simple Dental visual system: warm beige, white cards, earth-tone accents, clean typography.

## Recommended Information Architecture

### Homepage Section

Placement: between **Services Preview** and **Contact Preview**.

Purpose: quick trust signal before users decide to call/book.

Content:

- Eyebrow: `Patient Reviews`
- Heading: `What Patients Are Saying About Simple Dental`
- Subcopy: short trust statement about honest care, transparent pricing, same dentist.
- Rating summary badge:
  - Google logo/icon text treatment
  - `5.0` or current rating
  - `★★★★★`
  - `Based on X Google reviews`
- 3 featured review cards.
- CTAs:
  - Primary: `Read All Reviews`
  - Secondary: `Call (702) 302-4787`

Layout:

- Desktop: left rating/intro column + right 3-card review grid or horizontal card row.
- Tablet: stacked intro + 2-column cards.
- Mobile: stacked cards with optional horizontal scroll snap.

### Testimonials Page

URL: `/testimonials/`

Purpose: full trust-building page for visitors comparing dentists.

Recommended page flow:

1. **Hero**
   - Heading: `Patient Reviews`
   - Subtitle: `Real feedback from patients who chose Simple Dental for honest, no-pressure care in Las Vegas.`
   - CTA row: `Call (702) 302-4787`, `Book Online`

2. **Google Rating Summary Block**
   - Large rating number.
   - Star row.
   - Review count.
   - Link to Google Business Profile.
   - Small disclaimer: `Reviews are copied from Google and may be shortened for display.` if excerpts are used.

3. **All Reviews Grid**
   - All available reviews, 13 current reviews if all screenshots/content are provided.
   - Cards include:
     - Reviewer initial avatar.
     - Reviewer first name/last initial or Google display name.
     - Date/relative time.
     - Star rating.
     - Review text.
     - Small `Google review` label.
   - Desktop: 3-column masonry-like grid.
   - Tablet: 2 columns.
   - Mobile: 1 column.

4. **CTA Closing Section**
   - Heading: `Looking for a Las Vegas dentist you can trust?`
   - Copy: `Call Simple Dental and we’ll help you choose the right appointment.`
   - Buttons: `Call (702) 302-4787`, `Book Online`, `View Services & Pricing`

## Visual Design

### Style Direction

- Background alternates:
  - Hero: existing page-header style with office image or warm beige gradient.
  - Review summary: `var(--warm-beige)` / `var(--off-white)` gradient.
  - Cards: `var(--white)` with `var(--border-gray)` border and `var(--shadow-light)`.
- Accent color:
  - Stars: warm gold `#F5B301`.
  - Google label: neutral text with small multicolor G mark or simple `Google` wordmark style.
  - Buttons: existing `.btn.btn-primary` and `.btn.btn-secondary`.
- Card radius: `1rem` to match same-day crown/service card polish.
- Avatar: circular initials with `var(--primary-brown)` background and white text.

### Typography

- Use existing heading scale.
- Review text: 1rem, line-height 1.65–1.75.
- Reviewer names: 600/700 weight.
- Metadata: small, muted `var(--text-light)`.

### Card Anatomy

Each review card:

```text
[Initial Avatar]  Reviewer Name
                  Google review · Date
★★★★★
“Review text goes here...”
```

Optional footer:

```text
Verified Google review
```

## Content Rules

- Do not fabricate reviews.
- Use only copied Google Business Profile reviews.
- Keep spelling/punctuation as written unless typo cleanup is requested.
- If trimming long reviews, mark as excerpted or include full review on testimonials page.
- Homepage should use the 3 strongest reviews, not necessarily the newest.

## Static Data Structure

Add helper in `functions.php`:

```php
function simple_dental_get_google_reviews() {
    return array(
        array(
            'name' => 'Reviewer Name',
            'initials' => 'RN',
            'rating' => 5,
            'date' => 'Month YYYY',
            'source' => 'Google',
            'featured' => true,
            'text' => 'Review text...',
        ),
    );
}
```

Benefits:

- One source of truth.
- Homepage and testimonials page reuse same data.
- Easy future update: add/remove reviews in one function.

## Implementation Files

Likely files:

- `simple-dental-theme/functions.php`
  - Add review data helper.
  - Add shortcode/helper renderers if useful.
  - Add SEO metadata for testimonials page.
  - Add schema if appropriate.
- `simple-dental-theme/front-page.php`
  - Insert homepage review teaser section between services and contact.
- `simple-dental-theme/page-testimonials.php`
  - New dedicated testimonials template.
- `simple-dental-theme/style.css`
  - Add review section/card styles.
- `simple-dental-theme/translations/*.json`
  - Translate UI labels/headings, not patient review text unless explicitly requested.

## SEO Notes

Testimonials page title:

`Patient Reviews | Simple Dental Las Vegas`

Meta description:

`Read patient reviews for Simple Dental in Las Vegas. Patients choose us for honest, no-pressure dental care, transparent pricing, and one experienced dentist.`

Schema:

- Keep conservative.
- Avoid fake aggregate rating unless exact Google rating/review count is confirmed.
- Review schema can be added only if review content and rating are genuine and displayed on-page.

## Accessibility

- Stars must have text alternative: `5 out of 5 stars`.
- Do not rely on star color alone.
- Google review links need clear labels.
- Cards should be semantic `<article>` blocks.
- CTA buttons need visible focus styles from existing button system.

## Current Review Inputs

Received from Google Business Profile screenshots on 2026-05-14:

- Current visible rating: `5.0`
- Current visible review count: `13`
- Google Business Profile URL used in site CTAs: `https://maps.app.goo.gl/aEKiZbNFp7SJFG11A`
- Reviews added to static data:
  - Alan Wang
  - Robert Wu
  - Vivian
  - J L
  - Anna Sun
  - Ashley Yu
  - One cropped-name Google reviewer

Remaining optional input:

- Add the remaining Google reviews if the full 13-review set should be displayed.
- Replace the cropped-name reviewer with the real display name if available.

## Recommended Build Order

1. Add review data helper with real copied reviews.
2. Build `/testimonials/` page template as the all-reviews archive.
3. Add homepage teaser section as the featured reviews preview.
4. Add CSS polish/responsive behavior.
5. Add testimonials SEO metadata and sitemap path.
6. Test PHP lint, JSON validity, mobile layout, and production URLs.

## Decision
Proceed with static Google reviews. Homepage should show only featured review previews; `/testimonials/` should act as the all-reviews archive without a separate featured section.
