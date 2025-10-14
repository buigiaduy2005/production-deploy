<?php
/**
 * Migration: Create Routing Rules Table
 * 
 * This migration creates the wp_virical_routing_rules table
 * for storing URL routing rules in the database.
 * 
 * @package Virical
 * @version 1.0.0
 * @date 2025-09-10
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create the routing rules table
 */
function virical_migration_005_create_routing_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'virical_routing_rules';
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
        rule_name VARCHAR(100) UNIQUE NOT NULL,
        pattern VARCHAR(500) NOT NULL,
        rewrite VARCHAR(500) NOT NULL,
        redirect_type VARCHAR(10) DEFAULT NULL,
        rule_type ENUM('rewrite', 'redirect', 'custom') DEFAULT 'rewrite',
        priority INT DEFAULT 10,
        is_active BOOLEAN DEFAULT TRUE,
        conditions JSON,
        meta_data JSON,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        KEY idx_active (is_active),
        KEY idx_priority (priority),
        KEY idx_type (rule_type)
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
    
    // Insert default routing rules (from functions.php lines 350-357)
    $default_rules = array(
        array(
            'rule_name' => 'single_product',
            'pattern' => '^san-pham/([^/]+)/?$',
            'rewrite' => 'index.php?product=$matches[1]',
            'rule_type' => 'rewrite',
            'priority' => 1,
            'is_active' => 1,
            'meta_data' => json_encode(array(
                'description' => 'Single product page URL',
                'query_var' => 'product'
            ))
        ),
        array(
            'rule_name' => 'single_project',
            'pattern' => '^cong-trinh/([^/]+)/?$',
            'rewrite' => 'index.php?project=$matches[1]',
            'rule_type' => 'rewrite',
            'priority' => 2,
            'is_active' => 1,
            'meta_data' => json_encode(array(
                'description' => 'Single project page URL',
                'query_var' => 'project'
            ))
        ),
        array(
            'rule_name' => 'product_category',
            'pattern' => '^product-category/([^/]+)/?$',
            'rewrite' => 'index.php?category=$matches[1]',
            'rule_type' => 'rewrite',
            'priority' => 3,
            'is_active' => 1,
            'meta_data' => json_encode(array(
                'description' => 'Product category page URL',
                'query_var' => 'category'
            ))
        ),
        array(
            'rule_name' => 'products_page',
            'pattern' => '^san-pham/?$',
            'rewrite' => 'index.php?pagename=san-pham',
            'rule_type' => 'rewrite',
            'priority' => 4,
            'is_active' => 1,
            'meta_data' => json_encode(array(
                'description' => 'Products archive page'
            ))
        ),
        array(
            'rule_name' => 'projects_page',
            'pattern' => '^cong-trinh/?$',
            'rewrite' => 'index.php?pagename=cong-trinh',
            'rule_type' => 'rewrite',
            'priority' => 5,
            'is_active' => 1,
            'meta_data' => json_encode(array(
                'description' => 'Projects archive page'
            ))
        ),
        // Redirects from old URLs
        array(
            'rule_name' => 'old_products_redirect',
            'pattern' => '^products/?$',
            'rewrite' => '/san-pham/',
            'redirect_type' => '301',
            'rule_type' => 'redirect',
            'priority' => 10,
            'is_active' => 1,
            'meta_data' => json_encode(array(
                'description' => 'Redirect old products URL to new URL'
            ))
        ),
        array(
            'rule_name' => 'old_projects_redirect',
            'pattern' => '^projects/?$',
            'rewrite' => '/cong-trinh/',
            'redirect_type' => '301',
            'rule_type' => 'redirect',
            'priority' => 11,
            'is_active' => 1,
            'meta_data' => json_encode(array(
                'description' => 'Redirect old projects URL to new URL'
            ))
        )
    );
    
    // Insert routing rules
    foreach ($default_rules as $rule) {
        $wpdb->insert($table_name, $rule);
    }
    
    // Update migration status
    update_option('virical_migration_005_status', 'completed');
    update_option('virical_migration_005_date', current_time('mysql'));
    
    return array(
        'status' => 'success',
        'message' => "Successfully created table $table_name with default routing rules"
    );
}

/**
 * Check if migration has already run
 */
function virical_migration_005_should_run() {
    $status = get_option('virical_migration_005_status');
    return $status !== 'completed';
}

/**
 * Execute migration
 */
function virical_migration_005_execute() {
    if (!virical_migration_005_should_run()) {
        return array(
            'status' => 'skipped',
            'message' => 'Migration 005 has already been completed'
        );
    }
    
    return virical_migration_005_create_routing_table();
}

// Run migration if called directly via WP-CLI
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('virical migrate:005', function() {
        $result = virical_migration_005_execute();
        
        if ($result['status'] === 'success') {
            WP_CLI::success($result['message']);
        } elseif ($result['status'] === 'skipped') {
            WP_CLI::warning($result['message']);
        } else {
            WP_CLI::error($result['message']);
        }
    });
}

// Auto-run migration on admin_init if migration 004 is complete
add_action('admin_init', function() {
    // Check if migration 004 is complete
    $migration_004_status = get_option('virical_migration_004_status');
    
    if ($migration_004_status === 'completed' && virical_migration_005_should_run()) {
        virical_migration_005_execute();
    }
});