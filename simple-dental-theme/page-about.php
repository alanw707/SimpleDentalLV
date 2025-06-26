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
        <header class="page-header section" style="background-image: url('https://plus.unsplash.com/premium_photo-1672922646298-3afc6c6397c9?w=1200&q=80'); background-size: cover; background-position: center;">
            <div class="page-header-overlay">
                <div class="container">
                    <h1 class="page-title">About Simple Dental</h1>
                    <p class="page-subtitle">Straightforward dentistry you can trust</p>
                </div>
            </div>
        </header>

        <!-- About Content -->
        <section class="about-section section">
            <div class="container">
                
                <!-- Main Story -->
                <div class="about-story">
                    <h2>What Simple Dental Stands For</h2>
                    <p>At Simple Dental, we believe dentistry shouldn't be confusing or pushy. You'll always see the same dentist — me — and we'll only recommend what you truly need.</p>
                    
                    <p>With digital tools and efficient systems, we make your visit fast, comfortable, and transparent. This isn't about fancy amenities or high-pressure sales — it's about delivering honest, quality dental care that working families can afford.</p>
                </div>

                <!-- Practice Philosophy -->
                <div class="about-philosophy">
                    <div class="philosophy-content">
                        <h2>How We're Different</h2>
                        <div class="philosophy-grid">
                            <div class="philosophy-item">
                                <div class="philosophy-icon">🩺</div>
                                <h3>One Doctor, Always</h3>
                                <p>You'll see the same experienced dentist every visit. No rotating providers, no bait-and-switch.</p>
                            </div>
                            
                            <div class="philosophy-item">
                                <div class="philosophy-icon">💰</div>
                                <h3>Transparent Pricing</h3>
                                <p>Know exactly what you'll pay before treatment begins. No surprise bills, no hidden fees.</p>
                            </div>
                            
                            <div class="philosophy-item">
                                <div class="philosophy-icon">⚡</div>
                                <h3>Modern Efficiency</h3>
                                <p>Same-day crowns, digital technology, and streamlined systems for better outcomes.</p>
                            </div>
                            
                            <div class="philosophy-item">
                                <div class="philosophy-icon">🤝</div>
                                <h3>No Pressure</h3>
                                <p>We recommend only what you truly need. Just honest recommendations based on your dental health.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Practice Details -->
                <div class="about-details">
                    <h2>The Simple Dental Difference</h2>
                    <div class="details-grid">
                        <div class="detail-card">
                            <h4>Lean & Efficient</h4>
                            <p>Our practice is designed to be efficient with 2-3 operatories and advanced digital tools. This keeps overhead low and passes savings to you.</p>
                        </div>
                        
                        <div class="detail-card">
                            <h4>In-House Lab</h4>
                            <p>Same-day crowns and faster turnaround times thanks to our in-house lab and digital workflow.</p>
                        </div>
                        
                        <div class="detail-card">
                            <h4>Mobile Delivery</h4>
                            <p>ASI mobile carts and modern systems make treatments more comfortable and efficient.</p>
                        </div>
                        
                        <div class="detail-card">
                            <h4>Family Focused</h4>
                            <p>We cater to everyday working families who want honest, affordable care from an experienced doctor.</p>
                        </div>
                    </div>
                </div>

                <!-- Location & Opening -->
                <div class="about-location">
                    <div class="location-content">
                        <div class="location-info">
                            <h2>Coming to Las Vegas</h2>
                            <h3>New Location Opening September 2025</h3>
                            <p class="address"><strong>204 S Jones Blvd, Las Vegas, NV 89149</strong></p>
                            <p>We're excited to bring our straightforward approach to dental care to the Las Vegas community. Our new practice is being designed from the ground up to deliver efficient, comfortable, and transparent dental care.</p>
                            
                            <div class="opening-features">
                                <div class="feature-list">
                                    <div class="feature-item">
                                        <span class="feature-check">✓</span>
                                        <span>Same-day crown technology</span>
                                    </div>
                                    <div class="feature-item">
                                        <span class="feature-check">✓</span>
                                        <span>Digital X-rays and tools</span>
                                    </div>
                                    <div class="feature-item">
                                        <span class="feature-check">✓</span>
                                        <span>Comfortable, modern facility</span>
                                    </div>
                                    <div class="feature-item">
                                        <span class="feature-check">✓</span>
                                        <span>Easy parking and access</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="location-cta">
                            <h4>Ready to Experience Simple Dental?</h4>
                            <p>Call us to learn more about our approach or to get on our list for September 2025.</p>
                            <a href="tel:7023024787" class="btn btn-primary">Call (702) 302-4787</a>
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
    margin-top: 90px;
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
    .philosophy-grid {
        grid-template-columns: 1fr;
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
    
    .about-philosophy {
        padding: 3rem 1.5rem;
        margin: 3rem 0;
    }
}
</style>

<?php
get_footer();
?>