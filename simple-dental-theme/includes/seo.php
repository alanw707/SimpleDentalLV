<?php
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

    if (simple_dental_is_smile_preview_request()) {
        return array_merge($default, array(
            'title' => function_exists('__t') ? __t('AI Smile Preview Las Vegas | Simple Dental') : 'AI Smile Preview Las Vegas | Simple Dental',
            'description' => function_exists('__t') ? __t('Create a private AI smile preview concept for whitening, veneers, alignment, or cosmetic smile makeover ideas before booking a Simple Dental consultation.') : 'Create a private AI smile preview concept for whitening, veneers, alignment, or cosmetic smile makeover ideas before booking a Simple Dental consultation.',
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

    if (simple_dental_is_testimonials_request()) {
        return home_url(simple_dental_get_testimonials_path());
    }

    if (simple_dental_is_smile_preview_request()) {
        return home_url(simple_dental_get_smile_preview_path());
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

    if ($rank_math_active && (simple_dental_is_same_day_crowns_request() || simple_dental_is_testimonials_request() || simple_dental_is_smile_preview_request())) {
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

