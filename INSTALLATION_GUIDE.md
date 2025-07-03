# Simple Dental WordPress Theme - Installation Guide

## Prerequisites

### Required WordPress Plugins
Install these plugins before setting up the theme:

**1. SMTP Email Plugin (Choose One):**
- **Brevo (Recommended)**: Official Brevo plugin for WordPress
- **WP Mail SMTP**: By WPForms (free version supports Brevo)
- **Easy WP SMTP**: Simple SMTP configuration

**2. Google reCAPTCHA Plugin:**
- **Advanced Google reCAPTCHA**: For contact form spam protection
- Alternative: **reCAPTCHA for WooCommerce** (works with any form)

### Plugin Installation Steps
1. Go to **Plugins → Add New**
2. Search for "Brevo" and "Advanced Google reCAPTCHA"
3. Install and activate both plugins
4. Configure as described in Step 7 below

## Quick Setup for Hostinger

### Step 1: Upload Theme
1. Log into your Hostinger WordPress admin dashboard
2. Go to **Appearance > Themes**
3. Click **Add New > Upload Theme**
4. Upload the `simple-dental-theme.zip` file
5. Click **Install Now** and then **Activate**

### Step 2: Create Required Pages
Create these pages in **Pages > Add New**:

**1. Home Page**
- Title: "Home" 
- Content: Leave blank (theme will handle content)
- Publish

**2. About Page**
- Title: "About"
- Page Template: Select "About Page" 
- Content: Add any additional content you want
- Publish

**3. Services Page**
- Title: "Services"
- Page Template: Select "Services Page"
- Content: The pricing will display automatically
- Publish

**4. Contact Page**
- Title: "Contact" 
- Page Template: Select "Contact Page"
- Content: Contact form and map will display automatically
- Publish

### Step 3: Set Homepage
1. Go to **Settings > Reading**
2. Select "A static page"
3. Choose "Home" as your Homepage
4. Save Changes

### Step 4: Setup Navigation Menu
1. Go to **Appearance > Menus**
2. Create a new menu called "Primary Menu"
3. Add pages in this order:
   - Home
   - About  
   - Services
   - Contact
4. Check "Primary Menu" under Menu Locations
5. Save Menu

### Step 5: Upload Logo
1. Go to **Appearance > Customize**
2. Click **Site Identity**
3. Upload your logo (recommended: 200x60 pixels)
4. Save & Publish

### Step 6: Update Site Information
1. Go to **Settings > General**
2. Update Site Title: "Simple Dental"
3. Update Tagline: "Straightforward dentistry from one experienced doctor"
4. Verify admin email address (this is the fallback for contact forms)
5. Save Changes

### Step 7: Configure Email & Security Plugins

**A. Setup Brevo SMTP:**
1. Sign up for free Brevo account at brevo.com
2. Get your SMTP credentials from Brevo dashboard
3. Go to **Settings > Brevo** or **Settings > WP Mail SMTP**
4. Enter your Brevo SMTP settings:
   - SMTP Host: smtp-relay.brevo.com
   - Port: 587
   - Encryption: TLS
   - Username: Your Brevo login email
   - Password: Your Brevo SMTP key
5. Send a test email to verify setup

**B. Setup Google reCAPTCHA:**
1. Visit console.developers.google.com
2. Create a new project or select existing
3. Enable reCAPTCHA API
4. Create reCAPTCHA v3 credentials for your domain
5. Go to **Settings > Advanced Google reCAPTCHA**
6. Enter your Site Key and Secret Key
7. Configure to work with contact forms

### Step 8: Configure Contact Form Email Settings
1. Go to **Appearance > Customize > Contact Form Settings**
2. Set **Primary Contact Email** (where contact forms go)
3. Add **Additional Recipients** if needed (comma-separated)
4. Set **Email Subject Prefix** (e.g., "[Simple Dental Contact]")
5. Ensure **Enable Email Notifications** is checked
6. Save & Publish

## Customization Options

### Service Pricing Management
Services are now managed through theme shortcodes with preset pricing:
- **Featured Services**: Top 6 services displayed on homepage
- **Complete Service Menu**: All 20+ services in 6 categories
- **New Patient Special**: $199 promotion prominently displayed

To modify service pricing, edit the `get_dental_services_data()` function in `functions.php`

### Contact Information Updates
Contact information is hardcoded in multiple theme files. Update these locations if needed:
- **Phone**: functions.php, footer.php, header.php, contact page
- **Address**: footer.php, about page, contact page
- **Hours**: footer.php, contact page
- **Google Maps**: page-contact.php (update embed URL with actual location)

### Colors (Optional)
To change colors, edit the `:root` section in Appearance > Theme Editor > style.css

## Testing Checklist

### Basic Functionality
- [ ] Homepage displays with hero section and philosophy cards
- [ ] All menu links work properly
- [ ] Services page shows all categorized pricing
- [ ] Same-day crown technology section displays
- [ ] New Patient Special appears prominently
- [ ] About page shows placeholder for doctor bio
- [ ] Mobile menu works on phone with smooth animations
- [ ] Logo appears in header
- [ ] Scroll-to-top button functions

### Contact Form Testing
- [ ] Contact form displays without errors
- [ ] reCAPTCHA widget appears
- [ ] Form submits via AJAX (no page refresh)
- [ ] Success message displays after submission
- [ ] Email received at configured address
- [ ] Error handling works (try submitting empty form)
- [ ] Loading animation appears during submission

### Email System Verification
- [ ] Brevo SMTP test email successful
- [ ] Contact form emails delivered to primary address
- [ ] CC recipients receive copies (if configured)
- [ ] Email subject includes custom prefix
- [ ] Reply-To header set correctly to sender

### Mobile & Performance
- [ ] Mobile typography readable and properly sized
- [ ] Contact form works on mobile devices
- [ ] All animations smooth on mobile
- [ ] No JavaScript console errors
- [ ] Page loads quickly on mobile

## Troubleshooting

### Contact Form Issues
**Problem**: Contact form not sending emails
**Solutions**:
1. Check Brevo SMTP configuration
2. Verify WordPress Admin Email in Settings > General
3. Check Contact Form Settings in Customizer
4. Test Brevo connection with plugin test email feature
5. Check WordPress error logs for email failures

**Problem**: reCAPTCHA not appearing
**Solutions**:
1. Verify reCAPTCHA plugin is activated
2. Check Site Key and Secret Key configuration
3. Ensure domain matches reCAPTCHA settings
4. Clear any caching plugins

### Email Delivery Issues
**Problem**: Emails going to spam
**Solutions**:
1. Configure SPF/DKIM records with your hosting provider
2. Use a professional email address as sender
3. Add your domain to safe senders list
4. Check Brevo sender reputation

### Performance Issues
**Problem**: Slow loading
**Solutions**:
1. Enable caching plugin (WP Rocket, W3 Total Cache)
2. Optimize images
3. Check hosting server performance
4. Minimize plugin usage

## Support Resources

### Documentation Files
- **CLAUDE.md**: Comprehensive project documentation
- **PROJECT_STATUS.md**: Current project status and completion
- **TECHNICAL_REFERENCE.md**: Detailed technical documentation
- **FTP_DEPLOYMENT.md**: Deployment instructions

### Contact Form Email Configuration
All email settings can be managed through:
**WordPress Admin → Appearance → Customize → Contact Form Settings**

### Plugin Support
- **Brevo Support**: brevo.com/support
- **reCAPTCHA Documentation**: developers.google.com/recaptcha

Your website is now ready for your September 2025 opening with professional contact management and spam protection!