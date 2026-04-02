<?php
/**
 * Slug-specific template for the HIPAA policy page.
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <header class="page-header section" style="background-image: url('<?php echo esc_url(simple_dental_media_url('hero-contact-waiting-area.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
            <div class="page-header-overlay">
                <div class="container">
                    <h1 class="page-title"><?php echo esc_html(get_the_title() ?: __t('HIPAA Policy')); ?></h1>
                    <p class="page-subtitle"><?php echo esc_html(__t('Notice of Privacy Practices for Simple Dental patients.')); ?></p>
                </div>
            </div>
        </header>

        <section class="page-content section">
            <div class="container narrow-content">
                <article <?php post_class('policy-page'); ?>>
                    <?php the_content(); ?>

                    <?php if (current_user_can('edit_post', get_the_ID()) && trim(wp_strip_all_tags(get_the_content())) === '') : ?>
                        <p class="policy-admin-note"><?php echo esc_html(__t('Add the approved HIPAA notice content to this page in WordPress admin to publish the patient-facing policy.')); ?></p>
                    <?php endif; ?>
                </article>
            </div>
        </section>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>
