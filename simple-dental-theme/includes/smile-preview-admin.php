<?php
/**
 * Smile Preview leads admin UI.
 */

if (!defined('ABSPATH')) {
    exit;
}

function simple_dental_smile_preview_admin_slug() {
    return 'simple-dental-smile-preview-leads';
}

function simple_dental_smile_preview_get_leads() {
    $leads = get_option('simple_dental_smile_preview_leads', array());
    return is_array($leads) ? $leads : array();
}

function simple_dental_smile_preview_update_leads($leads) {
    update_option('simple_dental_smile_preview_leads', array_values($leads), false);
}

function simple_dental_smile_preview_admin_menu() {
    add_management_page(
        __('Smile Preview Leads', 'simple-dental'),
        __('Smile Preview Leads', 'simple-dental'),
        'manage_options',
        simple_dental_smile_preview_admin_slug(),
        'simple_dental_smile_preview_render_admin_page'
    );
}
add_action('admin_menu', 'simple_dental_smile_preview_admin_menu');

function simple_dental_smile_preview_admin_url($args = array()) {
    return add_query_arg(array_merge(array(
        'page' => simple_dental_smile_preview_admin_slug(),
    ), $args), admin_url('tools.php'));
}

function simple_dental_smile_preview_handle_admin_actions() {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }

    if (empty($_GET['page']) || $_GET['page'] !== simple_dental_smile_preview_admin_slug()) {
        return;
    }

    $action = isset($_GET['smile_action']) ? sanitize_key(wp_unslash($_GET['smile_action'])) : '';
    if ($action === '') {
        return;
    }

    check_admin_referer('simple_dental_smile_preview_' . $action);

    if ($action === 'export_csv') {
        simple_dental_smile_preview_export_csv();
    }

    if ($action === 'delete_lead') {
        $index = isset($_GET['lead']) ? absint($_GET['lead']) : -1;
        $leads = simple_dental_smile_preview_get_leads();
        if (isset($leads[$index])) {
            unset($leads[$index]);
            simple_dental_smile_preview_update_leads($leads);
            wp_safe_redirect(simple_dental_smile_preview_admin_url(array('smile_notice' => 'deleted')));
            exit;
        }
    }

    if ($action === 'clear_expired') {
        simple_dental_smile_preview_purge_old_leads();
        wp_safe_redirect(simple_dental_smile_preview_admin_url(array('smile_notice' => 'expired_cleared')));
        exit;
    }
}
add_action('admin_init', 'simple_dental_smile_preview_handle_admin_actions');

function simple_dental_smile_preview_export_csv() {
    $leads = simple_dental_smile_preview_get_leads();

    nocache_headers();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="smile-preview-leads-' . gmdate('Y-m-d') . '.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, array('Submitted', 'Name', 'Email', 'Phone', 'Goals', 'Notes', 'UTM Source', 'UTM Medium', 'UTM Campaign', 'UTM Content', 'UTM Term', 'Source'));

    foreach ($leads as $lead) {
        $utm = isset($lead['utm']) && is_array($lead['utm']) ? $lead['utm'] : array();
        fputcsv($output, array(
            isset($lead['created_at']) ? $lead['created_at'] : '',
            isset($lead['name']) ? $lead['name'] : '',
            isset($lead['email']) ? $lead['email'] : '',
            isset($lead['phone']) ? $lead['phone'] : '',
            isset($lead['goals']) ? $lead['goals'] : '',
            isset($lead['improvement_notes']) ? $lead['improvement_notes'] : '',
            isset($utm['utm_source']) ? $utm['utm_source'] : '',
            isset($utm['utm_medium']) ? $utm['utm_medium'] : '',
            isset($utm['utm_campaign']) ? $utm['utm_campaign'] : '',
            isset($utm['utm_content']) ? $utm['utm_content'] : '',
            isset($utm['utm_term']) ? $utm['utm_term'] : '',
            isset($lead['source']) ? $lead['source'] : '',
        ));
    }

    fclose($output);
    exit;
}

function simple_dental_smile_preview_render_admin_notice() {
    $notice = isset($_GET['smile_notice']) ? sanitize_key(wp_unslash($_GET['smile_notice'])) : '';
    if ($notice === 'deleted') {
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Lead deleted.', 'simple-dental') . '</p></div>';
    }
    if ($notice === 'expired_cleared') {
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Expired leads cleared.', 'simple-dental') . '</p></div>';
    }
}

