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
    wp_enqueue_style('simple-dental-style', get_stylesheet_uri(), array(), '1.1.0');
    
    // Google Fonts
    wp_enqueue_style('simple-dental-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Custom JavaScript (if needed)
    wp_enqueue_script('simple-dental-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.1.0', true);
    
    // CRITICAL FIX: Re-enable navigation script for mobile menu functionality
    wp_enqueue_script('simple-dental-nav', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), '1.1.0', true);

}
add_action('wp_enqueue_scripts', 'simple_dental_scripts');

/**
 * Custom Walker for Navigation Menu
 */
// Legacy WP nav walker removed (unused); fallback menu renders inline SVG icons

/**
 * Add custom fields for services pricing
 */
// Legacy admin meta box for service pricing removed (unused)

/**
 * Same-day crowns landing page routing.
 */
function simple_dental_get_same_day_crowns_path() {
    return '/same-day-crowns-las-vegas/';
}

function simple_dental_get_testimonials_path() {
    return '/testimonials/';
}

function simple_dental_get_normalized_request_path() {
    $request_path = isset($_SERVER['REQUEST_URI'])
        ? strtok(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])), '?')
        : '';

    $request_path = simple_dental_strip_language_prefix_from_path((string) $request_path);
    return '/' . trim($request_path, '/') . '/';
}

function simple_dental_is_same_day_crowns_request() {
    return simple_dental_get_normalized_request_path() === simple_dental_get_same_day_crowns_path();
}

function simple_dental_render_same_day_crowns_page() {
    if (!simple_dental_is_same_day_crowns_request()) {
        return;
    }

    status_header(200);
    global $wp_query;
    if ($wp_query) {
        $wp_query->is_404 = false;
    }

    include get_template_directory() . '/page-same-day-crowns.php';
    exit;
}
add_action('template_redirect', 'simple_dental_render_same_day_crowns_page', 1);

function simple_dental_is_testimonials_request() {
    return simple_dental_get_normalized_request_path() === simple_dental_get_testimonials_path();
}

function simple_dental_render_testimonials_page() {
    if (!simple_dental_is_testimonials_request()) {
        return;
    }

    status_header(200);
    global $wp_query;
    if ($wp_query) {
        $wp_query->is_404 = false;
    }

    include get_template_directory() . '/page-testimonials.php';
    exit;
}
add_action('template_redirect', 'simple_dental_render_testimonials_page', 1);

/**
 * SEO titles, metadata, and structured data.
 */
function simple_dental_get_seo_data() {
    $default = array(
        'title' => 'Las Vegas Dentist | Simple Dental',
        'description' => 'Simple Dental is a Las Vegas dentist offering honest, no-pressure dental care, transparent pricing, same-day crowns, cleanings, root canals, and phone-first scheduling.',
        'image' => simple_dental_media_url('hero-home-reception-wide.jpg', 'large'),
        'robots' => 'index,follow',
    );

    if (is_front_page()) {
        return array_merge($default, array(
            'description' => 'Looking for a Las Vegas dentist? Simple Dental offers honest, no-pressure dental care with transparent pricing, same-day crowns, cleanings, and root canals for Las Vegas and North Las Vegas patients.',
        ));
    }

    if (simple_dental_is_same_day_crowns_request()) {
        return array_merge($default, array(
            'title' => 'Same-Day Crowns Las Vegas | $899 Crowns | Simple Dental',
            'description' => 'Same-day crowns in Las Vegas at Simple Dental. Permanent ceramic crowns designed, milled, and placed in one visit with transparent $899 pricing when appropriate.',
            'image' => simple_dental_media_url('services-tech-lab-milling.jpg', 'large'),
        ));
    }

    if (simple_dental_is_testimonials_request()) {
        return array_merge($default, array(
            'title' => 'Patient Reviews | Simple Dental Las Vegas',
            'description' => 'Read patient reviews for Simple Dental in Las Vegas. Patients choose us for honest, no-pressure dental care, transparent pricing, and one experienced dentist.',
            'image' => simple_dental_media_url('hero-home-reception-wide.jpg', 'large'),
        ));
    }

    if (is_page('services')) {
        return array_merge($default, array(
            'title' => 'Dental Services & Transparent Pricing | Simple Dental Las Vegas',
            'description' => 'See Simple Dental services and pricing in Las Vegas, including same-day crowns, dental cleanings, fillings, root canals, extractions, dentures, night guards, and retainers.',
            'image' => simple_dental_media_url('hero-services-operatory.jpg', 'large'),
        ));
    }

    if (is_page('about')) {
        return array_merge($default, array(
            'title' => 'About Dr. Charles Chang | Simple Dental Las Vegas',
            'description' => 'Meet Dr. Charles Chang, a Las Vegas dentist with 15+ years of experience and advanced training in implants, oral surgery, endodontics, and same-day crowns.',
            'image' => simple_dental_media_url('Charles-Portrait-1.jpg', 'large'),
        ));
    }

    if (is_page('contact')) {
        return array_merge($default, array(
            'title' => 'Call Simple Dental | Las Vegas Dentist Contact',
            'description' => 'Call Simple Dental at (702) 302-4787 or book online. Visit our Las Vegas dental office at 204 S Jones Blvd, serving Las Vegas and North Las Vegas patients.',
            'image' => simple_dental_media_url('hero-contact-waiting-area.jpg', 'large'),
        ));
    }

    if (is_page('faq')) {
        return array_merge($default, array(
            'title' => 'Las Vegas Dentist FAQ | Simple Dental',
            'description' => 'Answers about Simple Dental in Las Vegas, including same-day crowns, transparent pricing, PPO insurance, cash patients, location, parking, and scheduling.',
            'image' => simple_dental_media_url('hero-default-front-desk.jpg', 'large'),
        ));
    }

    if (is_page('hipaa-policy')) {
        return array_merge($default, array(
            'title' => 'HIPAA Privacy Policy | Simple Dental',
            'description' => 'Simple Dental HIPAA privacy policy and patient information practices.',
            'robots' => 'noindex,follow',
        ));
    }

    if (is_page()) {
        $page_title = single_post_title('', false);
        return array_merge($default, array(
            'title' => $page_title . ' | Simple Dental Las Vegas',
        ));
    }

    return $default;
}

function simple_dental_is_rank_math_active() {
    return defined('RANK_MATH_VERSION') || class_exists('RankMath');
}

