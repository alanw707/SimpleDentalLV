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

    public function get_rtl_direction() {
        $rtl_languages = ['ar', 'he', 'fa', 'ur'];
        return in_array($this->current_language, $rtl_languages) ? 'rtl' : 'ltr';
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

// Language switcher function
function simple_dental_language_switcher() {
    global $simple_dental_translator;
    return $simple_dental_translator->get_language_switcher_html();
}

// Get current language
function get_current_language() {
    global $simple_dental_translator;
    return $simple_dental_translator->get_current_language();
}