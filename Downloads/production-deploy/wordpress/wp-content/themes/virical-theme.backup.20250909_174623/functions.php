<?php
/**
 * Virical Theme Functions
 *
 * @package Virical
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define Constants
 */
define( 'AURA_THEME_VERSION', '1.0.0' );
define( 'AURA_THEME_DIR', get_template_directory() );
define( 'AURA_THEME_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function aura_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );

    // Add theme support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 90,
        'width'       => 174,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Register navigation menus
    register_nav_menus( array(
        'primary'   => esc_html__( 'Primary Menu', 'aura-lighting' ),
        'footer'    => esc_html__( 'Footer Menu', 'aura-lighting' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for core custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 90,
        'width'       => 174,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Add support for responsive embedded content
    add_theme_support( 'responsive-embeds' );

    // Add support for wide alignment
    add_theme_support( 'align-wide' );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );

    // Enqueue editor styles
    add_editor_style( 'style-editor.css' );
}
add_action( 'after_setup_theme', 'aura_theme_setup' );

/**
 * Set the content width in pixels
 */
function aura_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'aura_content_width', 1240 );
}
add_action( 'after_setup_theme', 'aura_content_width', 0 );

/**
 * Enqueue scripts and styles
 */
function aura_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style( 'aura-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap', array(), null );

    // Enqueue theme stylesheet
    wp_enqueue_style( 'aura-style', get_stylesheet_uri(), array(), AURA_THEME_VERSION );

    // Enqueue custom styles with higher priority
    wp_enqueue_style( 'aura-custom', AURA_THEME_URI . '/assets/css/custom-styles.css', array(), AURA_THEME_VERSION );
    
    // Enqueue main CSS files
    wp_enqueue_style( 'aura-main', AURA_THEME_URI . '/assets/css/style.min.css', array(), AURA_THEME_VERSION );
    wp_enqueue_style( 'aura-frontend', AURA_THEME_URI . '/assets/css/frontend.min.css', array(), AURA_THEME_VERSION );
    wp_enqueue_style( 'aura-responsive', AURA_THEME_URI . '/assets/css/responsive.css', array(), AURA_THEME_VERSION );
    wp_enqueue_style( 'aura-page-templates', AURA_THEME_URI . '/assets/css/page-templates.css', array(), AURA_THEME_VERSION );

    // Enqueue Font Awesome
    wp_enqueue_style( 'font-awesome', AURA_THEME_URI . '/assets/css/all.min.css', array(), '5.15.4' );

    // Enqueue jQuery (WordPress includes jQuery)
    wp_enqueue_script( 'jquery' );

    // Enqueue main JavaScript files
    wp_enqueue_script( 'aura-header', AURA_THEME_URI . '/assets/js/header.js', array('jquery'), AURA_THEME_VERSION, true );
    wp_enqueue_script( 'aura-main', AURA_THEME_URI . '/assets/js/main.js', array('jquery'), AURA_THEME_VERSION, true );
    wp_enqueue_script( 'aura-frontend', AURA_THEME_URI . '/assets/js/frontend.min.js', array('jquery'), AURA_THEME_VERSION, true );

    // Enqueue comment reply script for threaded comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Localize script for AJAX
    wp_localize_script( 'aura-main', 'aura_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'aura_ajax_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'aura_scripts' );

/**
 * Register widget area
 */
function aura_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'aura-lighting' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'aura-lighting' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 1', 'aura-lighting' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Footer widget area 1', 'aura-lighting' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 2', 'aura-lighting' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Footer widget area 2', 'aura-lighting' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 3', 'aura-lighting' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Footer widget area 3', 'aura-lighting' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'aura_widgets_init' );

/**
 * Custom Post Type for Products
 */
