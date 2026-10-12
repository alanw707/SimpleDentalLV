<?php
/**
 * Header navigation module.
 *
 * Owns menu item definitions, current-page matching, and emitted navigation
 * markup so header.php stays a layout caller instead of the navigation source.
 */

if (!defined('ABSPATH')) {
    exit;
}

function simple_dental_header_navigation_items() {
    return array(
        array('path' => '/services/', 'label' => __t('Services'), 'icon' => '<circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6"/><path d="M1 12h6m6 0h6"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/><circle cx="5" cy="12" r="1"/><circle cx="19" cy="12" r="1"/>'),
        array('path' => '/treatment-guides/', 'label' => __t('Prices', 'key:guides.nav.label'), 'icon' => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M9 7h7"/><path d="M9 11h5"/>'),
        array('path' => '/testimonials/', 'label' => __t('Reviews'), 'icon' => '<path d="M21 15a4 4 0 0 1-4 4H7l-4 4V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/><path d="M8 8h8"/><path d="M8 12h6"/>'),
        array('path' => '/about/', 'label' => __t('About', 'key:nav.about'), 'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'),
        array('path' => '/contact/', 'label' => __t('Contact'), 'icon' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>'),
    );
}

function simple_dental_header_navigation_current_path() {
    $current_path = isset($GLOBALS['wp']->request) ? '/' . trim((string) $GLOBALS['wp']->request, '/') . '/' : '/';
    return trailingslashit(simple_dental_strip_language_prefix_from_path($current_path));
}

function simple_dental_header_navigation_is_current($item_path, $current_path) {
    $item_path = trailingslashit($item_path);
    return ($current_path === $item_path) || ('/' === $item_path && ('/' === $current_path || '' === $current_path));
}

function simple_dental_render_header_navigation() {
    $current_path = simple_dental_header_navigation_current_path();

    echo '<ul id="primary-menu" class="primary-menu">';
    echo '<li class="language-switcher-item">';
    echo '  <div class="language-switcher-wrapper">';
    echo        simple_dental_language_switcher();
    echo '  </div>';
    echo '</li>';

    foreach (simple_dental_header_navigation_items() as $item) {
        $aria_current = simple_dental_header_navigation_is_current($item['path'], $current_path) ? ' aria-current="page"' : '';
        echo '<li><a href="' . esc_url(simple_dental_with_lang(home_url($item['path']))) . '"' . $aria_current . '><svg class="menu-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $item['icon'] . '</svg><span class="menu-text">' . esc_html($item['label']) . '</span></a></li>';
    }

    echo '</ul>';
}
