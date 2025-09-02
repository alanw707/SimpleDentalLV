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
        <header class="page-header section" style="background-image: url('https://images.unsplash.com/photo-1516975698824-571e2c952dbd?w=1200&q=80); background-size: cover; background-position: center;">
            <div class="page-header-overlay">
                <div class="container">
                    <h1 class="page-title"><?php echo __t('Our Services'); ?></h1>
                    <p class="page-subtitle">Transparent pricing for all your dental care needs — no surprises, no hidden fees</p>
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
                        <h2>🦷 Same-Day Crowns with Cutting-Edge Technology</h2>
                        <div class="technology-intro">
                            <p>Experience the future of dental care with our advanced same-day crown technology. What traditionally required multiple visits, temporary crowns, and goopy impressions can now be completed in a single, comfortable appointment.</p>
                        </div>
                        
                        <div class="technology-grid">
                            <div class="tech-feature">
                                <h3>Advanced Intraoral Scanner</h3>
                                <p>Our state-of-the-art intraoral scanner captures precise 3D digital impressions in minutes. No more uncomfortable goopy impressions that make you gag — just a small wand that creates a perfect digital model of your tooth.</p>
                                <ul>
                                    <li>Comfortable, non-invasive scanning process</li>
                                    <li>Precise measurements for perfect crown fit</li>
                                    <li>Real-time 3D visualization of your tooth</li>
                                </ul>
                            </div>
                            
                            <div class="tech-feature">
                                <h3>Glidewell Fastmill.io System</h3>
                                <p>Using Glidewell's Fastmill.io technology, we design and mill your custom crown right here in our office. This cutting-edge system ensures precision craftsmanship and perfect color matching for natural-looking results.</p>
                                <ul>
                                    <li>Crown designed and created in our office</li>
                                    <li>Perfect color and shape matching</li>
                                    <li>High-strength ceramic materials</li>
                                    <li>Same-day placement and completion</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="technology-benefits">
                            <h3>The Same-Day Crown Advantage</h3>
                            <div class="benefits-grid">
                                <div class="benefit-item">
                                    <span class="benefit-icon">⚡</span>
                                    <h4>Single Appointment</h4>
                                    <p>Complete restoration in one visit — no second appointment needed</p>
                                </div>
                                <div class="benefit-item">
                                    <span class="benefit-icon">🚫</span>
                                    <h4>No Temporary Crowns</h4>
                                    <p>Skip the discomfort and inconvenience of temporary crowns</p>
                                </div>
                                <div class="benefit-item">
                                    <span class="benefit-icon">✋</span>
                                    <h4>No Goopy Impressions</h4>
                                    <p>Digital scanning eliminates messy, uncomfortable impressions</p>
                                </div>
                                <div class="benefit-item">
                                    <span class="benefit-icon">🎯</span>
                                    <h4>Perfect Precision</h4>
                                    <p>Digital technology ensures accurate fit and natural appearance</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="technology-cta">
                            <h3>Experience Modern Dental Care</h3>
                            <p>Ready to see how advanced technology makes dental care more comfortable and efficient? Our same-day crown process typically takes 2-3 hours from start to finish.</p>
                            <a href="tel:7023024787" class="btn btn-primary">Schedule Your Same-Day Crown Consultation</a>
                        </div>
                    </div>
                </div>
                
                <!-- Introduction -->
                <div class="services-intro">
                    <h2>Complete Service Menu</h2>
                    <p>At Simple Dental, we believe you should know exactly what you're paying for. Below are our transparent prices for all dental procedures we offer. No games, no hidden fees — just honest pricing from an experienced doctor.</p>
                </div>

                <!-- Insurance Notice -->
                <div class="insurance-notice">
                    <h3>💡 Transparent Pricing Notice</h3>
                    <div class="notice-content">
                        <p>The prices listed on our website are our cash fees, designed for patients without dental insurance or those who prefer to pay directly.</p>
                        
                        <p>If you have dental insurance and we are in-network, your cost will be determined by your specific insurance plan's benefits and contracted rates.</p>
                        
                        <p>If we are out-of-network with your insurance, we are happy to help you submit claims to your insurance company to maximize your reimbursement.</p>
                        
                        <p><strong>Our team is always available to help you understand your coverage and provide an estimate before treatment, so there are no surprises.</strong></p>
                    </div>
                </div>

                <!-- All Services by Category -->
                <?php echo do_shortcode('[services_by_category]'); ?>
                
                <!-- Practice Advantages -->
                <div class="services-additional">
                    <div class="services-info-grid">
                        <div class="info-card">
                            <h3>Efficient Digital Workflow</h3>
                            <p>Our streamlined digital systems and in-house lab capabilities mean faster treatment times and better outcomes for our patients.</p>
                        </div>
                        
                        <div class="info-card">
                            <h3>Transparent Treatment Planning</h3>
                            <p>We explain every step of your treatment and provide clear pricing upfront. No surprises, no hidden costs.</p>
                        </div>
                        
                        <div class="info-card">
                            <h3>Honest Recommendations</h3>
                            <p>We only recommend treatments you truly need. Our focus is on preserving your natural teeth whenever possible.</p>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="services-cta">
                    <div class="cta-content">
                        <h2>Ready to Schedule Your Visit?</h2>
                        <p>Call us today to discuss your dental needs and schedule an appointment. We're here to provide honest, affordable care.</p>
                        <div class="cta-buttons">
                            <a href="tel:7023024787" class="btn btn-primary">Call (702) 302-4787</a>
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-secondary">Get More Information</a>
                        </div>
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
    background: rgba(0, 0, 0, 0.5);
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

