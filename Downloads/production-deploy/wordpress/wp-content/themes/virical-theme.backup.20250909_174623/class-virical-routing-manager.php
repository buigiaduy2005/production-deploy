<?php
/**
 * Virical Routing Manager Class
 * 
 * Manages URL routing rules from database
 * 
 * @package Virical
 * @version 1.0.0
 * @since 2025-09-10
 */

if (!defined('ABSPATH')) {
    exit;
}

class ViricalRoutingManager {
    
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
     * Cache key for routing rules
     * @var string
     */
    private $cache_key = 'virical_routing_rules';
    
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
        $this->table_name = $wpdb->prefix . 'virical_routing_rules';
    }
    
    /**
     * Initialize the routing manager
     */
    public function init() {
        // Hook into WordPress rewrite system
        add_action('init', array($this, 'register_routing_rules'), 1);
        add_filter('query_vars', array($this, 'add_query_vars'));
        add_action('template_redirect', array($this, 'handle_redirects'));
        add_filter('template_include', array($this, 'handle_custom_templates'), 99);
        
        // Admin hooks
        if (is_admin()) {
            add_action('admin_menu', array($this, 'add_admin_menu'));
            add_action('wp_ajax_virical_save_route', array($this, 'ajax_save_route'));
            add_action('wp_ajax_virical_delete_route', array($this, 'ajax_delete_route'));
            add_action('wp_ajax_virical_toggle_route', array($this, 'ajax_toggle_route'));
            add_action('wp_ajax_virical_flush_rules', array($this, 'ajax_flush_rules'));
        }
        
        // Flush rewrite rules when routes are updated
        add_action('virical_routes_updated', array($this, 'flush_rewrite_rules'));
    }
    
    /**
     * Register routing rules from database
     */
    public function register_routing_rules() {
        $rules = $this->get_active_rules('rewrite');
        
        foreach ($rules as $rule) {
            add_rewrite_rule(
                $rule->pattern,
                $rule->rewrite,
                'top'
            );
        }
    }
    
    /**
     * Add custom query vars
     * 
     * @param array $vars Existing query vars
     * @return array Modified query vars
     */
    public function add_query_vars($vars) {
        // Add custom query vars from routing rules
        $rules = $this->get_active_rules();
        
        foreach ($rules as $rule) {
            if (!empty($rule->meta_data['query_var'])) {
                $vars[] = $rule->meta_data['query_var'];
            }
        }
        
        // Add default custom vars
        $vars[] = 'product';
        $vars[] = 'project';
        
        return $vars;
    }
    
    /**
     * Handle redirect rules
     */
    public function handle_redirects() {
        // Get current URL path
        $current_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        
        // Get redirect rules
        $redirects = $this->get_active_rules('redirect');
        
        foreach ($redirects as $redirect) {
            // Check if pattern matches
            if (preg_match('#' . $redirect->pattern . '#', $current_path)) {
                // Perform redirect
                $redirect_url = home_url($redirect->rewrite);
                $redirect_type = !empty($redirect->redirect_type) ? intval($redirect->redirect_type) : 301;
                
                wp_redirect($redirect_url, $redirect_type);
                exit;
            }
        }
    }
    
    /**
     * Handle custom templates for products and projects
     */
    public function handle_custom_templates($template) {
        // Check if this is a single product
        $product_slug = get_query_var('product');
        if ($product_slug) {
            // Check if single-product.php exists
            $single_product = get_template_directory() . '/single-product.php';
            if (file_exists($single_product)) {
                // Get product data
                global $wpdb;
                $product = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}virical_products WHERE slug = %s AND is_active = 1",
                    $product_slug
                ));
                
                if ($product) {
                    // Make product data available to template
                    set_query_var('current_product', $product);
                    return $single_product;
                }
            }
        }
        
        // Check if this is a single project
        $project_slug = get_query_var('project');
        if ($project_slug) {
            // Check if single-project.php exists
            $single_project = get_template_directory() . '/single-project.php';
            if (file_exists($single_project)) {
                // Get project data
                global $wpdb;
                $project = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}virical_projects WHERE slug = %s AND is_active = 1",
                    $project_slug
                ));
                
                if ($project) {
                    // Make project data available to template
                    set_query_var('current_project', $project);
                    return $single_project;
                }
            }
        }
        
        return $template;
    }
    
    /**
     * Get active routing rules
     * 
     * @param string $type Optional rule type filter
     * @return array Routing rules
     */
    public function get_active_rules($type = null) {
        // Check cache first
        $cache_key = $this->cache_key . '_' . ($type ?: 'all');
        $cached = wp_cache_get($cache_key);
        
        if ($cached !== false) {
            return $cached;
        }
        
        // Build query
        $where = "is_active = 1";
        $params = array();
        
        if ($type) {
            $where .= " AND rule_type = %s";
            $params[] = $type;
        }
        
        // Query database
        if ($params) {
            $query = $this->wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE {$where} ORDER BY priority ASC",
                $params
            );
        } else {
            $query = "SELECT * FROM {$this->table_name} WHERE {$where} ORDER BY priority ASC";
        }
        
        $rules = $this->wpdb->get_results($query);
        
        // Process rules
        foreach ($rules as &$rule) {
            // Decode JSON fields with empty string check
            $rule->conditions = !empty($rule->conditions) ? json_decode($rule->conditions, true) : [];
            $rule->meta_data = !empty($rule->meta_data) ? json_decode($rule->meta_data, true) : [];
            
            // Validate decoded data
            if ($rule->conditions === null) {
                $rule->conditions = [];
            }
            if ($rule->meta_data === null) {
                $rule->meta_data = [];
            }
        }
        
        // Cache the result
        wp_cache_set($cache_key, $rules, '', $this->cache_ttl);
        
        return $rules;
    }
    
    /**
     * Add routing rule
     * 
     * @param array $rule_data Rule data
     * @return int|false Insert ID or false on failure
     */
    public function add_rule($rule_data) {
        // Prepare data
        $data = array(
            'rule_name' => sanitize_text_field($rule_data['rule_name']),
            'pattern' => $rule_data['pattern'],
            'rewrite' => $rule_data['rewrite'],
            'redirect_type' => isset($rule_data['redirect_type']) ? $rule_data['redirect_type'] : null,
            'rule_type' => isset($rule_data['rule_type']) ? $rule_data['rule_type'] : 'rewrite',
            'priority' => isset($rule_data['priority']) ? intval($rule_data['priority']) : 10,
            'is_active' => isset($rule_data['is_active']) ? intval($rule_data['is_active']) : 1,
            'conditions' => isset($rule_data['conditions']) ? json_encode($rule_data['conditions']) : null,
            'meta_data' => isset($rule_data['meta_data']) ? json_encode($rule_data['meta_data']) : null
        );
        
        // Insert into database
        $result = $this->wpdb->insert($this->table_name, $data);
        
        if ($result) {
            // Clear cache and trigger update
            $this->clear_cache();
            do_action('virical_routes_updated');
            
            return $this->wpdb->insert_id;
        }
        
        return false;
    }
    
    /**
     * Update routing rule
     * 
     * @param int $rule_id Rule ID
     * @param array $rule_data Rule data
     * @return bool Success status
     */
    public function update_rule($rule_id, $rule_data) {
        // Prepare data
        $data = array();
        
        if (isset($rule_data['rule_name'])) {
            $data['rule_name'] = sanitize_text_field($rule_data['rule_name']);
        }
        if (isset($rule_data['pattern'])) {
            $data['pattern'] = $rule_data['pattern'];
        }
        if (isset($rule_data['rewrite'])) {
            $data['rewrite'] = $rule_data['rewrite'];
        }
        if (isset($rule_data['redirect_type'])) {
            $data['redirect_type'] = $rule_data['redirect_type'];
        }
        if (isset($rule_data['rule_type'])) {
            $data['rule_type'] = $rule_data['rule_type'];
        }
        if (isset($rule_data['priority'])) {
            $data['priority'] = intval($rule_data['priority']);
        }
        if (isset($rule_data['is_active'])) {
            $data['is_active'] = intval($rule_data['is_active']);
        }
        if (isset($rule_data['conditions'])) {
            $data['conditions'] = json_encode($rule_data['conditions']);
        }
        if (isset($rule_data['meta_data'])) {
            $data['meta_data'] = json_encode($rule_data['meta_data']);
        }
        
        // Update database
        $result = $this->wpdb->update(
            $this->table_name,
            $data,
            array('id' => $rule_id)
        );
        
        if ($result !== false) {
            // Clear cache and trigger update
            $this->clear_cache();
            do_action('virical_routes_updated');
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Delete routing rule
     * 
     * @param int $rule_id Rule ID
     * @return bool Success status
     */
    public function delete_rule($rule_id) {
        $result = $this->wpdb->delete(
            $this->table_name,
            array('id' => $rule_id)
        );
        
        if ($result) {
            // Clear cache and trigger update
            $this->clear_cache();
            do_action('virical_routes_updated');
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Toggle rule status
     * 
     * @param int $rule_id Rule ID
     * @return bool Success status
     */
    public function toggle_rule_status($rule_id) {
        // Get current status
        $current = $this->wpdb->get_var(
            $this->wpdb->prepare(
                "SELECT is_active FROM {$this->table_name} WHERE id = %d",
                $rule_id
            )
        );
        
        if ($current !== null) {
            // Toggle status
            $new_status = $current ? 0 : 1;
            
            $result = $this->wpdb->update(
                $this->table_name,
                array('is_active' => $new_status),
                array('id' => $rule_id)
            );
            
            if ($result !== false) {
                // Clear cache and trigger update
                $this->clear_cache();
                do_action('virical_routes_updated');
                
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Clear routing cache
     */
    public function clear_cache() {
        wp_cache_delete($this->cache_key . '_all');
        wp_cache_delete($this->cache_key . '_rewrite');
        wp_cache_delete($this->cache_key . '_redirect');
        wp_cache_delete($this->cache_key . '_custom');
    }
    
    /**
     * Flush WordPress rewrite rules
     */
    public function flush_rewrite_rules() {
        flush_rewrite_rules();
    }
    
    /**
     * Add admin menu for routing management
     */
    public function add_admin_menu() {
        add_submenu_page(
            'virical-settings',
            'Routing Manager',
            'Routing Manager',
            'manage_options',
            'virical-routing-manager',
            array($this, 'render_admin_page')
        );
    }
    
    /**
     * Render admin page
     */
    public function render_admin_page() {
        // Get all rules
        $rules = $this->wpdb->get_results(
            "SELECT * FROM {$this->table_name} ORDER BY priority ASC"
        );

        // Define image paths
        $ray_nam_cham_img = get_template_directory_uri() . '/assets/images/san-pham/ray-nam-cham.jpg';
        $den_spotlight_img = get_template_directory_uri() . '/assets/images/san-pham/den-spotlight.jpg';

        // Kiểm tra tồn tại của file hình ảnh
        $default_img = get_template_directory_uri() . '/assets/images/placeholder.jpg';
        
        ?>
        <div class="wrap">
            <h1>Routing Manager</h1>
            
            <!-- Thêm section hiển thị sản phẩm -->
            <div class="products-section">
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo esc_url(file_exists(get_template_directory() . '/assets/images/san-pham/ray-nam-cham.jpg') ? $ray_nam_cham_img : $default_img); ?>" 
                             alt="Ray Nam Châm MAGNA Pro 48V"
                             onerror="this.src='<?php echo esc_url($default_img); ?>'" />
                    </div>
                    <div class="product-info">
                        <h3>Ray Nam Châm MAGNA Pro 48V</h3>
                        <p>Hệ thống ray nam châm chuyên nghiệp với điện áp 48V an toàn, cho phép di chuyển và điều chỉnh đèn linh hoạt.</p>
                        <button class="button button-primary">Nổi Bật</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo esc_url(file_exists(get_template_directory() . '/assets/images/san-pham/den-spotlight.jpg') ? $den_spotlight_img : $default_img); ?>" 
                             alt="Đèn Spotlight Ray Nam Chấm 15W"
                             onerror="this.src='<?php echo esc_url($default_img); ?>'" />
                    </div>
                    <div class="product-info">
                        <h3>Đèn Spotlight Ray Nam Chấm 15W</h3> 
                        <p>Đèn spotlight gắn ray nam châm công suất 15W, góc chiếu điều chỉnh được.</p>
                        <button class="button button-primary">Nổi Bật</button>
                    </div>
                </div>
            </div>

            <!-- Cập nhật CSS cho phần sản phẩm -->
            <style>
                .products-section {
                    display: flex;
                    gap: 30px;
                    margin: 30px 0;
                    padding: 20px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                .product-card {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    background: #fff;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    overflow: hidden;
                    transition: transform 0.2s;
                }
                .product-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                }
                .product-image {
                    height: 250px;
                    overflow: hidden;
                    position: relative;
                }
                .product-image img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transition: transform 0.3s;
                }
                .product-card:hover .product-image img {
                    transform: scale(1.05);
                }
                .product-info {
                    padding: 20px;
                    text-align: center;
                }
                .product-info h3 {
                    margin: 0 0 15px;
                    font-size: 18px;
                    color: #23282d;
                }
                .product-info p {
                    margin: 0 0 20px;
                    color: #666;
                    line-height: 1.5;
                }
                .button-primary {
                    width: auto;
                    min-width: 120px;
                    text-align: center;
                    padding: 8px 20px;
                    border-radius: 4px;
                    transition: all 0.3s;
                }
                .button-primary:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                }
            </style>
                
            <div class="tablenav top">
                <button class="button button-primary" id="add-new-route">Add New Route</button>
                <button class="button" id="flush-rewrite-rules">Flush Rewrite Rules</button>
            </div>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th width="20%">Rule Name</th>
                        <th width="25%">Pattern</th>
                        <th width="25%">Rewrite/Redirect</th>
                        <th width="10%">Type</th>
                        <th width="10%">Priority</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rules as $rule): ?>
                        <tr data-id="<?php echo esc_attr($rule->id); ?>">
                            <td><?php echo esc_html($rule->rule_name); ?></td>
                            <td><code><?php echo esc_html($rule->pattern); ?></code></td>
                            <td><code><?php echo esc_html($rule->rewrite); ?></code></td>
                            <td>
                                <span class="rule-type <?php echo esc_attr($rule->rule_type); ?>">
                                    <?php echo esc_html($rule->rule_type); ?>
                                    <?php if ($rule->rule_type === 'redirect' && $rule->redirect_type): ?>
                                        (<?php echo esc_html($rule->redirect_type); ?>)
                                    <?php endif; ?>
                                </span>
                            </td>
                            <td><?php echo esc_html($rule->priority); ?></td>
                            <td>
                                <button class="button-link edit-route">Edit</button> |
                                <button class="button-link toggle-route">
                                    <?php echo $rule->is_active ? 'Disable' : 'Enable'; ?>
                                </button> |
                                <button class="button-link delete-route" style="color: #dc3232;">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <!-- Add/Edit Route Modal -->
            <div id="route-modal" class="modal" style="display:none;">
                <div class="modal-content">
                    <h2>Add/Edit Route</h2>
                    <form id="route-form">
                        <input type="hidden" id="route-id" value="">
                        
                        <label for="rule-name">Rule Name:</label>
                        <input type="text" id="rule-name" class="regular-text" required>
                        
                        <label for="pattern">Pattern (Regex):</label>
                        <input type="text" id="pattern" class="regular-text" required>
                        <p class="description">e.g., ^san-pham/([^/]+)/?$</p>
                        
                        <label for="rewrite">Rewrite/Redirect URL:</label>
                        <input type="text" id="rewrite" class="regular-text" required>
                        <p class="description">e.g., index.php?product=$matches[1] or /new-url/</p>
                        
                        <label for="rule-type">Rule Type:</label>
                        <select id="rule-type">
                            <option value="rewrite">Rewrite</option>
                            <option value="redirect">Redirect</option>
                            <option value="custom">Custom</option>
                        </select>
                        
                        <div id="redirect-options" style="display:none;">
                            <label for="redirect-type">Redirect Type:</label>
                            <select id="redirect-type">
                                <option value="301">301 (Permanent)</option>
                                <option value="302">302 (Temporary)</option>
                                <option value="307">307 (Temporary)</option>
                            </select>
                        </div>
                        
                        <label for="priority">Priority:</label>
                        <input type="number" id="priority" value="10" min="1" max="100">
                        
                        <label for="is-active">
                            <input type="checkbox" id="is-active" checked> Active
                        </label>
                        
                        <div class="modal-actions">
                            <button type="submit" class="button button-primary">Save Route</button>
                            <button type="button" class="button cancel-modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <style>
        .rule-type {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
        }
        .rule-type.rewrite { background: #d4edda; color: #155724; }
        .rule-type.redirect { background: #fff3cd; color: #856404; }
        .rule-type.custom { background: #d1ecf1; color: #0c5460; }
        
        .modal {
            position: fixed;
            z-index: 100000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 500px;
            max-width: 90%;
        }
        .modal-content label {
            display: block;
            margin-top: 10px;
            font-weight: 600;
        }
        .modal-content input[type="text"],
        .modal-content select {
            width: 100%;
            margin-top: 5px;
        }
        .modal-actions {
            margin-top: 20px;
            text-align: right;
        }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            // Show/hide redirect options
            $('#rule-type').on('change', function() {
                if ($(this).val() === 'redirect') {
                    $('#redirect-options').show();
                } else {
                    $('#redirect-options').hide();
                }
            });
            
            // Add new route
            $('#add-new-route').on('click', function() {
                $('#route-form')[0].reset();
                $('#route-id').val('');
                $('#route-modal').show();
            });
            
            // Edit route
            $('.edit-route').on('click', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');
                // Load route data and show modal
                // This would need AJAX to get full route data
                $('#route-modal').show();
            });
            
            // Cancel modal
            $('.cancel-modal').on('click', function() {
                $('#route-modal').hide();
            });
            
            // Save route
            $('#route-form').on('submit', function(e) {
                e.preventDefault();
                
                var data = {
                    action: 'virical_save_route',
                    nonce: '<?php echo wp_create_nonce('virical_routing_nonce'); ?>',
                    rule_id: $('#route-id').val(),
                    rule_name: $('#rule-name').val(),
                    pattern: $('#pattern').val(),
                    rewrite: $('#rewrite').val(),
                    rule_type: $('#rule-type').val(),
                    redirect_type: $('#redirect-type').val(),
                    priority: $('#priority').val(),
                    is_active: $('#is-active').is(':checked') ? 1 : 0
                };
                
                $.post(ajaxurl, data, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error saving route');
                    }
                });
            });
            
            // Toggle route
            $('.toggle-route').on('click', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');
                
                $.post(ajaxurl, {
                    action: 'virical_toggle_route',
                    nonce: '<?php echo wp_create_nonce('virical_routing_nonce'); ?>',
                    rule_id: id
                }, function(response) {
                    if (response.success) {
                        location.reload();
                    }
                });
            });
            
            // Delete route
            $('.delete-route').on('click', function() {
                if (!confirm('Are you sure you want to delete this route?')) {
                    return;
                }
                
                var row = $(this).closest('tr');
                var id = row.data('id');
                
                $.post(ajaxurl, {
                    action: 'virical_delete_route',
                    nonce: '<?php echo wp_create_nonce('virical_routing_nonce'); ?>',
                    rule_id: id
                }, function(response) {
                    if (response.success) {
                        row.remove();
                    }
                });
            });
            
            // Flush rewrite rules
            $('#flush-rewrite-rules').on('click', function() {
                var button = $(this);
                button.prop('disabled', true).text('Flushing...');
                
                $.post(ajaxurl, {
                    action: 'virical_flush_rules',
                    nonce: '<?php echo wp_create_nonce('virical_routing_nonce'); ?>'
                }, function(response) {
                    button.prop('disabled', false).text('Flush Rewrite Rules');
                    if (response.success) {
                        alert('Rewrite rules flushed successfully');
                    }
                });
            });
        });
        </script>
        <?php
    }
    
    /**
     * AJAX handler to save route
     */
    public function ajax_save_route() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Validate nonce
        check_ajax_referer('virical_routing_nonce', 'nonce');
        
        // Get route data
        $rule_data = array(
            'rule_name' => $_POST['rule_name'],
            'pattern' => $_POST['pattern'],
            'rewrite' => $_POST['rewrite'],
            'rule_type' => $_POST['rule_type'],
            'redirect_type' => $_POST['redirect_type'],
            'priority' => $_POST['priority'],
            'is_active' => $_POST['is_active']
        );
        
        // Save route
        if (!empty($_POST['rule_id'])) {
            $result = $this->update_rule(intval($_POST['rule_id']), $rule_data);
        } else {
            $result = $this->add_rule($rule_data);
        }
        
        if ($result) {
            wp_send_json_success(array('message' => 'Route saved successfully'));
        } else {
            wp_send_json_error(array('message' => 'Failed to save route'));
        }
    }
    
    /**
     * AJAX handler to delete route
     */
    public function ajax_delete_route() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Validate nonce
        check_ajax_referer('virical_routing_nonce', 'nonce');
        
        $rule_id = intval($_POST['rule_id']);
        
        if ($this->delete_rule($rule_id)) {
            wp_send_json_success(array('message' => 'Route deleted successfully'));
        } else {
            wp_send_json_error(array('message' => 'Failed to delete route'));
        }
    }
    
    /**
     * AJAX handler to toggle route status
     */
    public function ajax_toggle_route() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Validate nonce
        check_ajax_referer('virical_routing_nonce', 'nonce');
        
        $rule_id = intval($_POST['rule_id']);
        
        if ($this->toggle_rule_status($rule_id)) {
            wp_send_json_success(array('message' => 'Route status toggled'));
        } else {
            wp_send_json_error(array('message' => 'Failed to toggle route'));
        }
    }
    
    /**
     * AJAX handler to flush rewrite rules
     */
    public function ajax_flush_rules() {
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        // Validate nonce
        check_ajax_referer('virical_routing_nonce', 'nonce');
        
        $this->flush_rewrite_rules();
        
        wp_send_json_success(array('message' => 'Rewrite rules flushed'));
    }
}