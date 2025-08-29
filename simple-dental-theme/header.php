<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Enhanced Google Translate Implementation -->
    <script type="text/javascript">
    class SimpleDentalTranslator {
        constructor() {
            this.isInitialized = false;
            this.currentLanguage = 'en';
            this.supportedLanguages = {
                'en': 'English',
                'es': 'Español', 
                'zh-TW': '繁體中文',
                'zh-CN': '简体中文'
            };
            this.initializationAttempts = 0;
            this.maxAttempts = 5;
            this.debounceTimeout = null;
            
            // Bind methods to maintain context
            this.init = this.init.bind(this);
            this.changeLanguage = this.changeLanguage.bind(this);
            this.handleCustomSelectChange = this.handleCustomSelectChange.bind(this);
        }

        // Initialize Google Translate (called by Google's callback)
        init() {
            try {
                if (typeof google === 'undefined' || !google.translate) {
                    console.warn('Google Translate not available, retrying...');
                    if (this.initializationAttempts < this.maxAttempts) {
                        this.initializationAttempts++;
                        setTimeout(this.init, 1000);
                    } else {
                        console.error('Google Translate failed to load after maximum attempts');
                        this.showFallbackMessage();
                    }
                    return;
                }

                // Create Google Translate instance
                new google.translate.TranslateElement({
                    pageLanguage: 'en',
                    includedLanguages: 'en,es,zh-TW,zh-CN',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                    multilanguagePage: true,
                    autoDisplay: false,
                    gaTrack: false // Disable tracking
                }, 'google_translate_element_hidden');

                // Wait for Google Translate to be ready
                this.waitForGoogleTranslateReady();
                
            } catch (error) {
                console.error('Google Translate initialization error:', error);
                this.showFallbackMessage();
            }
        }

        // Wait for Google Translate widget to be ready
        waitForGoogleTranslateReady() {
            const checkReady = () => {
                const selectElement = document.querySelector('#google_translate_element_hidden select.goog-te-combo');
                
                if (selectElement && selectElement.options && selectElement.options.length > 1) {
                    this.isInitialized = true;
                    this.setupCustomLanguageSelector();
                    console.log('✅ Google Translate initialized successfully');
                } else if (this.initializationAttempts < this.maxAttempts) {
                    this.initializationAttempts++;
                    setTimeout(checkReady, 500);
                } else {
                    console.error('❌ Google Translate widget failed to initialize');
                    this.showFallbackMessage();
                }
            };
            
            setTimeout(checkReady, 500);
        }

        // Setup custom language selector
        setupCustomLanguageSelector() {
            const customSelect = document.getElementById('custom-language-select');
            if (!customSelect) {
                console.error('Custom language selector not found');
                return;
            }

            // Remove existing listeners to prevent duplicates
            customSelect.removeEventListener('change', this.handleCustomSelectChange);
            customSelect.addEventListener('change', this.handleCustomSelectChange);

            // Set initial state
            this.updateCustomSelectValue();
            
            // Monitor for translation changes
            this.observeTranslationChanges();
        }

        // Handle custom select changes with debouncing
        handleCustomSelectChange(event) {
            const selectedLang = event.target.value;
            
            // Clear previous timeout
            if (this.debounceTimeout) {
                clearTimeout(this.debounceTimeout);
            }
            
            // Debounce language changes
            this.debounceTimeout = setTimeout(() => {
                this.changeLanguage(selectedLang);
            }, 150);
        }

        // Change language using Google Translate
        changeLanguage(langCode) {
            if (!this.isInitialized) {
                console.warn('Google Translate not initialized yet');
                return;
            }

            const googleSelect = document.querySelector('#google_translate_element_hidden select.goog-te-combo');
            
            if (!googleSelect) {
                console.error('Google Translate select element not found');
                return;
            }

            try {
                // Find matching option in Google's select
                let foundOption = false;
                for (let i = 0; i < googleSelect.options.length; i++) {
                    const option = googleSelect.options[i];
                    const optionValue = option.value;
                    
                    // Match language codes
                    if ((langCode === 'en' && optionValue === '') ||
                        optionValue === langCode ||
                        optionValue.toLowerCase() === langCode.toLowerCase()) {
                        
                        googleSelect.selectedIndex = i;
                        googleSelect.dispatchEvent(new Event('change', { bubbles: true }));
                        this.currentLanguage = langCode;
                        foundOption = true;
                        console.log(`🌍 Language changed to: ${this.supportedLanguages[langCode]}`);
                        break;
                    }
                }

                if (!foundOption) {
                    console.warn(`Language ${langCode} not found in Google Translate options`);
                }

            } catch (error) {
                console.error('Error changing language:', error);
            }
        }

        // Update custom select to match current translation state
        updateCustomSelectValue() {
            const googleSelect = document.querySelector('#google_translate_element_hidden select.goog-te-combo');
            const customSelect = document.getElementById('custom-language-select');

            if (!googleSelect || !customSelect) return;

            try {
                const currentValue = googleSelect.value || 'en';
                const normalizedValue = currentValue === '' ? 'en' : currentValue;
                
                if (customSelect.value !== normalizedValue) {
                    customSelect.value = normalizedValue;
                    this.currentLanguage = normalizedValue;
                }
            } catch (error) {
                console.error('Error updating custom select:', error);
            }
        }

        // Observe translation changes in the body element
        observeTranslationChanges() {
            if (typeof MutationObserver === 'undefined') return;

            const observer = new MutationObserver((mutations) => {
                let shouldUpdate = false;
                
                mutations.forEach((mutation) => {
                    if (mutation.type === 'attributes' && 
                        (mutation.attributeName === 'class' || mutation.attributeName === 'lang')) {
                        shouldUpdate = true;
                    }
                });

                if (shouldUpdate) {
                    // Debounce updates
                    clearTimeout(this.debounceTimeout);
                    this.debounceTimeout = setTimeout(() => {
                        this.syncLanguageState();
                    }, 300);
                }
            });

            // Start observing body for class changes
            observer.observe(document.body, {
                attributes: true,
                attributeFilter: ['class', 'lang']
            });
        }

        // Sync language state based on body classes
        syncLanguageState() {
            const bodyClasses = document.body.className;
            let detectedLanguage = 'en';

            if (bodyClasses.includes('translated-zh-cn')) {
                detectedLanguage = 'zh-CN';
            } else if (bodyClasses.includes('translated-zh-tw')) {
                detectedLanguage = 'zh-TW';
            } else if (bodyClasses.includes('translated-es')) {
                detectedLanguage = 'es';
            }

            if (detectedLanguage !== this.currentLanguage) {
                this.currentLanguage = detectedLanguage;
                
                const customSelect = document.getElementById('custom-language-select');
                if (customSelect && customSelect.value !== detectedLanguage) {
                    customSelect.value = detectedLanguage;
                }
            }
        }

        // Show fallback message when Google Translate fails
        showFallbackMessage() {
            const customSelect = document.getElementById('custom-language-select');
            if (customSelect) {
                customSelect.disabled = true;
                customSelect.style.opacity = '0.6';
                
                // Add error message
                const errorMsg = document.createElement('small');
                errorMsg.textContent = 'Translation temporarily unavailable';
                errorMsg.style.color = '#d32f2f';
                errorMsg.style.fontSize = '11px';
                errorMsg.style.display = 'block';
                errorMsg.style.marginTop = '4px';
                customSelect.parentNode.appendChild(errorMsg);
            }
        }
    }

    // Global instance
    window.simpleDentalTranslator = new SimpleDentalTranslator();

    // Google Translate callback (required by Google)
    function googleTranslateElementInit() {
        window.simpleDentalTranslator.init();
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Small delay to ensure everything is loaded
        setTimeout(() => {
            if (!window.simpleDentalTranslator.isInitialized) {
                window.simpleDentalTranslator.init();
            }
        }, 1000);
    });
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
    .goog-te-gadget-icon,
    .goog-te-menu-value,
    .goog-te-gadget-simple {
        display: none !important;
        visibility: hidden !important;
    }
    
    /* Hide the entire Google Translate element since we're using custom */
    #google_translate_element_hidden {
        position: absolute !important;
        left: -9999px !important;
        top: -9999px !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        width: 0 !important;
        overflow: hidden !important;
        z-index: -1 !important;
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
        position: relative;
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
    
    #custom-language-select:hover:not(:disabled) {
        border-color: var(--brown-hover, #6B5D4F);
        box-shadow: 0 2px 8px rgba(139, 115, 85, 0.15);
        transform: translateY(-1px);
    }
    
    #custom-language-select:focus {
        border-color: var(--primary-brown, #8B7355);
        box-shadow: 0 0 0 3px rgba(139, 115, 85, 0.1);
    }
    
    #custom-language-select:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    #custom-language-select:active:not(:disabled) {
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
    
    /* Accessibility enhancements */
    #custom-language-select:focus-visible {
        outline: 2px solid var(--primary-brown, #8B7355);
        outline-offset: 2px;
    }
    
    /* Loading/error states */
    .language-switcher.loading #custom-language-select {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .language-switcher .error-message {
        color: #d32f2f;
        font-size: 11px;
        margin-top: 4px;
        display: block;
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
    
    <!-- Google Translate Script - Load only once here -->
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit&hl=en" async defer></script>
    
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

                <!-- Enhanced Language Switcher -->
                <div class="language-switcher">
                    <div class="language-label">
                        <span>🌍</span>
                        <span>Language</span>
                    </div>
                    <select id="custom-language-select" aria-label="Select Language" title="Choose your preferred language">
                        <option value="en">English</option>
                        <option value="es">Español</option>
                        <option value="zh-TW">繁體中文</option>
                        <option value="zh-CN">简体中文</option>
                    </select>
                </div>

                <!-- Hidden Google Translate Element -->
                <div id="google_translate_element_hidden" aria-hidden="true"></div>

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