<?php
/**
 * Smile Preview Provider adapter.
 *
 * Keeps image-provider details behind the Smile Preview Flow seam so HTTP
 * handlers do not know model, prompt, endpoint, transport, or response shape.
 */

if (!defined('ABSPATH')) {
    exit;
}

function simple_dental_smile_preview_provider_generate($file_path, $mime_type, $goal_prompts) {
    $filtered_result = apply_filters('simple_dental_smile_preview_provider_result', null, $file_path, $mime_type, $goal_prompts);
    if ($filtered_result !== null) {
        return $filtered_result;
    }

    return simple_dental_openai_smile_preview_generate($file_path, $mime_type, $goal_prompts);
}

function simple_dental_smile_preview_provider_api_key() {
    if (defined('SIMPLE_DENTAL_OPENAI_API_KEY') && SIMPLE_DENTAL_OPENAI_API_KEY) {
        return SIMPLE_DENTAL_OPENAI_API_KEY;
    }

    $env_key = getenv('OPENAI_API_KEY');
    return $env_key ? $env_key : '';
}

function simple_dental_smile_preview_provider_model() {
    if (defined('SIMPLE_DENTAL_OPENAI_IMAGE_MODEL') && SIMPLE_DENTAL_OPENAI_IMAGE_MODEL) {
        return SIMPLE_DENTAL_OPENAI_IMAGE_MODEL;
    }

    $env_model = getenv('SIMPLE_DENTAL_OPENAI_IMAGE_MODEL');
    return $env_model ? $env_model : 'gpt-image-2';
}

function simple_dental_smile_preview_provider_prompt($goal_prompts) {
    $safe_goals = $goal_prompts ? $goal_prompts : 'natural subtle improvement';

    return 'Edit this uploaded photo with maximum identity preservation. This is an image edit, not a new portrait. Keep the same person exactly recognizable: same face shape, eye shape, eyebrows, nose, cheeks, jawline, skin texture, skin tone, ears, hairline, hairstyle, facial hair, glasses or no glasses, clothing, pose, camera angle, crop, lighting, background, and expression. Do not add glasses, remove glasses, change age, change gender, change ethnicity, reshape the head, alter the eyes, alter the nose, or beautify the face. Change only teeth that are already visible. Do not open a closed mouth, invent teeth, add a new smile, or change lips except for minimal natural adjustments required by visible-teeth edits. If visible teeth cannot be edited without changing identity, return the original person nearly unchanged. Selected smile goals: ' . $safe_goals . '. Make only the visible teeth look natural, clean, healthy, and professionally improved while preserving realistic proportions. Non-clinical visual concept only; not dental advice or a guaranteed outcome.';
}

function simple_dental_openai_smile_preview_post_fields($file_path, $mime_type, $goal_prompts, $model) {
    $post_fields = array(
        'model' => $model,
        'prompt' => simple_dental_smile_preview_provider_prompt($goal_prompts),
        'size' => '1024x1024',
        'quality' => 'high',
        'n' => 1,
        'image[]' => curl_file_create($file_path, $mime_type, basename($file_path)),
    );

    if ($model !== 'gpt-image-2') {
        $post_fields['input_fidelity'] = 'high';
    }

    return $post_fields;
}

function simple_dental_openai_smile_preview_generate($file_path, $mime_type, $goal_prompts) {
    $api_key = simple_dental_smile_preview_provider_api_key();
    if ($api_key === '') {
        return new WP_Error('missing_api_key', 'AI image provider is not configured. Set OPENAI_API_KEY or SIMPLE_DENTAL_OPENAI_API_KEY locally.');
    }

    if (!function_exists('curl_init') || !function_exists('curl_file_create')) {
        return new WP_Error('missing_curl', 'PHP cURL file upload support is required for AI image generation.');
    }

    $model = simple_dental_smile_preview_provider_model();
    $post_fields = simple_dental_openai_smile_preview_post_fields($file_path, $mime_type, $goal_prompts, $model);

    $ch = curl_init('https://api.openai.com/v1/images/edits');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $api_key));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 360);

    $response = curl_exec($ch);
    $http_code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($response === false || $curl_error) {
        return new WP_Error('ai_request_failed', 'AI image request failed: ' . $curl_error);
    }

    $payload = json_decode($response, true);
    if ($http_code < 200 || $http_code >= 300) {
        $message = isset($payload['error']['message']) ? $payload['error']['message'] : 'AI image provider returned HTTP ' . $http_code;
        return new WP_Error('ai_provider_error', $message);
    }

    if (empty($payload['data'][0]['b64_json'])) {
        return new WP_Error('ai_missing_image', 'AI image provider did not return an image.');
    }

    return 'data:image/png;base64,' . $payload['data'][0]['b64_json'];
}
