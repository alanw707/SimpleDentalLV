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


<!-- Add some basic CSS for footer layout and mobile menu -->
<style>
.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    padding: 3px 0;
    color: var(--light-gray);
}

.footer-faq-item {
    margin-bottom: 12px;
}

.footer-faq-item:last-child {
    margin-bottom: 0;
}

.footer-faq-item p {
    margin-bottom: 0;
    line-height: 1.5;
    color: var(--light-gray);
}

.footer-faq-item strong {
    color: var(--white);
    font-weight: 600;
}

/* Scroll to Top Button */
.scroll-to-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background-color: var(--primary-brown);
    color: var(--white);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: bold;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 1000;
    outline: none;
}

.scroll-to-top:hover {
    background-color: var(--brown-hover);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.scroll-to-top.visible {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.scroll-arrow {
    line-height: 1;
    font-size: 18px;
}

.menu-toggle {
    display: none;
    background: none;
    border: none;
    padding: 10px;
    cursor: pointer;
    flex-direction: column;
    justify-content: space-around;
    width: 30px;
    height: 30px;
}

.hamburger {
    width: 25px;
    height: 3px;
    background-color: var(--text-dark);
    transition: 0.3s;
}

.mobile-menu-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 999;
}

@media (max-width: 768px) {
    .menu-toggle {
        display: flex;
    }
    
    .main-navigation ul {
        position: fixed;
        top: 70px;
        right: -100%;
        width: 80%;
        max-width: 300px;
        background-color: var(--white);
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        padding: 20px 0;
        transition: right 0.3s ease;
        z-index: 1000;
        height: calc(100vh - 70px);
        overflow-y: auto;
    }
    
    .main-navigation ul.active {
        right: 0;
    }
    
    .main-navigation li {
        width: 100%;
        border-bottom: 1px solid var(--light-gray);
    }
    
    .main-navigation a {
        display: block;
        padding: 15px 20px;
        border-bottom: none !important;
    }
    
    .header-cta {
        display: none;
    }
    
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
    }
    
    /* Scroll to top button mobile adjustments */
    .scroll-to-top {
        bottom: 15px;
        right: 15px;
        width: 45px;
        height: 45px;
    }
    
    .scroll-arrow {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
}
</style>

<?php wp_footer(); ?>

</body>
</html>
