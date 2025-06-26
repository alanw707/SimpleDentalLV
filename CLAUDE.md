# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

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
- Exam & Cleaning: $189
- Deep Cleaning: $225 per quad
- Same-Day Crown: $899
- Extraction: $220
- Root Canal: $850

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
- `style.css` - Main stylesheet with theme header
- `functions.php` - Theme functionality and WordPress hooks
- `index.php` - Homepage template
- `page-*.php` - Custom page templates
- `header.php` / `footer.php` - Site structure
- JavaScript files for navigation and interactions

**Color Palette:**
- Primary Brown: #8B7355
- Light Brown: #A68B5B
- Accent Teal: #4a9b8e
- Warm Beige: #f5f2ed
- Various grays for text and backgrounds

## Features Implemented

✅ Responsive design (mobile-first)
✅ Gray and earth-tone color scheme  
✅ Custom page templates
✅ Services pricing display system
✅ Contact form with email functionality
✅ Google Maps integration
✅ Coming Soon banner
✅ SEO optimization (local business schema)
✅ Performance optimizations
✅ Mobile navigation menu with smooth animations
✅ FAQ section
✅ Professional typography (Inter font)
✅ Background images for all page headers
✅ Optimized mobile hero section padding
✅ Clean hamburger menu with X-icon transitions
✅ Content Security Policy (CSP) compliance
✅ Scroll animations for service cards
✅ Header scroll effects

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
- **Template Hierarchy**: Uses custom page templates (page-about.php, page-services.php, page-contact.php) that must be selected manually in WordPress page editor
- **Custom Functionality**: Service pricing system managed through WordPress meta boxes - edit any page and scroll to "Service Pricing" section
- **Shortcodes**: `[simple_dental_services]` displays pricing grid, `[simple_dental_contact]` displays contact form
- **Color System**: CSS custom properties in `:root` for easy theme customization

### Architecture Notes
- **functions.php**: Contains custom meta boxes for pricing, contact form handler, SEO schema markup, and performance optimizations
- **Navigation**: Custom walker class for menu styling, mobile menu handled via JavaScript
- **Contact Form**: Built-in PHP form handler (no plugins needed) - emails sent to WordPress admin email
- **Performance**: Removes unnecessary WP features (emojis, RSD, comments) and uses minimal JavaScript

## Testing Checklist

- [x] Homepage displays correctly with hero section
- [x] All page templates work properly
- [x] Navigation menu functions on desktop and mobile
- [x] Mobile menu animations work smoothly
- [x] Contact form sends emails correctly
- [x] Services pricing displays properly
- [x] Map embed loads correctly
- [x] Mobile responsiveness across all pages
- [x] SEO meta tags are present
- [x] Logo displays in header
- [x] Coming Soon banner appears on homepage
- [x] Background images display on all pages
- [x] Hero section padding optimized for mobile
- [x] JavaScript console errors resolved (CSP compliance)
- [x] Scroll animations functioning on service cards

## Recent Accomplishments (Latest Updates)

**Mobile UX Improvements (Complete):**
- ✅ Fixed mobile menu positioning and width (170px optimal size)
- ✅ Resolved hero text cutoff issues with proper padding (470px for front-page, 430px for other pages)
- ✅ Implemented smooth CSS animations for mobile menu show/hide
- ✅ Added clean hamburger-to-X icon transitions
- ✅ Fixed all JavaScript console errors (CSP compliance)
- ✅ Moved all dynamic CSS to main stylesheet

**Animation & Polish (Complete):**
- ✅ Mobile menu slide-in/fade animations working perfectly
- ✅ Service card scroll animations for better user engagement
- ✅ Header scroll effects for modern feel
- ✅ All CSS transitions use optimized cubic-bezier timing

## Future Considerations

**Short-term priorities (if needed):**
- [ ] Add loading states for contact form submission
- [ ] Consider adding smooth scroll behavior to anchor links
- [ ] Potential form validation improvements
- [ ] Add hover states for mobile touch interactions

**Long-term considerations:**
- May need to update Google Maps embed URL with actual practice location
- Consider adding online appointment booking integration
- Potential for blog functionality if client wants to add dental health content
- May need insurance information updates before opening
- Consider adding patient portal integration
- Add structured data for services/pricing for better SEO

## Important Implementation Details

### Service Pricing System
- Pricing data stored in WordPress post meta (`_simple_dental_services`)
- Default services defined in `functions.php` if no custom pricing set
- Services page meta box allows editing service name, price, and description
- Data structure: array of objects with 'name', 'price', 'description' keys

### Contact Form Security
- Uses WordPress nonce verification and sanitization
- Form fields: name, email, phone, message (all sanitized on submission)
- Emails sent to WordPress admin email address from Settings > General

### SEO & Schema Implementation
- Local business schema markup automatically added to homepage and contact page
- Includes business name, address, phone, hours, and price range
- Meta descriptions and keywords optimized for "dentist las vegas" searches

### Theme Customization Points
- Business info updates required in: `functions.php` (schema), `footer.php` (contact info), `page-contact.php` (details)
- Google Maps embed URL in `page-contact.php` line ~47 (currently placeholder)
- Coming Soon banner controlled in `header.php` (only shows on front page)
- Mobile menu breakpoint: 768px (defined in footer.php and navigation.js)