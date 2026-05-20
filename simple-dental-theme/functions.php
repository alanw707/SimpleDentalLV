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

require_once get_template_directory() . '/includes/smile-preview-contract.php';
require_once get_template_directory() . '/includes/smile-preview-provider.php';
require_once get_template_directory() . '/includes/captcha.php';
require_once get_template_directory() . '/includes/contact.php';
require_once get_template_directory() . '/includes/smile-preview-controller.php';
require_once get_template_directory() . '/includes/page-routing.php';
require_once get_template_directory() . '/includes/seo.php';
require_once get_template_directory() . '/includes/google-reviews.php';
require_once get_template_directory() . '/includes/services-catalog.php';
require_once get_template_directory() . '/includes/header-navigation.php';

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
    wp_enqueue_style('simple-dental-style', get_stylesheet_uri(), array(), '1.1.1');
    
    // Google Fonts
    wp_enqueue_style('simple-dental-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Custom JavaScript (if needed)
    wp_enqueue_script('simple-dental-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.1.0', true);
    
    // CRITICAL FIX: Re-enable navigation script for mobile menu functionality
    wp_enqueue_script('simple-dental-nav', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), '1.1.0', true);

    if (function_exists('simple_dental_is_smile_preview_request') && simple_dental_is_smile_preview_request()) {
        wp_enqueue_script('simple-dental-smile-preview', get_template_directory_uri() . '/assets/js/smile-preview.js', array(), '1.0.2', true);
        wp_localize_script('simple-dental-smile-preview', 'simpleDentalSmilePreview', simple_dental_smile_preview_contract_for_browser());
    }

}
add_action('wp_enqueue_scripts', 'simple_dental_scripts');

/**
 * One-time cache purge after theme content updates.
 */
function simple_dental_purge_cache_after_reviews_update() {
    $version = 'smile-preview-intake-2026-05-19-1';
    if (get_option('simple_dental_cache_purge_version') === $version) {
        return;
    }

    do_action('litespeed_purge_all');
    do_action('litespeed_purge_url', home_url('/'));
    do_action('litespeed_purge_url', home_url('/locale-sitemap.xml'));
    do_action('litespeed_purge_url', home_url('/sitemap_index.xml'));
    do_action('litespeed_purge_url', home_url(simple_dental_get_testimonials_path()));
    do_action('litespeed_purge_url', home_url(simple_dental_get_smile_preview_path()));

    update_option('simple_dental_cache_purge_version', $version, false);
}
add_action('wp_loaded', 'simple_dental_purge_cache_after_reviews_update', 99);

/**
 * Custom Walker for Navigation Menu
 */
// Legacy WP nav walker removed (unused); fallback menu renders inline SVG icons

/**
 * Add custom fields for services pricing
 */
// Legacy admin meta box for service pricing removed (unused)

function simple_dental_get_client_ip() {
    $ip_keys = array('HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR');

    foreach ($ip_keys as $key) {
        if (empty($_SERVER[$key])) {
            continue;
        }

        $raw_ip = sanitize_text_field(wp_unslash($_SERVER[$key]));
        $ip = trim(explode(',', $raw_ip)[0]);
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }
    }

    return '0.0.0.0';
}

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
 * Translate structured content using stable translation keys.
 */
function simple_dental_translate_structured_text($item, $field) {
    if (empty($item[$field])) {
        return '';
    }

    $key_field = $field . '_key';
    $context = !empty($item[$key_field]) ? 'key:' . $item[$key_field] : '';

    return __t($item[$field], $context);
}

/**
 * Find attachment ID by filename with a slug fallback.
 */
function simple_dental_find_attachment_id_by_filename($filename) {
    $attachment_id = 0;

    $query = new WP_Query(array(
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'meta_query'     => array(
            array(
                'key'     => '_wp_attached_file',
                'value'   => '/' . $filename,
                'compare' => 'LIKE',
            ),
        ),
    ));

    if (!empty($query->posts)) {
        $attachment_id = (int) $query->posts[0];
    }
    wp_reset_postdata();

    if (!$attachment_id) {
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        if (!empty($basename)) {
            $attachment = get_page_by_path(sanitize_title($basename), OBJECT, 'attachment');
            if ($attachment) {
                $attachment_id = (int) $attachment->ID;
            }
        }
    }

    return $attachment_id;
}

/**
 * Render media library image by filename with theme asset fallback.
 */
function simple_dental_media_image($filename, $alt, $class = '') {
    $attachment_id = simple_dental_find_attachment_id_by_filename($filename);

    if ($attachment_id) {
        $attrs = array(
            'loading'  => 'lazy',
            'decoding' => 'async',
            'alt'      => $alt,
        );
        if (!empty($class)) {
            $attrs['class'] = $class;
        }
        return wp_get_attachment_image($attachment_id, 'full', false, $attrs);
    }

    $src = get_template_directory_uri() . '/assets/images/' . $filename;
    $class_attr = !empty($class) ? ' class="' . esc_attr($class) . '"' : '';
    return '<img src="' . esc_url($src) . '" alt="' . esc_attr($alt) . '"' . $class_attr . ' loading="lazy" decoding="async" />';
}

