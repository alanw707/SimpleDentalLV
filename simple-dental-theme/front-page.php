<?php
/**
 * Front Page Template
 * 
 * This template is specifically for the homepage and takes priority over index.php
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Hero Section -->
    <section class="hero" style="background-image: url('https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=1200&q=80'); background-size: cover; background-position: center;">
        <div class="hero-overlay">
            <div class="container">
                <h1><?php echo __t('Straightforward Dentistry from one Experienced Doctor.'); ?></h1>
                <p class="subtitle"><?php echo __t('No pressure. No upsell. Just honest, transparent dental care with modern technology and fair pricing.'); ?></p>
                <div class="hero-buttons">
                    <a href="#services" class="btn btn-primary"><?php echo __t('View Our Services'); ?></a>
                    <a href="tel:7023024787" class="btn btn-secondary"><?php echo __t('Call (702) 302-4787'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Preview Section -->
    <section class="section">
        <div class="container">
            <!-- Main Story -->
            <div class="about-story">
                <h2><?php echo __t('What Simple Dental Stands For'); ?></h2>
                <p><?php echo __t("At Simple Dental, we believe dentistry shouldn't be confusing or pushy. You'll always see the same dentist — me — and we'll only recommend what you truly need."); ?></p>
                
                <p><?php echo __t("With digital tools and efficient systems, we make your visit fast, comfortable, and transparent. This isn't about fancy amenities or high-pressure sales — it's about delivering honest, quality dental care that working families can afford."); ?></p>
            </div>

            <!-- Practice Philosophy -->
            <div class="about-philosophy">
                <div class="philosophy-content">
                    <h2><?php echo __t('How We\'re Different'); ?></h2>
                    <div class="philosophy-grid">
                        <div class="philosophy-item">
                            <div class="philosophy-icon">🩺</div>
                            <h3><?php echo __t('One Doctor, Always'); ?></h3>
                            <p><?php echo __t("You'll see the same experienced dentist every visit. No rotating providers, no bait-and-switch."); ?></p>
                        </div>
                        
                        <div class="philosophy-item">
                            <div class="philosophy-icon">💰</div>
                            <h3><?php echo __t('Transparent Pricing'); ?></h3>
                            <p><?php echo __t("Know exactly what you'll pay before treatment begins. No surprise bills, no hidden fees."); ?></p>
                        </div>
                        
                        <div class="philosophy-item">
                            <div class="philosophy-icon">⚡</div>
                            <h3><?php echo __t('Modern Efficiency'); ?></h3>
                            <p><?php echo __t('Same-day crowns, digital technology, and streamlined systems for better outcomes.'); ?></p>
                        </div>
                        
                        <div class="philosophy-item">
                            <div class="philosophy-icon">🤝</div>
                            <h3><?php echo __t('No Pressure'); ?></h3>
                            <p><?php echo __t('We recommend only what you truly need. Just honest recommendations based on your dental health.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 2rem;">
                <a href="<?php echo esc_url(simple_dental_with_lang(home_url('/about/'))); ?>" class="btn btn-primary"><?php echo __t('Learn More About Our Practice'); ?></a>
            </div>
        </div>
    </section>

    <!-- New Patient Special Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--warm-beige) 0%, var(--off-white) 100%);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2><?php echo __t('Start Your Journey to Better Oral Health'); ?></h2>
                <p style="font-size: 1.125rem; color: var(--text-medium); max-width: 600px; margin: 0 auto;">
                    <?php echo __t("New to Simple Dental? We're offering a comprehensive introduction to our practice."); ?>
                </p>
            </div>
            
            <?php echo do_shortcode('[new_patient_special]'); ?>
        </div>
    </section>

    <!-- Services Preview Section -->
    <section class="section section-alt" id="services">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 40px;"><?php echo __t('Our Most Popular Services'); ?></h2>
            <p style="text-align: center; margin-bottom: 2rem; font-size: 1.125rem; color: var(--text-medium);">
                <?php echo __t('Transparent pricing on the services our patients need most'); ?>
            </p>
            
            <?php echo do_shortcode('[featured_services]'); ?>
            
            <div style="text-align: center; margin-top: 40px;">
                <p><strong><?php echo __t('No surprises. No hidden fees.'); ?></strong> <?php echo __t('Patients know upfront what to expect.'); ?></p>
                <a href="<?php echo esc_url(simple_dental_with_lang(home_url('/services/'))); ?>" class="btn btn-primary"><?php echo __t('View All Services & Pricing'); ?></a>
            </div>
        </div>
    </section>

    <!-- Contact Preview Section -->
    <section class="section">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 40px;"><?php echo __t('Visit Us in Las Vegas'); ?></h2>
            
            <div class="contact-info">
                <div class="contact-card">
                    <h4><?php echo __t('Our Location'); ?></h4>
                    <p><strong>204 S Jones Blvd</strong><br>
                    Las Vegas, NV 89149</p>
                    <p><?php echo __t('Convenient location with easy parking'); ?></p>
                </div>
                
                <div class="contact-card">
                    <h4><?php echo __t('Office Hours'); ?></h4>
                    <p><strong><?php echo __t('Monday - Friday'); ?></strong><br>
                    8:00 AM - 4:00 PM</p>
                    <p><strong><?php echo __t('Weekends:'); ?></strong> <?php echo __t('Closed'); ?></p>
                </div>
                
                <div class="contact-card">
                    <h4><?php echo __t('Schedule Appointment'); ?></h4>
                    <p><strong><a href="tel:7023024787">(702) 302-4787</a></strong></p>
                    <p><?php echo __t('Call to schedule your visit'); ?></p>
                    <a href="<?php echo esc_url(simple_dental_with_lang(home_url('/contact/'))); ?>" class="btn btn-primary"><?php echo __t('Contact Us'); ?></a>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- Styles moved to style.css (Front page section) -->

<?php
get_footer();
?>
