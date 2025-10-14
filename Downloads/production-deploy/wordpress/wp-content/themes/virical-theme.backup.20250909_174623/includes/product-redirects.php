<?php
/**
 * Product URL Redirects
 * Handles redirects from old Aura URLs to new Virical URLs
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle product redirects
 */
add_action('template_redirect', 'virical_handle_product_redirects', 5);
function virical_handle_product_redirects() {
    global $wpdb;
    
    // Check if we're on an old product URL
    if (is_singular('aura_product')) {
        $post = get_post();
        if ($post) {
            // Check if this product has been migrated
            $migrated = get_post_meta($post->ID, '_migrated_to_virical', true);
            $virical_id = get_post_meta($post->ID, '_virical_product_id', true);
            
            if ($migrated && $virical_id) {
                // Get the Virical product slug
                $virical_slug = $wpdb->get_var($wpdb->prepare(
                    "SELECT slug FROM {$wpdb->prefix}virical_products WHERE id = %d",
                    $virical_id
                ));
                
                if ($virical_slug) {
                    // Redirect to new URL
                    $new_url = home_url('/san-pham/' . $virical_slug . '/');
                    wp_redirect($new_url, 301);
                    exit;
                }
            }
        }
    }
    
    // Handle category redirects
    if (is_tax('product_category')) {
        $term = get_queried_object();
        if ($term) {
            // Check if Virical system has products
            $virical_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}virical_products WHERE is_active = 1");
            
            if ($virical_count > 0) {
                // Redirect to Virical category page
                $new_url = home_url('/san-pham/?category=' . $term->slug);
                wp_redirect($new_url, 301);
                exit;
            }
        }
    }
}

/**
 * Add rewrite rules for both old and new URLs
 */
add_action('init', 'virical_add_compatibility_rewrite_rules', 20);
function virical_add_compatibility_rewrite_rules() {
    // Keep existing san-pham rules
    add_rewrite_rule(
        'san-pham/([^/]+)/?$',
        'index.php?pagename=san-pham&product_slug=$matches[1]',
        'top'
    );
    
    // Add category support for san-pham
    add_rewrite_rule(
        'san-pham/category/([^/]+)/?$',
        'index.php?pagename=san-pham&category=$matches[1]',
        'top'
    );
}

/**
 * Generate redirect map for all products
 */
function virical_generate_redirect_map() {
    global $wpdb;
    
    $redirect_map = array();
    
    // Get all migrated products
    $migrated_products = get_posts(array(
        'post_type' => 'aura_product',
        'posts_per_page' => -1,
        'meta_key' => '_migrated_to_virical',
        'meta_value' => true
    ));
    
    foreach ($migrated_products as $product) {
        $virical_id = get_post_meta($product->ID, '_virical_product_id', true);
        if ($virical_id) {
            $virical_slug = $wpdb->get_var($wpdb->prepare(
                "SELECT slug FROM {$wpdb->prefix}virical_products WHERE id = %d",
                $virical_id
            ));
            
            if ($virical_slug) {
                $old_url = str_replace(home_url(), '', get_permalink($product->ID));
                $new_url = '/san-pham/' . $virical_slug . '/';
                $redirect_map[$old_url] = $new_url;
            }
        }
    }
    
    // Save redirect map as option
    update_option('virical_redirect_map', $redirect_map);
    
    return $redirect_map;
}

/**
 * Handle 404 errors for old URLs
 */
add_action('template_redirect', 'virical_handle_404_redirects', 999);
function virical_handle_404_redirects() {
    if (is_404()) {
        global $wp;
        $current_url = '/' . $wp->request . '/';
        
        // Check if this matches an old product pattern
        if (preg_match('/^\/products\/([^\/]+)\/?$/', $current_url, $matches)) {
            $old_slug = $matches[1];
            
            // Try to find in Virical products
            global $wpdb;
            $virical_slug = $wpdb->get_var($wpdb->prepare(
                "SELECT slug FROM {$wpdb->prefix}virical_products WHERE slug = %s OR slug LIKE %s",
                $old_slug,
                '%' . $old_slug . '%'
            ));
            
            if ($virical_slug) {
                wp_redirect(home_url('/san-pham/' . $virical_slug . '/'), 301);
                exit;
            }
        }
    }
}

/**
 * Update internal links in content
 */
add_filter('the_content', 'virical_update_product_links');
function virical_update_product_links($content) {
    // Only process if we have a redirect map
    $redirect_map = get_option('virical_redirect_map', array());
    
    if (!empty($redirect_map)) {
        foreach ($redirect_map as $old_url => $new_url) {
            $old_full_url = home_url($old_url);
            $new_full_url = home_url($new_url);
            
            // Replace full URLs
            $content = str_replace($old_full_url, $new_full_url, $content);
            
            // Replace relative URLs
            $content = str_replace('"' . $old_url . '"', '"' . $new_url . '"', $content);
            $content = str_replace("'" . $old_url . "'", "'" . $new_url . "'", $content);
        }
    }
    
    return $content;
}

/**
 * Admin notice for redirect status
 */
add_action('admin_notices', 'virical_redirect_admin_notice');
function virical_redirect_admin_notice() {
    if (get_option('virical_show_redirect_notice')) {
        $redirect_map = get_option('virical_redirect_map', array());
        $count = count($redirect_map);
        ?>
        <div class="notice notice-info is-dismissible">
            <p><?php printf(__('Virical Redirects: %d product URLs are being redirected from old to new format.', 'virical'), $count); ?></p>
            <p><a href="<?php echo admin_url('admin.php?page=virical-products&tab=redirects'); ?>"><?php _e('View Redirect Map', 'virical'); ?></a></p>
        </div>
        <?php
        delete_option('virical_show_redirect_notice');
    }
}

/**
 * Generate redirects after migration
 */
add_action('virical_after_migration', 'virical_setup_redirects');
function virical_setup_redirects() {
    virical_generate_redirect_map();
    update_option('virical_show_redirect_notice', true);
    
    // Flush rewrite rules
    flush_rewrite_rules();
}