/**
 * Return media URL by filename with theme asset fallback.
 */
function simple_dental_media_url($filename, $size = 'full') {
    $attachment_id = simple_dental_find_attachment_id_by_filename($filename);
    if ($attachment_id) {
        $url = wp_get_attachment_image_url($attachment_id, $size);
        if (!empty($url)) {
            return $url;
        }
    }

    return get_template_directory_uri() . '/assets/images/' . $filename;
}

/**
 * Load translation system
 */
require_once get_template_directory() . '/includes/translator.php';

/**
 * Ensure FAQ link appears in primary wp_nav_menu output.
 */
function simple_dental_append_faq_menu_item($items, $args) {
    if (empty($args->theme_location) || $args->theme_location !== 'primary') {
        return $items;
    }

    if (strpos($items, '/faq/') !== false) {
        return $items;
    }

    $faq_url = esc_url(simple_dental_with_lang(home_url('/faq/')));
    $items .= '<li class="menu-item menu-item-faq"><a href="' . $faq_url . '">' . esc_html(__t('FAQ')) . '</a></li>';
    return $items;
}
add_filter('wp_nav_menu_items', 'simple_dental_append_faq_menu_item', 10, 2);

/**
 * Force internal menu links to open in the same tab.
 */
function simple_dental_force_menu_self_target($atts, $item, $args, $depth) {
    if (empty($atts['href'])) {
        return $atts;
    }

    $scheme = wp_parse_url($atts['href'], PHP_URL_SCHEME);
    if ($scheme && !in_array($scheme, array('http', 'https'), true)) {
        return $atts;
    }

    $home_host = wp_parse_url(home_url('/'), PHP_URL_HOST);
    $url_host = wp_parse_url($atts['href'], PHP_URL_HOST);
    $is_relative = (!$url_host && strpos($atts['href'], '/') === 0);
    $is_same_host = ($url_host && $home_host && strtolower($url_host) === strtolower($home_host));

    if ($is_relative || $is_same_host) {
        $atts['target'] = '_self';
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'simple_dental_force_menu_self_target', 20, 4);

/**
 * Opening date and booking configuration.
 */
define('SIMPLE_DENTAL_OPENING_DATE', '2026-04-06');
define('SIMPLE_DENTAL_BOOKING_EXTERNAL_URL', 'https://dental4.me/simpledental');
define('SIMPLE_DENTAL_BOOKING_PATH', '/book-now/');

/**
 * Get the fixed opening date timestamp.
 *
 * @return int Unix timestamp of the opening date
 */
function simple_dental_get_opening_date() {
    return strtotime(SIMPLE_DENTAL_OPENING_DATE);
}

/**
 * Get the online booking URL.
 *
 * @return string
 */
function simple_dental_get_booking_url() {
    return home_url(SIMPLE_DENTAL_BOOKING_PATH);
}

/**
 * Get the external booking vendor URL.
 *
 * @return string
 */
function simple_dental_get_external_booking_url() {
    return SIMPLE_DENTAL_BOOKING_EXTERNAL_URL;
}

/**
 * Redirect friendly booking paths to the external scheduler.
 */
function simple_dental_redirect_booking_paths() {
    $request_path = isset($_SERVER['REQUEST_URI'])
        ? strtok(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])), '?')
        : '';

    $request_path = '/' . trim((string) $request_path, '/') . '/';

    if (in_array($request_path, array('/book-now/', '/booknow/'), true)) {
        wp_redirect(simple_dental_get_external_booking_url(), 302);
        exit;
    }
}
add_action('template_redirect', 'simple_dental_redirect_booking_paths', 0);

/**
 * Check whether the practice is open.
 *
 * @return bool
 */
function simple_dental_is_open() {
    return current_time('timestamp') >= simple_dental_get_opening_date();
}

/**
 * Get the current language code from the custom translator.
 *
 * @return string
 */
function simple_dental_get_current_language_code() {
    global $simple_dental_translator;

    if ($simple_dental_translator && method_exists($simple_dental_translator, 'get_current_language')) {
        return $simple_dental_translator->get_current_language();
    }

    return 'en';
}


/**
 * Get formatted opening date string for display
 *
 * Returns a full localized date string.
 *
 * @return string Formatted date string
 */
function simple_dental_get_opening_date_display() {
    $opening_date = simple_dental_get_opening_date();
    $language = simple_dental_get_current_language_code();

    $month_names = array(
        1 => __t('January'),
        2 => __t('February'),
        3 => __t('March'),
        4 => __t('April'),
        5 => __t('May'),
        6 => __t('June'),
        7 => __t('July'),
        8 => __t('August'),
        9 => __t('September'),
        10 => __t('October'),
        11 => __t('November'),
        12 => __t('December')
    );

    $month = (int) date('n', $opening_date);
    $day = (int) date('j', $opening_date);
    $year = date('Y', $opening_date);

    if ($language === 'es') {
        return $day . ' de ' . $month_names[$month] . ' de ' . $year;
    }

    if ($language === 'zh-TW' || $language === 'zh-CN') {
        return $year . '年' . $month_names[$month] . $day . '日';
    }

    return $month_names[$month] . ' ' . $day . ', ' . $year;
}

