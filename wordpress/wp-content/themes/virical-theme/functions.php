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

// Include template tags (contains aura_posted_on)
if (file_exists(get_template_directory() . '/inc/template-tags.php')) {
    require_once get_template_directory() . '/inc/template-tags.php';
}

// Include template functions
if (file_exists(get_template_directory() . '/inc/template-functions.php')) {
    require_once get_template_directory() . '/inc/template-functions.php';
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
// // add_action('init', 'virical_custom_rewrite_rules');

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
    $defaults = array(
        'post_type' => 'product',
        'posts_per_page' => 12,
        'offset' => 0,
        'category' => null,
        'featured' => null,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    $args = wp_parse_args($args, $defaults);

    $query_args = array(
        'post_type' => $args['post_type'],
        'posts_per_page' => $args['posts_per_page'],
        'offset' => $args['offset'],
        'orderby' => $args['orderby'],
        'order' => $args['order'],
        'post_status' => 'publish',
    );

    $tax_query = array();
    if (!empty($args['category'])) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $args['category'],
        );
    }
    if (!empty($tax_query)) {
        $query_args['tax_query'] = $tax_query;
    }

    $meta_query = array();
    if ($args['featured'] !== null) {
        $meta_query[] = array(
            'key' => '_featured',
            'value' => 'yes',
            'compare' => '=',
        );
    }
    if (!empty($meta_query)) {
        $query_args['meta_query'] = $meta_query;
    }

    $query = new WP_Query($query_args);
    return $query->posts;
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
        $results = $wpdb->get_results(
            "SELECT setting_key, setting_value, setting_type 
            FROM {$wpdb->prefix}homepage_settings"
        );
        
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
    
    return $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}homepage_sliders
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
    
    $results = $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}homepage_sections
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
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'meta_key' => '_featured',
        'meta_value' => 'yes',
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $query = new WP_Query($args);
    return $query->posts;
}

/**
 * Get featured projects for homepage
 */
function virical_get_featured_projects($limit = 6) {
    global $wpdb;
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT p.*, p.type as type_name, p.main_image as featured_image
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
    $terms = get_terms( array(
        'taxonomy' => 'category',
        'hide_empty' => false,
    ) );
    $categories = array();
    foreach ($terms as $term) {
        $categories[] = array(
            'name' => $term->name,
            'slug' => $term->slug,
            'product_count' => $term->count,
        );
    }
    return $categories;
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

// Add custom field to category add screen
function virical_add_category_logo_field() {
    ?>
    <div class="form-field">
        <label for="category-logo-id"><?php _e( 'Logo', 'virical' ); ?></label>
        <input type="hidden" name="category-logo-id" id="category-logo-id" value="" />
        <div id="category-logo-wrapper"></div>
        <p>
            <input type="button" class="button button-secondary" id="upload-logo-button" value="<?php _e( 'Upload Logo', 'virical' ); ?>" />
            <input type="button" class="button button-secondary" id="remove-logo-button" value="<?php _e( 'Remove Logo', 'virical' ); ?>" />
        </p>
    </div>
    <?php
}
add_action( 'category_add_form_fields', 'virical_add_category_logo_field' );

// Add custom field to category edit screen
function virical_edit_category_logo_field( $term ) {
    $logo_id = get_term_meta( $term->term_id, 'category-logo-id', true );
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category-logo-id"><?php _e( 'Logo', 'virical' ); ?></label></th>
        <td>
            <input type="hidden" name="category-logo-id" id="category-logo-id" value="<?php echo esc_attr( $logo_id ); ?>" />
            <div id="category-logo-wrapper">
                <?php if ( $logo_id ) : ?>
                    <?php echo wp_get_attachment_image( $logo_id, 'thumbnail' ); ?>
                <?php endif; ?>
            </div>
            <p>
                <input type="button" class="button button-secondary" id="upload-logo-button" value="<?php _e( 'Upload Logo', 'virical' ); ?>" />
                <input type="button" class="button button-secondary" id="remove-logo-button" value="<?php _e( 'Remove Logo', 'virical' ); ?>" />
            </p>
        </td>
    </tr>
    <?php
}
add_action( 'category_edit_form_fields', 'virical_edit_category_logo_field' );

// Save custom field
function virical_save_category_logo( $term_id ) {
    if ( isset( $_POST['category-logo-id'] ) ) {
        update_term_meta( $term_id, 'category-logo-id', absint( $_POST['category-logo-id'] ) );
    }
}
add_action( 'created_category', 'virical_save_category_logo' );
add_action( 'edited_category', 'virical_save_category_logo' );

// Enqueue media scripts
function virical_enqueue_media_uploader() {
    wp_enqueue_media();
    wp_print_media_templates();
    ?>
    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;
            $('#upload-logo-button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: '<?php _e( 'Choose Logo', 'virical' ); ?>',
                    button: {
                        text: '<?php _e( 'Choose Logo', 'virical' ); ?>'
                    },
                    multiple: false
                });
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#category-logo-id').val(attachment.id);
                    $('#category-logo-wrapper').html('<img src="' + attachment.url + '" style="max-width:150px;height:auto;" />');
                });
                mediaUploader.open();
            });
            $('#remove-logo-button').click(function(e) {
                e.preventDefault();
                $('#category-logo-id').val('');
                $('#category-logo-wrapper').html('');
            });
        });
    </script>
    <?php
}
add_action( 'admin_footer', 'virical_enqueue_media_uploader' );

