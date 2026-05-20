# SimpleDentalLV Website

SimpleDentalLV website presents a Las Vegas dental practice to prospective patients and supports local search discovery and appointment/contact conversion.

## Language

**Local Dental Search Visibility**:
The website's ability to appear for Las Vegas-area dental searches from prospective patients.
_Avoid_: generic SEO, traffic growth

**Homepage Search Intent**:
General local dentist intent for prospective patients searching for a dentist in Las Vegas.
_Avoid_: all services, broad dental education

**Geographic Scope**:
The search market the website intentionally targets: primarily Las Vegas, secondarily North Las Vegas.
_Avoid_: Jones Blvd as a target market, generic Nevada targeting

**Phone-First CTA**:
A call-to-action hierarchy that presents calling the practice as the primary action before booking online or contact forms.
_Avoid_: book-first CTA, generic lead capture

**Patient Conversion**:
A prospective patient contacting the practice, with phone calls prioritized before contact form submissions.
_Avoid_: generic lead, traffic

**Mentioned Topic SEO**:
SEO metadata should reflect important topics that are visibly mentioned on a page, without implying the practice offers a service that the page does not clearly offer.
_Avoid_: hidden keyword targeting, unsupported service claims

**Priority Service Page**:
A service-specific page selected for early SEO work because it has strong local patient search intent.
_Avoid_: every service at once, thin service page

**Service-Specific Page**:
A page focused on one dental service or service category that answers patient search intent for that service.
_Avoid_: landing page, content page

**Smile Preview Flow**:
The cosmetic preview interaction where a prospective patient uploads a teeth-visible selfie, selects cosmetic goals, gives consent, and receives a non-clinical visual concept.
_Avoid_: treatment planning, diagnosis, guaranteed result

**Smile Concept Preview**:
The non-clinical generated visual output from the **Smile Preview Flow**; it can support conversation before a consultation but does not represent dental advice or a promised outcome.
_Avoid_: treatment plan, final result, diagnosis

**Smile Improvement Goal**:
A prospective patient's self-selected cosmetic concern or desired change before receiving a **Smile Concept Preview**; canonical options are whiter teeth, straighter smile, close gaps, fix chips or worn edges, improve tooth shape, and I’m not sure yet.
_Avoid_: treatment recommendation, diagnosis, treatment goal, veneer selection, crown selection, implant selection

**Google Review Linkout**:
A trust element that sends prospective patients to the live Simple Dental Google Business Profile for current review count and review content.
_Avoid_: review sync, scraped reviews, stale review count

## Relationships

- **Local Dental Search Visibility** is the primary SEO outcome for the website.
- **Homepage Search Intent** supports **Local Dental Search Visibility** for general Las Vegas dentist searches.
- **Geographic Scope** defines Las Vegas as primary and North Las Vegas as secondary.
- **Patient Conversion** is the primary business result of **Local Dental Search Visibility**.
- **Phone-First CTA** supports **Patient Conversion**, especially on mobile and local-intent sections.
- **Mentioned Topic SEO** applies to visible page content, including doctor training and service mentions.
- **Priority Service Pages** are Same-Day Crowns, Teeth Cleaning, and Root Canal; Dental Implants are unresolved pending service confirmation.
- **Service-Specific Pages** support **Local Dental Search Visibility** by matching specific patient searches.
- **Smile Preview Flow** can support **Patient Conversion**, but its **Smile Concept Preview** must remain clearly non-clinical.
- **Smile Improvement Goals** are collected before the **Smile Concept Preview** as structured options with optional free text.
- A **Google Review Linkout** supports **Patient Conversion** without requiring local review count accuracy.

## Example dialogue

> **Dev:** "Should SEO pages optimize for reading time or patient action?"
> **Domain expert:** "Patient action — phone calls first, contact forms second."

## Flagged ambiguities

- "Improve SEO" resolved to mean **Local Dental Search Visibility** first, with **Service-Specific Pages** as a secondary opportunity.
- "Jones Blvd" is the practice address in code, but not an SEO target market; avoid "Johnes Blvd" as a misspelled target term.
- Current code often presents Book Online before phone calls; resolved target is **Phone-First CTA** while retaining Book Online as secondary.
- "Emergency Dentistry" should not be targeted unless the practice starts accepting urgent same-day pain or broken-tooth cases.
- Code mentions implant training on the About page and translation labels, but the service list does not include implant services; use **Mentioned Topic SEO** for the About-page training mention, but do not imply implant services are offered until clarified.
- Implant SEO wording should be limited to Dr. Chang's advanced implant training unless implant services are added to the service catalog.
- "Sync Google Reviews" resolved away from full automation for now because Google Business Profile owner access is unavailable; use **Google Review Linkout** until access exists.
