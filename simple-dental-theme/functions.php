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
    
    // Responsive navigation script for mobile - DISABLED to prevent conflicts
    // wp_enqueue_script('simple-dental-nav', get_template_directory_uri() . '/assets/js/navigation.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'simple_dental_scripts');

/**
 * Custom Walker for Navigation Menu
 */
class Simple_Dental_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
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
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

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
 * Contact form shortcode (simple contact form)
 */
function simple_dental_contact_form() {
    if ($_POST['simple_dental_contact_submit']) {
        $name = sanitize_text_field($_POST['contact_name']);
        $email = sanitize_email($_POST['contact_email']);
        $phone = sanitize_text_field($_POST['contact_phone']);
        $message = sanitize_textarea_field($_POST['contact_message']);
        
        $to = get_option('admin_email');
        $subject = 'New Contact Form Submission - Simple Dental';
        $body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        if (wp_mail($to, $subject, $body, $headers)) {
            echo '<div class="contact-success">Thank you! Your message has been sent. We\'ll get back to you soon.</div>';
        } else {
            echo '<div class="contact-error">Sorry, there was an error sending your message. Please call us directly at (702) 302-4787.</div>';
        }
    }
    
    ob_start();
    ?>
    <form method="post" class="simple-contact-form">
        <div class="form-row">
            <input type="text" name="contact_name" placeholder="Your Name" required>
            <input type="email" name="contact_email" placeholder="Your Email" required>
        </div>
        <div class="form-row">
            <input type="tel" name="contact_phone" placeholder="Your Phone Number">
        </div>
        <div class="form-row">
            <textarea name="contact_message" placeholder="Your Message" rows="5" required></textarea>
        </div>
        <div class="form-row">
            <button type="submit" name="simple_dental_contact_submit" class="btn btn-primary">Send Message</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('simple_dental_contact', 'simple_dental_contact_form');

/**
 * Services display shortcode
 */
function simple_dental_services_display($atts) {
    $page_id = get_the_ID();
    $services = get_post_meta($page_id, '_simple_dental_services', true);
    
    if (empty($services)) {
        // Default services if none set
        $services = array(
            array('name' => 'Exam & Cleaning', 'price' => '$189', 'description' => 'Comprehensive dental exam and professional cleaning'),
            array('name' => 'Deep Cleaning', 'price' => '$225 per quad', 'description' => 'Deep scaling and root planing treatment'),
            array('name' => 'Same-Day Crown', 'price' => '$899', 'description' => 'Complete crown restoration in one visit'),
            array('name' => 'Extraction', 'price' => '$220', 'description' => 'Simple tooth extraction procedure'),
            array('name' => 'Root Canal', 'price' => '$850', 'description' => 'Root canal therapy treatment'),
        );
    }
    
    ob_start();
    echo '<div class="services-grid">';
    foreach ($services as $service) {
        echo '<div class="service-card">';
        echo '<h3 class="service-title">' . esc_html($service['name']) . '</h3>';
        echo '<div class="service-price">' . esc_html($service['price']) . '</div>';
        echo '<p class="service-description">' . esc_html($service['description']) . '</p>';
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('simple_dental_services', 'simple_dental_services_display');
?>