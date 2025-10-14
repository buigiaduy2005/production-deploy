<?php
/**
 * Week 1: Quick Fixes & Data Cleanup
 * 
 * This migration script performs:
 * 1. Clean duplicate data from wp_posts (aura_product, aura_project)
 * 2. Populate empty settings tables
 * 3. Add sample About/Contact data
 * 
 * Reference: GiaiPhap Section 5.0 Week 1 & todos.md Task 1.1-1.4
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ViricalWeek1Migration {
    
    private $wpdb;
    private $errors = [];
    private $success = [];
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }
    
    /**
     * Run all Week 1 migrations
     */
    public function run_migration() {
        echo "<h2>Week 1: Quick Fixes & Data Cleanup</h2>";
        
        // Task 1.1: Clean duplicate data (4h)
        echo "<h3>Task 1.1: Cleaning Duplicate Data...</h3>";
        $this->clean_duplicate_data();
        
        // Task 1.3: Populate empty settings tables (4h)
        echo "<h3>Task 1.3: Populating Settings Tables...</h3>";
        $this->populate_settings_tables();
        
        // Task 1.4: Add sample About/Contact data (2h)
        echo "<h3>Task 1.4: Adding Sample About/Contact Data...</h3>";
        $this->add_sample_data();
        
        // Show summary
        $this->show_summary();
    }
    
    /**
     * Task 1.1: Clean duplicate data from wp_posts
     * Reference: GiaiPhap Lines 606-608
     */
    private function clean_duplicate_data() {
        // Count before deletion
        $aura_products_count = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->wpdb->posts} WHERE post_type = 'aura_product'"
        );
        $aura_projects_count = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->wpdb->posts} WHERE post_type = 'aura_project'"
        );
        
        if ($aura_products_count > 0 || $aura_projects_count > 0) {
            // First, delete post meta for these posts
            $this->wpdb->query(
                "DELETE pm FROM {$this->wpdb->postmeta} pm
                INNER JOIN {$this->wpdb->posts} p ON pm.post_id = p.ID
                WHERE p.post_type IN ('aura_product', 'aura_project')"
            );
            
            // Delete the posts
            $deleted_products = $this->wpdb->query(
                "DELETE FROM {$this->wpdb->posts} WHERE post_type = 'aura_product'"
            );
            
            $deleted_projects = $this->wpdb->query(
                "DELETE FROM {$this->wpdb->posts} WHERE post_type = 'aura_project'"
            );
            
            if ($deleted_products !== false || $deleted_projects !== false) {
                $this->success[] = "✓ Deleted {$aura_products_count} aura_product posts";
                $this->success[] = "✓ Deleted {$aura_projects_count} aura_project posts";
                echo "<p style='color: green;'>✓ Successfully cleaned duplicate data</p>";
            } else {
                $this->errors[] = "Failed to delete duplicate posts";
                echo "<p style='color: red;'>✗ Error cleaning duplicate data</p>";
            }
        } else {
            echo "<p>⚠ No duplicate data found (already cleaned)</p>";
        }
    }
    
    /**
     * Task 1.3: Populate empty settings tables
     * Reference: GiaiPhap Lines 610-619
     */
    private function populate_settings_tables() {
        // Check if tables exist
        $tables = [
            'homepage_settings',
            'homepage_sliders',
            'products_page_settings',
            'projects_page_settings'
        ];
        
        foreach ($tables as $table) {
            $table_name = $this->wpdb->prefix . $table;
            $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$table_name}'");
            
            if (!$table_exists) {
                $this->errors[] = "Table {$table_name} does not exist";
                continue;
            }
            
            // Check if table is empty
            $count = $this->wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
            
            if ($count == 0) {
                switch ($table) {
                    case 'homepage_settings':
                        $this->populate_homepage_settings();
                        break;
                    case 'homepage_sliders':
                        $this->populate_homepage_sliders();
                        break;
                    case 'products_page_settings':
                        $this->populate_products_page_settings();
                        break;
                    case 'projects_page_settings':
                        $this->populate_projects_page_settings();
                        break;
                }
            } else {
                echo "<p>⚠ Table {$table} already has data ({$count} records)</p>";
            }
        }
    }
    
    /**
     * Populate homepage settings
     * Reference: GiaiPhap Lines 611-614
     */
    private function populate_homepage_settings() {
        $settings = [
            ['setting_key' => 'hero_title', 'setting_value' => 'Welcome to Virical'],
            ['setting_key' => 'hero_subtitle', 'setting_value' => 'Premium Lighting Solutions'],
            ['setting_key' => 'hero_image', 'setting_value' => '/uploads/hero.jpg'],
            ['setting_key' => 'hero_button_text', 'setting_value' => 'Khám phá ngay'],
            ['setting_key' => 'hero_button_url', 'setting_value' => '/san-pham/'],
            ['setting_key' => 'featured_products_title', 'setting_value' => 'Sản phẩm nổi bật'],
            ['setting_key' => 'featured_products_count', 'setting_value' => '6'],
            ['setting_key' => 'featured_projects_title', 'setting_value' => 'Công trình tiêu biểu'],
            ['setting_key' => 'featured_projects_count', 'setting_value' => '3']
        ];
        
        foreach ($settings as $setting) {
            $result = $this->wpdb->insert(
                $this->wpdb->prefix . 'homepage_settings',
                $setting,
                ['%s', '%s']
            );
            
            if ($result === false) {
                $this->errors[] = "Failed to insert homepage setting: {$setting['setting_key']}";
            }
        }
        
        $this->success[] = "✓ Populated homepage_settings with " . count($settings) . " settings";
        echo "<p style='color: green;'>✓ Homepage settings populated</p>";
    }
    
    /**
     * Populate homepage sliders
     */
    private function populate_homepage_sliders() {
        $sliders = [
            [
                'title' => 'Virical Lighting',
                'subtitle' => 'Illuminate Your World',
                'image_url' => '/uploads/slider1.jpg',
                'button_text' => 'Explore',
                'button_url' => '/san-pham/',
                'sort_order' => 1,
                'is_active' => 1
            ],
            [
                'title' => 'Giải pháp chiếu sáng',
                'subtitle' => 'Cho mọi không gian',
                'image_url' => '/uploads/slider2.jpg',
                'button_text' => 'Xem thêm',
                'button_url' => '/cong-trinh/',
                'sort_order' => 2,
                'is_active' => 1
            ],
            [
                'title' => 'Công nghệ tiên tiến',
                'subtitle' => 'Tiết kiệm năng lượng',
                'image_url' => '/uploads/slider3.jpg',
                'button_text' => 'Liên hệ',
                'button_url' => '/lien-he/',
                'sort_order' => 3,
                'is_active' => 1
            ]
        ];
        
        foreach ($sliders as $slider) {
            $result = $this->wpdb->insert(
                $this->wpdb->prefix . 'homepage_sliders',
                $slider,
                ['%s', '%s', '%s', '%s', '%s', '%d', '%d']
            );
            
            if ($result === false) {
                $this->errors[] = "Failed to insert slider: {$slider['title']}";
            }
        }
        
        $this->success[] = "✓ Added " . count($sliders) . " homepage sliders";
        echo "<p style='color: green;'>✓ Homepage sliders populated</p>";
    }
    
    /**
     * Populate products page settings
     * Reference: GiaiPhap Lines 616-619
     */
    private function populate_products_page_settings() {
        $settings = [
            ['setting_key' => 'page_title', 'setting_value' => 'Sản phẩm'],
            ['setting_key' => 'page_subtitle', 'setting_value' => 'Khám phá bộ sưu tập đèn chiếu sáng cao cấp'],
            ['setting_key' => 'products_per_page', 'setting_value' => '12'],
            ['setting_key' => 'enable_filter', 'setting_value' => '1'],
            ['setting_key' => 'enable_search', 'setting_value' => '1'],
            ['setting_key' => 'enable_sorting', 'setting_value' => '1'],
            ['setting_key' => 'default_sort', 'setting_value' => 'name_asc'],
            ['setting_key' => 'grid_columns', 'setting_value' => '3'],
            ['setting_key' => 'show_price', 'setting_value' => '1'],
            ['setting_key' => 'show_category', 'setting_value' => '1']
        ];
        
        foreach ($settings as $setting) {
            $result = $this->wpdb->insert(
                $this->wpdb->prefix . 'products_page_settings',
                $setting,
                ['%s', '%s']
            );
            
            if ($result === false) {
                $this->errors[] = "Failed to insert product page setting: {$setting['setting_key']}";
            }
        }
        
        $this->success[] = "✓ Populated products_page_settings with " . count($settings) . " settings";
        echo "<p style='color: green;'>✓ Products page settings populated</p>";
    }
    
    /**
     * Populate projects page settings
     */
    private function populate_projects_page_settings() {
        $settings = [
            ['setting_key' => 'page_title', 'setting_value' => 'Công Trình'],
            ['setting_key' => 'page_subtitle', 'setting_value' => 'Các dự án chiếu sáng đã thực hiện'],
            ['setting_key' => 'projects_per_page', 'setting_value' => '9'],
            ['setting_key' => 'enable_filter', 'setting_value' => '1'],
            ['setting_key' => 'enable_type_filter', 'setting_value' => '1'],
            ['setting_key' => 'grid_columns', 'setting_value' => '3'],
            ['setting_key' => 'show_location', 'setting_value' => '1'],
            ['setting_key' => 'show_year', 'setting_value' => '1'],
            ['setting_key' => 'show_type', 'setting_value' => '1']
        ];
        
        foreach ($settings as $setting) {
            $result = $this->wpdb->insert(
                $this->wpdb->prefix . 'projects_page_settings',
                $setting,
                ['%s', '%s']
            );
            
            if ($result === false) {
                $this->errors[] = "Failed to insert project page setting: {$setting['setting_key']}";
            }
        }
        
        $this->success[] = "✓ Populated projects_page_settings with " . count($settings) . " settings";
        echo "<p style='color: green;'>✓ Projects page settings populated</p>";
    }
    
    /**
     * Task 1.4: Add sample About/Contact data
     */
    private function add_sample_data() {
        // Add team members
        $this->add_team_members();
        
        // Add contact offices
        $this->add_contact_offices();
        
        // Add achievements
        $this->add_achievements();
    }
    
    /**
     * Add sample team members
     */
    private function add_team_members() {
        $table_name = $this->wpdb->prefix . 'about_team_members';
        $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$table_name}'");
        
        if (!$table_exists) {
            $this->errors[] = "Table {$table_name} does not exist";
            return;
        }
        
        $count = $this->wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
        
        if ($count == 0) {
            $team_members = [
                [
                    'name' => 'Nguyễn Văn A',
                    'position' => 'CEO & Founder',
                    'bio' => 'Với hơn 15 năm kinh nghiệm trong ngành chiếu sáng, ông A đã dẫn dắt Virical trở thành một trong những thương hiệu hàng đầu về giải pháp chiếu sáng tại Việt Nam.',
                    'image_url' => '/uploads/team/ceo.jpg',
                    'email' => 'ceo@virical.vn',
                    'linkedin' => 'https://linkedin.com/in/nguyenvana',
                    'sort_order' => 1,
                    'is_active' => 1
                ],
                [
                    'name' => 'Trần Thị B',
                    'position' => 'Design Director',
                    'bio' => 'Chuyên gia thiết kế ánh sáng với nhiều giải thưởng quốc tế, bà B đã tạo nên những không gian ánh sáng độc đáo cho hàng trăm dự án lớn.',
                    'image_url' => '/uploads/team/designer.jpg',
                    'email' => 'design@virical.vn',
                    'linkedin' => 'https://linkedin.com/in/tranthib',
                    'sort_order' => 2,
                    'is_active' => 1
                ],
                [
                    'name' => 'Phạm Văn C',
                    'position' => 'Technical Manager',
                    'bio' => 'Kỹ sư điện với chuyên môn cao về công nghệ LED và hệ thống điều khiển thông minh, ông C đảm bảo chất lượng kỹ thuật cho mọi sản phẩm.',
                    'image_url' => '/uploads/team/technical.jpg',
                    'email' => 'technical@virical.vn',
                    'linkedin' => 'https://linkedin.com/in/phamvanc',
                    'sort_order' => 3,
                    'is_active' => 1
                ]
            ];
            
            foreach ($team_members as $member) {
                $result = $this->wpdb->insert($table_name, $member);
                
                if ($result === false) {
                    $this->errors[] = "Failed to insert team member: {$member['name']}";
                }
            }
            
            $this->success[] = "✓ Added " . count($team_members) . " team members";
            echo "<p style='color: green;'>✓ Team members added</p>";
        } else {
            echo "<p>⚠ Team members table already has data ({$count} records)</p>";
        }
    }
    
    /**
     * Add sample contact offices
     */
    private function add_contact_offices() {
        $table_name = $this->wpdb->prefix . 'contact_offices';
        $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$table_name}'");
        
        if (!$table_exists) {
            $this->errors[] = "Table {$table_name} does not exist";
            return;
        }
        
        $count = $this->wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
        
        if ($count == 0) {
            $offices = [
                [
                    'name' => 'Văn phòng chính',
                    'address' => '123 Nguyễn Trãi, Quận 1, TP.HCM',
                    'phone' => '028 1234 5678',
                    'fax' => '028 1234 5679',
                    'email' => 'info@virical.vn',
                    'latitude' => 10.762622,
                    'longitude' => 106.660172,
                    'working_hours' => 'Thứ 2 - Thứ 6: 8:00 - 18:00',
                    'is_main' => 1,
                    'is_active' => 1
                ],
                [
                    'name' => 'Showroom',
                    'address' => '456 Lê Lợi, Quận 3, TP.HCM',
                    'phone' => '028 8765 4321',
                    'fax' => '028 8765 4322',
                    'email' => 'showroom@virical.vn',
                    'latitude' => 10.772075,
                    'longitude' => 106.698795,
                    'working_hours' => 'Thứ 2 - Chủ nhật: 9:00 - 21:00',
                    'is_main' => 0,
                    'is_active' => 1
                ],
                [
                    'name' => 'Chi nhánh Hà Nội',
                    'address' => '789 Kim Mã, Ba Đình, Hà Nội',
                    'phone' => '024 3456 7890',
                    'fax' => '024 3456 7891',
                    'email' => 'hanoi@virical.vn',
                    'latitude' => 21.033333,
                    'longitude' => 105.850000,
                    'working_hours' => 'Thứ 2 - Thứ 6: 8:00 - 17:30',
                    'is_main' => 0,
                    'is_active' => 1
                ]
            ];
            
            foreach ($offices as $office) {
                $result = $this->wpdb->insert($table_name, $office);
                
                if ($result === false) {
                    $this->errors[] = "Failed to insert office: {$office['name']}";
                }
            }
            
            $this->success[] = "✓ Added " . count($offices) . " office locations";
            echo "<p style='color: green;'>✓ Office locations added</p>";
        } else {
            echo "<p>⚠ Offices table already has data ({$count} records)</p>";
        }
    }
    
    /**
     * Add sample achievements
     */
    private function add_achievements() {
        $table_name = $this->wpdb->prefix . 'about_achievements';
        $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$table_name}'");
        
        if (!$table_exists) {
            $this->errors[] = "Table {$table_name} does not exist";
            return;
        }
        
        $count = $this->wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
        
        if ($count == 0) {
            $achievements = [
                [
                    'year' => 2020,
                    'title' => 'Best Lighting Brand',
                    'description' => 'Giải thưởng thương hiệu chiếu sáng tốt nhất từ Vietnam Lighting Association',
                    'icon' => 'dashicons-awards',
                    'sort_order' => 1,
                    'is_active' => 1
                ],
                [
                    'year' => 2021,
                    'title' => 'ISO 9001:2015',
                    'description' => 'Chứng nhận hệ thống quản lý chất lượng quốc tế',
                    'icon' => 'dashicons-yes-alt',
                    'sort_order' => 2,
                    'is_active' => 1
                ],
                [
                    'year' => 2022,
                    'title' => 'Green Building Partner',
                    'description' => 'Đối tác chiến lược cho các công trình xanh bền vững',
                    'icon' => 'dashicons-admin-multisite',
                    'sort_order' => 3,
                    'is_active' => 1
                ],
                [
                    'year' => 2023,
                    'title' => 'Innovation Award',
                    'description' => 'Giải thưởng đổi mới sáng tạo trong công nghệ LED thông minh',
                    'icon' => 'dashicons-lightbulb',
                    'sort_order' => 4,
                    'is_active' => 1
                ]
            ];
            
            foreach ($achievements as $achievement) {
                $result = $this->wpdb->insert($table_name, $achievement);
                
                if ($result === false) {
                    $this->errors[] = "Failed to insert achievement: {$achievement['title']}";
                }
            }
            
            $this->success[] = "✓ Added " . count($achievements) . " achievements";
            echo "<p style='color: green;'>✓ Achievements added</p>";
        } else {
            echo "<p>⚠ Achievements table already has data ({$count} records)</p>";
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
        
        // Run validation tests
        $this->run_validation_tests();
    }
    
    /**
     * Run validation tests for Week 1
     * Reference: todos.md Task 1.5
     */
    private function run_validation_tests() {
        echo "<h3>🧪 Validation Tests</h3>";
        
        $tests = [];
        
        // Test 1: Verify duplicate data removed
        $aura_count = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->wpdb->posts} WHERE post_type IN ('aura_product', 'aura_project')"
        );
        $tests[] = [
            'name' => 'Duplicate data removed',
            'expected' => 0,
            'actual' => $aura_count,
            'passed' => ($aura_count == 0)
        ];
        
        // Test 2: Verify settings populated
        $homepage_settings = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->wpdb->prefix}homepage_settings"
        );
        $tests[] = [
            'name' => 'Homepage settings populated',
            'expected' => '> 3',
            'actual' => $homepage_settings,
            'passed' => ($homepage_settings > 3)
        ];
        
        $products_settings = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->wpdb->prefix}products_page_settings"
        );
        $tests[] = [
            'name' => 'Products page settings populated',
            'expected' => '> 3',
            'actual' => $products_settings,
            'passed' => ($products_settings > 3)
        ];
        
        // Test 3: Verify sample data
        $team_members = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->wpdb->prefix}about_team_members WHERE is_active = 1"
        );
        $tests[] = [
            'name' => 'Team members added',
            'expected' => '>= 2',
            'actual' => $team_members,
            'passed' => ($team_members >= 2)
        ];
        
        $offices = $this->wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->wpdb->prefix}contact_offices WHERE is_active = 1"
        );
        $tests[] = [
            'name' => 'Office locations added',
            'expected' => '>= 2',
            'actual' => $offices,
            'passed' => ($offices >= 2)
        ];
        
        // Display test results
        echo "<table class='wp-list-table widefat fixed striped'>";
        echo "<thead><tr><th>Test</th><th>Expected</th><th>Actual</th><th>Result</th></tr></thead>";
        echo "<tbody>";
        
        $all_passed = true;
        foreach ($tests as $test) {
            $result = $test['passed'] ? 
                '<span style="color: green;">✓ PASSED</span>' : 
                '<span style="color: red;">✗ FAILED</span>';
            
            echo "<tr>";
            echo "<td>{$test['name']}</td>";
            echo "<td>{$test['expected']}</td>";
            echo "<td>{$test['actual']}</td>";
            echo "<td>{$result}</td>";
            echo "</tr>";
            
            if (!$test['passed']) {
                $all_passed = false;
            }
        }
        
        echo "</tbody></table>";
        
        if ($all_passed) {
            echo "<p style='color: green; font-weight: bold;'>✓ All Week 1 tests passed! Ready for Week 2.</p>";
            update_option('virical_week1_completed', true);
        } else {
            echo "<p style='color: red; font-weight: bold;'>✗ Some tests failed. Please review and fix issues before proceeding.</p>";
        }
    }
}

