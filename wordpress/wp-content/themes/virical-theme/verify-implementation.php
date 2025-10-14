<?php
/**
 * Verification Script for Virical Implementation
 * 
 * This script verifies the Week 1 and Week 2 implementations
 * Run this from WordPress admin or via WP-CLI
 * 
 * @package Virical
 */

// If running via WP-CLI or direct PHP
if (php_sapi_name() === 'cli') {
    // Load WordPress
    $wp_load_path = dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';
    if (file_exists($wp_load_path)) {
        require_once $wp_load_path;
    } else {
        die("WordPress not found. Please run from WordPress root.\n");
    }
}

class ViricalImplementationVerifier {
    
    private $wpdb;
    private $tests_passed = 0;
    private $tests_failed = 0;
    private $results = [];
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }
    
    /**
     * Run all verification tests
     */
    public function run_all_tests() {
        echo "\n========================================\n";
        echo "VIRICAL IMPLEMENTATION VERIFICATION\n";
        echo "========================================\n\n";
        
        // Week 1 Tests
        echo "WEEK 1 TESTS - Quick Fixes & Data Cleanup\n";
        echo "----------------------------------------\n";
        $this->test_duplicate_data_cleanup();
        $this->test_settings_tables_populated();
        $this->test_about_contact_data();
        $this->test_single_product_redirect();
        
        echo "\nWEEK 2 TESTS - Admin Menu System\n";
        echo "----------------------------------------\n";
        $this->test_admin_menu_table();
        $this->test_admin_menu_manager_class();
        $this->test_functions_php_updated();
        
        // Summary
        $this->show_summary();
    }
    
    /**
     * Test 1.1: Verify duplicate data cleanup
     */
    private function test_duplicate_data_cleanup() {
        $test_name = "Task 1.1: Duplicate Data Cleanup";
        
        // Check for aura_product posts
        $aura_products = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->wpdb->posts} WHERE post_type = 'aura_product'"
        );
        
        // Check for aura_project posts
        $aura_projects = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->wpdb->posts} WHERE post_type = 'aura_project'"
        );
        
        if ($aura_products == 0 && $aura_projects == 0) {
            $this->pass($test_name, "No duplicate aura posts found");
        } else {
            $this->fail($test_name, "Found {$aura_products} aura_product and {$aura_projects} aura_project posts");
        }
    }
    
    /**
     * Test 1.3: Verify settings tables populated
     */
    private function test_settings_tables_populated() {
        $tables = [
            'homepage_settings' => 3,
            'homepage_sliders' => 1,
            'products_page_settings' => 3,
            'projects_page_settings' => 3
        ];
        
        foreach ($tables as $table => $min_records) {
            $test_name = "Task 1.3: {$table} populated";
            $table_name = $this->wpdb->prefix . $table;
            
            // Check if table exists
            $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$table_name}'");
            
            if (!$table_exists) {
                $this->fail($test_name, "Table {$table_name} does not exist");
                continue;
            }
            
            // Count records
            $count = $this->wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
            
            if ($count >= $min_records) {
                $this->pass($test_name, "Found {$count} records (minimum: {$min_records})");
            } else {
                $this->fail($test_name, "Found {$count} records, expected at least {$min_records}");
            }
        }
    }
    
    /**
     * Test 1.4: Verify About/Contact data
     */
    private function test_about_contact_data() {
        $tables = [
            'about_team_members' => 2,
            'contact_offices' => 2,
            'about_achievements' => 2
        ];
        
        foreach ($tables as $table => $min_records) {
            $test_name = "Task 1.4: {$table} data";
            $table_name = $this->wpdb->prefix . $table;
            
            // Check if table exists
            $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$table_name}'");
            
            if (!$table_exists) {
                $this->warn($test_name, "Table {$table_name} does not exist (may not be required)");
                continue;
            }
            
            // Count active records
            $count = $this->wpdb->get_var(
                "SELECT COUNT(*) FROM {$table_name} WHERE is_active = 1"
            );
            
            if ($count >= $min_records) {
                $this->pass($test_name, "Found {$count} active records");
            } else {
                $this->warn($test_name, "Found {$count} records, expected at least {$min_records}");
            }
        }
    }
    
    /**
     * Test 1.2: Verify single product template redirect
     */
    private function test_single_product_redirect() {
        $test_name = "Task 1.2: Single Product Template";
        
        $template_file = get_template_directory() . '/single-aura_product.php';
        
        if (file_exists($template_file)) {
            $content = file_get_contents($template_file);
            
            if (strpos($content, 'wp_redirect') !== false && 
                strpos($content, 'virical_products') !== false) {
                $this->pass($test_name, "Template correctly redirects to new structure");
            } else {
                $this->fail($test_name, "Template exists but doesn't redirect properly");
            }
        } else {
            $this->fail($test_name, "Template file not found");
        }
    }
    
    /**
     * Test 2.1: Verify admin menu table
     */
    private function test_admin_menu_table() {
        $test_name = "Task 2.1: Admin Menu Table";
        $table_name = $this->wpdb->prefix . 'virical_admin_menus';
        
        // Check if table exists
        $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$table_name}'");
        
        if (!$table_exists) {
            $this->fail($test_name, "Table {$table_name} does not exist");
            return;
        }
        
        // Check table structure
        $columns = $this->wpdb->get_results("SHOW COLUMNS FROM {$table_name}");
        $required_columns = ['id', 'menu_slug', 'parent_slug', 'menu_title', 'page_title', 
                            'capability', 'icon', 'position', 'callback_function', 'is_active'];
        
        $column_names = array_map(function($col) { return $col->Field; }, $columns);
        $missing_columns = array_diff($required_columns, $column_names);
        
        if (empty($missing_columns)) {
            // Count menus
            $menu_count = $this->wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
            
            if ($menu_count >= 6) {
                $this->pass($test_name, "Table exists with {$menu_count} menus");
            } else {
                $this->warn($test_name, "Table exists but only has {$menu_count} menus (expected 6+)");
            }
        } else {
            $this->fail($test_name, "Missing columns: " . implode(', ', $missing_columns));
        }
    }
    
    /**
     * Test 2.3: Verify Admin Menu Manager Class
     */
    private function test_admin_menu_manager_class() {
        $test_name = "Task 2.3: Admin Menu Manager Class";
        
        $class_file = get_template_directory() . '/includes/class-virical-admin-menu-manager.php';
        
        if (!file_exists($class_file)) {
            $this->fail($test_name, "Class file not found");
            return;
        }
        
        // Check if class is loaded
        if (class_exists('ViricalAdminMenuManager')) {
            // Check required methods
            $required_methods = ['register_menus', 'get_all_menus', 'add_menu', 
                               'update_menu', 'delete_menu', 'clear_cache'];
            
            $missing_methods = [];
            foreach ($required_methods as $method) {
                if (!method_exists('ViricalAdminMenuManager', $method)) {
                    $missing_methods[] = $method;
                }
            }
            
            if (empty($missing_methods)) {
                $this->pass($test_name, "Class loaded with all required methods");
            } else {
                $this->fail($test_name, "Missing methods: " . implode(', ', $missing_methods));
            }
        } else {
            $this->fail($test_name, "Class not loaded");
        }
    }
    
    /**
     * Test 2.4: Verify functions.php updated
     */
    private function test_functions_php_updated() {
        $test_name = "Task 2.4: Functions.php Updated";
        
        $functions_file = get_template_directory() . '/functions.php';
        $content = file_get_contents($functions_file);
        
        if (strpos($content, 'class-virical-admin-menu-manager.php') !== false) {
            $this->pass($test_name, "Functions.php includes Admin Menu Manager");
        } else {
            $this->fail($test_name, "Functions.php doesn't include Admin Menu Manager");
        }
    }
    
    /**
     * Helper: Pass test
     */
    private function pass($test_name, $message) {
        $this->tests_passed++;
        $this->results[] = ['status' => 'PASS', 'test' => $test_name, 'message' => $message];
        echo "✅ PASS: {$test_name}\n";
        echo "   {$message}\n\n";
    }
    
    /**
     * Helper: Fail test
     */
    private function fail($test_name, $message) {
        $this->tests_failed++;
        $this->results[] = ['status' => 'FAIL', 'test' => $test_name, 'message' => $message];
        echo "❌ FAIL: {$test_name}\n";
        echo "   {$message}\n\n";
    }
    
    /**
     * Helper: Warning
     */
    private function warn($test_name, $message) {
        $this->results[] = ['status' => 'WARN', 'test' => $test_name, 'message' => $message];
        echo "⚠️  WARN: {$test_name}\n";
        echo "   {$message}\n\n";
    }
    
    /**
     * Show summary
     */
    private function show_summary() {
        echo "\n========================================\n";
        echo "VERIFICATION SUMMARY\n";
        echo "========================================\n\n";
        
        $total_tests = $this->tests_passed + $this->tests_failed;
        $pass_rate = $total_tests > 0 ? round(($this->tests_passed / $total_tests) * 100, 1) : 0;
        
        echo "Total Tests: {$total_tests}\n";
        echo "Passed: {$this->tests_passed}\n";
        echo "Failed: {$this->tests_failed}\n";
        echo "Pass Rate: {$pass_rate}%\n\n";
        
        if ($this->tests_failed > 0) {
            echo "❌ FAILED TESTS:\n";
            foreach ($this->results as $result) {
                if ($result['status'] === 'FAIL') {
                    echo "   - {$result['test']}: {$result['message']}\n";
                }
            }
            echo "\n";
        }
        
        if ($pass_rate >= 80) {
            echo "✅ Implementation verification PASSED!\n";
        } elseif ($pass_rate >= 60) {
            echo "⚠️  Implementation partially complete. Review failed tests.\n";
        } else {
            echo "❌ Implementation verification FAILED. Please fix issues.\n";
        }
        
        // Save results to file
        $this->save_results();
    }
    
    /**
     * Save results to file
     */
    private function save_results() {
        $results_file = get_template_directory() . '/verification-results.txt';
        $content = "VIRICAL IMPLEMENTATION VERIFICATION RESULTS\n";
        $content .= "Generated: " . date('Y-m-d H:i:s') . "\n\n";
        
        foreach ($this->results as $result) {
            $content .= "[{$result['status']}] {$result['test']}: {$result['message']}\n";
        }
        
        file_put_contents($results_file, $content);
        echo "\nResults saved to: verification-results.txt\n";
    }
}

