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


<?php
get_footer();
?>
