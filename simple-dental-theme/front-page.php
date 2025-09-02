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
                <p>At Simple Dental, we believe dentistry shouldn't be confusing or pushy. You'll always see the same dentist — me — and we'll only recommend what you truly need.</p>
                
                <p>With digital tools and efficient systems, we make your visit fast, comfortable, and transparent. This isn't about fancy amenities or high-pressure sales — it's about delivering honest, quality dental care that working families can afford.</p>
            </div>

            <!-- Practice Philosophy -->
            <div class="about-philosophy">
                <div class="philosophy-content">
                    <h2><?php echo __t('How We\'re Different'); ?></h2>
                    <div class="philosophy-grid">
                        <div class="philosophy-item">
                            <div class="philosophy-icon">🩺</div>
                            <h3><?php echo __t('One Doctor, Always'); ?></h3>
                            <p>You'll see the same experienced dentist every visit. No rotating providers, no bait-and-switch.</p>
                        </div>
                        
                        <div class="philosophy-item">
                            <div class="philosophy-icon">💰</div>
                            <h3><?php echo __t('Transparent Pricing'); ?></h3>
                            <p>Know exactly what you'll pay before treatment begins. No surprise bills, no hidden fees.</p>
                        </div>
                        
                        <div class="philosophy-item">
                            <div class="philosophy-icon">⚡</div>
                            <h3><?php echo __t('Modern Efficiency'); ?></h3>
                            <p>Same-day crowns, digital technology, and streamlined systems for better outcomes.</p>
                        </div>
                        
                        <div class="philosophy-item">
                            <div class="philosophy-icon">🤝</div>
                            <h3><?php echo __t('No Pressure'); ?></h3>
                            <p>We recommend only what you truly need. Just honest recommendations based on your dental health.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 2rem;">
                <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn-primary">Learn More About Our Practice</a>
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
            <h2 style="text-align: center; margin-bottom: 40px;"><?php echo __t('Our Most Popular Services'); ?></h2>
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
            <h2 style="text-align: center; margin-bottom: 40px;"><?php echo __t('Visit Us in Las Vegas'); ?></h2>
            
            <div class="contact-info">
                <div class="contact-card">
                    <h4><?php echo __t('Our Location'); ?></h4>
                    <p><strong>204 S Jones Blvd</strong><br>
                    Las Vegas, NV 89149</p>
                    <p>Convenient location with easy parking</p>
                </div>
                
                <div class="contact-card">
                    <h4><?php echo __t('Office Hours'); ?></h4>
                    <p><strong>Monday - Friday</strong><br>
                    8:00 AM - 4:00 PM</p>
                    <p><strong>Weekends:</strong> Closed</p>
                </div>
                
                <div class="contact-card">
                    <h4><?php echo __t('Schedule Appointment'); ?></h4>
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

.about-story {
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
    padding: 2rem 0;
}

.about-story h2 {
    color: var(--primary-brown);
    margin-bottom: 1.5rem;
    font-size: 2.25rem;
}

.about-story p {
    font-size: 1.125rem;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    color: var(--text-medium);
}

.about-philosophy {
    background-color: var(--warm-beige);
    padding: 4rem 2rem;
    margin: 4rem 0;
    border-radius: 1rem;
}

.philosophy-content {
    max-width: 1000px;
    margin: 0 auto;
}

.philosophy-content h2 {
    text-align: center;
    color: var(--text-dark);
    margin-bottom: 3rem;
    font-size: 2rem;
}

.philosophy-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.philosophy-item {
    background: var(--white);
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: var(--shadow-light);
    text-align: center;
    border: 1px solid var(--border-gray);
    transition: all 0.2s ease;
}

.philosophy-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
    border-color: var(--primary-brown);
}

.philosophy-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    display: block;
}

.philosophy-item h3 {
    color: var(--primary-brown);
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.philosophy-item p {
    color: var(--text-medium);
    line-height: 1.6;
}

@media (max-width: 768px) {
    .hero-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .philosophy-grid {
        grid-template-columns: 1fr;
    }
    
    .about-philosophy {
        padding: 3rem 1.5rem;
        margin: 3rem 0;
    }
}
</style>

<?php
get_footer();
?>