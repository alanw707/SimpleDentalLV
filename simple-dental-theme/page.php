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
            <header class="page-header section" style="background-image: url('<?php echo esc_url(simple_dental_media_url('hero-default-front-desk.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
                <div class="page-header-overlay">
                    <div class="container">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </div>
                </div>
            </header>

            <section class="page-image-strip">
                <div class="container">
                    <figure class="page-image-strip-item">
                        <?php echo simple_dental_media_image('page-feature-sterilization.jpg', __t('Sterilization and prep area at Simple Dental')); ?>
                    </figure>
                </div>
            </section>

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
