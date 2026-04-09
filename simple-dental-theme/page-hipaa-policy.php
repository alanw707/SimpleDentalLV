<?php
/**
 * Slug-specific template for the HIPAA policy page.
 */

if (!function_exists('simple_dental_render_hipaa_notice')) {
    /**
     * Render the built-in Notice of Privacy Practices for translated locales.
     *
     * @return void
     */
    function simple_dental_render_hipaa_notice() {
        ?>
        <div class="entry-content">
            <p><strong><?php echo esc_html(__t('Effective Date: April 2, 2026')); ?></strong></p>
            <p><?php echo esc_html(__t('This notice describes how medical information about you may be used and disclosed and how you can get access to this information. Please review it carefully.')); ?></p>

            <h2><?php echo esc_html(__t('Your Information. Your Rights. Our Responsibilities.')); ?></h2>
            <p><?php echo esc_html(__t('Simple Dental is committed to protecting the privacy of your protected health information, also called PHI. We create and maintain records about the care and services you receive so we can provide quality care, receive payment, operate our practice, and comply with legal requirements.')); ?></p>

            <h3><?php echo esc_html(__t('Practice Contact')); ?></h3>
            <ul>
                <li><?php echo esc_html('Simple Dental'); ?></li>
                <li><?php echo esc_html('204 S Jones Blvd'); ?></li>
                <li><?php echo esc_html('Las Vegas, NV 89107'); ?></li>
                <li><?php echo esc_html(__t('Phone: (702) 302-4787')); ?></li>
                <li><?php echo esc_html(__t('Privacy Contact: To be confirmed')); ?></li>
                <li><?php echo esc_html(__t('Email: To be confirmed')); ?></li>
            </ul>

            <h2><?php echo esc_html(__t('Your Rights')); ?></h2>
            <p><?php echo esc_html(__t('You have the right to:')); ?></p>
            <ul>
                <li><?php echo esc_html(__t('Get a copy of your dental and billing records, with limited exceptions allowed by law.')); ?></li>
                <li><?php echo esc_html(__t('Ask us to correct your dental or billing records if you believe they are incomplete or incorrect.')); ?></li>
                <li><?php echo esc_html(__t('Request confidential communications, such as asking us to contact you at a different phone number, mailing address, or in a specific way.')); ?></li>
                <li><?php echo esc_html(__t('Ask us to limit certain uses or disclosures of your information. We are not required to agree to every request, but we will consider each request carefully.')); ?></li>
                <li><?php echo esc_html(__t('Ask us not to share information with your health plan if you paid for an item or service in full out of pocket, unless the disclosure is required by law.')); ?></li>
                <li><?php echo esc_html(__t('Receive a list of certain disclosures we made of your information, as allowed by law.')); ?></li>
                <li><?php echo esc_html(__t('Get a paper copy of this notice at any time, even if you agreed to receive it electronically.')); ?></li>
                <li><?php echo esc_html(__t('Choose someone to act for you, if that person has legal authority to do so.')); ?></li>
                <li><?php echo esc_html(__t('File a complaint if you believe your privacy rights have been violated.')); ?></li>
            </ul>
            <p><?php echo esc_html(__t('To exercise any of these rights, contact Simple Dental using the contact information above.')); ?></p>

            <h2><?php echo esc_html(__t('Your Choices')); ?></h2>
            <p><?php echo esc_html(__t('For certain situations, you may tell us your preferences about how we share your information. For example, you may ask us to:')); ?></p>
            <ul>
                <li><?php echo esc_html(__t('Share information with family members, friends, or others involved in your care or payment for your care.')); ?></li>
                <li><?php echo esc_html(__t('Contact you using specific methods for appointment reminders, billing, or follow-up communications.')); ?></li>
            </ul>
            <p><?php echo esc_html(__t('If you are not able to tell us your preference, we may share information if we believe it is in your best interest, consistent with applicable law.')); ?></p>
            <p><?php echo esc_html(__t('We will not use or disclose your information for marketing purposes or sell your information unless you give us written permission, if such permission is required by law.')); ?></p>

            <h2><?php echo esc_html(__t('Our Uses and Disclosures')); ?></h2>
            <p><?php echo esc_html(__t('We may use and disclose your health information in the following ways:')); ?></p>

            <h3><?php echo esc_html(__t('Treatment')); ?></h3>
            <p><?php echo esc_html(__t('We may use your information to provide, coordinate, or manage your dental care and related services. We may share your information with other health care professionals involved in your treatment.')); ?></p>

            <h3><?php echo esc_html(__t('Payment')); ?></h3>
            <p><?php echo esc_html(__t('We may use and disclose your information to bill and collect payment for the care and services you receive. This may include billing you, your insurance company, or another responsible party.')); ?></p>

            <h3><?php echo esc_html(__t('Health Care Operations')); ?></h3>
            <p><?php echo esc_html(__t('We may use and disclose your information to run our practice, improve patient care, manage staff performance, conduct quality review activities, maintain records, and carry out other administrative functions.')); ?></p>

            <h3><?php echo esc_html(__t('Appointment Reminders and Care Communications')); ?></h3>
            <p><?php echo esc_html(__t('We may contact you with appointment reminders, treatment follow-up information, or information about treatment alternatives or services that may be relevant to your care.')); ?></p>

            <h3><?php echo esc_html(__t('Individuals Involved in Your Care')); ?></h3>
            <p><?php echo esc_html(__t('We may disclose information to a family member, friend, or other person involved in your care or payment for your care when appropriate, unless you object.')); ?></p>

            <h3><?php echo esc_html(__t('As Required or Permitted by Law')); ?></h3>
            <p><?php echo esc_html(__t('We may use or disclose your information when required or permitted by federal or state law, including in the following circumstances:')); ?></p>
            <ul>
                <li><?php echo esc_html(__t('To comply with public health reporting obligations.')); ?></li>
                <li><?php echo esc_html(__t('To report suspected abuse, neglect, or domestic violence when required or permitted by law.')); ?></li>
                <li><?php echo esc_html(__t('For health oversight activities, audits, inspections, or investigations.')); ?></li>
                <li><?php echo esc_html(__t('For law enforcement purposes or in response to a court order, subpoena, or other lawful process.')); ?></li>
                <li><?php echo esc_html(__t("For workers' compensation claims, as permitted by law.")); ?></li>
                <li><?php echo esc_html(__t('To prevent or reduce a serious threat to health or safety.')); ?></li>
                <li><?php echo esc_html(__t('For government functions when authorized by law.')); ?></li>
                <li><?php echo esc_html(__t('To the U.S. Department of Health and Human Services if it investigates or reviews our HIPAA compliance.')); ?></li>
            </ul>

            <h2><?php echo esc_html(__t('Our Responsibilities')); ?></h2>
            <p><?php echo esc_html(__t('Simple Dental is required by law to:')); ?></p>
            <ul>
                <li><?php echo esc_html(__t('Maintain the privacy and security of your protected health information.')); ?></li>
                <li><?php echo esc_html(__t('Provide you with this notice of our legal duties and privacy practices.')); ?></li>
                <li><?php echo esc_html(__t('Follow the terms of the notice currently in effect.')); ?></li>
                <li><?php echo esc_html(__t('Notify you if a breach occurs that may have compromised the privacy or security of your information, when notification is required by law.')); ?></li>
            </ul>
            <p><?php echo esc_html(__t('We will not use or disclose your information in a way that is materially different from what is described in this notice unless we are allowed or required to do so by law, or you authorize us in writing.')); ?></p>

            <h2><?php echo esc_html(__t('Changes to This Notice')); ?></h2>
            <p><?php echo esc_html(__t('We may change this notice at any time. Any updated notice will apply to all information we maintain. The current version will be posted on our website and available in our office.')); ?></p>

            <h2><?php echo esc_html(__t('Questions or Complaints')); ?></h2>
            <p><?php echo esc_html(__t('If you have questions about this notice or believe your privacy rights have been violated, you may contact Simple Dental using the information listed above.')); ?></p>
            <p><?php echo esc_html(__t('You may also file a complaint with the U.S. Department of Health and Human Services Office for Civil Rights:')); ?></p>
            <ul>
                <li><?php echo esc_html(__t('Online: https://www.hhs.gov/hipaa/filing-a-complaint/index.html')); ?></li>
                <li><?php echo esc_html(__t('Phone: 1-877-696-6775')); ?></li>
            </ul>
            <p><?php echo esc_html(__t('Simple Dental will not retaliate against you for filing a complaint.')); ?></p>
        </div>
        <?php
    }
}

get_header();
?>

<main id="primary" class="site-main">

    <?php while (have_posts()) : the_post(); ?>

        <header class="page-header section" style="background-image: url('<?php echo esc_url(simple_dental_media_url('hero-contact-waiting-area.jpg', 'large')); ?>'); background-size: cover; background-position: center;">
            <div class="page-header-overlay">
                <div class="container">
                    <h1 class="page-title"><?php echo esc_html(__t('Notice of Privacy Practices')); ?></h1>
                    <p class="page-subtitle"><?php echo esc_html(__t('Notice of Privacy Practices for Simple Dental patients.')); ?></p>
                </div>
            </div>
        </header>

        <section class="page-content section">
            <div class="container narrow-content">
                <article <?php post_class('policy-page'); ?>>
                    <?php if ('en' === simple_dental_get_current_language_code()) : ?>
                        <?php the_content(); ?>
                    <?php else : ?>
                        <?php simple_dental_render_hipaa_notice(); ?>
                    <?php endif; ?>

                    <?php if ('en' === simple_dental_get_current_language_code() && current_user_can('edit_post', get_the_ID()) && trim(wp_strip_all_tags(get_the_content())) === '') : ?>
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
