# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Standard Workflow
1. First think through the problem, read the codebase for relevant files, and write a plan to tasks/todo.md.
2. The plan should have a list of todo items that you can check off as you complete them
3. Before you begin working, check in with me and I will verify the plan.
4. Then, begin working on the todo items, marking them as complete as you go.
5. Please every step of the way just give me a high level explanation of what changes you made
6. Make every task and code change you do as simple as possible. We want to avoid making any massive or complex changes. Every change should impact as little code as possible. Everything is about simplicity.
7. Finally, add a review section to the [todo.md] file with a summary of the changes you made and any other relevant information.


## Project Overview

This is a custom WordPress theme development project for Simple Dental, a new dental practice opening in Las Vegas, Nevada in September 2025.

## Client Requirements

**Practice Information:**
- Practice Name: Simple Dental
- Location: 204 S Jones Blvd, Las Vegas, NV 89149
- Phone: (702) 302-4787
- Hours: Monday-Friday, 8 AM - 4 PM
- Opening: September 2025

**Brand Philosophy:**
- Straightforward dentistry from one experienced doctor
- No pressure, no upselling
- Transparent pricing with no hidden fees
- Modern technology with same-day crowns
- Focus on everyday working families

**Design Requirements:**
- Clean, modern aesthetic
- Gray and earth-tone color palette
- Mobile-responsive design
- Fast loading times
- Minimal animations

## Website Structure

**Required Pages:**
1. **Home Page** - Hero section with practice philosophy and service preview
2. **About Page** - Practice story, philosophy, and what makes them different
3. **Services Page** - Transparent pricing for all services
4. **Contact Page** - Contact form, business info, map embed, and FAQ

**Key Services & Pricing:**
Now features 20+ services organized into 6 categories:
- **Preventive & Diagnostic**: New Patient Exam + X-rays ($149), Adult Cleaning ($150), etc.
- **Restorative Dentistry**: Tooth-Colored Fillings ($180-250), Same-Day Crowns ($899)
- **Tooth Removal**: Simple Extraction ($180), Surgical Extraction ($280)
- **Root Canals**: Front Tooth ($650), Premolar ($800), Molar ($1000)
- **Dentures & Partials**: Full Denture ($2000), Partial Denture ($1600)
- **Other Services**: Night Guard ($365), Retainers ($200)
- **New Patient Special**: Complete Checkup & Cleaning ($199)

## Technical Implementation

**WordPress Theme Structure:**
- Custom WordPress theme (not a child theme)
- Responsive CSS with mobile-first approach
- Custom page templates for each main page
- Built-in contact form functionality
- Service pricing management system
- SEO optimization with local business schema
- Performance optimizations

**Key Files:**
- `style.css` - Main stylesheet with theme header and comprehensive contact form styling
- `functions.php` - Theme functionality, WordPress hooks, service data, AJAX handlers, Customizer settings
- `front-page.php` - Homepage template (renamed from index.php)
- `page-*.php` - Custom page templates with enhanced content
- `header.php` / `footer.php` - Site structure with scroll-to-top functionality
- JavaScript files for navigation, AJAX form submission, and scroll interactions

**Color Palette:**
- Primary Brown: #8B7355
- Light Brown: #A68B5B
- Accent Teal: #4a9b8e
- Warm Beige: #f5f2ed
- Warm Coral (muted): #B5967A
- Coral Hover: #A68867
- Soft Sage: #9CAF88
- Various grays for text and backgrounds

## Features Implemented

### Core WordPress Theme
✅ Responsive design (mobile-first)
✅ Gray and earth-tone color scheme with coral accents
✅ Custom page templates (front-page.php, page-about.php, page-services.php, page-contact.php)
✅ Professional typography (Inter font)
✅ Background images for all page headers
✅ Coming Soon banner
✅ Performance optimizations

### Service Management System
✅ Comprehensive 20+ services organized into 6 categories
✅ Multiple shortcodes: [featured_services], [services_by_category], [new_patient_special]
✅ New Patient Special prominent display ($199)
✅ Same-day crown technology showcase with detailed explanations
✅ Transparent pricing display with categorized organization

### Advanced Contact Form
✅ AJAX form submission (no page refresh)
✅ Google reCAPTCHA integration support
✅ Brevo SMTP integration
✅ WordPress Customizer email settings configuration
✅ Multiple recipient support (primary + CC emails)
✅ Custom email subject prefixes
✅ Enhanced security with nonce verification
✅ Loading states and user feedback
✅ Error logging and troubleshooting features