// Add logo column to category list
function virical_add_category_logo_column( $columns ) {
    $columns['logo'] = __( 'Logo', 'virical' );
    return $columns;
}
add_filter( 'manage_edit-category_columns', 'virical_add_category_logo_column' );

// Display logo in the column
function virical_display_category_logo_column( $content, $column_name, $term_id ) {
    if ( 'logo' === $column_name ) {
        $logo_id = get_term_meta( $term_id, 'category-logo-id', true );
        if ( $logo_id ) {
            $content = wp_get_attachment_image( $logo_id, 'thumbnail' );
        }
    }
    return $content;
}
add_filter( 'manage_category_custom_column', 'virical_display_category_logo_column', 10, 3 );
// =========== CUSTOM MEGA MENU BY GEMINI START ===========

// 1. Enqueue the custom menu stylesheet
if (!function_exists('gemini_enqueue_menu_styles')) {
    add_action('wp_enqueue_scripts', 'gemini_enqueue_menu_styles');
    function gemini_enqueue_menu_styles() {
        wp_enqueue_style(
            'gemini-custom-menu',
            get_stylesheet_directory_uri() . '/css/custom-menu.css',
            array(),
            '1.0.1' // Version bump
        );
    }
}

// 2. Add SVG support for uploads
if (!function_exists('gemini_add_svg_to_upload_mimes')) {
    add_filter('upload_mimes', 'gemini_add_svg_to_upload_mimes');
    function gemini_add_svg_to_upload_mimes($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
}

// 3. Filter the navigation menu to add the dynamic dropdown
if (!function_exists('gemini_add_product_dropdown')) {
    add_filter('wp_nav_menu_items', 'gemini_add_product_dropdown', 10, 2);
    function gemini_add_product_dropdown($items, $args) {
        // DEBUG: This will run on ALL menus to ensure it triggers.
        // if (isset($args->theme_location) && $args->theme_location == 'primary') {
            
            if (!empty($items) && strpos($items, 'menu-item') !== false) {
                $doc = new DOMDocument();
                @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $items);
                $xpath = new DOMXPath($doc);

                // DEBUG: Target the 2nd menu item instead of searching for text.
                $product_lis = $xpath->query('//li[contains(@class, "menu-item")][2]');

                if ($product_lis->length > 0) {
                    $product_li = $product_lis->item(0);
                    $product_link = $xpath->query('.//a', $product_li)->item(0);

                    // Get product categories (WooCommerce)
                    $product_categories = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0));

                    if (!empty($product_categories) && !is_wp_error($product_categories)) {
                        $dropdown_div = $doc->createElement('div');
                        $dropdown_div->setAttribute('class', 'dropdown-content');

                        foreach ($product_categories as $category) {
                            $category_link_url = get_term_link($category);
                            $category_name = $category->name;
                            $logo_id = get_term_meta($category->term_id, 'category-logo-id', true);
                            if (!$logo_id) { $logo_id = get_term_meta($category->term_id, 'thumbnail_id', true); }
                            $image_url = $logo_id ? wp_get_attachment_url($logo_id) : get_stylesheet_directory_uri() . '/assets/images/default-product.jpg';

                            $item_a = $doc->createElement('a');
                            $item_a->setAttribute('href', esc_url($category_link_url));
                            $item_a->setAttribute('class', 'dropdown-item');
                            $img = $doc->createElement('img');
                            $img->setAttribute('src', esc_url($image_url));
                            $img->setAttribute('alt', esc_attr($category_name));
                            $img->setAttribute('class', 'icon');
                            $span = $doc->createElement('span', esc_html($category_name));
                            $item_a->appendChild($img);
                            $item_a->appendChild($span);
                            $dropdown_div->appendChild($item_a);
                        }

                        $product_li->setAttribute('class', $product_li->getAttribute('class') . ' menu-item-has-children dropdown');
                        
                        if ($product_link) {
                            $product_link->nodeValue = '';
                            $toggle_span = $doc->createElement('span', 'DEBUG MENU ');
                            $toggle_span->setAttribute('class', 'dropdown-toggle');
                            $caret_span = $doc->createElement('span');
                            $caret_span->setAttribute('class', 'caret');
                            $toggle_span->appendChild($caret_span);
                            $product_link->appendChild($toggle_span);
                        }

                        $product_li->appendChild($dropdown_div);
                    }
                }
                
                $items = $doc->saveHTML();
                $items = preg_replace('~<(?:!DOCTYPE|/?(?:html|body|xml))[^>]*>\s*~i', '', $items);
            }
        // }
        return $items;
    }
}

