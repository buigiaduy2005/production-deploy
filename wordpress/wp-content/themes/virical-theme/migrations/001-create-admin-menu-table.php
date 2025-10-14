<?php
/**
 * Migration 001: Create Admin Menu Table
 * 
 * This migration creates the wp_virical_admin_menus table and migrates existing menu data
 * Reference: GiaiPhap Section 3.1 Lines 174-194 & todos.md Task 2.1-2.2
 * 
 * @package Virical
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ViricalAdminMenuMigration {
    
    private $wpdb;
    private $table_name;
    private $errors = [];
    private $success = [];
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'virical_admin_menus';
    }
    
    /**
     * Run the migration
     */
    public function run() {
        echo "<h2>Admin Menu Table Migration</h2>";
        
        // Step 1: Create table
        echo "<h3>Step 1: Creating Admin Menu Table...</h3>";
        $this->create_admin_menu_table();
        
        // Step 2: Migrate existing menus
        echo "<h3>Step 2: Migrating Existing Menus...</h3>";
        $this->migrate_existing_menus();
        
        // Step 3: Verify migration
        echo "<h3>Step 3: Verifying Migration...</h3>";
        $this->verify_migration();
        
        // Show summary
        $this->show_summary();
    }
    
    /**
     * Create the admin menu table
     * Reference: GiaiPhap Section 3.1 Lines 176-194
     */
    private function create_admin_menu_table() {
        $charset_collate = $this->wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            menu_slug VARCHAR(100) UNIQUE NOT NULL,
            parent_slug VARCHAR(100) DEFAULT NULL,
            menu_title VARCHAR(200) NOT NULL,
            page_title VARCHAR(200) NOT NULL,
            capability VARCHAR(100) DEFAULT 'manage_options',
            icon VARCHAR(100) DEFAULT NULL,
            position INT DEFAULT NULL,
            callback_function VARCHAR(200),
            is_active BOOLEAN DEFAULT TRUE,
            sort_order INT DEFAULT 0,
            meta_data JSON,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            KEY idx_parent (parent_slug),
            KEY idx_active (is_active),
            KEY idx_order (sort_order)
        ) {$charset_collate}";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $result = dbDelta($sql);
        
        // Check if table was created
        $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'");
        
        if ($table_exists) {
            $this->success[] = "✓ Admin menu table created successfully";
            echo "<p style='color: green;'>✓ Table {$this->table_name} created successfully</p>";
        } else {
            $this->errors[] = "Failed to create admin menu table";
            echo "<p style='color: red;'>✗ Failed to create table {$this->table_name}</p>";
        }
    }
    
    /**
     * Migrate existing hardcoded menus to database
     * Reference: todos.md Lines 241-251
     */
    private function migrate_existing_menus() {
        // Check if menus already migrated
        $existing_count = $this->wpdb->get_var("SELECT COUNT(*) FROM {$this->table_name}");
        
        if ($existing_count > 0) {
            echo "<p>⚠ Admin menus already exist ({$existing_count} menus). Skipping migration.</p>";
            return;
        }
        
        // Define menus to migrate based on existing admin pages
        $menus_to_migrate = [
            // Main Products Menu
            [
                'menu_slug' => 'virical-products',
                'parent_slug' => null,
                'menu_title' => 'Sản phẩm Virical',
                'page_title' => 'Quản lý Sản phẩm',
                'capability' => 'manage_options',
                'icon' => 'dashicons-cart',
                'position' => 30,
                'callback_function' => 'virical_products_page',
                'is_active' => 1,
                'sort_order' => 1,
                'meta_data' => json_encode([
                    'description' => 'Quản lý sản phẩm Virical',
                    'help_text' => 'Thêm, sửa, xóa sản phẩm',
                    'original_file' => 'products-admin.php'
                ])
            ],
            // Products Submenu - Categories
            [
                'menu_slug' => 'virical-categories',
                'parent_slug' => 'virical-products',
                'menu_title' => 'Danh mục',
                'page_title' => 'Danh mục sản phẩm',
                'capability' => 'manage_options',
                'icon' => null,
                'position' => null,
                'callback_function' => 'virical_categories_page',
                'is_active' => 1,
                'sort_order' => 1,
                'meta_data' => json_encode([
                    'description' => 'Quản lý danh mục sản phẩm'
                ])
            ],
            // Main Projects Menu
            [
                'menu_slug' => 'virical-projects',
                'parent_slug' => null,
                'menu_title' => 'Công trình Virical',
                'page_title' => 'Quản lý Công trình',
                'capability' => 'manage_options',
                'icon' => 'dashicons-building',
                'position' => 31,
                'callback_function' => 'virical_projects_admin_page',
                'is_active' => 1,
                'sort_order' => 2,
                'meta_data' => json_encode([
                    'description' => 'Quản lý công trình',
                    'original_file' => 'projects-admin.php'
                ])
            ],
            // Projects Submenu - Project Types
            [
                'menu_slug' => 'virical-project-types',
                'parent_slug' => 'virical-projects',
                'menu_title' => 'Loại công trình',
                'page_title' => 'Loại công trình',
                'capability' => 'manage_options',
                'icon' => null,
                'position' => null,
                'callback_function' => 'virical_project_types_page',
                'is_active' => 1,
                'sort_order' => 1,
                'meta_data' => json_encode([
                    'description' => 'Quản lý loại công trình'
                ])
            ],
            // About Page Menu
            [
                'menu_slug' => 'virical-about',
                'parent_slug' => null,
                'menu_title' => 'About Page',
                'page_title' => 'About Page Settings',
                'capability' => 'manage_options',
                'icon' => 'dashicons-info',
                'position' => 32,
                'callback_function' => 'aura_about_page_admin_page',
                'is_active' => 1,
                'sort_order' => 3,
                'meta_data' => json_encode([
                    'description' => 'Quản lý trang About',
                    'original_file' => 'about-page-admin.php'
                ])
            ],
            // Settings Menu
            [
                'menu_slug' => 'virical-settings',
                'parent_slug' => null,
                'menu_title' => 'Cài đặt Virical',
                'page_title' => 'Cài đặt hệ thống',
                'capability' => 'manage_options',
                'icon' => 'dashicons-admin-settings',
                'position' => 99,
                'callback_function' => 'virical_settings_page',
                'is_active' => 1,
                'sort_order' => 10,
                'meta_data' => json_encode([
                    'description' => 'Cài đặt chung cho hệ thống Virical'
                ])
            ],
            // Settings Submenu - Company Settings
            [
                'menu_slug' => 'virical-company-settings',
                'parent_slug' => 'virical-settings',
                'menu_title' => 'Company Info',
                'page_title' => 'Company Settings',
                'capability' => 'manage_options',
                'icon' => null,
                'position' => null,
                'callback_function' => 'virical_company_settings_page',
                'is_active' => 1,
                'sort_order' => 1,
                'meta_data' => json_encode([
                    'description' => 'Thông tin công ty',
                    'original_file' => 'company-settings.php'
                ])
            ],
            // Settings Submenu - Footer Menu
            [
                'menu_slug' => 'virical-footer-menu',
                'parent_slug' => 'virical-settings',
                'menu_title' => 'Footer Menu',
                'page_title' => 'Footer Menu Settings',
                'capability' => 'manage_options',
                'icon' => null,
                'position' => null,
                'callback_function' => 'virical_footer_menu_settings_page',
                'is_active' => 1,
                'sort_order' => 2,
                'meta_data' => json_encode([
                    'description' => 'Cài đặt menu footer',
                    'original_file' => 'footer-menu-settings.php'
                ])
            ],
            // Settings Submenu - Product Settings
            [
                'menu_slug' => 'virical-product-settings',
                'parent_slug' => 'virical-settings',
                'menu_title' => 'Product Settings',
                'page_title' => 'Product Page Settings',
                'capability' => 'manage_options',
                'icon' => null,
                'position' => null,
                'callback_function' => 'virical_product_settings_page',
                'is_active' => 1,
                'sort_order' => 3,
                'meta_data' => json_encode([
                    'description' => 'Cài đặt trang sản phẩm',
                    'original_file' => 'product-settings.php'
                ])
            ],
            // Migration Tools Menu
            [
                'menu_slug' => 'virical-migration',
                'parent_slug' => 'virical-settings',
                'menu_title' => 'Migration Tools',
                'page_title' => 'Migration Tools',
                'capability' => 'manage_options',
                'icon' => null,
                'position' => null,
                'callback_function' => 'virical_migration_admin_page',
                'is_active' => 1,
                'sort_order' => 10,
                'meta_data' => json_encode([
                    'description' => 'Công cụ migration dữ liệu',
                    'original_file' => 'migrate-aura-to-virical.php'
                ])
            ],
            // Week 1 Migration
            [
                'menu_slug' => 'virical-week1-migration',
                'parent_slug' => 'virical-migration',
                'menu_title' => 'Week 1 Migration',
                'page_title' => 'Week 1: Quick Fixes',
                'capability' => 'manage_options',
                'icon' => null,
                'position' => null,
                'callback_function' => 'virical_week1_migration_page',
                'is_active' => 1,
                'sort_order' => 1,
                'meta_data' => json_encode([
                    'description' => 'Week 1 migration tasks',
                    'original_file' => 'migrations/week1-quick-fixes.php'
                ])
            ]
        ];
        
        $migrated_count = 0;
        
        foreach ($menus_to_migrate as $menu) {
            // Check if menu already exists
            $exists = $this->wpdb->get_var($this->wpdb->prepare(
                "SELECT id FROM {$this->table_name} WHERE menu_slug = %s",
                $menu['menu_slug']
            ));
            
            if (!$exists) {
                $result = $this->wpdb->insert(
                    $this->table_name,
                    $menu,
                    [
                        '%s', '%s', '%s', '%s', '%s', 
                        '%s', '%d', '%s', '%d', '%d', '%s'
                    ]
                );
                
                if ($result) {
                    $migrated_count++;
                    echo "<p style='color: green;'>✓ Migrated menu: {$menu['menu_title']}</p>";
                } else {
                    $this->errors[] = "Failed to migrate menu: {$menu['menu_title']} - " . $this->wpdb->last_error;
                    echo "<p style='color: red;'>✗ Failed to migrate: {$menu['menu_title']}</p>";
                }
            }
        }
        
        if ($migrated_count > 0) {
            $this->success[] = "✓ Migrated {$migrated_count} admin menus";
        }
    }
    
    /**
     * Verify the migration was successful
     */
    private function verify_migration() {
        // Count total menus
        $total_menus = $this->wpdb->get_var("SELECT COUNT(*) FROM {$this->table_name}");
        
        // Count top-level menus
        $top_level = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->table_name} WHERE parent_slug IS NULL"
        );
        
        // Count submenus
        $submenus = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->table_name} WHERE parent_slug IS NOT NULL"
        );
        
        echo "<h4>Migration Results:</h4>";
        echo "<ul>";
        echo "<li>Total menus: <strong>{$total_menus}</strong></li>";
        echo "<li>Top-level menus: <strong>{$top_level}</strong></li>";
        echo "<li>Submenus: <strong>{$submenus}</strong></li>";
        echo "</ul>";
        
        // Test query to show menu hierarchy
        $menus = $this->wpdb->get_results(
            "SELECT menu_slug, parent_slug, menu_title 
             FROM {$this->table_name} 
             ORDER BY sort_order, menu_slug"
        );
        
        if ($menus) {
            echo "<h4>Menu Structure:</h4>";
            echo "<ul>";
            foreach ($menus as $menu) {
                if (empty($menu->parent_slug)) {
                    echo "<li><strong>{$menu->menu_title}</strong> ({$menu->menu_slug})";
                    
                    // Find submenus
                    $has_submenus = false;
                    foreach ($menus as $submenu) {
                        if ($submenu->parent_slug === $menu->menu_slug) {
                            if (!$has_submenus) {
                                echo "<ul>";
                                $has_submenus = true;
                            }
                            echo "<li>{$submenu->menu_title} ({$submenu->menu_slug})</li>";
                        }
                    }
                    if ($has_submenus) {
                        echo "</ul>";
                    }
                    echo "</li>";
                }
            }
            echo "</ul>";
        }
        
        if ($total_menus >= 6) {
            $this->success[] = "✓ Migration verification passed";
            update_option('virical_admin_menus_migrated', true);
        } else {
            $this->errors[] = "Migration verification failed - expected at least 6 menus, found {$total_menus}";
        }
    }
    
    /**
     * Show migration summary
     */
    private function show_summary() {
        echo "<h3>Migration Summary</h3>";
        
        if (!empty($this->success)) {
            echo "<h4>✓ Successful Operations:</h4>";
            echo "<ul style='color: green;'>";
            foreach ($this->success as $msg) {
                echo "<li>{$msg}</li>";
            }
            echo "</ul>";
        }
        
        if (!empty($this->errors)) {
            echo "<h4>✗ Errors:</h4>";
            echo "<ul style='color: red;'>";
            foreach ($this->errors as $error) {
                echo "<li>{$error}</li>";
            }
            echo "</ul>";
        }
        
        if (empty($this->errors)) {
            echo "<p style='color: green; font-weight: bold;'>✓ Admin menu migration completed successfully!</p>";
        } else {
            echo "<p style='color: red; font-weight: bold;'>✗ Migration completed with errors. Please review.</p>";
        }
    }
}

