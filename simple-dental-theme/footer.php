<?php
$hipaa_policy_page = get_page_by_path('hipaa-policy');
$hipaa_policy_url = ($hipaa_policy_page instanceof WP_Post && 'publish' === $hipaa_policy_page->post_status)
    ? simple_dental_with_lang(get_permalink($hipaa_policy_page))
    : '';
$footer_status_label = simple_dental_is_open()
    ? __t('Now Open | Las Vegas, Nevada')
    : sprintf(__t('Opening %s | Las Vegas, Nevada'), simple_dental_get_opening_date_display());
?>
    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Simple Dental</h4>
                    <p><?php echo __t('Straightforward dentistry from one experienced doctor. No pressure. No upsell.'); ?></p>
                    <p><?php echo __t('Modern care with transparent pricing and honest approach to dental health.'); ?></p>
                </div>

                <div class="footer-section">
                    <h4><?php echo __t('Contact'); ?></h4>
                    <p><strong><?php echo __t('Address:'); ?></strong><br>
                    204 S Jones Blvd<br>
                    Las Vegas, NV 89107</p>
                    <p><strong><?php echo __t('Phone:'); ?></strong> <a href="tel:7023024787">(702) 302-4787</a></p>
                </div>

                <div class="footer-section">
                    <h4><?php echo __t('Office Hours', 'footer'); ?></h4>
                    <p><strong><?php echo __t('Monday - Friday:'); ?></strong><br>
                    8:00 AM - 4:00 PM</p>
                    <p><strong><?php echo __t('Saturday & Sunday:'); ?></strong><br>
                    <?php echo __t('Closed'); ?></p>
                </div>

                <div class="footer-section">
                    <h4><?php echo __t('Common Questions'); ?></h4>
                    <div class="footer-faq-item">
                        <p><strong><?php echo __t('Do you accept insurance?'); ?></strong><br>
                        <?php echo __t('We accept most major insurance plans and will verify your benefits.'); ?></p>
                    </div>
                    <div class="footer-faq-item">
                        <p><strong><?php echo __t('One doctor, always?'); ?></strong><br>
                        <?php echo __t("Yes, you'll see the same experienced doctor every visit."); ?></p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <div class="footer-bottom-left">
                        <p>&copy; <?php echo date('Y'); ?> Simple Dental. <?php echo __t('All rights reserved.'); ?></p>
                        <?php if ($hipaa_policy_url) : ?>
                            <p class="footer-legal-links"><a href="<?php echo esc_url($hipaa_policy_url); ?>"><?php echo __t('HIPAA Policy'); ?></a></p>
                        <?php endif; ?>
                    </div>
                    <div class="footer-bottom-right">
                        <p><?php echo esc_html($footer_status_label); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<!-- Scroll to Top Button -->
<button id="scroll-to-top" class="scroll-to-top" aria-label="Scroll to top">
    <span class="scroll-arrow">↑</span>
</button>


<!-- Styles moved to style.css -->

<?php wp_footer(); ?>

</body>
</html>
