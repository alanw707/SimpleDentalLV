<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Custom lightweight translation system active -->
    
    <!-- Font preloading for better performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
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
            <span class="banner-text"><?php echo __t('🎉 Coming October 2025! | Modern Dental Care in Las Vegas'); ?></span>
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
                                <a href="<?php echo esc_url(simple_dental_with_lang(home_url('/'))); ?>" rel="home">
                                    Simple Dental LV
                                </a>
                            </h1>
                        </div>
                        <?php
                    }
                    ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Main navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle mobile menu">
                        <span class="hamburger" aria-hidden="true"></span>
                        <span class="hamburger" aria-hidden="true"></span>
                        <span class="hamburger" aria-hidden="true"></span>
                        <span class="screen-reader-text"><?php esc_html_e('Menu', 'simple-dental'); ?></span>
                    </button>
                    
                    <?php
                    // Force translated fallback menu for multilingual support
                    simple_dental_fallback_menu();
                    ?>
                </nav><!-- #site-navigation -->

                <!-- Language switcher for multilingual support -->
                <div class="language-switcher-wrapper">
                    <?php echo simple_dental_language_switcher(); ?>
                </div>

                <div class="header-cta">
                    <a href="tel:7023024787" class="btn btn-primary"><?php echo __t('Call Us'); ?>: (702) 302-4787</a>
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
    // Language switcher for mobile menu (as first menu item)
    echo '<li class="language-switcher-item">';
    echo '  <div class="language-switcher-wrapper">';
    echo        simple_dental_language_switcher();
    echo '  </div>';
    echo '</li>';
    echo '<li><a href="' . esc_url(simple_dental_with_lang(home_url('/'))) . '"><svg class="menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg><span class="menu-text">' . __t('Home') . '</span></a></li>';
    echo '<li><a href="' . esc_url(simple_dental_with_lang(home_url('/about/'))) . '"><svg class="menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span class="menu-text">' . __t('About') . '</span></a></li>';
    echo '<li><a href="' . esc_url(simple_dental_with_lang(home_url('/services/'))) . '"><svg class="menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6"/><path d="M1 12h6m6 0h6"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/><circle cx="5" cy="12" r="1"/><circle cx="19" cy="12" r="1"/></svg><span class="menu-text">' . __t('Services') . '</span></a></li>';
    echo '<li><a href="' . esc_url(simple_dental_with_lang(home_url('/contact/'))) . '"><svg class="menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg><span class="menu-text">' . __t('Contact') . '</span></a></li>';
    echo '</ul>';
}
?>