// Admin page for this migration
function virical_admin_menu_migration_page() {
    ?>
    <div class="wrap">
        <h1>Admin Menu Table Migration</h1>
        
        <?php
        if (isset($_POST['run_migration']) && check_admin_referer('virical_admin_menu_migration')) {
            $migration = new ViricalAdminMenuMigration();
            $migration->run();
        } else {
            global $wpdb;
            $table_name = $wpdb->prefix . 'virical_admin_menus';
            $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'");
            $menu_count = 0;
            
            if ($table_exists) {
                $menu_count = $wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
            }
            ?>
            
            <div class="card">
                <h2>Migration Information</h2>
                
                <p>This migration will:</p>
                <ol>
                    <li>Create the <code>wp_virical_admin_menus</code> table</li>
                    <li>Migrate all existing hardcoded admin menus to the database</li>
                    <li>Prepare the system for dynamic menu management</li>
                </ol>
                
                <h3>Current Status:</h3>
                <ul>
                    <li>Table exists: <strong><?php echo $table_exists ? 'Yes' : 'No'; ?></strong></li>
                    <?php if ($table_exists): ?>
                        <li>Existing menus in database: <strong><?php echo $menu_count; ?></strong></li>
                    <?php endif; ?>
                </ul>
                
                <?php if ($menu_count > 0): ?>
                    <div class="notice notice-warning">
                        <p>⚠ Admin menus already exist in the database. Running this migration will skip existing menus.</p>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <?php wp_nonce_field('virical_admin_menu_migration'); ?>
                    <p>
                        <input type="submit" name="run_migration" class="button button-primary" 
                               value="Run Admin Menu Migration" 
                               onclick="return confirm('This will create the admin menu table and migrate existing menus. Continue?');">
                    </p>
                </form>
                
                <hr>
                
                <p><em>Reference: GiaiPhap Section 3.1 & todos.md Task 2.1-2.2</em></p>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

// Add admin menu for this migration
add_action('admin_menu', function() {
    add_submenu_page(
        'virical-settings',
        'Admin Menu Migration',
        'Admin Menu Migration',
        'manage_options',
        'virical-admin-menu-migration',
        'virical_admin_menu_migration_page'
    );
});