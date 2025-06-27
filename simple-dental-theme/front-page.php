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
                <h1>Straightforward Dentistry from one Experienced Doctor.</h1>
                <p class="subtitle">No pressure. No upsell. Just honest, transparent dental care with modern technology and fair pricing.</p>
                <div class="hero-buttons">
                    <a href="#services" class="btn btn-primary">View Our Services</a>
                    <a href="tel:7023024787" class="btn btn-secondary">Call (702) 302-4787</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Preview Section -->
    <section class="section">
        <div class="container">
            <div class="about-preview">
                <div class="about-content">
                    <h2>What Simple Dental Stands For</h2>
                    <p>At Simple Dental, we believe dentistry shouldn't be confusing or pushy. You'll always see the same dentist — me — and we'll only recommend what you truly need.</p>
                    
                    <p>With digital tools like same-day crowns and efficient systems, we make your visit fast, comfortable, and transparent. No hidden fees, no pressure, just honest care for everyday working families.</p>
                    
                    <div class="about-features">
                        <div class="feature">
                            <h4>One Doctor, Always</h4>
                            <p>You'll see the same experienced dentist every visit</p>
                        </div>
                        <div class="feature">
                            <h4>Transparent Pricing</h4>
                            <p>Know exactly what you'll pay before treatment</p>
                        </div>
                        <div class="feature">
                            <h4>Modern Technology</h4>
                            <p>Advanced digital tools for comfortable, efficient care</p>
                        </div>
                    </div>
                    
                    <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn-primary">Learn More About Us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- New Patient Special Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--warm-beige) 0%, var(--off-white) 100%);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2>Start Your Journey to Better Oral Health</h2>
                <p style="font-size: 1.125rem; color: var(--text-medium); max-width: 600px; margin: 0 auto;">
                    New to Simple Dental? We're offering a comprehensive introduction to our practice.
                </p>
            </div>
            
            <?php echo do_shortcode('[new_patient_special]'); ?>
        </div>
    </section>

    <!-- Services Preview Section -->
    <section class="section section-alt" id="services">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 40px;">Our Most Popular Services</h2>
            <p style="text-align: center; margin-bottom: 2rem; font-size: 1.125rem; color: var(--text-medium);">
                Transparent pricing on the services our patients need most
            </p>
            
            <?php echo do_shortcode('[featured_services]'); ?>
            
            <div style="text-align: center; margin-top: 40px;">
                <p><strong>No surprises. No hidden fees.</strong> Patients know upfront what to expect.</p>
                <a href="<?php echo esc_url(home_url('/services/')); ?>" class="btn btn-primary">View All Services & Pricing</a>
            </div>
        </div>
    </section>

    <!-- Contact Preview Section -->
    <section class="section">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 40px;">Visit Us in Las Vegas</h2>
            
            <div class="contact-info">
                <div class="contact-card">
                    <h4>Our Location</h4>
                    <p><strong>204 S Jones Blvd</strong><br>
                    Las Vegas, NV 89149</p>
                    <p>Convenient location with easy parking</p>
                </div>
                
                <div class="contact-card">
                    <h4>Office Hours</h4>
                    <p><strong>Monday - Friday</strong><br>
                    8:00 AM - 4:00 PM</p>
                    <p><strong>Weekends:</strong> Closed</p>
                </div>
                
                <div class="contact-card">
                    <h4>Schedule Appointment</h4>
                    <p><strong><a href="tel:7023024787">(702) 302-4787</a></strong></p>
                    <p>Call to schedule your visit</p>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

</main>

<style>
/* Homepage specific styles */
.hero {
    position: relative;
    text-align: center;
    padding: 220px 0 140px;
    margin-top: 0px;
    min-height: 75vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.hero-overlay {
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

.hero-overlay .container {
    position: relative;
    z-index: 2;
}

.hero h1 {
    font-size: 3.5rem;
    color: var(--white);
    margin: 0 0 2rem 0;
    font-weight: 800;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    letter-spacing: -0.025em;
    line-height: 1.2;
}

.hero .subtitle {
    font-size: 1.5rem;
    color: var(--white);
    margin: 0 0 2rem 0;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    font-weight: 400;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.4;
}

@media (max-width: 768px) {
    .hero {
        padding-top: 470px !important;
        padding-bottom: 100px;
        margin-top: 0 !important;
        min-height: 60vh;
        position: relative !important;
    }
    
    .hero h1 {
        font-size: 2.3rem;
    }
    
    .hero .subtitle {
        font-size: 1.2rem;
    }
}

.about-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin: 40px 0;
}

.feature {
    text-align: center;
    padding: 20px;
}

.feature h4 {
    color: var(--accent-teal);
    margin-bottom: 10px;
}

.hero-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 30px;
    flex-wrap: wrap;
}

.about-preview {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

@media (max-width: 768px) {
    .hero-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .about-features {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
?>