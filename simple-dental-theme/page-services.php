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
                    <h1 class="page-title">Our Services</h1>
                    <p class="page-subtitle">Clear, honest pricing — no surprises, no hidden fees</p>
                </div>
            </div>
        </header>

        <!-- Services Content -->
        <section class="services-section section">
            <div class="container">
                
                <!-- Introduction -->
                <div class="services-intro">
                    <h2>What You Can Expect</h2>
                    <p>At Simple Dental, we believe you should know exactly what you're paying for. Below are our transparent prices for common dental procedures. No games, no hidden fees — just honest pricing from an experienced doctor.</p>
                </div>

                <!-- Services Grid -->
                <?php echo do_shortcode('[simple_dental_services]'); ?>

                <!-- Additional Information -->
                <div class="services-additional">
                    <div class="services-info-grid">
                        <div class="info-card">
                            <h3>Same-Day Crowns</h3>
                            <p>Complete your crown restoration in a single visit with our advanced digital technology. No temporary crowns, no multiple appointments.</p>
                        </div>
                        
                        <div class="info-card">
                            <h3>Digital Technology</h3>
                            <p>We use modern digital tools and an in-house lab to make your visit efficient and comfortable while keeping costs down.</p>
                        </div>
                        
                        <div class="info-card">
                            <h3>No Pressure Approach</h3>
                            <p>We only recommend what you truly need. You'll always see the same doctor and receive honest, straightforward care.</p>
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
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-secondary">Contact Us</a>
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

@media (max-width: 768px) {
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
}
</style>

<?php
get_footer();
?>