/**
 * Simple Dental Theme Main JavaScript
 * Additional theme functionality
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Mobile menu logic is handled in navigation.js - avoiding duplicate handlers
        
        // Contact form styles are now in CSS file

        // Phone number formatting
        $('input[type="tel"]').on('input', function() {
            var value = $(this).val().replace(/\D/g, '');
            var formattedValue = '';
            
            if (value.length > 0) {
                if (value.length <= 3) {
                    formattedValue = '(' + value;
                } else if (value.length <= 6) {
                    formattedValue = '(' + value.substring(0, 3) + ') ' + value.substring(3);
                } else {
                    formattedValue = '(' + value.substring(0, 3) + ') ' + value.substring(3, 6) + '-' + value.substring(6, 10);
                }
            }
            
            $(this).val(formattedValue);
        });

        // Scroll animations (fade in on scroll)
        function fadeInOnScroll() {
            $('.service-card, .contact-card').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('fade-in');
                }
            });
        }

        // Fade-in styles are now in CSS file

        // Initial fade in check
        fadeInOnScroll();

        // Fade in on scroll
        $(window).scroll(function() {
            fadeInOnScroll();
        });

        // Header scroll effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.site-header').addClass('scrolled');
            } else {
                $('.site-header').removeClass('scrolled');
            }
        });

        // Header scroll styles are now in CSS file

        // Scroll to Top Button functionality
        const scrollToTopBtn = document.getElementById('scroll-to-top');
        
        if (scrollToTopBtn) {
            // Show/hide button based on scroll position
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    scrollToTopBtn.classList.add('visible');
                } else {
                    scrollToTopBtn.classList.remove('visible');
                }
            });
            
            // Smooth scroll to top on click
            scrollToTopBtn.addEventListener('click', function() {
                $('html, body').animate({
                    scrollTop: 0
                }, {
                    duration: 800,
                    easing: 'swing'
                });
            });
            
            // Keyboard accessibility
            scrollToTopBtn.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: 0
                    }, {
                        duration: 800,
                        easing: 'swing'
                    });
                }
            });
        }

    });

})(jQuery);