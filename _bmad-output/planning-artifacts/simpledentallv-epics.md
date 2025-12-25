---
stepsCompleted: [1, 2, 3, 4]
inputDocuments:
  - simpledentallv-prd.md
  - simpledentallv-architecture.md
  - ux-design-specification.md
---

# SimpleDentalLV - Epic Breakdown

## Overview

This document provides the complete epic and story breakdown for SimpleDentalLV, decomposing the requirements from the PRD, UX Design, and Architecture into implementable stories.

## Requirements Inventory

### Functional Requirements

- FR1: The site shall display a clear homepage hero with primary CTA ("Book Appointment") and secondary CTA ("Call Now").
- FR2: The site shall provide a services overview page with categories (e.g., General, Cosmetic, Emergency) and drill-down detail pages.
- FR3: Each service detail page shall include benefits, typical process, and FAQs or insurance notes where applicable.
- FR4: The site shall support an appointment request form with required fields (name, phone, email, preferred times, service).
- FR5: The appointment request form shall include CAPTCHA or equivalent spam protection and send email notifications to staff.
- FR6: The site shall include a click-to-call phone link visible on mobile across all pages.
- FR7: The site shall include location, hours, and an embedded map on the Contact page.
- FR8: The site shall display provider/team bios with photos and credentials.
- FR9: The site shall display patient reviews/testimonials and/or review platform links.
- FR10: The site shall include a "New Patients" section with downloadable or online forms and visit prep instructions.
- FR11: The site shall include a financing/insurance section with accepted plans or guidance.
- FR12: The site shall include a promotions/specials section (optional, manageable via CMS).
- FR13: The site shall include a language toggle for English and Spanish content.
- FR14: The site shall include a blog or resources section for patient education (optional but CMS-ready).
- FR15: The site shall include structured data (Schema.org) for Dentist/LocalBusiness, services, and reviews where allowed.
- FR16: The site shall include analytics instrumentation (GA4 events for CTA clicks and form submissions).
- FR17: The site shall provide a global navigation and footer with key links (services, contact, reviews, privacy).
- FR18: The site shall provide an accessible error/success state for form submissions.
- FR19: The site shall allow staff to update key content (services, hours, CTA links) via WordPress admin.

### NonFunctional Requirements

- NFR1: Performance: LCP <= 2.5s on mobile for homepage and primary service pages.
- NFR2: Accessibility: WCAG 2.1 AA for contrast, keyboard navigation, and alt text.
- NFR3: SEO: Indexable pages with proper metadata, semantic headings, and sitemap.
- NFR4: Security: HTTPS, input validation, sanitization, and output escaping.
- NFR5: Reliability: Form delivery success rate >= 99% with clear error handling.
- NFR6: Privacy/Compliance: No PHI storage; include privacy policy and HIPAA guidance as needed.
- NFR7: Responsiveness: Works across mobile, tablet, and desktop.
- NFR8: Localization: English and Spanish content are equivalent in meaning.

### Additional Requirements

- Preserve existing theme structure, typography, and navigation patterns.
- Avoid new interaction patterns beyond current theme conventions.
- Use WordPress templates, theme functions, and enqueued JS/CSS.
- Appointment requests are emailed to staff; do not store PHI in WordPress.
- Use responsive images and avoid layout shift for imagery-heavy sections.
- Track CTA clicks and form submissions via GA4 events.
- Use RankMath for metadata, sitemap, and schema; avoid duplicate schema output.
- Support language toggle and translation helper integration.

### FR Coverage Map

FR1: Epic 1 - Core navigation and CTAs
FR2: Epic 2 - Services discovery
FR3: Epic 2 - Service detail experience
FR4: Epic 3 - Appointment request form
FR5: Epic 3 - Form spam protection and notifications
FR6: Epic 1 - Mobile click-to-call
FR7: Epic 3 - Contact page and map
FR8: Epic 4 - Team bios
FR9: Epic 4 - Reviews/testimonials
FR10: Epic 4 - New patient content
FR11: Epic 4 - Insurance and financing guidance
FR12: Epic 4 - Promotions/specials
FR13: Epic 7 - Localization
FR14: Epic 5 - Blog/resources
FR15: Epic 5 - SEO and schema
FR16: Epic 6 - Analytics instrumentation
FR17: Epic 1 - Global navigation/footer
FR18: Epic 3 - Form success and error states
FR19: Epic 1 - CMS controls for key content

