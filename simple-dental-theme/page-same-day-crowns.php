<?php
/**
 * Same-Day Crowns SEO landing page.
 */

get_header();

$booking_url = simple_dental_get_booking_url();
$services_url = simple_dental_with_lang(home_url('/services/'));
$contact_url = simple_dental_with_lang(home_url('/contact/'));
$faq_url = simple_dental_with_lang(home_url('/faq/'));
?>

<main id="primary" class="site-main service-landing same-day-crowns-page">
    <header class="page-header section service-hero" style="background-image: url('<?php echo esc_url(simple_dental_media_url('services-tech-lab-milling.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
        <div class="page-header-overlay">
            <div class="container">
                <p class="service-eyebrow"><?php echo esc_html(__t('Transparent one-visit crown care', 'key:crowns.hero.eyebrow')); ?></p>
                <h1 class="page-title"><?php echo esc_html(__t('Same-Day Crowns in Las Vegas', 'key:crowns.hero.h1')); ?></h1>
                <p class="page-subtitle"><?php echo esc_html(__t('A permanent ceramic crown designed, milled, and placed in one visit at Simple Dental — no temporary crown, no second appointment, and no pressure.', 'key:crowns.hero.subtitle')); ?></p>
                <div class="hero-buttons">
                    <a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call (702) 302-4787')); ?></a>
                    <a href="<?php echo esc_url($booking_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('Book Online')); ?></a>
                </div>
                <p class="hero-booking-note"><?php echo esc_html(__t('$899 transparent crown pricing when a standard crown is appropriate.', 'key:crowns.hero.price_note')); ?></p>
            </div>
        </div>
    </header>

    <section class="section service-summary-section">
        <div class="container">
            <div class="service-summary-grid">
                <article class="service-summary-card service-summary-card-featured">
                    <h2><?php echo esc_html(__t('One visit. One dentist. One clear price.', 'key:crowns.summary.h2')); ?></h2>
                    <p><?php echo esc_html(__t('Simple Dental uses digital scanning and in-office milling to make same-day crowns faster, cleaner, and easier to understand. Dr. Charles Chang evaluates your tooth, explains your options, and only recommends a crown when it truly makes sense for your dental health.', 'key:crowns.summary.copy')); ?></p>
                </article>
                <article class="service-summary-card">
                    <h3><?php echo esc_html(__t('Typical visit time', 'key:crowns.summary.time_label')); ?></h3>
                    <p><?php echo esc_html(__t('About 2–3 hours from scan to final placement.', 'key:crowns.summary.time_copy')); ?></p>
                </article>
                <article class="service-summary-card">
                    <h3><?php echo esc_html(__t('Transparent fee', 'key:crowns.summary.price_label')); ?></h3>
                    <p><?php echo esc_html(__t('$899 for a standard same-day ceramic crown. If a buildup or other treatment is needed, we explain that before care begins.', 'key:crowns.summary.price_copy')); ?></p>
                </article>
            </div>
        </div>
    </section>

    <section class="section section-alt">
        <div class="container">
            <div class="media-split service-process-split">
                <div class="media-split-content">
                    <h2><?php echo esc_html(__t('How same-day crowns work', 'key:crowns.process.h2')); ?></h2>
                    <p><?php echo esc_html(__t('Instead of sending a mold to an outside lab, we scan your tooth digitally and create your crown in our Las Vegas office. That means fewer appointments, no temporary crown for two weeks, and a more comfortable process from start to finish.', 'key:crowns.process.copy')); ?></p>
                    <ol class="service-steps">
                        <li><strong><?php echo esc_html(__t('Exam and clear recommendation', 'key:crowns.step1.title')); ?></strong><span><?php echo esc_html(__t('We check the tooth, explain what we see, and discuss whether a crown, filling, or another option is best.', 'key:crowns.step1.copy')); ?></span></li>
                        <li><strong><?php echo esc_html(__t('Digital scan', 'key:crowns.step2.title')); ?></strong><span><?php echo esc_html(__t('A small scanner captures a 3D model of your tooth without goopy impression material.', 'key:crowns.step2.copy')); ?></span></li>
                        <li><strong><?php echo esc_html(__t('In-office milling', 'key:crowns.step3.title')); ?></strong><span><?php echo esc_html(__t('Your ceramic crown is designed and milled right here using modern digital equipment.', 'key:crowns.step3.copy')); ?></span></li>
                        <li><strong><?php echo esc_html(__t('Final fit and placement', 'key:crowns.step4.title')); ?></strong><span><?php echo esc_html(__t('Dr. Chang checks the bite, fit, and appearance before bonding the permanent crown.', 'key:crowns.step4.copy')); ?></span></li>
                    </ol>
                </div>
                <figure class="media-split-image">
                    <?php echo simple_dental_media_image('services-tech-operatory.jpg', __t('Simple Dental operatory for same-day crown visits', 'key:crowns.process.image_alt')); ?>
                </figure>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="services-info-grid service-benefit-grid">
                <div class="info-card">
                    <h3><?php echo esc_html(__t('No temporary crown', 'key:crowns.benefit.temp.title')); ?></h3>
                    <p><?php echo esc_html(__t('Because the final crown is made the same day, you can skip the temporary crown stage in many cases.', 'key:crowns.benefit.temp.copy')); ?></p>
                </div>
                <div class="info-card">
                    <h3><?php echo esc_html(__t('Fewer appointments', 'key:crowns.benefit.appointments.title')); ?></h3>
                    <p><?php echo esc_html(__t('Most same-day crowns are completed in one visit, which helps patients with work, school, and family schedules.', 'key:crowns.benefit.appointments.copy')); ?></p>
                </div>
                <div class="info-card">
                    <h3><?php echo esc_html(__t('Natural-looking ceramic', 'key:crowns.benefit.ceramic.title')); ?></h3>
                    <p><?php echo esc_html(__t('Modern ceramic materials are selected to restore strength while blending with your smile.', 'key:crowns.benefit.ceramic.copy')); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-alt service-price-section">
        <div class="container">
            <div class="service-price-card">
                <div>
                    <p class="service-eyebrow"><?php echo esc_html(__t('Simple Dental crown pricing', 'key:crowns.price.eyebrow')); ?></p>
                    <h2><?php echo esc_html(__t('$899 Same-Day Crown', 'key:crowns.price.h2')); ?></h2>
                    <p><?php echo esc_html(__t('Our crown fee is designed to be clear and fair for Las Vegas patients who want quality work without surprise pricing. If your tooth needs a buildup, root canal, extraction, or another service first, we explain the reason and cost before treatment.', 'key:crowns.price.copy')); ?></p>
                </div>
                <div class="service-price-actions">
                    <a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call About Same-Day Crowns')); ?></a>
                    <a href="<?php echo esc_url($services_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('View All Services & Pricing')); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="section-heading-center"><?php echo esc_html(__t('Same-day crowns may help when you have:', 'key:crowns.need.h2')); ?></h2>
            <div class="services-info-grid service-need-grid">
                <div class="info-card"><p><?php echo esc_html(__t('A cracked or broken tooth', 'key:crowns.need.cracked')); ?></p></div>
                <div class="info-card"><p><?php echo esc_html(__t('A large worn-out filling', 'key:crowns.need.filling')); ?></p></div>
                <div class="info-card"><p><?php echo esc_html(__t('A weak tooth that needs protection', 'key:crowns.need.weak')); ?></p></div>
                <div class="info-card"><p><?php echo esc_html(__t('A tooth restored after root canal treatment', 'key:crowns.need.root_canal')); ?></p></div>
            </div>
        </div>
    </section>

    <section class="section section-alt">
        <div class="container">
            <div class="faq-section service-faq-block">
                <h2><?php echo esc_html(__t('Same-Day Crown Questions', 'key:crowns.faq.h2')); ?></h2>
                <div class="faq-grid">
                    <div class="faq-item">
                        <h4><?php echo esc_html(__t('Are same-day crowns permanent?', 'key:crowns.faq.q1')); ?></h4>
                        <p><?php echo esc_html(__t('Yes. When appropriate for your tooth, the crown placed at Simple Dental is the final ceramic crown, not a temporary crown.', 'key:crowns.faq.a1')); ?></p>
                    </div>
                    <div class="faq-item">
                        <h4><?php echo esc_html(__t('How long does a same-day crown appointment take?', 'key:crowns.faq.q2')); ?></h4>
                        <p><?php echo esc_html(__t('Most visits take about 2–3 hours, depending on the tooth, scan, design, milling, and final bite adjustments.', 'key:crowns.faq.a2')); ?></p>
                    </div>
                    <div class="faq-item">
                        <h4><?php echo esc_html(__t('What if I need a buildup first?', 'key:crowns.faq.q3')); ?></h4>
                        <p><?php echo esc_html(__t('If the tooth needs a buildup or another service before the crown, we explain why and review the fee before starting treatment.', 'key:crowns.faq.a3')); ?></p>
                    </div>
                    <div class="faq-item">
                        <h4><?php echo esc_html(__t('Can I book online?', 'key:crowns.faq.q4')); ?></h4>
                        <p><?php echo wp_kses_post(sprintf(__t('Yes. You can %s, or call us at %s if you want help deciding what type of visit to schedule.', 'key:crowns.faq.a4'), '<a href="' . esc_url($booking_url) . '">' . esc_html(__t('book online')) . '</a>', '<a href="tel:7023024787">(702) 302-4787</a>')); ?></p>
                    </div>
                </div>
                <p class="service-faq-link"><a href="<?php echo esc_url($faq_url); ?>"><?php echo esc_html(__t('Read more Simple Dental FAQs', 'key:crowns.faq.more')); ?></a></p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="services-cta">
                <div class="cta-content">
                    <h2><?php echo esc_html(__t('Need a Crown in Las Vegas?', 'key:crowns.final.h2')); ?></h2>
                    <p><?php echo esc_html(__t('Call Simple Dental first. We will explain your options clearly, keep pricing transparent, and help you choose the right appointment.', 'key:crowns.final.copy')); ?></p>
                    <div class="cta-buttons">
                        <a href="tel:7023024787" class="btn btn-primary"><?php echo esc_html(__t('Call (702) 302-4787')); ?></a>
                        <a href="<?php echo esc_url($booking_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('Book Online')); ?></a>
                        <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-secondary"><?php echo esc_html(__t('Contact Us Online')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
