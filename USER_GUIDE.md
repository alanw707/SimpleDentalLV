# Simple Dental Website - User Guide

## Table of Contents
1. [Getting Started](#getting-started)
2. [Managing Pages](#managing-pages)
3. [Updating Services & Pricing](#updating-services--pricing)
4. [Customizing Email Settings](#customizing-email-settings)
5. [Managing Contact Information](#managing-contact-information)
6. [Adding Images](#adding-images)
7. [Menu Management](#menu-management)
8. [Regular Maintenance](#regular-maintenance)

## Getting Started

### Logging Into Your Website
1. Go to **yoursite.com/wp-admin** (replace with your actual domain)
2. Enter your username and password
3. Click **Log In**

### WordPress Dashboard Overview
- **Dashboard**: Main overview page with site activity
- **Posts**: Not used for dental practice (disabled)
- **Pages**: Your website pages (Home, About, Services, Contact)
- **Media**: Upload and manage images
- **Appearance**: Customize your site's appearance
- **Users**: Manage admin accounts
- **Settings**: General site settings

## Managing Pages

### Editing Page Content

#### Homepage
1. Go to **Pages > All Pages**
2. Click **"Home"** to edit
3. Make your changes in the editor
4. Click **Update** when finished

**What you can edit**:
- Hero section text ("Straightforward Dentistry...")
- Philosophy section content
- Any text content on the page

**What NOT to change**:
- Service displays (these are automatic)
- Page template (should stay as "Front Page")

#### About Page
1. Go to **Pages > About**
2. Edit the content as needed
3. **Doctor Biography Section**: 
   - Look for the placeholder text about Dr. Chang
   - Replace with actual doctor information
   - Add doctor photo using **Add Media** button

#### Services Page
1. Go to **Pages > Services**
2. You can edit introductory text
3. **Don't modify the shortcodes** like `[services_by_category]`
4. These automatically display your pricing

#### Contact Page
1. Go to **Pages > Contact**
2. Update business hours if needed
3. **Google Maps**: To update the map, you'll need technical help to change the map URL

### Adding New Pages
1. Go to **Pages > Add New**
2. Enter page title
3. Add content using the editor
4. Choose page template from **Page Attributes** (if needed)
5. Click **Publish**

## Updating Services & Pricing

The Simple Dental theme has **20+ services organized into 6 categories**. Pricing is managed automatically, but you can update it when needed.

### Current Service Categories
1. **Preventive & Diagnostic** (5 services)
2. **Restorative Dentistry** (3 services)
3. **Tooth Removal** (2 services)
4. **Root Canals** (3 services)
5. **Dentures & Partials** (3 services)
6. **Other Services** (2 services)

### How to Update Pricing

**⚠️ Important**: Pricing updates require technical knowledge. For major changes, contact your website developer.

**Simple price updates**:
1. Go to **Pages > Services**
2. Look for the **Service Pricing** meta box below the editor
3. Edit individual service prices and descriptions
4. Click **Update Page**

### New Patient Special
The **$199 New Patient Special** is prominently displayed on your homepage and services page. To update:
1. Edit the Homepage or Services page
2. Look for the New Patient Special section
3. Update price or description as needed

## Customizing Email Settings

Your contact form can be customized through the WordPress Customizer.

### Accessing Email Settings
1. Go to **Appearance > Customize**
2. Click **Contact Form Settings**

### Available Settings

#### Primary Email Address
- **What it does**: Main email that receives contact form messages
- **Default**: Your WordPress admin email
- **How to change**: Enter new email address and click **Publish**

#### CC Email Addresses
- **What it does**: Additional emails that receive copies
- **Format**: Separate multiple emails with commas
- **Example**: `info@simpledentallv.com, dr.smith@simpledentallv.com`

#### Subject Prefix
- **What it does**: Adds prefix to email subject line
- **Default**: `[Simple Dental Website]`
- **Example**: `[Simple Dental Website] New contact form message`

#### Enable/Disable Notifications
- **What it does**: Turn contact form emails on/off
- **Use case**: Disable temporarily if receiving spam

### Testing Contact Form
1. Go to your contact page
2. Fill out and submit the form
3. Check that emails are received
4. If problems, see the Troubleshooting Guide

## Managing Contact Information

Your business information appears in multiple locations. Here's where to update it:

### Footer Information
1. Go to **Appearance > Customize**
2. Look for footer customization options
3. Update phone, address, hours as needed

**For major footer changes**, you may need developer assistance.

### Contact Page Details
1. Edit the **Contact** page
2. Update:
   - Business address
   - Phone number
   - Office hours
   - Any special instructions

### Schema Markup (SEO)
Your business information is automatically included in Google search results. This is managed in the theme code and should only be updated by a developer.

## Adding Images

### Uploading Images
1. Go to **Media > Library**
2. Click **Add New**
3. **Drag and drop** or **Select Files**
4. Wait for upload to complete

### Image Best Practices
- **Size**: Keep images under 500KB for fast loading
- **Dimensions**: 1200px wide is usually sufficient
- **Format**: JPG for photos, PNG for graphics with transparency

### Adding Images to Pages
1. Edit the page where you want to add an image
2. Position cursor where you want the image
3. Click **Add Media** button
4. Select your image
5. Choose size (usually "Large" or "Full Size")
6. Click **Insert into page**

### Profile Photos
For doctor profiles on the About page:
- **Recommended size**: 400x500 pixels
- **Professional headshot** works best
- **Upload** through Media Library
- **Insert** into About page content

## Menu Management

Your website navigation menu includes: Home | About | Services | Contact

### Updating Menu Items
1. Go to **Appearance > Menus**
2. Select **"Primary Menu"**
3. Make changes:
   - **Reorder**: Drag and drop items
   - **Rename**: Click arrow next to menu item, change "Navigation Label"
   - **Add pages**: Select from left sidebar, click "Add to Menu"

### Adding New Menu Items
1. Create the new page first
2. Go to **Appearance > Menus**
3. Find your new page in the **Pages** section
4. Click **Add to Menu**
5. Drag to desired position
6. Click **Save Menu**

## Regular Maintenance

### Monthly Tasks

#### Update WordPress
1. Go to **Dashboard > Updates**
2. If updates available, click **Update Now**
3. Test your website afterward

#### Check Contact Form
1. Submit a test message through your contact form
2. Verify you receive the email
3. Check that auto-response works (if enabled)

#### Review Content
1. Check all pages for outdated information
2. Update service prices if needed
3. Verify contact information is current

### Quarterly Tasks

#### Backup Your Website
- Your hosting provider should handle backups
- Contact Hostinger support to confirm backup status

#### Review Analytics
- If Google Analytics is set up, review visitor statistics
- Check which pages are most popular
- Look for any technical issues

#### Update Business Information
- Review hours, services, pricing
- Update staff information
- Check that contact details are current

### Annual Tasks

#### Content Audit
- Review all website content
- Update service descriptions
- Refresh homepage messaging
- Add new testimonials (if available)

#### SEO Review
- Update meta descriptions if needed
- Review keyword relevance
- Check Google My Business listing

## Common Tasks

### Changing Business Hours
**Multiple locations need updating:**
1. **Contact Page**: Edit page content
2. **Footer**: May need developer help
3. **Schema Markup**: Developer required

### Updating Phone Number
**Update in these locations:**
1. **Header**: Contact your developer
2. **Footer**: Contact your developer  
3. **Contact Page**: Edit page content
4. **Schema Markup**: Developer required

### Adding Staff Members
1. **About Page**: Edit page content
2. **Add photos**: Upload through Media Library
3. **Staff bios**: Write and format content

### Seasonal Updates
- **Holiday hours**: Update contact page and footer
- **Seasonal messaging**: Edit homepage content
- **Special promotions**: Can be added to homepage

## Getting Help

### When to Contact Your Developer
- Layout or design changes
- Technical errors or broken functionality
- Adding new features (online booking, testimonials)
- Email delivery problems
- Performance issues

### When to Contact Hosting Support
- Website won't load
- Email problems
- SSL certificate issues
- Database problems

### Self-Help Resources
1. **WordPress.org**: Official WordPress documentation
2. **Your Theme Documentation**: Check project documentation files
3. **YouTube**: WordPress tutorials for basic tasks

### Emergency Procedures
If your website goes down:
1. **Don't panic** - most issues are temporary
2. **Check other websites** - might be internet connection
3. **Contact hosting support** (Hostinger)
4. **Contact developer** if hosting says it's a website issue

### Content Management Best Practices

#### Before Making Changes
- **Preview changes** before publishing
- **Test contact form** after email setting changes
- **Check mobile view** - many visitors use phones

#### Writing for Your Website
- **Keep it simple** - patients want clear information
- **Focus on benefits** - how you help patients
- **Use local keywords** - "Las Vegas dentist", etc.
- **Include calls-to-action** - "Call today", "Schedule appointment"

#### Image Guidelines
- **Professional photos** only
- **Consistent style** across the website
- **Alt text** for accessibility (describe the image)
- **Copyright compliance** - only use images you own or have licensed

This guide covers the most common tasks you'll need to perform as a website owner. For anything not covered here, don't hesitate to contact your developer or hosting provider for assistance.