## Epic List

### Epic 1: Core Navigation and CTAs
Visitors can quickly navigate the site and take primary actions without friction.
**FRs covered:** FR1, FR6, FR17, FR19

### Epic 2: Services Discovery and Detail Pages
Visitors can understand services and navigate to detailed information.
**FRs covered:** FR2, FR3

### Epic 3: Appointment and Contact
Visitors can request appointments, contact the clinic, and receive clear feedback.
**FRs covered:** FR4, FR5, FR7, FR18

### Epic 4: Trust, Team, and New Patient Content
Visitors build trust and find information needed to choose the clinic.
**FRs covered:** FR8, FR9, FR10, FR11, FR12

### Epic 5: SEO and Resources
Visitors can discover the clinic via search and access educational content.
**FRs covered:** FR14, FR15

### Epic 6: Analytics and Measurement
Clinic staff can measure conversions and CTA performance.
**FRs covered:** FR16

### Epic 7: Localization
Spanish-speaking visitors can navigate and convert with equivalent content.
**FRs covered:** FR13

## Epic 1: Core Navigation and CTAs

Deliver consistent navigation and primary CTAs aligned with the existing theme.

### Story 1.1: Global Navigation and Footer Links

As a site visitor,
I want consistent navigation and footer links,
So that I can reach key pages quickly.

**Acceptance Criteria:**

**Given** the site header and footer are rendered
**When** a visitor views any page
**Then** links to Services, Contact, Reviews, and Privacy are visible and functional
**And** navigation is usable on mobile and desktop breakpoints

### Story 1.2: Homepage Hero CTAs

As a new patient,
I want clear "Book Appointment" and "Call Now" CTAs in the hero,
So that I can take action immediately.

**Acceptance Criteria:**

**Given** the homepage is loaded
**When** a visitor views the hero section
**Then** primary and secondary CTAs are visible without scrolling on common mobile widths
**And** the CTAs link to the configured booking and call destinations

### Story 1.3: Mobile Click-to-Call Visibility

As a mobile visitor,
I want a persistent click-to-call option,
So that I can contact the clinic without hunting.

**Acceptance Criteria:**

**Given** a mobile viewport width
**When** the visitor scrolls any page
**Then** a click-to-call link remains visible and tappable
**And** the link uses a valid tel: URI

### Story 1.4: CMS Control for CTA Destinations

As a clinic admin,
I want to update CTA links and phone number in the CMS,
So that content changes do not require code edits.

**Acceptance Criteria:**

**Given** an admin user is logged in
**When** they update CTA destinations and phone number in theme settings
**Then** the changes are reflected on the homepage and header
**And** invalid URLs are rejected or sanitized

## Epic 2: Services Discovery and Detail Pages

Provide clear service categorization and detail pages that match the PRD.

### Story 2.1: Services Overview Page

As a new patient,
I want to scan service categories and select a service,
So that I can find care that fits my needs.

**Acceptance Criteria:**

**Given** the Services page is published
**When** a visitor views the page
**Then** services are grouped by category with clear titles and descriptions
**And** each service links to a detail page

### Story 2.2: Service Detail Template

As a prospective patient,
I want service detail pages with benefits, process, and FAQs,
So that I understand what to expect.

**Acceptance Criteria:**

**Given** a service detail page is loaded
**When** a visitor scrolls the page
**Then** the page includes sections for benefits, typical process, and FAQs
**And** headings are semantic and accessible

## Epic 3: Appointment and Contact

Enable appointment requests and reliable contact flows without storing PHI.

### Story 3.1: Appointment Request Form

As a prospective patient,
I want to submit an appointment request,
So that the clinic can contact me to confirm.

**Acceptance Criteria:**

**Given** the appointment request form is displayed
**When** a visitor submits required fields (name, phone, email, preferred times, service)
**Then** the form validates required fields and sanitizes input
**And** PHI is not stored in WordPress

### Story 3.2: Spam Protection and Notifications

As a clinic staff member,
I want spam protection and reliable email notifications,
So that valid requests are delivered and spam is reduced.

**Acceptance Criteria:**

**Given** the appointment request form is submitted
**When** CAPTCHA or equivalent validation succeeds
**Then** an email notification is sent to the clinic inbox
**And** failed CAPTCHA attempts are rejected with a user-friendly message

### Story 3.3: Accessible Form Feedback

