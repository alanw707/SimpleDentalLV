<?php
/**
 * Custom landing page routing.
 *
 * Maps stable marketing URLs to theme templates without relying on editable
 * WordPress page records for these high-value landing pages.
 */

if (!defined('ABSPATH')) {
    exit;
}

function simple_dental_get_same_day_crowns_path() {
    return '/same-day-crowns-las-vegas/';
}

function simple_dental_get_testimonials_path() {
    return '/testimonials/';
}

function simple_dental_get_smile_preview_path() {
    return '/smile-preview/';
}

function simple_dental_get_normalized_request_path() {
    $request_path = isset($_SERVER['REQUEST_URI'])
        ? strtok(sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])), '?')
        : '';

    $request_path = simple_dental_strip_language_prefix_from_path((string) $request_path);
    return '/' . trim($request_path, '/') . '/';
}

function simple_dental_is_same_day_crowns_request() {
    return simple_dental_get_normalized_request_path() === simple_dental_get_same_day_crowns_path();
}

function simple_dental_is_testimonials_request() {
    return simple_dental_get_normalized_request_path() === simple_dental_get_testimonials_path();
}

function simple_dental_is_smile_preview_request() {
    return simple_dental_get_normalized_request_path() === simple_dental_get_smile_preview_path();
}

function simple_dental_render_custom_template($template_file) {
    status_header(200);
    global $wp_query;
    if ($wp_query) {
        $wp_query->is_404 = false;
    }

    include get_template_directory() . '/' . ltrim($template_file, '/');
    exit;
}

function simple_dental_render_same_day_crowns_page() {
    if (!simple_dental_is_same_day_crowns_request()) {
        return;
    }

    simple_dental_render_custom_template('page-same-day-crowns.php');
}
add_action('template_redirect', 'simple_dental_render_same_day_crowns_page', 1);

function simple_dental_render_testimonials_page() {
    if (!simple_dental_is_testimonials_request()) {
        return;
    }

    simple_dental_render_custom_template('page-testimonials.php');
}
add_action('template_redirect', 'simple_dental_render_testimonials_page', 1);

function simple_dental_render_smile_preview_page() {
    if (!simple_dental_is_smile_preview_request()) {
        return;
    }

    simple_dental_render_custom_template('page-smile-preview.php');
}
add_action('template_redirect', 'simple_dental_render_smile_preview_page', 1);
