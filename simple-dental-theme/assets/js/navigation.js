/**
 * Simple Dental Theme Navigation Script
 * Handles mobile menu functionality
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Mobile menu toggle
        $('.menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation ul').toggleClass('active');
            $('.mobile-menu-overlay').toggle();
            $('body').toggleClass('menu-open');
        });

        // Close mobile menu when overlay is clicked
        $('.mobile-menu-overlay').on('click', function() {
            $('.menu-toggle').removeClass('active');
            $('.main-navigation ul').removeClass('active');
            $(this).hide();
            $('body').removeClass('menu-open');
        });

        // Close mobile menu when a menu item is clicked
        $('.main-navigation a').on('click', function() {
            if ($(window).width() <= 768) {
                $('.menu-toggle').removeClass('active');
                $('.main-navigation ul').removeClass('active');
                $('.mobile-menu-overlay').hide();
                $('body').removeClass('menu-open');
            }
        });

        // Handle window resize
        $(window).resize(function() {
            if ($(window).width() > 768) {
                $('.menu-toggle').removeClass('active');
                $('.main-navigation ul').removeClass('active');
                $('.mobile-menu-overlay').hide();
                $('body').removeClass('menu-open');
            }
        });

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