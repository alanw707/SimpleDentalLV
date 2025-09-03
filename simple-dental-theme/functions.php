<?php
/**
 * Simple Dental Theme Functions
 * 
 * Theme functions and definitions for Simple Dental WordPress theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function simple_dental_setup() {
    // Add theme support for various WordPress features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'simple-dental'),
        'footer'  => __('Footer Menu', 'simple-dental'),
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'simple_dental_setup');

/**
 * Add Favicon Support
 */
function simple_dental_favicon() {
    // Get site icon URL, fallback to default location
    $favicon_url = get_site_icon_url();
    if (empty($favicon_url)) {
        $favicon_url = get_template_directory_uri() . '/favicon.ico';
    }
    
    echo '<link rel="icon" type="image/x-icon" href="' . esc_url($favicon_url) . '">';
    echo '<link rel="shortcut icon" href="' . esc_url($favicon_url) . '">';
    
    // Apple touch icon
    $apple_icon = get_site_icon_url(180);
    if (!empty($apple_icon)) {
        echo '<link rel="apple-touch-icon" href="' . esc_url($apple_icon) . '">';
    }
}
add_action('wp_head', 'simple_dental_favicon');

/**
 * Enqueue Styles and Scripts
 */
function simple_dental_scripts() {
    // Main theme stylesheet
    wp_enqueue_style('simple-dental-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Google Fonts
    wp_enqueue_style('simple-dental-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Custom JavaScript (if needed)
    wp_enqueue_script('simple-dental-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // CRITICAL FIX: Re-enable navigation script for mobile menu functionality
    wp_enqueue_script('simple-dental-nav', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'simple_dental_scripts');

/**
 * Custom Walker for Navigation Menu
 */
class Simple_Dental_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Find icon class
        $icon_class = '';
        foreach ($classes as $class) {
            if (strpos($class, 'icon-') === 0) {
                $icon_class = str_replace('icon-', '', $class);
                break;
            }
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';

        // Icons are handled by inline SVG in fallback menu

        $item_output .= '<span class="menu-text">' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
        $item_output .= (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// Feather Icons removed - using inline SVG icons instead

/**
 * Add custom fields for services pricing
 */
function simple_dental_add_service_meta_boxes() {
    add_meta_box(
        'service-pricing',
        'Service Pricing',
        'simple_dental_service_pricing_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'simple_dental_add_service_meta_boxes');

function simple_dental_service_pricing_callback($post) {
    wp_nonce_field('simple_dental_save_service_pricing', 'simple_dental_service_pricing_nonce');
    
    $services = get_post_meta($post->ID, '_simple_dental_services', true);
    
    echo '<table class="form-table">';
    echo '<tr><th>Service Name</th><th>Price</th><th>Description</th></tr>';
    
    $default_services = array(
        array('name' => 'Exam & Cleaning', 'price' => '$189', 'description' => 'Comprehensive dental exam and professional cleaning'),
        array('name' => 'Deep Cleaning', 'price' => '$225 per quad', 'description' => 'Deep scaling and root planing treatment'),
        array('name' => 'Same-Day Crown', 'price' => '$899', 'description' => 'Complete crown restoration in one visit'),
        array('name' => 'Extraction', 'price' => '$220', 'description' => 'Simple tooth extraction procedure'),
        array('name' => 'Root Canal', 'price' => '$850', 'description' => 'Root canal therapy treatment'),
    );
    
    if (empty($services)) {
        $services = $default_services;
    }
    
    foreach ($services as $index => $service) {
        echo '<tr>';
        echo '<td><input type="text" name="service_name[]" value="' . esc_attr($service['name']) . '" style="width:100%;" /></td>';
        echo '<td><input type="text" name="service_price[]" value="' . esc_attr($service['price']) . '" style="width:100%;" /></td>';
        echo '<td><input type="text" name="service_description[]" value="' . esc_attr($service['description']) . '" style="width:100%;" /></td>';
        echo '</tr>';
    }
    
    echo '</table>';
    echo '<p><strong>Note:</strong> These services will display on your Services page with transparent pricing.</p>';
}

function simple_dental_save_service_pricing($post_id) {
    if (!isset($_POST['simple_dental_service_pricing_nonce']) || 
        !wp_verify_nonce($_POST['simple_dental_service_pricing_nonce'], 'simple_dental_save_service_pricing')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['service_name']) && isset($_POST['service_price']) && isset($_POST['service_description'])) {
        $services = array();
        $names = $_POST['service_name'];
        $prices = $_POST['service_price'];
        $descriptions = $_POST['service_description'];
        
        for ($i = 0; $i < count($names); $i++) {
            if (!empty($names[$i])) {
                $services[] = array(
                    'name' => sanitize_text_field($names[$i]),
                    'price' => sanitize_text_field($prices[$i]),
                    'description' => sanitize_text_field($descriptions[$i])
                );
            }
        }
        
        update_post_meta($post_id, '_simple_dental_services', $services);
    }
}
add_action('save_post', 'simple_dental_save_service_pricing');

/**
 * Add SEO meta tags
 */
function simple_dental_add_seo_meta() {
    if (is_front_page()) {
        echo '<meta name="description" content="Simple Dental - Honest same-day dentistry in Las Vegas. Transparent pricing, no pressure, experienced doctor. Located at 204 S Jones Blvd. Opening September 2025.">' . "\n";
        echo '<meta name="keywords" content="dentist las vegas, dental care, same day crowns, transparent pricing, no pressure dentistry, jones boulevard">' . "\n";
    }
    
    // Local business schema markup
    if (is_front_page() || is_page('contact')) {
        echo '<script type="application/ld+json">';
        echo json_encode(array(
            "@context" => "https://schema.org",
            "@type" => "DentalClinic",
            "name" => "Simple Dental",
            "description" => "Honest same-day dentistry with transparent pricing and no pressure",
            "address" => array(
                "@type" => "PostalAddress",
                "streetAddress" => "204 S Jones Blvd",
                "addressLocality" => "Las Vegas",
                "addressRegion" => "NV",
                "postalCode" => "89149",
                "addressCountry" => "US"
            ),
            "telephone" => "(702) 302-4787",
            "openingHours" => "Mo-Fr 08:00-16:00",
            "priceRange" => "$$"
        ));
        echo '</script>' . "\n";
    }
}
add_action('wp_head', 'simple_dental_add_seo_meta');

/**
 * Custom excerpt length
 */
function simple_dental_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'simple_dental_excerpt_length');

/**
 * Custom excerpt more
 */
function simple_dental_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'simple_dental_excerpt_more');

/**
 * Remove unnecessary WordPress features for performance
 */
function simple_dental_remove_wp_features() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove wlwmanifest link
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Remove feed links
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
}
add_action('init', 'simple_dental_remove_wp_features');

/**
 * Disable comments site-wide (dental practice doesn't need comments)
 */
function simple_dental_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'simple_dental_disable_comments_status', 20, 2);
add_filter('pings_open', 'simple_dental_disable_comments_status', 20, 2);

/**
 * Hide comments from admin menu
 */
function simple_dental_remove_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'simple_dental_remove_comments_admin_menu');

/**
 * AJAX handler for contact form submission
 */
function simple_dental_ajax_contact_form() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['contact_form_nonce'], 'simple_dental_contact_nonce')) {
        wp_die(json_encode(array('success' => false, 'message' => 'Security verification failed. Please refresh and try again.')));
    }
    
    $errors = array();
    
    // Sanitize input data
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    
    // Validate required fields
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (empty($email) || !is_email($email)) {
        $errors[] = 'Valid email is required.';
    }
    if (empty($message)) {
        $errors[] = 'Message is required.';
    }
    
    // Verify reCAPTCHA if available
    if (function_exists('anr_verify_captcha')) {
        if (!anr_verify_captcha()) {
            $errors[] = 'Please complete the CAPTCHA verification.';
        }
    }
    
    // If validation errors, return them
    if (!empty($errors)) {
        wp_die(json_encode(array('success' => false, 'errors' => $errors)));
    }
    
    // Get custom email settings
    $email_settings = simple_dental_get_contact_emails();
    
    // Check if notifications are enabled
    if (!$email_settings['notifications_enabled']) {
        error_log('Simple Dental Contact Form AJAX - Email notifications disabled');
        wp_die(json_encode(array('success' => true, 'message' => 'Thank you! Your message has been received. We\'ll get back to you within 24 hours.')));
    }
    
    // Prepare email recipients
    $to = $email_settings['primary'];
    $cc_emails = $email_settings['cc'];
    
    error_log('Simple Dental Contact Form AJAX - Sending to: ' . $to . (empty($cc_emails) ? '' : ' (CC: ' . implode(', ', $cc_emails) . ')'));
    
    // Prepare email subject with custom prefix
    $subject_prefix = $email_settings['subject_prefix'];
    $subject = $subject_prefix . ' Contact Form Submission';
    
    // Prepare email body
    $body = "New contact form submission from Simple Dental website:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n\n";
    $body .= "Message:\n$message\n\n";
    $body .= "---\n";
    $body .= "Submitted: " . date('Y-m-d H:i:s') . "\n";
    $body .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    // Prepare email headers
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Simple Dental Website <' . $to . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Add CC headers if CC emails are specified
    if (!empty($cc_emails)) {
        foreach ($cc_emails as $cc_email) {
            $headers[] = 'Cc: ' . $cc_email;
        }
    }
    
    // Attempt to send email
    $mail_sent = wp_mail($to, $subject, $body, $headers);
    
    if ($mail_sent) {
        error_log('Simple Dental Contact Form AJAX - Email sent successfully');
        wp_die(json_encode(array('success' => true, 'message' => 'Thank you! Your message has been sent successfully. We\'ll get back to you within 24 hours.')));
    } else {
        error_log('Simple Dental Contact Form AJAX - Email failed to send to: ' . $to);
        // Provide helpful error message with contact alternatives
        $error_message = 'Sorry, there was an error sending your message. Please try one of these alternatives:';
        $error_message .= '\n• Call us directly at (702) 302-4787';
        $error_message .= '\n• Email us at ' . $to;
        if (!empty($cc_emails)) {
            $error_message .= ' or ' . implode(', ', $cc_emails);
        }
        wp_die(json_encode(array('success' => false, 'message' => $error_message)));
    }
}
add_action('wp_ajax_simple_dental_contact', 'simple_dental_ajax_contact_form');
add_action('wp_ajax_nopriv_simple_dental_contact', 'simple_dental_ajax_contact_form');

