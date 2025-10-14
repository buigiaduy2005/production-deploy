<?php
/**
 * Outdoor Admin Manager Class
 * Handles all admin functionality for Outdoor page
 * 
 * @package Virical
 */

if (!defined('ABSPATH')) {
    exit;
}

class Outdoor_Admin_Manager {
    
    private $wpdb;
    private $sections_table;
    private $products_table;
    private $settings_table;
    
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->sections_table = $wpdb->prefix . 'outdoor_sections';
        $this->products_table = $wpdb->prefix . 'outdoor_page_products';
        $this->settings_table = $wpdb->prefix . 'outdoor_page_settings';
        
        // Add hooks
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        
        // AJAX handlers
        add_action('wp_ajax_save_outdoor_settings', [$this, 'ajax_save_settings']);
        add_action('wp_ajax_save_outdoor_section', [$this, 'ajax_save_section']);
        add_action('wp_ajax_delete_outdoor_section', [$this, 'ajax_delete_section']);
        add_action('wp_ajax_save_outdoor_product', [$this, 'ajax_save_product']);
        add_action('wp_ajax_delete_outdoor_product', [$this, 'ajax_delete_product']);
        add_action('wp_ajax_reorder_outdoor_items', [$this, 'ajax_reorder_items']);
        add_action('wp_ajax_upload_outdoor_image', [$this, 'ajax_upload_image']);
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'Outdoor Management',
            'Outdoor Page',
            'manage_options',
            'outdoor-management',
            [$this, 'render_admin_page'],
            'dashicons-palmtree',
            31
        );
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_outdoor-management') {
            return;
        }
        
        // Enqueue WordPress media uploader
        wp_enqueue_media();
        
        // Enqueue jQuery UI for sortable
        wp_enqueue_script('jquery-ui-sortable');
        
        // Custom admin styles
        wp_enqueue_style('outdoor-admin-styles', get_template_directory_uri() . '/assets/css/outdoor-admin.css', [], '1.0.0');
        
        // Custom admin scripts
        wp_enqueue_script('outdoor-admin-scripts', get_template_directory_uri() . '/assets/js/outdoor-admin.js', ['jquery', 'jquery-ui-sortable'], '1.0.0', true);
        
        // Localize script
        wp_localize_script('outdoor-admin-scripts', 'outdoor_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('outdoor_admin_nonce'),
            'upload_url' => admin_url('async-upload.php'),
            'uploads_base_url' => wp_upload_dir()['baseurl']
        ]);
    }
    
    /**
     * Render main admin page
     */
    public function render_admin_page() {
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'settings';
        ?>
        <div class="wrap outdoor-admin-wrap">
            <h1><span class="dashicons dashicons-palmtree"></span> Outdoor Page Management</h1>
            
            <nav class="nav-tab-wrapper">
                <a href="?page=outdoor-management&tab=settings" 
                   class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-admin-generic"></span> Settings
                </a>
                <a href="?page=outdoor-management&tab=sections" 
                   class="nav-tab <?php echo $active_tab == 'sections' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-category"></span> Sections
                </a>
                <a href="?page=outdoor-management&tab=products" 
                   class="nav-tab <?php echo $active_tab == 'products' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-products"></span> Products
                </a>
                <a href="?page=outdoor-management&tab=layout" 
                   class="nav-tab <?php echo $active_tab == 'layout' ? 'nav-tab-active' : ''; ?>">
                    <span class="dashicons dashicons-layout"></span> Layout
                </a>
            </nav>
            
            <div class="tab-content">
                <?php
                switch($active_tab) {
                    case 'sections':
                        $this->render_sections_tab();
                        break;
                    case 'products':
                        $this->render_products_tab();
                        break;
                    case 'layout':
                        $this->render_layout_tab();
                        break;
                    default:
                        $this->render_settings_tab();
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
        $settings = $this->get_all_settings();
        ?>
        <div class="outdoor-settings-container">
            <h2>Page Settings</h2>
            
            <form id="outdoor-settings-form">
                <table class="form-table">
                    <tr>
                        <th><label for="page_title">Page Title</label></th>
                        <td>
                            <input type="text" id="page_title" name="page_title" 
                                   value="<?php echo esc_attr($settings['page_title'] ?? ''); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label for="banner_image">Banner Image</label></th>
                        <td>
                            <div class="image-upload-container">
                                <input type="hidden" id="banner_image" name="banner_image" 
                                       value="<?php echo esc_attr($settings['banner_image'] ?? ''); ?>" />
                                <div id="banner_image_preview" class="image-preview">
                                    <?php if (!empty($settings['banner_image'])): ?>
                                        <img src="<?php echo esc_url($settings['banner_image']); ?>" />
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="button upload-image-btn" data-field="banner_image">
                                    Upload Image
                                </button>
                                <button type="button" class="button remove-image-btn" data-field="banner_image" 
                                        <?php echo empty($settings['banner_image']) ? 'style="display:none;"' : ''; ?>>
                                    Remove
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label for="meta_description">Meta Description</label></th>
                        <td>
                            <textarea id="meta_description" name="meta_description" 
                                      rows="3" class="large-text"><?php echo esc_textarea($settings['meta_description'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label for="show_cta_button">Show CTA Button</label></th>
                        <td>
                            <input type="checkbox" id="show_cta_button" name="show_cta_button" value="1" 
                                   <?php checked(($settings['show_cta_button'] ?? '0'), '1'); ?> />
                            <label for="show_cta_button">Display call-to-action button at bottom of page</label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label for="cta_button_text">CTA Button Text</label></th>
                        <td>
                            <input type="text" id="cta_button_text" name="cta_button_text" 
                                   value="<?php echo esc_attr($settings['cta_button_text'] ?? 'Xem Catalog'); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    
                    <tr>
                        <th><label for="cta_button_link">CTA Button Link</label></th>
                        <td>
                            <input type="text" id="cta_button_link" name="cta_button_link" 
                                   value="<?php echo esc_attr($settings['cta_button_link'] ?? '/catalog/outdoor'); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <button type="submit" class="button button-primary">Save Settings</button>
                    <span class="spinner" style="float: none;"></span>
                </p>
            </form>
        </div>
        <?php
    }
    
    /**
     * Render Sections Tab
     */
    private function render_sections_tab() {
        $sections = $this->get_all_sections();
        ?>
        <div class="outdoor-sections-container">
            <div class="section-header">
                <h2>Outdoor Sections</h2>
                <button type="button" class="button button-primary add-section-btn">
                    <span class="dashicons dashicons-plus-alt"></span> Add New Section
                </button>
            </div>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th width="5%">Order</th>
                        <th width="20%">Section Name</th>
                        <th width="25%">Title</th>
                        <th width="25%">Subtitle</th>
                        <th width="10%">Products</th>
                        <th width="10%">Status</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody id="sections-list" class="sortable-list">
                    <?php foreach ($sections as $section): ?>
                    <tr data-id="<?php echo $section->id; ?>" class="section-row">
                        <td class="drag-handle">
                            <span class="dashicons dashicons-move"></span>
                            <?php echo $section->section_order; ?>
                        </td>
                        <td><?php echo esc_html($section->section_name); ?></td>
                        <td><?php echo esc_html($section->section_title); ?></td>
                        <td><?php echo esc_html($section->section_subtitle); ?></td>
                        <td>
                            <?php 
                            $product_count = $this->wpdb->get_var($this->wpdb->prepare(
                                "SELECT COUNT(*) FROM {$this->products_table} WHERE section_id = %d",
                                $section->id
                            ));
                            echo $product_count;
                            ?>
                        </td>
                        <td>
                            <span class="status-badge <?php echo $section->is_active ? 'active' : 'inactive'; ?>">
                                <?php echo $section->is_active ? 'Active' : 'Inactive'; ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="button button-small edit-section-btn" 
                                    data-id="<?php echo $section->id; ?>">Edit</button>
                            <button type="button" class="button button-small delete-section-btn" 
                                    data-id="<?php echo $section->id; ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Section Edit Modal -->
        <div id="section-modal" class="outdoor-modal" style="display:none;">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2 id="section-modal-title">Add Section</h2>
                
                <form id="section-form">
                    <input type="hidden" id="section_id" name="section_id" value="">
                    
                    <div class="form-field">
                        <label for="section_name">Section Name (ID)</label>
                        <input type="text" id="section_name" name="section_name" required>
                        <p class="description">Unique identifier (e.g., spotlight_garden)</p>
                    </div>
                    
                    <div class="form-field">
                        <label for="section_title">Section Title</label>
                        <input type="text" id="section_title" name="section_title" required>
                    </div>
                    
                    <div class="form-field">
                        <label for="section_subtitle">Section Subtitle (Optional)</label>
                        <input type="text" id="section_subtitle" name="section_subtitle">
                    </div>
                    
                    <div class="form-field">
                        <label for="section_active">
                            <input type="checkbox" id="section_active" name="is_active" value="1" checked>
                            Active
                        </label>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="button button-primary">Save Section</button>
                        <button type="button" class="button cancel-modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render Products Tab
     */
    private function render_products_tab() {
        $sections = $this->get_all_sections();
        $products = $this->get_all_products();
        ?>
        <div class="outdoor-products-container">
            <div class="section-header">
                <h2>Outdoor Products</h2>
                <button type="button" class="button button-primary add-product-btn">
                    <span class="dashicons dashicons-plus-alt"></span> Add New Product
                </button>
            </div>
            
            <!-- Filter by Section -->
            <div class="filter-bar">
                <label for="filter-section">Filter by Section:</label>
                <select id="filter-section">
                    <option value="">All Sections</option>
                    <?php foreach ($sections as $section): ?>
                    <option value="<?php echo $section->id; ?>">
                        <?php echo esc_html($section->section_title); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th width="5%">Order</th>
                        <th width="15%">Image</th>
                        <th width="20%">Product Name</th>
                        <th width="15%">Section</th>
                        <th width="25%">Description</th>
                        <th width="8%">Featured</th>
                        <th width="8%">Status</th>
                        <th width="14%">Actions</th>
                    </tr>
                </thead>
                <tbody id="products-list" class="sortable-list">
                    <?php foreach ($products as $product): ?>
                    <tr data-id="<?php echo $product->id; ?>" data-section="<?php echo $product->section_id; ?>" class="product-row">
                        <td class="drag-handle">
                            <span class="dashicons dashicons-move"></span>
                            <?php echo $product->product_order; ?>
                        </td>
                        <td>
                            <?php if ($product->product_image): ?>
                                <img src="<?php echo esc_url($product->product_image); ?>" 
                                     style="max-width: 100px; height: auto;">
                            <?php else: ?>
                                <span class="no-image">No image</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo esc_html($product->product_name); ?></strong></td>
                        <td>
                            <?php 
                            $section = $this->wpdb->get_row($this->wpdb->prepare(
                                "SELECT section_title FROM {$this->sections_table} WHERE id = %d",
                                $product->section_id
                            ));
                            echo esc_html($section->section_title ?? 'Unknown');
                            ?>
                        </td>
                        <td><?php echo esc_html($product->product_description); ?></td>
                        <td>
                            <?php if ($product->is_featured): ?>
                                <span class="dashicons dashicons-star-filled" style="color: #f0ad4e;"></span>
                            <?php else: ?>
                                <span class="dashicons dashicons-star-empty"></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-badge <?php echo $product->is_active ? 'active' : 'inactive'; ?>">
                                <?php echo $product->is_active ? 'Active' : 'Inactive'; ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="button button-small edit-product-btn" 
                                    data-id="<?php echo $product->id; ?>">Edit</button>
                            <button type="button" class="button button-small delete-product-btn" 
                                    data-id="<?php echo $product->id; ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Product Edit Modal -->
        <div id="product-modal" class="outdoor-modal" style="display:none;">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2 id="product-modal-title">Add Product</h2>
                
                <form id="product-form">
                    <input type="hidden" id="product_id" name="product_id" value="">
                    
                    <div class="form-field">
                        <label for="product_section">Section</label>
                        <select id="product_section" name="section_id" required>
                            <option value="">Select Section</option>
                            <?php foreach ($sections as $section): ?>
                            <option value="<?php echo $section->id; ?>">
                                <?php echo esc_html($section->section_title); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="product_name">Product Name</label>
                        <input type="text" id="product_name" name="product_name" required>
                    </div>
                    
                    <div class="form-field">
                        <label for="product_description">Description</label>
                        <textarea id="product_description" name="product_description" rows="3"></textarea>
                    </div>
                    
                    <div class="form-field">
                        <label>Product Image</label>
                        <div class="image-upload-container">
                            <input type="hidden" id="product_image" name="product_image">
                            <div id="product_image_preview" class="image-preview"></div>
                            <button type="button" class="button upload-image-btn" data-field="product_image">
                                Upload Image
                            </button>
                            <button type="button" class="button remove-image-btn" data-field="product_image" style="display:none;">
                                Remove
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="product_featured">
                            <input type="checkbox" id="product_featured" name="is_featured" value="1">
                            Featured Product
                        </label>
                    </div>
                    
                    <div class="form-field">
                        <label for="product_active">
                            <input type="checkbox" id="product_active" name="is_active" value="1" checked>
                            Active
                        </label>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="button button-primary">Save Product</button>
                        <button type="button" class="button cancel-modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render Layout Tab
     */
    private function render_layout_tab() {
        $sections = $this->get_all_sections();
        ?>
        <div class="outdoor-layout-container">
            <h2>Page Layout Configuration</h2>
            
            <div class="layout-preview">
                <h3>Current Page Structure</h3>
                
                <div class="layout-sections">
                    <?php foreach ($sections as $section): 
                        if (!$section->is_active) continue;
                    ?>
                    <div class="layout-section" data-id="<?php echo $section->id; ?>">
                        <div class="section-header">
                            <span class="section-order"><?php echo $section->section_order; ?></span>
                            <h4><?php echo esc_html($section->section_title); ?></h4>
                            <?php if ($section->section_name === 'banner'): ?>
                                <span class="badge">Banner</span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($section->section_name !== 'banner'): ?>
                        <div class="section-products">
                            <?php
                            $products = $this->wpdb->get_results($this->wpdb->prepare(
                                "SELECT * FROM {$this->products_table} 
                                WHERE section_id = %d AND is_active = 1 
                                ORDER BY product_order ASC",
                                $section->id
                            ));
                            ?>
                            <p>Products: <?php echo count($products); ?></p>
                            <div class="product-grid-preview">
                                <?php foreach (array_slice($products, 0, 4) as $product): ?>
                                <div class="product-preview">
                                    <?php if ($product->product_image): ?>
                                        <img src="<?php echo esc_url($product->product_image); ?>">
                                    <?php endif; ?>
                                    <span><?php echo esc_html($product->product_name); ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="layout-info">
                    <h3>Layout Information</h3>
                    <ul>
                        <li>Active Sections: <?php echo count(array_filter($sections, function($s) { return $s->is_active; })); ?></li>
                        <li>Total Products: <?php echo $this->wpdb->get_var("SELECT COUNT(*) FROM {$this->products_table} WHERE is_active = 1"); ?></li>
                        <li>Page URL: <a href="<?php echo home_url('/outdoor'); ?>" target="_blank"><?php echo home_url('/outdoor'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Helper Methods
     */
    private function get_all_settings() {
        $results = $this->wpdb->get_results("SELECT * FROM {$this->settings_table}");
        $settings = [];
        foreach ($results as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        return $settings;
    }
    
    private function get_all_sections() {
        return $this->wpdb->get_results("SELECT * FROM {$this->sections_table} ORDER BY section_order ASC");
    }
    
    private function get_all_products() {
        return $this->wpdb->get_results("SELECT * FROM {$this->products_table} ORDER BY section_id, product_order ASC");
    }
    
    /**
     * AJAX Handler: Save Settings
     */
    public function ajax_save_settings() {
        check_ajax_referer('outdoor_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $settings = $_POST['settings'] ?? [];
        
        foreach ($settings as $key => $value) {
            $existing = $this->wpdb->get_var($this->wpdb->prepare(
                "SELECT id FROM {$this->settings_table} WHERE setting_key = %s",
                $key
            ));
            
            if ($existing) {
                $this->wpdb->update(
                    $this->settings_table,
                    ['setting_value' => $value],
                    ['setting_key' => $key]
                );
            } else {
                $this->wpdb->insert(
                    $this->settings_table,
                    [
                        'setting_key' => $key,
                        'setting_value' => $value,
                        'setting_type' => 'text'
                    ]
                );
            }
        }
        
        wp_send_json_success(['message' => 'Settings saved successfully']);
    }
    
    /**
     * AJAX Handler: Save Section
     */
    public function ajax_save_section() {
        check_ajax_referer('outdoor_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $section_id = intval($_POST['section_id'] ?? 0);
        $data = [
            'section_name' => sanitize_text_field($_POST['section_name']),
            'section_title' => sanitize_text_field($_POST['section_title']),
            'section_subtitle' => sanitize_text_field($_POST['section_subtitle'] ?? ''),
            'is_active' => intval($_POST['is_active'] ?? 0)
        ];
        
        if ($section_id) {
            $this->wpdb->update($this->sections_table, $data, ['id' => $section_id]);
        } else {
            $data['section_order'] = $this->wpdb->get_var("SELECT MAX(section_order) + 1 FROM {$this->sections_table}") ?? 1;
            $this->wpdb->insert($this->sections_table, $data);
            $section_id = $this->wpdb->insert_id;
        }
        
        wp_send_json_success([
            'message' => 'Section saved successfully',
            'section_id' => $section_id
        ]);
    }
    
    /**
     * AJAX Handler: Delete Section
     */
    public function ajax_delete_section() {
        check_ajax_referer('outdoor_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $section_id = intval($_POST['section_id']);
        
        // Check if section has products
        $product_count = $this->wpdb->get_var($this->wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->products_table} WHERE section_id = %d",
            $section_id
        ));
        
        if ($product_count > 0) {
            wp_send_json_error(['message' => 'Cannot delete section with products. Please delete products first.']);
            return;
        }
        
        $this->wpdb->delete($this->sections_table, ['id' => $section_id]);
        
        wp_send_json_success(['message' => 'Section deleted successfully']);
    }
    
    /**
     * AJAX Handler: Save Product
     */
    public function ajax_save_product() {
        check_ajax_referer('outdoor_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $product_id = intval($_POST['product_id'] ?? 0);
        $data = [
            'section_id' => intval($_POST['section_id']),
            'product_name' => sanitize_text_field($_POST['product_name']),
            'product_image' => esc_url_raw($_POST['product_image'] ?? ''),
            'product_description' => sanitize_textarea_field($_POST['product_description'] ?? ''),
            'is_featured' => intval($_POST['is_featured'] ?? 0),
            'is_active' => intval($_POST['is_active'] ?? 0)
        ];
        
        if ($product_id) {
            $this->wpdb->update($this->products_table, $data, ['id' => $product_id]);
        } else {
            $data['product_order'] = $this->wpdb->get_var($this->wpdb->prepare(
                "SELECT MAX(product_order) + 1 FROM {$this->products_table} WHERE section_id = %d",
                $data['section_id']
            )) ?? 1;
            $this->wpdb->insert($this->products_table, $data);
            $product_id = $this->wpdb->insert_id;
        }
        
        wp_send_json_success([
            'message' => 'Product saved successfully',
            'product_id' => $product_id
        ]);
    }
    
    /**
     * AJAX Handler: Delete Product
     */
    public function ajax_delete_product() {
        check_ajax_referer('outdoor_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $product_id = intval($_POST['product_id']);
        $this->wpdb->delete($this->products_table, ['id' => $product_id]);
        
        wp_send_json_success(['message' => 'Product deleted successfully']);
    }
    
    /**
     * AJAX Handler: Reorder Items
     */
    public function ajax_reorder_items() {
        check_ajax_referer('outdoor_admin_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $type = $_POST['type'] ?? 'product';
        $order = $_POST['order'] ?? [];
        
        if ($type === 'section') {
            foreach ($order as $position => $id) {
                $this->wpdb->update(
                    $this->sections_table,
                    ['section_order' => $position + 1],
                    ['id' => intval($id)]
                );
            }
        } else {
            foreach ($order as $position => $id) {
                $this->wpdb->update(
                    $this->products_table,
                    ['product_order' => $position + 1],
                    ['id' => intval($id)]
                );
            }
        }
        
        wp_send_json_success(['message' => 'Order updated successfully']);
    }
}

// Initialize the manager
new Outdoor_Admin_Manager();