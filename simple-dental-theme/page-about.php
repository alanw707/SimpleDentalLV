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
        <header class="page-header section" style="background-image: url('https://images.pexels.com/photos/287237/pexels-photo-287237.jpeg'); background-size: cover; background-position: center;">
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
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Charles-Portrait-1.jpg" alt="Dr. Charles Chang, DDS, MS, AFAAID" />
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
                            <h3><?php echo __t('🎉 Opening October 2025!'); ?></h3>
                            <p class="address"><strong>204 S Jones Blvd, Las Vegas, NV 89149</strong></p>
                            
                            <div class="location-highlight">
                                <p><strong><?php echo __t("🚗 We're seconds away from Highway 95!"); ?></strong></p>
                                <p><?php echo __t("Simple Dental is conveniently located just off Highway 95 at the Jones exit — you'll be at our door in seconds! Whether you're coming from Summerlin, Centennial Hills, or central Las Vegas, getting here is quick and easy."); ?></p>
                                <p><?php echo __t("Look for us right off Jones Blvd, and enjoy stress-free parking and easy access — because your visit should start simple before you even step inside."); ?></p>
                            </div>
                            
                            <p><?php echo __t("We're excited to announce that Simple Dental will be opening in October. Our brand-new, modern office is designed to make your dental visits simple, honest, and stress-free."); ?></p>
                            
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
                            <p><?php echo __t('Call us to learn more about our approach or to get on our list for October 2025.'); ?></p>
                            <a href="tel:7023024787" class="btn btn-primary"><?php echo __t('Call (702) 302-4787'); ?></a>
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

.doctor-bio-section {
    max-width: 1000px;
    margin: 0 auto;
    padding: 2rem 0;
}

.doctor-bio-section h2 {
    color: var(--primary-brown);
    margin-bottom: 2rem;
    font-size: 2.25rem;
    text-align: center;
}

.doctor-bio-content {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 3rem;
    align-items: start;
}

.doctor-image img {
    width: 100%;
    border-radius: 1rem;
    box-shadow: var(--shadow-medium);
}

.doctor-bio-text h3 {
    color: var(--primary-brown);
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
}

.doctor-bio-text p {
    color: var(--text-medium);
    line-height: 1.7;
    margin-bottom: 1.5rem;
    font-size: 1.0625rem;
}

.doctor-bio-text p:last-child {
    margin-bottom: 0;
}

/* Philosophy styles removed - now on homepage */

.about-details {
    margin: 4rem 0;
}

.about-details h2 {
    text-align: center;
    color: var(--text-dark);
    margin-bottom: 3rem;
    font-size: 2rem;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.detail-card {
    text-align: center;
    padding: 1.5rem;
    border: 2px solid var(--border-gray);
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    background: var(--white);
}

.detail-card:hover {
    border-color: var(--primary-brown);
    transform: translateY(-2px);
    box-shadow: var(--shadow-light);
}

.detail-card h4 {
    color: var(--primary-brown);
    margin-bottom: 0.75rem;
    font-size: 1.125rem;
}

.detail-card p {
    color: var(--text-medium);
    line-height: 1.6;
}

.about-location {
    background: var(--off-white);
    padding: 3rem;
    border-radius: 1rem;
    margin-top: 4rem;
    border: 1px solid var(--border-gray);
}

.location-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    align-items: start;
}

.location-info h2 {
    color: var(--text-dark);
    margin-bottom: 1rem;
    font-size: 2rem;
}

.location-info h3 {
    color: var(--primary-brown);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.location-info p {
    color: var(--text-medium);
    margin-bottom: 1rem;
    line-height: 1.6;
}

.location-highlight {
    background: linear-gradient(135deg, var(--warm-beige) 0%, var(--off-white) 100%);
    padding: 1.5rem;
    border-radius: 0.75rem;
    margin: 1.5rem 0;
    border-left: 4px solid var(--accent-teal);
}

.location-highlight p {
    margin-bottom: 0.75rem;
}

.location-highlight p:last-child {
    margin-bottom: 0;
}

.address {
    color: var(--text-dark) !important;
    font-size: 1.125rem;
}

.feature-list {
    margin: 1.5rem 0;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.feature-check {
    color: var(--sage-green);
    font-weight: 700;
    font-size: 1.125rem;
}

.feature-item span:last-child {
    color: var(--text-medium);
    line-height: 1.5;
}

.location-cta {
    background: var(--white);
    padding: 2rem;
    border-radius: 0.75rem;
    text-align: center;
    box-shadow: var(--shadow-light);
    border: 1px solid var(--border-gray);
}

.location-cta h4 {
    color: var(--text-dark);
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.location-cta p {
    color: var(--text-medium);
    margin-bottom: 1.5rem;
    line-height: 1.6;
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
    
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .location-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .about-location {
        padding: 2rem 1.5rem;
    }
    
    .doctor-bio-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .doctor-image {
        max-width: 300px;
        margin: 0 auto;
    }
    
    .doctor-bio-text h3 {
        font-size: 1.5rem;
    }
}
</style>

<?php
get_footer();
?>
