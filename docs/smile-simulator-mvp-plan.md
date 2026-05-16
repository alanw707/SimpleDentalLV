# Simple Dental LV — Smile Simulator MVP Plan

Created: 2026-05-16
Owner: Alan / 168 Media Group
Project: Simple Dental LV lead-generation cosmetic dentistry tool

## One-line concept
A website-based “AI Smile Preview” that lets a visitor upload a selfie, choose a cosmetic goal, receive a realistic-but-clearly-non-clinical smile concept image, and convert into a booked cosmetic consultation.

## Strategic position
Build this as a lead-generation and trust-building tool, not a medical diagnostic or treatment-planning product.

Recommended positioning:
- “See a concept preview of your future smile.”
- “AI visual mockup for inspiration only.”
- “Final treatment recommendations require an in-person dental exam.”

Avoid:
- “Accurate simulation”
- “Treatment outcome prediction”
- “Dental diagnosis”
- Any guarantee that the preview represents the actual achievable result

## Primary goal
Generate cosmetic dentistry leads for Simple Dental LV by giving users an emotionally compelling before/after preview and pushing them into a consultation booking flow.

## Target users
- Local Las Vegas / North Las Vegas patients considering whitening, veneers, aligners, bonding, or smile makeover work
- People who are curious but hesitant to book a consult
- Visitors from paid social, Google local search, SEO pages, and dental landing pages

## MVP user flow
1. Landing page
   - Hook: “See Your Future Smile in 60 Seconds”
   - Short explanation: upload selfie → choose smile goal → get AI concept preview → book consult
   - Clear disclaimer near upload

2. Upload step
   - User uploads a front-facing smile selfie
   - Basic guidance:
     - Face camera directly
     - Good lighting
     - Teeth visible
     - No sunglasses / heavy filters
   - Consent checkbox required before upload

3. Goal selection
   User chooses one or more:
   - Whiter smile
   - Straighter smile
   - Close small gaps
   - Veneer-style smile makeover
   - Fix chipped/uneven teeth concept
   - Natural subtle improvement
   - Hollywood bright smile

4. AI generation
   - System sends image + selected goal to image model
   - Output: one edited “after” concept image
   - Optional later: generate 2–3 style variants

5. Results page
   - Show original and AI preview side-by-side
   - Disclaimer directly below result
   - CTA:
     - “Book a Cosmetic Smile Consultation”
     - “Text / Call Simple Dental LV”
   - Lead capture form if not captured before generation

6. Lead capture
   Required minimum:
   - Name
   - Email
   - Phone
   - Preferred contact method
   - Cosmetic interest
   Optional:
   - Best time to contact
   - Notes / concerns
   - Consent to SMS/email follow-up

7. Internal notification
   - Send lead to email/CRM/Notion/Google Sheet
   - Include original image, generated image, selected goal, contact info, timestamp, source/UTM

8. Follow-up
   - Auto-confirmation to user:
     - “Your preview is ready. A real smile plan starts with an exam.”
   - Staff gets suggested follow-up script

## Core MVP features
- Responsive landing page embedded on SimpleDentalLV site or standalone subpage
- Image upload with file type/size validation
- Consent + disclaimer gating before upload
- Goal selector
- AI image-editing pipeline
- Before/after result viewer
- Lead form
- Admin/storage for submitted leads
- Email notification to office/admin
- UTM capture for campaign attribution
- Basic abuse/rate limiting
- Privacy copy and data retention policy

## Nice-to-have v2 features
- Multiple preview styles: natural, bright, veneer, subtle
- “Compare 3 smiles” gallery
- Appointment scheduler integration
- SMS follow-up automation
- CRM integration
- Admin dashboard to review leads
- Retargeting pixel events
- Spanish landing page
- Before/after gallery from consenting real patients
- A/B test: lead form before generation vs after generation

## Recommended tech architecture
### Fastest MVP path
- Frontend: simple WordPress page or lightweight React/Next.js app embedded/linked from SimpleDentalLV
- Backend: Node/Express or Next.js API route
- AI: image edit/generation provider capable of reference-image edits
- Storage: S3-compatible bucket or local/private storage initially
- Lead sink: Google Sheet + email notification, then CRM later
- Analytics: GA4 + conversion events

### Suggested data flow
1. Browser uploads image to backend
2. Backend validates file and stores original privately
3. Backend calls image model with safe transformation prompt
4. Backend stores generated image privately
5. User sees result via signed/temporary URL or proxied asset
6. Lead submitted and sent to admin sink
7. System logs UTM/source/session metadata

## AI prompt direction
System objective: preserve user identity and face structure while only improving visible teeth/smile aesthetics according to selected cosmetic goal.

Base edit prompt:
“Create a realistic cosmetic dentistry concept preview from this selfie. Keep the person’s face, skin, lips, expression, lighting, camera angle, and identity consistent. Only adjust the visible teeth and smile aesthetics. Make the smile look natural, clean, healthy, and professionally improved. Do not change facial structure, age, gender presentation, hairstyle, skin tone, background, or overall appearance. This is a non-clinical visual concept, not a guaranteed dental outcome.”

