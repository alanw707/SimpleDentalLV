# Simple Dental WordPress Theme

A clean, modern WordPress theme designed specifically for Simple Dental practice in Las Vegas, Nevada.

## Theme Features

- **Responsive Design**: Mobile-first approach with clean, modern aesthetic
- **Gray & Earth Tone Color Scheme**: Professional yet approachable design
- **Transparent Pricing Display**: Built-in service pricing functionality
- **SEO Optimized**: Local business schema markup and optimized meta tags
- **Performance Focused**: Fast loading with minimal JavaScript
- **Contact Forms**: Built-in contact form with email functionality
- **Custom Page Templates**: Specialized templates for About, Services, and Contact pages

## Installation Instructions

### Option 1: WordPress Admin Upload
1. Log in to your WordPress admin dashboard
2. Go to `Appearance > Themes`
3. Click `Add New > Upload Theme`
4. Choose the `simple-dental-theme.zip` file
5. Click `Install Now`
6. Activate the theme

### Option 2: FTP Upload
1. Extract the theme files
2. Upload the `simple-dental-theme` folder to `/wp-content/themes/`
3. Go to `Appearance > Themes` in WordPress admin
4. Activate the Simple Dental theme

## Required Pages Setup

After activating the theme, create the following pages:

### 1. Home Page
- Create a new page titled "Home"
- Go to `Settings > Reading` and set this page as your homepage

### 2. About Page
- Create a new page titled "About"
- Select "About Page" template from the Page Attributes
- Add your content about the practice

### 3. Services Page
- Create a new page titled "Services"
- Select "Services Page" template from the Page Attributes
- The pricing will display automatically (can be customized in page editor)

### 4. Contact Page
- Create a new page titled "Contact"
- Select "Contact Page" template from the Page Attributes
- Contact form and map will display automatically

## Menu Setup

1. Go to `Appearance > Menus`
2. Create a new menu named "Primary Menu"
3. Add your pages in this order:
   - Home
   - About
   - Services
   - Contact
4. Set the menu location to "Primary Menu"

## Logo Setup

1. Go to `Appearance > Customize > Site Identity`
2. Upload your logo (recommended size: 200x60 pixels)
3. The logo will appear in the header

## Services Pricing Customization

To customize service pricing:
1. Edit the Services page
2. Scroll down to the "Service Pricing" meta box
3. Modify the service names, prices, and descriptions
4. Update the page

## Contact Form Setup

The contact form is built-in and will send emails to the admin email address. To customize:
- Check your WordPress admin email in `Settings > General`
- The form includes fields for name, email, phone, and message

## Color Customization

The theme uses CSS custom properties for easy color customization. Main colors:
- `--primary-brown: #8B7355`
- `--accent-teal: #4a9b8e`
- `--warm-beige: #f5f2ed`

To customize colors, edit the `:root` section in `style.css`.

## Google Maps Integration

The contact page includes a Google Maps embed. To customize the map:
1. Edit `page-contact.php`
2. Replace the iframe src with your Google Maps embed URL
3. Update the address in the contact information

## Performance Notes

This theme is optimized for performance:
- Minimal JavaScript usage
- Optimized CSS delivery
- No unnecessary WordPress features loaded
- Comments disabled by default (not needed for dental practice)

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Support

For theme customization or issues:
1. Check the WordPress admin for any error messages
2. Ensure all required pages are created
3. Verify menu setup is complete
4. Check that logo is uploaded

## File Structure

```
simple-dental-theme/
├── style.css (main stylesheet with theme info)
├── functions.php (theme functionality)
├── index.php (homepage template)
├── page.php (default page template)
├── page-about.php (about page template)
├── page-services.php (services page template)
├── page-contact.php (contact page template)
├── header.php (site header)
├── footer.php (site footer)
├── assets/
│   ├── js/
│   │   ├── main.js
│   │   └── navigation.js
│   ├── css/ (for additional stylesheets)
│   └── images/ (for theme images)
└── README.md (this file)
```

## Coming Soon Banner

The theme includes a "Coming Soon" banner that appears on the homepage. This is automatically displayed and can be customized in `header.php`.

## Business Information

Update business information in the following locations:
- `functions.php` (schema markup)
- `footer.php` (footer contact info)
- `page-contact.php` (contact page details)

## Version Information

- **Version**: 1.0
- **WordPress Compatibility**: 5.0+
- **PHP Version**: 7.4+
- **Last Updated**: December 2024