// Run verification if called directly or via admin
if (php_sapi_name() === 'cli' || (is_admin() && isset($_GET['run_verification']))) {
    $verifier = new ViricalImplementationVerifier();
    $verifier->run_all_tests();
} else {
    // Add admin page for verification
    add_action('admin_menu', function() {
        add_submenu_page(
            'virical-settings',
            'Implementation Verification',
            'Verify Implementation',
            'manage_options',
            'virical-verification',
            function() {
                ?>
                <div class="wrap">
                    <h1>Virical Implementation Verification</h1>
                    
                    <div class="card">
                        <h2>Run Verification Tests</h2>
                        <p>This will verify all Week 1 and Week 2 implementation tasks.</p>
                        
                        <a href="<?php echo admin_url('admin.php?page=virical-verification&run_verification=1'); ?>" 
                           class="button button-primary">Run Verification</a>
                    </div>
                    
                    <?php if (isset($_GET['run_verification'])): ?>
                        <div class="card" style="margin-top: 20px;">
                            <h2>Verification Results</h2>
                            <pre style="background: #f1f1f1; padding: 15px; overflow-x: auto;">
                                <?php
                                $verifier = new ViricalImplementationVerifier();
                                $verifier->run_all_tests();
                                ?>
                            </pre>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
            }
        );
    });
}