As a visitor,
I want clear success or error feedback after submission,
So that I know what happened.

**Acceptance Criteria:**

**Given** a form submission response is returned
**When** the submission succeeds or fails
**Then** a success or error message is displayed inline
**And** the message is announced to assistive technologies

### Story 3.4: Contact Page with Map and Hours

As a visitor,
I want to find the clinic location and hours,
So that I can plan a visit.

**Acceptance Criteria:**

**Given** the Contact page is loaded
**When** a visitor views the page
**Then** the address, hours, and phone number are visible
**And** an embedded map is present and functional

## Epic 4: Trust, Team, and New Patient Content

Provide credibility and preparedness content to support conversion.

### Story 4.1: Team Bios and Credentials

As a visitor,
I want to see provider bios and credentials,
So that I can trust the clinic.

**Acceptance Criteria:**

**Given** the Team section is displayed
**When** a visitor views provider profiles
**Then** each provider has a photo, name, and credentials
**And** the layout is responsive without overlap

### Story 4.2: Reviews and Testimonials

As a new patient,
I want to read reviews or testimonials,
So that I can assess patient satisfaction.

**Acceptance Criteria:**

**Given** the Reviews section is displayed
**When** a visitor scrolls to it
**Then** testimonials or review links are visible
**And** external review links open in a new tab

### Story 4.3: New Patient Preparation

As a new patient,
I want to know what to bring and how to prepare,
So that my first visit is smooth.

**Acceptance Criteria:**

**Given** the New Patients page is available
**When** a visitor views the page
**Then** preparation steps and forms are listed clearly
**And** downloadable forms open or download successfully

### Story 4.4: Financing and Insurance Guidance

As a prospective patient,
I want to understand insurance and financing options,
So that I can plan costs.

**Acceptance Criteria:**

**Given** the Financing/Insurance section is published
**When** a visitor views the content
**Then** accepted insurance guidance is listed
**And** financing options are described without medical claims

### Story 4.5: Promotions and Specials Module

As a visitor,
I want to see current promotions,
So that I can decide if there is an offer that fits me.

**Acceptance Criteria:**

**Given** promotions are configured in the CMS
**When** a visitor views the Promotions section
**Then** active offers are displayed with title and details
**And** expired offers are not shown

## Epic 5: SEO and Resources

Improve discoverability and provide educational content.

### Story 5.1: LocalBusiness and Service Schema

As a search user,
I want clear structured data on the site,
So that I can find accurate clinic information.

**Acceptance Criteria:**

**Given** a public page is rendered
**When** the page source is inspected
**Then** RankMath outputs JSON-LD for LocalBusiness/Dentist
**And** service pages include service-related schema where applicable
**And** duplicate schema output is not present in the theme

### Story 5.2: Blog and Resources Index

As a patient,
I want access to educational resources,
So that I can learn about dental care.

**Acceptance Criteria:**

**Given** the Resources page is published
**When** a visitor views the page
**Then** recent posts are listed with titles and summaries
**And** content is editable via WordPress posts

## Epic 6: Analytics and Measurement

Provide conversion measurement for clinic staff.

### Story 6.1: CTA and Form Event Tracking

As a clinic owner,
I want to track CTA clicks and form submissions,
So that I can measure conversion performance.

**Acceptance Criteria:**

**Given** analytics is configured
**When** a user clicks Book or Call CTAs or submits a form
**Then** GA4 events are fired with names `cta_book`, `cta_call`, `form_submit`, and `language_toggle`
**And** events include the page path and language context
**And** events are verified in GA4 DebugView prior to release

## Epic 7: Localization

Ensure Spanish-speaking visitors have equivalent experiences.

### Story 7.1: Language Toggle

As a bilingual visitor,
I want a language toggle in the header,
So that I can switch to Spanish easily.

**Acceptance Criteria:**

**Given** the site header is displayed
**When** the visitor uses the language toggle
**Then** the page switches between English and Spanish
**And** the toggle remains visible on mobile and desktop

### Story 7.2: Spanish Content Parity

As a Spanish-speaking patient,
I want the key pages in Spanish,
So that I can complete the same actions.

**Acceptance Criteria:**

**Given** the Spanish version of the site is active
**When** the visitor views Home, Services, Contact, New Patients, and Financing
**Then** the content is available in Spanish with equivalent CTAs
**And** the booking/contact flows are accessible in Spanish
