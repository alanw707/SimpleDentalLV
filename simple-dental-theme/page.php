<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <!-- Page Header -->
            <header class="page-header section" style="background-image: url('https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=1200&q=80'); background-size: cover; background-position: center;">
                <div class="page-header-overlay">
                    <div class="container">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content section">
                <div class="container">
                    <div class="content-wrapper">
                        <?php
                        the_content();

                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'simple-dental'),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>

        </article>

    <?php endwhile; ?>

</main>

<style>
.page-header {
    position: relative;
    text-align: center;
    padding: 240px 0 160px;
    min-height: 56vh; /* Account for fixed header */
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
    margin: 0;
    font-weight: 800;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    letter-spacing: -0.025em;
}

.page-content {
    padding: 60px 0;
    background: var(--white);
}

.content-wrapper {
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.8;
}

.content-wrapper h2 {
    color: var(--primary-brown);
    margin-top: 40px;
    margin-bottom: 20px;
}

.content-wrapper h3 {
    color: var(--primary-brown);
    margin-top: 30px;
    margin-bottom: 15px;
}

.content-wrapper p {
    margin-bottom: 20px;
    color: var(--text-medium);
}

.content-wrapper ul,
.content-wrapper ol {
    margin-bottom: 20px;
    padding-left: 30px;
}

.content-wrapper li {
    margin-bottom: 8px;
    color: var(--text-medium);
}

.page-links {
    margin-top: 40px;
    text-align: center;
}

.page-links a {
    display: inline-block;
    padding: 8px 16px;
    margin: 0 4px;
    background-color: var(--primary-brown);
    color: var(--white);
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.page-links a:hover {
    background-color: var(--brown-hover);
}

.page-links .current {
    background-color: var(--brown-hover);
    color: var(--white);
    padding: 8px 16px;
    margin: 0 4px;
    border-radius: 4px;
}

@media (max-width: 768px) {
    .page-header {
        padding-top: 430px !important;
        padding-bottom: 120px;
        min-height: 48vh;
        position: relative !important;
    }
    
    .page-title {
        font-size: 2.25rem;
    }
    
    .page-content {
        padding: 40px 0;
    }
}
</style>

<?php
get_footer();
?>