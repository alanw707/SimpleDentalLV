<?php
/**
 * Template for Contact Page
 * 
 * Template Name: Contact Page
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Page Header -->
        <header class="page-header section" style="background-image: url('https://images.unsplash.com/photo-1581351721010-8cf859cb14a4?w=1200&q=80'); background-size: cover; background-position: center;">
            <div class="page-header-overlay">
                <div class="container">
                    <h1 class="page-title"><?php echo __t('Contact Simple Dental'); ?></h1>
                    <p class="page-subtitle"><?php echo __t('Get in touch to schedule your appointment'); ?></p>
                </div>
            </div>
        </header>

        <!-- Contact Information -->
        <section class="contact-section section">
            <div class="container">
                
                <!-- Contact Info Cards -->
                <div class="contact-info">
                    <div class="contact-card primary-contact">
                        <h3><?php echo __t('Schedule an Appointment'); ?></h3>
                        <div class="contact-detail">
                            <h4><?php echo __t('Phone'); ?></h4>
                            <p><a href="tel:7023024787" class="phone-link">(702) 302-4787</a></p>
                        </div>
                        <div class="contact-detail">
                            <h4><?php echo __t('Best Times to Call'); ?></h4>
                            <p><?php echo __t('Monday - Friday: 8:00 AM - 4:00 PM'); ?></p>
                        </div>
                        <a href="tel:7023024787" class="btn btn-primary"><?php echo __t('Call Now'); ?></a>
                    </div>
                    
                    <div class="contact-card">
                        <h3><?php echo __t('Our Location'); ?></h3>
                        <div class="contact-detail">
                            <h4><?php echo __t('Address'); ?></h4>
                            <p>204 S Jones Blvd<br>Las Vegas, NV 89149</p>
                        </div>
                        <div class="contact-detail">
                            <h4><?php echo __t('🚗 Easy Access from Highway 95'); ?></h4>
                            <p><?php echo __t("Just off Highway 95 at the Jones exit — you'll be at our door in seconds! Convenient for Summerlin, Centennial Hills, and central Las Vegas."); ?></p>
                        </div>
                        <div class="contact-detail">
                            <h4><?php echo __t('Opening'); ?></h4>
                            <p><?php echo __t('October 2025'); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <h3><?php echo __t('Office Hours'); ?></h3>
                        <div class="contact-detail">
                            <h4><?php echo __t('Monday - Friday'); ?></h4>
                            <p>8:00 AM - 4:00 PM</p>
                        </div>
                        <div class="contact-detail">
                            <h4><?php echo __t('Weekends'); ?></h4>
                            <p><?php echo __t('Closed'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-section">
                    <h2><?php echo __t('Send Us a Message'); ?></h2>
                    <p><?php echo __t("Have questions about our services or want to learn more? Send us a message and we'll get back to you soon."); ?></p>
                    
                    <?php echo do_shortcode('[simple_dental_contact]'); ?>
                </div>

            </div>
        </section>

        <!-- Map Section -->
        <section class="map-section">
            <div class="container">
                <h2><?php echo __t('Find Us in Las Vegas'); ?></h2>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3221.2747982!2d-115.2089!3d36.1699!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c8c0b9f7c4b123%3A0x1234567890abcdef!2s204%20S%20Jones%20Blvd%2C%20Las%20Vegas%2C%20NV%2089149!5e0!3m2!1sen!2sus!4v1234567890123"
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="map-info">
                    <p><strong><?php echo __t('🎉 Coming October 2025!'); ?></strong></p>
                    <p><?php echo __t("We're excited to announce that Simple Dental will be opening in October. Our brand-new, modern office is designed to make your dental visits simple, honest, and stress-free."); ?></p>
                    <p><strong><?php echo __t("Stay tuned for updates — we can't wait to welcome you soon!"); ?></strong></p>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section section section-alt">
            <div class="container">
                <h2><?php echo __t('Frequently Asked Questions'); ?></h2>
                
                <div class="faq-grid">
                    <div class="faq-item">
                        <h4><?php echo __t('When do you open?'); ?></h4>
                        <p><?php echo __t("We're opening in October 2025 at our new location on S Jones Blvd."); ?></p>
                    </div>
                    
                    <div class="faq-item">
                        <h4><?php echo __t('Do you accept insurance?'); ?></h4>
                        <p><?php echo __t('We\'ll provide details about insurance acceptance closer to our opening date. Our transparent pricing makes it easy to know costs upfront.'); ?></p>
                    </div>
                    
                    <div class="faq-item">
                        <h4><?php echo __t('What makes you different?'); ?></h4>
                        <p><?php echo __t("You'll always see the same doctor, get transparent pricing, and receive only the care you actually need — no pressure, no upselling."); ?></p>
                    </div>
                    
                    <div class="faq-item">
                        <h4><?php echo __t('What technology do you use?'); ?></h4>
                        <p><?php echo __t('We use modern digital tools and equipment to make your visit more comfortable and efficient, including digital X-rays and intraoral scanners.'); ?></p>
                    </div>
                    
                    <div class="faq-item">
                        <h4><?php echo __t('How do I schedule an appointment?'); ?></h4>
                        <p><?php echo __t("Call us at (702) 302-4787. We'll be taking appointments starting in October 2025."); ?></p>
                    </div>
                    
                    <div class="faq-item">
                        <h4><?php echo __t('Is parking available?'); ?></h4>
                        <p><?php echo __t("Yes, we'll have convenient parking available at our S Jones Blvd location."); ?></p>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>
