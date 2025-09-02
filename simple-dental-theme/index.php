<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php if (is_front_page() && is_home()) : ?>
        
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1><?php echo __t('Welcome to Simple Dental'); ?></h1>
                <p class="subtitle"><?php echo __t('Quality dental care for the whole family'); ?></p>
                <div class="hero-buttons">
                    <a href="#services" class="btn btn-primary"><?php echo __t('Our Services'); ?></a>
                    <a href="tel:7023024787" class="btn btn-secondary"><?php echo __t('Call Us'); ?> (702) 302-4787</a>
                </div>
            </div>
        </section>

        <!-- About Preview Section -->
        <section class="section">
            <div class="container">
                <div class="about-preview">
                    <div class="about-content">
                        <h2><?php echo __t('Welcome to Simple Dental'); ?></h2>
                        <p>At Simple Dental, we believe dentistry shouldn't be confusing or pushy. You'll always see the same dentist — me — and we'll only recommend what you truly need.</p>
                        
                        <p>With digital tools like same-day crowns and efficient systems, we make your visit fast, comfortable, and transparent. No hidden fees, no pressure, just honest care for everyday working families.</p>
                        
                        <div class="about-features">
                            <div class="feature">
                                <h4><?php echo __t('Years of Experience'); ?></h4>
                                <p><?php echo __t('Professional Staff'); ?></p>
                            </div>
                            <div class="feature">
                                <h4><?php echo __t('Happy Patients'); ?></h4>
                                <p><?php echo __t('Quality dental care for the whole family'); ?></p>
                            </div>
                            <div class="feature">
                                <h4><?php echo __t('Modern Equipment'); ?></h4>
                                <p><?php echo __t('Professional Staff'); ?></p>
                            </div>
                        </div>
                        
                        <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn-primary">Learn More About Us</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Preview Section -->
        <section class="section section-alt" id="services">
            <div class="container">
                <h2 style="text-align: center; margin-bottom: 40px;"><?php echo __t('Our Services'); ?></h2>
                
                <?php echo do_shortcode('[simple_dental_services]'); ?>
                
                <div style="text-align: center; margin-top: 40px;">
                    <p><strong>No surprises. No hidden fees.</strong> Patients know upfront what to expect.</p>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>" class="btn btn-primary">View All Services</a>
                </div>
            </div>
        </section>

        <!-- Contact Preview Section -->
        <section class="section">
            <div class="container">
                <h2 style="text-align: center; margin-bottom: 40px;"><?php echo __t('Contact'); ?></h2>
                
                <div class="contact-info">
                    <div class="contact-card">
                        <h4>Our Location</h4>
                        <p><strong>204 S Jones Blvd</strong><br>
                        Las Vegas, NV 89149</p>
                        <p>Convenient location with easy parking</p>
                    </div>
                    
                    <div class="contact-card">
                        <h4>Office Hours</h4>
                        <p><strong>Monday - Friday</strong><br>
                        8:00 AM - 4:00 PM</p>
                        <p><strong>Weekends:</strong> Closed</p>
                    </div>
                    
                    <div class="contact-card">
                        <h4><?php echo __t('Schedule Appointment'); ?></h4>
                        <p><strong><a href="tel:7023024787">(702) 302-4787</a></strong></p>
                        <p>Call to schedule your visit</p>
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary"><?php echo __t('Contact'); ?></a>
                    </div>
                </div>
            </div>
        </section>

    <?php else : ?>
        
        <!-- Standard Blog/Page Content -->
        <?php if (have_posts()) : ?>
            
            <div class="container">
                <div class="content-area section">
                    
                    <?php while (have_posts()) : the_post(); ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <?php
                                if (is_singular()) :
                                    the_title('<h1 class="entry-title">', '</h1>');
                                else :
                                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                endif;
                                ?>
                            </header>

                            <div class="entry-content">
                                <?php
                                if (is_singular()) :
                                    the_content();
                                else :
                                    the_excerpt();
                                endif;

                                wp_link_pages(
                                    array(
                                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'simple-dental'),
                                        'after'  => '</div>',
                                    )
                                );
                                ?>
                            </div>

                            <?php if (!is_singular()) : ?>
                            <footer class="entry-footer">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-secondary">Read More</a>
                            </footer>
                            <?php endif; ?>
                        </article>

                    <?php endwhile; ?>

                    <?php
                    // Pagination for blog posts
                    if (!is_singular()) :
                        the_posts_navigation(
                            array(
                                'prev_text' => __('&larr; Older Posts', 'simple-dental'),
                                'next_text' => __('Newer Posts &rarr;', 'simple-dental'),
                            )
                        );
                    endif;
                    ?>
                    
                </div>
            </div>

        <?php else : ?>
            
            <div class="container">
                <div class="content-area section">
                    <div class="no-results">
                        <h1><?php esc_html_e('Nothing Found', 'simple-dental'); ?></h1>
                        <p><?php esc_html_e('It looks like nothing was found at this location.', 'simple-dental'); ?></p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Go Home</a>
                    </div>
                </div>
            </div>

        <?php endif; ?>
        
    <?php endif; ?>

</main><!-- #main -->

<style>
/* Additional styles for index page */
.about-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin: 40px 0;
}

.feature {
    text-align: center;
    padding: 20px;
}

.feature h4 {
    color: var(--accent-teal);
    margin-bottom: 10px;
}

.hero-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 30px;
    flex-wrap: wrap;
}

.about-preview {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.entry-header {
    text-align: center;
    margin-bottom: 30px;
}

.entry-content {
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
}

.entry-footer {
    text-align: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--light-gray);
}

.posts-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid var(--light-gray);
}

.no-results {
    text-align: center;
    padding: 60px 20px;
}

@media (max-width: 768px) {
    .hero-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .about-features {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
?>