// =========== CUSTOM MEGA MENU BY GEMINI END ===========

// =========== CATEGORY LOGO MANAGEMENT ===========

/**
 * Add category logo field to category add/edit forms
 */
if (!function_exists('virical_add_category_logo_field')) {
    add_action('category_add_form_fields', 'virical_add_category_logo_field');
    add_action('category_edit_form_fields', 'virical_edit_category_logo_field');
    
    function virical_add_category_logo_field() {
        ?>
        <div class="form-field">
            <label for="category_logo"><?php _e('Category Logo'); ?></label>
            <input type="hidden" id="category_logo" name="category_logo" value="" />
            <button type="button" class="button" id="upload_category_logo"><?php _e('Upload Logo'); ?></button>
            <div id="category_logo_preview"></div>
            <p class="description"><?php _e('Upload a logo for this category to display in dropdown menu.'); ?></p>
        </div>
        <script>
        jQuery(document).ready(function($) {
            $('#upload_category_logo').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Category Logo',
                    multiple: false
                }).open().on('select', function(e){
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    var image_id = uploaded_image.toJSON().id;
                    $('#category_logo').val(image_id);
                    $('#category_logo_preview').html('<img src="' + image_url + '" style="max-width: 100px; height: auto;" />');
                });
            });
        });
        </script>
        <?php
    }
    
    function virical_edit_category_logo_field($term) {
        $logo_id = get_term_meta($term->term_id, 'category_logo', true);
        $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="category_logo"><?php _e('Category Logo'); ?></label></th>
            <td>
                <input type="hidden" id="category_logo" name="category_logo" value="<?php echo esc_attr($logo_id); ?>" />
                <button type="button" class="button" id="upload_category_logo"><?php _e('Upload Logo'); ?></button>
                <div id="category_logo_preview">
                    <?php if ($logo_url): ?>
                        <img src="<?php echo esc_url($logo_url); ?>" style="max-width: 100px; height: auto;" />
                    <?php endif; ?>
                </div>
                <p class="description"><?php _e('Upload a logo for this category to display in dropdown menu.'); ?></p>
            </td>
        </tr>
        <script>
        jQuery(document).ready(function($) {
            $('#upload_category_logo').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Category Logo',
                    multiple: false
                }).open().on('select', function(e){
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    var image_id = uploaded_image.toJSON().id;
                    $('#category_logo').val(image_id);
                    $('#category_logo_preview').html('<img src="' + image_url + '" style="max-width: 100px; height: auto;" />');
                });
            });
        });
        </script>
        <?php
    }
}