// Admin page for Week 1 migration
function virical_week1_migration_page() {
    ?>
    <div class="wrap">
        <h1>Week 1: Quick Fixes & Data Cleanup</h1>
        
        <?php
        if (isset($_POST['run_week1']) && check_admin_referer('virical_week1_migration')) {
            $migration = new ViricalWeek1Migration();
            $migration->run_migration();
        } else {
            // Check current status
            global $wpdb;
            $week1_completed = get_option('virical_week1_completed', false);
            ?>
            
            <div class="card">
                <h2>Week 1 Tasks Overview</h2>
                
                <?php if ($week1_completed): ?>
                    <div class="notice notice-success">
                        <p>✓ Week 1 tasks have been completed!</p>
                    </div>
                <?php endif; ?>
                
                <p>This migration will perform the following tasks:</p>
                <ol>
                    <li><strong>Task 1.1:</strong> Clean duplicate data (Remove aura_product and aura_project posts)</li>
                    <li><strong>Task 1.3:</strong> Populate empty settings tables (homepage, products, projects)</li>
                    <li><strong>Task 1.4:</strong> Add sample About/Contact data (team members, offices, achievements)</li>
                </ol>
                
                <h3>Current Status:</h3>
                <?php
                $aura_products = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'aura_product'");
                $aura_projects = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'aura_project'");
                $homepage_settings = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}homepage_settings");
                $team_members = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}about_team_members");
                ?>
                
                <ul>
                    <li>Aura Products (to be removed): <strong><?php echo $aura_products; ?></strong></li>
                    <li>Aura Projects (to be removed): <strong><?php echo $aura_projects; ?></strong></li>
                    <li>Homepage Settings: <strong><?php echo $homepage_settings; ?></strong> records</li>
                    <li>Team Members: <strong><?php echo $team_members; ?></strong> records</li>
                </ul>
                
                <form method="post" action="">
                    <?php wp_nonce_field('virical_week1_migration'); ?>
                    <p>
                        <input type="submit" name="run_week1" class="button button-primary" 
                               value="Run Week 1 Migration" 
                               onclick="return confirm('This will clean duplicate data and populate settings. Continue?');">
                    </p>
                </form>
                
                <hr>
                
                <p><em>Reference: GiaiPhap Section 5.0 Week 1 & todos.md Tasks 1.1-1.5</em></p>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

// Add admin menu for Week 1 migration
add_action('admin_menu', function() {
    add_submenu_page(
        'virical-products',
        'Week 1 Migration',
        'Week 1 Migration',
        'manage_options',
        'virical-week1-migration',
        'virical_week1_migration_page'
    );
});