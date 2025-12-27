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

        // Clear any stale mobile menu state on desktop loads.
        if ($(window).width() > 768) {
            closeMenu();
        }

        // Smooth scroll for anchor links
        function getHeaderOffset() {
            var headerHeight = $('.site-header').outerHeight() || 0;
            var adminBarHeight = $('#wpadminbar').length ? ($('#wpadminbar').outerHeight() || 0) : 0;
            return headerHeight + adminBarHeight;
        }

        $('a[href*="#"]:not([href="#"])').click(function() {
            var isFaqJump = $(this).closest('.faq-panel-nav').length;
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    var duration = isFaqJump ? 200 : 1000;
                    $('html, body').animate({
                        scrollTop: target.offset().top - getHeaderOffset()
                    }, duration);
                    if (this.hash && window.history && window.history.pushState) {
                        window.history.pushState(null, '', this.hash);
                    }
                    return false;
                }
            }
        });

        // Force internal menu links to open in the same tab
        function isInternalLink(href) {
            if (!href) {
                return false;
            }
            if (href.indexOf('#') === 0) {
                return true;
            }
            var link = document.createElement('a');
            link.href = href;
            if (link.protocol && link.protocol !== 'http:' && link.protocol !== 'https:') {
                return false;
            }
            return !link.hostname || link.hostname === window.location.hostname;
        }

        $('.main-navigation a, .faq-panel-nav a').each(function() {
            var href = $(this).attr('href');
            if (isInternalLink(href)) {
                $(this).attr('target', '_self');
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