function aura_register_products_post_type() {
    $labels = array(
        'name'                  => _x( 'Products', 'Post type general name', 'aura-lighting' ),
        'singular_name'         => _x( 'Product', 'Post type singular name', 'aura-lighting' ),
        'menu_name'             => _x( 'Products', 'Admin Menu text', 'aura-lighting' ),
        'name_admin_bar'        => _x( 'Product', 'Add New on Toolbar', 'aura-lighting' ),
        'add_new'               => __( 'Add New', 'aura-lighting' ),
        'add_new_item'          => __( 'Add New Product', 'aura-lighting' ),
        'new_item'              => __( 'New Product', 'aura-lighting' ),
        'edit_item'             => __( 'Edit Product', 'aura-lighting' ),
        'view_item'             => __( 'View Product', 'aura-lighting' ),
        'all_items'             => __( 'All Products', 'aura-lighting' ),
        'search_items'          => __( 'Search Products', 'aura-lighting' ),
        'parent_item_colon'     => __( 'Parent Products:', 'aura-lighting' ),
        'not_found'             => __( 'No products found.', 'aura-lighting' ),
        'not_found_in_trash'    => __( 'No products found in Trash.', 'aura-lighting' ),
        'featured_image'        => _x( 'Product Cover Image', 'Overrides the "Featured Image" phrase', 'aura-lighting' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase', 'aura-lighting' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase', 'aura-lighting' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase', 'aura-lighting' ),
        'archives'              => _x( 'Product archives', 'The post type archive label', 'aura-lighting' ),
        'insert_into_item'      => _x( 'Insert into product', 'Overrides the "Insert into post" phrase', 'aura-lighting' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this product', 'Overrides the "Uploaded to this post" phrase', 'aura-lighting' ),
        'filter_items_list'     => _x( 'Filter products list', 'Screen reader text', 'aura-lighting' ),
        'items_list_navigation' => _x( 'Products list navigation', 'Screen reader text', 'aura-lighting' ),
        'items_list'            => _x( 'Products list', 'Screen reader text', 'aura-lighting' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'products' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-lightbulb',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'aura_product', $args );
}
add_action( 'init', 'aura_register_products_post_type' );

/**
 * Register Product Categories
 */
function aura_register_product_categories() {
    $labels = array(
        'name'              => _x( 'Product Categories', 'taxonomy general name', 'aura-lighting' ),
        'singular_name'     => _x( 'Product Category', 'taxonomy singular name', 'aura-lighting' ),
        'search_items'      => __( 'Search Categories', 'aura-lighting' ),
        'all_items'         => __( 'All Categories', 'aura-lighting' ),
        'parent_item'       => __( 'Parent Category', 'aura-lighting' ),
        'parent_item_colon' => __( 'Parent Category:', 'aura-lighting' ),
        'edit_item'         => __( 'Edit Category', 'aura-lighting' ),
        'update_item'       => __( 'Update Category', 'aura-lighting' ),
        'add_new_item'      => __( 'Add New Category', 'aura-lighting' ),
        'new_item_name'     => __( 'New Category Name', 'aura-lighting' ),
        'menu_name'         => __( 'Categories', 'aura-lighting' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'product-category' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'product_category', array( 'aura_product' ), $args );
}
add_action( 'init', 'aura_register_product_categories' );

/**
 * Custom Post Type for Projects
 */
function aura_register_projects_post_type() {
    $labels = array(
        'name'                  => _x( 'Projects', 'Post type general name', 'aura-lighting' ),
        'singular_name'         => _x( 'Project', 'Post type singular name', 'aura-lighting' ),
        'menu_name'             => _x( 'Projects', 'Admin Menu text', 'aura-lighting' ),
        'name_admin_bar'        => _x( 'Project', 'Add New on Toolbar', 'aura-lighting' ),
        'add_new'               => __( 'Add New', 'aura-lighting' ),
        'add_new_item'          => __( 'Add New Project', 'aura-lighting' ),
        'new_item'              => __( 'New Project', 'aura-lighting' ),
        'edit_item'             => __( 'Edit Project', 'aura-lighting' ),
        'view_item'             => __( 'View Project', 'aura-lighting' ),
        'all_items'             => __( 'All Projects', 'aura-lighting' ),
        'search_items'          => __( 'Search Projects', 'aura-lighting' ),
        'not_found'             => __( 'No projects found.', 'aura-lighting' ),
        'not_found_in_trash'    => __( 'No projects found in Trash.', 'aura-lighting' ),
        'featured_image'        => _x( 'Project Cover Image', 'Overrides the "Featured Image" phrase', 'aura-lighting' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase', 'aura-lighting' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase', 'aura-lighting' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase', 'aura-lighting' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'projects' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'aura_project', $args );
}
add_action( 'init', 'aura_register_projects_post_type' );

/**
 * Flush rewrite rules on theme activation
 */
function aura_flush_rewrite_rules() {
    aura_register_products_post_type();
    aura_register_projects_post_type();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'aura_flush_rewrite_rules' );

/**
 * Add custom image sizes
 */
function aura_add_image_sizes() {
    add_image_size( 'aura-product-thumb', 300, 300, true );
    add_image_size( 'aura-product-full', 1024, 1024, true );
    add_image_size( 'aura-project-thumb', 400, 300, true );
    add_image_size( 'aura-project-full', 1200, 800, true );
}
add_action( 'after_setup_theme', 'aura_add_image_sizes' );

/**
 * Customize excerpt length
 */
function aura_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'aura_excerpt_length', 999 );

/**
 * Customize excerpt more
 */
function aura_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'aura_excerpt_more' );

/**
 * Add rewrite rules for product detail pages
 */
function aura_add_product_rewrite_rules() {
    add_rewrite_rule(
        'san-pham/([^/]+)/?$',
        'index.php?pagename=san-pham&product_slug=$matches[1]',
        'top'
    );
    
    add_rewrite_tag('%product_slug%', '([^&]+)');
}
add_action('init', 'aura_add_product_rewrite_rules');

/**
 * Template redirect for product detail
 */
function aura_product_template_redirect() {
    if (get_query_var('product_slug')) {
        include(get_template_directory() . '/single-product.php');
        exit;
    }
}
add_action('template_redirect', 'aura_product_template_redirect');

/**
 * Custom Post Type for Homepage Slider
 */
function aura_register_slider_post_type() {
    $labels = array(
        'name'                  => _x( 'Slides', 'Post type general name', 'aura-lighting' ),
        'singular_name'         => _x( 'Slide', 'Post type singular name', 'aura-lighting' ),
        'menu_name'             => _x( 'Homepage Slider', 'Admin Menu text', 'aura-lighting' ),
        'add_new'               => __( 'Add New Slide', 'aura-lighting' ),
        'add_new_item'          => __( 'Add New Slide', 'aura-lighting' ),
        'edit_item'             => __( 'Edit Slide', 'aura-lighting' ),
        'view_item'             => __( 'View Slide', 'aura-lighting' ),
        'all_items'             => __( 'All Slides', 'aura-lighting' ),
        'search_items'          => __( 'Search Slides', 'aura-lighting' ),
        'not_found'             => __( 'No slides found.', 'aura-lighting' ),
        'not_found_in_trash'    => __( 'No slides found in Trash.', 'aura-lighting' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-images-alt2',
        'supports'           => array( 'title', 'thumbnail' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'aura_slider', $args );
}
add_action( 'init', 'aura_register_slider_post_type' );

/**
 * Add Meta Boxes for Slider
 */
function aura_add_slider_meta_boxes() {
    add_meta_box(
        'aura_slider_details',
        __( 'Slide Details', 'aura-lighting' ),
        'aura_slider_meta_box_callback',
        'aura_slider',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'aura_add_slider_meta_boxes' );

/**
 * Slider Meta Box Callback
 */
function aura_slider_meta_box_callback( $post ) {
    wp_nonce_field( 'aura_slider_meta_box', 'aura_slider_meta_box_nonce' );
    
    $slide_subtitle = get_post_meta( $post->ID, '_slide_subtitle', true );
    $box_title = get_post_meta( $post->ID, '_box_title', true );
    $slide_link = get_post_meta( $post->ID, '_slide_link', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="slide_subtitle"><?php _e( 'Slide Subtitle', 'aura-lighting' ); ?></label></th>
            <td>
                <input type="text" id="slide_subtitle" name="slide_subtitle" value="<?php echo esc_attr( $slide_subtitle ); ?>" class="regular-text" />
                <p class="description"><?php _e( 'Main title of the slide (e.g., "BỘ SƯU TẬP 2022")', 'aura-lighting' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="box_title"><?php _e( 'Box Title', 'aura-lighting' ); ?></label></th>
            <td>
                <input type="text" id="box_title" name="box_title" value="<?php echo esc_attr( $box_title ); ?>" class="regular-text" />
                <p class="description"><?php _e( 'Text inside the white box (e.g., "THIẾT KẾ HIỆN ĐẠI")', 'aura-lighting' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="slide_link"><?php _e( 'Slide Link', 'aura-lighting' ); ?></label></th>
            <td>
                <input type="url" id="slide_link" name="slide_link" value="<?php echo esc_url( $slide_link ); ?>" class="regular-text" />
                <p class="description"><?php _e( 'Optional link when clicking on the slide', 'aura-lighting' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save Slider Meta Box Data
 */
function aura_save_slider_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['aura_slider_meta_box_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['aura_slider_meta_box_nonce'], 'aura_slider_meta_box' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    if ( isset( $_POST['slide_subtitle'] ) ) {
        update_post_meta( $post_id, '_slide_subtitle', sanitize_text_field( $_POST['slide_subtitle'] ) );
    }
    
    if ( isset( $_POST['box_title'] ) ) {
        update_post_meta( $post_id, '_box_title', sanitize_text_field( $_POST['box_title'] ) );
    }
    
    if ( isset( $_POST['slide_link'] ) ) {
        update_post_meta( $post_id, '_slide_link', esc_url_raw( $_POST['slide_link'] ) );
    }
}
add_action( 'save_post', 'aura_save_slider_meta_box_data' );

/**
 * Add Homepage Settings to Customizer
 */
function aura_homepage_customizer( $wp_customize ) {
    // Add Homepage Section
    $wp_customize->add_section( 'aura_homepage_settings', array(
        'title'    => __( 'Homepage Settings', 'aura-lighting' ),
        'priority' => 30,
    ) );
    
    // About Section Title
    $wp_customize->add_setting( 'aura_about_title', array(
        'default'           => 'VIRICAL - FEELING LIGHT',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'aura_about_title', array(
        'label'    => __( 'About Section Title', 'aura-lighting' ),
        'section'  => 'aura_homepage_settings',
        'type'     => 'text',
    ) );
    
    // About Section Subtitle
    $wp_customize->add_setting( 'aura_about_subtitle', array(
        'default'           => 'VỀ CHÚNG TÔI',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'aura_about_subtitle', array(
        'label'    => __( 'About Section Subtitle', 'aura-lighting' ),
        'section'  => 'aura_homepage_settings',
        'type'     => 'text',
    ) );
    
    // About Section Content
    $wp_customize->add_setting( 'aura_about_content', array(
        'default'           => 'VIRICAL là thương hiệu đèn chiếu sáng cao cấp...',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    
    $wp_customize->add_control( 'aura_about_content', array(
        'label'    => __( 'About Section Content', 'aura-lighting' ),
        'section'  => 'aura_homepage_settings',
        'type'     => 'textarea',
    ) );
    
    // Products Section Title
    $wp_customize->add_setting( 'aura_products_title', array(
        'default'           => 'SẢN PHẨM NỔI BẬT',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'aura_products_title', array(
        'label'    => __( 'Products Section Title', 'aura-lighting' ),
        'section'  => 'aura_homepage_settings',
        'type'     => 'text',
    ) );
    
    // Projects Section Title
    $wp_customize->add_setting( 'aura_projects_title', array(
        'default'           => 'DỰ ÁN TIÊU BIỂU',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'aura_projects_title', array(
        'label'    => __( 'Projects Section Title', 'aura-lighting' ),
        'section'  => 'aura_homepage_settings',
        'type'     => 'text',
    ) );
}
add_action( 'customize_register', 'aura_homepage_customizer' );

/**
 * Include additional files
 */
require_once AURA_THEME_DIR . '/inc/template-functions.php';
require_once AURA_THEME_DIR . '/inc/template-tags.php';
require_once AURA_THEME_DIR . '/inc/customizer.php';

// Include About Page admin settings
require_once AURA_THEME_DIR . '/includes/about-page-admin.php';

// Include Products admin settings
require_once AURA_THEME_DIR . '/includes/products-admin.php';

// Include Projects admin settings
require_once AURA_THEME_DIR . '/includes/projects-admin.php';

// Include Migration tool
require_once AURA_THEME_DIR . '/includes/migrate-aura-to-virical.php';

// Include Product Redirects
require_once AURA_THEME_DIR . '/includes/product-redirects.php';

// Include Menu Updater
require_once AURA_THEME_DIR . '/includes/menu-updater.php';

// Include Virical Search
require_once AURA_THEME_DIR . '/includes/virical-search.php';

// Include Company Settings
require_once AURA_THEME_DIR . '/includes/company-settings.php';

// Include Product Settings
require_once AURA_THEME_DIR . '/includes/product-settings.php';

// Include Footer Menu Settings
require_once AURA_THEME_DIR . '/includes/footer-menu-settings.php';