### Mobile & UX Enhancements
✅ Optimized mobile hero section padding (470px front-page, 430px other pages)
✅ Mobile navigation menu with smooth animations
✅ Clean hamburger menu with X-icon transitions
✅ Scroll-to-top functionality
✅ Scroll animations for service cards
✅ Header scroll effects
✅ Content Security Policy (CSP) compliance

### Content Organization & SEO
✅ Content consolidation to eliminate redundancy
✅ Enhanced homepage with philosophy cards and hover effects
✅ SEO optimization (local business schema)
✅ Google Maps integration
✅ FAQ sections strategically placed
✅ Mobile typography optimization

## Deployment

**For Hostinger WordPress Hosting:**
1. Zip the `simple-dental-theme` folder
2. Upload via WordPress Admin > Themes > Add New > Upload
3. Create required pages (Home, About, Services, Contact)
4. Set up primary navigation menu
5. Upload logo via Customizer
6. Test all functionality

## Development Workflow

This is a standalone WordPress theme that requires no build process. Key development patterns:

### Theme Deployment

**Manual Upload (ZIP):**
```bash
# Create ZIP for WordPress admin upload
python3 -c "
import zipfile, os
def create_zip(source_dir, zip_path):
    with zipfile.ZipFile(zip_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
        for root, dirs, files in os.walk(source_dir):
            for file in files:
                file_path = os.path.join(root, file)
                arcname = os.path.relpath(file_path, os.path.dirname(source_dir))
                zipf.write(file_path, arcname)
create_zip('simple-dental-theme', 'simple-dental-theme.zip')
"
```

**Automated FTP Deployment:**
```bash
# Option 1: Edit deploy.py with FTP credentials
python3 deploy.py

# Option 2: Secure deployment with separate config
cp deploy-config.example.py ftp_config.py
# Edit ftp_config.py with credentials
python3 deploy-secure.py
```

### WordPress Theme Structure
- **Template Hierarchy**: Uses custom page templates (page-about.php, page-services.php, page-contact.php) plus front-page.php for homepage
- **Advanced Shortcode System**: 
  - `[featured_services]` - Top 6 services for homepage
  - `[services_by_category]` - Full categorized service list
  - `[new_patient_special]` - Prominent special pricing display
  - `[simple_dental_contact]` - AJAX-enabled contact form
- **Customizer Integration**: Email settings configurable via Appearance → Customize → Contact Form Settings
- **Color System**: CSS custom properties in `:root` with earth-tone and coral accent palette

### Architecture Notes
- **functions.php**: Contains comprehensive service data, AJAX handlers, WordPress Customizer settings, contact form functionality, and SEO schema markup
- **Navigation**: Custom walker class for menu styling, mobile menu with smooth animations
- **Contact Form**: Advanced AJAX-enabled form with reCAPTCHA, custom email settings, and SMTP integration
- **Performance**: Removes unnecessary WP features (emojis, RSD, comments) while adding essential UX features
- **Email System**: Configurable recipients, custom subject prefixes, and professional email formatting

## Testing Checklist

### Core Functionality
- [x] Homepage displays correctly with hero section and philosophy cards
- [x] All page templates work properly with enhanced content
- [x] Navigation menu functions on desktop and mobile
- [x] Mobile menu animations work smoothly
- [x] Services pricing displays properly in all categories
- [x] Map embed loads correctly
- [x] Mobile responsiveness across all pages
- [x] SEO meta tags are present
- [x] Logo displays in header
- [x] Coming Soon banner appears on homepage
- [x] Background images display on all pages
- [x] Hero section padding optimized for mobile
- [x] JavaScript console errors resolved (CSP compliance)
- [x] Scroll animations functioning on service cards
- [x] Scroll-to-top button functionality

### Advanced Contact Form
- [x] AJAX form submission works without page refresh
- [x] Contact form sends emails via Brevo SMTP
- [x] reCAPTCHA integration functioning
- [x] Form validation and error handling working
- [x] Loading states and user feedback operational
- [x] Multiple recipient emails (CC) functionality
- [x] WordPress Customizer email settings accessible
- [x] Email logging for troubleshooting

