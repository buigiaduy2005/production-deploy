<?php
/**
 * Plugin Name: Virical Contact Manager
 * Description: Manages customer contact submissions from frontend forms.
 * Version: 1.0
 * Author: Gemini
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly.

// Create the custom database table on plugin activation
function virical_contact_manager_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_contacts';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) DEFAULT '' NOT NULL,
        email varchar(100) DEFAULT '' NOT NULL,
        phone varchar(20) DEFAULT '' NOT NULL,
        subject varchar(255) DEFAULT '' NOT NULL,
        message longtext NOT NULL,
        source varchar(50) NOT NULL,
        submitted_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'virical_contact_manager_activate');

// Add the admin menu page
function virical_contacts_admin_menu() {
    add_menu_page(
        'Liên hệ Khách hàng',
        'Liên hệ KH',
        'manage_options',
        'virical-contacts',
        'virical_contacts_admin_page_html',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'virical_contacts_admin_menu');

// Render the admin page
function virical_contacts_admin_page_html() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_contacts';
    $contacts = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submitted_at DESC");
    ?>
    <div class="wrap">
        <h1>Danh sách Liên hệ từ Khách hàng</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Tên</th>
                    <th style="width: 15%;">Email</th>
                    <th style="width: 10%;">Số điện thoại</th>
                    <th>Nội dung</th>
                    <th style="width: 10%;">Nguồn</th>
                    <th style="width: 15%;">Ngày gửi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($contacts) : ?>
                    <?php foreach ($contacts as $contact) : ?>
                        <tr>
                            <td><?php echo $contact->id; ?></td>
                            <td><?php echo esc_html($contact->name); ?></td>
                            <td><?php echo esc_html($contact->email); ?></td>
                            <td><?php echo esc_html($contact->phone); ?></td>
                            <td><?php echo esc_html($contact->message); ?></td>
                            <td><?php echo esc_html($contact->source); ?></td>
                            <td><?php echo $contact->submitted_at; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">Chưa có thông tin liên hệ nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// AJAX handler for the form submission
function virical_handle_contact_submission() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_contacts';

    // Nonce check can be added for extra security if the form is for logged-in users
    
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $source = isset($_POST['source']) ? sanitize_text_field($_POST['source']) : 'Unknown';

    // Simple validation
    if (empty($phone) && empty($email)) {
        wp_send_json_error('Vui lòng cung cấp số điện thoại hoặc email.');
        return;
    }

    $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'source'  => $source,
            'submitted_at' => current_time('mysql'),
        )
    );

    wp_send_json_success('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.');
}
add_action('wp_ajax_nopriv_virical_contact_form', 'virical_handle_contact_submission');
add_action('wp_ajax_virical_contact_form', 'virical_handle_contact_submission');

/**
 * Save Contact Form 7 submissions to the custom database table.
 * Hooks into 'wpcf7_mail_sent' which runs after successful submission and email sending.
 */
function virical_save_cf7_submission_to_db($contact_form) {
    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $posted_data = $submission->get_posted_data();
        
        // --- Map your Contact Form 7 field names to your database columns ---
        // Assumes default CF7 field names. Change if your form uses different names.
        $name = isset($posted_data['your-name']) ? sanitize_text_field($posted_data['your-name']) : '';
        $email = isset($posted_data['your-email']) ? sanitize_email($posted_data['your-email']) : '';
        $phone = isset($posted_data['your-phone']) ? sanitize_text_field($posted_data['your-phone']) : ''; 
        $subject = isset($posted_data['your-subject']) ? sanitize_text_field($posted_data['your-subject']) : 'Hỗ trợ từ trang Liên hệ';
        $message = isset($posted_data['your-message']) ? sanitize_textarea_field($posted_data['your-message']) : '';
        
        // Don't save if both email and phone are empty
        if (empty($email) && empty($phone)) {
            return;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'virical_contacts';

        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $message,
                'source'  => 'Contact Form 7',
                'submitted_at' => current_time('mysql'),
            )
        );
    }
}
add_action('wpcf7_mail_sent', 'virical_save_cf7_submission_to_db', 20, 1);
