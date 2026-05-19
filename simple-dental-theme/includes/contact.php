<?php
/**
 * Contact form handling, settings, and email routing.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * AJAX handler for contact form submission
 */
function simple_dental_ajax_contact_form() {
    $nonce = isset($_POST['contact_form_nonce']) ? sanitize_text_field(wp_unslash($_POST['contact_form_nonce'])) : '';

    // Verify nonce for security
    if (!wp_verify_nonce($nonce, 'simple_dental_contact_nonce')) {
        wp_send_json_error(array('message' => __t('Security verification failed. Please refresh and try again.')));
    }
    
    $errors = array();
    
    // Sanitize input data
    $name = isset($_POST['contact_name']) ? sanitize_text_field(wp_unslash($_POST['contact_name'])) : '';
    $email = isset($_POST['contact_email']) ? sanitize_email(wp_unslash($_POST['contact_email'])) : '';
    $phone = isset($_POST['contact_phone']) ? sanitize_text_field(wp_unslash($_POST['contact_phone'])) : '';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field(wp_unslash($_POST['contact_message'])) : '';
    
    // Validate required fields
    if (empty($name)) {
        $errors[] = __t('Name is required.');
    }
    if (empty($email) || !is_email($email)) {
        $errors[] = __t('Valid email is required.');
    }
    if (empty($message)) {
        $errors[] = __t('Message is required.');
    }
    
    // Verify reCAPTCHA if available
    if (simple_dental_has_captcha_field() && !simple_dental_verify_recaptcha_response()) {
        $errors[] = __t('Please complete the CAPTCHA verification.');
    }
    
    // If validation errors, return them
    if (!empty($errors)) {
        wp_die(json_encode(array('success' => false, 'errors' => $errors)));
    }
    
    // Get custom email settings
    $email_settings = simple_dental_get_contact_emails();
    
    // Check if notifications are enabled
    if (!$email_settings['notifications_enabled']) {
        error_log('Simple Dental Contact Form AJAX - Email notifications disabled');
        wp_die(json_encode(array('success' => true, 'message' => __t("Thank you! Your message has been received. We'll get back to you within 24 hours."))));
    }
    
    // Prepare email recipients
    $to = $email_settings['primary'];
    $cc_emails = $email_settings['cc'];
    
    error_log('Simple Dental Contact Form AJAX - Sending to: ' . $to . (empty($cc_emails) ? '' : ' (CC: ' . implode(', ', $cc_emails) . ')'));
    
    // Prepare email subject with custom prefix
    $subject_prefix = $email_settings['subject_prefix'];
    $subject = $subject_prefix . ' ' . __t('Contact Form Submission');
    
    // Prepare email body
    $body = __t('New contact form submission from Simple Dental website:') . "\n\n";
    $body .= __t('Name:') . " $name\n";
    $body .= __t('Email:') . " $email\n";
    $body .= __t('Phone:') . " $phone\n\n";
    $body .= __t('Message:') . "\n$message\n\n";
    $body .= "---\n";
    $body .= "Submitted: " . date('Y-m-d H:i:s') . "\n";
    $body .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    // Prepare email headers
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Simple Dental Website <' . $to . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Add CC headers if CC emails are specified
    if (!empty($cc_emails)) {
        foreach ($cc_emails as $cc_email) {
            $headers[] = 'Cc: ' . $cc_email;
        }
    }
    
    // Attempt to send email
    $mail_sent = wp_mail($to, $subject, $body, $headers);
    
    if ($mail_sent) {
        error_log('Simple Dental Contact Form AJAX - Email sent successfully');
        wp_die(json_encode(array('success' => true, 'message' => __t("Thank you! Your message has been sent successfully. We'll get back to you within 24 hours."))));
    } else {
        error_log('Simple Dental Contact Form AJAX - Email failed to send to: ' . $to);
        // Provide helpful error message with contact alternatives
        $error_message = __t('Sorry, there was an error sending your message. Please try one of these alternatives:');
        $error_message .= '\n• ' . __t('Call us directly at (702) 302-4787');
        $error_message .= '\n• ' . __t('Email us at') . ' ' . $to;
        if (!empty($cc_emails)) {
            $error_message .= ' or ' . implode(', ', $cc_emails);
        }
        wp_die(json_encode(array('success' => false, 'message' => $error_message)));
    }
}
add_action('wp_ajax_simple_dental_contact', 'simple_dental_ajax_contact_form');
add_action('wp_ajax_nopriv_simple_dental_contact', 'simple_dental_ajax_contact_form');

