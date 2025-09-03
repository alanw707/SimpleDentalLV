<?php
/**
 * Template for Services Page
 * 
 * Template Name: Services Page
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Page Header -->
        <header class="page-header section" style="background-image: url('https://images.unsplash.com/photo-1516975698824-571e2c952dbd?w=1200&q=80'); background-size: cover; background-position: center;">
            <div class="page-header-overlay">
                <div class="container">
                    <h1 class="page-title"><?php echo __t('Our Services'); ?></h1>
                    <p class="page-subtitle"><?php echo __t('Transparent pricing for all your dental care needs — no surprises, no hidden fees'); ?></p>
                </div>
            </div>
        </header>

        <!-- Services Content -->
        <section class="services-section section">
            <div class="container">
                
                <!-- New Patient Special Highlight -->
                <div style="text-align: center; margin-bottom: 3rem;">
                    <?php echo do_shortcode('[new_patient_special]'); ?>
                </div>

                <!-- Same-Day Crown Technology Section -->
                <div class="technology-section">
                    <div class="container">
                        <h2><?php echo __t('🦷 Same-Day Crowns with Cutting-Edge Technology'); ?></h2>
                        <div class="technology-intro">
                            <p><?php echo __t('Experience the future of dental care with our advanced same-day crown technology. What traditionally required multiple visits, temporary crowns, and goopy impressions can now be completed in a single, comfortable appointment.'); ?></p>
                        </div>
                        
                        <div class="technology-grid">
                            <div class="tech-feature">
                                <h3><?php echo __t('Advanced Intraoral Scanner'); ?></h3>
                                <p><?php echo __t('Our state-of-the-art intraoral scanner captures precise 3D digital impressions in minutes. No more uncomfortable goopy impressions that make you gag — just a small wand that creates a perfect digital model of your tooth.'); ?></p>
                                <ul>
                                    <li><?php echo __t('Comfortable, non-invasive scanning process'); ?></li>
                                    <li><?php echo __t('Precise measurements for perfect crown fit'); ?></li>
                                    <li><?php echo __t('Real-time 3D visualization of your tooth'); ?></li>
                                </ul>
                            </div>
                            
                            <div class="tech-feature">
                                <h3><?php echo __t('Glidewell Fastmill.io System'); ?></h3>
                                <p><?php echo __t('Using Glidewell\'s Fastmill.io technology, we design and mill your custom crown right here in our office. This cutting-edge system ensures precision craftsmanship and perfect color matching for natural-looking results.'); ?></p>
                                <ul>
                                    <li><?php echo __t('Crown designed and created in our office'); ?></li>
                                    <li><?php echo __t('Perfect color and shape matching'); ?></li>
                                    <li><?php echo __t('High-strength ceramic materials'); ?></li>
                                    <li><?php echo __t('Same-day placement and completion'); ?></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="technology-benefits">
                            <h3><?php echo __t('The Same-Day Crown Advantage'); ?></h3>
                            <div class="benefits-grid">
                                <div class="benefit-item">
                                    <span class="benefit-icon">⚡</span>
                                    <h4><?php echo __t('Single Appointment'); ?></h4>
                                    <p><?php echo __t('Complete restoration in one visit — no second appointment needed'); ?></p>
                                </div>
                                <div class="benefit-item">
                                    <span class="benefit-icon">🚫</span>
                                    <h4><?php echo __t('No Temporary Crowns'); ?></h4>
                                    <p><?php echo __t('Skip the discomfort and inconvenience of temporary crowns'); ?></p>
                                </div>
                                <div class="benefit-item">
                                    <span class="benefit-icon">✋</span>
                                    <h4><?php echo __t('No Goopy Impressions'); ?></h4>
                                    <p><?php echo __t('Digital scanning eliminates messy, uncomfortable impressions'); ?></p>
                                </div>
                                <div class="benefit-item">
                                    <span class="benefit-icon">🎯</span>
                                    <h4><?php echo __t('Perfect Precision'); ?></h4>
                                    <p><?php echo __t('Digital technology ensures accurate fit and natural appearance'); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="technology-cta">
                            <h3><?php echo __t('Experience Modern Dental Care'); ?></h3>
                            <p><?php echo __t('Ready to see how advanced technology makes dental care more comfortable and efficient? Our same-day crown process typically takes 2-3 hours from start to finish.'); ?></p>
                            <a href="tel:7023024787" class="btn btn-primary"><?php echo __t('Schedule Your Same-Day Crown Consultation'); ?></a>
                        </div>
                    </div>
                </div>
                
                <!-- Introduction -->
                <div class="services-intro">
                    <h2><?php echo __t('Complete Service Menu'); ?></h2>
                    <p><?php echo __t('At Simple Dental, we believe you should know exactly what you\'re paying for. Below are our transparent prices for all dental procedures we offer. No games, no hidden fees — just honest pricing from an experienced doctor.'); ?></p>
                </div>

                <!-- Insurance Notice -->
                <div class="insurance-notice">
                    <h3><?php echo __t('💡 Transparent Pricing Notice'); ?></h3>
                    <div class="notice-content">
                        <p><?php echo __t('The prices listed on our website are our cash fees, designed for patients without dental insurance or those who prefer to pay directly.'); ?></p>
                        
                        <p><?php echo __t('If you have dental insurance and we are in-network, your cost will be determined by your specific insurance plan\'s benefits and contracted rates.'); ?></p>
                        
                        <p><?php echo __t('If we are out-of-network with your insurance, we are happy to help you submit claims to your insurance company to maximize your reimbursement.'); ?></p>
                        
                        <p><strong><?php echo __t('Our team is always available to help you understand your coverage and provide an estimate before treatment, so there are no surprises.'); ?></strong></p>
                    </div>
                </div>

                <!-- All Services by Category -->
                <?php echo do_shortcode('[services_by_category]'); ?>
                
                <!-- Practice Advantages -->
                <div class="services-additional">
                    <div class="services-info-grid">
                        <div class="info-card">
                            <h3><?php echo __t('Efficient Digital Workflow'); ?></h3>
                            <p><?php echo __t('Our streamlined digital systems and in-house lab capabilities mean faster treatment times and better outcomes for our patients.'); ?></p>
                        </div>
                        
                        <div class="info-card">
                            <h3><?php echo __t('Transparent Treatment Planning'); ?></h3>
                            <p><?php echo __t('We explain every step of your treatment and provide clear pricing upfront. No surprises, no hidden costs.'); ?></p>
                        </div>
                        
                        <div class="info-card">
                            <h3><?php echo __t('Honest Recommendations'); ?></h3>
                            <p><?php echo __t('We only recommend treatments you truly need. Our focus is on preserving your natural teeth whenever possible.'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="services-cta">
                    <div class="cta-content">
                        <h2><?php echo __t('Ready to Schedule Your Visit?'); ?></h2>
                        <p><?php echo __t('Call us today to discuss your dental needs and schedule an appointment. We\'re here to provide honest, affordable care.'); ?></p>
                        <div class="cta-buttons">
                            <a href="tel:7023024787" class="btn btn-primary"><?php echo __t('Call (702) 302-4787'); ?></a>
                            <a href="<?php echo esc_url(simple_dental_with_lang(home_url('/contact/'))); ?>" class="btn btn-secondary"><?php echo __t('Get More Information'); ?></a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>

