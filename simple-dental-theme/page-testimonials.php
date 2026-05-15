<?php
/**
 * Testimonials / Google Reviews page.
 */

get_header();

$booking_url = simple_dental_get_booking_url();
$services_url = simple_dental_with_lang(home_url('/services/'));
$contact_url = simple_dental_with_lang(home_url('/contact/'));
$google_meta = simple_dental_get_google_reviews_meta();
$google_reviews = simple_dental_get_google_reviews();
$google_url = !empty($google_meta['google_url']) ? $google_meta['google_url'] : '';
?>

<main id="primary" class="site-main testimonials-page">
    <header class="page-header section testimonials-hero" style="background-image: url('<?php echo esc_url(simple_dental_media_url('hero-home-reception-wide.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
        <div class="page-header-overlay">
            <div class="container">
                <p class="service-eyebrow"><?php echo esc_html(__t('Patient Reviews')); ?></p>
                <h1 class="page-title"><?php echo esc_html(__t('Patient Reviews for Simple Dental')); ?></h1>
                <p class="page-subtitle"><?php echo esc_html(__t('Real feedback from patients who chose Simple Dental for honest, no-pressure care in Las Vegas.')); ?></p>
                <div class="hero-buttons">
                    <a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call (702) 302-4787')); ?></a>
                    <a href="<?php echo esc_url($booking_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('Book Online')); ?></a>
                </div>
            </div>
        </div>
    </header>

    <section class="section testimonials-summary-section">
        <div class="container">
            <div class="testimonials-summary-card">
                <div>
                    <p class="section-eyebrow"><?php echo esc_html(__t('Google Reviews')); ?></p>
                    <h2><?php echo esc_html(__t('Trust built through clear, honest dental care.')); ?></h2>
                    <p><?php echo esc_html(__t('These Google reviews reflect patient experiences with Simple Dental’s clean office, clear communication, and no-pressure approach.')); ?></p>
                </div>
                <div class="testimonials-rating-panel">
                    <span class="google-wordmark">Google</span>
                    <?php if (!empty($google_meta['rating'])) : ?>
                        <strong class="rating-number"><?php echo esc_html($google_meta['rating']); ?></strong>
                        <?php echo simple_dental_render_review_stars((int) round((float) $google_meta['rating'])); ?>
                    <?php else : ?>
                        <strong class="rating-number rating-placeholder"><?php echo esc_html(__t('Reviews coming soon')); ?></strong>
                    <?php endif; ?>
                    <?php if (!empty($google_meta['review_count'])) : ?>
                        <p><?php echo esc_html(sprintf(__t('Based on %s Google reviews'), $google_meta['review_count'])); ?></p>
                    <?php else : ?>
                        <p><?php echo esc_html(__t('Waiting for copied Google review count and rating.')); ?></p>
                    <?php endif; ?>
                    <?php if ($google_url) : ?>
                        <a href="<?php echo esc_url($google_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html(__t('Open Simple Dental on Google')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-alt">
        <div class="container">
            <div class="section-heading-block">
                <p class="section-eyebrow"><?php echo esc_html(__t('All Reviews')); ?></p>
                <h2><?php echo esc_html(__t('More Patient Experiences')); ?></h2>
                <p><?php echo esc_html(__t('Browse the Google reviews currently shared with Simple Dental for this page.')); ?></p>
            </div>
            <div class="reviews-card-grid reviews-all-grid">
                <?php
                if (!empty($google_reviews)) {
                    foreach ($google_reviews as $review) {
                        echo simple_dental_render_google_review_card($review);
                    }
                } else {
                    echo simple_dental_render_reviews_empty_state();
                }
                ?>
            </div>
        </div>
    </section>

    <section class="section section-alt">
        <div class="container">
            <div class="services-cta testimonials-cta">
                <div class="cta-content">
                    <h2><?php echo esc_html(__t('Looking for a Las Vegas dentist you can trust?')); ?></h2>
                    <p><?php echo esc_html(__t('Call Simple Dental and we will help you choose the right appointment with clear answers and no pressure.')); ?></p>
                    <div class="cta-buttons">
                        <a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call (702) 302-4787')); ?></a>
                        <a href="<?php echo esc_url($booking_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('Book Online')); ?></a>
                        <a href="<?php echo esc_url($services_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('View Services & Pricing')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