Goal modifiers:
- Whitening: “Make teeth moderately whiter while keeping a natural shade; avoid over-bright artificial white.”
- Straightening: “Make visible teeth appear more evenly aligned while preserving natural proportions.”
- Gaps: “Subtly reduce small visible gaps for a natural smile concept.”
- Veneers: “Create a polished veneer-style smile with even shape and color, still realistic and not cartoonish.”
- Natural subtle: “Make only subtle improvements; prioritize realism over dramatic change.”
- Hollywood bright: “Create a brighter, more symmetrical smile, but keep it plausible and high-end.”

## Compliance / risk guardrails
This tool must include explicit disclaimers:
- AI-generated visual concept only
- Not dental advice
- Not a diagnosis
- Not a treatment plan
- Results are not guaranteed
- Actual options require exam/x-rays/dentist evaluation

Consent checkbox copy:
“I understand this AI smile preview is for illustrative purposes only and is not dental advice, diagnosis, treatment planning, or a guarantee of results. I consent to Simple Dental LV using my uploaded photo to generate my preview and contact me about cosmetic dentistry services.”

Privacy/data notes:
- Treat uploaded face images as sensitive personal data
- Do not use images for public marketing without separate written consent
- Set a retention policy, e.g. delete non-converted uploads after 30 days and leads after normal business retention rules
- Avoid PHI collection in the MVP beyond contact info and cosmetic interest
- If users add medical details, handle cautiously and avoid exposing in public/marketing tooling

## Landing page copy draft
Headline:
See Your Future Smile in 60 Seconds

Subheadline:
Upload a selfie and get an AI-generated smile concept for whitening, veneers, straightening, or a full cosmetic smile makeover.

CTA:
Create My Smile Preview

Trust copy:
Your preview is a visual concept only. A real treatment plan starts with an exam by a licensed dentist.

Section bullets:
- Preview cosmetic smile ideas before booking
- Explore whitening, veneers, alignment, and gap-fix concepts
- Private upload, quick result, no obligation
- Book a consult if you like what you see

Result CTA:
Like the direction? Let’s see what’s actually possible for your smile.
Book a Cosmetic Consultation at Simple Dental LV.

## Staff follow-up script
“Hi [Name], this is Simple Dental LV. We saw you tried our AI Smile Preview for [goal]. The image is just a concept, but Dr. [Name/team] can evaluate what’s actually possible and walk you through options like whitening, veneers, bonding, or aligners. Would you like to schedule a cosmetic consultation?”

## Analytics events
Track:
- smile_simulator_page_view
- smile_upload_started
- smile_upload_completed
- smile_goal_selected
- smile_generation_started
- smile_generation_completed
- smile_generation_failed
- lead_form_started
- lead_form_submitted
- booking_cta_clicked
- phone_cta_clicked

Campaign UTMs:
- utm_source
- utm_medium
- utm_campaign
- utm_content
- utm_term

## Success metrics
MVP validation targets:
- Landing page upload-start rate: 10%+
- Upload-to-result completion: 70%+
- Result-to-lead submit: 15–30%+
- Lead-to-consult booked: 10–25%+
- Cost per qualified cosmetic lead: compare against Google Ads dental cosmetic CPL

## Build phases
### Phase 0 — Decision/spec lock
- Choose implementation path: WordPress embedded tool vs standalone app
- Pick AI image provider
- Decide storage/retention policy
- Confirm who receives leads
- Confirm booking CTA destination

### Phase 1 — Prototype
- Build local upload + generation flow
- Test with sample images only
- Validate output realism and prompt quality
- Confirm model can preserve face identity and only alter teeth

### Phase 2 — MVP
- Add landing page
- Add lead capture
- Add consent/disclaimer
- Add email/Sheet notification
- Add GA4 events
- Add basic rate limiting and file validation
- Deploy behind a private/test URL

### Phase 3 — Launch
- Publish on SimpleDentalLV site
- Add CTA from cosmetic dentistry / veneers / whitening pages
- Run small paid social/local test
- Monitor cost per lead and consult bookings

### Phase 4 — Optimize
- A/B test hero copy
- A/B test form before vs after result
- Add Spanish page if local demand supports it
- Add retargeting audiences
- Add staff follow-up automation

## Open questions
- Where should the tool live: `/smile-preview/`, subdomain, or standalone campaign page?
- Which booking system should CTA use?
- Who receives notifications?
- What is the office’s preferred cosmetic consult offer?
- Do we want free consult, discounted consult, or “request appointment” framing?
- What retention period should be used for uploaded photos?

## Recommended next step
Build a private prototype first using 10–20 test/selfie-style images to validate output quality. Do not launch publicly until the disclaimers, consent flow, storage rules, and lead notification path are in place.
