/**
 * Simple Dental Theme Main JavaScript
 * Additional theme functionality
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Mobile Menu Toggle - Simple approach without animation conflicts
        $('.menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation ul').toggleClass('active');
            $('.mobile-menu-overlay').toggle();
            $('body').toggleClass('menu-open');
            
            // Clean X icon animation using CSS classes
            if ($(this).hasClass('active')) {
                if ($(this).find('.close-icon').length === 0) {
                    $(this).append('<div class="close-icon">✕</div>');
                }
            }
        });
        
        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
                $('.menu-toggle').removeClass('active');
                $('.main-navigation ul').removeClass('active');
                $('.mobile-menu-overlay').hide();
                $('body').removeClass('menu-open');
                // Animations handled by CSS classes
            }
        });
        
        // Close mobile menu when clicking a link
        $('.main-navigation a').on('click', function() {
            $('.menu-toggle').removeClass('active');
            $('.main-navigation ul').removeClass('active');
            $('.mobile-menu-overlay').hide();
            $('body').removeClass('menu-open');
            // Animations handled by CSS classes
        });
        
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

    });

})(jQuery);