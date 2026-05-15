<?php
/**
 * Lightweight Translation System
 * Free custom solution for Spanish, Chinese Traditional, Chinese Simplified
 */

function simple_dental_language_route_map() {
    return array(
        'es' => 'es',
        'zh-cn' => 'zh-CN',
        'zh-tw' => 'zh-TW',
    );
}

function simple_dental_language_slug_to_code($slug) {
    $slug = strtolower(trim((string) $slug, '/'));
    $map = simple_dental_language_route_map();
    return isset($map[$slug]) ? $map[$slug] : '';
}

function simple_dental_language_code_to_slug($code) {
    if ($code === 'en') {
        return '';
    }

    foreach (simple_dental_language_route_map() as $slug => $language_code) {
        if ($language_code === $code) {
            return $slug;
        }
    }

    return '';
}

function simple_dental_get_request_language_from_path() {
    if (empty($_SERVER['REQUEST_URI'])) {
        return '';
    }

    $path = wp_parse_url(esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])), PHP_URL_PATH);
    $segments = explode('/', trim((string) $path, '/'));
    $first_segment = isset($segments[0]) ? $segments[0] : '';

    return simple_dental_language_slug_to_code($first_segment);
}

function simple_dental_strip_language_prefix_from_path($path) {
    $path = '/' . ltrim((string) $path, '/');
    $has_trailing_slash = substr($path, -1) === '/';
    $segments = explode('/', trim($path, '/'));

    if (!empty($segments[0]) && simple_dental_language_slug_to_code($segments[0])) {
        array_shift($segments);
    }

    $clean_path = '/' . implode('/', $segments);
    if ($clean_path !== '/' && $has_trailing_slash) {
        $clean_path .= '/';
    }

    return $clean_path;
}

function simple_dental_is_internal_url($url) {
    $scheme = wp_parse_url($url, PHP_URL_SCHEME);
    if ($scheme && !in_array($scheme, array('http', 'https'), true)) {
        return false;
    }

    $home_host = wp_parse_url(home_url('/'), PHP_URL_HOST);
    $url_host = wp_parse_url($url, PHP_URL_HOST);

    return (!$url_host && strpos($url, '/') === 0) || ($url_host && $home_host && strtolower($url_host) === strtolower($home_host));
}

function simple_dental_wp_locale_for_language($language_code) {
    $locales = array(
        'en' => 'en_US',
        'es' => 'es_US',
        'zh-CN' => 'zh_CN',
        'zh-TW' => 'zh_TW',
    );

    return isset($locales[$language_code]) ? $locales[$language_code] : 'en_US';
}

function simple_dental_html_lang_for_language($language_code) {
    $languages = array(
        'en' => 'en-US',
        'es' => 'es-US',
        'zh-CN' => 'zh-Hans',
        'zh-TW' => 'zh-Hant',
    );

    return isset($languages[$language_code]) ? $languages[$language_code] : 'en-US';
}

function simple_dental_url_for_language($url, $language_code) {
    if (empty($url) || !simple_dental_is_internal_url($url)) {
        return $url;
    }

    $language_code = (string) $language_code;
    $slug = simple_dental_language_code_to_slug($language_code);
    $clean_url = remove_query_arg('lang', $url);
    $parts = wp_parse_url($clean_url);

    if (empty($parts)) {
        return $url;
    }

    $path = isset($parts['path']) ? $parts['path'] : '/';
    $base_path = simple_dental_strip_language_prefix_from_path($path);
    $localized_path = $slug ? '/' . $slug . rtrim($base_path, '/') . '/' : $base_path;
    if ($base_path === '/' && $slug) {
        $localized_path = '/' . $slug . '/';
    }

    $host = isset($parts['host']) ? $parts['host'] : '';
    $scheme = isset($parts['scheme']) ? $parts['scheme'] : '';
    $port = isset($parts['port']) ? ':' . $parts['port'] : '';
    $prefix = $host ? ($scheme ? $scheme . '://' : '//') . $host . $port : '';

    $query = array();
    if (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
        unset($query['lang']);
    }

    $result = $prefix . $localized_path;
    if (!empty($query)) {
        $result .= '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
    }
    if (!empty($parts['fragment'])) {
        $result .= '#' . $parts['fragment'];
    }

    return $result;
}

class SimpleDentalTranslator {
    private $default_language = 'en';
    private $supported_languages = [
        'en' => 'English',
        'es' => 'Español', 
        'zh-TW' => '繁體中文',
        'zh-CN' => '简体中文'
    ];
    private $current_language;
    private $translations = [];

    public function __construct() {
        $this->current_language = $this->detect_language();
        $this->load_translations();
    }

