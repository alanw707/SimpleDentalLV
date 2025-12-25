<?php
/**
 * Template for About Page
 * 
 * Template Name: About Page
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Page Header -->
        <header class="page-header section" style="background-image: url('<?php echo esc_url(simple_dental_media_url('page-feature-sterilization.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
            <div class="page-header-overlay">
            <div class="container">
            <h1 class="page-title"><?php echo __t('About Simple Dental'); ?></h1>
            <p class="page-subtitle"><?php echo __t('Straightforward dentistry you can trust'); ?></p>
            </div>
            </div>
        </header>

        <!-- About Content -->
        <section class="about-section section">
            <div class="container">
                
                <!-- Doctor Biography Section -->
                <div class="doctor-bio-section">
                    <h2><?php echo __t('Meet Dr. Charles Chang'); ?></h2>
                    <div class="doctor-bio-content">
                        <div class="doctor-image">
                            <?php echo simple_dental_media_image('Charles-Portrait-1.jpg', __t('Dr. Charles Chang portrait')); ?>
                        </div>
                        <div class="doctor-bio-text">
                            <h3>🦷 Dr. Charles Chang, DDS, MS, AFAAID</h3>
                            <p><?php echo __t('Dr. Charles Chang is a highly experienced and trusted dentist who believes that dental care should be simple, honest, and stress-free. With over 15 years of clinical experience, Dr. Chang has advanced training in implants, oral surgery, endodontics, and same-day crowns. He takes pride in offering essential, high-quality treatments without unnecessary upselling or surprises.'); ?></p>

                            <p><?php echo __t("After practicing in New York and Seattle, Dr. Chang and his family moved to Las Vegas to build Simple Dental, a modern, patient-focused practice designed to make dental visits easier and more comfortable. His practice philosophy emphasizes efficiency, transparency, and respect for patients' time — including convenient same-day crowns and clear, upfront pricing."); ?></p>

                            <p><?php echo __t("Outside of the office, Dr. Chang enjoys spending time with his wife and daughter, exploring local parks and restaurants, and caring for their two dogs. As a dedicated father and family man, he understands the importance of balance and brings that same thoughtful, caring approach to each patient he treats."); ?></p>

                            <p><?php echo __t('Dr. Chang looks forward to welcoming you to Simple Dental, where you can expect straightforward, compassionate care in a warm and welcoming environment.'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Office Gallery -->
                <div class="about-gallery">
                    <div class="media-split about-gallery-split">
                        <div class="media-split-content">
                            <h2><?php echo __t('Designed for Comfort'); ?></h2>
                            <p class="about-gallery-copy"><?php echo __t('Warm light, clean lines, and a layout that keeps visits calm and efficient.'); ?></p>
                        </div>
                        <div class="media-split-image about-gallery-grid">
                            <figure class="about-gallery-item">
                                <?php echo simple_dental_media_image('about-gallery-dentist-wall.jpg', __t('Simple Dental front desk and dentist wall')); ?>
                            </figure>
                            <figure class="about-gallery-item">
                                <?php echo simple_dental_media_image('about-gallery-front-desk.jpg', __t('Simple Dental front desk detail')); ?>
                            </figure>
                        </div>
                    </div>
                </div>

                <!-- Practice Details -->
                <div class="about-details">
                    <h2><?php echo __t('The Simple Dental Difference'); ?></h2>
                    <div class="details-grid">
                        <div class="detail-card">
                            <h4><?php echo __t('Lean & Efficient'); ?></h4>
                            <p><?php echo __t('Our practice is designed to be efficient with 2-3 operatories and advanced digital tools. This keeps overhead low and passes savings to you.'); ?></p>
                        </div>
                        
                        <div class="detail-card">
                            <h4><?php echo __t('In-House Lab'); ?></h4>
                            <p><?php echo __t('Same-day crowns and faster turnaround times thanks to our in-house lab and digital workflow.'); ?></p>
                        </div>
                        
                        <div class="detail-card">
                            <h4><?php echo __t('Mobile Delivery'); ?></h4>
                            <p><?php echo __t('ASI mobile carts and modern systems make treatments more comfortable and efficient.'); ?></p>
                        </div>
                        
                        <div class="detail-card">
                            <h4><?php echo __t('Family Focused'); ?></h4>
                            <p><?php echo __t('We cater to everyday working families who want honest, affordable care from an experienced doctor.'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Location & Opening -->
                <div class="about-location">
                    <div class="location-content">
                        <div class="location-info">
                            <h2><?php echo __t('Coming to Las Vegas'); ?></h2>
                            <h3><?php echo sprintf(__t('🎉 Opening %s!'), simple_dental_get_opening_date_display()); ?></h3>
                            <p class="address"><strong>204 S Jones Blvd, Las Vegas, NV 89107</strong></p>
                            
                            <div class="location-highlight">
                                <p><strong><?php echo __t("🚗 We're seconds away from Highway 95!"); ?></strong></p>
                                <p><?php echo __t("Simple Dental is conveniently located just off Highway 95 at the Jones exit — you'll be at our door in seconds! Whether you're coming from Summerlin, Centennial Hills, or central Las Vegas, getting here is quick and easy."); ?></p>
                                <p><?php echo __t("Look for us right off Jones Blvd, and enjoy stress-free parking and easy access — because your visit should start simple before you even step inside."); ?></p>
                            </div>
                            
                            <p><?php echo sprintf(__t("We're excited to announce that Simple Dental will be opening in %s. Our brand-new, modern office is designed to make your dental visits simple, honest, and stress-free."), simple_dental_get_opening_date_display()); ?></p>
                            
                            <div class="opening-features">
                                <div class="feature-list">
                                    <div class="feature-item">
                                        <span class="feature-check">✓</span>
                                        <span><?php echo __t('Advanced digital technology'); ?></span>
                                    </div>
                                    <div class="feature-item">
                                        <span class="feature-check">✓</span>
                                        <span><?php echo __t('Digital X-rays and tools'); ?></span>
                                    </div>
                                    <div class="feature-item">
                                        <span class="feature-check">✓</span>
                                        <span><?php echo __t('Comfortable, modern facility'); ?></span>
                                    </div>
                                    <div class="feature-item">
                                        <span class="feature-check">✓</span>
                                        <span><?php echo __t('Easy parking and access'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="location-cta">
                            <h4><?php echo __t('Ready to Experience Simple Dental?'); ?></h4>
                            <p><?php echo sprintf(__t('Call us to learn more about our approach or to get on our list for %s.'), simple_dental_get_opening_date_display()); ?></p>
                            <a href="tel:7023024787" class="btn btn-primary"><?php echo __t('Call (702) 302-4787'); ?></a>
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
