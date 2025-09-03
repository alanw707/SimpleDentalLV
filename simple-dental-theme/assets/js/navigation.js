/**
 * Simple Dental Theme Navigation Script
 * Handles mobile menu functionality
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Mobile menu toggle (single source of truth: body.menu-open)
        $(document).on('click', '.menu-toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const $toggle = $(this);
            const $menu = $('.main-navigation ul');
            const $body = $('body');
            const isOpen = $body.hasClass('menu-open');

            if (isOpen) {
                $body.removeClass('menu-open');
                $toggle.removeClass('active').attr('aria-expanded', 'false');
                $menu.removeClass('active'); // keep for backward-compat CSS
                $toggle.focus();
            } else {
                $body.addClass('menu-open');
                $toggle.addClass('active').attr('aria-expanded', 'true');
                $menu.addClass('active'); // keep for backward-compat CSS
                // Focus first menu item for accessibility
                setTimeout(function() { $menu.find('a:first').trigger('focus'); }, 60);
            }
        });

        // Close mobile menu when overlay is clicked
        $(document).on('click', '.mobile-menu-overlay', function() { closeMenu(); });

        // Close mobile menu when a menu item is clicked
        $(document).on('click', '.main-navigation a', function() {
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

        // Ensure only a single overlay exists; do not duplicate
        const overlays = $('.mobile-menu-overlay');
        if (overlays.length > 1) { overlays.not(':first').remove(); }

        // Helper function to close menu consistently
        function closeMenu() {
            $('.menu-toggle')
                .removeClass('active')
                .attr('aria-expanded', 'false')
                .focus();
            $('.main-navigation ul').removeClass('active');
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