/**
 * Contact form shortcode (enhanced with AJAX and CAPTCHA)
 */
function simple_dental_contact_form() {
    ob_start();
    ?>
    <div id="contact-form-messages"></div>
    
    <form id="simple-contact-form" class="simple-contact-form">
        <?php wp_nonce_field('simple_dental_contact_nonce', 'contact_form_nonce'); ?>
        
        <div class="form-row">
            <input type="text" name="contact_name" id="contact_name" placeholder="<?php echo __t('Your Name*'); ?>" required>
            <input type="email" name="contact_email" id="contact_email" placeholder="<?php echo __t('Your Email*'); ?>" required>
        </div>
        
        <div class="form-row">
            <input type="tel" name="contact_phone" id="contact_phone" placeholder="<?php echo __t('Your Phone Number'); ?>">
        </div>
        
        <div class="form-row">
            <textarea name="contact_message" id="contact_message" placeholder="<?php echo __t('Your Message*'); ?>" rows="5" required></textarea>
        </div>
        
        <?php if (simple_dental_has_captcha_field()) : ?>
        <div class="form-row captcha-row">
            <?php simple_dental_render_captcha_field(); ?>
        </div>
        <?php endif; ?>
        
        <div class="form-row">
            <button type="submit" id="contact-submit-btn" class="btn btn-primary">
                <span class="btn-text"><?php echo __t('Send Message'); ?></span>
                <span class="btn-loading" style="display: none;"><?php echo __t('Sending...'); ?></span>
            </button>
        </div>
        
        <div class="form-row form-note">
            <small><strong>*</strong> <?php echo __t('Required fields'); ?> | <?php echo __t('We respect your privacy and will never share your information.'); ?></small>
        </div>
    </form>
    
    <script>
    jQuery(document).ready(function($) {
        $('#simple-contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var submitBtn = $('#contact-submit-btn');
            var btnText = submitBtn.find('.btn-text');
            var btnLoading = submitBtn.find('.btn-loading');
            var messagesDiv = $('#contact-form-messages');
            
            // Show loading state
            submitBtn.prop('disabled', true);
            btnText.hide();
            btnLoading.show();
            messagesDiv.empty();
            
            // Collect form data
            var formData = {
                action: 'simple_dental_contact',
                contact_name: $('#contact_name').val(),
                contact_email: $('#contact_email').val(),
                contact_phone: $('#contact_phone').val(),
                contact_message: $('#contact_message').val(),
                contact_form_nonce: $('input[name="contact_form_nonce"]').val()
            };
            
            // Add reCAPTCHA response if available
            var hiddenCaptchaResponse = $('[name="g-recaptcha-response"]').val();
            if (hiddenCaptchaResponse) {
                formData['g-recaptcha-response'] = hiddenCaptchaResponse;
            } else if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.getResponse === 'function') {
                var captchaResponse = grecaptcha.getResponse();
                if (captchaResponse) {
                    formData['g-recaptcha-response'] = captchaResponse;
                }
            }
            
            // Submit via AJAX
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        messagesDiv.html('<div class="contact-success">✅ <strong><?php echo __t('Thank you!'); ?></strong> ' + response.message + '</div>');
                        // Reset form
                        $('#simple-contact-form')[0].reset();
                        // Reset reCAPTCHA if available
                        if (typeof grecaptcha !== 'undefined') {
                            grecaptcha.reset();
                        }
                        // Scroll to success message
                        $('html, body').animate({
                            scrollTop: messagesDiv.offset().top - 100
                        }, 500);
                    } else {
                        // Show error message(s)
                        var errorHtml = '<div class="contact-error">';
                        if (response.errors && response.errors.length > 0) {
                            errorHtml += '<strong><?php echo __t('Please correct the following:'); ?></strong><ul>';
                            response.errors.forEach(function(error) {
                                errorHtml += '<li>' + error + '</li>';
                            });
                            errorHtml += '</ul>';
                        } else {
                            errorHtml += response.message || '<?php echo __t('An error occurred. Please try again.'); ?>';
                        }
                        errorHtml += '</div>';
                        messagesDiv.html(errorHtml);
                        
                        // Scroll to error message
                        $('html, body').animate({
                            scrollTop: messagesDiv.offset().top - 100
                        }, 500);
                    }
                },
                error: function() {
                    messagesDiv.html('<div class="contact-error"><?php echo __t('Connection error. Please try again or call us directly at (702) 302-4787.'); ?></div>');
                },
                complete: function() {
                    // Reset button state
                    submitBtn.prop('disabled', false);
                    btnText.show();
                    btnLoading.hide();
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('simple_dental_contact', 'simple_dental_contact_form');


/**
 * WordPress Customizer Settings for Contact Form
 */
function simple_dental_customizer_settings($wp_customize) {
    // Add Contact Form Settings Section
    $current_settings = simple_dental_get_contact_emails();
    $settings_info = 'Current settings: Primary email: ' . $current_settings['primary'];
    if (!empty($current_settings['cc'])) {
        $settings_info .= ' | CC: ' . implode(', ', $current_settings['cc']);
    }
    $settings_info .= ' | Subject prefix: ' . $current_settings['subject_prefix'];
    
    $wp_customize->add_section('simple_dental_contact_settings', array(
        'title' => 'Contact Form Settings',
        'description' => 'Configure email settings for contact form submissions. ' . $settings_info,
        'priority' => 30,
    ));
    
    // Primary Contact Email Setting
    $wp_customize->add_setting('contact_form_primary_email', array(
        'default' => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_primary_email', array(
        'label' => 'Primary Contact Email',
        'description' => 'Main email address to receive contact form submissions. Defaults to WordPress admin email.',
        'section' => 'simple_dental_contact_settings',
        'type' => 'email',
        'priority' => 10,
    ));
    
    // Additional CC Emails Setting
    $wp_customize->add_setting('contact_form_cc_emails', array(
        'default' => '',
        'sanitize_callback' => 'simple_dental_sanitize_email_list',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_cc_emails', array(
        'label' => 'Additional Recipients (CC)',
        'description' => 'Additional email addresses to CC on contact forms. Separate multiple emails with commas. Example: email1@domain.com, email2@domain.com',
        'section' => 'simple_dental_contact_settings',
        'type' => 'textarea',
        'priority' => 20,
    ));
    
    // Email Subject Prefix Setting
    $wp_customize->add_setting('contact_form_subject_prefix', array(
        'default' => '[Simple Dental Website]',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_subject_prefix', array(
        'label' => 'Email Subject Prefix',
        'description' => 'Text to prepend to contact form email subjects. Helps identify website emails.',
        'section' => 'simple_dental_contact_settings',
        'type' => 'text',
        'priority' => 30,
    ));
    
    // Email Notifications Toggle
    $wp_customize->add_setting('contact_form_notifications_enabled', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('contact_form_notifications_enabled', array(
        'label' => 'Enable Email Notifications',
        'description' => 'Turn on/off email notifications for contact form submissions.',
        'section' => 'simple_dental_contact_settings',
        'type' => 'checkbox',
        'priority' => 40,
    ));
}
add_action('customize_register', 'simple_dental_customizer_settings');


/**
 * Sanitize email list (comma-separated emails)
 */
function simple_dental_sanitize_email_list($input) {
    if (empty($input)) {
        return '';
    }
    
    // Split by comma and sanitize each email
    $emails = array_map('trim', explode(',', $input));
    $valid_emails = array();
    
    foreach ($emails as $email) {
        $sanitized_email = sanitize_email($email);
        if (!empty($sanitized_email) && is_email($sanitized_email)) {
            $valid_emails[] = $sanitized_email;
        }
    }
    
    return implode(', ', $valid_emails);
}

/**
 * Get contact form email settings with fallbacks
 */
function simple_dental_get_contact_emails() {
    $primary_email = get_theme_mod('contact_form_primary_email', get_option('admin_email'));
    $cc_emails = get_theme_mod('contact_form_cc_emails', '');
    
    // Validate primary email
    if (empty($primary_email) || !is_email($primary_email)) {
        $primary_email = get_option('admin_email');
        error_log('Simple Dental Contact Form - Invalid primary email, using admin email: ' . $primary_email);
    }
    
    // Process CC emails
    $cc_email_array = array();
    if (!empty($cc_emails)) {
        $cc_emails_list = array_map('trim', explode(',', $cc_emails));
        foreach ($cc_emails_list as $email) {
            if (!empty($email) && is_email($email)) {
                $cc_email_array[] = $email;
            }
        }
    }
    
    return array(
        'primary' => $primary_email,
        'cc' => $cc_email_array,
        'subject_prefix' => get_theme_mod('contact_form_subject_prefix', '[Simple Dental Website]'),
        'notifications_enabled' => get_theme_mod('contact_form_notifications_enabled', true)
    );
}

?>
