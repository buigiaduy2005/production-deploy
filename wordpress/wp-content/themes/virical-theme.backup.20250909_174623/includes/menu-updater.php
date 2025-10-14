<?php
/**
 * Menu Link Updater
 * Updates menu items to use new Virical URLs
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Update menu items to use Virical URLs
 */
function virical_update_menu_links() {
    $menus = wp_get_nav_menus();
    $updated_count = 0;
    
    foreach ($menus as $menu) {
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        
        foreach ($menu_items as $item) {
            $updated = false;
            
            // Check if this is a product category link
            if ($item->object == 'product_category') {
                // Update to new URL format
                $term = get_term($item->object_id, 'product_category');
                if ($term && !is_wp_error($term)) {
                    $new_url = home_url('/san-pham/?category=' . $term->slug);
                    wp_update_nav_menu_item($menu->term_id, $item->ID, array(
                        'menu-item-url' => $new_url,
                        'menu-item-type' => 'custom'
                    ));
                    $updated = true;
                }
            }
            
            // Check if this is a product archive link
            elseif ($item->type == 'post_type_archive' && $item->object == 'aura_product') {
                // Update to san-pham page
                wp_update_nav_menu_item($menu->term_id, $item->ID, array(
                    'menu-item-url' => home_url('/san-pham/'),
                    'menu-item-type' => 'custom'
                ));
                $updated = true;
            }
            
            // Check custom links that might point to old URLs
            elseif ($item->type == 'custom') {
                $url = $item->url;
                
                // Update product archive links
                if (strpos($url, '/products') !== false || strpos($url, 'post_type=aura_product') !== false) {
                    $new_url = str_replace(array('/products', 'post_type=aura_product'), array('/san-pham', 'page=san-pham'), $url);
                    wp_update_nav_menu_item($menu->term_id, $item->ID, array(
                        'menu-item-url' => $new_url
                    ));
                    $updated = true;
                }
            }
            
            if ($updated) {
                $updated_count++;
            }
        }
    }
    
    return $updated_count;
}

/**
 * Admin page for menu updater
 */
function virical_menu_updater_page() {
    ?>
    <div class="wrap">
        <h1>Update Menu Links</h1>
        
        <?php
        if (isset($_POST['update_menus']) && check_admin_referer('virical_update_menus')) {
            $count = virical_update_menu_links();
            echo '<div class="notice notice-success"><p>' . sprintf(__('Updated %d menu items.', 'virical'), $count) . '</p></div>';
        }
        ?>
        
        <div class="card">
            <h2>Menu Link Updater</h2>
            <p>This tool will update all menu links from old Aura product URLs to new Virical URLs.</p>
            
            <h3>Current Menus:</h3>
            <?php
            $menus = wp_get_nav_menus();
            if (!empty($menus)) {
                echo '<ul>';
                foreach ($menus as $menu) {
                    $items = wp_get_nav_menu_items($menu->term_id);
                    $product_items = 0;
                    
                    foreach ($items as $item) {
                        if ($item->object == 'product_category' || 
                            $item->object == 'aura_product' ||
                            (strpos($item->url, '/products') !== false)) {
                            $product_items++;
                        }
                    }
                    
                    echo '<li>' . esc_html($menu->name) . ' - ' . sprintf(__('%d product-related items', 'virical'), $product_items) . '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No menus found.</p>';
            }
            ?>
            
            <form method="post" action="">
                <?php wp_nonce_field('virical_update_menus'); ?>
                <p>
                    <input type="submit" name="update_menus" class="button button-primary" value="Update Menu Links">
                </p>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Add submenu page
 */
add_action('admin_menu', 'virical_add_menu_updater_page');
function virical_add_menu_updater_page() {
    add_submenu_page(
        'virical-products',
        'Update Menus',
        'Update Menus',
        'manage_options',
        'virical-menu-updater',
        'virical_menu_updater_page'
    );
}

/**
 * Filter menu items on frontend to ensure correct URLs
 */
add_filter('wp_nav_menu_objects', 'virical_filter_menu_urls', 10, 2);
function virical_filter_menu_urls($items, $args) {
    global $wpdb;
    
    // Check if Virical system has products
    $virical_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}virical_products WHERE is_active = 1");
    
    if ($virical_count > 0) {
        foreach ($items as &$item) {
            // Update product-related URLs
            if (strpos($item->url, '/products') !== false) {
                $item->url = str_replace('/products', '/san-pham', $item->url);
            }
            
            // Update category URLs
            if (strpos($item->url, '/product-category/') !== false) {
                preg_match('/\/product-category\/([^\/]+)/', $item->url, $matches);
                if (isset($matches[1])) {
                    $item->url = home_url('/san-pham/?category=' . $matches[1]);
                }
            }
        }
    }
    
    return $items;
}