<?php
/**
 * Virical Navigation Manager Class
 * 
 * Manages navigation menus from database
 * 
 * @package Virical
 * @version 1.0.0
 * @since 2025-09-10
 */

if (!defined('ABSPATH')) {
    exit;
}

class ViricalNavigationManager {
    
    /**
     * Database connection
     * @var wpdb
     */
    private $wpdb;
    
    /**
     * Table name
     * @var string
     */
    private $table_name;
    
    /**
     * Cache key for navigation menus
     * @var string
     */
    private $cache_key = 'virical_navigation_menus';
    
    /**
     * Cache TTL in seconds
     * @var int
     */
    private $cache_ttl = 3600; // 1 hour
    
    /**
     * Constructor
     */
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'virical_navigation_menus';
    }
    
    /**
     * Initialize the navigation manager
     */
    public function init() {
        // Register nav menu locations
        add_action('after_setup_theme', array($this, 'register_nav_locations'));
        
        // DISABLED: Filter for nav menu fallback to prevent duplicate menus
        // add_filter('wp_nav_menu_args', array($this, 'set_database_fallback'));
        
        // Admin hooks
        if (is_admin()) {
//             add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('wp_ajax_virical_save_nav_item', array($this, 'ajax_save_nav_item'));
            add_action('wp_ajax_virical_delete_nav_item', array($this, 'ajax_delete_nav_item'));
            add_action('wp_ajax_virical_reorder_nav_items', array($this, 'ajax_reorder_nav_items'));
        }
    }
    
    /**
     * Register navigation menu locations
     */
    public function register_nav_locations() {
        register_nav_menus(array(
            'primary' => 'Primary Navigation',
            'footer' => 'Footer Navigation',
            'mobile' => 'Mobile Navigation'
        ));
    }
    
    /**
     * Set database fallback for navigation menus
     * 
     * @param array $args Navigation menu arguments
     * @return array Modified arguments
     */
    public function set_database_fallback($args) {
        // Only set fallback if no menu is assigned
        if (empty($args['theme_location'])) {
            return $args;
        }
        
        $locations = get_nav_menu_locations();
        
        // If no menu assigned to this location, use database fallback
        if (empty($locations[$args['theme_location']])) {
            $args['fallback_cb'] = array($this, 'render_database_menu');
            $args['menu_location'] = $args['theme_location'];
        }
        
        return $args;
    }
    
    /**
     * Get navigation menu items from database
     * 
     * @param string $location Menu location
     * @param int $parent_id Parent menu item ID
     * @return array Menu items
     */
    public function get_database_menu($location, $parent_id = null) {
        // Check cache first
        $cache_key = $this->cache_key . '_' . $location . '_' . ($parent_id ?: '0');
        $cached = wp_cache_get($cache_key);
        
        if ($cached !== false) {
            return $cached;
        }
        
        // Build query
        $where = "menu_location = %s AND is_active = 1";
        $params = array($location);
        
        if ($parent_id === null) {
            $where .= " AND parent_id IS NULL";
        } else {
            $where .= " AND parent_id = %d";
            $params[] = $parent_id;
        }
        
        // Query database
        $query = $this->wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE {$where} ORDER BY sort_order ASC",
            $params
        );
        
        $menu_items = $this->wpdb->get_results($query);
        
        // Process menu items
        foreach ($menu_items as &$item) {
            // Decode meta data
            $item->meta_data = json_decode($item->meta_data, true);
            
            // Get children
            $item->children = $this->get_database_menu($location, $item->id);
        }
        
        // Cache the result
        wp_cache_set($cache_key, $menu_items, '', $this->cache_ttl);
        
        return $menu_items;
    }
    
    /**
     * Render database menu as fallback
     * 
     * @param array $args Menu arguments
     */
    public function render_database_menu($args) {
        $location = isset($args['menu_location']) ? $args['menu_location'] : 'primary';
        $menu_items = $this->get_database_menu($location);
        
        if (empty($menu_items)) {
            return;
        }
        
        // Start menu wrapper
        $menu_class = isset($args['menu_class']) ? $args['menu_class'] : 'menu';
        $menu_id = isset($args['menu_id']) ? $args['menu_id'] : '';
        
        echo '<ul';
        if ($menu_id) {
            echo ' id="' . esc_attr($menu_id) . '"';
        }
        echo ' class="' . esc_attr($menu_class) . '">';
        
        // Render menu items
        $this->render_menu_items($menu_items, $args);
        
        // End menu wrapper
        echo '</ul>';
    }
    
    /**
     * Render menu items recursively
     * 
     * @param array $items Menu items
     * @param array $args Menu arguments
     * @param int $depth Current depth
     */
    private function render_menu_items($items, $args, $depth = 0) {
        // AGGRESSIVE DEBUG: Attempt to flush any object cache.
        wp_cache_flush();

        foreach ($items as $item) {
            // Use a more flexible check for the item title.
            $is_product_menu = (isset($item->item_title) && trim($item->item_title) === 'Sản phẩm');

            $classes = array('menu-item');
            if (!empty($item->item_classes)) { $classes[] = $item->item_classes; }
            if ($this->is_current_page($item->item_url)) { $classes[] = 'current-menu-item'; }
            if (!empty($item->children) || $is_product_menu) { $classes[] = 'menu-item-has-children'; }
            if ($is_product_menu) { $classes[] = 'dropdown'; }
            
            echo '<li class="' . esc_attr(implode(' ', $classes)) . '">';
            echo '<a href="' . esc_url($item->item_url) . '">';
            if ($item->item_icon) { echo '<i class="' . esc_attr($item->item_icon) . '"></i> '; }
            echo esc_html($item->item_title);
            if ($is_product_menu) { echo ' <span class="caret"></span>'; }
            echo '</a>';
            
            // FINAL ATTEMPT: INJECT HARDCODED DROPDOWN
            if ($is_product_menu) {
                echo '<div class="dropdown-content">';
                echo '<a href="#" class="dropdown-item"><img src="https://via.placeholder.com/50" class="icon"><span>Test Item 1</span></a>';
                echo '<a href="#" class="dropdown-item"><img src="https://via.placeholder.com/50" class="icon"><span>Test Item 2</span></a>';
                echo '<a href="#" class="dropdown-item"><img src="https://via.placeholder.com/50" class="icon"><span>Test Item 3</span></a>';
                echo '</div>';
            }
            
            if (!empty($item->children)) {
                echo '<ul class="sub-menu">';
                $this->render_menu_items($item->children, $args, $depth + 1);
                echo '</ul>';
            }
            
            echo '</li>';
        }
    }
    
    /**
     * Check if URL is current page
     * 
     * @param string $url Menu item URL
     * @return bool
     */
    private function is_current_page($url) {
        $current_url = home_url(add_query_arg(array(), $_SERVER['REQUEST_URI']));
        $item_url = home_url($url);
        
        // Exact match
        if ($current_url === $item_url) {
            return true;
        }
        
        // Check if current URL starts with item URL (for parent items)
        if (strpos($current_url, $item_url) === 0 && $url !== '/') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Add admin menu for navigation management
     */
    public function add_admin_menu() {
        add_submenu_page(
            'virical-settings',
            'Navigation Manager',
            'Navigation Manager',
            'manage_options',
            'virical-navigation-manager',
            array($this, 'render_admin_page')
        );
    }
    
    /**
     * Render admin page
     */
    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1>Navigation Manager</h1>
            <p>Manage your navigation menus from the database.</p>
            
            <div class="nav-tabs-wrapper">
                <h2 class="nav-tab-wrapper">
                    <a href="#primary" class="nav-tab nav-tab-active">Primary Menu</a>
                    <a href="#footer" class="nav-tab">Footer Menu</a>
                    <a href="#mobile" class="nav-tab">Mobile Menu</a>
                </h2>
            </div>
            
            <div id="primary-menu" class="menu-editor">
                <?php $this->render_menu_editor('primary'); ?>
            </div>
            
            <div id="footer-menu" class="menu-editor" style="display:none;">
                <?php $this->render_menu_editor('footer'); ?>
            </div>
            
            <div id="mobile-menu" class="menu-editor" style="display:none;">
                <?php $this->render_menu_editor('mobile'); ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render menu editor for a location
     * 
     * @param string $location Menu location
     */
    private function render_menu_editor($location) {
        $menu_items = $this->get_database_menu($location);
        
        echo '<div class="menu-items" data-location="' . esc_attr($location) . '">';
        
        if ($menu_items) {
            echo '<ul class="sortable">';
            foreach ($menu_items as $item) {
                $this->render_menu_item_editor($item);
            }
            echo '</ul>';
        } else {
            echo '<p>No menu items found for this location.</p>';
        }
        
        echo '<button class="button button-primary add-menu-item">Add Menu Item</button>';
        echo '</div>';
    }
    
    /**
     * Render menu item editor
     * 
     * @param object $item Menu item
     */
    private function render_menu_item_editor($item) {
        ?>
        <li class="menu-item" data-id="<?php echo esc_attr($item->id); ?>">
            <div class="menu-item-bar">
                <div class="menu-item-handle">
                    <span class="item-title"><?php echo esc_html($item->item_title); ?></span>
                    <span class="item-controls">
                        <button class="edit-menu-item">Edit</button>
                        <button class="delete-menu-item">Delete</button>
                    </span>
                </div>
            </div>
            <div class="menu-item-settings" style="display:none;">
                <input type="text" class="item-title-input" value="<?php echo esc_attr($item->item_title); ?>" placeholder="Title">
                <input type="text" class="item-url-input" value="<?php echo esc_attr($item->item_url); ?>" placeholder="URL">
                <input type="text" class="item-classes-input" value="<?php echo esc_attr($item->item_classes); ?>" placeholder="CSS Classes">
                <button class="button save-menu-item">Save</button>
            </div>
            <?php if (!empty($item->children)): ?>
                <ul class="sub-menu sortable">
                    <?php foreach ($item->children as $child): ?>
                        <?php $this->render_menu_item_editor($child); ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
        <?php
    }
    
    /**
     * Clear navigation cache
     * 
     * @param string $location Optional specific location to clear
     */
    public function clear_cache($location = null) {
        if ($location) {
            wp_cache_delete($this->cache_key . '_' . $location . '_0');
        } else {
            // Clear all navigation cache
            wp_cache_flush();
        }
    }
    
    /**
     * AJAX handler to save navigation item
     */
    public function ajax_save_nav_item() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Validate nonce
        check_ajax_referer('virical_nav_nonce', 'nonce');
        
        // Get item data
        $item_data = array(
            'menu_location' => sanitize_text_field($_POST['menu_location']),
            'parent_id' => !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : null,
            'item_title' => sanitize_text_field($_POST['item_title']),
            'item_url' => esc_url_raw($_POST['item_url']),
            'item_target' => sanitize_text_field($_POST['item_target']),
            'item_classes' => sanitize_text_field($_POST['item_classes']),
            'item_icon' => sanitize_text_field($_POST['item_icon']),
            'item_description' => sanitize_text_field($_POST['item_description']),
            'is_active' => intval($_POST['is_active']),
            'sort_order' => intval($_POST['sort_order'])
        );
        
        // Save to database
        if (isset($_POST['item_id']) && $_POST['item_id']) {
            // Update existing
            $result = $this->wpdb->update(
                $this->table_name,
                $item_data,
                array('id' => intval($_POST['item_id']))
            );
        } else {
            // Insert new
            $item_data['meta_data'] = json_encode(array(
                'created_by' => get_current_user_id(),
                'created_at' => current_time('mysql')
            ));
            $result = $this->wpdb->insert($this->table_name, $item_data);
        }
        
        // Clear cache
        $this->clear_cache($item_data['menu_location']);
        
        wp_send_json_success(array('message' => 'Menu item saved successfully'));
    }
    
    /**
     * AJAX handler to delete navigation item
     */
    public function ajax_delete_nav_item() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Validate nonce
        check_ajax_referer('virical_nav_nonce', 'nonce');
        
        $item_id = intval($_POST['item_id']);
        
        // Get item location for cache clearing
        $item = $this->wpdb->get_row(
            $this->wpdb->prepare(
                "SELECT menu_location FROM {$this->table_name} WHERE id = %d",
                $item_id
            )
        );
        
        // Delete from database (children will be deleted by CASCADE)
        $result = $this->wpdb->delete(
            $this->table_name,
            array('id' => $item_id)
        );
        
        // Clear cache
        if ($item) {
            $this->clear_cache($item->menu_location);
        }
        
        wp_send_json_success(array('message' => 'Menu item deleted successfully'));
    }
    
    /**
     * AJAX handler to reorder navigation items
     */
    public function ajax_reorder_nav_items() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Validate nonce
        check_ajax_referer('virical_nav_nonce', 'nonce');
        
        $order = $_POST['order'];
        $location = sanitize_text_field($_POST['menu_location']);
        
        // Update sort order for each item
        foreach ($order as $position => $item_id) {
            $this->wpdb->update(
                $this->table_name,
                array('sort_order' => $position),
                array('id' => intval($item_id))
            );
        }
        
        // Clear cache
        $this->clear_cache($location);
        
        wp_send_json_success(array('message' => 'Menu order updated successfully'));
    }
    
    /**
     * Get navigation menu fallback function
     * For use in templates
     * 
     * @param string $location Menu location
     * @return callable
     */
    public function get_fallback_callback($location) {
        return function($args) use ($location) {
            $args['menu_location'] = $location;
            $this->render_database_menu($args);
        };
    }
}