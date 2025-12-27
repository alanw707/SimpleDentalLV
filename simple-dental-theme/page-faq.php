<?php
/**
 * Template for FAQ Page
 *
 * Template Name: FAQ Page
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <!-- Page Header -->
        <header class="page-header section" style="background-image: url('<?php echo esc_url(simple_dental_media_url('hero-default-front-desk.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
            <div class="page-header-overlay">
                <div class="container">
                    <h1 class="page-title"><?php echo esc_html(__t('FAQ')); ?></h1>
                    <p class="page-subtitle"><?php echo esc_html(__t('Simple Dental: Honest Answers for Our Las Vegas Patients', 'key:faq.hero_title')); ?></p>
                </div>
            </div>
        </header>

        <section class="faq-hero">
            <div class="container">
                <div class="faq-hero-grid">
                    <aside class="faq-hero-panel">
                        <h2 class="faq-panel-title"><?php echo esc_html(__t('Browse topics')); ?></h2>
                        <details class="faq-panel-collapse" open>
                            <summary><?php echo esc_html(__t('Browse topics')); ?></summary>
                            <nav class="faq-panel-nav" aria-label="<?php echo esc_attr(__t('Frequently Asked Questions')); ?>">
                                <a href="#faq-philosophy" target="_self"><?php echo esc_html(__t('The "Simple & Honest" Philosophy', 'key:faq.section.philosophy')); ?></a>
                                <a href="#faq-crowns" target="_self"><?php echo esc_html(__t('Focus on Crowns & Restorative Care', 'key:faq.section.crowns')); ?></a>
                                <a href="#faq-insurance" target="_self"><?php echo esc_html(__t('Insurance & Payments (For Cash & PPO Patients)', 'key:faq.section.insurance')); ?></a>
                                <a href="#faq-location" target="_self"><?php echo esc_html(__t('Convenience & Location', 'key:faq.section.location')); ?></a>
                            </nav>
                        </details>
                    </aside>
                    <div class="faq-hero-content">
                        <div class="faq-accordion">
                            <div class="faq-group" id="faq-philosophy">
                                <p class="faq-group-label"><?php echo esc_html(__t('The "Simple & Honest" Philosophy', 'key:faq.section.philosophy')); ?></p>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('Why is Simple Dental different from other Las Vegas dentists?', 'key:faq.philosophy.q.different')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(__t('Most dental offices today are owned by large corporations where you see a different doctor every time and feel pressured to buy services you don\'t need. Simple Dental is different. You will see the same experienced dentist every time. We offer a "No Pressure, No Upsell" guarantee. We only recommend what you truly need for a healthy smile.', 'key:faq.philosophy.a.different')); ?></p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('Do I have to worry about hidden fees or "bait and switch" pricing?', 'key:faq.philosophy.q.hidden_fees')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(__t('No. Our name is Simple Dental because we keep pricing simple. We provide upfront, flat-rate pricing for our most common services, like our $199 New Patient Special and our $899 Same-Day Crowns. You will know exactly what you are paying before we ever start treatment.', 'key:faq.philosophy.a.hidden_fees')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-group" id="faq-crowns">
                                <p class="faq-group-label"><?php echo esc_html(__t('Focus on Crowns & Restorative Care', 'key:faq.section.crowns')); ?></p>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('How can Simple Dental offer a permanent crown in just one visit?', 'key:faq.crowns.q.same_day')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(__t('We use advanced digital technology to design and mill your ceramic crown right here in our Las Vegas office. This means you don\'t have to wear a temporary crown for two weeks or come back for a second appointment. You walk in with a problem and walk out with a permanent, high-quality crown in about two hours.', 'key:faq.crowns.a.same_day')); ?></p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('How much does a dental crown cost at Simple Dental?', 'key:faq.crowns.q.cost')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(__t('We offer high-quality, permanent ceramic crowns for $899. This is an all-inclusive, fair price designed for patients who want quality work without the "strip mall" markup.', 'key:faq.crowns.a.cost')); ?></p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('What if I need a crown but I am worried about the cost?', 'key:faq.crowns.q.cost_concern')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(__t('We specialize in helping patients get the care they need without breaking the bank. Because we are an efficient, doctor-owned practice, we keep our overhead low and pass those savings to you. We also offer flexible financing through CareCredit to make your treatment affordable.', 'key:faq.crowns.a.cost_concern')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-group" id="faq-insurance">
                                <p class="faq-group-label"><?php echo esc_html(__t('Insurance & Payments (For Cash & PPO Patients)', 'key:faq.section.insurance')); ?></p>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('Do you accept patients without dental insurance?', 'key:faq.insurance.q.no_insurance')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(__t('Yes! A huge portion of our patients are "cash patients" or self-pay. We have designed our pricing to be affordable for the everyday person who doesn\'t have a big corporate insurance plan. Our $199 New Patient Special is a great way to get started.', 'key:faq.insurance.a.no_insurance')); ?></p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('Which insurance plans does Simple Dental accept?', 'key:faq.insurance.q.plans')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(sprintf(__t('We work with most major PPO dental insurance plans. We are happy to verify your benefits for you before your appointment so there are no surprises. Please call us at %s with your insurance information, and we\'ll do the legwork for you.', 'key:faq.insurance.a.plans'), '<a href="tel:7023024787">(702) 302-4787</a>')); ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-group" id="faq-location">
                                <p class="faq-group-label"><?php echo esc_html(__t('Convenience & Location', 'key:faq.section.location')); ?></p>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('Where is your office located and is there parking?', 'key:faq.location.q.address')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(__t('Simple Dental is located at 204 S Jones Blvd, Las Vegas, NV 89107. We chose this location because it is easy to access with plenty of free parking right in back of the office. You won\'t have to deal with parking garages or long walks.', 'key:faq.location.a.address')); ?></p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('What languages does the staff speak?', 'key:faq.location.q.languages')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(__t('To serve all of Las Vegas, we are a multilingual office. We speak English, Spanish (Español), and Chinese (繁體中文 and 简体中文).', 'key:faq.location.a.languages')); ?></p>
                                    </div>
                                </div>
                                <div class="faq-item">
                                    <h3 class="faq-question"><?php echo esc_html(__t('How do I book an appointment?', 'key:faq.location.q.appointment')); ?></h3>
                                    <div class="faq-answer">
                                        <p><?php echo wp_kses_post(sprintf(__t('Call us at %s to book an appointment. Our team will find a time that works for you and answer any questions.', 'key:faq.location.a.appointment'), '<a href="tel:7023024787">(702) 302-4787</a>')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var panel = document.querySelector('.faq-panel-collapse');
                if (panel && window.innerWidth <= 768) {
                    panel.removeAttribute('open');
                }
            });
        </script>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>
