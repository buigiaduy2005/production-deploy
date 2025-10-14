<?php
/**
 * Migration: Create Page Templates Table
 * 
 * This migration creates the wp_virical_page_templates table
 * for storing page templates in the database.
 * 
 * @package Virical
 * @version 1.0.0
 * @date 2025-09-10
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create the page templates table
 */
function virical_migration_003_create_templates_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'virical_page_templates';
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
        template_name VARCHAR(100) UNIQUE NOT NULL,
        template_title VARCHAR(200) NOT NULL,
        template_type ENUM('page', 'post', 'archive', 'single') DEFAULT 'page',
        template_content LONGTEXT,
        template_settings JSON,
        sections JSON,
        css_content TEXT,
        js_content TEXT,
        is_active BOOLEAN DEFAULT TRUE,
        version VARCHAR(20) DEFAULT '1.0.0',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        KEY idx_type (template_type),
        KEY idx_active (is_active),
        KEY idx_name (template_name)
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
    
    // Update migration status
    update_option('virical_migration_003_status', 'completed');
    update_option('virical_migration_003_date', current_time('mysql'));
    
    return array(
        'status' => 'success',
        'message' => "Successfully created table $table_name"
    );
}

/**
 * Check if migration has already run
 */
function virical_migration_003_should_run() {
    $status = get_option('virical_migration_003_status');
    return $status !== 'completed';
}

/**
 * Execute migration
 */
function virical_migration_003_execute() {
    if (!virical_migration_003_should_run()) {
        return array(
            'status' => 'skipped',
            'message' => 'Migration 003 has already been completed'
        );
    }
    
    return virical_migration_003_create_templates_table();
}

// Run migration if called directly via WP-CLI
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('virical migrate:003', function() {
        $result = virical_migration_003_execute();
        
        if ($result['status'] === 'success') {
            WP_CLI::success($result['message']);
        } elseif ($result['status'] === 'skipped') {
            WP_CLI::warning($result['message']);
        } else {
            WP_CLI::error($result['message']);
        }
    });
}

// Auto-run migration on admin_init if migration 002 is complete
add_action('admin_init', function() {
    // Check if migration 002 is complete
    $migration_002_status = get_option('virical_migration_002_status');
    
    if ($migration_002_status === 'completed' && virical_migration_003_should_run()) {
        virical_migration_003_execute();
    }
});