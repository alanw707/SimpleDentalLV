<?php
/**
 * Cavity and gum disease stage guides.
 *
 * Patient education without fees; the priced options live on the Prices page.
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$booking_url = simple_dental_get_booking_url();
$prices_url = simple_dental_with_lang(home_url(simple_dental_get_treatment_guides_path()));
$guides = simple_dental_get_treatment_guides_data();
?>

<main id="primary" class="site-main service-landing treatment-guides">
    <header class="page-header section service-hero" style="background-image: url('<?php echo esc_url(simple_dental_media_url('hero-services-operatory.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
        <div class="page-header-overlay">
            <div class="container">
                <h1 class="page-title"><?php echo esc_html(__t('Cavity & Gum Disease Guides', 'key:health.hero.h1')); ?></h1>
                <p class="page-subtitle"><?php echo esc_html(__t('The stages of cavities and gum disease, the signs to watch for, and how cavities are treated at each stage.', 'key:health.hero.subtitle')); ?></p>
                <div class="hero-buttons">
                    <a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call (702) 302-4787')); ?></a>
                    <a href="<?php echo esc_url($prices_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('Full Price List', 'key:guides.link.prices')); ?></a>
                </div>
            </div>
        </div>
    </header>

    <?php $cavities = $guides['cavities']; ?>
    <section class="section tg-section" id="<?php echo esc_attr($cavities['id']); ?>">
        <div class="container">
            <header class="tg-section__head">
                <h2><?php echo esc_html($cavities['title']); ?></h2>
                <p><?php echo esc_html($cavities['intro']); ?></p>
            </header>

            <div class="tg-scale" aria-hidden="true">
                <span><?php echo esc_html($cavities['scale_start']); ?></span>
                <span class="tg-scale__bar"></span>
                <span><?php echo esc_html($cavities['scale_end']); ?></span>
            </div>

            <ol class="tg-stages tg-stages--5" tabindex="0" aria-label="<?php echo esc_attr($cavities['title']); ?>">
                <?php foreach ($cavities['stages'] as $index => $stage) : ?>
                    <li class="tg-stage tg-stage--<?php echo (int) $index + 1; ?>">
                        <header class="tg-stage__head">
                            <h3 class="tg-stage__name"><?php echo esc_html($stage['name']); ?></h3>
                            <p class="tg-stage__sub"><?php echo esc_html($stage['sub']); ?></p>
                        </header>
                        <div class="tg-stage__body">
                            <h4 class="tg-option__label"><?php echo esc_html($cavities['signs_label']); ?></h4>
                            <ul class="tg-step__points">
                                <?php foreach ($stage['points'] as $point) : ?>
                                    <li><?php echo esc_html($point); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="tg-stage__treatment">
                            <h4 class="tg-option__label"><?php echo esc_html($cavities['treatment_label']); ?></h4>
                            <p><?php echo esc_html($stage['treatment']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <?php $gums = $guides['gums']; ?>
    <section class="section section-alt tg-section" id="<?php echo esc_attr($gums['id']); ?>">
        <div class="container">
            <header class="tg-section__head">
                <h2><?php echo esc_html($gums['title']); ?></h2>
                <p><?php echo esc_html($gums['intro']); ?></p>
            </header>

            <div class="tg-scale" aria-hidden="true">
                <span><?php echo esc_html($gums['scale_start']); ?></span>
                <span class="tg-scale__bar"></span>
                <span><?php echo esc_html($gums['scale_end']); ?></span>
            </div>

            <ol class="tg-stages tg-stages--4" tabindex="0" aria-label="<?php echo esc_attr($gums['title']); ?>">
                <?php foreach ($gums['stages'] as $index => $stage) : ?>
                    <li class="tg-stage tg-stage--<?php echo (int) $index + ($index === 3 ? 2 : 1); ?>">
                        <header class="tg-stage__head">
                            <h3 class="tg-stage__name"><?php echo esc_html($stage['name']); ?></h3>
                            <p class="tg-stage__sub"><?php echo esc_html($stage['sub']); ?></p>
                        </header>
                        <div class="tg-pocket">
                            <span class="tg-pocket__probe" aria-hidden="true"><span style="height: <?php echo (int) round($stage['depth'] / 8 * 100); ?>%"></span></span>
                            <p class="tg-pocket__text"><span class="tg-option__label"><?php echo esc_html($gums['pocket_label']); ?></span> <strong><?php echo esc_html($stage['pocket']); ?></strong></p>
                        </div>
                        <div class="tg-stage__body">
                            <h4 class="tg-option__label"><?php echo esc_html($gums['signs_label']); ?></h4>
                            <ul class="tg-step__points">
                                <?php foreach ($stage['points'] as $point) : ?>
                                    <li><?php echo esc_html($point); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="services-cta">
                <div class="cta-content">
                    <h2><?php echo esc_html(__t('Noticed one of these signs?', 'key:health.final.h2')); ?></h2>
                    <p><?php echo esc_html(__t('Call us and we will take a look. Dr. Chang explains what he sees and what it costs before any treatment begins.', 'key:health.final.copy')); ?></p>
                    <div class="cta-buttons">
                        <a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call (702) 302-4787')); ?></a>
                        <a href="<?php echo esc_url($booking_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('Book Online')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
