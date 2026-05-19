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


