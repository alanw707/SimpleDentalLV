<?php
/**
 * Treatment Guides & Prices page.
 *
 * Patient-education guides with listed fees so patients can compare options
 * and check prices before they come in.
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$booking_url = simple_dental_get_booking_url();
$services_url = simple_dental_with_lang(home_url('/services/'));
$crowns_url = simple_dental_with_lang(home_url('/same-day-crowns-las-vegas/'));
$health_url = simple_dental_with_lang(home_url(simple_dental_get_dental_health_path()));
$guides = simple_dental_get_treatment_guides_data();
$price_groups = simple_dental_get_treatment_price_list($guides);
?>

<main id="primary" class="site-main service-landing treatment-guides">
    <header class="page-header section service-hero" style="background-image: url('<?php echo esc_url(simple_dental_media_url('hero-services-operatory.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
        <div class="page-header-overlay">
            <div class="container">
                <h1 class="page-title"><?php echo esc_html(simple_dental_guide_t('hero.h1_v2', 'Prices & Treatment Options')); ?></h1>
                <p class="page-subtitle"><?php echo esc_html(simple_dental_guide_t('hero.subtitle_v2', 'Check the price before you come in, then open any guide to compare your options.')); ?></p>
                <div class="hero-buttons">
                    <a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call (702) 302-4787')); ?></a>
                    <a href="<?php echo esc_url($booking_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('Book Online')); ?></a>
                </div>
            </div>
        </div>
    </header>

    <section class="section tg-section tg-prices" id="prices">
        <div class="container">
            <div class="tg-prices__layout">
                <div class="tg-prices__intro">
                    <h2><?php echo esc_html(simple_dental_guide_t('prices.title', 'Prices at a glance')); ?></h2>
                    <p><?php echo esc_html(simple_dental_guide_t('prices.intro', 'These are our listed fees. Dr. Chang confirms which option suits your tooth, and the total cost, at your exam and before any treatment begins.')); ?></p>
                    <p class="tg-note"><?php echo esc_html(simple_dental_guide_t('prices.cash_note', 'These are cash fees. If you use insurance, your cost depends on your plan.')); ?></p>
                    <p class="tg-prices__crown-link"><a href="<?php echo esc_url($crowns_url); ?>"><?php echo esc_html(simple_dental_guide_t('prices.crown_link', 'See how same-day crowns work')); ?></a></p>
                </div>
                <div class="tg-prices__groups">
                    <?php foreach ($price_groups as $group) : ?>
                        <div class="tg-price-group">
                            <h3 class="tg-price-group__title"><a href="#<?php echo esc_attr($group['id']); ?>"><?php echo esc_html($group['title']); ?></a> <span class="tg-price-group__unit"><?php echo esc_html($group['unit']); ?></span></h3>
                            <dl class="tg-price-list">
                                <?php foreach ($group['rows'] as $row) : ?>
                                    <div class="tg-price-list__row">
                                        <dt><?php echo esc_html($row['name']); ?></dt>
                                        <dd><?php echo esc_html($row['price']); ?></dd>
                                    </div>
                                <?php endforeach; ?>
                            </dl>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-alt tg-section tg-guides" id="guides">
        <div class="container">
            <header class="tg-section__head">
                <h2><?php echo esc_html(simple_dental_guide_t('compare.title', 'Compare your options')); ?></h2>
                <p><?php echo esc_html(simple_dental_guide_t('compare.intro', 'Open a guide to see what each option is made of, what it suits, and its trade-offs.')); ?></p>
            </header>

            <?php foreach (array('crowns', 'implants', 'partials', 'dentures') as $guide_key) : ?>
                <?php $guide = $guides[$guide_key]; ?>
                <details class="tg-guide" id="<?php echo esc_attr($guide['id']); ?>">
                    <summary class="tg-guide__summary">
                        <span class="tg-guide__title"><?php echo esc_html($guide['title']); ?></span>
                        <span class="tg-guide__intro"><?php echo esc_html($guide['intro']); ?></span>
                    </summary>
                    <div class="tg-guide__body">
                        <?php if ('implants' === $guide_key) : ?>
                            <?php $implants = $guide; ?>
            <ol class="tg-steps">
                <?php foreach ($implants['steps'] as $step) : ?>
                    <li class="tg-step">
                        <h3 class="tg-step__title"><?php echo esc_html($step['title']); ?></h3>
                        <p class="tg-step__summary"><?php echo esc_html($step['summary']); ?></p>
                        <ul class="tg-step__points">
                            <?php foreach ($step['points'] as $point) : ?>
                                <li><?php echo esc_html($point); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ol>

            <div class="tg-implant-facts">
                <div class="tg-timeline">
                    <h3><?php echo esc_html($implants['timeline_title']); ?></h3>
                    <dl class="tg-price-list">
                        <?php foreach ($implants['timeline'] as $row) : ?>
                            <div class="tg-price-list__row">
                                <dt><?php echo esc_html($row[0]); ?></dt>
                                <dd><?php echo esc_html($row[1]); ?></dd>
                            </div>
                        <?php endforeach; ?>
                        <div class="tg-price-list__row tg-price-list__row--total">
                            <dt><?php echo esc_html($implants['timeline_total_label']); ?></dt>
                            <dd><?php echo esc_html($implants['timeline_total']); ?></dd>
                        </div>
                    </dl>
                    <p class="tg-note"><?php echo esc_html($implants['timeline_note']); ?></p>
                </div>
                <div class="tg-benefits">
                    <h3><?php echo esc_html($implants['benefits_title']); ?></h3>
                    <ul class="tg-list tg-list--pros">
                        <?php foreach ($implants['benefits'] as $benefit) : ?>
                            <li><?php echo esc_html($benefit); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="tg-note"><?php echo esc_html($implants['price_note']); ?></p>
                    <p><a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call (702) 302-4787')); ?></a></p>
                </div>
            </div>
                        <?php else : ?>
                            <?php simple_dental_render_guide_options($guide); ?>
                        <?php endif; ?>
                    </div>
                </details>
            <?php endforeach; ?>

            <p class="tg-guides__more"><a href="<?php echo esc_url($health_url); ?>"><?php echo esc_html(simple_dental_guide_t('compare.health_link', 'How cavities and gum disease progress, and the signs to watch for')); ?></a></p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="services-cta">
                <div class="cta-content">
                    <h2><?php echo esc_html(simple_dental_guide_t('final.h2', 'Not sure which option is right for you?')); ?></h2>
                    <p><?php echo esc_html(simple_dental_guide_t('final.copy', 'We look at your mouth, your budget, and what matters to you, then give you a clear recommendation. No pressure, and no treatment starts before you know the cost.')); ?></p>
                    <div class="cta-buttons">
                        <a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call (702) 302-4787')); ?></a>
                        <a href="<?php echo esc_url($booking_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('Book Online')); ?></a>
                        <a href="<?php echo esc_url($services_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('View All Services & Pricing')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<?php
get_footer();
