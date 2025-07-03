# Simple Dental WordPress Theme - Technical Reference

## Table of Contents
1. [Shortcode Reference](#shortcode-reference)
2. [WordPress Customizer Settings](#wordpress-customizer-settings)
3. [PHP Function Reference](#php-function-reference)
4. [CSS Architecture](#css-architecture)
5. [AJAX Endpoints](#ajax-endpoints)
6. [File Structure](#file-structure)
7. [Database Schema](#database-schema)

## Shortcode Reference

### [featured_services]
**Purpose**: Displays the top 6 most popular services for homepage  
**Location**: Homepage services preview section  
**Output**: Grid of 6 service cards with pricing  
**Function**: `featured_services_display()`

```php
<?php echo do_shortcode('[featured_services]'); ?>
```

### [services_by_category]
**Purpose**: Displays all 20+ services organized by category  
**Location**: Services page complete menu section  
**Output**: 6 category sections with color-coded service cards  
**Function**: `services_by_category_display()`

```php
<?php echo do_shortcode('[services_by_category]'); ?>
```

### [new_patient_special]
**Purpose**: Displays prominent New Patient Special ($199)  
**Location**: Homepage and Services page  
**Output**: Coral-themed promotional card with pricing and features  
**Function**: `new_patient_special_display()`

```php
<?php echo do_shortcode('[new_patient_special]'); ?>
```

### [simple_dental_contact]
**Purpose**: Displays AJAX-enabled contact form  
**Location**: Contact page  
**Output**: Professional contact form with reCAPTCHA integration  
**Function**: `simple_dental_contact_form()`

```php
<?php echo do_shortcode('[simple_dental_contact]'); ?>
```

### [simple_dental_services] (Legacy)
**Purpose**: Backward compatibility shortcode  
**Location**: Deprecated, redirects to featured_services  
**Function**: `simple_dental_services_display()`

## WordPress Customizer Settings

### Contact Form Settings Section
**Path**: WordPress Admin → Appearance → Customize → Contact Form Settings

#### contact_form_primary_email
- **Type**: Email field
- **Default**: WordPress admin email
- **Purpose**: Main recipient for contact form submissions
- **Validation**: `sanitize_email()`

#### contact_form_cc_emails
- **Type**: Textarea
- **Default**: Empty
- **Purpose**: Additional email recipients (comma-separated)
- **Validation**: `simple_dental_sanitize_email_list()`

#### contact_form_subject_prefix
- **Type**: Text field
- **Default**: "[Simple Dental Website]"
- **Purpose**: Email subject line prefix for identification
- **Validation**: `sanitize_text_field()`

#### contact_form_notifications_enabled
- **Type**: Checkbox
- **Default**: true
- **Purpose**: Enable/disable email notifications
- **Validation**: `wp_validate_boolean()`

### Accessing Settings in Code
```php
$email_settings = simple_dental_get_contact_emails();
$primary_email = $email_settings['primary'];
$cc_emails = $email_settings['cc'];
$subject_prefix = $email_settings['subject_prefix'];
$notifications_enabled = $email_settings['notifications_enabled'];
```

## PHP Function Reference

### Core Service Functions

#### `get_dental_services_data()`
**Purpose**: Returns comprehensive array of all dental services  
**Returns**: Multi-dimensional array with 6 categories  
**Structure**:
```php
array(
    'category_key' => array(
        'title' => 'Category Name',
        'services' => array(
            array('name' => 'Service Name', 'price' => '$XXX', 'description' => 'Description')
        )
    )
)
```

#### `simple_dental_get_contact_emails()`
**Purpose**: Retrieves contact form email settings with fallbacks  
**Returns**: Array with primary, cc, subject_prefix, notifications_enabled  
**Fallbacks**: WordPress admin email if custom settings invalid

### Contact Form Functions

#### `simple_dental_ajax_contact_form()`
**Purpose**: AJAX handler for contact form submissions  
**Security**: Nonce verification, input sanitization, reCAPTCHA validation  
**Response**: JSON with success/error status and messages

#### `simple_dental_sanitize_email_list($input)`
**Purpose**: Sanitizes comma-separated email list  
**Validation**: Filters invalid emails, returns clean comma-separated string

### Customizer Functions

#### `simple_dental_customizer_settings($wp_customize)`
**Purpose**: Registers WordPress Customizer controls  
**Hook**: `customize_register`  
**Creates**: Contact Form Settings section with 4 controls

### Shortcode Display Functions

#### `featured_services_display($atts)`
**Purpose**: Renders top 6 services for homepage  
**Returns**: HTML string with service grid

#### `services_by_category_display($atts)`
**Purpose**: Renders all services organized by category  
**Returns**: HTML string with categorized service sections

#### `new_patient_special_display($atts)`
**Purpose**: Renders New Patient Special promotional card  
**Returns**: HTML string with coral-themed pricing card

#### `simple_dental_contact_form()`
**Purpose**: Renders AJAX-enabled contact form  
**Features**: Loading states, error handling, reCAPTCHA integration  
**Returns**: HTML string with form and JavaScript

## CSS Architecture

### CSS Custom Properties (Variables)
```css
:root {
    /* Primary Colors */
    --primary-brown: #8B7355;
    --brown-light: #A68B5B;
    --brown-hover: #7A6149;
    
    /* Accent Colors */
    --accent-teal: #4a9b8e;
    --warm-coral: #B5967A;
    --coral-hover: #A68867;
    --soft-sage: #9CAF88;
    
    /* Neutral Colors */
    --warm-beige: #f5f2ed;
    --off-white: #fafafa;
    --white: #ffffff;
    
    /* Text Colors */
    --text-dark: #2c2c2c;
    --text-medium: #666666;
    --light-gray: #999999;
    
    /* Shadows */
    --shadow-light: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-large: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
```

### Component Architecture

#### Contact Form Styling
- **Base**: `.simple-contact-form`
- **Form Rows**: `.form-row` with flexbox layout
- **Input States**: Focus, error, loading states
- **AJAX Elements**: Loading spinners, message containers

#### Service Cards
- **Base**: `.service-card`
- **Categories**: Color-coded borders per category
- **Hover Effects**: Transform and shadow transitions
- **Responsive**: Grid layout with auto-fit columns

#### Navigation
- **Desktop**: Horizontal flex layout
- **Mobile**: Slide-in overlay with animations
- **Hamburger**: CSS-only animated icon transitions

### Responsive Breakpoints
```css
/* Mobile First Approach */
@media (min-width: 768px) { /* Tablet */ }
@media (min-width: 1024px) { /* Desktop */ }
@media (max-width: 480px) { /* Small Mobile */ }
```

### Key CSS Classes

#### Layout Classes
- `.container`: Max-width wrapper with padding
- `.section`: Standard section padding
- `.section-alt`: Alternate background section

#### Component Classes
- `.btn`: Button base styles
- `.btn-primary`: Primary button (brown)
- `.btn-secondary`: Secondary button (teal)
- `.btn-coral`: Coral accent button

#### Utility Classes
- `.text-center`: Center text alignment
- `.sr-only`: Screen reader only content

## AJAX Endpoints

### Contact Form Submission
**Action**: `simple_dental_contact`  
**URL**: `admin-ajax.php`  
**Method**: POST  
**Authentication**: WordPress nonce

#### Request Parameters
```javascript
{
    action: 'simple_dental_contact',
    contact_name: 'User Name',
    contact_email: 'user@example.com',
    contact_phone: '123-456-7890',
    contact_message: 'Message content',
    contact_form_nonce: 'nonce_value',
    'g-recaptcha-response': 'captcha_response'
}
```

#### Response Format
```javascript
// Success Response
{
    success: true,
    message: 'Thank you! Your message has been sent successfully.'
}

// Error Response
{
    success: false,
    message: 'Error message',
    errors: ['Validation error 1', 'Validation error 2']
}
```

#### JavaScript Implementation
```javascript
$('#simple-contact-form').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: ajax_url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            // Handle success/error
        }
    });
});
```

## File Structure

### Core Theme Files
```
simple-dental-theme/
├── style.css                 # Main stylesheet with theme header
├── functions.php            # Core functionality and hooks
├── index.php               # Fallback template
├── front-page.php          # Homepage template
├── page.php                # Default page template
├── page-about.php          # About page template
├── page-services.php       # Services page template
├── page-contact.php        # Contact page template
├── header.php              # Site header
├── footer.php              # Site footer
└── assets/
    ├── css/                # Additional stylesheets (if any)
    ├── images/             # Theme images
    └── js/
        ├── main.js         # Main JavaScript functionality
        └── navigation.js   # Navigation-specific scripts
```

### WordPress Template Hierarchy
1. **Homepage**: `front-page.php` (priority over `index.php`)
2. **Pages**: `page-{template}.php` → `page.php` → `index.php`
3. **About**: `page-about.php` (must be selected in page editor)
4. **Services**: `page-services.php` (must be selected in page editor)
5. **Contact**: `page-contact.php` (must be selected in page editor)

## Database Schema

### WordPress Options (Theme Settings)
- `theme_mod_contact_form_primary_email`: Primary contact email
- `theme_mod_contact_form_cc_emails`: CC email list
- `theme_mod_contact_form_subject_prefix`: Email subject prefix
- `theme_mod_contact_form_notifications_enabled`: Notification toggle

### Post Meta (Service Pricing - Legacy)
- `_simple_dental_services`: Serialized array of custom services (deprecated)

## Hooks and Filters

### Action Hooks
```php
add_action('wp_ajax_simple_dental_contact', 'simple_dental_ajax_contact_form');
add_action('wp_ajax_nopriv_simple_dental_contact', 'simple_dental_ajax_contact_form');
add_action('customize_register', 'simple_dental_customizer_settings');
add_action('admin_menu', 'simple_dental_remove_comments_admin_menu');
```

### Shortcode Hooks
```php
add_shortcode('featured_services', 'featured_services_display');
add_shortcode('services_by_category', 'services_by_category_display');
add_shortcode('new_patient_special', 'new_patient_special_display');
add_shortcode('simple_dental_contact', 'simple_dental_contact_form');
```

## Performance Optimizations

### WordPress Feature Removal
```php
// Remove unnecessary WordPress features
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
```

### CSS Optimizations
- Single stylesheet approach
- CSS custom properties for theming
- Minimal use of external dependencies
- Hardware-accelerated animations

### JavaScript Optimizations
- Minimal JavaScript footprint
- jQuery dependency for AJAX compatibility
- Event delegation for performance
- Debounced scroll events

## Security Features

### Input Sanitization
```php
$name = sanitize_text_field($_POST['contact_name']);
$email = sanitize_email($_POST['contact_email']);
$message = sanitize_textarea_field($_POST['contact_message']);
```

### Nonce Verification
```php
wp_verify_nonce($_POST['contact_form_nonce'], 'simple_dental_contact_nonce')
```

### Email Validation
```php
if (!is_email($email)) {
    $errors[] = 'Valid email is required.';
}
```

### reCAPTCHA Integration
```php
if (function_exists('anr_verify_captcha')) {
    if (!anr_verify_captcha()) {
        $errors[] = 'Please complete the CAPTCHA verification.';
    }
}
```

## Maintenance Notes

### Regular Updates Required
1. **WordPress Core**: Monthly security updates
2. **Plugins**: SMTP and reCAPTCHA plugin updates
3. **Service Pricing**: Update prices in `get_dental_services_data()`
4. **Contact Information**: Update across multiple files when changed

### Backup Locations
- **Database**: WordPress options table (theme_mod_* entries)
- **Files**: Entire `simple-dental-theme` directory
- **Content**: All created pages with assigned templates

### Common Maintenance Tasks
1. **Email Testing**: Regular contact form delivery tests
2. **SMTP Monitoring**: Check Brevo account status and limits
3. **Performance Monitoring**: Page speed and mobile performance
4. **Security Updates**: WordPress, theme, and plugin updates