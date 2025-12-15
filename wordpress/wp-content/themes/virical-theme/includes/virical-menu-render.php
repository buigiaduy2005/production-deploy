<?php
/**
 * Virical Custom Menu Renderer
 * Renders navigation menu from wp_virical_navigation_menus table
 */

if (!function_exists('virical_render_navigation_menu')) {
    /**
     * Render navigation menu with dropdown support
     *
     * @param string $location Menu location (primary, footer, etc.)
     * @param string $menu_class CSS class for menu ul
     * @return void
     */
    function virical_render_navigation_menu($location = 'primary', $menu_class = 'main-nav') {
        global $wpdb;

        // Get all active menus for this location
        $menus = $wpdb->get_results($wpdb->prepare(
            "SELECT id, parent_id, item_title, item_url, item_icon, item_description, sort_order
            FROM wp_virical_navigation_menus
            WHERE menu_location = %s AND is_active = 1
            ORDER BY sort_order ASC",
            $location
        ));

        if (empty($menus)) {
            // Fallback menu if no menus found
            echo '<ul class="' . esc_attr($menu_class) . '">';
            echo '<li><a href="' . home_url('/') . '">Trang Chủ</a></li>';
            echo '</ul>';
            return;
        }

        // Organize menus into parent-child structure
        $menu_tree = [];
        $menu_items = [];

        // First pass: store all items by ID
        foreach ($menus as $menu) {
            $menu_items[$menu->id] = $menu;
            $menu_items[$menu->id]->children = [];
        }

        // Second pass: build tree structure
        foreach ($menus as $menu) {
            if ($menu->parent_id === NULL) {
                // Top level menu
                $menu_tree[] = $menu->id;
            } else {
                // Child menu - add to parent's children array
                if (isset($menu_items[$menu->parent_id])) {
                    $menu_items[$menu->parent_id]->children[] = $menu->id;
                }
            }
        }

        // Render the menu
        echo '<ul class="' . esc_attr($menu_class) . '">';

        foreach ($menu_tree as $parent_id) {
            $parent = $menu_items[$parent_id];

            // Normalize "Sản phẩm đèn" to "Sản phẩm" to match logic and user request
            if (trim($parent->item_title) === 'Sản phẩm đèn') {
                $parent->item_title = 'Sản phẩm';
            }

            $has_children = !empty($parent->children);
            
            // Special case: "Sản phẩm" menu always has dropdown
            $is_product_menu = (trim($parent->item_title) === 'Sản phẩm');
            $has_dropdown = $has_children || $is_product_menu;

            // Start parent menu item
            echo '<li class="menu-item' . ($has_dropdown ? ' menu-item-has-children' : '') . '">';

            // Parent menu link
            echo '<a href="' . esc_url($parent->item_url) . '"';
            if ($parent->item_description) {
                echo ' title="' . esc_attr($parent->item_description) . '"';
            }
            echo '>';
            echo esc_html($parent->item_title);
            
            // Add caret for dropdown menus
            if ($has_dropdown) {
                echo ' <span class="caret"></span>';
            }
            
            echo '</a>';

            // Render submenu if has children or is product menu
            if ($has_dropdown) {
                if (trim($parent->item_title) === 'Sản phẩm') {
                    // Get only parent categories (no children)
                    $categories = get_terms( array(
                        'taxonomy' => 'category',
                        'hide_empty' => false,
                        'parent' => 0, // Only get parent categories
                    ) );
                    
                    // Debug: Log available parent categories
                    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                        error_log('Found ' . count($categories) . ' parent categories for dropdown');
                        foreach ($categories as $cat) {
                            error_log('Parent Category: ' . $cat->name . ' (ID: ' . $cat->term_id . ', Parent: ' . $cat->parent . ')');
                        }
                    }
                    
                    // Fallback to demo categories if no real categories exist
                    if ( empty( $categories ) || is_wp_error( $categories ) ) {
                        $categories = array(
                            (object) array('term_id' => 1, 'name' => 'Đèn LED Trong Nhà', 'slug' => 'den-led-trong-nha'),
                            (object) array('term_id' => 2, 'name' => 'Đèn LED Ngoài Trời', 'slug' => 'den-led-ngoai-troi'),
                            (object) array('term_id' => 3, 'name' => 'Đèn LED Thông Minh', 'slug' => 'den-led-thong-minh'),
                            (object) array('term_id' => 4, 'name' => 'Đèn LED Công Nghiệp', 'slug' => 'den-led-cong-nghiep'),
                            (object) array('term_id' => 5, 'name' => 'Đèn LED Trang Trí', 'slug' => 'den-led-trang-tri'),
                            (object) array('term_id' => 6, 'name' => 'Đèn LED Ô Tô', 'slug' => 'den-led-o-to'),
                        );
                    }
                    
                    if ( ! empty( $categories ) ) {
                        echo '<div class="dropdown-content">';
                        foreach ($categories as $category) {
                            // Get category logo using helper function
                            $logo_url = '';
                            if (function_exists('virical_get_category_logo')) {
                                $logo_url = virical_get_category_logo($category->term_id);
                            }
                            // Generate proper link for both real and demo categories
                            if (isset($category->slug)) {
                                $category_link = home_url('/san-pham/?category=' . $category->slug);
                            } else {
                                $category_link = get_term_link($category);
                            }
                            
                            echo '<a href="' . esc_url($category_link) . '" class="dropdown-item">';
                            if ($logo_url) {
                                echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr($category->name) . '" class="icon">';
                            } else {
                                // Use category icon or default fallback
                                $icon_class = get_term_meta($category->term_id, 'category_icon', true);
                                if (!$icon_class) {
                                    $icon_class = 'fas fa-cube';
                                }
                                echo '<div class="icon icon-fallback"><i class="' . esc_attr($icon_class) . '"></i></div>';
                            }
                            echo '<span>' . esc_html($category->name) . '</span>';
                            echo '</a>';
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<div class="dropdown-content">';
                    foreach ($parent->children as $child_id) {
                        $child = $menu_items[$child_id];
                        echo '<div class="dropdown-item">';
                        if ($child->item_icon) {
                            echo '<img src="' . esc_url($child->item_icon) . '" alt="Icon">';
                        }
                        echo '<span>' . esc_html($child->item_title) . '</span>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }

            echo '</li>';
        }

        echo '</ul>';
    }
}

/**
 * Get menu item by URL (for active state)
 */
if (!function_exists('virical_is_menu_active')) {
    function virical_is_menu_active($menu_url) {
        $current_url = $_SERVER['REQUEST_URI'];
        return strpos($current_url, $menu_url) === 0;
    }
}

?>