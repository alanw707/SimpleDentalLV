<?php
/**
 * Lightweight Translation System
 * Free custom solution for Spanish, Chinese Traditional, Chinese Simplified
 */

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
        // Check URL parameter first (for active language switching)
        if (isset($_GET['lang'])) {
            $lang = sanitize_text_field($_GET['lang']);
            if (array_key_exists($lang, $this->supported_languages)) {
                $this->set_language($lang);
                return $lang;
            }
        }

        // Check cookie (for persistence when no active switching)
        if (isset($_COOKIE['simple_dental_lang'])) {
            $lang = sanitize_text_field($_COOKIE['simple_dental_lang']);
            if (array_key_exists($lang, $this->supported_languages)) {
                return $lang;
            }
        }

        // Check browser language (first visit only - set cookie to remember)
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (array_key_exists($browser_lang, $this->supported_languages)) {
                $this->set_language($browser_lang);
                return $browser_lang;
            }
        }

        return $this->default_language;
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
            // Remove existing lang parameter first, then add new one
            $clean_url = remove_query_arg('lang', $current_url);
            $url = add_query_arg('lang', $code, $clean_url);
            
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

    // Ignore non-http(s) schemes (mailto:, tel:, etc.)
    $scheme = wp_parse_url($url, PHP_URL_SCHEME);
    if ($scheme && !in_array($scheme, array('http', 'https'), true)) {
        return $url;
    }

    // Determine current language
    global $simple_dental_translator;
    if (!$simple_dental_translator) {
        return $url;
    }
    $lang = $simple_dental_translator->get_current_language();
    if (empty($lang) || $lang === 'en') {
        // Default language: do not alter URLs
        return $url;
    }

    // Only modify internal links (same host or relative)
    $home_host = wp_parse_url(home_url('/'), PHP_URL_HOST);
    $url_host  = wp_parse_url($url, PHP_URL_HOST);
    $is_relative = (bool) (! $url_host && strpos($url, '/') === 0);
    $is_same_host = ($url_host && $home_host && strtolower($url_host) === strtolower($home_host));
    if (!$is_relative && !$is_same_host) {
        return $url; // external link
    }

    // Replace existing lang param then add our current language
    $clean = remove_query_arg('lang', $url);
    return add_query_arg('lang', $lang, $clean);
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

// Language switcher function
function simple_dental_language_switcher() {
    global $simple_dental_translator;
    return $simple_dental_translator->get_language_switcher_html();
}

// Public helper functions are intentionally minimized to reduce surface area
