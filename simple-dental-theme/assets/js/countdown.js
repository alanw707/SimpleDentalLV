/**
 * Countdown Timer for Simple Dental
 *
 * Displays countdown to opening date with live updates.
 * Handles grace period fallback message.
 */
(function($) {
    'use strict';

    // Exit if countdown data not available
    if (typeof countdownData === 'undefined') {
        return;
    }

    var targetTimestamp = countdownData.targetTimestamp;
    var isGracePeriod = countdownData.isGracePeriod;
    var gracePeriodMessage = countdownData.gracePeriodMessage;

    /**
     * Update countdown display
     */
    function updateCountdown() {
        var $timer = $('.countdown-timer');
        if (!$timer.length) {
            return;
        }

        var now = Date.now();
        var difference = targetTimestamp - now;

        // If past the date or in grace period, show fallback message
        if (difference <= 0 || isGracePeriod) {
            showGracePeriodMessage($timer);
            return;
        }

        // Calculate time units
        var days = Math.floor(difference / (1000 * 60 * 60 * 24));
        var hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((difference % (1000 * 60)) / 1000);

        // Update DOM elements
        $timer.find('.countdown-days').text(padNumber(days));
        $timer.find('.countdown-hours').text(padNumber(hours));
        $timer.find('.countdown-mins').text(padNumber(minutes));
        $timer.find('.countdown-secs').text(padNumber(seconds));
    }

    /**
     * Pad single digit numbers with leading zero
     */
    function padNumber(num) {
        return num < 10 ? '0' + num : num;
    }

    /**
     * Show grace period message instead of countdown
     */
    function showGracePeriodMessage($timer) {
        var message = $timer.data('grace-message') || gracePeriodMessage;
        $timer.html('<p class="countdown-grace-message">' + message + '</p>');
    }

    /**
     * Initialize countdown on DOM ready
     */
    $(document).ready(function() {
        // Initial update
        updateCountdown();

        // Update every second
        setInterval(updateCountdown, 1000);
    });

})(jQuery);