    private function detect_language() {
        // Check direct locale route first, e.g. /es/services/.
        $path_language = simple_dental_get_request_language_from_path();
        if ($path_language && array_key_exists($path_language, $this->supported_languages)) {
            $this->set_language($path_language);
            return $path_language;
        }

        // Keep legacy ?lang= URLs working during the route migration.
        if (isset($_GET['lang'])) {
            $lang = sanitize_text_field(wp_unslash($_GET['lang']));
            if (array_key_exists($lang, $this->supported_languages)) {
                $this->set_language($lang);
                return $lang;
            }
        }

        // Direct locale routing is canonical now. No locale prefix means English.
        // Do not let old cookies or browser language override explicit English URLs.
        return $this->default_language;
    }

    private function match_browser_language($accept_language) {
        $languages = array_map('trim', explode(',', strtolower($accept_language)));

        foreach ($languages as $language) {
            $language = trim(explode(';', $language)[0]);
            if ($language === '') {
                continue;
            }

            if ($language === 'es' || strpos($language, 'es-') === 0) {
                return 'es';
            }

            if (
                $language === 'zh-tw' ||
                $language === 'zh-hk' ||
                $language === 'zh-mo' ||
                strpos($language, 'zh-hant') === 0
            ) {
                return 'zh-TW';
            }

            if (
                $language === 'zh-cn' ||
                $language === 'zh-sg' ||
                strpos($language, 'zh-hans') === 0 ||
                $language === 'zh'
            ) {
                return 'zh-CN';
            }
        }

        return '';
    }

    private function load_translations() {
        if ($this->current_language === $this->default_language) {
            return; // No translation file needed for default language
        }

        $translation_file = get_template_directory() . '/translations/' . $this->current_language . '.json';
        
        if (file_exists($translation_file)) {
            $json_content = file_get_contents($translation_file);
            $this->translations = json_decode($json_content, true) ?: [];
        }
    }

    public function translate($text, $context = '') {
        if ($this->current_language === $this->default_language) {
            return $text;
        }

        if ($context && strpos($context, 'key:') === 0) {
            $key = substr($context, 4);
            if (isset($this->translations[$key])) {
                return $this->translations[$key];
            }

            if (isset($this->translations[$text])) {
                return $this->translations[$text];
            }

            return $text;
        }

        $key = $context ? $context . '|' . $text : $text;
        
        // Try with context first
        if ($context && isset($this->translations[$key])) {
            return $this->translations[$key];
        }
        
        // Fallback to text without context
        if (isset($this->translations[$text])) {
            return $this->translations[$text];
        }
        
        return $text; // Return original if no translation found
    }

    public function set_language($language_code) {
        if (array_key_exists($language_code, $this->supported_languages)) {
            $this->current_language = $language_code;
            // Set cookie with more compatible parameters
            if (!headers_sent()) {
                setcookie('simple_dental_lang', $language_code, [
                    'expires' => time() + (86400 * 30), // 30 days
                    'path' => '/',
                    'domain' => '', // Let browser handle domain
                    'secure' => is_ssl(),
                    'httponly' => false, // Allow JavaScript access if needed
                    'samesite' => 'Lax'
                ]);
            }
            $this->load_translations();
            return true;
        }
        return false;
    }

    public function get_current_language() {
        return $this->current_language;
    }

    public function get_supported_languages() {
        return $this->supported_languages;
    }

    public function get_language_switcher_html() {
        $current_url = home_url($_SERVER['REQUEST_URI']);
        $switcher_html = '<div class="language-switcher">';
        
        // Add globe icon
        $switcher_html .= '<svg class="language-globe-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">';
        $switcher_html .= '<circle cx="12" cy="12" r="10"/>';
        $switcher_html .= '<path d="M2 12h20"/>';
        $switcher_html .= '<path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>';
        $switcher_html .= '</svg>';
        
        $switcher_html .= '<select class="language-dropdown" onchange="window.location.href=this.value" aria-label="Select Language">';
        
        foreach ($this->supported_languages as $code => $name) {
            $selected = ($code === $this->current_language) ? ' selected' : '';
            $url = simple_dental_url_for_language($current_url, $code);
            
            $switcher_html .= sprintf(
                '<option value="%s"%s>%s</option>',
                esc_url($url),
                $selected,
                esc_html($name)
            );
        }
        
        $switcher_html .= '</select>';
        $switcher_html .= '</div>';
        return $switcher_html;
    }

}

// Initialize global translator instance
global $simple_dental_translator;
$simple_dental_translator = new SimpleDentalTranslator();

// Translation function for use in templates
function __t($text, $context = '') {
    global $simple_dental_translator;
    return $simple_dental_translator->translate($text, $context);
}

/**
 * Append the active language to internal URLs so language persists
 * across navigation. Keeps external links untouched.
 */