.services-section {
    background-color: var(--white);
}

.services-intro {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 3rem;
    padding: 2rem 0;
}

.services-intro h2 {
    color: var(--primary-brown);
    margin-bottom: 1.5rem;
    font-size: 2.25rem;
}

.services-intro p {
    font-size: 1.125rem;
    line-height: 1.7;
    color: var(--text-medium);
}

.insurance-notice {
    background: linear-gradient(135deg, var(--warm-beige) 0%, var(--off-white) 100%);
    border: 1px solid var(--border-gray);
    border-radius: 1rem;
    padding: 2rem;
    margin: 3rem auto;
    max-width: 900px;
    box-shadow: var(--shadow-light);
}

.insurance-notice h3 {
    color: var(--primary-brown);
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    text-align: center;
}

.notice-content p {
    color: var(--text-medium);
    line-height: 1.7;
    margin-bottom: 1rem;
    font-size: 1.0625rem;
}

.notice-content p:last-child {
    margin-bottom: 0;
    text-align: center;
}

.services-additional {
    margin-top: 4rem;
}

.services-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.info-card {
    background: var(--white);
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: var(--shadow-light);
    text-align: center;
    border: 1px solid var(--border-gray);
    transition: all 0.2s ease;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
    border-color: var(--primary-brown);
}

.info-card h3 {
    color: var(--primary-brown);
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.info-card p {
    color: var(--text-medium);
    line-height: 1.6;
}

.services-cta {
    background: var(--warm-beige);
    border: 1px solid var(--border-gray);
    padding: 3rem;
    border-radius: 1rem;
    text-align: center;
    margin-top: 3rem;
}

.cta-content h2 {
    color: var(--text-dark);
    margin-bottom: 1rem;
    font-size: 2rem;
}

.cta-content p {
    color: var(--text-medium);
    font-size: 1.125rem;
    margin-bottom: 2rem;
    line-height: 1.6;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-buttons .btn {
    min-width: 200px;
    padding: 1rem 2rem;
}

/* Technology Section Styles */
.technology-section {
    background: linear-gradient(135deg, var(--warm-beige) 0%, var(--off-white) 100%);
    padding: 4rem 0;
    margin: 3rem 0;
    border-radius: 1rem;
}

.technology-section h2 {
    text-align: center;
    color: var(--primary-brown);
    margin-bottom: 2rem;
    font-size: 2.5rem;
}

.technology-intro {
    text-align: center;
    max-width: 800px;
    margin: 0 auto 3rem;
}

.technology-intro p {
    font-size: 1.25rem;
    line-height: 1.7;
    color: var(--text-medium);
}

.technology-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.tech-feature {
    background: var(--white);
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: var(--shadow-light);
    border: 1px solid var(--border-gray);
}

.tech-feature h3 {
    color: var(--primary-brown);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.tech-feature p {
    color: var(--text-medium);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.tech-feature ul {
    list-style: none;
    padding: 0;
}

.tech-feature li {
    color: var(--text-medium);
    padding: 0.5rem 0;
    position: relative;
    padding-left: 1.5rem;
}

.tech-feature li:before {
    content: '✓';
    color: var(--sage-green);
    font-weight: bold;
    position: absolute;
    left: 0;
}

.technology-benefits {
    margin: 3rem 0;
}

.technology-benefits h3 {
    text-align: center;
    color: var(--primary-brown);
    margin-bottom: 2rem;
    font-size: 2rem;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.benefit-item {
    background: var(--white);
    padding: 1.5rem;
    border-radius: 0.75rem;
    text-align: center;
    box-shadow: var(--shadow-light);
    border: 1px solid var(--border-gray);
    transition: all 0.2s ease;
}

.benefit-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
    border-color: var(--primary-brown);
}

.benefit-icon {
    font-size: 2rem;
    display: block;
    margin-bottom: 1rem;
}

.benefit-item h4 {
    color: var(--primary-brown);
    margin-bottom: 0.5rem;
    font-size: 1.125rem;
}

.benefit-item p {
    color: var(--text-medium);
    line-height: 1.5;
    margin: 0;
}

.technology-cta {
    background: var(--white);
    padding: 2rem;
    border-radius: 1rem;
    text-align: center;
    box-shadow: var(--shadow-light);
    border: 1px solid var(--border-gray);
}

.technology-cta h3 {
    color: var(--primary-brown);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.technology-cta p {
    color: var(--text-medium);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
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
    
    .services-intro {
        padding: 1.5rem 0;
    }
    
    .services-intro h2 {
        font-size: 2rem;
    }
    
    .services-info-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .insurance-notice {
        padding: 1.5rem;
        margin: 2rem 0;
    }
    
    .insurance-notice h3 {
        font-size: 1.25rem;
    }
    
    .notice-content p {
        font-size: 1rem;
    }
    
    .info-card {
        padding: 1.5rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .services-cta {
        padding: 2rem 1.5rem;
    }
    
    .cta-content h2 {
        font-size: 1.75rem;
    }
    
    .cta-content p {
        font-size: 1rem;
    }
    
    /* Technology Section Mobile */
    .technology-section {
        padding: 2rem 0;
        margin: 2rem 0;
    }
    
    .technology-section h2 {
        font-size: 2rem;
    }
    
    .technology-intro p {
        font-size: 1.125rem;
    }
    
    .technology-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .tech-feature {
        padding: 1.5rem;
    }
    
    .benefits-grid {
        grid-template-columns: 1fr;
    }
    
    .technology-cta {
        padding: 1.5rem;
    }
}
</style>

<?php
get_footer();
?>