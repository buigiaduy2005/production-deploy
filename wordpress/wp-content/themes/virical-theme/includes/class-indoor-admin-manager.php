<?php
/**
 * Indoor Admin Manager Class
 * Handles all admin functionality for Indoor page
 * 
 * @package Virical
 */

if (!defined('ABSPATH')) {
    exit;
}

class Indoor_Admin_Manager {
    
    private $wpdb;
    private $settings_table;
    private $categories_table;
    private $products_table;
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->settings_table = $wpdb->prefix . 'indoor_page_settings';
        $this->categories_table = $wpdb->prefix . 'indoor_product_categories';
        $this->products_table = $wpdb->prefix . 'indoor_products';
        
        // Add hooks
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        
        // AJAX handlers
        add_action('wp_ajax_save_indoor_settings', [$this, 'ajax_save_settings']);
        add_action('wp_ajax_save_indoor_category', [$this, 'ajax_save_category']);
        add_action('wp_ajax_delete_indoor_category', [$this, 'ajax_delete_category']);
        add_action('wp_ajax_save_indoor_product', [$this, 'ajax_save_product']);
        add_action('wp_ajax_delete_indoor_product', [$this, 'ajax_delete_product']);
        add_action('wp_ajax_reorder_indoor_items', [$this, 'ajax_reorder_items']);
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'Indoor Management',
            'Indoor Page',
            'manage_options',
            'indoor-management',
            [$this, 'render_admin_page'],
            'dashicons-lightbulb',
            30
        );
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_indoor-management') {
            return;
        }
        
        // Enqueue WordPress media uploader
        wp_enqueue_media();
        
        // Enqueue jQuery UI for sortable
        wp_enqueue_script('jquery-ui-sortable');
        
        // Custom admin styles
        wp_enqueue_style('indoor-admin-styles', get_template_directory_uri() . '/assets/css/indoor-admin.css', [], '1.0.0');
        
        // Custom admin scripts
        wp_enqueue_script('indoor-admin-scripts', get_template_directory_uri() . '/assets/js/indoor-admin.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', true);
        
        // Localize script
        wp_localize_script('indoor-admin-scripts', 'indoor_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('indoor_admin_nonce')
        ]);
    }
    
    /**
     * Render main admin page
     */
    public function render_admin_page() {
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'settings';
        ?>
        <div class="wrap indoor-admin-wrap">
            <h1>Indoor Page Management</h1>
            
            <nav class="nav-tab-wrapper">
                <a href="?page=indoor-management&tab=settings" 
                   class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">
                    Settings
                </a>
                <a href="?page=indoor-management&tab=categories" 
                   class="nav-tab <?php echo $active_tab == 'categories' ? 'nav-tab-active' : ''; ?>">
                    Categories
                </a>
                <a href="?page=indoor-management&tab=products" 
                   class="nav-tab <?php echo $active_tab == 'products' ? 'nav-tab-active' : ''; ?>">
                    Products
                </a>
            </nav>
            
            <div class="tab-content">
                <?php
                switch ($active_tab) {
                    case 'settings':
                        $this->render_settings_tab();
                        break;
                    case 'categories':
                        $this->render_categories_tab();
                        break;
                    case 'products':
                        $this->render_products_tab();
                        break;
                }
                ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render Settings Tab
     */
    private function render_settings_tab() {
        // Get current settings
        $settings = $this->wpdb->get_results("SELECT * FROM {$this->settings_table}", OBJECT_K);
        $settings_array = [];
        foreach ($settings as $setting) {
            $settings_array[$setting->setting_key] = $setting->setting_value;
        }
        ?>
        <div class="indoor-settings-tab">
            <h2>Page Settings</h2>
            
            <form id="indoor-settings-form">
                <table class="form-table">
                    <tr>
                        <th><label for="page_title">Page Title</label></th>
                        <td>
                            <input type="text" id="page_title" name="page_title" 
                                   value="<?php echo esc_attr($settings_array['page_title'] ?? ''); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label for="page_subtitle">Page Subtitle</label></th>
                        <td>
                            <input type="text" id="page_subtitle" name="page_subtitle" 
                                   value="<?php echo esc_attr($settings_array['page_subtitle'] ?? ''); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label for="banner_image">Banner Image</label></th>
                        <td>
                            <div class="image-upload-container">
                                <input type="hidden" id="banner_image" name="banner_image" 
                                       value="<?php echo esc_attr($settings_array['banner_image'] ?? ''); ?>" />
                                
                                <div id="banner-preview" class="image-preview">
                                    <?php if (!empty($settings_array['banner_image'])): ?>
                                        <img src="<?php echo esc_url($settings_array['banner_image']); ?>" alt="Banner" />
                                    <?php endif; ?>
                                </div>
                                
                                <button type="button" class="button upload-image-btn" 
                                        data-target="#banner_image" 
                                        data-preview="#banner-preview">
                                    Choose Image
                                </button>
                                
                                <button type="button" class="button remove-image-btn" 
                                        data-target="#banner_image" 
                                        data-preview="#banner-preview">
                                    Remove Image
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label for="meta_title">Meta Title</label></th>
                        <td>
                            <input type="text" id="meta_title" name="meta_title" 
                                   value="<?php echo esc_attr($settings_array['meta_title'] ?? ''); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label for="meta_description">Meta Description</label></th>
                        <td>
                            <textarea id="meta_description" name="meta_description" 
                                      rows="3" class="large-text"><?php echo esc_textarea($settings_array['meta_description'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <button type="submit" class="button button-primary">Save Settings</button>
                    <span class="spinner"></span>
                    <span class="notice-message"></span>
                </p>
            </form>
        </div>
        <?php
    }
    
    /**
     * Render Categories Tab
     */
    private function render_categories_tab() {
        $categories = $this->wpdb->get_results("
            SELECT * FROM {$this->categories_table} 
            ORDER BY display_order ASC
        ");
        ?>
        <div class="indoor-categories-tab">
            <h2>Categories Management</h2>
            
            <div class="category-form-container">
                <h3 id="category-form-title">Add New Category</h3>
                
                <form id="indoor-category-form">
                    <input type="hidden" id="category_id" name="category_id" value="" />
                    
                    <table class="form-table">
                        <tr>
                            <th><label for="category_name">Category Name *</label></th>
                            <td>
                                <input type="text" id="category_name" name="category_name" 
                                       class="regular-text" required />
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="category_slug">Slug</label></th>
                            <td>
                                <input type="text" id="category_slug" name="category_slug" 
                                       class="regular-text" />
                                <p class="description">Leave empty to auto-generate from name</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="is_active">Status</label></th>
                            <td>
                                <select id="is_active" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    
                    <p class="submit">
                        <button type="submit" class="button button-primary">Save Category</button>
                        <button type="button" class="button cancel-edit-btn">Cancel</button>
                        <span class="spinner"></span>
                        <span class="notice-message"></span>
                    </p>
                </form>
            </div>
            
            <div class="categories-list-container">
                <h3>Existing Categories</h3>
                
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th width="50">Order</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th width="100">Products</th>
                            <th width="100">Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categories-list" class="sortable-list">
                        <?php foreach ($categories as $category): ?>
                            <?php
                            $product_count = $this->wpdb->get_var($this->wpdb->prepare(
                                "SELECT COUNT(*) FROM {$this->products_table} WHERE category_id = %d",
                                $category->id
                            ));
                            ?>
                            <tr data-id="<?php echo $category->id; ?>" class="sortable-item">
                                <td class="drag-handle">☰</td>
                                <td><?php echo esc_html($category->category_name); ?></td>
                                <td><?php echo esc_html($category->category_slug); ?></td>
                                <td><?php echo $product_count; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $category->is_active ? 'active' : 'inactive'; ?>">
                                        <?php echo $category->is_active ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="button button-small edit-category-btn" 
                                            data-id="<?php echo $category->id; ?>"
                                            data-name="<?php echo esc_attr($category->category_name); ?>"
                                            data-slug="<?php echo esc_attr($category->category_slug); ?>"
                                            data-active="<?php echo $category->is_active; ?>">
                                        Edit
                                    </button>
                                    <button class="button button-small delete-category-btn" 
                                            data-id="<?php echo $category->id; ?>"
                                            data-count="<?php echo $product_count; ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render Products Tab
     */
    private function render_products_tab() {
        // Get categories for dropdown
        $categories = $this->wpdb->get_results("
            SELECT * FROM {$this->categories_table} 
            WHERE is_active = 1 
            ORDER BY display_order ASC
        ");
        
        // Get products with category names
        $products = $this->wpdb->get_results("
            SELECT p.*, c.category_name 
            FROM {$this->products_table} p
            LEFT JOIN {$this->categories_table} c ON p.category_id = c.id
            ORDER BY c.display_order ASC, p.display_order ASC
        ");
        ?>
        <div class="indoor-products-tab">
            <h2>Products Management</h2>
            
            <div class="product-form-container">
                <h3 id="product-form-title">Add New Product</h3>
                
                <form id="indoor-product-form">
                    <input type="hidden" id="product_id" name="product_id" value="" />
                    
                    <table class="form-table">
                        <tr>
                            <th><label for="product_category">Category *</label></th>
                            <td>
                                <select id="product_category" name="category_id" required>
                                    <option value="">-- Select Category --</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category->id; ?>">
                                            <?php echo esc_html($category->category_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="product_name">Product Name *</label></th>
                            <td>
                                <input type="text" id="product_name" name="product_name" 
                                       class="regular-text" required />
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="product_slug">Slug</label></th>
                            <td>
                                <input type="text" id="product_slug" name="product_slug" 
                                       class="regular-text" />
                                <p class="description">Leave empty to auto-generate from name</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="product_link">Product Link</label></th>
                            <td>
                                <input type="url" id="product_link" name="product_link" 
                                       class="regular-text" placeholder="https://..." />
                                <p class="description">Link to product detail page (optional)</p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="product_image">Product Image</label></th>
                            <td>
                                <div class="image-upload-container">
                                    <input type="hidden" id="product_image" name="product_image" value="" />
                                    
                                    <div id="product-preview" class="image-preview"></div>
                                    
                                    <button type="button" class="button upload-image-btn" 
                                            data-target="#product_image" 
                                            data-preview="#product-preview">
                                        Choose Image
                                    </button>
                                    
                                    <button type="button" class="button remove-image-btn" 
                                            data-target="#product_image" 
                                            data-preview="#product-preview">
                                        Remove Image
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th><label for="product_active">Status</label></th>
                            <td>
                                <select id="product_active" name="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    
                    <p class="submit">
                        <button type="submit" class="button button-primary">Save Product</button>
                        <button type="button" class="button cancel-edit-btn">Cancel</button>
                        <span class="spinner"></span>
                        <span class="notice-message"></span>
                    </p>
                </form>
            </div>
            
            <div class="products-list-container">
                <h3>Existing Products</h3>
                
                <div class="products-filter">
                    <select id="category-filter">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>">
                                <?php echo esc_html($category->category_name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th width="50">Order</th>
                            <th width="80">Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Link</th>
                            <th width="100">Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="products-list" class="sortable-list">
                        <?php foreach ($products as $product): ?>
                            <tr data-id="<?php echo $product->id; ?>" 
                                data-category="<?php echo $product->category_id; ?>" 
                                class="sortable-item product-row">
                                <td class="drag-handle">☰</td>
                                <td>
                                    <?php if ($product->product_image): ?>
                                        <img src="<?php echo esc_url($product->product_image); ?>" 
                                             alt="<?php echo esc_attr($product->product_name); ?>"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <span class="no-image">No image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo esc_html($product->product_name); ?></td>
                                <td><?php echo esc_html($product->category_name); ?></td>
                                <td>
                                    <?php if ($product->product_link && $product->product_link !== '#'): ?>
                                        <a href="<?php echo esc_url($product->product_link); ?>" target="_blank">
                                            View →
                                        </a>
                                    <?php else: ?>
                                        <span class="no-link">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $product->is_active ? 'active' : 'inactive'; ?>">
                                        <?php echo $product->is_active ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="button button-small edit-product-btn" 
                                            data-id="<?php echo $product->id; ?>"
                                            data-category="<?php echo $product->category_id; ?>"
                                            data-name="<?php echo esc_attr($product->product_name); ?>"
                                            data-slug="<?php echo esc_attr($product->product_slug); ?>"
                                            data-link="<?php echo esc_attr($product->product_link); ?>"
                                            data-image="<?php echo esc_attr($product->product_image); ?>"
                                            data-active="<?php echo $product->is_active; ?>">
                                        Edit
                                    </button>
                                    <button class="button button-small delete-product-btn" 
                                            data-id="<?php echo $product->id; ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    
    /**
     * AJAX: Save Settings
     */
    public function ajax_save_settings() {
        // Check nonce
        if (!wp_verify_nonce($_POST['nonce'], 'indoor_admin_nonce')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Permission denied');
        }
        
        $settings = [
            'page_title' => sanitize_text_field($_POST['page_title']),
            'page_subtitle' => sanitize_text_field($_POST['page_subtitle']),
            'banner_image' => esc_url_raw($_POST['banner_image']),
            'meta_title' => sanitize_text_field($_POST['meta_title']),
            'meta_description' => sanitize_textarea_field($_POST['meta_description'])
        ];
        
        foreach ($settings as $key => $value) {
            $this->wpdb->replace(
                $this->settings_table,
                [
                    'setting_key' => $key,
                    'setting_value' => $value,
                    'setting_type' => ($key === 'banner_image') ? 'image' : 'text'
                ]
            );
        }
        
        wp_send_json_success(['message' => 'Settings saved successfully']);
    }
    
    /**
     * AJAX: Save Category
     */
    public function ajax_save_category() {
        // Check nonce
        if (!wp_verify_nonce($_POST['nonce'], 'indoor_admin_nonce')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Permission denied');
        }
        
        $category_id = intval($_POST['category_id']);
        $category_name = sanitize_text_field($_POST['category_name']);
        $category_slug = sanitize_title($_POST['category_slug']);
        $is_active = intval($_POST['is_active']);
        
        // Auto-generate slug if empty
        if (empty($category_slug)) {
            $category_slug = sanitize_title($category_name);
        }
        
        $data = [
            'category_name' => $category_name,
            'category_slug' => $category_slug,
            'is_active' => $is_active
        ];
        
        if ($category_id > 0) {
            // Update existing
            $this->wpdb->update(
                $this->categories_table,
                $data,
                ['id' => $category_id]
            );
            $message = 'Category updated successfully';
        } else {
            // Get max display order
            $max_order = $this->wpdb->get_var("SELECT MAX(display_order) FROM {$this->categories_table}");
            $data['display_order'] = ($max_order + 1);
            
            // Insert new
            $this->wpdb->insert($this->categories_table, $data);
            $message = 'Category added successfully';
        }
        
        wp_send_json_success(['message' => $message]);
    }
    
    /**
     * AJAX: Delete Category
     */
    public function ajax_delete_category() {
        // Check nonce
        if (!wp_verify_nonce($_POST['nonce'], 'indoor_admin_nonce')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Permission denied');
        }
        
        $category_id = intval($_POST['category_id']);
        
        // Check if category has products
        $product_count = $this->wpdb->get_var($this->wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->products_table} WHERE category_id = %d",
            $category_id
        ));
        
        if ($product_count > 0) {
            wp_send_json_error(['message' => 'Cannot delete category with products. Please delete or reassign products first.']);
            return;
        }
        
        $this->wpdb->delete($this->categories_table, ['id' => $category_id]);
        
        wp_send_json_success(['message' => 'Category deleted successfully']);
    }
    
    /**
     * AJAX: Save Product
     */
    public function ajax_save_product() {
        // Check nonce
        if (!wp_verify_nonce($_POST['nonce'], 'indoor_admin_nonce')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Permission denied');
        }
        
        $product_id = intval($_POST['product_id']);
        $category_id = intval($_POST['category_id']);
        $product_name = sanitize_text_field($_POST['product_name']);
        $product_slug = sanitize_title($_POST['product_slug']);
        $product_link = esc_url_raw($_POST['product_link']);
        $product_image = esc_url_raw($_POST['product_image']);
        $is_active = intval($_POST['is_active']);
        
        // Auto-generate slug if empty
        if (empty($product_slug)) {
            $product_slug = sanitize_title($product_name);
        }
        
        $data = [
            'category_id' => $category_id,
            'product_name' => $product_name,
            'product_slug' => $product_slug,
            'product_link' => $product_link,
            'product_image' => $product_image,
            'is_active' => $is_active
        ];
        
        if ($product_id > 0) {
            // Update existing
            $this->wpdb->update(
                $this->products_table,
                $data,
                ['id' => $product_id]
            );
            $message = 'Product updated successfully';
        } else {
            // Get max display order for this category
            $max_order = $this->wpdb->get_var($this->wpdb->prepare(
                "SELECT MAX(display_order) FROM {$this->products_table} WHERE category_id = %d",
                $category_id
            ));
            $data['display_order'] = ($max_order + 1);
            
            // Insert new
            $this->wpdb->insert($this->products_table, $data);
            $message = 'Product added successfully';
        }
        
        wp_send_json_success(['message' => $message]);
    }
    
    /**
     * AJAX: Delete Product
     */
    public function ajax_delete_product() {
        // Check nonce
        if (!wp_verify_nonce($_POST['nonce'], 'indoor_admin_nonce')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Permission denied');
        }
        
        $product_id = intval($_POST['product_id']);
        
        $this->wpdb->delete($this->products_table, ['id' => $product_id]);
        
        wp_send_json_success(['message' => 'Product deleted successfully']);
    }
    
    /**
     * AJAX: Reorder Items
     */
    public function ajax_reorder_items() {
        // Check nonce
        if (!wp_verify_nonce($_POST['nonce'], 'indoor_admin_nonce')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Permission denied');
        }
        
        $type = sanitize_text_field($_POST['type']);
        $order = $_POST['order']; // Array of IDs
        
        $table = ($type === 'category') ? $this->categories_table : $this->products_table;
        
        foreach ($order as $position => $id) {
            $this->wpdb->update(
                $table,
                ['display_order' => $position],
                ['id' => intval($id)]
            );
        }
        
        wp_send_json_success(['message' => 'Order updated successfully']);
    }
}

// Initialize the class
new Indoor_Admin_Manager();