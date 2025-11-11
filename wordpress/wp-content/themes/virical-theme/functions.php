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

// Include admin menu manager
if (file_exists(get_template_directory() . '/includes/admin-menu-manager.php')) {
    require_once get_template_directory() . '/includes/admin-menu-manager.php';
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
        
        // Enqueue product archive layout CSS
        wp_enqueue_style(
            'virical-product-archive-layout',
            get_stylesheet_directory_uri() . '/css/product-archive-layout.css',
            array(),
            '1.0.0'
        );
        
        // Enqueue product description CSS
        wp_enqueue_style(
            'virical-product-description',
            get_stylesheet_directory_uri() . '/css/product-description.css',
            array(),
            '1.0.0'
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
// DISABLED: This filter is causing duplicate menu items. The custom menu is rendered via virical_render_navigation_menu() instead.
if (!function_exists('gemini_add_product_dropdown')) {
    // add_filter('wp_nav_menu_items', 'gemini_add_product_dropdown', 10, 2);
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
 * Disable WordPress default menu rendering to prevent duplicates
 */
function virical_disable_wp_menu_rendering() {
    // Remove all WordPress menu-related filters and actions
    remove_all_actions('wp_nav_menu');
    remove_all_filters('wp_nav_menu_objects');
    remove_all_filters('wp_nav_menu_items');
    remove_all_filters('wp_nav_menu_args');
}
add_action('init', 'virical_disable_wp_menu_rendering', 1);

/**
 * Output buffer to remove duplicate menus from final HTML
 */
function virical_remove_duplicate_menus_from_html($buffer) {
    // Count how many times ul.main-nav appears
    $nav_count = substr_count($buffer, 'class="main-nav"');
    
    if ($nav_count > 1) {
        // Remove duplicate ul.main-nav elements - keep only the first one
        $pattern = '/(<ul[^>]*class="[^"]*main-nav[^"]*"[^>]*>.*?<\/ul>)/s';
        preg_match_all($pattern, $buffer, $matches);
        
        if (count($matches[0]) > 1) {
            // Replace all occurrences after the first one with empty string
            for ($i = 1; $i < count($matches[0]); $i++) {
                $buffer = str_replace($matches[0][$i], '', $buffer);
            }
        }
    }
    
    return $buffer;
}

function virical_start_output_buffering() {
    ob_start('virical_remove_duplicate_menus_from_html');
}
add_action('template_redirect', 'virical_start_output_buffering', 1);

/**
 * Create demo categories with icons if none exist
 */
if (!function_exists('virical_create_demo_categories')) {
    function virical_create_demo_categories() {
        // Only run once
        if (get_option('virical_demo_categories_created')) {
            return;
        }
        
        $demo_categories = array(
            'Đèn LED Trong Nhà' => 'fas fa-home',
            'Đèn LED Ngoài Trời' => 'fas fa-tree',
            'Đèn LED Thông Minh' => 'fas fa-lightbulb',
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
    add_action('init', 'virical_create_demo_categories');
}

// Enable WordPress editor features for better content editing
function virical_add_editor_support() {
    // Add theme support for editor styles
    add_theme_support('editor-styles');
    
    // Add theme support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add theme support for wide and full alignment
    add_theme_support('align-wide');
    
    // Add theme support for custom line height
    add_theme_support('custom-line-height');
    
    // Add theme support for custom spacing
    add_theme_support('custom-spacing');
    
    // Add theme support for post thumbnails
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'virical_add_editor_support');

// Enable gallery and image blocks for product content
function virical_enable_gutenberg_features() {
    // Make sure Gutenberg is enabled for products
    add_post_type_support('product', 'editor');
    add_post_type_support('product', 'thumbnail');
    add_post_type_support('product', 'custom-fields');
}
add_action('init', 'virical_enable_gutenberg_features');

// Add custom image sizes for product descriptions
function virical_add_image_sizes() {
    add_image_size('product-description', 800, 600, true);
    add_image_size('product-gallery', 400, 300, true);
    add_image_size('product-thumbnail', 300, 300, true);
}
add_action('after_setup_theme', 'virical_add_image_sizes');

// Add image size options to media uploader
function virical_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'product-description' => __('Product Description'),
        'product-gallery' => __('Product Gallery'),
        'product-thumbnail' => __('Product Thumbnail'),
    ));
}
add_filter('image_size_names_choose', 'virical_custom_image_sizes');

// Add help meta box for product editing
function virical_add_product_help_meta_box() {
    add_meta_box(
        'virical_product_help',
        'Hướng dẫn thêm hình ảnh vào mô tả sản phẩm',
        'virical_product_help_callback',
        'product',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'virical_add_product_help_meta_box');

function virical_product_help_callback() {
    ?>
    <div style="padding: 10px;">
        <h4>📷 Cách thêm hình ảnh:</h4>
        <ol style="font-size: 13px; line-height: 1.5;">
            <li><strong>Thêm hình đơn:</strong> Click nút "+" → chọn "Image"</li>
            <li><strong>Thêm gallery:</strong> Click nút "+" → chọn "Gallery"</li>
            <li><strong>Căn chỉnh:</strong> Chọn hình → chọn Left/Center/Right</li>
            <li><strong>Kích thước:</strong> Chọn "Product Description" size</li>
        </ol>
        
        <h4>💡 Lưu ý:</h4>
        <ul style="font-size: 13px; line-height: 1.5;">
            <li>Hình ảnh sẽ tự động có border radius và shadow</li>
            <li>Gallery sẽ hiển thị dạng grid responsive</li>
            <li>Hình ảnh có thể căn trái/phải để text bao quanh</li>
        </ul>
        
        <div style="background: #f0f8ff; padding: 8px; border-radius: 4px; margin-top: 10px;">
            <small><strong>Kích thước khuyến nghị:</strong><br>
            - Hình đơn: 800x600px<br>
            - Gallery: 400x300px mỗi hình</small>
        </div>
    </div>
    <?php
}

// Create custom post type for Blog Management
function virical_create_blog_post_type() {
    $labels = array(
        'name'                  => 'Quản lý Bài viết',
        'singular_name'         => 'Bài viết',
        'menu_name'             => 'Quản lý Bài viết',
        'name_admin_bar'        => 'Bài viết',
        'archives'              => 'Danh sách bài viết',
        'attributes'            => 'Thuộc tính bài viết',
        'parent_item_colon'     => 'Bài viết cha:',
        'all_items'             => 'Tất cả bài viết',
        'add_new_item'          => 'Thêm bài viết mới',
        'add_new'               => 'Thêm mới',
        'new_item'              => 'Bài viết mới',
        'edit_item'             => 'Chỉnh sửa bài viết',
        'update_item'           => 'Cập nhật bài viết',
        'view_item'             => 'Xem bài viết',
        'view_items'            => 'Xem bài viết',
        'search_items'          => 'Tìm kiếm bài viết',
        'not_found'             => 'Không tìm thấy bài viết',
        'not_found_in_trash'    => 'Không tìm thấy bài viết trong thùng rác',
        'featured_image'        => 'Hình đại diện',
        'set_featured_image'    => 'Đặt hình đại diện',
        'remove_featured_image' => 'Xóa hình đại diện',
        'use_featured_image'    => 'Sử dụng làm hình đại diện',
        'insert_into_item'      => 'Chèn vào bài viết',
        'uploaded_to_this_item' => 'Tải lên bài viết này',
        'items_list'            => 'Danh sách bài viết',
        'items_list_navigation' => 'Điều hướng danh sách bài viết',
        'filter_items_list'     => 'Lọc danh sách bài viết',
    );
    
    $args = array(
        'label'                 => 'Bài viết',
        'description'           => 'Quản lý bài viết cho website',
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'taxonomies'            => array('blog_category', 'blog_tag'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-edit-large',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'blog',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type('blog_post', $args);
}
add_action('init', 'virical_create_blog_post_type', 0);

// Create custom taxonomies for blog posts
function virical_create_blog_taxonomies() {
    // Blog Categories
    $category_labels = array(
        'name'              => 'Danh mục Blog',
        'singular_name'     => 'Danh mục',
        'search_items'      => 'Tìm danh mục',
        'all_items'         => 'Tất cả danh mục',
        'parent_item'       => 'Danh mục cha',
        'parent_item_colon' => 'Danh mục cha:',
        'edit_item'         => 'Chỉnh sửa danh mục',
        'update_item'       => 'Cập nhật danh mục',
        'add_new_item'      => 'Thêm danh mục mới',
        'new_item_name'     => 'Tên danh mục mới',
        'menu_name'         => 'Danh mục',
    );

    register_taxonomy('blog_category', array('blog_post'), array(
        'hierarchical'      => true,
        'labels'            => $category_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'blog-category'),
        'show_in_rest'      => true,
    ));

    // Blog Tags
    $tag_labels = array(
        'name'                       => 'Thẻ Blog',
        'singular_name'              => 'Thẻ',
        'search_items'               => 'Tìm thẻ',
        'popular_items'              => 'Thẻ phổ biến',
        'all_items'                  => 'Tất cả thẻ',
        'edit_item'                  => 'Chỉnh sửa thẻ',
        'update_item'                => 'Cập nhật thẻ',
        'add_new_item'               => 'Thêm thẻ mới',
        'new_item_name'              => 'Tên thẻ mới',
        'separate_items_with_commas' => 'Phân cách thẻ bằng dấu phẩy',
        'add_or_remove_items'        => 'Thêm hoặc xóa thẻ',
        'choose_from_most_used'      => 'Chọn từ thẻ được dùng nhiều nhất',
        'not_found'                  => 'Không tìm thấy thẻ',
        'menu_name'                  => 'Thẻ',
    );

    register_taxonomy('blog_tag', array('blog_post'), array(
        'hierarchical'          => false,
        'labels'                => $tag_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array('slug' => 'blog-tag'),
        'show_in_rest'          => true,
    ));
}
add_action('init', 'virical_create_blog_taxonomies', 0);

// Flush rewrite rules on activation
function virical_flush_rewrite_rules() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes because we are only defining it here.
    virical_create_blog_post_type();
    virical_create_blog_taxonomies();
    
    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}

// Hook into the 'init' action so that the function
// Containing our post type registration is not 
// unnecessarily executed. 
add_action('init', 'virical_flush_rewrite_rules_maybe');

function virical_flush_rewrite_rules_maybe() {
    if (get_option('virical_flush_rewrite_rules_flag')) {
        flush_rewrite_rules();
        delete_option('virical_flush_rewrite_rules_flag');
    }
}

// Set flag to flush rewrite rules on next page load
function virical_set_flush_rewrite_rules_flag() {
    add_option('virical_flush_rewrite_rules_flag', true);
}

// Run once to set the flag
if (!get_option('virical_blog_post_type_created')) {
    add_option('virical_blog_post_type_created', true);
    virical_set_flush_rewrite_rules_flag();
}