function simple_dental_document_title($title) {
    if (is_admin() || is_feed()) {
        return $title;
    }

    $seo = simple_dental_get_seo_data();
    return !empty($seo['title']) ? $seo['title'] : $title;
}
add_filter('pre_get_document_title', 'simple_dental_document_title');

function simple_dental_rank_math_title($title) {
    $seo = simple_dental_get_seo_data();
    return !empty($seo['title']) ? $seo['title'] : $title;
}
add_filter('rank_math/frontend/title', 'simple_dental_rank_math_title', 20);
add_filter('rank_math/opengraph/facebook/title', 'simple_dental_rank_math_title', 20);
add_filter('rank_math/opengraph/twitter/title', 'simple_dental_rank_math_title', 20);

function simple_dental_rank_math_description($description) {
    $seo = simple_dental_get_seo_data();
    return !empty($seo['description']) ? $seo['description'] : $description;
}
add_filter('rank_math/frontend/description', 'simple_dental_rank_math_description', 20);
add_filter('rank_math/opengraph/facebook/description', 'simple_dental_rank_math_description', 20);
add_filter('rank_math/opengraph/twitter/description', 'simple_dental_rank_math_description', 20);

function simple_dental_rank_math_robots($robots) {
    $seo = simple_dental_get_seo_data();

    if (!empty($seo['robots']) && $seo['robots'] === 'noindex,follow') {
        return array(
            'index' => 'noindex',
            'follow' => 'follow',
        );
    }

    return $robots;
}
add_filter('rank_math/frontend/robots', 'simple_dental_rank_math_robots', 20);

function simple_dental_rank_math_og_image($image) {
    $seo = simple_dental_get_seo_data();
    return !empty($seo['image']) ? $seo['image'] : $image;
}
add_filter('rank_math/opengraph/facebook/image', 'simple_dental_rank_math_og_image', 20);
add_filter('rank_math/opengraph/twitter/image', 'simple_dental_rank_math_og_image', 20);

function simple_dental_get_base_canonical_url() {
    if (is_front_page()) {
        return home_url('/');
    }

    if (simple_dental_is_same_day_crowns_request()) {
        return home_url(simple_dental_get_same_day_crowns_path());
    }

    if (is_singular()) {
        return remove_query_arg('lang', get_permalink());
    }

    return home_url('/');
}

function simple_dental_get_language_url($language) {
    return simple_dental_url_for_language(simple_dental_get_base_canonical_url(), $language);
}

function simple_dental_get_canonical_url() {
    return simple_dental_get_language_url(simple_dental_get_current_language_code());
}

function simple_dental_rank_math_canonical($canonical) {
    return simple_dental_get_canonical_url();
}
add_filter('rank_math/frontend/canonical', 'simple_dental_rank_math_canonical', 20);

function simple_dental_print_json_ld($data) {
    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}

function simple_dental_get_practice_schema() {
    $practice_id = home_url('/#organization');

    return array(
        '@context' => 'https://schema.org',
        '@type' => 'Dentist',
        '@id' => $practice_id,
        'name' => 'Simple Dental',
        'url' => home_url('/'),
        'image' => simple_dental_media_url('hero-home-reception-wide.jpg', 'large'),
        'description' => 'Honest, no-pressure dental care with transparent pricing in Las Vegas.',
        'telephone' => '+17023024787',
        'priceRange' => '$$',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => '204 S Jones Blvd',
            'addressLocality' => 'Las Vegas',
            'addressRegion' => 'NV',
            'postalCode' => '89107',
            'addressCountry' => 'US',
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => 36.17120687243312,
            'longitude' => -115.22627292380125,
        ),
        'hasMap' => 'https://maps.app.goo.gl/aEKiZbNFp7SJFG11A',
        'sameAs' => array(
            'https://maps.app.goo.gl/aEKiZbNFp7SJFG11A',
        ),
        'openingHoursSpecification' => array(
            array(
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'),
                'opens' => '08:00',
                'closes' => '16:00',
            ),
        ),
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Las Vegas'),
            array('@type' => 'City', 'name' => 'North Las Vegas'),
        ),
        'medicalSpecialty' => 'Dentistry',
        'availableService' => array(
            array('@type' => 'MedicalProcedure', 'name' => 'Same-Day Crowns'),
            array('@type' => 'MedicalProcedure', 'name' => 'Dental Cleanings'),
            array('@type' => 'MedicalProcedure', 'name' => 'Root Canals'),
            array('@type' => 'MedicalProcedure', 'name' => 'Tooth-Colored Fillings'),
            array('@type' => 'MedicalProcedure', 'name' => 'Tooth Extractions'),
            array('@type' => 'MedicalProcedure', 'name' => 'Dentures and Partials'),
        ),
    );
}

function simple_dental_add_seo_meta() {
    if (is_admin()) {
        return;
    }

    $seo = simple_dental_get_seo_data();
    $canonical_url = simple_dental_get_canonical_url();
    $locale_map = array(
        'en' => 'en_US',
        'es' => 'es_US',
        'zh-CN' => 'zh_CN',
        'zh-TW' => 'zh_TW',
    );
    $language = simple_dental_get_current_language_code();
    $locale = isset($locale_map[$language]) ? $locale_map[$language] : 'en_US';
    $rank_math_active = simple_dental_is_rank_math_active();

    if (!$rank_math_active) {
        echo '<meta name="description" content="' . esc_attr($seo['description']) . '">' . "\n";
        echo '<meta name="robots" content="' . esc_attr($seo['robots']) . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '">' . "\n";
    }

    if ($rank_math_active && simple_dental_is_same_day_crowns_request()) {
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '">' . "\n";
    }

    echo '<link rel="alternate" hreflang="en" href="' . esc_url(simple_dental_get_language_url('en')) . '">' . "\n";
    echo '<link rel="alternate" hreflang="es" href="' . esc_url(simple_dental_get_language_url('es')) . '">' . "\n";
    echo '<link rel="alternate" hreflang="zh-Hans" href="' . esc_url(simple_dental_get_language_url('zh-CN')) . '">' . "\n";
    echo '<link rel="alternate" hreflang="zh-Hant" href="' . esc_url(simple_dental_get_language_url('zh-TW')) . '">' . "\n";
    echo '<link rel="alternate" hreflang="x-default" href="' . esc_url(simple_dental_get_language_url('en')) . '">' . "\n";
    echo '<meta name="geo.region" content="US-NV">' . "\n";
    echo '<meta name="geo.placename" content="Las Vegas">' . "\n";

    if ($rank_math_active) {
        return;
    }

    echo '<meta property="og:locale" content="' . esc_attr($locale) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($seo['title']) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($seo['description']) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($canonical_url) . '">' . "\n";
    echo '<meta property="og:site_name" content="Simple Dental">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($seo['image']) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($seo['title']) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($seo['description']) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($seo['image']) . '">' . "\n";

    simple_dental_print_json_ld(simple_dental_get_practice_schema());

    if (is_front_page()) {
        simple_dental_print_json_ld(array(
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => home_url('/#website'),
            'url' => home_url('/'),
            'name' => 'Simple Dental',
            'publisher' => array('@id' => home_url('/#organization')),
        ));
    }

    if (is_page('about')) {
        simple_dental_print_json_ld(array(
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'Dr. Charles Chang',
            'jobTitle' => 'Dentist',
            'worksFor' => array('@id' => home_url('/#organization')),
            'knowsAbout' => array('Implant training', 'Oral surgery', 'Endodontics', 'Same-day crowns'),
        ));
    }

    if (is_page('services')) {
        simple_dental_print_json_ld(simple_dental_get_services_schema());
    }

    if (is_page('faq')) {
        simple_dental_print_json_ld(simple_dental_get_faq_schema());
    }

    if (simple_dental_is_same_day_crowns_request()) {
        simple_dental_print_json_ld(simple_dental_get_same_day_crowns_schema());
        simple_dental_print_json_ld(simple_dental_get_same_day_crowns_faq_schema());
    }
}
add_action('wp_head', 'simple_dental_add_seo_meta');

