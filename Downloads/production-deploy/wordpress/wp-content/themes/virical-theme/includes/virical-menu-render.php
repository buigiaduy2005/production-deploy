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
            $has_children = !empty($parent->children);

            // Start parent menu item
            echo '<li class="menu-item' . ($has_children ? ' menu-item-has-children' : '') . '">';

            // Parent menu link
            echo '<a href="' . esc_url($parent->item_url) . '"';
            if ($parent->item_description) {
                echo ' title="' . esc_attr($parent->item_description) . '"';
            }
            echo '>';
            echo esc_html($parent->item_title);
            echo '</a>';

            // Render submenu if has children
            if ($has_children) {
                echo '<ul class="sub-menu">';

                foreach ($parent->children as $child_id) {
                    $child = $menu_items[$child_id];

                    echo '<li class="menu-item">';
                    echo '<a href="' . esc_url($child->item_url) . '"';
                    if ($child->item_description) {
                        echo ' title="' . esc_attr($child->item_description) . '"';
                    }
                    echo '>';
                    echo esc_html($child->item_title);
                    echo '</a>';
                    echo '</li>';
                }

                echo '</ul>';
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