<?php
/**
 * Smile Preview Flow contract.
 *
 * Shared facts for the Smile Preview Flow interface. Keep browser and PHP
 * validation in sync here; provider and rendering details stay behind callers.
 */

if (!defined('ABSPATH')) {
    exit;
}

function simple_dental_smile_preview_translate($text) {
    return function_exists('__t') ? __t($text) : $text;
}

function simple_dental_smile_preview_contract() {
    $max_file_size = 8 * 1024 * 1024;
    $t = 'simple_dental_smile_preview_translate';

    return array(
        'maxFileSize' => $max_file_size,
        'maxFileSizeMb' => 8,
        'allowedMimeTypes' => array('image/jpeg', 'image/png', 'image/webp'),
        'acceptedFileTypes' => 'image/jpeg,image/png,image/webp',
        'goalInputName' => 'smile-goal',
        'requiresConsent' => true,
        'uploadHint' => $t('JPG, PNG, or WebP up to 8 MB'),
        'consentText' => $t('I understand this AI smile preview is for illustrative purposes only and is not dental advice, diagnosis, treatment planning, or a guarantee of results. I consent to Simple Dental LV using my uploaded photo to generate my preview and contact me about cosmetic dentistry services.'),
        'goals' => array(
            array('id' => 'whiter-smile', 'label' => $t('Whiter smile'), 'prompt' => 'Whiter smile'),
            array('id' => 'straighter-smile', 'label' => $t('Straighter smile'), 'prompt' => 'Straighter smile'),
            array('id' => 'close-small-gaps', 'label' => $t('Close small gaps'), 'prompt' => 'Close small gaps'),
            array('id' => 'veneer-style-smile-makeover', 'label' => $t('Veneer-style makeover'), 'prompt' => 'Veneer-style smile makeover'),
            array('id' => 'fix-chipped-or-uneven-teeth', 'label' => $t('Fix chipped / uneven teeth'), 'prompt' => 'Fix chipped or uneven teeth concept'),
            array('id' => 'smooth-worn-edges', 'label' => $t('Smooth worn edges'), 'prompt' => 'Smooth worn tooth edges concept'),
            array('id' => 'natural-subtle-improvement', 'label' => $t('Natural subtle improvement'), 'prompt' => 'Natural subtle improvement'),
            array('id' => 'balanced-smile-shape', 'label' => $t('Balanced smile shape'), 'prompt' => 'Balanced smile shape concept'),
            array('id' => 'hollywood-bright-smile', 'label' => $t('Hollywood bright smile'), 'prompt' => 'Hollywood bright smile'),
        ),
        'messages' => array(
            'missingPhoto' => $t('Please choose a smile selfie first.'),
            'uploadRequired' => $t('Please upload a smile selfie.'),
            'invalidType' => $t('Please upload a JPG, PNG, or WebP image.'),
            'tooLarge' => $t('Please choose an image smaller than 8 MB.'),
            'missingGoal' => $t('Choose at least one smile goal.'),
            'missingConsent' => $t('Consent is required before generating a preview.'),
            'missingCaptcha' => $t('Please complete the CAPTCHA before generating your preview.'),
            'captchaVerificationFailed' => $t('Please complete the CAPTCHA verification.'),
            'securityFailed' => $t('Security check failed.'),
            'rateLimited' => $t('Too many preview requests. Please call Simple Dental LV or try again later.'),
            'aiFailed' => $t('Could not generate AI smile preview.'),
            'aiParseFailed' => $t('Could not generate AI smile preview. Please refresh and try again.'),
            'imageReadFailed' => $t('Could not read this image. Please try another photo.'),
            'imageProcessFailed' => $t('Could not process this image. Please try another photo.'),
            'imagePrepareFailed' => $t('Could not prepare this image for AI generation.'),
            'defaultFileName' => $t('smile-selfie'),
            'choosePhoto' => $t('Choose a photo'),
            'generatingLabel' => $t('Generating AI Preview...'),
            'generateLabel' => $t('Generate AI Preview'),
            'selectedGoalSingular' => $t('Selected goal: '),
            'selectedGoalPlural' => $t('Selected goals: '),
            'requestReceived' => $t('Request received.'),
            'submitFailed' => $t('Could not submit request. Please call Simple Dental LV.'),
            'previewFailed' => $t('Could not generate the smile preview.'),
        ),
    );
}

function simple_dental_smile_preview_allowed_mime_types() {
    $contract = simple_dental_smile_preview_contract();
    return $contract['allowedMimeTypes'];
}

function simple_dental_smile_preview_max_file_size() {
    $contract = simple_dental_smile_preview_contract();
    return (int) $contract['maxFileSize'];
}

function simple_dental_smile_preview_goals() {
    $contract = simple_dental_smile_preview_contract();
    return $contract['goals'];
}

function simple_dental_smile_preview_goal_prompt_values($goal_ids_or_labels) {
    $selected = is_array($goal_ids_or_labels) ? $goal_ids_or_labels : explode(',', (string) $goal_ids_or_labels);
    $selected = array_map('trim', $selected);
    $selected = array_filter($selected, 'strlen');
    $by_id = array();
    $by_label = array();

    foreach (simple_dental_smile_preview_goals() as $goal) {
        $by_id[$goal['id']] = $goal['prompt'];
        $by_label[$goal['prompt']] = $goal['prompt'];
        $by_label[$goal['label']] = $goal['prompt'];
    }

    $prompts = array();
    foreach ($selected as $value) {
        if (isset($by_id[$value])) {
            $prompts[] = $by_id[$value];
        } elseif (isset($by_label[$value])) {
            $prompts[] = $by_label[$value];
        }
    }

    return array_values(array_unique($prompts));
}

function simple_dental_smile_preview_contract_for_browser() {
    $contract = simple_dental_smile_preview_contract();
    foreach ($contract['goals'] as $index => $goal) {
        unset($contract['goals'][$index]['prompt']);
    }
    global $simple_dental_translator;
    $contract['currentLanguage'] = ($simple_dental_translator && method_exists($simple_dental_translator, 'get_current_language')) ? $simple_dental_translator->get_current_language() : 'en';
    $contract['ajaxUrl'] = admin_url('admin-ajax.php');
    $contract['nonce'] = wp_create_nonce('simple_dental_smile_preview_nonce');
    $contract['generateNonce'] = wp_create_nonce('simple_dental_smile_preview_generate_nonce');
    return $contract;
}