function simple_dental_get_services_schema() {
    $catalog = simple_dental_get_service_catalog();
    $services = array();

    foreach ($catalog as $service) {
        $offer = array(
            '@type' => 'Offer',
            'itemOffered' => array(
                '@type' => 'Service',
                'name' => $service['name'],
                'description' => $service['description'],
                'provider' => array('@id' => home_url('/#organization')),
            ),
            'priceCurrency' => 'USD',
            'availability' => 'https://schema.org/InStock',
        );

        if (preg_match('/^\$(\d+(?:\.\d{2})?)$/', $service['price'], $matches)) {
            $offer['price'] = $matches[1];
        } else {
            $offer['description'] = $service['name'] . ' pricing: ' . $service['price'];
        }

        $services[] = $offer;
    }

    return array(
        '@context' => 'https://schema.org',
        '@type' => 'OfferCatalog',
        'name' => 'Simple Dental Services and Pricing',
        'url' => home_url('/services/'),
        'itemListElement' => $services,
    );
}

function simple_dental_get_faq_schema() {
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array(
            array(
                '@type' => 'Question',
                'name' => 'Why is Simple Dental different from other Las Vegas dentists?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Simple Dental is different because patients see the same experienced dentist every time, with no pressure, no upsell, and recommendations based on what they truly need.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'Do I have to worry about hidden fees or bait and switch pricing?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'No. Simple Dental keeps pricing simple with upfront pricing for common services, including the $199 New Patient Special and $899 Same-Day Crowns.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'How can Simple Dental offer a permanent crown in just one visit?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Simple Dental uses digital scanning and in-office milling technology to design, create, and place ceramic crowns in one Las Vegas office visit.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'How much does a dental crown cost at Simple Dental?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Simple Dental offers high-quality permanent ceramic crowns for $899, with related fees explained before treatment if a buildup or other service is needed.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'What if I need a crown but I am worried about the cost?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Simple Dental keeps overhead low, passes savings to patients, and offers flexible financing through CareCredit to help make treatment affordable.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'Do you accept patients without dental insurance?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Yes. Simple Dental serves cash and self-pay patients and offers transparent pricing and new patient specials.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'Which insurance plans does Simple Dental accept?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Simple Dental works with most major PPO dental insurance plans and can verify benefits before the appointment.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'Where is your office located and is there parking?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Simple Dental is located at 204 S Jones Blvd, Las Vegas, NV 89107, with easy access and plenty of free parking behind the office.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'What languages does the staff speak?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Simple Dental serves Las Vegas patients in English, Spanish, Traditional Chinese, and Simplified Chinese.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'How do I book an appointment?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Call Simple Dental at (702) 302-4787 for help choosing a time, or book online at dental4.me/simpledental.'),
            ),
        ),
    );
}

function simple_dental_get_same_day_crowns_schema() {
    $page_url = simple_dental_url_for_language(home_url(simple_dental_get_same_day_crowns_path()), simple_dental_get_current_language_code());

    return array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        '@id' => $page_url . '#service',
        'name' => 'Same-Day Crowns in Las Vegas',
        'description' => 'Permanent ceramic same-day crowns designed, milled, and placed in one visit at Simple Dental in Las Vegas.',
        'provider' => array('@id' => home_url('/#organization')),
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Las Vegas'),
            array('@type' => 'City', 'name' => 'North Las Vegas'),
        ),
        'serviceType' => 'Same-Day Dental Crowns',
        'offers' => array(
            '@type' => 'Offer',
            'price' => '899',
            'priceCurrency' => 'USD',
            'availability' => 'https://schema.org/InStock',
            'url' => $page_url,
            'description' => '$899 for a standard same-day ceramic crown when appropriate. Additional treatment, such as a buildup, is quoted before care begins.',
        ),
    );
}

function simple_dental_get_same_day_crowns_faq_schema() {
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array(
            array(
                '@type' => 'Question',
                'name' => 'Are same-day crowns permanent?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Yes. When appropriate for your tooth, the crown placed at Simple Dental is the final ceramic crown, not a temporary crown.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'How long does a same-day crown appointment take?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Most same-day crown visits take about 2 to 3 hours, depending on the tooth, scan, design, milling, and final bite adjustments.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'What if I need a buildup first?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'If the tooth needs a buildup or another service before the crown, Simple Dental explains why and reviews the fee before starting treatment.'),
            ),
            array(
                '@type' => 'Question',
                'name' => 'Can I book online?',
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => 'Yes. You can book online or call Simple Dental at (702) 302-4787 for help deciding what type of visit to schedule.'),
            ),
        ),
    );
}

function simple_dental_schema_node($schema) {
    unset($schema['@context']);
    return $schema;
}

function simple_dental_get_locale_sitemap_page_paths() {
    return array(
        '/',
        '/services/',
        '/about/',
        '/contact/',
        '/faq/',
        '/same-day-crowns-las-vegas/',
        '/testimonials/',
    );
}

