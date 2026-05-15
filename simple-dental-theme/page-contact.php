<?php
/**
 * Template for Contact Page
 * 
 * Template Name: Contact Page
 */

get_header();

$booking_url = simple_dental_get_booking_url();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Page Header -->
        <header class="page-header section" style="background-image: url('<?php echo esc_url(simple_dental_media_url('hero-contact-waiting-area.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
            <div class="page-header-overlay">
                <div class="container">
                    <h1 class="page-title"><?php echo __t('Contact Simple Dental'); ?></h1>
                    <p class="page-subtitle"><?php echo __t('Call us or contact us with questions. Online booking is also available.'); ?></p>
                </div>
            </div>
        </header>

        <!-- Contact Information -->
        <section class="contact-section section">
            <div class="container">
                
                <!-- Contact Rows -->
                <div class="contact-rows">
                    <div class="contact-row media-split">
                        <div class="media-split-content">
                            <h2><?php echo __t('Call or Book Your Visit'); ?></h2>
                            <p><?php echo __t('Call us if you want help choosing the right appointment time. You can also use our online scheduler anytime.'); ?></p>
                            <div class="contact-row-details">
                                <div class="detail-item">
                                    <h4><?php echo __t('Book Online'); ?></h4>
                                    <p><a href="<?php echo esc_url($booking_url); ?>"><?php echo esc_html(home_url(SIMPLE_DENTAL_BOOKING_PATH)); ?></a></p>
                                </div>
                                <div class="detail-item">
                                    <h4><?php echo __t('Phone'); ?></h4>
                                    <p><a href="tel:7023024787" class="phone-link">(702) 302-4787</a></p>
                                </div>
                                <div class="detail-item">
                                    <h4><?php echo __t('Hours'); ?></h4>
                                    <p><?php echo __t('Monday - Friday: 8:00 AM - 4:00 PM'); ?></p>
                                </div>
                            </div>
                            <div class="cta-buttons">
                                <a href="tel:7023024787" class="btn btn-primary"><?php echo __t('Call (702) 302-4787'); ?></a>
                                <a href="<?php echo esc_url($booking_url); ?>" class="btn btn-secondary"><?php echo __t('Book Online'); ?></a>
                            </div>
                        </div>
                        <figure class="media-split-image">
                            <?php echo simple_dental_media_image('contact-operatory-side.jpg', __t('Operatory chair and equipment at Simple Dental')); ?>
                        </figure>
                    </div>

                    <div class="contact-row media-split reverse">
                        <div class="media-split-content">
                            <h2><?php echo __t('Find Us Fast'); ?></h2>
                            <p><?php echo __t('Visit Simple Dental at 204 S Jones Blvd in Las Vegas, near Highway 95 at the Jones exit. Our office has convenient free parking and is easy to reach from central Las Vegas, Summerlin, and North Las Vegas.'); ?></p>
                            <div class="contact-row-details">
                                <div class="detail-item">
                                    <h4><?php echo __t('Address'); ?></h4>
                                    <p>204 S Jones Blvd<br>Las Vegas, NV 89107</p>
                                </div>
                                <div class="detail-item">
                                    <h4><?php echo __t('Parking'); ?></h4>
                                    <p><?php echo __t('Free parking is available behind the office.'); ?></p>
                                </div>
                                <div class="detail-item">
                                    <h4><?php echo __t('Directions'); ?></h4>
                                    <p><a href="https://maps.app.goo.gl/aEKiZbNFp7SJFG11A" target="_blank" rel="noopener noreferrer"><?php echo __t('Open Simple Dental in Google Maps'); ?></a></p>
                                </div>
                            </div>
                        </div>
                        <figure class="media-split-image">
                            <?php echo simple_dental_media_image('contact-office-hallway.jpg', __t('Simple Dental office hallway')); ?>
                        </figure>
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
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3220.8088084536653!2d-115.22627292380125!3d36.17120687243312!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c8c175a757d405%3A0xa580f9c1778a5418!2sSimple%20Dental!5e0!3m2!1sen!2sus!4v1778764636365!5m2!1sen!2sus"
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="<?php echo esc_attr(__t('Google Map showing Simple Dental in Las Vegas')); ?>">
                    </iframe>
                </div>
                <div class="map-info">
                    <p><strong>Simple Dental</strong><br>204 S Jones Blvd, Las Vegas, NV 89107<br><a href="tel:7023024787">(702) 302-4787</a></p>
                    <p><?php echo __t('Our Las Vegas dental office offers honest care, transparent pricing, and convenient free parking behind the office.'); ?></p>
                    <p><a href="https://maps.app.goo.gl/aEKiZbNFp7SJFG11A" target="_blank" rel="noopener noreferrer"><?php echo __t('Get directions in Google Maps'); ?></a></p>
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
                        <p><?php echo sprintf(__t('Our opening date is %s at our new location on S Jones Blvd.'), simple_dental_get_opening_date_display()); ?></p>
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
                        <p><?php echo wp_kses_post(sprintf(__t('Book online at %s, or call us at %s and our team will help you choose a time that works.'), '<a href="' . esc_url($booking_url) . '">' . esc_html(home_url(SIMPLE_DENTAL_BOOKING_PATH)) . '</a>', '<a href="tel:7023024787">(702) 302-4787</a>')); ?></p>
                    </div>
                    
                    <div class="faq-item">
                        <h4><?php echo __t('Is parking available?'); ?></h4>
                        <p><?php echo __t('Yes. Free parking is available behind our S Jones Blvd office.'); ?></p>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>
