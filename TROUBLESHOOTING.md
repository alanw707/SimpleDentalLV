# Troubleshooting Guide - Simple Dental Theme

## Table of Contents
1. [Common Issues](#common-issues)
2. [Contact Form Problems](#contact-form-problems)
3. [Email Delivery Issues](#email-delivery-issues)
4. [Display Problems](#display-problems)
5. [Performance Issues](#performance-issues)
6. [Debugging Tools](#debugging-tools)
7. [Emergency Recovery](#emergency-recovery)

## Common Issues

### Theme Not Displaying Correctly

**Symptoms**: White screen, broken layout, missing styles
**Causes**: Theme activation issues, file permissions, plugin conflicts

**Solutions**:
```bash
# 1. Check file permissions (via FTP or hosting panel)
chmod 644 *.php
chmod 644 *.css
chmod 755 assets/
chmod 644 assets/js/*.js

# 2. Verify theme files are complete
ls -la simple-dental-theme/
# Should show: functions.php, style.css, header.php, footer.php, etc.
```

**WordPress Admin Steps**:
1. **Deactivate all plugins** → Check if theme displays correctly
2. **Switch to default theme** → Reactivate Simple Dental theme
3. **Clear any caching plugins** → Test display again

### Menu Not Appearing

**Symptoms**: No navigation menu visible on frontend
**Solutions**:

1. **Check Menu Assignment**:
   - Go to `Appearance > Menus`
   - Verify "Primary Menu" is assigned to "Primary Menu" location
   - If no menu exists, create one with Home, About, Services, Contact pages

2. **Menu Fallback Issue**:
```php
// Add to functions.php if navigation fails
function simple_dental_fallback_menu() {
    echo '<ul class="primary-nav">';
    echo '<li><a href="' . home_url() . '">Home</a></li>';
    echo '<li><a href="' . home_url('/about') . '">About</a></li>';
    echo '<li><a href="' . home_url('/services') . '">Services</a></li>';
    echo '<li><a href="' . home_url('/contact') . '">Contact</a></li>';
    echo '</ul>';
}
```

### Mobile Menu Not Working

**Symptoms**: Hamburger menu doesn't open, X button doesn't close
**Solutions**:

1. **JavaScript Console Errors**:
   - Open browser developer tools (F12)
   - Check Console tab for errors
   - Common fix: Ensure jQuery is loading

2. **CSS Animation Issues**:
```css
/* Add to style.css if mobile menu isn't animating */
@media (max-width: 768px) {
    .mobile-nav {
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }
    .mobile-nav.is-open {
        transform: translateX(0);
    }
}
```

## Contact Form Problems

### Form Not Submitting

**Symptoms**: Form submission does nothing, no success/error message
**Debugging Steps**:

1. **Check Browser Console**:
```javascript
// Look for these errors in browser console:
// "Failed to load resource" - AJAX endpoint issue
// "Nonce verification failed" - Security token issue
```

2. **WordPress Debug Mode**:
```php
// Add to wp-config.php temporarily
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// Check /wp-content/debug.log for errors
```

3. **AJAX Handler Test**:
```php
// Add temporary debug function to functions.php
add_action('wp_ajax_test_contact', 'test_contact_ajax');
add_action('wp_ajax_nopriv_test_contact', 'test_contact_ajax');
function test_contact_ajax() {
    wp_send_json_success('AJAX is working!');
}

// Test by visiting: yoursite.com/wp-admin/admin-ajax.php?action=test_contact
```

### Form Submits But No Email Received

**Symptoms**: Success message appears but no email arrives
**Solutions**:

1. **Check WordPress Email Function**:
```php
// Add temporary test to functions.php
add_action('wp_footer', 'test_wp_mail');
function test_wp_mail() {
    if (current_user_can('administrator') && isset($_GET['test_email'])) {
        $result = wp_mail('your@email.com', 'Test Email', 'WordPress mail function test');
        echo $result ? 'Email sent successfully' : 'Email failed to send';
    }
}
// Visit: yoursite.com/?test_email=1
```

2. **SMTP Configuration Issue**:
   - Check `Appearance > Customize > Contact Form Settings`
   - Verify Brevo SMTP plugin is active and configured
   - Test SMTP connection in plugin settings

3. **Email Delivery Logs**:
```php
// Check email attempts (add to functions.php temporarily)
add_action('wp_mail_failed', 'log_email_errors');
function log_email_errors($wp_error) {
    error_log('Email failed: ' . $wp_error->get_error_message());
}
```

## Email Delivery Issues

### Emails Going to Spam

**Symptoms**: Contact form emails end up in spam folder
**Solutions**:

1. **SPF/DKIM Records**:
   - Contact hosting provider to set up proper email authentication
   - For Brevo SMTP, add their recommended DNS records

2. **From Address Issues**:
```php
// Ensure from address matches domain
add_filter('wp_mail_from', 'custom_wp_mail_from');
function custom_wp_mail_from($original_email_address) {
    return 'noreply@simpledentallv.com'; // Use your domain
}

add_filter('wp_mail_from_name', 'custom_wp_mail_from_name');
function custom_wp_mail_from_name($original_email_from) {
    return 'Simple Dental Website';
}
```

### Multiple Email Recipients Not Working

**Symptoms**: Only primary email receives messages, CC emails don't
**Debug Steps**:

1. **Check Email Settings**:
   - Go to `Appearance > Customize > Contact Form Settings`
   - Verify CC emails are properly formatted: `email1@domain.com, email2@domain.com`

2. **Test Email List Function**:
```php
// Add temporary debug
add_action('wp_footer', 'debug_email_settings');
function debug_email_settings() {
    if (current_user_can('administrator') && isset($_GET['debug_emails'])) {
        $settings = simple_dental_get_contact_emails();
        echo '<pre>' . print_r($settings, true) . '</pre>';
    }
}
// Visit: yoursite.com/?debug_emails=1
```

## Display Problems

### Services Not Showing

**Symptoms**: Service pricing sections empty or showing errors
**Solutions**:

1. **Shortcode Issues**:
```php
// Test shortcodes individually
echo do_shortcode('[featured_services]');
echo do_shortcode('[services_by_category]');
echo do_shortcode('[new_patient_special]');
```

2. **Service Data Function**:
```php
// Test service data retrieval
add_action('wp_footer', 'debug_services_data');
function debug_services_data() {
    if (current_user_can('administrator') && isset($_GET['debug_services'])) {
        $services = get_dental_services_data();
        echo '<pre>' . print_r($services, true) . '</pre>';
    }
}
```

### Images Not Loading

**Symptoms**: Background images missing, logos not appearing
**Solutions**:

1. **File Path Issues**:
```php
// Check image paths
echo get_template_directory_uri() . '/assets/images/';
// Should output: https://yoursite.com/wp-content/themes/simple-dental-theme/assets/images/
```

2. **Image File Permissions**:
```bash
# Set correct permissions via FTP
chmod 644 assets/images/*.jpg
chmod 644 assets/images/*.png
```

3. **CDN or Caching Issues**:
   - Clear any CDN cache
   - Check if images exist in hosting file manager
   - Try hard refresh (Ctrl+F5)

## Performance Issues

### Site Loading Slowly

**Symptoms**: Pages take >5 seconds to load
**Debugging Steps**:

1. **Check Plugin Conflicts**:
   - Deactivate all plugins except essential ones (SMTP, reCAPTCHA)
   - Test loading speed
   - Reactivate plugins one by one to identify culprit

2. **Large Image Issues**:
```bash
# Check image file sizes via FTP
ls -lh assets/images/
# Images should be <500KB each for web use
```

3. **Database Query Issues**:
```php
// Add query debugging
define('SAVEQUERIES', true);

// Add to footer temporarily
add_action('wp_footer', 'show_query_count');
function show_query_count() {
    if (current_user_can('administrator')) {
        global $wpdb;
        echo '<!-- Total queries: ' . count($wpdb->queries) . ' -->';
    }
}
```

### JavaScript Errors

**Symptoms**: Console errors, broken functionality
**Common Fixes**:

1. **jQuery Conflicts**:
```javascript
// Use jQuery no-conflict mode
jQuery(document).ready(function($) {
    // Your jQuery code here
});
```

2. **Script Loading Order**:
```php
// Ensure jQuery dependency in functions.php
wp_enqueue_script('simple-dental-script', 
    get_template_directory_uri() . '/assets/js/main.js', 
    array('jquery'), // jQuery dependency
    '1.0.0', 
    true // Load in footer
);
```

## Debugging Tools

### WordPress Debug Mode
```php
// Add to wp-config.php for detailed error reporting
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
```

### Browser Developer Tools
1. **Console Tab**: JavaScript errors and AJAX responses
2. **Network Tab**: Failed resource loads, slow requests
3. **Elements Tab**: CSS issues, missing classes

### Custom Debug Functions
```php
// Add to functions.php for debugging
function debug_simple_dental($data, $label = 'Debug') {
    if (WP_DEBUG && current_user_can('administrator')) {
        error_log($label . ': ' . print_r($data, true));
        echo '<!-- ' . $label . ': ' . print_r($data, true) . ' -->';
    }
}

// Usage examples:
debug_simple_dental($contact_form_data, 'Contact Form Data');
debug_simple_dental(get_dental_services_data(), 'Services Data');
```

### Plugin Debugging
```php
// Test specific functionality
add_action('init', 'test_theme_functions');
function test_theme_functions() {
    if (current_user_can('administrator') && isset($_GET['run_tests'])) {
        // Test contact email settings
        $emails = simple_dental_get_contact_emails();
        wp_die('<pre>' . print_r($emails, true) . '</pre>');
    }
}
// Visit: yoursite.com/?run_tests=1
```

## Emergency Recovery

### Site Down Completely

**White Screen of Death**:
1. **Via FTP**: Rename `functions.php` to `functions.php.backup`
2. **Upload basic functions.php**:
```php
<?php
// Basic functions.php for emergency recovery
function simple_dental_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'simple_dental_setup');
```
3. **Restore original functions.php** once issue is identified

### Database Issues

**Theme Settings Lost**:
```sql
-- Restore customizer settings via phpMyAdmin
SELECT * FROM wp_options WHERE option_name LIKE 'theme_mod_%';

-- Reset to defaults if corrupted
DELETE FROM wp_options WHERE option_name LIKE 'theme_mod_%';
```

### Plugin Conflicts

**Mass Plugin Deactivation**:
```php
// Add to wp-config.php temporarily
define('WP_DEBUG', true);

// Or rename plugins folder via FTP
mv /wp-content/plugins /wp-content/plugins-disabled
```

## Support Escalation

### Before Contacting Support

**Gather This Information**:
1. **WordPress Version**: `Dashboard > Updates`
2. **Theme Version**: Check `style.css` header
3. **Active Plugins**: `Plugins > Installed Plugins`
4. **Error Messages**: Copy exact text from console/logs
5. **Browser/Device**: What browser and version experiencing issue
6. **Steps to Reproduce**: Detailed steps that cause the problem

### Log Files to Check

1. **WordPress Debug Log**: `/wp-content/debug.log`
2. **Server Error Log**: Usually in hosting control panel
3. **Browser Console**: Developer tools console tab

### Emergency Contacts

- **WordPress Support**: WordPress.org support forums
- **Hosting Support**: Contact Hostinger support for server issues
- **Theme Developer**: Use project documentation for guidance

### Recovery Checklist

- [ ] Backup created before troubleshooting
- [ ] WordPress and plugins updated
- [ ] Debug mode enabled
- [ ] Error logs checked
- [ ] Browser cache cleared
- [ ] Plugin conflicts ruled out
- [ ] File permissions verified
- [ ] Database connection confirmed

This troubleshooting guide covers the most common issues encountered with the Simple Dental theme. Always create backups before making changes, and test fixes in a staging environment when possible.