/**
 * Contact form shortcode (enhanced with AJAX and CAPTCHA)
 */
function simple_dental_contact_form() {
    ob_start();
    ?>
    <div id="contact-form-messages"></div>
    
    <form id="simple-contact-form" class="simple-contact-form">
        <?php wp_nonce_field('simple_dental_contact_nonce', 'contact_form_nonce'); ?>
        
        <div class="form-row">
            <input type="text" name="contact_name" id="contact_name" placeholder="Your Name*" required>
            <input type="email" name="contact_email" id="contact_email" placeholder="Your Email*" required>
        </div>
        
        <div class="form-row">
            <input type="tel" name="contact_phone" id="contact_phone" placeholder="Your Phone Number">
        </div>
        
        <div class="form-row">
            <textarea name="contact_message" id="contact_message" placeholder="Your Message*" rows="5" required></textarea>
        </div>
        
        <?php if (function_exists('anr_captcha_form_field')) : ?>
        <div class="form-row captcha-row">
            <?php anr_captcha_form_field(); ?>
        </div>
        <?php endif; ?>
        
        <div class="form-row">
            <button type="submit" id="contact-submit-btn" class="btn btn-primary">
                <span class="btn-text">Send Message</span>
                <span class="btn-loading" style="display: none;">Sending...</span>
            </button>
        </div>
        
        <div class="form-row form-note">
            <small><strong>*</strong> Required fields | We respect your privacy and will never share your information.</small>
        </div>
    </form>
    
    <script>
    jQuery(document).ready(function($) {
        $('#simple-contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var submitBtn = $('#contact-submit-btn');
            var btnText = submitBtn.find('.btn-text');
            var btnLoading = submitBtn.find('.btn-loading');
            var messagesDiv = $('#contact-form-messages');
            
            // Show loading state
            submitBtn.prop('disabled', true);
            btnText.hide();
            btnLoading.show();
            messagesDiv.empty();
            
            // Collect form data
            var formData = {
                action: 'simple_dental_contact',
                contact_name: $('#contact_name').val(),
                contact_email: $('#contact_email').val(),
                contact_phone: $('#contact_phone').val(),
                contact_message: $('#contact_message').val(),
                contact_form_nonce: $('input[name="contact_form_nonce"]').val()
            };
            
            // Add reCAPTCHA response if available
            if (typeof grecaptcha !== 'undefined') {
                var captchaResponse = grecaptcha.getResponse();
                if (captchaResponse) {
                    formData['g-recaptcha-response'] = captchaResponse;
                }
            }
            
            // Submit via AJAX
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        messagesDiv.html('<div class="contact-success">✅ <strong>Thank you!</strong> ' + response.message + '</div>');
                        // Reset form
                        $('#simple-contact-form')[0].reset();
                        // Reset reCAPTCHA if available
                        if (typeof grecaptcha !== 'undefined') {
                            grecaptcha.reset();
                        }
                        // Scroll to success message
                        $('html, body').animate({
                            scrollTop: messagesDiv.offset().top - 100
                        }, 500);
                    } else {
                        // Show error message(s)
                        var errorHtml = '<div class="contact-error">';
                        if (response.errors && response.errors.length > 0) {
                            errorHtml += '<strong>Please correct the following:</strong><ul>';
                            response.errors.forEach(function(error) {
                                errorHtml += '<li>' + error + '</li>';
                            });
                            errorHtml += '</ul>';
                        } else {
                            errorHtml += response.message || 'An error occurred. Please try again.';
                        }
                        errorHtml += '</div>';
                        messagesDiv.html(errorHtml);
                        
                        // Scroll to error message
                        $('html, body').animate({
                            scrollTop: messagesDiv.offset().top - 100
                        }, 500);
                    }
                },
                error: function() {
                    messagesDiv.html('<div class="contact-error">Connection error. Please try again or call us directly at (702) 302-4787.</div>');
                },
                complete: function() {
                    // Reset button state
                    submitBtn.prop('disabled', false);
                    btnText.show();
                    btnLoading.hide();
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('simple_dental_contact', 'simple_dental_contact_form');

/**
 * Get comprehensive service data
 */
function get_dental_services_data() {
    return array(
        'preventive' => array(
            'title' => 'Preventive & Diagnostic',
            'services' => array(
                array('name' => 'New Patient Exam + X-rays', 'price' => '$149', 'description' => 'Comprehensive initial examination with digital X-rays'),
                array('name' => 'Routine Exam + 4 X-rays', 'price' => '$149', 'description' => 'Regular checkup with limited X-ray series'),
                array('name' => 'Adult Cleaning', 'price' => '$150', 'description' => 'Professional teeth cleaning and polishing'),
                array('name' => 'Deep Cleaning (per quadrant)', 'price' => '$225', 'description' => 'Deep scaling and root planing treatment'),
                array('name' => 'Fluoride Treatment', 'price' => '$39', 'description' => 'Professional fluoride application for cavity prevention'),
            )
        ),
        'restorative' => array(
            'title' => 'Restorative Dentistry',
            'services' => array(
                array('name' => 'Tooth-Colored Filling', 'price' => '$180-250', 'description' => 'Composite fillings depending on surfaces treated'),
                array('name' => 'Same-Day Crown (Ceramic)', 'price' => '$899', 'description' => 'Complete crown restoration in one visit'),
                array('name' => 'Core Buildup (if needed)', 'price' => '$150', 'description' => 'Foundation preparation for crown placement'),
            )
        ),
        'extraction' => array(
            'title' => 'Tooth Removal',
            'services' => array(
                array('name' => 'Simple Extraction', 'price' => '$180', 'description' => 'Routine tooth removal procedure'),
                array('name' => 'Surgical Extraction', 'price' => '$280', 'description' => 'Complex tooth removal requiring surgical technique'),
            )
        ),
        'endodontics' => array(
            'title' => 'Root Canals',
            'services' => array(
                array('name' => 'Front Tooth', 'price' => '$650', 'description' => 'Root canal therapy for anterior teeth'),
                array('name' => 'Premolar', 'price' => '$800', 'description' => 'Root canal therapy for bicuspid teeth'),
                array('name' => 'Molar', 'price' => '$1000', 'description' => 'Root canal therapy for back teeth'),
            )
        ),
        'prosthetics' => array(
            'title' => 'Dentures & Partials',
            'services' => array(
                array('name' => 'Full Denture (per arch)', 'price' => '$2000', 'description' => 'Complete denture for upper or lower jaw'),
                array('name' => 'Partial Denture', 'price' => '$1600', 'description' => 'Removable partial denture to replace missing teeth'),
                array('name' => 'Denture Reline', 'price' => '$250', 'description' => 'Adjusting denture fit for comfort'),
            )
        ),
        'other' => array(
            'title' => 'Other Services',
            'services' => array(
                array('name' => 'Night Guard', 'price' => '$365', 'description' => 'Custom-made night guard for teeth grinding protection'),
                array('name' => 'Retainers (per arch)', 'price' => '$200', 'description' => 'Custom retainers for maintaining tooth position'),
            )
        )
    );
}

/**
 * Featured services for homepage (top 6)
 */
function featured_services_display($atts) {
    $featured = array(
        array('name' => 'New Patient Exam + X-rays', 'price' => '$149', 'description' => 'Comprehensive initial examination with digital X-rays'),
        array('name' => 'Adult Cleaning', 'price' => '$150', 'description' => 'Professional teeth cleaning and polishing'),
        array('name' => 'Tooth-Colored Filling', 'price' => '$180-250', 'description' => 'Composite fillings depending on surfaces treated'),
        array('name' => 'Same-Day Crown (Ceramic)', 'price' => '$899', 'description' => 'Complete crown restoration in one visit'),
        array('name' => 'Simple Extraction', 'price' => '$180', 'description' => 'Routine tooth removal procedure'),
        array('name' => 'Front Tooth Root Canal', 'price' => '$650', 'description' => 'Root canal therapy for anterior teeth'),
    );
    
    ob_start();
    echo '<div class="services-grid">';
    foreach ($featured as $service) {
        echo '<div class="service-card">';
        echo '<h3 class="service-title">' . esc_html($service['name']) . '</h3>';
        echo '<div class="service-price">' . esc_html($service['price']) . '</div>';
        echo '<p class="service-description">' . esc_html($service['description']) . '</p>';
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('featured_services', 'featured_services_display');

/**
 * New Patient Special callout
 */
function new_patient_special_display($atts) {
    ob_start();
    ?>
    <div class="new-patient-special">
        <div class="special-badge">New Patient Special</div>
        <h3>Complete Checkup & Cleaning</h3>
        <div class="special-price">$199</div>
        <p>Comprehensive exam, professional cleaning, and peace of mind for new patients</p>
        <div class="special-features">
            <span class="feature">✓ Full Examination</span>
            <span class="feature">✓ Professional Cleaning</span>
            <span class="feature">✓ X-rays if needed</span>
        </div>
        <a href="tel:7023024787" class="btn btn-coral">Book Your Visit</a>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('new_patient_special', 'new_patient_special_display');

/**
 * Services by category for full services page
 */
function services_by_category_display($atts) {
    $services_data = get_dental_services_data();
    
    ob_start();
    echo '<div class="services-by-category">';
    
    foreach ($services_data as $category_key => $category) {
        echo '<div class="service-category" data-category="' . esc_attr($category_key) . '">';
        echo '<h3 class="category-title">' . esc_html($category['title']) . '</h3>';
        echo '<div class="services-grid category-grid">';
        
        foreach ($category['services'] as $service) {
            echo '<div class="service-card category-card">';
            echo '<h4 class="service-title">' . esc_html($service['name']) . '</h4>';
            echo '<div class="service-price">' . esc_html($service['price']) . '</div>';
            echo '<p class="service-description">' . esc_html($service['description']) . '</p>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('services_by_category', 'services_by_category_display');

/**
 * Legacy services display shortcode (for backward compatibility)
 */
function simple_dental_services_display($atts) {
    // Use featured services for existing shortcode
    return featured_services_display($atts);
}
add_shortcode('simple_dental_services', 'simple_dental_services_display');

/**
 * WordPress Customizer Settings for Contact Form
 */
function simple_dental_customizer_settings($wp_customize) {
    // Add Contact Form Settings Section
    $current_settings = simple_dental_get_contact_emails();
    $settings_info = 'Current settings: Primary email: ' . $current_settings['primary'];
    if (!empty($current_settings['cc'])) {
        $settings_info .= ' | CC: ' . implode(', ', $current_settings['cc']);
    }
    $settings_info .= ' | Subject prefix: ' . $current_settings['subject_prefix'];
    
    $wp_customize->add_section('simple_dental_contact_settings', array(
        'title' => 'Contact Form Settings',
        'description' => 'Configure email settings for contact form submissions. ' . $settings_info,
        'priority' => 30,
    ));
    
    // Primary Contact Email Setting
    $wp_customize->add_setting('contact_form_primary_email', array(
        'default' => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_primary_email', array(
        'label' => 'Primary Contact Email',
        'description' => 'Main email address to receive contact form submissions. Defaults to WordPress admin email.',
        'section' => 'simple_dental_contact_settings',
        'type' => 'email',
        'priority' => 10,
    ));
    
    // Additional CC Emails Setting
    $wp_customize->add_setting('contact_form_cc_emails', array(
        'default' => '',
        'sanitize_callback' => 'simple_dental_sanitize_email_list',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_cc_emails', array(
        'label' => 'Additional Recipients (CC)',
        'description' => 'Additional email addresses to CC on contact forms. Separate multiple emails with commas. Example: email1@domain.com, email2@domain.com',
        'section' => 'simple_dental_contact_settings',
        'type' => 'textarea',
        'priority' => 20,
    ));
    
    // Email Subject Prefix Setting
    $wp_customize->add_setting('contact_form_subject_prefix', array(
        'default' => '[Simple Dental Website]',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_subject_prefix', array(
        'label' => 'Email Subject Prefix',
        'description' => 'Text to prepend to contact form email subjects. Helps identify website emails.',
        'section' => 'simple_dental_contact_settings',
        'type' => 'text',
        'priority' => 30,
    ));
    
    // Email Notifications Toggle
    $wp_customize->add_setting('contact_form_notifications_enabled', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_notifications_enabled', array(
        'label' => 'Enable Email Notifications',
        'description' => 'Turn on/off email notifications for contact form submissions.',
        'section' => 'simple_dental_contact_settings',
        'type' => 'checkbox',
        'priority' => 40,
    ));
}
add_action('customize_register', 'simple_dental_customizer_settings');

/**
 * Load translation system
 */
require_once get_template_directory() . '/includes/translator.php';

/**
 * Sanitize email list (comma-separated emails)
 */
function simple_dental_sanitize_email_list($input) {
    if (empty($input)) {
        return '';
    }
    
    // Split by comma and sanitize each email
    $emails = array_map('trim', explode(',', $input));
    $valid_emails = array();
    
    foreach ($emails as $email) {
        $sanitized_email = sanitize_email($email);
        if (!empty($sanitized_email) && is_email($sanitized_email)) {
            $valid_emails[] = $sanitized_email;
        }
    }
    
    return implode(', ', $valid_emails);
}

/**
 * Get contact form email settings with fallbacks
 */
function simple_dental_get_contact_emails() {
    $primary_email = get_theme_mod('contact_form_primary_email', get_option('admin_email'));
    $cc_emails = get_theme_mod('contact_form_cc_emails', '');
    
    // Validate primary email
    if (empty($primary_email) || !is_email($primary_email)) {
        $primary_email = get_option('admin_email');
        error_log('Simple Dental Contact Form - Invalid primary email, using admin email: ' . $primary_email);
    }
    
    // Process CC emails
    $cc_email_array = array();
    if (!empty($cc_emails)) {
        $cc_emails_list = array_map('trim', explode(',', $cc_emails));
        foreach ($cc_emails_list as $email) {
            if (!empty($email) && is_email($email)) {
                $cc_email_array[] = $email;
            }
        }
    }
    
    return array(
        'primary' => $primary_email,
        'cc' => $cc_email_array,
        'subject_prefix' => get_theme_mod('contact_form_subject_prefix', '[Simple Dental Website]'),
        'notifications_enabled' => get_theme_mod('contact_form_notifications_enabled', true)
    );
}

?>