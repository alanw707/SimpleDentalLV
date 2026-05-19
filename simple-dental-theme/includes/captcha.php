<?php
/**
 * CAPTCHA integration helpers.
 *
 * Supports configured reCAPTCHA keys and compatible CAPTCHA plugins for forms
 * that need spam protection.
 */

if (!defined('ABSPATH')) {
    exit;
}

function simple_dental_get_recaptcha_keys() {
    $site_key = '';
    $secret_key = '';
    $type = '';

    $c4wp_options = get_option('c4wp_admin_options', array());
    if (is_array($c4wp_options)) {
        $site_key = isset($c4wp_options['site_key']) ? trim((string) $c4wp_options['site_key']) : $site_key;
        $secret_key = isset($c4wp_options['secret_key']) ? trim((string) $c4wp_options['secret_key']) : $secret_key;
        $type = simple_dental_detect_recaptcha_type($c4wp_options, 'v3');
    }

    $wpcaptcha_options = get_option('wpcaptcha_options', array());
    if (is_array($wpcaptcha_options) && $site_key === '') {
        $site_key = isset($wpcaptcha_options['captcha_site_key']) ? trim((string) $wpcaptcha_options['captcha_site_key']) : '';
        $secret_key = isset($wpcaptcha_options['captcha_secret_key']) ? trim((string) $wpcaptcha_options['captcha_secret_key']) : '';
        $type = simple_dental_detect_recaptcha_type($wpcaptcha_options, 'v2');
    }

    return array(
        'site_key' => $site_key,
        'secret_key' => $secret_key,
        'type' => $type ?: 'v2',
    );
}

function simple_dental_detect_recaptcha_type($options, $default) {
    foreach ($options as $key => $value) {
        if (is_scalar($value) && preg_match('/recaptcha.*(v3|version_3|invisible|v2|version_2)|captcha.*(v3|version_3|invisible|v2|version_2)/i', (string) $key . ' ' . (string) $value, $matches)) {
            $match = strtolower(implode(' ', $matches));
            if (strpos($match, 'v3') !== false || strpos($match, 'version_3') !== false) {
                return 'v3';
            }
            if (strpos($match, 'invisible') !== false) {
                return 'v3';
            }
            if (strpos($match, 'v2') !== false || strpos($match, 'version_2') !== false) {
                return 'v2';
            }
        }
    }

    return $default;
}

function simple_dental_render_captcha_field() {
    $keys = simple_dental_get_recaptcha_keys();
    if ($keys['site_key'] !== '') {
        if ($keys['type'] === 'v3') {
            wp_enqueue_script('google-recaptcha-v3', 'https://www.google.com/recaptcha/api.js?render=' . rawurlencode($keys['site_key']), array(), null, true);
            echo '<input type="hidden" class="simple-dental-recaptcha-v3" name="g-recaptcha-response" data-sitekey="' . esc_attr($keys['site_key']) . '" value="">';
            echo '<script>(function(){var field=document.currentScript.previousElementSibling;if(!field)return;var form=field.form;if(!form)return;form.addEventListener("submit",function(e){if(field.value||typeof grecaptcha==="undefined"||!grecaptcha.execute)return;e.preventDefault();e.stopImmediatePropagation();grecaptcha.ready(function(){grecaptcha.execute(field.dataset.sitekey,{action:"simple_dental_form"}).then(function(token){field.value=token;form.dispatchEvent(new Event("submit",{bubbles:true,cancelable:true}));});});},true);})();</script>';
            return true;
        }

        wp_enqueue_script('google-recaptcha-v2', 'https://www.google.com/recaptcha/api.js', array(), null, true);
        echo '<div class="g-recaptcha" data-sitekey="' . esc_attr($keys['site_key']) . '"></div>';
        return true;
    }

    if (function_exists('anr_captcha_form_field')) {
        anr_captcha_form_field();
        return true;
    }

    return false;
}

function simple_dental_has_captcha_field() {
    $keys = simple_dental_get_recaptcha_keys();
    $has_captcha = $keys['site_key'] !== '' || function_exists('anr_captcha_form_field');
    return (bool) apply_filters('simple_dental_smile_preview_has_captcha_field', $has_captcha);
}

function simple_dental_verify_recaptcha_response() {
    $filtered_result = apply_filters('simple_dental_smile_preview_captcha_result', null);
    if ($filtered_result !== null) {
        return (bool) $filtered_result;
    }

    $response = isset($_POST['g-recaptcha-response']) ? sanitize_text_field(wp_unslash($_POST['g-recaptcha-response'])) : '';
    if ($response === '') {
        return false;
    }

    $keys = simple_dental_get_recaptcha_keys();
    if ($keys['secret_key'] !== '') {
        $request = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
            'timeout' => 10,
            'body' => array(
                'secret' => $keys['secret_key'],
                'response' => $response,
                'remoteip' => simple_dental_get_client_ip(),
            ),
        ));

        if (is_wp_error($request)) {
            return false;
        }

        $body = json_decode(wp_remote_retrieve_body($request), true);
        return is_array($body) && !empty($body['success']);
    }

    if (function_exists('anr_verify_captcha')) {
        return (bool) anr_verify_captcha($response);
    }

    return true;
}
