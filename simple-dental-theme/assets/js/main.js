/**
 * Simple Dental Theme Main JavaScript
 * Additional theme functionality
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // --- Lightweight language persistence on client ---
        // Goal: avoid relying on server cookies (bypassed by caches)
        // Strategy: store selected lang in localStorage and ensure URLs carry it
        (function() {
            try {
                var allowed = ['en', 'es', 'zh-TW', 'zh-CN'];
                var params = new URLSearchParams(window.location.search);
                var urlLang = params.get('lang');

                function isAllowed(code) {
                    return allowed.indexOf(code) !== -1;
                }

                function addLangToUrl(href, code) {
                    try {
                        var u = new URL(href, window.location.origin);
                        u.searchParams.set('lang', code);
                        return u.toString();
                    } catch (e) {
                        return href; // Leave unchanged on parse errors
                    }
                }

                // If current URL carries lang, persist to localStorage
                if (urlLang && isAllowed(urlLang)) {
                    window.localStorage.setItem('simple_dental_lang', urlLang);
                }

                var stored = window.localStorage.getItem('simple_dental_lang');

                // If no lang in URL but we have a stored non-default, redirect once
                if (!urlLang && stored && stored !== 'en') {
                    var redirectedKey = 'simple_dental_lang_redirected_' + window.location.pathname;
                    if (!sessionStorage.getItem(redirectedKey)) {
                        sessionStorage.setItem(redirectedKey, '1');
                        window.location.replace(addLangToUrl(window.location.href, stored));
                        return; // stop further execution on this page
                    }
                }

                // Safety net: rewrite internal links missing lang
                if (stored && stored !== 'en') {
                    var anchors = document.querySelectorAll('a[href]');
                    var origin = window.location.origin;
                    anchors.forEach(function(a) {
                        var href = a.getAttribute('href');
                        if (!href) return;
                        // Ignore external, mailto, tel, fragments
                        if (href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0 || href.indexOf('#') === 0) return;
                        var isAbsolute = /^https?:\/\//i.test(href);
                        if (isAbsolute && href.indexOf(origin) !== 0) return; // external
                        // Skip if lang already present
                        if (/([?&])lang=/.test(href)) return;
                        a.setAttribute('href', addLangToUrl(href, stored));
                    });
                }
            } catch (e) {
                // Fail silently; language fallback is English
            }
        })();
        
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
