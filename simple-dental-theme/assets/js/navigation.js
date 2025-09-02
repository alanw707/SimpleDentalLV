/**
 * Simple Dental Theme Navigation Script
 * Handles mobile menu functionality
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Enhanced mobile menu toggle with accessibility and device consistency
        $('.menu-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $toggle = $(this);
            const $menu = $('.main-navigation ul');
            const $overlay = $('.mobile-menu-overlay');
            const $body = $('body');
            const isOpen = $toggle.hasClass('active');
            
            if (isOpen) {
                // Close menu
                $toggle.removeClass('active').attr('aria-expanded', 'false');
                $menu.removeClass('active');
                $overlay.fadeOut(200);
                $body.removeClass('menu-open');
                
                // Return focus to toggle button
                $toggle.focus();
            } else {
                // Open menu
                $toggle.addClass('active').attr('aria-expanded', 'true');
                $menu.addClass('active');
                $overlay.fadeIn(200);
                $body.addClass('menu-open');
                
                // Focus first menu item for accessibility
                setTimeout(function() {
                    $menu.find('a:first').focus();
                }, 100);
            }
        });

        // Close mobile menu when overlay is clicked
        $('.mobile-menu-overlay').on('click', function() {
            closeMenu();
        });

        // Close mobile menu when a menu item is clicked
        $('.main-navigation a').on('click', function() {
            if ($(window).width() <= 768) {
                closeMenu();
            }
        });

        // Handle window resize - close menu on desktop
        $(window).resize(function() {
            if ($(window).width() > 768) {
                closeMenu();
            }
        });

        // Keyboard navigation support
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('.menu-toggle').hasClass('active')) {
                closeMenu();
            }
        });

        // Helper function to close menu consistently
        function closeMenu() {
            $('.menu-toggle')
                .removeClass('active')
                .attr('aria-expanded', 'false')
                .focus();
            $('.main-navigation ul').removeClass('active');
            $('.mobile-menu-overlay').fadeOut(200);
            $('body').removeClass('menu-open');
        }

        // Smooth scroll for anchor links
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                    return false;
                }
            }
        });

        // Add active class to current menu item
        var currentUrl = window.location.pathname;
        $('.main-navigation a').each(function() {
            var linkUrl = $(this).attr('href');
            if (linkUrl && (currentUrl === linkUrl || currentUrl.indexOf(linkUrl) === 0)) {
                $(this).addClass('active');
            }
        });

    });

})(jQuery);