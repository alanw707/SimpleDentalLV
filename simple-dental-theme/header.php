<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Google Translate Setup - Hidden -->
    <script type="text/javascript">
    let googleTranslateInstance = null;
    
    function googleTranslateElementInit() {
        googleTranslateInstance = new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,es,zh-TW,zh-CN',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            multilanguagePage: true,
            gaTrack: true,
            autoDisplay: false
        }, 'google_translate_element_hidden');
    }
    
    // Custom language selector functionality
    function initCustomLanguageSelector() {
        const customSelect = document.getElementById('custom-language-select');
        if (!customSelect) return;
        
        customSelect.addEventListener('change', function() {
            const selectedLang = this.value;
            changeLanguage(selectedLang);
        });
        
        // Set initial language based on current Google Translate state
        updateCustomSelectValue();
    }
    
    function changeLanguage(langCode) {
        // Find and trigger Google Translate
        const hiddenSelect = document.querySelector('#google_translate_element_hidden .goog-te-combo');
        
        if (hiddenSelect) {
            // Find the option that matches our language code
            for (let i = 0; i < hiddenSelect.options.length; i++) {
                const option = hiddenSelect.options[i];
                if (option.value === langCode || 
                    (langCode === 'en' && option.value === '') ||
                    option.value.toLowerCase() === langCode.toLowerCase()) {
                    hiddenSelect.selectedIndex = i;
                    hiddenSelect.dispatchEvent(new Event('change'));
                    break;
                }
            }
        }
        
        // Update our custom select appearance
        updateLanguageDisplay(langCode);
    }
    
    function updateLanguageDisplay(langCode) {
        const customSelect = document.getElementById('custom-language-select');
        if (customSelect) {
            customSelect.value = langCode;
        }
    }
    
    function updateCustomSelectValue() {
        const hiddenSelect = document.querySelector('#google_translate_element_hidden .goog-te-combo');
        const customSelect = document.getElementById('custom-language-select');
        
        if (hiddenSelect && customSelect) {
            const currentValue = hiddenSelect.value || 'en';
            customSelect.value = currentValue;
        }
    }
    
    // Enhanced initialization with error handling
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize custom language selector
        initCustomLanguageSelector();
        
        // Wait for Google Translate to fully load
        let initAttempts = 0;
        const maxAttempts = 10;
        
        const waitForGoogleTranslate = function() {
            const hiddenSelect = document.querySelector('#google_translate_element_hidden .goog-te-combo');
            
            if (hiddenSelect && hiddenSelect.options.length > 1) {
                // Google Translate is ready
                updateCustomSelectValue();
                console.log('Custom language selector initialized successfully');
            } else if (initAttempts < maxAttempts) {
                initAttempts++;
                setTimeout(waitForGoogleTranslate, 500);
            } else {
                console.warn('Google Translate failed to load properly');
            }
        };
        
        setTimeout(waitForGoogleTranslate, 1000);
        
        // Periodic sync (less frequent to avoid performance issues)
        setInterval(updateCustomSelectValue, 5000);
    });
    
    // Handle page language changes from Google Translate
    function handleLanguageChange() {
        // Monitor for URL hash changes that indicate translation
        const currentLang = document.documentElement.lang || 'en';
        const bodyClasses = document.body.className;
        
        // Update custom select based on body classes
        if (bodyClasses.includes('translated-zh-cn')) {
            updateLanguageDisplay('zh-CN');
        } else if (bodyClasses.includes('translated-zh-tw')) {
            updateLanguageDisplay('zh-TW');
        } else if (bodyClasses.includes('translated-es')) {
            updateLanguageDisplay('es');
        } else {
            updateLanguageDisplay('en');
        }
    }
    
    // Watch for translation changes
    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    handleLanguageChange();
                }
            });
        });
        
        // Start observing when page loads
        setTimeout(function() {
            observer.observe(document.body, {
                attributes: true,
                attributeFilter: ['class']
            });
        }, 1500);
    }
    </script>
    
    <!-- Chinese Font Support -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;600;700&family=Noto+Sans+SC:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
    /* Hide Google Translate UI Elements Completely */
    .goog-te-banner-frame,
    .goog-te-balloon-frame,
    .skiptranslate iframe,
    #goog-gt-tt,
    .goog-te-ftab,
    .goog-logo-link,
    .goog-te-gadget-icon {
        display: none !important;
    }
    
    /* Hide the entire Google Translate element since we're using custom */
    #google_translate_element_hidden {
        position: absolute !important;
        left: -9999px !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        overflow: hidden !important;
    }
    
    body {
        top: 0 !important;
        position: relative !important;
    }
    
    /* Chinese Text Support */
    body[class*="translated-"] {
        font-family: 'Noto Sans TC', 'Noto Sans SC', 'Inter', -apple-system, sans-serif;
    }
    
    body.translated-zh-cn {
        font-family: 'Noto Sans SC', 'Inter', -apple-system, sans-serif;
    }
    
    body.translated-zh-tw {
        font-family: 'Noto Sans TC', 'Inter', -apple-system, sans-serif;
    }
    
    /* Custom Language Switcher Styling */
    .language-switcher {
        margin-left: 20px;
        margin-right: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .language-label {
        font-size: 14px;
        color: var(--primary-brown, #8B7355);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    /* Custom Language Select Styling */
    #custom-language-select {
        padding: 6px 10px;
        border: 2px solid var(--primary-brown, #8B7355);
        border-radius: 6px;
        background: white;
        color: var(--primary-brown, #8B7355);
        font-size: 13px;
        font-weight: 500;
        font-family: 'Noto Sans TC', 'Noto Sans SC', 'Inter', -apple-system, sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        outline: none;
        box-shadow: 0 1px 3px rgba(139, 115, 85, 0.1);
        min-width: 140px;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238B7355' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 16px;
        padding-right: 32px;
    }
    
    #custom-language-select:hover {
        border-color: var(--brown-hover, #6B5D4F);
        box-shadow: 0 2px 8px rgba(139, 115, 85, 0.15);
        transform: translateY(-1px);
    }
    
    #custom-language-select:focus {
        border-color: var(--primary-brown, #8B7355);
        box-shadow: 0 0 0 3px rgba(139, 115, 85, 0.1);
    }
    
    #custom-language-select:active {
        transform: translateY(0);
    }
    
    /* Option styling */
    #custom-language-select option {
        padding: 8px 12px;
        font-family: 'Noto Sans TC', 'Noto Sans SC', 'Inter', -apple-system, sans-serif;
        font-weight: 500;
        background: white;
        color: var(--primary-brown, #8B7355);
    }
    
    #custom-language-select option:hover,
    #custom-language-select option:focus {
        background-color: var(--warm-beige, #f5f2ed);
    }
    
    /* Accessibility enhancements */
    #custom-language-select:focus-visible {
        outline: 2px solid var(--primary-brown, #8B7355);
        outline-offset: 2px;
    }
    
    /* Loading state */
    .language-switcher.loading #custom-language-select {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    @media (max-width: 768px) {
        .language-switcher {
            margin: 8px 0;
            justify-content: center;
            gap: 6px;
        }
        
        #custom-language-select {
            padding: 5px 24px 5px 8px;
            font-size: 12px;
            min-width: 120px;
            background-size: 14px;
            background-position: right 6px center;
        }
        
        .language-label {
            font-size: 13px;
        }
    }
    
    @media (max-width: 480px) {
        .language-switcher {
            flex-direction: column;
            gap: 4px;
        }
        
        #custom-language-select {
            min-width: 110px;
            font-size: 11px;
        }
        
        .language-label {
            font-size: 12px;
        }
    }
    
    /* High contrast mode support */
    @media (prefers-contrast: high) {
        #custom-language-select {
            border-width: 3px;
        }
    }
    
    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        #custom-language-select {
            transition: none;
        }
        
        #custom-language-select:hover {
            transform: none;
        }
    }
    </style>
    
    <!-- Google Translate Script -->
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'simple-dental'); ?></a>

    <?php if (is_front_page()): ?>
    <!-- Coming Soon Banner -->
    <div class="coming-soon-banner">
        <div class="container">
            <span class="banner-text">🎉 Coming September 2025! | Modern Dental Care in Las Vegas</span>
        </div>
    </div>
    <?php endif; ?>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) {
                        echo '<div class="custom-logo-wrapper">';
                        the_custom_logo();
                        echo '</div>';
                    } else {
                        ?>
                        <div class="site-title-wrapper">
                            <h1 class="site-title">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    Simple Dental LV
                                </a>
                            </h1>
                        </div>
                        <?php
                    }
                    ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="hamburger"></span>
                        <span class="hamburger"></span>
                        <span class="hamburger"></span>
                        <span class="screen-reader-text"><?php esc_html_e('Menu', 'simple-dental'); ?></span>
                    </button>
                    
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'menu_class'     => 'primary-menu',
                            'container'      => false,
                            'walker'         => new Simple_Dental_Walker_Nav_Menu(),
                            'fallback_cb'    => 'simple_dental_fallback_menu',
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->

                <!-- Language Switcher -->
                <div class="language-switcher">
                    <div class="language-label">
                        <span>🌍</span>
                        <span>Language</span>
                    </div>
                    <select id="custom-language-select" aria-label="Select Language">
                        <option value="en">English</option>
                        <option value="es">Español</option>
                        <option value="zh-TW">繁體中文</option>
                        <option value="zh-CN">简体中文</option>
                    </select>
                </div>

                <!-- Hidden Google Translate Element -->
                <div id="google_translate_element_hidden" style="display: none;"></div>

                <div class="header-cta">
                    <a href="tel:7023024787" class="btn btn-primary">Call Now: (702) 302-4787</a>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay"></div>

<?php
/**
 * Fallback menu if no menu is set
 */
function simple_dental_fallback_menu() {
    echo '<ul id="primary-menu" class="primary-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">About</a></li>';
    echo '<li><a href="' . esc_url(home_url('/services/')) . '">Services</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">Contact</a></li>';
    echo '</ul>';
}
?>