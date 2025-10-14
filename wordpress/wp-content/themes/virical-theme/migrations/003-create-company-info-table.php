<?php
/**
 * Migration: Create Company Info Table
 * 
 * @package Virical
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Check if migration already ran
$migration_name = 'virical_migration_003_company_info';
if (get_option($migration_name)) {
    return;
}

global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

// Create company info table
$table_name = $wpdb->prefix . 'virical_company_info';
$sql = "CREATE TABLE IF NOT EXISTS $table_name (
    id INT(11) NOT NULL AUTO_INCREMENT,
    info_key VARCHAR(100) NOT NULL UNIQUE,
    info_value TEXT,
    info_type VARCHAR(50) DEFAULT 'text',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_key (info_key)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

// Insert default company info
$default_info = array(
    array('info_key' => 'company_name', 'info_value' => 'Virical Lighting', 'info_type' => 'text'),
    array('info_key' => 'tagline', 'info_value' => 'Feeling Light', 'info_type' => 'text'),
    array('info_key' => 'company_description', 'info_value' => 'Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.', 'info_type' => 'text'),
    array('info_key' => 'hotline', 'info_value' => '1900 6888', 'info_type' => 'text'),
    array('info_key' => 'phone', 'info_value' => '024.6656.2688', 'info_type' => 'text'),
    array('info_key' => 'mobile', 'info_value' => '0963.954.969', 'info_type' => 'text'),
    array('info_key' => 'email', 'info_value' => 'info@virical.vn', 'info_type' => 'text'),
    array('info_key' => 'address', 'info_value' => "Số 8 Tôn Thất Thuyết\nMỹ Đình, Nam Từ Liêm\nHà Nội, Việt Nam", 'info_type' => 'text'),
    array('info_key' => 'working_hours', 'info_value' => 'Thứ 2 - Thứ 6: 8:00 - 17:30\nThứ 7: 8:00 - 12:00', 'info_type' => 'text'),
    array('info_key' => 'copyright_text', 'info_value' => '© {year} Virical. All Rights Reserved. | Designed by Virical Team', 'info_type' => 'text'),
    array('info_key' => 'google_maps_url', 'info_value' => 'https://maps.google.com/?q=Số+8+Tôn+Thất+Thuyết+Hà+Nội', 'info_type' => 'text'),
    array('info_key' => 'facebook', 'info_value' => 'https://www.facebook.com/virical', 'info_type' => 'text'),
    array('info_key' => 'youtube', 'info_value' => 'https://www.youtube.com/virical', 'info_type' => 'text'),
    array('info_key' => 'zalo', 'info_value' => 'https://zalo.me/virical', 'info_type' => 'text'),
    array('info_key' => 'instagram', 'info_value' => 'https://www.instagram.com/virical', 'info_type' => 'text'),
    array('info_key' => 'linkedin', 'info_value' => 'https://www.linkedin.com/company/virical', 'info_type' => 'text')
);

foreach ($default_info as $info) {
    $wpdb->insert($table_name, $info, array('%s', '%s', '%s'));
}

// Create footer menu items table
$footer_menu_table = $wpdb->prefix . 'virical_footer_menu';
$sql2 = "CREATE TABLE IF NOT EXISTS $footer_menu_table (
    id INT(11) NOT NULL AUTO_INCREMENT,
    menu_section VARCHAR(50) NOT NULL,
    menu_title VARCHAR(100) NOT NULL,
    menu_url VARCHAR(255) NOT NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_section (menu_section),
    KEY idx_active (is_active),
    KEY idx_order (sort_order)
) $charset_collate;";

dbDelta($sql2);

// Insert footer menu items
$footer_menus = array(
    // Products Section
    array('menu_section' => 'products', 'menu_title' => 'Đèn Indoor', 'menu_url' => '/indoor/', 'sort_order' => 1),
    array('menu_section' => 'products', 'menu_title' => 'Đèn Outdoor', 'menu_url' => '/outdoor/', 'sort_order' => 2),
    array('menu_section' => 'products', 'menu_title' => 'Đèn Downlight', 'menu_url' => '/san-pham/downlight/', 'sort_order' => 3),
    array('menu_section' => 'products', 'menu_title' => 'Đèn Spotlight', 'menu_url' => '/san-pham/spotlight/', 'sort_order' => 4),
    array('menu_section' => 'products', 'menu_title' => 'Đèn Ray Nam Châm', 'menu_url' => '/san-pham/ray-nam-cham/', 'sort_order' => 5),
    
    // Information Section
    array('menu_section' => 'info', 'menu_title' => 'Về Chúng Tôi', 'menu_url' => '/gioi-thieu/', 'sort_order' => 1),
    array('menu_section' => 'info', 'menu_title' => 'Công Trình', 'menu_url' => '/cong-trinh/', 'sort_order' => 2),
    array('menu_section' => 'info', 'menu_title' => 'Catalogue', 'menu_url' => '/catalogue/', 'sort_order' => 3),
    array('menu_section' => 'info', 'menu_title' => 'Chính Sách Bảo Hành', 'menu_url' => '/chinh-sach-bao-hanh/', 'sort_order' => 4),
    array('menu_section' => 'info', 'menu_title' => 'Liên Hệ', 'menu_url' => '/lien-he/', 'sort_order' => 5)
);

foreach ($footer_menus as $menu) {
    $wpdb->insert($footer_menu_table, $menu);
}

// Mark migration as complete
update_option($migration_name, date('Y-m-d H:i:s'));

echo "Migration 003: Company Info table created successfully!\n";