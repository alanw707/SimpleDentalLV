---
stepsCompleted: []
inputDocuments:
  - simpledentallv-prd.md
  - ux-design-specification.md
workflowType: 'architecture'
lastStep: 0
project_name: 'SimpleDentalLV'
user_name: 'Alanw'
date: '2025-12-22'
---

# Architecture Decision Document

## 1. Overview

This architecture defines how the SimpleDentalLV WordPress theme will deliver the PRD requirements while preserving the existing theme and UX constraints. The system is a marketing and conversion website, not a patient portal. No PHI should be stored in WordPress.

## 2. System Context

- **Client:** Web browsers on mobile, tablet, and desktop.
- **CMS:** WordPress with the `simple-dental-theme`.
- **Primary pages:** Home, Services, Service Detail, About, New Patients, Financing/Insurance, Promotions, Blog/Resources, Contact.
- **External services (as needed):**
  - Google Maps (location)
  - Reviews platform (Google reviews link)
  - Analytics (GA4)
  - CAPTCHA service

## 3. Constraints

- Preserve existing theme structure and navigation.
- Avoid storing PHI or sensitive medical data.
- Maintain bilingual English/Spanish content support.
- Keep performance within Core Web Vitals targets.

## 4. Architecture Decisions

### 4.1 Presentation Layer

- Implement features within the existing WordPress theme using PHP templates, theme functions, and enqueued JS/CSS.
- Prefer WordPress core patterns (page templates, blocks, shortcodes) over custom plugins unless required.

### 4.2 Content Model

- Use WordPress Pages for top-level content (Home, Contact, About, New Patients, Financing, Promotions).
- Services use a Services landing page with child pages for each service detail (no custom post type in current phase).

### 4.3 Forms and Booking

- Reuse the existing AJAX contact form pattern with CAPTCHA for appointment requests.
- Appointment request data should be emailed to staff; do not store PHI in the database.
- Scheduling integrations are deferred; CTAs route to the request form or call actions.

### 4.4 Localization

- Use the existing translation helper (`includes/translator.php`) and `translations/` assets (custom multilingual is already in place).

### 4.5 SEO and Schema

- Ensure each page has unique title/description and structured headings.
- Use RankMath for metadata, XML sitemap, and JSON-LD schema.
- Avoid duplicate schema output in theme templates when RankMath is active.

### 4.6 Analytics

- Track CTA clicks (Book, Call), form submissions, and language toggle via GA4 events.
- Standardize event names: `cta_book`, `cta_call`, `form_submit`, `language_toggle`.
- Implement with data attributes and a small JS tracker module in `assets/js/`.
- Validate events using GA4 DebugView in staging before launch.

### 4.7 Performance

- Use responsive images with `srcset` and native lazy loading for non-hero media.
- Minimize JS and defer non-critical scripts.
- Optimize hero imagery to protect LCP.

### 4.8 Security and Compliance

- Sanitize and validate all form inputs.
- Escape all outputs using WordPress `esc_*` functions.
- Use nonces for form submissions.
- Enforce HTTPS and include a privacy policy with HIPAA guidance where applicable.

## 5. Data Flows

- **Appointment Request:** User submits form -> server validates -> email sent to staff -> success/failed feedback.
- **Contact:** User submits contact form -> email sent -> confirmation shown.
- **Scheduling:** Deferred; "Book" CTAs point to request form or call.

## 6. Non-Functional Requirements Mapping

- **Performance:** LCP <= 2.5s on key pages; avoid layout shift.
- **Accessibility:** WCAG 2.1 AA for contrast, focus, and form labels.
- **Reliability:** Form delivery success rate >= 99% with clear error handling.

## 7. Open Decisions

- None.

## 8. Risks

- UX scope conflicts with PRD conversion requirements if CTAs are de-emphasized.
- Performance regressions from heavy imagery or embedded third-party widgets.
