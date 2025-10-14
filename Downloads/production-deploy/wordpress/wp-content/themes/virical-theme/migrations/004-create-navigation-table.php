<?php
/**
 * Migration: Create Navigation Menus Table
 * 
 * This migration creates the wp_virical_navigation_menus table
 * for storing navigation menu items in the database.
 * 
 * @package Virical
 * @version 1.0.0
 * @date 2025-09-10
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create the navigation menus table
 */
function virical_migration_004_create_navigation_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'virical_navigation_menus';
    $charset_collate = $wpdb->get_charset_collate();
    
    // Check if table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
        return array(
            'status' => 'skipped',
            'message' => "Table $table_name already exists"
        );
    }
    
    // Create table SQL
    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        menu_location VARCHAR(100) NOT NULL,
        parent_id INT DEFAULT NULL,
        item_title VARCHAR(200) NOT NULL,
        item_url VARCHAR(500) NOT NULL,
        item_target VARCHAR(20) DEFAULT '_self',
        item_classes VARCHAR(200) DEFAULT NULL,
        item_icon VARCHAR(100) DEFAULT NULL,
        item_description TEXT,
        is_active BOOLEAN DEFAULT TRUE,
        sort_order INT DEFAULT 0,
        meta_data JSON,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        KEY idx_location (menu_location),
        KEY idx_parent (parent_id),
        KEY idx_active (is_active),
        KEY idx_order (sort_order),
        FOREIGN KEY (parent_id) REFERENCES {$wpdb->prefix}virical_navigation_menus(id) ON DELETE CASCADE
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Verify table was created
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        return array(
            'status' => 'error',
            'message' => "Failed to create table $table_name"
        );
    }
    
    // Insert default navigation items
    $default_menus = array(
        // Primary navigation
        array(
            'menu_location' => 'primary',
            'item_title' => 'Trang chủ',
            'item_url' => '/',
            'sort_order' => 1,
            'is_active' => 1
        ),
        array(
            'menu_location' => 'primary',
            'item_title' => 'Giới thiệu',
            'item_url' => '/gioi-thieu/',
            'sort_order' => 2,
            'is_active' => 1
        ),
        array(
            'menu_location' => 'primary',
            'item_title' => 'Sản phẩm',
            'item_url' => '/san-pham/',
            'sort_order' => 3,
            'is_active' => 1
        ),
        array(
            'menu_location' => 'primary',
            'item_title' => 'Công trình',
            'item_url' => '/cong-trinh/',
            'sort_order' => 4,
            'is_active' => 1
        ),
        array(
            'menu_location' => 'primary',
            'item_title' => 'Liên hệ',
            'item_url' => '/lien-he/',
            'sort_order' => 5,
            'is_active' => 1
        ),
        // Footer navigation
        array(
            'menu_location' => 'footer',
            'item_title' => 'Chính sách bảo mật',
            'item_url' => '/chinh-sach-bao-mat/',
            'sort_order' => 1,
            'is_active' => 1
        ),
        array(
            'menu_location' => 'footer',
            'item_title' => 'Điều khoản sử dụng',
            'item_url' => '/dieu-khoan-su-dung/',
            'sort_order' => 2,
            'is_active' => 1
        ),
        array(
            'menu_location' => 'footer',
            'item_title' => 'Hỗ trợ',
            'item_url' => '/ho-tro/',
            'sort_order' => 3,
            'is_active' => 1
        )
    );
    
    // Insert default menus
    foreach ($default_menus as $menu) {
        $menu['meta_data'] = json_encode(array(
            'version' => '1.0.0',
            'source' => 'migration_004'
        ));
        $wpdb->insert($table_name, $menu);
    }
    
    // Update migration status
    update_option('virical_migration_004_status', 'completed');
    update_option('virical_migration_004_date', current_time('mysql'));
    
    return array(
        'status' => 'success',
        'message' => "Successfully created table $table_name with default navigation items"
    );
}

/**
 * Check if migration has already run
 */
function virical_migration_004_should_run() {
    $status = get_option('virical_migration_004_status');
    return $status !== 'completed';
}

/**
 * Execute migration
 */
function virical_migration_004_execute() {
    if (!virical_migration_004_should_run()) {
        return array(
            'status' => 'skipped',
            'message' => 'Migration 004 has already been completed'
        );
    }
    
    return virical_migration_004_create_navigation_table();
}

// Run migration if called directly via WP-CLI
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('virical migrate:004', function() {
        $result = virical_migration_004_execute();
        
        if ($result['status'] === 'success') {
            WP_CLI::success($result['message']);
        } elseif ($result['status'] === 'skipped') {
            WP_CLI::warning($result['message']);
        } else {
            WP_CLI::error($result['message']);
        }
    });
}

// Auto-run migration on admin_init if migration 003 is complete
add_action('admin_init', function() {
    // Check if migration 003 is complete
    $migration_003_status = get_option('virical_migration_003_status');
    
    if ($migration_003_status === 'completed' && virical_migration_004_should_run()) {
        virical_migration_004_execute();
    }
});