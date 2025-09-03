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
                    Las Vegas, NV 89149</p>
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
                    </div>
                    <div class="footer-bottom-right">
                        <p><?php echo __t('Opening October 2025 | Las Vegas, Nevada'); ?></p>
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