/**
 * Save category logo field
 */
if (!function_exists('virical_save_category_logo')) {
    add_action('created_category', 'virical_save_category_logo');
    add_action('edited_category', 'virical_save_category_logo');
    
    function virical_save_category_logo($term_id) {
        if (isset($_POST['category_logo'])) {
            update_term_meta($term_id, 'category_logo', sanitize_text_field($_POST['category_logo']));
        }
    }
}

/**
 * Get category logo URL
 */
if (!function_exists('virical_get_category_logo')) {
    function virical_get_category_logo($term_id, $size = 'thumbnail') {
        // Try multiple possible meta keys for category logo
        $logo_id = get_term_meta($term_id, 'category_logo', true);
        if (!$logo_id) {
            $logo_id = get_term_meta($term_id, 'category-logo-id', true);
        }
        if (!$logo_id) {
            $logo_id = get_term_meta($term_id, 'thumbnail_id', true);
        }
        if (!$logo_id) {
            $logo_id = get_term_meta($term_id, 'category_image', true);
        }
        
        if ($logo_id) {
            $logo_data = wp_get_attachment_image_src($logo_id, $size);
            if ($logo_data) {
                return $logo_data[0];
            }
        }
        
        return false;
    }
}

/**
 * Enqueue media uploader for category logo
 */
if (!function_exists('virical_enqueue_category_media')) {
    add_action('admin_enqueue_scripts', 'virical_enqueue_category_media');
    
    function virical_enqueue_category_media($hook) {
        if ($hook == 'edit-tags.php' || $hook == 'term.php') {
            wp_enqueue_media();
        }
    }
}

/**
 * Create demo categories with icons if none exist
 */
if (!function_exists('virical_create_demo_categories')) {
    add_action('init', 'virical_create_demo_categories');
    
    function virical_create_demo_categories() {
        // Only run once
        if (get_option('virical_demo_categories_created')) {
            return;
        }
        
        $demo_categories = array(
            'Đèn LED Trong Nhà' => 'fas fa-home',
            'Đèn LED Ngoài Trời' => 'fas fa-tree',
            'Đèn LED Thông Minh' => 'fas fa-wifi',
            'Đèn LED Công Nghiệp' => 'fas fa-industry',
            'Đèn LED Trang Trí' => 'fas fa-star',
            'Đèn LED Ô Tô' => 'fas fa-car'
        );
        
        foreach ($demo_categories as $name => $icon) {
            // Check if category already exists
            $existing = get_term_by('name', $name, 'category');
            if (!$existing) {
                $term = wp_insert_term($name, 'category', array(
                    'description' => 'Danh mục sản phẩm ' . $name,
                    'slug' => sanitize_title($name)
                ));
                
                if (!is_wp_error($term)) {
                    // Store icon class as meta for fallback
                    update_term_meta($term['term_id'], 'category_icon', $icon);
                }
            }
        }
        
        // Mark as created
        update_option('virical_demo_categories_created', true);
    }
}