function simple_dental_get_locale_sitemap_languages() {
    return array('es', 'zh-CN', 'zh-TW');
}

function simple_dental_get_sitemap_languages_for_path($path) {
    if ($path === simple_dental_get_same_day_crowns_path() || $path === simple_dental_get_testimonials_path()) {
        return array('en', 'es', 'zh-CN', 'zh-TW');
    }

    return simple_dental_get_locale_sitemap_languages();
}

function simple_dental_get_page_lastmod_for_path($path) {
    if ($path === '/') {
        $front_page_id = (int) get_option('page_on_front');
        if ($front_page_id) {
            return get_post_modified_time('c', true, $front_page_id);
        }
        return gmdate('c');
    }

    $virtual_templates = array(
        simple_dental_get_same_day_crowns_path() => 'page-same-day-crowns.php',
        simple_dental_get_testimonials_path() => 'page-testimonials.php',
    );

    if (isset($virtual_templates[$path])) {
        $template_path = get_template_directory() . '/' . $virtual_templates[$path];
        if (file_exists($template_path)) {
            return gmdate('c', filemtime($template_path));
        }
    }

    $page = get_page_by_path(trim($path, '/'));
    if ($page) {
        return get_post_modified_time('c', true, $page);
    }

    return gmdate('c');
}

function simple_dental_get_locale_sitemap_url() {
    return home_url('/locale-sitemap.xml');
}

function simple_dental_add_locale_sitemap_rewrite_rule() {
    add_rewrite_tag('%simple_dental_locale_sitemap%', '1');
    add_rewrite_rule('^locale-sitemap\.xml$', 'index.php?simple_dental_locale_sitemap=1', 'top');
}
add_action('init', 'simple_dental_add_locale_sitemap_rewrite_rule');

function simple_dental_flush_locale_sitemap_rewrite_rule() {
    $version = '2026-05-14-1';
    if (get_option('simple_dental_locale_sitemap_version') === $version) {
        return;
    }

    simple_dental_add_locale_sitemap_rewrite_rule();
    flush_rewrite_rules(false);
    update_option('simple_dental_locale_sitemap_version', $version, false);
}
add_action('init', 'simple_dental_flush_locale_sitemap_rewrite_rule', 21);

function simple_dental_locale_sitemap_query_vars($vars) {
    $vars[] = 'simple_dental_locale_sitemap';
    return $vars;
}
add_filter('query_vars', 'simple_dental_locale_sitemap_query_vars');

function simple_dental_render_locale_sitemap() {
    $request_path = '';
    if (!empty($_SERVER['REQUEST_URI'])) {
        $request_path = wp_parse_url(esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])), PHP_URL_PATH);
    }

    if (get_query_var('simple_dental_locale_sitemap') !== '1' && $request_path !== '/locale-sitemap.xml') {
        return;
    }

    status_header(200);
    header('Content-Type: application/xml; charset=UTF-8');
    header('X-Robots-Tag: noindex, follow', true);

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

    foreach (simple_dental_get_locale_sitemap_page_paths() as $path) {
        $base_url = home_url($path);
        $lastmod = simple_dental_get_page_lastmod_for_path($path);

        foreach (simple_dental_get_sitemap_languages_for_path($path) as $language) {
            $loc = simple_dental_url_for_language($base_url, $language);
            echo "\t<url>\n";
            echo "\t\t" . '<loc>' . esc_xml($loc) . '</loc>' . "\n";
            echo "\t\t" . '<lastmod>' . esc_xml($lastmod) . '</lastmod>' . "\n";
            echo "\t\t" . '<xhtml:link rel="alternate" hreflang="en" href="' . esc_xml(simple_dental_url_for_language($base_url, 'en')) . '" />' . "\n";
            echo "\t\t" . '<xhtml:link rel="alternate" hreflang="es" href="' . esc_xml(simple_dental_url_for_language($base_url, 'es')) . '" />' . "\n";
            echo "\t\t" . '<xhtml:link rel="alternate" hreflang="zh-Hans" href="' . esc_xml(simple_dental_url_for_language($base_url, 'zh-CN')) . '" />' . "\n";
            echo "\t\t" . '<xhtml:link rel="alternate" hreflang="zh-Hant" href="' . esc_xml(simple_dental_url_for_language($base_url, 'zh-TW')) . '" />' . "\n";
            echo "\t\t" . '<xhtml:link rel="alternate" hreflang="x-default" href="' . esc_xml(simple_dental_url_for_language($base_url, 'en')) . '" />' . "\n";
            echo "\t</url>\n";
        }
    }

    echo '</urlset>' . "\n";
    exit;
}
add_action('template_redirect', 'simple_dental_render_locale_sitemap', 0);

function simple_dental_add_locale_sitemap_to_rank_math_index($xml) {
    $lastmod = gmdate('c');
    $xml .= "\t<sitemap>\n";
    $xml .= "\t\t" . '<loc>' . esc_xml(simple_dental_get_locale_sitemap_url()) . '</loc>' . "\n";
    $xml .= "\t\t" . '<lastmod>' . esc_xml($lastmod) . '</lastmod>' . "\n";
    $xml .= "\t</sitemap>\n";
    return $xml;
}
add_filter('rank_math/sitemap/index', 'simple_dental_add_locale_sitemap_to_rank_math_index', 20);

function simple_dental_add_locale_sitemap_to_robots($output, $public) {
    $line = 'Sitemap: ' . simple_dental_get_locale_sitemap_url();
    if (strpos($output, $line) === false) {
        $output = rtrim($output) . "\n" . $line . "\n";
    }

    return $output;
}
add_filter('robots_txt', 'simple_dental_add_locale_sitemap_to_robots', 20, 2);

