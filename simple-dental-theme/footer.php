    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Simple Dental</h4>
                    <p>Straightforward dentistry from one experienced doctor. No pressure. No upsell.</p>
                    <p>Modern care with transparent pricing and honest approach to dental health.</p>
                </div>

                <div class="footer-section">
                    <h4>Contact Information</h4>
                    <p><strong>Address:</strong><br>
                    204 S Jones Blvd<br>
                    Las Vegas, NV 89149</p>
                    <p><strong>Phone:</strong> <a href="tel:7023024787">(702) 302-4787</a></p>
                </div>

                <div class="footer-section">
                    <h4>Office Hours</h4>
                    <p><strong>Monday - Friday:</strong><br>
                    8:00 AM - 4:00 PM</p>
                    <p><strong>Saturday & Sunday:</strong><br>
                    Closed</p>
                </div>

                <div class="footer-section">
                    <h4>Our Services</h4>
                    <ul>
                        <li>Exam & Cleaning - $189</li>
                        <li>Same-Day Crowns - $899</li>
                        <li>Root Canals - $850</li>
                        <li>Extractions - $220</li>
                        <li>Deep Cleaning - $225/quad</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <div class="footer-bottom-left">
                        <p>&copy; <?php echo date('Y'); ?> Simple Dental. All rights reserved.</p>
                    </div>
                    <div class="footer-bottom-right">
                        <p>Opening September 2025 | Las Vegas, Nevada</p>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay"></div>

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