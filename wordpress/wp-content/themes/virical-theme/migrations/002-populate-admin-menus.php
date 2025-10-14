<?php
/**
 * Migration: Populate Admin Menus
 * 
 * This migration populates the wp_virical_admin_menus table
 * with initial admin menu data.
 * 
 * @package Virical
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Run the migration
 */
function virical_migration_002_populate_admin_menus() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'virical_admin_menus';
    
    // Check if table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        return array(
            'status' => 'error',
            'message' => "Table $table_name does not exist. Please run migration 001 first."
        );
    }
    
    // Check if menus already exist
    $existing = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    if ($existing > 0) {
        return array(
            'status' => 'skipped',
            'message' => "Admin menus already populated. Found $existing existing menus."
        );
    }
    
    // Define menu data
    $menus = array(
        // Main Products Menu
        array(
            'menu_slug' => 'virical-products',
            'parent_slug' => null,
            'menu_title' => 'Sản phẩm Virical',
            'page_title' => 'Quản lý Sản phẩm',
            'capability' => 'manage_options',
            'icon' => 'dashicons-cart',
            'position' => 30,
            'callback_function' => 'virical_products_page',
            'is_active' => 1,
            'sort_order' => 1
        ),
        // Products Submenu - Categories
        array(
            'menu_slug' => 'virical-categories',
            'parent_slug' => 'virical-products',
            'menu_title' => 'Danh mục',
            'page_title' => 'Danh mục sản phẩm',
            'capability' => 'manage_options',
            'icon' => null,
            'position' => null,
            'callback_function' => 'virical_categories_page',
            'is_active' => 1,
            'sort_order' => 2
        ),
        // Products Submenu - Add New
        array(
            'menu_slug' => 'virical-add-product',
            'parent_slug' => 'virical-products',
            'menu_title' => 'Thêm mới',
            'page_title' => 'Thêm sản phẩm mới',
            'capability' => 'manage_options',
            'icon' => null,
            'position' => null,
            'callback_function' => 'virical_add_product_page',
            'is_active' => 1,
            'sort_order' => 3
        ),
        // Main Projects Menu
        array(
            'menu_slug' => 'virical-projects',
            'parent_slug' => null,
            'menu_title' => 'Công trình Virical',
            'page_title' => 'Quản lý Công trình',
            'capability' => 'manage_options',
            'icon' => 'dashicons-building',
            'position' => 31,
            'callback_function' => 'virical_projects_admin_page',
            'is_active' => 1,
            'sort_order' => 4
        ),
        // Projects Submenu - Project Types
        array(
            'menu_slug' => 'virical-project-types',
            'parent_slug' => 'virical-projects',
            'menu_title' => 'Loại công trình',
            'page_title' => 'Loại công trình',
            'capability' => 'manage_options',
            'icon' => null,
            'position' => null,
            'callback_function' => 'virical_project_types_page',
            'is_active' => 1,
            'sort_order' => 5
        ),
        // Projects Submenu - Add New
        array(
            'menu_slug' => 'virical-add-project',
            'parent_slug' => 'virical-projects',
            'menu_title' => 'Thêm mới',
            'page_title' => 'Thêm công trình mới',
            'capability' => 'manage_options',
            'icon' => null,
            'position' => null,
            'callback_function' => 'virical_add_project_page',
            'is_active' => 1,
            'sort_order' => 6
        ),
        // About Page Menu
        array(
            'menu_slug' => 'virical-about',
            'parent_slug' => null,
            'menu_title' => 'About Page',
            'page_title' => 'About Page Settings',
            'capability' => 'manage_options',
            'icon' => 'dashicons-info',
            'position' => 32,
            'callback_function' => 'virical_about_page_admin',
            'is_active' => 1,
            'sort_order' => 7
        ),
        // Contact Page Menu
        array(
            'menu_slug' => 'virical-contact',
            'parent_slug' => null,
            'menu_title' => 'Contact Page',
            'page_title' => 'Contact Page Settings',
            'capability' => 'manage_options',
            'icon' => 'dashicons-email',
            'position' => 33,
            'callback_function' => 'virical_contact_page_admin',
            'is_active' => 1,
            'sort_order' => 8
        ),
        // Homepage Settings Menu
        array(
            'menu_slug' => 'virical-homepage',
            'parent_slug' => null,
            'menu_title' => 'Homepage Settings',
            'page_title' => 'Homepage Configuration',
            'capability' => 'manage_options',
            'icon' => 'dashicons-admin-home',
            'position' => 34,
            'callback_function' => 'virical_homepage_settings',
            'is_active' => 1,
            'sort_order' => 9
        ),
        // Main Settings Menu
        array(
            'menu_slug' => 'virical-settings',
            'parent_slug' => null,
            'menu_title' => 'Cài đặt Virical',
            'page_title' => 'Cài đặt hệ thống',
            'capability' => 'manage_options',
            'icon' => 'dashicons-admin-settings',
            'position' => 99,
            'callback_function' => 'virical_settings_page',
            'is_active' => 1,
            'sort_order' => 10
        ),
        // Settings Submenu - General
        array(
            'menu_slug' => 'virical-general-settings',
            'parent_slug' => 'virical-settings',
            'menu_title' => 'Cài đặt chung',
            'page_title' => 'Cài đặt chung',
            'capability' => 'manage_options',
            'icon' => null,
            'position' => null,
            'callback_function' => 'virical_general_settings_page',
            'is_active' => 1,
            'sort_order' => 11
        ),
        // Settings Submenu - SEO
        array(
            'menu_slug' => 'virical-seo-settings',
            'parent_slug' => 'virical-settings',
            'menu_title' => 'SEO Settings',
            'page_title' => 'SEO Configuration',
            'capability' => 'manage_options',
            'icon' => null,
            'position' => null,
            'callback_function' => 'virical_seo_settings_page',
            'is_active' => 1,
            'sort_order' => 12
        ),
        // Settings Submenu - Cache
        array(
            'menu_slug' => 'virical-cache-settings',
            'parent_slug' => 'virical-settings',
            'menu_title' => 'Cache Settings',
            'page_title' => 'Cache Configuration',
            'capability' => 'manage_options',
            'icon' => null,
            'position' => null,
            'callback_function' => 'virical_cache_settings_page',
            'is_active' => 1,
            'sort_order' => 13
        )
    );
    
    // Insert menus
    $inserted = 0;
    $errors = array();
    
    foreach ($menus as $menu) {
        // Add meta_data as JSON
        $menu['meta_data'] = json_encode(array(
            'version' => '1.0.0',
            'source' => 'migration_002',
            'created_by' => 'system'
        ));
        
        $result = $wpdb->insert($table_name, $menu);
        
        if ($result === false) {
            $errors[] = "Failed to insert menu: {$menu['menu_slug']} - {$wpdb->last_error}";
        } else {
            $inserted++;
        }
    }
    
    // Update migration status
    if ($inserted > 0) {
        update_option('virical_migration_002_status', 'completed');
        update_option('virical_migration_002_date', current_time('mysql'));
        update_option('virical_migration_002_inserted', $inserted);
    }
    
    if (!empty($errors)) {
        return array(
            'status' => 'partial',
            'message' => "Inserted $inserted menus with " . count($errors) . " errors",
            'errors' => $errors
        );
    }
    
    return array(
        'status' => 'success',
        'message' => "Successfully inserted $inserted admin menus"
    );
}

