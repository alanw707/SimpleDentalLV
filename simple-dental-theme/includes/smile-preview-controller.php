<?php
/**
 * Smile Preview request handlers.
 *
 * Owns rate limiting, AI preview generation, and consultation lead capture for
 * the Smile Preview flow. Rendering and provider details live in separate files.
 */

if (!defined('ABSPATH')) {
    exit;
}

function simple_dental_smile_preview_rate_limit_key() {
    return 'simple_dental_smile_preview_rate_' . md5(simple_dental_get_client_ip());
}

function simple_dental_smile_preview_is_rate_limited() {
    $key = simple_dental_smile_preview_rate_limit_key();
    $attempts = get_transient($key);

    if (!is_array($attempts)) {
        $attempts = array();
    }

    $now = time();
    $attempts = array_filter($attempts, function ($timestamp) use ($now) {
        return ((int) $timestamp) > ($now - HOUR_IN_SECONDS);
    });

    if (count($attempts) >= 20) {
        set_transient($key, $attempts, HOUR_IN_SECONDS);
        return true;
    }

    $attempts[] = $now;
    set_transient($key, $attempts, HOUR_IN_SECONDS);
    return false;
}

function simple_dental_smile_preview_purge_old_leads() {
    $leads = get_option('simple_dental_smile_preview_leads', array());
    if (!is_array($leads)) {
        return;
    }

    $cutoff = strtotime('-30 days', current_time('timestamp'));
    $leads = array_filter($leads, function ($lead) use ($cutoff) {
        if (empty($lead['created_at'])) {
            return false;
        }
        return strtotime($lead['created_at']) >= $cutoff;
    });

    update_option('simple_dental_smile_preview_leads', array_values($leads), false);
}

function simple_dental_smile_preview_apply_ajax_language() {
    if (empty($_POST['lang'])) {
        return;
    }

    $language = sanitize_text_field(wp_unslash($_POST['lang']));
    if ($language === 'en' || simple_dental_language_code_to_slug($language)) {
        global $simple_dental_translator;
        if ($simple_dental_translator && method_exists($simple_dental_translator, 'set_language')) {
            $simple_dental_translator->set_language($language);
        }
    }
}

function simple_dental_smile_preview_validate_upload($file, $messages) {
    if (!is_array($file) || empty($file['tmp_name'])) {
        return new WP_Error('missing_upload', $messages['uploadRequired']);
    }

    if (!isset($file['error']) || (int) $file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        return new WP_Error('invalid_upload', $messages['uploadRequired']);
    }

    $size = isset($file['size']) ? (int) $file['size'] : 0;
    if ($size <= 0) {
        return new WP_Error('invalid_upload', $messages['invalidType']);
    }

    if ($size > simple_dental_smile_preview_max_file_size()) {
        return new WP_Error('too_large', $messages['tooLarge']);
    }

    $allowed_types = simple_dental_smile_preview_allowed_mime_types();
    $detected_mime = '';

    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $detected_mime = (string) finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
        }
    }

    $image_info = @getimagesize($file['tmp_name']);
    $image_mime = is_array($image_info) && !empty($image_info['mime']) ? sanitize_mime_type($image_info['mime']) : '';
    $detected_mime = sanitize_mime_type($detected_mime ?: $image_mime);

    if (!in_array($detected_mime, $allowed_types, true) || !in_array($image_mime, $allowed_types, true)) {
        return new WP_Error('invalid_type', $messages['invalidType']);
    }

    return $detected_mime;
}

function simple_dental_ajax_smile_preview_generate() {
    if (function_exists('set_time_limit')) {
        @set_time_limit(420);
    }

    $contract = simple_dental_smile_preview_contract();
    $messages = $contract['messages'];

    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'simple_dental_smile_preview_generate_nonce')) {
        wp_send_json_error(array('message' => $messages['securityFailed']), 403);
    }

    simple_dental_smile_preview_apply_ajax_language();
    $contract = simple_dental_smile_preview_contract();
    $messages = $contract['messages'];

    if (simple_dental_smile_preview_is_rate_limited()) {
        wp_send_json_error(array('message' => $messages['rateLimited']), 429);
    }

    if (simple_dental_has_captcha_field() && !simple_dental_verify_recaptcha_response()) {
        wp_send_json_error(array('message' => $messages['captchaVerificationFailed']), 400);
    }

    if (empty($_FILES['smile_photo']) || !isset($_FILES['smile_photo']['tmp_name'])) {
        wp_send_json_error(array('message' => $messages['uploadRequired']), 400);
    }

    $file = $_FILES['smile_photo'];
    $mime_type = simple_dental_smile_preview_validate_upload($file, $messages);
    if (is_wp_error($mime_type)) {
        wp_send_json_error(array('message' => $mime_type->get_error_message()), 400);
    }

    $submitted_goals = isset($_POST['goals']) ? sanitize_text_field(wp_unslash($_POST['goals'])) : '';
    $goal_prompts = simple_dental_smile_preview_goal_prompt_values($submitted_goals);
    if (empty($goal_prompts)) {
        wp_send_json_error(array('message' => $messages['missingGoal']), 400);
    }

    $generated_image = simple_dental_smile_preview_provider_generate($file['tmp_name'], $mime_type, implode(', ', $goal_prompts));

    if (is_wp_error($generated_image)) {
        error_log('Simple Dental Smile Preview provider error: ' . $generated_image->get_error_code() . ' - ' . $generated_image->get_error_message());
        wp_send_json_error(array(
            'message' => $messages['aiFailed'],
            'canUseFallback' => in_array($generated_image->get_error_code(), array('missing_api_key', 'missing_curl', 'ai_request_failed', 'ai_provider_error', 'ai_missing_image'), true),
        ), 503);
    }

    wp_send_json_success(array(
        'image' => $generated_image,
        'provider' => 'openai-images-edits-' . simple_dental_smile_preview_provider_model(),
        'retention' => 'Uploaded image is processed for this request only and is not retained by this site.',
    ));
}
add_action('wp_ajax_simple_dental_smile_preview_generate', 'simple_dental_ajax_smile_preview_generate');
add_action('wp_ajax_nopriv_simple_dental_smile_preview_generate', 'simple_dental_ajax_smile_preview_generate');

