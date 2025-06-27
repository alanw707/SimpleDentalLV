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
                    <h1 class="page-title">Contact Simple Dental</h1>
                    <p class="page-subtitle">Get in touch to schedule your appointment</p>
                </div>
            </div>
        </header>

        <!-- Contact Information -->
        <section class="contact-section section">
            <div class="container">
                
                <!-- Contact Info Cards -->
                <div class="contact-info">
                    <div class="contact-card primary-contact">
                        <h3>Schedule an Appointment</h3>
                        <div class="contact-detail">
                            <h4>Phone</h4>
                            <p><a href="tel:7023024787" class="phone-link">(702) 302-4787</a></p>
                        </div>
                        <div class="contact-detail">
                            <h4>Best Times to Call</h4>
                            <p>Monday - Friday: 8:00 AM - 4:00 PM</p>
                        </div>
                        <a href="tel:7023024787" class="btn btn-primary">Call Now</a>
                    </div>
                    
                    <div class="contact-card">
                        <h3>Our Location</h3>
                        <div class="contact-detail">
                            <h4>Address</h4>
                            <p>204 S Jones Blvd<br>Las Vegas, NV 89149</p>
                        </div>
                        <div class="contact-detail">
                            <h4>Opening</h4>
                            <p>September 2025</p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <h3>Office Hours</h3>
                        <div class="contact-detail">
                            <h4>Monday - Friday</h4>
                            <p>8:00 AM - 4:00 PM</p>
                        </div>
                        <div class="contact-detail">
                            <h4>Weekends</h4>
                            <p>Closed</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-section">
                    <h2>Send Us a Message</h2>
                    <p>Have questions about our services or want to learn more? Send us a message and we'll get back to you soon.</p>
                    
                    <?php echo do_shortcode('[simple_dental_contact]'); ?>
                </div>

            </div>
        </section>

        <!-- Map Section -->
        <section class="map-section">
            <div class="container">
                <h2>Find Us in Las Vegas</h2>
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
                    <p><strong>Coming September 2025</strong> - We're excited to serve the Las Vegas community with honest, straightforward dental care.</p>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section section section-alt">
            <div class="container">
                <h2>Frequently Asked Questions</h2>
                
                <div class="faq-grid">
                    <div class="faq-item">
                        <h4>When do you open?</h4>
                        <p>We're opening in September 2025 at our new location on S Jones Blvd.</p>
                    </div>
                    
                    <div class="faq-item">
                        <h4>Do you accept insurance?</h4>
                        <p>We'll provide details about insurance acceptance closer to our opening date. Our transparent pricing makes it easy to know costs upfront.</p>
                    </div>
                    
                    <div class="faq-item">
                        <h4>What makes you different?</h4>
                        <p>You'll always see the same doctor, get transparent pricing, and receive only the care you actually need — no pressure, no upselling.</p>
                    </div>
                    
                    <div class="faq-item">
                        <h4>What technology do you use?</h4>
                        <p>We use modern digital tools and equipment to make your visit more comfortable and efficient, including digital X-rays and intraoral scanners.</p>
                    </div>
                    
                    <div class="faq-item">
                        <h4>How do I schedule an appointment?</h4>
                        <p>Call us at (702) 302-4787. We'll be taking appointments starting in September 2025.</p>
                    </div>
                    
                    <div class="faq-item">
                        <h4>Is parking available?</h4>
                        <p>Yes, we'll have convenient parking available at our S Jones Blvd location.</p>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>

</main>

<style>
.page-header {
    position: relative;
    text-align: center;
    padding: 240px 0 160px;
    min-height: 56vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.page-header-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-header-overlay .container {
    position: relative;
    z-index: 2;
}

.page-title {
    font-size: 3rem;
    color: var(--white);
    margin: 0 0 1rem 0;
    font-weight: 800;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    letter-spacing: -0.025em;
}

.page-subtitle {
    font-size: 1.25rem;
    color: var(--white);
    margin: 0;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    font-weight: 400;
}

.contact-section {
    background-color: var(--off-white);
}

.contact-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.contact-card {
    background: var(--white);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    text-align: center;
}

.primary-contact {
    border: 3px solid var(--accent-teal);
}

.contact-card h3 {
    color: var(--accent-teal);
    margin-bottom: 20px;
}

.contact-detail {
    margin-bottom: 20px;
}

.contact-detail h4 {
    color: var(--primary-brown);
    margin-bottom: 8px;
    font-size: 1rem;
}

.contact-detail p {
    margin: 0;
    line-height: 1.4;
}

.phone-link {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--accent-teal);
    text-decoration: none;
}

.phone-link:hover {
    color: var(--primary-brown);
}

.contact-form-section {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}

.contact-form-section h2 {
    color: var(--text-dark);
    margin-bottom: 15px;
}

.contact-form-section p {
    margin-bottom: 30px;
    color: var(--text-medium);
}

.map-section {
    padding: 60px 0;
    background-color: var(--white);
}

.map-section h2 {
    text-align: center;
    color: var(--text-dark);
    margin-bottom: 30px;
}

.map-container {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.map-info {
    text-align: center;
}

.map-info p {
    font-size: 1.1rem;
    color: var(--text-medium);
}

.faq-section {
    background-color: var(--warm-beige);
}

.faq-section h2 {
    text-align: center;
    color: var(--text-dark);
    margin-bottom: 40px;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
}

.faq-item {
    background: var(--white);
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
}

.faq-item h4 {
    color: var(--primary-brown);
    margin-bottom: 10px;
    font-weight: 600;
}

.faq-item p {
    margin: 0;
    line-height: 1.6;
    color: var(--text-medium);
}

@media (max-width: 768px) {
    .page-header {
        padding-top: 470px !important;
        padding-bottom: 120px;
        min-height: 48vh;
        position: relative !important;
    }
    
    .page-title {
        font-size: 2.1rem;
    }
    
    .page-subtitle {
        font-size: 1.2rem;
    }
    
    .contact-info {
        grid-template-columns: 1fr;
    }
    
    .faq-grid {
        grid-template-columns: 1fr;
    }
    
    .map-container {
        height: 300px;
    }
}

@media (max-width: 480px) {
    .contact-card {
        padding: 20px;
    }
    
    .phone-link {
        font-size: 1.1rem;
    }
}
</style>

<?php
get_footer();
?>