/**
 * Check if migration has already run
 */
function virical_migration_002_should_run() {
    $status = get_option('virical_migration_002_status');
    return $status !== 'completed';
}

/**
 * Execute migration
 */
function virical_migration_002_execute() {
    if (!virical_migration_002_should_run()) {
        return array(
            'status' => 'skipped',
            'message' => 'Migration 002 has already been completed'
        );
    }
    
    return virical_migration_002_populate_admin_menus();
}

// Run migration if called directly via WP-CLI
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('virical migrate:002', function() {
        $result = virical_migration_002_execute();
        
        if ($result['status'] === 'success') {
            WP_CLI::success($result['message']);
        } elseif ($result['status'] === 'skipped') {
            WP_CLI::warning($result['message']);
        } elseif ($result['status'] === 'partial') {
            WP_CLI::warning($result['message']);
            foreach ($result['errors'] as $error) {
                WP_CLI::line("  - $error");
            }
        } else {
            WP_CLI::error($result['message']);
        }
    });
}

// Auto-run migration on admin_init if migration 001 is complete
add_action('admin_init', function() {
    // Check if migration 001 is complete
    $migration_001_status = get_option('virical_migration_001_status');
    
    if ($migration_001_status === 'completed' && virical_migration_002_should_run()) {
        virical_migration_002_execute();
    }
});