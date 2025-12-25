---
stepsCompleted: []
inputDocuments:
  - ux-design-specification.md
documentCounts:
  briefs: 0
  research: 1
  brainstorming: 0
  projectDocs: 1
workflowType: 'prd'
lastStep: 0
---

# Product Requirements Document - SimpleDentalLV

**Author:** Alanw (drafted by assistant)
**Date:** 2025-12-22
**Version:** 0.1 (draft)

## 1. Summary

SimpleDentalLV is a dental clinic website that converts local search traffic into booked appointments and qualified leads. The site must communicate trust, clearly present services, make it easy to request or book appointments, and support both new and existing patients on mobile and desktop.

## 2. Goals

- Increase appointment requests and phone calls from local search visitors.
- Provide clear service information and clinician credibility.
- Reduce front-desk time by moving common tasks (forms, FAQs, contact) online.
- Improve local SEO visibility and conversion performance.

## 3. Target Users

- New patients searching for a local dentist (family, cosmetic, emergency).
- Existing patients needing follow-up appointments or contact information.
- Caregivers booking for children or seniors.
- Mobile-first users who prefer quick calls or online booking.

## 4. Success Metrics

- +X% increase in appointment requests or bookings within 90 days of launch.
- +X% increase in click-to-call actions from mobile.
- +X% improvement in organic traffic for core service keywords.
- Contact form completion rate >= X% and spam rate <= X%.
- Page performance: Core Web Vitals passing for homepage and top service pages.

## 5. Assumptions

- Clinic serves the Las Vegas metro area (for Local SEO and maps).
- Primary language is English with a Spanish language toggle.
- Booking uses a request form and phone calls in the current phase (no real-time scheduling, no in-site PHI storage).

## 6. In Scope

- WordPress theme updates for homepage, service pages, and conversion components.
- Service listing with detail pages and pricing guidance where appropriate.
- Appointment request flow and/or external booking integration.
- Contact form with CAPTCHA, click-to-call, and location map.
- Patient trust content: reviews, credentials, and affiliations.
- SEO and schema for LocalBusiness/Dentist and services.

## 7. Out of Scope

- Full patient portal or EMR integration.
- Payments processing or insurance claim handling.
- Live chat or chatbot (unless added later).
- Real-time scheduling integrations (deferred).
- Multi-location scheduling administration.

## 8. User Journeys

1. New patient: land on homepage -> view services -> see reviews -> click "Book" -> complete request form or call.
2. Emergency visit: search "emergency dentist" -> see emergency service page -> click-to-call or book same-day.
3. Existing patient: find contact page -> call office or send message -> receive confirmation.

## 9. Functional Requirements

FR1: The site shall display a clear homepage hero with primary CTA ("Book Appointment") and secondary CTA ("Call Now").

FR2: The site shall provide a services overview page with categories (e.g., General, Cosmetic, Emergency) and drill-down detail pages.

FR3: Each service detail page shall include benefits, typical process, and FAQs or insurance notes where applicable.

FR4: The site shall support an appointment request form with required fields (name, phone, email, preferred times, service).

FR5: The appointment request form shall include CAPTCHA or equivalent spam protection and send email notifications to staff.

FR6: The site shall include a click-to-call phone link visible on mobile across all pages.

FR7: The site shall include location, hours, and an embedded map on the Contact page.

FR8: The site shall display provider/team bios with photos and credentials.

FR9: The site shall display patient reviews/testimonials and/or review platform links.

FR10: The site shall include a "New Patients" section with downloadable or online forms and visit prep instructions.

FR11: The site shall include a financing/insurance section with accepted plans or guidance.

FR12: The site shall include a promotions/specials section (optional, manageable via CMS).

FR13: The site shall include a language toggle for English and Spanish content.

FR14: The site shall include a blog or resources section for patient education (optional but CMS-ready).

FR15: The site shall include structured data (Schema.org) for Dentist/LocalBusiness, services, and reviews where allowed.

FR16: The site shall include analytics instrumentation (GA4 events for CTA clicks and form submissions).

FR17: The site shall provide a global navigation and footer with key links (services, contact, reviews, privacy).

FR18: The site shall provide an accessible error/success state for form submissions.

FR19: The site shall allow staff to update key content (services, hours, CTA links) via WordPress admin.


## 10. Non-Functional Requirements

NFR1: Performance: Largest Contentful Paint <= 2.5s on mobile for homepage and primary service pages.

NFR2: Accessibility: Conform to WCAG 2.1 AA, including contrast, keyboard navigation, and alt text.

NFR3: SEO: Pages should be indexable with proper metadata, semantic headings, and XML sitemap.

NFR4: Security: All forms must use HTTPS; no PHI stored in WordPress; sanitize and escape all inputs.

NFR5: Reliability: Contact form delivery success rate >= 99% with retry/notification on failure.

NFR6: Privacy/Compliance: Include HIPAA-compliant language as needed and a clear privacy policy.

NFR7: Responsiveness: Site must render correctly on mobile, tablet, and desktop breakpoints.

NFR8: Localization: English and Spanish content must be equivalent in meaning.

## 11. Content Requirements

- Professional clinic photography and staff images.
- Clear value proposition and differentiators (e.g., gentle care, advanced tech).
- Office hours, emergency availability, and directions.
- Insurance and financing explanations.

## 12. Analytics & Tracking

- Track CTA clicks: Book, Call, Contact Submit.
- Track form submit success/failure.
- Track top service page engagement and exit rates.

## 13. Risks & Open Questions

- Confirm bilingual content scope and translation ownership.
- Verify any legal/compliance requirements for marketing claims.

## 14. References

- UX spec: `_bmad-output/ux-design-specification.md`
- Industry research: common dental website patterns (booking, services, reviews, SEO).