function simple_dental_rank_math_json_ld($data) {
    $practice_schema = simple_dental_schema_node(simple_dental_get_practice_schema());
    $organization_updated = false;

    foreach ($data as $key => $node) {
        if (!is_array($node) || empty($node['@id'])) {
            continue;
        }

        if (strpos($node['@id'], '#organization') !== false) {
            $data[$key] = array_merge($node, array(
                '@type' => array('Dentist', 'Organization'),
                'name' => 'Simple Dental',
                'description' => $practice_schema['description'],
                'telephone' => $practice_schema['telephone'],
                'priceRange' => $practice_schema['priceRange'],
                'address' => $practice_schema['address'],
                'geo' => $practice_schema['geo'],
                'hasMap' => $practice_schema['hasMap'],
                'sameAs' => $practice_schema['sameAs'],
                'openingHoursSpecification' => $practice_schema['openingHoursSpecification'],
                'areaServed' => $practice_schema['areaServed'],
                'medicalSpecialty' => $practice_schema['medicalSpecialty'],
                'availableService' => $practice_schema['availableService'],
            ));
            $organization_updated = true;
        }
    }

    if (!$organization_updated) {
        $practice_schema['@id'] = home_url('/#organization');
        $data['simple_dental_practice'] = $practice_schema;
    }

    if (is_page('about')) {
        $data['simple_dental_doctor'] = array(
            '@type' => 'Person',
            'name' => 'Dr. Charles Chang',
            'jobTitle' => 'Dentist',
            'worksFor' => array('@id' => home_url('/#organization')),
            'knowsAbout' => array('Implant training', 'Oral surgery', 'Endodontics', 'Same-day crowns'),
        );
    }

    if (is_page('services')) {
        $data['simple_dental_services'] = simple_dental_schema_node(simple_dental_get_services_schema());
    }

    if (is_page('faq')) {
        $data['simple_dental_faq'] = simple_dental_schema_node(simple_dental_get_faq_schema());
    }

    if (simple_dental_is_same_day_crowns_request()) {
        $data['simple_dental_same_day_crowns'] = simple_dental_schema_node(simple_dental_get_same_day_crowns_schema());
        $data['simple_dental_same_day_crowns_faq'] = simple_dental_schema_node(simple_dental_get_same_day_crowns_faq_schema());
    }

    return $data;
}
add_filter('rank_math/json_ld', 'simple_dental_rank_math_json_ld', 20);

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
        wp_die(json_encode(array('success' => false, 'message' => __t('Security verification failed. Please refresh and try again.'))));
    }
    
    $errors = array();
    
    // Sanitize input data
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    
    // Validate required fields
    if (empty($name)) {
        $errors[] = __t('Name is required.');
    }
    if (empty($email) || !is_email($email)) {
        $errors[] = __t('Valid email is required.');
    }
    if (empty($message)) {
        $errors[] = __t('Message is required.');
    }
    
    // Verify reCAPTCHA if available
    if (function_exists('anr_verify_captcha')) {
        if (!anr_verify_captcha()) {
            $errors[] = __t('Please complete the CAPTCHA verification.');
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
        wp_die(json_encode(array('success' => true, 'message' => __t("Thank you! Your message has been received. We'll get back to you within 24 hours."))));
    }
    
    // Prepare email recipients
    $to = $email_settings['primary'];
    $cc_emails = $email_settings['cc'];
    
    error_log('Simple Dental Contact Form AJAX - Sending to: ' . $to . (empty($cc_emails) ? '' : ' (CC: ' . implode(', ', $cc_emails) . ')'));
    
    // Prepare email subject with custom prefix
    $subject_prefix = $email_settings['subject_prefix'];
    $subject = $subject_prefix . ' ' . __t('Contact Form Submission');
    
    // Prepare email body
    $body = __t('New contact form submission from Simple Dental website:') . "\n\n";
    $body .= __t('Name:') . " $name\n";
    $body .= __t('Email:') . " $email\n";
    $body .= __t('Phone:') . " $phone\n\n";
    $body .= __t('Message:') . "\n$message\n\n";
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
        wp_die(json_encode(array('success' => true, 'message' => __t("Thank you! Your message has been sent successfully. We'll get back to you within 24 hours."))));
    } else {
        error_log('Simple Dental Contact Form AJAX - Email failed to send to: ' . $to);
        // Provide helpful error message with contact alternatives
        $error_message = __t('Sorry, there was an error sending your message. Please try one of these alternatives:');
        $error_message .= '\n• ' . __t('Call us directly at (702) 302-4787');
        $error_message .= '\n• ' . __t('Email us at') . ' ' . $to;
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
            <input type="text" name="contact_name" id="contact_name" placeholder="<?php echo __t('Your Name*'); ?>" required>
            <input type="email" name="contact_email" id="contact_email" placeholder="<?php echo __t('Your Email*'); ?>" required>
        </div>
        
        <div class="form-row">
            <input type="tel" name="contact_phone" id="contact_phone" placeholder="<?php echo __t('Your Phone Number'); ?>">
        </div>
        
        <div class="form-row">
            <textarea name="contact_message" id="contact_message" placeholder="<?php echo __t('Your Message*'); ?>" rows="5" required></textarea>
        </div>
        
        <?php if (function_exists('anr_captcha_form_field')) : ?>
        <div class="form-row captcha-row">
            <?php anr_captcha_form_field(); ?>
        </div>
        <?php endif; ?>
        
        <div class="form-row">
            <button type="submit" id="contact-submit-btn" class="btn btn-primary">
                <span class="btn-text"><?php echo __t('Send Message'); ?></span>
                <span class="btn-loading" style="display: none;"><?php echo __t('Sending...'); ?></span>
            </button>
        </div>
        
        <div class="form-row form-note">
            <small><strong>*</strong> <?php echo __t('Required fields'); ?> | <?php echo __t('We respect your privacy and will never share your information.'); ?></small>
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
                        messagesDiv.html('<div class="contact-success">✅ <strong><?php echo __t('Thank you!'); ?></strong> ' + response.message + '</div>');
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
                            errorHtml += '<strong><?php echo __t('Please correct the following:'); ?></strong><ul>';
                            response.errors.forEach(function(error) {
                                errorHtml += '<li>' + error + '</li>';
                            });
                            errorHtml += '</ul>';
                        } else {
                            errorHtml += response.message || '<?php echo __t('An error occurred. Please try again.'); ?>';
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
                    messagesDiv.html('<div class="contact-error"><?php echo __t('Connection error. Please try again or call us directly at (702) 302-4787.'); ?></div>');
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
 * Shared service catalog used across homepage and services page.
 */
function simple_dental_get_service_catalog() {
    return array(
        'existing_patient_exam' => array(
            'name' => 'Existing Patient Exam and X-rays',
            'name_key' => 'services.preventive.existing_patient_exam.name',
            'price' => '$99',
            'description' => 'Comprehensive exam with digital X-rays for existing patients.',
            'description_key' => 'services.preventive.existing_patient_exam.description',
        ),
        'adult_cleaning' => array(
            'name' => 'Adult Cleaning',
            'name_key' => 'services.preventive.adult_cleaning.name',
            'price' => '$150',
            'description' => 'Professional teeth cleaning and polishing',
            'description_key' => 'services.preventive.adult_cleaning.description',
        ),
        'deep_cleaning' => array(
            'name' => 'Deep Cleaning (per quadrant)',
            'name_key' => 'services.preventive.deep_cleaning.name',
            'price' => '$225',
            'description' => 'Deep scaling and root planing treatment',
            'description_key' => 'services.preventive.deep_cleaning.description',
        ),
        'fluoride_treatment' => array(
            'name' => 'Fluoride Treatment',
            'name_key' => 'services.preventive.fluoride_treatment.name',
            'price' => '$39',
            'description' => 'Professional fluoride application for cavity prevention',
            'description_key' => 'services.preventive.fluoride_treatment.description',
        ),
        'tooth_colored_filling' => array(
            'name' => 'Tooth-Colored Filling',
            'name_key' => 'services.restorative.tooth_colored_filling.name',
            'price' => '$180-250',
            'description' => 'Composite fillings depending on surfaces treated',
            'description_key' => 'services.restorative.tooth_colored_filling.description',
        ),
        'same_day_crown' => array(
            'name' => 'Same-Day Crown (Ceramic)',
            'name_key' => 'services.restorative.same_day_crown.name',
            'price' => '$899',
            'description' => 'Complete crown restoration in one visit',
            'description_key' => 'services.restorative.same_day_crown.description',
        ),
        'core_buildup' => array(
            'name' => 'Core Buildup (if needed)',
            'name_key' => 'services.restorative.core_buildup.name',
            'price' => '$150',
            'description' => 'Foundation preparation for crown placement',
            'description_key' => 'services.restorative.core_buildup.description',
        ),
        'simple_extraction' => array(
            'name' => 'Simple Extraction',
            'name_key' => 'services.extraction.simple_extraction.name',
            'price' => '$180',
            'description' => 'Routine tooth removal procedure',
            'description_key' => 'services.extraction.simple_extraction.description',
        ),
        'surgical_extraction' => array(
            'name' => 'Surgical Extraction',
            'name_key' => 'services.extraction.surgical_extraction.name',
            'price' => '$280',
            'description' => 'Complex tooth removal requiring surgical technique',
            'description_key' => 'services.extraction.surgical_extraction.description',
        ),
        'front_tooth_root_canal' => array(
            'name' => 'Front Tooth Root Canal',
            'name_key' => 'services.endodontics.front_tooth.name',
            'price' => '$650',
            'description' => 'Root canal therapy for anterior teeth',
            'description_key' => 'services.endodontics.front_tooth.description',
        ),
        'premolar_root_canal' => array(
            'name' => 'Premolar Root Canal',
            'name_key' => 'services.endodontics.premolar.name',
            'price' => '$800',
            'description' => 'Root canal therapy for bicuspid teeth',
            'description_key' => 'services.endodontics.premolar.description',
        ),
        'molar_root_canal' => array(
            'name' => 'Molar Root Canal',
            'name_key' => 'services.endodontics.molar.name',
            'price' => '$1000',
            'description' => 'Root canal therapy for back teeth',
            'description_key' => 'services.endodontics.molar.description',
        ),
        'full_denture' => array(
            'name' => 'Full Denture (per arch)',
            'name_key' => 'services.prosthetics.full_denture.name',
            'price' => '$2000',
            'description' => 'Complete denture for upper or lower jaw',
            'description_key' => 'services.prosthetics.full_denture.description',
        ),
        'partial_denture' => array(
            'name' => 'Partial Denture',
            'name_key' => 'services.prosthetics.partial_denture.name',
            'price' => '$1600',
            'description' => 'Removable partial denture to replace missing teeth',
            'description_key' => 'services.prosthetics.partial_denture.description',
        ),
        'denture_reline' => array(
            'name' => 'Denture Reline',
            'name_key' => 'services.prosthetics.denture_reline.name',
            'price' => '$250',
            'description' => 'Adjusting denture fit for comfort',
            'description_key' => 'services.prosthetics.denture_reline.description',
        ),
        'night_guard' => array(
            'name' => 'Night Guard',
            'name_key' => 'services.other.night_guard.name',
            'price' => '$365',
            'description' => 'Custom-made night guard for teeth grinding protection',
            'description_key' => 'services.other.night_guard.description',
        ),
        'retainers' => array(
            'name' => 'Retainers (per arch)',
            'name_key' => 'services.other.retainers.name',
            'price' => '$200',
            'description' => 'Custom retainers for maintaining tooth position',
            'description_key' => 'services.other.retainers.description',
        ),
    );
}

/**
 * Get comprehensive service data.
 */
function get_dental_services_data() {
    return array(
        'preventive' => array(
            'title' => 'Preventive & Diagnostic',
            'title_key' => 'services.category.preventive',
            'service_ids' => array('existing_patient_exam', 'adult_cleaning', 'deep_cleaning', 'fluoride_treatment'),
        ),
        'restorative' => array(
            'title' => 'Restorative Dentistry',
            'title_key' => 'services.category.restorative',
            'service_ids' => array('tooth_colored_filling', 'same_day_crown', 'core_buildup'),
        ),
        'extraction' => array(
            'title' => 'Tooth Removal',
            'title_key' => 'services.category.extraction',
            'service_ids' => array('simple_extraction', 'surgical_extraction'),
        ),
        'endodontics' => array(
            'title' => 'Root Canals',
            'title_key' => 'services.category.endodontics',
            'service_ids' => array('front_tooth_root_canal', 'premolar_root_canal', 'molar_root_canal'),
        ),
        'prosthetics' => array(
            'title' => 'Dentures & Partials',
            'title_key' => 'services.category.prosthetics',
            'service_ids' => array('full_denture', 'partial_denture', 'denture_reline'),
        ),
        'other' => array(
            'title' => 'Other Services',
            'title_key' => 'services.category.other',
            'service_ids' => array('night_guard', 'retainers'),
        ),
    );
}

/**
 * Featured services for homepage (top 6)
 */
function featured_services_display($atts) {
    $catalog = simple_dental_get_service_catalog();
    $featured_ids = array(
        'existing_patient_exam',
        'adult_cleaning',
        'tooth_colored_filling',
        'same_day_crown',
        'simple_extraction',
        'front_tooth_root_canal',
    );

    ob_start();
    echo '<div class="services-grid">';
    foreach ($featured_ids as $service_id) {
        if (empty($catalog[$service_id])) {
            continue;
        }

        $service = $catalog[$service_id];
        echo '<div class="service-card">';
        echo '<h3 class="service-title">' . esc_html(simple_dental_translate_structured_text($service, 'name')) . '</h3>';
        echo '<div class="service-price">' . esc_html($service['price']) . '</div>';
        echo '<p class="service-description">' . esc_html(simple_dental_translate_structured_text($service, 'description')) . '</p>';
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
    $booking_url = simple_dental_get_booking_url();
    ob_start();
    ?>
    <div class="new-patient-special">
        <h3><?php echo __t('Opening Promotion', 'key:promo.new_patient.heading'); ?></h3>
        <div class="special-offers">
            <article class="special-offer-card special-offer-card--starter">
                <h4><?php echo __t('New Patient Exam + X-rays', 'key:promo.new_patient.exam.name'); ?></h4>
                <div class="special-price">$59</div>
                <p><?php echo __t('A simple first-visit exam with digital X-rays for new patients.', 'key:promo.new_patient.exam.description'); ?></p>
            </article>
            <article class="special-offer-card special-offer-card--featured">
                <h4><?php echo __t('New Patient Special', 'key:promo.new_patient.special.name'); ?></h4>
                <div class="special-price">$199</div>
                <ul class="special-offer-list">
                    <li><?php echo __t('Comprehensive exam', 'key:promo.new_patient.special.includes.exam'); ?></li>
                    <li><?php echo __t('Digital X-rays', 'key:promo.new_patient.special.includes.xrays'); ?></li>
                    <li><?php echo __t('Regular cleaning', 'key:promo.new_patient.special.includes.cleaning'); ?></li>
                    <li><?php echo __t('Complimentary digital 3D scan', 'key:promo.new_patient.special.includes.scan'); ?></li>
                </ul>
            </article>
        </div>
        <div class="special-features">
            <span class="feature">✓ <?php echo __t('Call or book online to schedule', 'key:promo.new_patient.cta.note'); ?></span>
        </div>
        <a href="tel:7023024787" class="btn btn-coral"><?php echo __t('Call for New Patient Visit', 'key:promo.new_patient.cta.call'); ?></a>
        <p class="special-secondary-cta"><?php echo wp_kses_post(sprintf(__t('Prefer online booking? %s', 'key:promo.new_patient.cta.online'), '<a href="' . esc_url($booking_url) . '">' . esc_html(__t('Book online')) . '</a>')); ?></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('new_patient_special', 'new_patient_special_display');

/**
 * Services by category for full services page
 */
function services_by_category_display($atts) {
    $catalog = simple_dental_get_service_catalog();
    $services_data = get_dental_services_data();
    
    ob_start();
    echo '<div class="services-by-category">';
    
    foreach ($services_data as $category_key => $category) {
        echo '<div class="service-category" data-category="' . esc_attr($category_key) . '">';
        echo '<h3 class="category-title">' . esc_html(simple_dental_translate_structured_text($category, 'title')) . '</h3>';
        echo '<div class="services-grid category-grid">';
        
        foreach ($category['service_ids'] as $service_id) {
            if (empty($catalog[$service_id])) {
                continue;
            }

            $service = $catalog[$service_id];
            echo '<div class="service-card category-card">';
            echo '<h4 class="service-title">' . esc_html(simple_dental_translate_structured_text($service, 'name')) . '</h4>';
            echo '<div class="service-price">' . esc_html($service['price']) . '</div>';
            echo '<p class="service-description">' . esc_html(simple_dental_translate_structured_text($service, 'description')) . '</p>';
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
 * Google Reviews / Testimonials data and render helpers.
 *
 * Real Google review text should be copied from the Simple Dental Google
 * Business Profile into simple_dental_get_google_reviews(). Do not invent
 * patient reviews.
 */
function simple_dental_get_google_reviews_meta() {
    return array(
        'rating' => '5.0',
        'review_count' => '13',
        'google_url' => 'https://maps.app.goo.gl/aEKiZbNFp7SJFG11A',
        'last_updated' => 'May 2026',
    );
}

function simple_dental_get_google_reviews() {
    return array(
        array(
            'name' => 'Alan Wang',
            'initials' => 'AW',
            'rating' => 5,
            'date' => '4 weeks ago',
            'featured' => false,
            'text' => 'Simple Dental LV 超出了我的預期。從走進診所的那一刻起，工作人員就非常貼心又友善。醫師潔牙的技術很好，手法溫柔但非常仔細，也會清楚解釋每個步驟。診所環境乾淨、現代、井然有序。這是我做過最好的潔牙體驗之一，很高興找到一家值得信賴的牙科診所。',
        ),
        array(
            'name' => 'Robert Wu',
            'initials' => 'RW',
            'rating' => 5,
            'date' => 'a week ago',
            'featured' => true,
            'text' => 'Dr Chang is super friendly!! He calms me down when I feel very nervous and makes a crown for me works very well. Very good experience, highly recommend.',
        ),
        array(
            'name' => 'Vivian',
            'initials' => 'V',
            'rating' => 5,
            'date' => 'a week ago',
            'featured' => true,
            'text' => 'Highly recommend this dental office! The clinic is beautiful, clean, and welcoming. The staff are friendly, professional, and made the whole experience very comfortable. Dr. Chang is very professional, and you can really feel the care and attention they give to their patients.',
        ),
        array(
            'name' => 'J L',
            'initials' => 'JL',
            'rating' => 5,
            'date' => '2 weeks ago',
            'featured' => true,
            'text' => 'Really happy with my experience here. The clinic feels clean and up-to-date, and everything was handled smoothly. Dr. Chang was patient, friendly, and took the time to explain things clearly, which I appreciated. The staff made the visit easy, and the location is very convenient. I’d come back and recommend it to others.',
        ),
        array(
            'name' => 'Anna Sun',
            'initials' => 'AS',
            'rating' => 5,
            'date' => '2 weeks ago',
            'featured' => false,
            'text' => 'I had an excellent experience at this dental clinic. The facility is equipped with modern, state-of-the-art technology, which made the entire process smooth and efficient. The dentist was not only highly skilled but also incredibly friendly and patient, taking the time to explain everything clearly. The staff created a warm and welcoming atmosphere, and the clinic itself is clean, comfortable, and thoughtfully designed. Another big plus is the convenient location—it’s very easy to access. I would highly recommend this clinic to anyone looking for quality dental care.',
        ),
        array(
            'name' => 'Ashley Yu',
            'initials' => 'AY',
            'rating' => 5,
            'date' => 'a month ago',
            'featured' => false,
            'text' => 'I had a really lovely experience at Dr. Chang’s office. From the moment I walked in, the clinic felt fresh, bright, and very clean. The space has a simple and welcoming feel that made me feel comfortable right away. Dr. Chang made the whole visit feel calm and reassuring. He was caring, patient, and very skilled, which helped me feel comfortable throughout the entire appointment. I especially appreciated how he checked in during the visit to make sure I was doing okay and felt at ease. What also stood out to me was his honesty. He explained things clearly and never made me feel pushed toward treatments that were not truly needed. That kind of sincerity and openness means a lot to me when choosing a dentist. The office is modern, thoughtfully arranged, and everything felt well managed from beginning to end. Overall, it was such a smooth and positive experience. I would absolutely recommend Dr. Chang to anyone looking for a dentist who is trustworthy, attentive, and provides excellent care.',
        ),
        array(
            'name' => 'Google reviewer',
            'initials' => 'G',
            'rating' => 5,
            'date' => 'a month ago',
            'featured' => false,
            'text' => 'We had a wonderful experience at this dental office! Dr. Chang did an amazing job cleaning my son’s teeth — he was incredibly thorough, and he felt absolutely no pain during the entire process. The staff was very professional and made us feel comfortable from start to finish. The clinic itself was also very clean and well-maintained, which made the visit even more pleasant. Highly recommend to any one looking for a great pediatric dental experience!',
        ),
    );
}

function simple_dental_get_featured_google_reviews($limit = 3) {
    $featured = array();
    $reviews = simple_dental_get_google_reviews();

    foreach ($reviews as $review) {
        if (!empty($review['featured'])) {
            $featured[] = $review;
        }
    }

    if (empty($featured)) {
        $featured = $reviews;
    }

    return array_slice($featured, 0, absint($limit));
}

function simple_dental_render_review_stars($rating) {
    $rating = max(0, min(5, (int) $rating));
    $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);

    return '<span class="review-stars" role="img" aria-label="' . esc_attr(sprintf(__t('%d out of 5 stars'), $rating)) . '">' . esc_html($stars) . '</span>';
}

function simple_dental_get_review_excerpt($text, $word_limit = 34) {
    $text = trim((string) $text);
    if ($text === '') {
        return '';
    }

    $words = preg_split('/\s+/u', $text);
    if (count($words) <= $word_limit) {
        return $text;
    }

    return implode(' ', array_slice($words, 0, $word_limit)) . '…';
}

function simple_dental_render_google_review_card($review, $is_featured = false, $compact = false) {
    $name = isset($review['name']) ? $review['name'] : __t('Google reviewer');
    $initials = !empty($review['initials']) ? $review['initials'] : strtoupper(substr($name, 0, 1));
    $rating = isset($review['rating']) ? (int) $review['rating'] : 5;
    $date = isset($review['date']) ? $review['date'] : '';
    $text = isset($review['text']) ? $review['text'] : '';
    if ($compact) {
        $text = simple_dental_get_review_excerpt($text, 30);
    }
    $class = $is_featured ? ' review-card-featured' : '';

    ob_start();
    ?>
    <article class="review-card<?php echo esc_attr($class); ?>">
        <div class="review-card-header">
            <div class="review-avatar" aria-hidden="true"><?php echo esc_html($initials); ?></div>
            <div>
                <h3 class="reviewer-name"><?php echo esc_html($name); ?></h3>
                <p class="review-source"><?php echo esc_html(__t('Google review')); ?><?php echo $date ? ' · ' . esc_html($date) : ''; ?></p>
            </div>
        </div>
        <?php echo simple_dental_render_review_stars($rating); ?>
        <blockquote class="review-text">
            <p><?php echo esc_html($text); ?></p>
        </blockquote>
    </article>
    <?php
    return ob_get_clean();
}

function simple_dental_render_reviews_empty_state() {
    ob_start();
    ?>
    <div class="reviews-empty-state">
        <p><strong><?php echo esc_html(__t('Google reviews are being added here soon.')); ?></strong></p>
        <p><?php echo esc_html(__t('This section is ready for real patient reviews copied from the Simple Dental Google Business Profile.')); ?></p>
    </div>
    <?php
    return ob_get_clean();
}

function simple_dental_render_google_reviews_home_section() {
    $meta = simple_dental_get_google_reviews_meta();
    $reviews = simple_dental_get_featured_google_reviews(3);
    $testimonials_url = simple_dental_with_lang(home_url(simple_dental_get_testimonials_path()));
    $google_url = !empty($meta['google_url']) ? $meta['google_url'] : '';

    ob_start();
    ?>
    <section class="section reviews-home-section" id="patient-reviews">
        <div class="container">
            <div class="reviews-home-layout">
                <div class="reviews-home-intro">
                    <p class="section-eyebrow"><?php echo esc_html(__t('Patient Reviews')); ?></p>
                    <h2><?php echo esc_html(__t('What Patients Are Saying About Simple Dental')); ?></h2>
                    <p><?php echo esc_html(__t('See why patients appreciate honest, no-pressure dental care from one experienced Las Vegas dentist.')); ?></p>
                    <div class="google-rating-badge" aria-label="<?php echo esc_attr(__t('Google reviews summary')); ?>">
                        <span class="google-wordmark">Google</span>
                        <?php if (!empty($meta['rating'])) : ?>
                            <strong><?php echo esc_html($meta['rating']); ?></strong>
                            <?php echo simple_dental_render_review_stars((int) round((float) $meta['rating'])); ?>
                        <?php else : ?>
                            <strong><?php echo esc_html(__t('Reviews coming soon')); ?></strong>
                        <?php endif; ?>
                        <?php if (!empty($meta['review_count'])) : ?>
                            <span><?php echo esc_html(sprintf(__t('Based on %s Google reviews'), $meta['review_count'])); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="review-section-actions">
                        <a href="<?php echo esc_url($testimonials_url); ?>" class="btn btn-primary"><?php echo esc_html(__t('Read Patient Reviews')); ?></a>
                        <?php if ($google_url) : ?>
                            <a href="<?php echo esc_url($google_url); ?>" class="btn btn-secondary" target="_blank" rel="noopener noreferrer"><?php echo esc_html(__t('View on Google')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="reviews-card-grid reviews-home-cards">
                    <?php
                    if (!empty($reviews)) {
                        foreach ($reviews as $review) {
                            echo simple_dental_render_google_review_card($review, true, true);
                        }
                    } else {
                        echo simple_dental_render_reviews_empty_state();
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
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