function simple_dental_ajax_smile_preview_lead() {
    $contract = simple_dental_smile_preview_contract();
    $messages = $contract['messages'];

    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'simple_dental_smile_preview_nonce')) {
        wp_send_json_error(array('message' => $messages['securityFailed']), 403);
    }

    simple_dental_smile_preview_apply_ajax_language();
    $contract = simple_dental_smile_preview_contract();
    $messages = $contract['messages'];

    if (simple_dental_smile_preview_is_rate_limited()) {
        wp_send_json_error(array('message' => $messages['rateLimited']), 429);
    }

    simple_dental_smile_preview_purge_old_leads();

    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $contact_method = isset($_POST['contactMethod']) ? sanitize_text_field(wp_unslash($_POST['contactMethod'])) : '';
    $goals = isset($_POST['goals']) ? sanitize_text_field(wp_unslash($_POST['goals'])) : '';
    $spam_check = isset($_POST['smile_check']) ? trim(sanitize_text_field(wp_unslash($_POST['smile_check']))) : '';
    $honeypot = isset($_POST['website']) ? trim(sanitize_text_field(wp_unslash($_POST['website']))) : '';
    $utm_source = isset($_POST['utm_source']) ? sanitize_text_field(wp_unslash($_POST['utm_source'])) : '';
    $utm_medium = isset($_POST['utm_medium']) ? sanitize_text_field(wp_unslash($_POST['utm_medium'])) : '';
    $utm_campaign = isset($_POST['utm_campaign']) ? sanitize_text_field(wp_unslash($_POST['utm_campaign'])) : '';
    $utm_content = isset($_POST['utm_content']) ? sanitize_text_field(wp_unslash($_POST['utm_content'])) : '';
    $utm_term = isset($_POST['utm_term']) ? sanitize_text_field(wp_unslash($_POST['utm_term'])) : '';

    if ($honeypot !== '') {
        wp_send_json_error(array('message' => simple_dental_smile_preview_translate('Spam check failed.')), 400);
    }

    if ($spam_check !== '7') {
        wp_send_json_error(array('message' => simple_dental_smile_preview_translate('Please answer the anti-spam question.')), 400);
    }

    if ($name === '' || $phone === '') {
        wp_send_json_error(array('message' => simple_dental_smile_preview_translate('Name and phone are required.')), 400);
    }

    if ($email !== '' && !is_email($email)) {
        wp_send_json_error(array('message' => simple_dental_smile_preview_translate('Please enter a valid email address.')), 400);
    }

    $lead = array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'contact_method' => $contact_method,
        'goals' => $goals,
        'utm' => array(
            'utm_source' => $utm_source,
            'utm_medium' => $utm_medium,
            'utm_campaign' => $utm_campaign,
            'utm_content' => $utm_content,
            'utm_term' => $utm_term,
        ),
        'created_at' => current_time('mysql'),
        'retention_delete_after_days' => 30,
        'source' => 'smile-preview-local-mvp',
    );

    $leads = get_option('simple_dental_smile_preview_leads', array());
    if (!is_array($leads)) {
        $leads = array();
    }

    array_unshift($leads, $lead);
    $leads = array_slice($leads, 0, 50);
    update_option('simple_dental_smile_preview_leads', $leads, false);

    $email_settings = simple_dental_get_contact_emails();
    if (!empty($email_settings['notifications_enabled'])) {
        $subject = $email_settings['subject_prefix'] . ' Smile Preview Lead';
        $body = "New AI Smile Preview lead from Simple Dental website:\n\n";
        $body .= "Name: $name\nEmail: $email\nPhone: $phone\nPreferred contact: $contact_method\nSmile goals: $goals\n\n";
        $body .= "UTM Source: $utm_source\nUTM Medium: $utm_medium\nUTM Campaign: $utm_campaign\nUTM Content: $utm_content\nUTM Term: $utm_term\n\n";
        $body .= "Submitted: " . current_time('mysql') . "\nIP Address: " . simple_dental_get_client_ip() . "\n";
        $body .= "Note: Uploaded images are processed temporarily for AI generation and are not retained by this site.\n";
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: Simple Dental Website <' . $email_settings['primary'] . '>',
        );
        if ($email !== '') {
            $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
        }
        if (!empty($email_settings['cc'])) {
            foreach ($email_settings['cc'] as $cc_email) {
                $headers[] = 'Cc: ' . $cc_email;
            }
        }
        wp_mail($email_settings['primary'], $subject, $body, $headers);
    }

    wp_send_json_success(array('message' => simple_dental_smile_preview_translate('Thanks. Simple Dental LV will follow up about your cosmetic consultation.')));
}
add_action('wp_ajax_simple_dental_smile_preview_lead', 'simple_dental_ajax_smile_preview_lead');
add_action('wp_ajax_nopriv_simple_dental_smile_preview_lead', 'simple_dental_ajax_smile_preview_lead');
