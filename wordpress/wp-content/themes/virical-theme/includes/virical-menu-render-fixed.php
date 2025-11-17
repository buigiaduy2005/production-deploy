<?php
/**
 * Virical Custom Menu Renderer - FIXED VERSION
 * Renders navigation menu with grid layout mega menu
 */

if (!function_exists('virical_render_navigation_menu')) {
    function virical_render_navigation_menu($location = 'primary', $menu_class = 'main-nav') {
        global $wpdb;
        
        error_log("VIRICAL MENU: Rendering {$location} with class {$menu_class}");

        // Get all active menus for this location
        $menus = $wpdb->get_results($wpdb->prepare(
            "SELECT id, parent_id, item_title, item_url, item_icon, item_description, sort_order
            FROM wp_virical_navigation_menus
            WHERE menu_location = %s AND is_active = 1
            ORDER BY sort_order ASC",
            $location
        ));

        if (empty($menus)) {
            // Enhanced fallback menu with grid mega menu
            echo '<ul class="' . esc_attr($menu_class) . '">';
            echo '<li><a href="' . home_url('/') . '">TRANG CHỦ</a></li>';
            echo '<li><a href="' . home_url('/gioi-thieu') . '">GIỚI THIỆU</a></li>';
            echo '<li class="menu-item-has-children menu-item-products">';
            echo '<a href="' . home_url('/san-pham') . '">SẢN PHẨM <span class="caret"></span></a>';
            
            // Dropdown danh mục đơn giản
            echo '<div class="dropdown-content">';
            
            // Lấy danh mục từ WordPress categories
            $categories = get_terms(array(
                'taxonomy'   => 'category',
                'hide_empty' => false,
                'parent'     => 0,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ));
            
            if (!is_wp_error($categories) && !empty($categories)) {
                foreach ($categories as $category) {
                    $category_link = get_term_link($category);
                    if (!is_wp_error($category_link)) {
                        echo '<div class="dropdown-item">';
                        echo '<a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a>';
                        echo '</div>';
                    }
                }
            } else {
                // Fallback danh mục mẫu
                echo '<div class="dropdown-item"><a href="' . home_url('/san-pham/?category=den-led-trong-nha') . '">Đèn LED trong nhà</a></div>';
                echo '<div class="dropdown-item"><a href="' . home_url('/san-pham/?category=den-led-ngoai-troi') . '">Đèn LED ngoài trời</a></div>';
                echo '<div class="dropdown-item"><a href="' . home_url('/san-pham/?category=den-led-thong-minh') . '">Đèn LED thông minh</a></div>';
                echo '<div class="dropdown-item"><a href="' . home_url('/san-pham/?category=den-led-cong-nghiep') . '">Đèn LED công nghiệp</a></div>';
            }
            
            echo '</div>'; // .dropdown-content
            echo '</li>';
            echo '<li><a href="' . home_url('/giai-phap-thong-minh') . '">GIẢI PHÁP THÔNG MINH</a></li>';
            echo '<li><a href="' . home_url('/lien-he') . '">LIÊN HỆ</a></li>';
            echo '</ul>';
            return;
        }

        // Render database menu với grid mega menu cho Sản phẩm
        $menu_tree = [];
        $menu_items = [];

        foreach ($menus as $menu) {
            $menu_items[$menu->id] = $menu;
            $menu_items[$menu->id]->children = [];
        }

        foreach ($menus as $menu) {
            if ($menu->parent_id === NULL) {
                $menu_tree[] = $menu->id;
            } else {
                if (isset($menu_items[$menu->parent_id])) {
                    $menu_items[$menu->parent_id]->children[] = $menu->id;
                }
            }
        }

        echo '<ul class="' . esc_attr($menu_class) . '">';

        foreach ($menu_tree as $parent_id) {
            $parent = $menu_items[$parent_id];

            if (trim($parent->item_title) === 'Danh mục sản phẩm') {
                continue;
            }

            $has_children = !empty($parent->children);
            $is_product_menu = (trim($parent->item_title) === 'Sản phẩm');
            $has_dropdown = $has_children || $is_product_menu;

            $additional_classes = [];
            if ($has_dropdown) {
                $additional_classes[] = 'menu-item-has-children';
            }
            if ($is_product_menu) {
                $additional_classes[] = 'menu-item-products';
            }
            $class_attribute = 'menu-item' . (!empty($additional_classes) ? ' ' . implode(' ', $additional_classes) : '');
            echo '<li class="' . esc_attr($class_attribute) . '">';

            echo '<a href="' . esc_url($parent->item_url) . '"';
            if ($parent->item_description) {
                echo ' title="' . esc_attr($parent->item_description) . '"';
            }
            echo '>';
            echo esc_html($parent->item_title);
            
            if ($has_dropdown) {
                echo ' <span class="caret"></span>';
            }
            
            echo '</a>';

            if ($has_dropdown) {
                if (trim($parent->item_title) === 'Sản phẩm') {
                    $categories = get_terms( array(
                        'taxonomy' => 'category',
                        'hide_empty' => false,
                        'parent' => 0,
                    ) );
                    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                        echo '<div class="dropdown-content product-mega-menu">';
                        echo '<div class="product-mega-categories">';
                        foreach ($categories as $category) {
                            $logo_id = get_term_meta( $category->term_id, 'category-logo-id', true );
                            $logo_url = '';
                            if ( $logo_id ) {
                                $logo_data = wp_get_attachment_image_src( $logo_id, 'thumbnail' );
                                if ($logo_data) {
                                    $logo_url = $logo_data[0];
                                }
                            }
                            echo '<a href="' . esc_url(get_term_link($category)) . '" class="product-mega-item">';
                            if ($logo_url) {
                                echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr($category->name) . '">';
                            }
                            echo '<span class="product-mega-item-name">' . esc_html($category->name) . '</span>';
                            echo '</a>';
                        }
                        echo '</div>'; // close product-mega-categories
                        echo '</div>'; // close dropdown-content
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

if (!function_exists('virical_is_menu_active')) {
    function virical_is_menu_active($menu_url) {
        $current_url = $_SERVER['REQUEST_URI'];
        return strpos($current_url, $menu_url) === 0;
    }
}
?>
