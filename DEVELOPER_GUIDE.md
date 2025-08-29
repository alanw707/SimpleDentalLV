# Developer Customization Guide - Simple Dental Theme

## Table of Contents
1. [Theme Architecture](#theme-architecture)
2. [Customization Patterns](#customization-patterns)
3. [Extending Functionality](#extending-functionality)
4. [Hook Reference](#hook-reference)
5. [Best Practices](#best-practices)
6. [Common Customizations](#common-customizations)

## Theme Architecture

### Design Philosophy
The Simple Dental theme follows WordPress standards with these principles:
- **Single Responsibility**: Each function has a specific purpose
- **Extensibility**: Easy to extend without modifying core files
- **Performance**: Minimal footprint with optimized code
- **Maintainability**: Clean, documented code structure

### File Organization
```
simple-dental-theme/
├── style.css              # Main stylesheet + theme header
├── functions.php           # All theme functionality (800+ lines)
├── front-page.php         # Homepage template
├── page-*.php             # Custom page templates
├── header.php/footer.php  # Site structure
└── assets/
    ├── js/                # JavaScript files
    ├── css/               # Additional stylesheets
    └── images/            # Theme images
```

### Key Architecture Decisions
- **Single Functions File**: All functionality in `functions.php` for simplicity
- **No Build Process**: Direct development, no compilation required
- **CSS Custom Properties**: Modern theming approach with CSS variables
- **AJAX Integration**: Contact form uses WordPress AJAX API
- **Shortcode System**: Modular content display system

## Customization Patterns

### Safe Customization Approach
```php
// ✅ GOOD: Use hooks to extend functionality
add_action('wp_head', 'my_custom_header_code');
function my_custom_header_code() {
    // Your custom code
}

// ❌ AVOID: Directly modifying theme files
// Don't edit functions.php directly for customizations
```

### Child Theme Alternative
Since this is a custom theme, create a plugin for customizations:

```php
<?php
/**
 * Plugin Name: Simple Dental Customizations
 * Description: Site-specific customizations for Simple Dental
 */

// Your customizations here
add_filter('simple_dental_services_data', 'custom_modify_services');
function custom_modify_services($services) {
    // Modify services array
    return $services;
}
```

## Extending Functionality

### Adding New Service Categories

```php
/**
 * Extend the dental services data
 */
add_filter('simple_dental_services_data', 'add_cosmetic_services');
function add_cosmetic_services($services) {
    $services['cosmetic'] = array(
        'title' => 'Cosmetic Dentistry',
        'services' => array(
            array(
                'name' => 'Teeth Whitening',
                'price' => '$299',
                'description' => 'Professional in-office whitening treatment'
            ),
            // Add more services...
        )
    );
    return $services;
}
```

### Custom Shortcodes

```php
/**
 * Create custom shortcode for business hours
 */
add_shortcode('business_hours', 'display_business_hours');
function display_business_hours($atts) {
    $hours = array(
        'Monday' => '8:00 AM - 4:00 PM',
        'Tuesday' => '8:00 AM - 4:00 PM',
        // ...
    );
    
    $output = '<div class="business-hours">';
    foreach ($hours as $day => $time) {
        $output .= "<p><strong>{$day}:</strong> {$time}</p>";
    }
    $output .= '</div>';
    
    return $output;
}
```

### Extending Contact Form

```php
/**
 * Add custom field to contact form
 */
add_filter('simple_dental_contact_form_fields', 'add_appointment_field');
function add_appointment_field($fields) {
    $fields['appointment_request'] = array(
        'type' => 'checkbox',
        'label' => 'Request Appointment',
        'required' => false
    );
    return $fields;
}

/**
 * Process custom field in contact form handler
 */
add_action('simple_dental_contact_form_process', 'process_appointment_request');
function process_appointment_request($form_data) {
    if (isset($form_data['appointment_request'])) {
        // Handle appointment request logic
        // Send to appointment system, etc.
    }
}
```

### Custom Post Types

```php
/**
 * Add testimonials post type
 */
add_action('init', 'register_testimonials_post_type');
function register_testimonials_post_type() {
    register_post_type('testimonial', array(
        'labels' => array(
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial'
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-format-quote'
    ));
}

/**
 * Display testimonials shortcode
 */
add_shortcode('testimonials', 'display_testimonials');
function display_testimonials($atts) {
    $testimonials = get_posts(array(
        'post_type' => 'testimonial',
        'posts_per_page' => 3
    ));
    
    $output = '<div class="testimonials-grid">';
    foreach ($testimonials as $testimonial) {
        $output .= '<div class="testimonial-card">';
        $output .= '<h3>' . get_the_title($testimonial) . '</h3>';
        $output .= '<p>' . get_the_content(null, false, $testimonial) . '</p>';
        $output .= '</div>';
    }
    $output .= '</div>';
    
    return $output;
}
```

## Hook Reference

### Available Actions
```php
// Theme setup complete
do_action('simple_dental_theme_loaded');

// Before contact form processing
do_action('simple_dental_contact_form_before_process', $form_data);

// After contact form processing
do_action('simple_dental_contact_form_after_process', $form_data, $result);

// Before services display
do_action('simple_dental_before_services_display', $services_data);
```

### Available Filters
```php
// Modify services data
apply_filters('simple_dental_services_data', $services);

// Modify contact form fields
apply_filters('simple_dental_contact_form_fields', $fields);

// Modify email settings
apply_filters('simple_dental_contact_emails', $email_settings);

// Modify schema markup
apply_filters('simple_dental_schema_markup', $schema);
```

### CSS Custom Properties for Theming
```css
:root {
    /* Primary Colors - Safe to modify */
    --primary-brown: #8B7355;
    --brown-light: #A68B5B;
    --accent-teal: #4a9b8e;
    
    /* Add custom properties */
    --custom-accent: #your-color;
}

/* Override in custom stylesheet */
.service-card {
    border-color: var(--custom-accent);
}
```

## Best Practices

### Performance Optimization
```php
/**
 * ✅ GOOD: Conditional loading
 */
function load_contact_form_scripts() {
    if (is_page('contact')) {
        wp_enqueue_script('contact-form-extra');
    }
}
add_action('wp_enqueue_scripts', 'load_contact_form_scripts');

/**
 * ❌ AVOID: Loading everywhere
 */
// Don't load heavy scripts on every page
```

### Database Queries
```php
/**
 * ✅ GOOD: Use WordPress functions
 */
$services = get_transient('dental_services_cache');
if (false === $services) {
    $services = get_dental_services_data();
    set_transient('dental_services_cache', $services, HOUR_IN_SECONDS);
}

/**
 * ❌ AVOID: Direct database queries
 */
// Don't use raw SQL unless absolutely necessary
```

### Security
```php
/**
 * ✅ GOOD: Sanitize and validate
 */
$user_input = sanitize_text_field($_POST['field']);
if (!wp_verify_nonce($_POST['nonce'], 'action_name')) {
    wp_die('Security check failed');
}

/**
 * ❌ AVOID: Raw input usage
 */
// Never use $_POST/$_GET directly
```

## Common Customizations

### Modifying Service Pricing
```php
/**
 * Update specific service pricing
 */
add_filter('simple_dental_services_data', 'update_service_pricing');
function update_service_pricing($services) {
    // Update New Patient Exam price
    foreach ($services['preventive']['services'] as &$service) {
        if ($service['name'] === 'New Patient Exam + X-rays') {
            $service['price'] = '$169'; // Updated price
            break;
        }
    }
    return $services;
}
```

### Custom Contact Form Recipients
```php
/**
 * Dynamic email recipients based on form content
 */
add_filter('simple_dental_contact_emails', 'dynamic_contact_recipients', 10, 2);
function dynamic_contact_recipients($email_settings, $form_data) {
    if (strpos($form_data['message'], 'appointment') !== false) {
        $email_settings['cc'][] = 'appointments@simpledentallv.com';
    }
    if (strpos($form_data['message'], 'billing') !== false) {
        $email_settings['cc'][] = 'billing@simpledentallv.com';
    }
    return $email_settings;
}
```

### Adding Social Media Links
```php
/**
 * Add social media to footer
 */
add_action('wp_footer', 'add_social_media_footer');
function add_social_media_footer() {
    ?>
    <div class="social-media-footer">
        <a href="https://facebook.com/simpledentallv" target="_blank" rel="noopener">
            <i data-feather="facebook"></i>
        </a>
        <a href="https://instagram.com/simpledentallv" target="_blank" rel="noopener">
            <i data-feather="instagram"></i>
        </a>
    </div>
    <style>
    .social-media-footer {
        text-align: center;
        padding: 20px 0;
        border-top: 1px solid var(--light-gray);
    }
    .social-media-footer a {
        margin: 0 10px;
        color: var(--primary-brown);
    }
    </style>
    <?php
}
```

### Custom Page Templates
```php
/**
 * Add custom page template
 */
// Create file: page-custom.php
<?php
/*
Template Name: Custom Page Template
*/

get_header(); ?>

<div class="custom-page-content">
    <!-- Your custom content -->
</div>

<?php get_footer(); ?>
```

### Google Analytics Integration
```php
/**
 * Add Google Analytics (GA4)
 */
add_action('wp_head', 'add_google_analytics');
function add_google_analytics() {
    if (is_admin() || current_user_can('administrator')) {
        return; // Don't track admin users
    }
    ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GA_MEASUREMENT_ID');
    </script>
    <?php
}
```

## Testing Customizations

### Local Testing Setup
1. **WordPress Local Development**:
   - Use Local by Flywheel or XAMPP
   - Copy theme files to local installation
   - Test customizations before deployment

2. **Staging Environment**:
   - Create staging subdomain
   - Deploy customizations first to staging
   - Test all functionality before production

### Custom Function Testing
```php
/**
 * Debug custom functions
 */
add_action('wp_footer', 'debug_custom_functions');
function debug_custom_functions() {
    if (WP_DEBUG && current_user_can('administrator')) {
        echo '<div style="background: #000; color: #fff; padding: 10px;">';
        echo '<h4>Debug Information:</h4>';
        echo '<p>Services Count: ' . count(get_dental_services_data()) . '</p>';
        echo '<p>Contact Emails: ' . print_r(simple_dental_get_contact_emails(), true) . '</p>';
        echo '</div>';
    }
}
```

## Deployment

### Custom Code Deployment
1. **Plugin Approach** (Recommended):
   - Create custom plugin for site-specific modifications
   - Upload via WordPress admin or FTP
   - Activate plugin

2. **Theme Modification** (Advanced):
   - Modify theme files directly
   - Use version control to track changes
   - Deploy using existing FTP deployment script

### Version Control
```bash
# Track custom modifications
git add custom-functions.php
git commit -m "Add custom testimonials functionality"
git push origin main

# Deploy with existing script
python3 deploy-robust.py
```

## Support and Maintenance

### Documentation Updates
When adding customizations:
1. Document new functions with PHPDoc comments
2. Update this guide with new customization examples
3. Add testing procedures for new functionality
4. Update the main TECHNICAL_REFERENCE.md if needed

### Code Review Checklist
- [ ] Security: All inputs sanitized and validated
- [ ] Performance: No unnecessary database queries
- [ ] Compatibility: Works with existing theme functionality
- [ ] Standards: Follows WordPress coding standards
- [ ] Documentation: Functions are properly documented
- [ ] Testing: Functionality tested in multiple scenarios

This guide provides the foundation for extending the Simple Dental theme safely and effectively. Always test customizations thoroughly before deploying to production.