function simple_dental_with_lang($url) {
    if (empty($url)) {
        return $url;
    }

    global $simple_dental_translator;
    if (!$simple_dental_translator) {
        return $url;
    }

    return simple_dental_url_for_language($url, $simple_dental_translator->get_current_language());
}

/**
 * Ensure common WordPress-generated links also carry the lang param.
 * We accept only the first argument from each filter.
 */
add_filter('the_permalink', 'simple_dental_with_lang', 10, 1);
add_filter('post_link', 'simple_dental_with_lang', 10, 1);
add_filter('page_link', 'simple_dental_with_lang', 10, 1);
add_filter('post_type_link', 'simple_dental_with_lang', 10, 1);
add_filter('term_link', 'simple_dental_with_lang', 10, 1);

/**
 * Append lang to menu item URLs generated by wp_nav_menu (if used).
 */
function simple_dental_nav_menu_link_attributes($atts, $item, $args, $depth) {
    if (!empty($atts['href'])) {
        $atts['href'] = simple_dental_with_lang($atts['href']);
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'simple_dental_nav_menu_link_attributes', 10, 4);

/**
 * Ensure the custom logo link points to the language-preserving URL.
 */
function simple_dental_custom_logo_with_lang($html) {
    if (empty($html)) {
        return $html;
    }
    // Replace the href in the rendered custom logo anchor with a lang-aware URL
    $updated = preg_replace_callback(
        '/href="([^"]+)"/i',
        function ($m) {
            $url = isset($m[1]) ? $m[1] : '';
            $new = simple_dental_with_lang($url);
            return 'href="' . esc_url($new) . '"';
        },
        $html
    );
    return $updated ?: $html;
}
add_filter('get_custom_logo', 'simple_dental_custom_logo_with_lang');

/**
 * Direct locale route support: /es/, /zh-cn/, /zh-tw/.
 */
function simple_dental_add_locale_rewrite_rules() {
    add_rewrite_tag('%simple_dental_lang%', '(es|zh-cn|zh-tw)');
    add_rewrite_rule('^(es|zh-cn|zh-tw)/?$', 'index.php?simple_dental_lang=$matches[1]', 'top');
    add_rewrite_rule('^(es|zh-cn|zh-tw)/(.+?)/?$', 'index.php?pagename=$matches[2]&simple_dental_lang=$matches[1]', 'top');
}
add_action('init', 'simple_dental_add_locale_rewrite_rules');

function simple_dental_locale_query_vars($vars) {
    $vars[] = 'simple_dental_lang';
    return $vars;
}
add_filter('query_vars', 'simple_dental_locale_query_vars');

function simple_dental_flush_locale_rewrite_rules() {
    $version = '2026-05-14-1';
    if (get_option('simple_dental_locale_routes_version') === $version) {
        return;
    }

    simple_dental_add_locale_rewrite_rules();
    flush_rewrite_rules(false);
    update_option('simple_dental_locale_routes_version', $version, false);
}
add_action('init', 'simple_dental_flush_locale_rewrite_rules', 20);

function simple_dental_redirect_legacy_language_urls() {
    if (empty($_GET['lang'])) {
        return;
    }

    $language = sanitize_text_field(wp_unslash($_GET['lang']));
    if ($language !== 'en' && !simple_dental_language_code_to_slug($language)) {
        return;
    }

    $current_url = home_url(wp_unslash($_SERVER['REQUEST_URI']));
    $target_url = simple_dental_url_for_language($current_url, $language);

    if ($target_url && $target_url !== $current_url) {
        wp_safe_redirect($target_url, 301);
        exit;
    }
}
add_action('template_redirect', 'simple_dental_redirect_legacy_language_urls', 0);

function simple_dental_filter_wp_locale($locale) {
    $language = simple_dental_get_request_language_from_path();

    if (!$language) {
        global $simple_dental_translator;
        if ($simple_dental_translator && method_exists($simple_dental_translator, 'get_current_language')) {
            $language = $simple_dental_translator->get_current_language();
        }
    }

    return $language ? simple_dental_wp_locale_for_language($language) : $locale;
}
add_filter('locale', 'simple_dental_filter_wp_locale', 20);

function simple_dental_language_attributes($output, $doctype) {
    global $simple_dental_translator;
    $language = ($simple_dental_translator && method_exists($simple_dental_translator, 'get_current_language'))
        ? $simple_dental_translator->get_current_language()
        : simple_dental_get_request_language_from_path();

    return 'lang="' . esc_attr(simple_dental_html_lang_for_language($language)) . '"';
}
add_filter('language_attributes', 'simple_dental_language_attributes', 20, 2);

// Language switcher function
function simple_dental_language_switcher() {
    global $simple_dental_translator;
    return $simple_dental_translator->get_language_switcher_html();
}

// Public helper functions are intentionally minimized to reduce surface area