function simple_dental_smile_preview_render_admin_page() {
    if (!current_user_can('manage_options')) {
        wp_die(esc_html__('You do not have permission to view Smile Preview leads.', 'simple-dental'));
    }

    $leads = simple_dental_smile_preview_get_leads();
    $email_settings = function_exists('simple_dental_get_contact_emails') ? simple_dental_get_contact_emails() : array();
    $last_mail = get_option('simple_dental_smile_preview_last_mail_result', array());
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Smile Preview Leads', 'simple-dental'); ?></h1>
        <?php simple_dental_smile_preview_render_admin_notice(); ?>

        <p><?php esc_html_e('Stored leads are limited to the latest 50 submissions and are purged after 30 days.', 'simple-dental'); ?></p>

        <p>
            <a class="button button-primary" href="<?php echo esc_url(wp_nonce_url(simple_dental_smile_preview_admin_url(array('smile_action' => 'export_csv')), 'simple_dental_smile_preview_export_csv')); ?>"><?php esc_html_e('Export CSV', 'simple-dental'); ?></a>
            <a class="button" href="<?php echo esc_url(wp_nonce_url(simple_dental_smile_preview_admin_url(array('smile_action' => 'clear_expired')), 'simple_dental_smile_preview_clear_expired')); ?>"><?php esc_html_e('Clear Expired Leads', 'simple-dental'); ?></a>
        </p>

        <h2><?php esc_html_e('Email Diagnostics', 'simple-dental'); ?></h2>
        <table class="widefat striped" style="max-width: 900px;">
            <tbody>
                <tr><th scope="row"><?php esc_html_e('Notifications', 'simple-dental'); ?></th><td><?php echo !empty($email_settings['notifications_enabled']) ? esc_html__('Enabled', 'simple-dental') : esc_html__('Disabled', 'simple-dental'); ?></td></tr>
                <tr><th scope="row"><?php esc_html_e('Primary recipient', 'simple-dental'); ?></th><td><?php echo esc_html(isset($email_settings['primary']) ? $email_settings['primary'] : ''); ?></td></tr>
                <tr><th scope="row"><?php esc_html_e('CC recipients', 'simple-dental'); ?></th><td><?php echo esc_html(!empty($email_settings['cc']) ? implode(', ', $email_settings['cc']) : '—'); ?></td></tr>
                <tr><th scope="row"><?php esc_html_e('Last Smile Preview email', 'simple-dental'); ?></th><td>
                    <?php
                    if (is_array($last_mail) && !empty($last_mail)) {
                        echo esc_html((!empty($last_mail['sent']) ? 'Sent' : 'Failed') . ' at ' . (isset($last_mail['checked_at']) ? $last_mail['checked_at'] : '') . ' to ' . (isset($last_mail['to']) ? $last_mail['to'] : ''));
                    } else {
                        esc_html_e('No Smile Preview email attempt logged yet.', 'simple-dental');
                    }
                    ?>
                </td></tr>
            </tbody>
        </table>

        <h2><?php esc_html_e('Leads', 'simple-dental'); ?> <span class="count">(<?php echo esc_html((string) count($leads)); ?>)</span></h2>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th><?php esc_html_e('Submitted', 'simple-dental'); ?></th>
                    <th><?php esc_html_e('Name', 'simple-dental'); ?></th>
                    <th><?php esc_html_e('Email', 'simple-dental'); ?></th>
                    <th><?php esc_html_e('Phone', 'simple-dental'); ?></th>
                    <th><?php esc_html_e('Goals', 'simple-dental'); ?></th>
                    <th><?php esc_html_e('Notes', 'simple-dental'); ?></th>
                    <th><?php esc_html_e('UTM', 'simple-dental'); ?></th>
                    <th><?php esc_html_e('Actions', 'simple-dental'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leads)) : ?>
                    <tr><td colspan="8"><?php esc_html_e('No Smile Preview leads captured yet.', 'simple-dental'); ?></td></tr>
                <?php endif; ?>
                <?php foreach ($leads as $index => $lead) : ?>
                    <?php $utm = isset($lead['utm']) && is_array($lead['utm']) ? array_filter($lead['utm']) : array(); ?>
                    <tr>
                        <td><?php echo esc_html(isset($lead['created_at']) ? $lead['created_at'] : ''); ?></td>
                        <td><?php echo esc_html(isset($lead['name']) ? $lead['name'] : ''); ?></td>
                        <td><a href="mailto:<?php echo esc_attr(isset($lead['email']) ? $lead['email'] : ''); ?>"><?php echo esc_html(isset($lead['email']) ? $lead['email'] : ''); ?></a></td>
                        <td><?php echo esc_html(isset($lead['phone']) ? $lead['phone'] : ''); ?></td>
                        <td><?php echo esc_html(isset($lead['goals']) ? $lead['goals'] : ''); ?></td>
                        <td><?php echo esc_html(isset($lead['improvement_notes']) ? $lead['improvement_notes'] : ''); ?></td>
                        <td><?php echo esc_html(!empty($utm) ? implode(' | ', $utm) : '—'); ?></td>
                        <td><a class="button button-small" href="<?php echo esc_url(wp_nonce_url(simple_dental_smile_preview_admin_url(array('smile_action' => 'delete_lead', 'lead' => $index)), 'simple_dental_smile_preview_delete_lead')); ?>" onclick="return confirm('<?php echo esc_js(__('Delete this lead?', 'simple-dental')); ?>');"><?php esc_html_e('Delete', 'simple-dental'); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