### Content & Services
- [x] New Patient Special displays prominently
- [x] Same-day crown technology section comprehensive
- [x] All 20+ services categorized and priced correctly
- [x] Content redundancy eliminated
- [x] Mobile typography optimized for readability
- [x] About page prepared for doctor biography content

## Recent Accomplishments (Latest Updates)

**Content Management & Service Expansion (Complete):**
- ✅ Expanded from 5 basic services to 20+ comprehensive services in 6 categories
- ✅ Created detailed same-day crown technology section with intraoral scanner and Glidewell Fastmill.io info
- ✅ Added prominent New Patient Special ($199) with coral-themed styling
- ✅ Implemented content consolidation to eliminate 40+ instances of duplicate content
- ✅ Enhanced homepage with professional philosophy cards and icons
- ✅ Reorganized content hierarchy for better SEO and user experience

**Advanced Contact Form Implementation (Complete):**
- ✅ AJAX form submission eliminates page refresh
- ✅ WordPress Customizer integration for email settings configuration
- ✅ Multiple recipient support (primary + CC emails)
- ✅ Brevo SMTP integration for reliable email delivery
- ✅ Google reCAPTCHA integration with Advanced Google reCAPTCHA plugin
- ✅ Enhanced security with nonce verification and input sanitization
- ✅ Professional loading states and error handling
- ✅ Email logging and troubleshooting features

**Mobile UX & Typography Optimization (Complete):**
- ✅ Reduced mobile hero font sizes for better readability (2.3rem h1, 1.2rem subtitles)
- ✅ Fixed mobile menu positioning and width (170px optimal size)
- ✅ Resolved hero text cutoff issues with proper padding (470px for front-page, 430px for other pages)
- ✅ Implemented smooth CSS animations for mobile menu show/hide
- ✅ Added clean hamburger-to-X icon transitions
- ✅ Fixed all JavaScript console errors (CSP compliance)
- ✅ Added scroll-to-top functionality with smooth animations

**Animation & Polish (Complete):**
- ✅ Mobile menu slide-in/fade animations working perfectly
- ✅ Service card scroll animations for better user engagement
- ✅ Header scroll effects for modern feel
- ✅ Contact form AJAX animations and transitions
- ✅ All CSS transitions use optimized cubic-bezier timing

## Future Considerations

**Immediate Pre-Launch Tasks:**
- [ ] Add doctor biography content when provided by client
- [ ] Update Google Maps embed URL with verified practice location
- [ ] Configure final email settings in WordPress Customizer
- [ ] Test contact form delivery with actual business email
- [ ] Verify reCAPTCHA functionality on live site

**Short-term Enhancements (Post-Launch):**
- [ ] Add online appointment booking integration
- [ ] Implement patient testimonials section
- [ ] Add before/after photo galleries
- [ ] Consider blog functionality for dental health content
- [ ] Add structured data for services/pricing for enhanced SEO

**Long-term Considerations:**
- Consider adding patient portal integration
- Potential for online payment processing
- Advanced appointment scheduling system
- Patient communication tools
- Insurance verification tools
- Review management system integration

## Important Implementation Details

### Service Pricing System
- Pricing data stored in WordPress post meta (`_simple_dental_services`)
- Default services defined in `functions.php` if no custom pricing set
- Services page meta box allows editing service name, price, and description
- Data structure: array of objects with 'name', 'price', 'description' keys

### Advanced Contact Form System
- **AJAX Submission**: No page refresh, smooth user experience
- **Security**: WordPress nonce verification, input sanitization, reCAPTCHA integration
- **Email Configuration**: WordPress Customizer settings for custom recipients
- **Multiple Recipients**: Primary email + CC emails support
- **SMTP Integration**: Brevo SMTP for reliable email delivery
- **Custom Email Headers**: Professional formatting with Reply-To
- **Error Handling**: Comprehensive logging and user feedback
- **Loading States**: Visual feedback during submission
- **Form Persistence**: Maintains user data on validation errors

### SEO & Schema Implementation
- Local business schema markup automatically added to homepage and contact page
- Includes business name, address, phone, hours, and price range
- Meta descriptions and keywords optimized for "dentist las vegas" searches

### Theme Customization Points
- Business info updates required in: `functions.php` (schema), `footer.php` (contact info), `page-contact.php` (details)
- Google Maps embed URL in `page-contact.php` line ~47 (currently placeholder)
- Coming Soon banner controlled in `header.php` (only shows on front page)
- Mobile menu breakpoint: 768px (defined in footer.php and navigation.js)