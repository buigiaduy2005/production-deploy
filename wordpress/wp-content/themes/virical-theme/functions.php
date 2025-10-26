<?php
/**
 * Virical Theme Functions
 * 
 * @package Virical
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function virical_theme_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'virical'),
        'footer' => __('Footer Menu', 'virical'),
    ));
}
add_action('after_setup_theme', 'virical_theme_setup');

/**
 * Enqueue scripts and styles
 */
function virical_enqueue_scripts() {
    // Theme stylesheet
    wp_enqueue_style('virical-style', get_stylesheet_uri(), array(), '1.0.1');
    
    // Custom styles
    wp_enqueue_style('virical-custom-styles', get_template_directory_uri() . '/assets/css/custom-styles.css', array('virical-style'), '1.0.1');
    wp_enqueue_style('virical-force-styles', get_template_directory_uri() . '/assets/css/force-styles.css', array(), '99.0', 'all');



    // Theme scripts
    wp_enqueue_script('virical-header-script', get_template_directory_uri() . '/assets/js/header.js', array('jquery'), '1.0.1', true);

    
}
add_action('wp_enqueue_scripts', 'virical_enqueue_scripts');

/**
 * Admin scripts and styles
 */
function virical_admin_enqueue_scripts() {
    wp_enqueue_style('virical-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0');
    wp_enqueue_script('virical-admin', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('virical-admin', 'virical_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('virical_menu_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'virical_admin_enqueue_scripts');

/**
 * Initialize Dynamic Configuration System
 * 
 * This replaces all hardcoded configurations
 * with a dynamic database-driven system
 */
function virical_init_configuration_system() {
    // Include the Admin Menu Manager class
    require_once get_template_directory() . '/includes/class-virical-admin-menu-manager.php';
    
    // Include the Template Manager class
    if (file_exists(get_template_directory() . '/includes/class-virical-template-manager.php')) {
        require_once get_template_directory() . '/includes/class-virical-template-manager.php';
    }
    
    // Include the Navigation Manager class
    if (file_exists(get_template_directory() . '/includes/class-virical-navigation-manager.php')) {
        require_once get_template_directory() . '/includes/class-virical-navigation-manager.php';
    }
    
    // Include the Routing Manager class
    if (file_exists(get_template_directory() . '/includes/class-virical-routing-manager.php')) {
        require_once get_template_directory() . '/includes/class-virical-routing-manager.php';
    }
    
    // Include the Indoor Admin Manager class
    if (file_exists(get_template_directory() . '/includes/class-indoor-admin-manager.php')) {
        require_once get_template_directory() . '/includes/class-indoor-admin-manager.php';
    }
    
    // Include the Outdoor Admin Manager class
    if (file_exists(get_template_directory() . '/includes/class-outdoor-admin-manager.php')) {
        require_once get_template_directory() . '/includes/class-outdoor-admin-manager.php';
    }
    
    // Initialize the managers
    if (class_exists('ViricalAdminMenuManager')) {
        $GLOBALS['virical_menu_manager'] = new ViricalAdminMenuManager();
    }
    
    if (class_exists('ViricalTemplateManager')) {
        $GLOBALS['virical_template_manager'] = new ViricalTemplateManager();
        $GLOBALS['virical_template_manager']->init();
    }
    
    if (class_exists('ViricalNavigationManager')) {
        $GLOBALS['virical_navigation_manager'] = new ViricalNavigationManager();
        $GLOBALS['virical_navigation_manager']->init();
    }
    
    if (class_exists('ViricalRoutingManager')) {
        $GLOBALS['virical_routing_manager'] = new ViricalRoutingManager();
        $GLOBALS['virical_routing_manager']->init();
    }
}
add_action('init', 'virical_init_configuration_system');

/**
 * Run database migrations on theme activation
 */
function virical_run_migrations() {
    // Only run in admin
    if (!is_admin()) {
        return;
    }
    
    // Migration 001: Create admin menu table
    if (file_exists(get_template_directory() . '/migrations/001-create-admin-menu-table.php')) {
        require_once get_template_directory() . '/migrations/001-create-admin-menu-table.php';
        if (function_exists('virical_migration_001_should_run') && virical_migration_001_should_run()) {
            virical_migration_001_execute();
        }
    }
    
    // Migration 002: Populate admin menus
    if (file_exists(get_template_directory() . '/migrations/002-populate-admin-menus.php')) {
        require_once get_template_directory() . '/migrations/002-populate-admin-menus.php';
        if (function_exists('virical_migration_002_should_run') && virical_migration_002_should_run()) {
            virical_migration_002_execute();
        }
    }
    
    // Migration 003: Create templates table
    if (file_exists(get_template_directory() . '/migrations/003-create-templates-table.php')) {
        require_once get_template_directory() . '/migrations/003-create-templates-table.php';
        if (function_exists('virical_migration_003_should_run') && virical_migration_003_should_run()) {
            virical_migration_003_execute();
        }
    }
    
    // Migration 004: Create navigation table
    if (file_exists(get_template_directory() . '/migrations/004-create-navigation-table.php')) {
        require_once get_template_directory() . '/migrations/004-create-navigation-table.php';
        if (function_exists('virical_migration_004_should_run') && virical_migration_004_should_run()) {
            virical_migration_004_execute();
        }
    }
    
    // Migration 005: Create routing table
    if (file_exists(get_template_directory() . '/migrations/005-create-routing-table.php')) {
        require_once get_template_directory() . '/migrations/005-create-routing-table.php';
        if (function_exists('virical_migration_005_should_run') && virical_migration_005_should_run()) {
            virical_migration_005_execute();
        }
    }
}
add_action('admin_init', 'virical_run_migrations');

/**
 * Custom post types (if needed)
 */
function virical_register_post_types() {
    // Register any custom post types here if needed
    // Note: Products and Projects are now in database tables
}
add_action('init', 'virical_register_post_types');

/**
 * Theme activation hook
 */
function virical_theme_activate() {
    // Run initial setup
    virical_theme_setup();
    
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Set theme version
    update_option('virical_theme_version', '1.0.0');
    update_option('virical_theme_activated', current_time('mysql'));
}
add_action('after_switch_theme', 'virical_theme_activate');

/**
 * Theme deactivation hook
 */
function virical_theme_deactivate() {
    // Clean up if needed
    flush_rewrite_rules();
}
add_action('switch_theme', 'virical_theme_deactivate');

/**
 * Include additional theme files
 */

// Include template functions
if (file_exists(get_template_directory() . '/includes/template-functions.php')) {
    require_once get_template_directory() . '/includes/template-functions.php';
}

// Include company info functions
// Disabled - functions moved to main functions.php (Phase 2)
// if (file_exists(get_template_directory() . '/includes/company-info-functions.php')) {
//     require_once get_template_directory() . '/includes/company-info-functions.php';
// }

// Include custom widgets
if (file_exists(get_template_directory() . '/includes/widgets.php')) {
    require_once get_template_directory() . '/includes/widgets.php';
}

// Include theme customizer
if (file_exists(get_template_directory() . '/includes/customizer.php')) {
    require_once get_template_directory() . '/includes/customizer.php';
}

/**
 * Navigation menu fallback
 * 
 * This function provides a fallback menu from database
 * when no WordPress menu is assigned
 */
function virical_get_database_menu_fallback() {
    global $wpdb;
    
    // For now, return a simple menu
    // This will be enhanced when navigation tables are created
    echo '<ul class="main-nav">';
    echo '<li><a href="' . home_url('/') . '">' . __('Home', 'virical') . '</a></li>';
    echo '<li><a href="' . home_url('/san-pham/') . '">' . __('Sản phẩm', 'virical') . '</a></li>';
    echo '<li><a href="' . home_url('/cong-trinh/') . '">' . __('Công trình', 'virical') . '</a></li>';
    echo '<li><a href="' . home_url('/ve-chung-toi/') . '">' . __('Về chúng tôi', 'virical') . '</a></li>';
    echo '<li><a href="' . home_url('/lien-he/') . '">' . __('Liên hệ', 'virical') . '</a></li>';
    echo '</ul>';
}

/**
 * Custom rewrite rules for products and projects
 */
function virical_custom_rewrite_rules() {
    // Product detail page
    add_rewrite_rule(
        '^san-pham/([^/]+)/?$',
        'index.php?pagename=san-pham&product=$matches[1]',
        'top'
    );
    
    // Project detail page
    add_rewrite_rule(
        '^cong-trinh/([^/]+)/?$',
        'index.php?pagename=cong-trinh&project=$matches[1]',
        'top'
    );
    
    // Product category
    add_rewrite_rule(
        '^danh-muc-san-pham/([^/]+)/?$',
        'index.php?pagename=san-pham&product_category=$matches[1]',
        'top'
    );
    
    // Project type
    add_rewrite_rule(
        '^loai-cong-trinh/([^/]+)/?$',
        'index.php?pagename=cong-trinh&project_type=$matches[1]',
        'top'
    );
}
add_action('init', 'virical_custom_rewrite_rules');

/**
 * Add custom query vars
 */
function virical_query_vars($vars) {
    $vars[] = 'product';
    $vars[] = 'project';
    $vars[] = 'product_category';
    $vars[] = 'project_type';
    return $vars;
}
add_filter('query_vars', 'virical_query_vars');

/**
 * Helper function to get products from database
 */
function virical_get_products($args = array()) {
    global $wpdb;
    
    $defaults = array(
        'limit' => 12,
        'offset' => 0,
        'category_id' => null,
        'is_featured' => null,
        'orderby' => 'sort_order',
        'order' => 'ASC'
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $table = $wpdb->prefix . 'virical_products';
    $where = array('is_active = 1');
    
    if ($args['category_id']) {
        $where[] = $wpdb->prepare('category_id = %d', $args['category_id']);
    }
    
    if ($args['is_featured'] !== null) {
        $where[] = $wpdb->prepare('is_featured = %d', $args['is_featured']);
    }
    
    $where_clause = implode(' AND ', $where);
    $order_clause = sprintf('%s %s', $args['orderby'], $args['order']);
    
    $query = $wpdb->prepare(
        "SELECT * FROM $table WHERE $where_clause ORDER BY $order_clause LIMIT %d OFFSET %d",
        $args['limit'],
        $args['offset']
    );
    
    return $wpdb->get_results($query);
}

/**
 * Helper function to get projects from database
 */
function virical_get_projects($args = array()) {
    global $wpdb;
    
    $defaults = array(
        'limit' => 9,
        'offset' => 0,
        'type_id' => null,
        'is_featured' => null,
        'orderby' => 'sort_order',
        'order' => 'ASC'
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $table = $wpdb->prefix . 'virical_projects';
    $where = array('is_active = 1');
    
    if ($args['type_id']) {
        $where[] = $wpdb->prepare('type_id = %d', $args['type_id']);
    }
    
    if ($args['is_featured'] !== null) {
        $where[] = $wpdb->prepare('is_featured = %d', $args['is_featured']);
    }
    
    $where_clause = implode(' AND ', $where);
    $order_clause = sprintf('%s %s', $args['orderby'], $args['order']);
    
    $query = $wpdb->prepare(
        "SELECT * FROM $table WHERE $where_clause ORDER BY $order_clause LIMIT %d OFFSET %d",
        $args['limit'],
        $args['offset']
    );
    
    return $wpdb->get_results($query);
}

/**
 * Homepage Settings Management Functions
 * Load homepage configuration from database
 */
function virical_get_homepage_settings($key = null) {
    global $wpdb;
    static $settings_cache = null;
    
    if ($settings_cache === null) {
        $results = $wpdb->get_results("
            SELECT setting_key, setting_value, setting_type 
            FROM {$wpdb->prefix}homepage_settings
        ");
        
        $settings_cache = array();
        foreach ($results as $row) {
            $value = $row->setting_value;
            if ($row->setting_type === 'json') {
                $value = !empty($value) ? json_decode($value, true) : [];
            }
            $settings_cache[$row->setting_key] = $value;
        }
    }
    
    if ($key) {
        return isset($settings_cache[$key]) ? $settings_cache[$key] : null;
    }
    
    return $settings_cache;
}

/**
 * Get homepage sliders from database
 */
function virical_get_homepage_sliders($active_only = true) {
    global $wpdb;
    
    $where = $active_only ? "WHERE is_active = 1" : "";
    
    return $wpdb->get_results("
        SELECT * FROM {$wpdb->prefix}homepage_sliders
        {$where}
        ORDER BY sort_order ASC
    ", ARRAY_A);
}

/**
 * Get homepage sections from database
 */
function virical_get_homepage_sections($active_only = true) {
    global $wpdb;
    
    $where = $active_only ? "WHERE is_active = 1" : "";
    
    $results = $wpdb->get_results("
        SELECT * FROM {$wpdb->prefix}homepage_sections
        {$where}
        ORDER BY sort_order ASC
    ");
    
    $sections = array();
    foreach ($results as $row) {
        $section = (array) $row;
        if (!empty($section['settings'])) {
            $section['settings'] = !empty($section['settings']) ? json_decode($section['settings'], true) : [];
        }
        $sections[] = $section;
    }
    
    return $sections;
}

/**
 * Get homepage section by key
 */
function virical_get_homepage_section($key) {
    $sections = virical_get_homepage_sections();
    
    foreach ($sections as $section) {
        if ($section['section_key'] === $key) {
            return $section;
        }
    }
    
    return null;
}

/**
 * Get featured products for homepage
 */
function virical_get_featured_products($limit = 8) {
    global $wpdb;
    
    return $wpdb->get_results($wpdb->prepare("
        SELECT p.*, p.category as category_name
        FROM {$wpdb->prefix}virical_products p
        WHERE p.is_active = 1
        ORDER BY p.sort_order ASC, p.created_at DESC
        LIMIT %d
    ", $limit), ARRAY_A);
}

/**
 * Get featured projects for homepage
 */
function virical_get_featured_projects($limit = 6) {
    global $wpdb;
    
    return $wpdb->get_results($wpdb->prepare("
        SELECT p.*, p.type as type_name, p.main_image as featured_image
        FROM {$wpdb->prefix}virical_projects p
        WHERE p.is_active = 1
        ORDER BY p.sort_order ASC, p.created_at DESC
        LIMIT %d
    ", $limit), ARRAY_A);
}

/**
 * Get product categories with count
 */
function virical_get_product_categories_with_count() {
    global $wpdb;
    
    return $wpdb->get_results("
        SELECT category as name, category as slug, COUNT(*) as product_count
        FROM {$wpdb->prefix}virical_products 
        WHERE is_active = 1
        GROUP BY category
        ORDER BY category ASC
    ", ARRAY_A);
}

/**
 * Get contact office information from database
 */
function virical_get_main_office() {
    global $wpdb;
    
    $office = $wpdb->get_row(
        "SELECT * FROM {$wpdb->prefix}contact_offices 
         WHERE is_main = 1 AND is_active = 1 
         ORDER BY sort_order ASC 
         LIMIT 1", 
        ARRAY_A
    );
    
    return $office;
}

/**
 * Get all active contact offices
 */
function virical_get_contact_offices($active_only = true) {
    global $wpdb;
    
    $where = $active_only ? 'WHERE is_active = 1' : '';
    
    $offices = $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}contact_offices 
         {$where}
         ORDER BY sort_order ASC", 
        ARRAY_A
    );
    
    return $offices;
}

/**
 * Get main office email for display
 */
function virical_get_main_office_email() {
    $office = virical_get_main_office();
    return $office ? $office['email'] : 'info@virical.vn';
}

/**
 * Get main office phone for display
 */
function virical_get_main_office_phone() {
    $office = virical_get_main_office();
    return $office ? $office['phone'] : '0869995698';
}

/**
 * Get company contact information from WordPress options
 * Centralized function to retrieve company data (Phase 2)
 *
 * @param string $key The information key (phone, email, address, etc.)
 * @param string $default Default value if option doesn't exist
 * @return string
 */
function virical_get_company_info($key, $default = '') {
    $option_map = [
        'phone' => 'virical_company_phone',
        'mobile' => 'virical_company_mobile',
        'email' => 'virical_company_email',
        'support_email' => 'virical_company_support_email',
        'address' => 'virical_company_address',
        'address_short' => 'virical_company_address_short',
        'name' => 'virical_company_name',
        'short_name' => 'virical_company_short_name',
        'slogan' => 'virical_company_slogan',
        'description' => 'virical_company_description',
        'business_hours' => 'virical_business_hours',
        'business_hours_showroom' => 'virical_business_hours_showroom',
        'hotline' => 'virical_hotline',
        'fax' => 'virical_fax',
        'google_maps' => 'virical_google_maps_embed',
    ];

    $option_name = $option_map[$key] ?? 'virical_company_' . $key;
    return get_option($option_name, $default);
}

/**
 * Get social media links
 *
 * @param string $platform The social platform (facebook, youtube, instagram, linkedin, zalo)
 * @param string $default Default URL if not set
 * @return string
 */
function virical_get_social_link($platform, $default = '#') {
    $option_name = 'virical_social_' . strtolower($platform);
    return get_option($option_name, $default);
}

/**
 * Display company phone with optional icon
 *
 * @param bool $with_icon Whether to include phone icon
 * @return void
 */
function virical_display_phone($with_icon = true) {
    $phone = virical_get_company_info('phone');
    if ($with_icon) {
        echo '<i class="fas fa-phone"></i> ';
    }
    echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
}

/**
 * Display company email with optional icon
 *
 * @param bool $with_icon Whether to include email icon
 * @return void
 */
function virical_display_email($with_icon = true) {
    $email = virical_get_company_info('email');
    if ($with_icon) {
        echo '<i class="fas fa-envelope"></i> ';
    }
    echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
}

/**
 * Debug function (only in development)
 */
if (defined('WP_DEBUG') && WP_DEBUG) {
    function virical_debug($data, $label = '') {
        echo '<pre style="background:#f5f5f5;padding:10px;margin:10px 0;">';
        if ($label) echo "<strong>$label:</strong>\n";
        print_r($data);
        echo '</pre>';
    }
}

/**
 * Get product image URL with fallbacks.
 *
 * @param object $product The product object.
 * @return string The product image URL.
 */
function virical_get_product_image_url($product) {
    // 1. Try the stored image_url first
    if (!empty($product->image_url) && filter_var($product->image_url, FILTER_VALIDATE_URL)) {
        return $product->image_url;
    }

    // 2. Try to find an image in the media library by SKU
    if (!empty($product->sku)) {
        $args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key' => '_wp_attached_file',
                    'value' => $product->sku,
                    'compare' => 'LIKE'
                )
            )
        );
        $attachment = new WP_Query($args);
        if ($attachment->have_posts()) {
            $attachment->the_post();
            return wp_get_attachment_url(get_the_ID());
        }
        wp_reset_postdata();
    }

    // 3. Try to find an image in the media library by title
    if (!empty($product->name)) {
        $args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => 1,
            'title' => $product->name,
        );
        $attachment = new WP_Query($args);
        if ($attachment->have_posts()) {
            $attachment->the_post();
            return wp_get_attachment_url(get_the_ID());
        }
        wp_reset_postdata();
    }

    // 4. Return a placeholder if no image is found
    return get_template_directory_uri() . '/assets/images/default-product.jpg';
}