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
    <a class="skip-link screen-reader-text" href="#primary"><?php echo esc_html(__t('Skip to content')); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content header-layout">
                <div class="site-branding header-brand-region">
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

                <a href="tel:7023024787" class="header-call" aria-label="<?php echo esc_attr(__t('Call (702) 302-4787')); ?>">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </a>

                <nav id="site-navigation" class="main-navigation header-nav-region" role="navigation" aria-label="<?php echo esc_attr(__t('Main navigation')); ?>">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php echo esc_attr(__t('Toggle mobile menu')); ?>">
                        <span class="hamburger" aria-hidden="true"></span>
                        <span class="hamburger" aria-hidden="true"></span>
                        <span class="hamburger" aria-hidden="true"></span>
                        <span class="screen-reader-text"><?php echo esc_html(__t('Menu')); ?></span>
                    </button>
                    
                    <?php
                    // Force translated fallback menu for multilingual support
                    simple_dental_render_header_navigation();
                    ?>
                </nav><!-- #site-navigation -->

                <!-- Language switcher for multilingual support -->
                <div class="language-switcher-wrapper header-utility-region">
                    <?php echo simple_dental_language_switcher(); ?>
                </div>

                <div class="header-cta header-action-region">
                    <a href="tel:7023024787" class="btn btn-primary"><?php echo __t('Call Us'); ?>: (702) 302-4787</a>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay"></div>


