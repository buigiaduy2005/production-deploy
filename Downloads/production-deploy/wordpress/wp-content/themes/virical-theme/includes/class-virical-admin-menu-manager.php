<?php
/**
 * Virical Admin Menu Manager Class
 * 
 * Manages dynamic admin menus from database
 * Reference: GiaiPhap Section 5.1 Lines 644-808 & todos.md Task 2.3
 * 
 * @package Virical
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ViricalAdminMenuManager {
    
    /**
     * Database instance
     * @var wpdb
     */
    private $wpdb;
    
    /**
     * Table name for admin menus
     * @var string
     */
    private $table_name;
    
    /**
     * Cache key for menu items
     * @var string
     */
    private $cache_key = 'virical_admin_menus';
    
    /**
     * Cache TTL in seconds
     * @var int
     */
    private $cache_ttl = 3600; // 1 hour
    
    /**
     * Singleton instance
     * @var ViricalAdminMenuManager
     */
    private static $instance = null;
    
    /**
     * Get singleton instance
     * @return ViricalAdminMenuManager
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'virical_admin_menus';
        
        // Hook into WordPress
        add_action('admin_menu', [$this, 'register_menus'], 5); // Early priority
        add_action('admin_init', [$this, 'init']);
        
        // Add AJAX handlers for dynamic menu management
        add_action('wp_ajax_virical_update_menu', [$this, 'ajax_update_menu']);
        add_action('wp_ajax_virical_toggle_menu', [$this, 'ajax_toggle_menu']);
        add_action('wp_ajax_virical_delete_menu', [$this, 'ajax_delete_menu']);
    }
    
    /**
     * Initialize menu system
     * Reference: GiaiPhap Lines 662-667
     */
    public function init() {
        // Clear cache on menu update
        if (isset($_POST['virical_menu_updated'])) {
            $this->clear_cache();
        }
        
        // Check if table exists, create if not
        $this->ensure_table_exists();
        
        // Register custom capabilities
        $this->register_capabilities();
    }
    
    /**
     * Ensure the admin menu table exists
     */
    private function ensure_table_exists() {
        $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'");
        
        if (!$table_exists) {
            // Create the table if it doesn't exist
            require_once(dirname(__FILE__) . '/../migrations/001-create-admin-menu-table.php');
            $migration = new ViricalAdminMenuMigration();
            $migration->run();
        }
    }
    
    /**
     * Register custom capabilities for menu management
     */
    private function register_capabilities() {
        $role = get_role('administrator');
        if ($role) {
            $role->add_cap('manage_virical_menus');
        }
    }
    
    /**
     * Register menus from database
     * Reference: GiaiPhap Lines 672-693
     */
    public function register_menus() {
        $menus = $this->get_active_menus();
        
        if (empty($menus)) {
            // Fallback to default if no menus in database
//             $this->register_default_menus();
            return;
        }
        
        // Group menus by parent
        $menu_tree = $this->build_menu_tree($menus);
        
        // Register top-level menus first
        foreach ($menu_tree as $menu) {
            if (empty($menu->parent_slug)) {
                add_menu_page(
                    $menu->page_title,
                    $menu->menu_title,
                    $menu->capability ?: 'manage_options',
                    $menu->menu_slug,
                    [$this, 'render_menu_page'],
                    $menu->icon,
                    $menu->position
                );
                
                // Register submenus
                if (isset($menu->children)) {
                    foreach ($menu->children as $submenu) {
                        add_submenu_page(
                            $menu->menu_slug,
                            $submenu->page_title,
                            $submenu->menu_title,
                            $submenu->capability ?: 'manage_options',
                            $submenu->menu_slug,
                            [$this, 'render_menu_page']
                        );
                    }
                }
            }
        }
    }
    
    /**
     * Build menu tree structure
     * @param array $menus Flat array of menu items
     * @return array Tree structure
     */
    private function build_menu_tree($menus) {
        $tree = [];
        $index = [];
        
        // First pass: index all menus
        foreach ($menus as $menu) {
            $index[$menu->menu_slug] = $menu;
            $menu->children = [];
        }
        
        // Second pass: build tree
        foreach ($menus as $menu) {
            if (empty($menu->parent_slug)) {
                $tree[$menu->menu_slug] = $menu;
            } else {
                if (isset($index[$menu->parent_slug])) {
                    $index[$menu->parent_slug]->children[] = $menu;
                }
            }
        }
        
        return $tree;
    }
    
    /**
     * Register default menus as fallback
     */
    private function register_default_menus() {
        // Products menu
        add_menu_page(
            'Quản lý Sản phẩm',
            'Sản phẩm Virical',
            'manage_options',
            'virical-products',
            'virical_products_page',
            'dashicons-cart',
            30
        );
        
        // Projects menu
        add_menu_page(
            'Quản lý Công trình',
            'Công trình Virical',
            'manage_options',
            'virical-projects',
            'virical_projects_admin_page',
            'dashicons-building',
            31
        );
    }
    
    /**
     * Get active menus from database with caching
     * Reference: GiaiPhap Lines 698-713
     */
    private function get_active_menus() {
        // Try to get from cache first
        $menus = wp_cache_get($this->cache_key);
        
        if (false === $menus) {
            $menus = $this->wpdb->get_results(
                "SELECT * FROM {$this->table_name} 
                WHERE is_active = 1 
                ORDER BY sort_order ASC, id ASC"
            );
            
            // Set cache
            if ($menus) {
                wp_cache_set($this->cache_key, $menus, '', $this->cache_ttl);
            }
        }
        
        return $menus ?: [];
    }
    
    /**
     * Render menu page based on callback
     * Reference: GiaiPhap Lines 732-745
     */
    public function render_menu_page() {
        $current_menu = $this->get_current_menu();
        
        if (!$current_menu) {
            wp_die('Menu not found');
        }
        
        // Check if callback function exists
        if (!empty($current_menu->callback_function) && 
            function_exists($current_menu->callback_function)) {
            // Call the original function
            call_user_func($current_menu->callback_function);
        } else {
            // Try to include file if specified in meta_data
            $meta_data = json_decode($current_menu->meta_data, true);
            if (!empty($meta_data['original_file'])) {
                $file_path = get_template_directory() . '/includes/' . $meta_data['original_file'];
                if (file_exists($file_path)) {
                    include $file_path;
                } else {
                    // Default render
                    $this->render_default_page($current_menu);
                }
            } else {
                // Default render
                $this->render_default_page($current_menu);
            }
        }
    }
    
    /**
     * Get current menu based on page parameter
     * Reference: GiaiPhap Lines 750-763
     */
    private function get_current_menu() {
        $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
        
        if (empty($page)) {
            return null;
        }
        
        // Try cache first
        $cache_key = 'virical_menu_' . $page;
        $menu = wp_cache_get($cache_key);
        
        if (false === $menu) {
            $menu = $this->wpdb->get_row(
                $this->wpdb->prepare(
                    "SELECT * FROM {$this->table_name} WHERE menu_slug = %s",
                    $page
                )
            );
            
            if ($menu) {
                wp_cache_set($cache_key, $menu, '', 300); // 5 minutes
            }
        }
        
        return $menu;
    }
    
    /**
     * Default page renderer
     * Reference: GiaiPhap Lines 768-789
     */
    private function render_default_page($menu) {
        $meta_data = json_decode($menu->meta_data, true) ?: [];
        ?>
        <div class="wrap">
            <h1><?php echo esc_html($menu->page_title); ?></h1>
            
            <?php if (!empty($meta_data['description'])): ?>
                <p class="description"><?php echo esc_html($meta_data['description']); ?></p>
            <?php endif; ?>
            
            <div class="notice notice-info">
                <p>This page is dynamically generated from database configuration.</p>
                <?php if (!empty($meta_data['help_text'])): ?>
                    <p><?php echo esc_html($meta_data['help_text']); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="card">
                <h2>Menu Information</h2>
                <table class="form-table">
                    <tr>
                        <th>Menu Slug</th>
                        <td><code><?php echo esc_html($menu->menu_slug); ?></code></td>
                    </tr>
                    <tr>
                        <th>Capability Required</th>
                        <td><code><?php echo esc_html($menu->capability); ?></code></td>
                    </tr>
                    <?php if ($menu->parent_slug): ?>
                    <tr>
                        <th>Parent Menu</th>
                        <td><code><?php echo esc_html($menu->parent_slug); ?></code></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if ($menu->is_active): ?>
                                <span class="dashicons dashicons-yes-alt" style="color: green;"></span> Active
                            <?php else: ?>
                                <span class="dashicons dashicons-dismiss" style="color: red;"></span> Inactive
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php
            // Hook for custom content
            do_action('virical_admin_page_content', $menu->menu_slug, $menu);
            ?>
        </div>
        <?php
    }
    
    /**
     * Clear menu cache
     * Reference: GiaiPhap Lines 794-796
     */
    public function clear_cache() {
        wp_cache_delete($this->cache_key);
        
        // Clear individual menu caches
        $menus = $this->wpdb->get_results("SELECT menu_slug FROM {$this->table_name}");
        foreach ($menus as $menu) {
            wp_cache_delete('virical_menu_' . $menu->menu_slug);
        }
    }
    
    /**
     * Add new menu
     * Reference: GiaiPhap Lines 799-816
     */
    public function add_menu($data) {
        // Validate required fields
        if (empty($data['menu_slug']) || empty($data['menu_title']) || empty($data['page_title'])) {
            return new WP_Error('missing_fields', 'Required fields are missing');
        }
        
        // Check if menu slug already exists
        $exists = $this->wpdb->get_var($this->wpdb->prepare(
            "SELECT id FROM {$this->table_name} WHERE menu_slug = %s",
            $data['menu_slug']
        ));
        
        if ($exists) {
            return new WP_Error('menu_exists', 'Menu slug already exists');
        }
        
        // Set defaults
        $data = wp_parse_args($data, [
            'capability' => 'manage_options',
            'is_active' => true,
            'sort_order' => 0
        ]);
        
        // Encode meta_data if array
        if (isset($data['meta_data']) && is_array($data['meta_data'])) {
            $data['meta_data'] = json_encode($data['meta_data']);
        }
        
        // Insert menu
        $result = $this->wpdb->insert(
            $this->table_name,
            $data,
            [
                '%s', '%s', '%s', '%s', '%s',
                '%s', '%d', '%s', '%d', '%d', '%s'
            ]
        );
        
        if ($result) {
            $this->clear_cache();
            $this->save_version($this->wpdb->insert_id, 'create', $data);
            return $this->wpdb->insert_id;
        }
        
        return new WP_Error('insert_failed', 'Failed to insert menu');
    }
    
    /**
     * Update menu
     * Reference: GiaiPhap Lines 821-844
     */
    public function update_menu($id, $data) {
        // Get current menu
        $current = $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE id = %d",
            $id
        ), ARRAY_A);
        
        if (!$current) {
            return new WP_Error('menu_not_found', 'Menu not found');
        }
        
        // Encode meta_data if array
        if (isset($data['meta_data']) && is_array($data['meta_data'])) {
            $data['meta_data'] = json_encode($data['meta_data']);
        }
        
        // Update menu
        $result = $this->wpdb->update(
            $this->table_name,
            $data,
            ['id' => $id]
        );
        
        if ($result !== false) {
            $this->clear_cache();
            $this->save_version($id, 'update', array_merge($current, $data));
            return true;
        }
        
        return new WP_Error('update_failed', 'Failed to update menu');
    }
    
    /**
     * Delete menu
     * Reference: GiaiPhap Lines 849-866
     */
    public function delete_menu($id) {
        // Get menu data before deletion
        $menu = $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE id = %d",
            $id
        ), ARRAY_A);
        
        if (!$menu) {
            return new WP_Error('menu_not_found', 'Menu not found');
        }
        
        // Check if menu has children
        $has_children = $this->wpdb->get_var($this->wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table_name} WHERE parent_slug = %s",
            $menu['menu_slug']
        ));
        
        if ($has_children > 0) {
            return new WP_Error('has_children', 'Cannot delete menu with children');
        }
        
        // Delete menu
        $result = $this->wpdb->delete(
            $this->table_name,
            ['id' => $id],
            ['%d']
        );
        
        if ($result) {
            $this->clear_cache();
            $this->save_version($id, 'delete', $menu);
            return true;
        }
        
        return new WP_Error('delete_failed', 'Failed to delete menu');
    }
    
    /**
     * Save version history
     * Reference: GiaiPhap Lines 871-895
     */
    private function save_version($menu_id, $action, $data) {
        $version_table = $this->wpdb->prefix . 'virical_config_versions';
        
        // Check if version table exists
        $table_exists = $this->wpdb->get_var("SHOW TABLES LIKE '{$version_table}'");
        
        if (!$table_exists) {
            return; // Skip versioning if table doesn't exist
        }
        
        // Get current user
        $user_id = get_current_user_id();
        
        // Generate version number
        $last_version = $this->wpdb->get_var($this->wpdb->prepare(
            "SELECT version_number FROM {$version_table} 
             WHERE config_type = 'admin_menu' AND config_id = %d 
             ORDER BY id DESC LIMIT 1",
            $menu_id
        ));
        
        $version_parts = $last_version ? explode('.', $last_version) : ['1', '0', '0'];
        $version_parts[2] = intval($version_parts[2]) + 1;
        $new_version = implode('.', $version_parts);
        
        // Insert version record
        $this->wpdb->insert(
            $version_table,
            [
                'config_type' => 'admin_menu',
                'config_id' => $menu_id,
                'version_number' => $new_version,
                'config_data' => json_encode($data),
                'changed_by' => $user_id,
                'change_note' => "Action: {$action}"
            ],
            ['%s', '%d', '%s', '%s', '%d', '%s']
        );
    }
    
    /**
     * Get all menus (including inactive)
     */
    public function get_all_menus() {
        return $this->wpdb->get_results(
            "SELECT * FROM {$this->table_name} 
             ORDER BY sort_order ASC, id ASC"
        );
    }
    
    /**
     * Toggle menu active status
     */
    public function toggle_menu($id) {
        $menu = $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT is_active FROM {$this->table_name} WHERE id = %d",
            $id
        ));
        
        if (!$menu) {
            return new WP_Error('menu_not_found', 'Menu not found');
        }
        
        $new_status = !$menu->is_active;
        
        $result = $this->wpdb->update(
            $this->table_name,
            ['is_active' => $new_status],
            ['id' => $id],
            ['%d'],
            ['%d']
        );
        
        if ($result !== false) {
            $this->clear_cache();
            return $new_status;
        }
        
        return new WP_Error('toggle_failed', 'Failed to toggle menu status');
    }
    
    /**
     * AJAX handler for updating menu
     */
    public function ajax_update_menu() {
        check_ajax_referer('virical_menu_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $id = intval($_POST['id']);
        $data = [
            'menu_title' => sanitize_text_field($_POST['menu_title']),
            'page_title' => sanitize_text_field($_POST['page_title']),
            'capability' => sanitize_text_field($_POST['capability']),
            'sort_order' => intval($_POST['sort_order'])
        ];
        
        $result = $this->update_menu($id, $data);
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } else {
            wp_send_json_success('Menu updated successfully');
        }
    }
    
    /**
     * AJAX handler for toggling menu
     */
    public function ajax_toggle_menu() {
        check_ajax_referer('virical_menu_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $id = intval($_POST['id']);
        $result = $this->toggle_menu($id);
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } else {
            wp_send_json_success(['new_status' => $result]);
        }
    }
    
    /**
     * AJAX handler for deleting menu
     */
    public function ajax_delete_menu() {
        check_ajax_referer('virical_menu_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $id = intval($_POST['id']);
        $result = $this->delete_menu($id);
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } else {
            wp_send_json_success('Menu deleted successfully');
        }
    }
}

// Initialize the manager
add_action('init', function() {
    ViricalAdminMenuManager::get_instance();
});