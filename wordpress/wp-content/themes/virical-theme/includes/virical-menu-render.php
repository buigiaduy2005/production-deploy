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
        
        // Prevent multiple renders of the same menu (CRITICAL FIX)
        static $rendered_menus = array();
        $menu_key = $location . '_' . $menu_class;
        
        if (isset($rendered_menus[$menu_key])) {
            error_log("VIRICAL MENU: Prevented duplicate render of {$menu_key}");
            return; // Already rendered, prevent duplicate
        }
        $rendered_menus[$menu_key] = true;
        error_log("VIRICAL MENU: Rendering {$menu_key}");

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
            
            // Special case: "Sản phẩm" menu always has dropdown
            $is_product_menu = (trim($parent->item_title) === 'Sản phẩm');
            $has_dropdown = $has_children || $is_product_menu;

            // Start parent menu item
            $additional_classes = [];
            if ($has_dropdown) {
                $additional_classes[] = 'menu-item-has-children';
            }
            if ($is_product_menu) {
                $additional_classes[] = 'menu-item-products';
            }
            $class_attribute = 'menu-item' . (!empty($additional_classes) ? ' ' . implode(' ', $additional_classes) : '');
            echo '<li class="' . esc_attr($class_attribute) . '">';

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
                    // Build mega menu from post categories with featured products
                    $categories = get_terms(array(
                        'taxonomy'   => 'category',
                        'hide_empty' => false,
                        'parent'     => 0,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                    ));

                    $has_categories = !is_wp_error($categories) && !empty($categories);

                    // Prepare featured product cards (Virical custom products or fallback posts)
                    $featured_cards = array();
                    $active_product_count = 0;

                    global $wpdb;
                    $product_table = $wpdb->prefix . 'virical_products';
                    $table_check   = $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $product_table));

                    if ($table_check === $product_table) {
                        $active_product_count = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$product_table} WHERE is_active = 1");

                        $product_results = $wpdb->get_results(
                            $wpdb->prepare(
                                "SELECT name, slug, image_url, description, features 
                                 FROM {$product_table} 
                                 WHERE is_active = 1 
                                 ORDER BY sort_order ASC, id DESC 
                                 LIMIT %d",
                                4
                            )
                        );

                        if (!empty($product_results)) {
                            foreach ($product_results as $product_entry) {
                                $image_url = $product_entry->image_url ? $product_entry->image_url : get_template_directory_uri() . '/assets/images/placeholder.jpg';
                                $raw_excerpt = $product_entry->description;
                                if (!$raw_excerpt && !empty($product_entry->features)) {
                                    $decoded_features = json_decode($product_entry->features, true);
                                    if (is_array($decoded_features) && !empty($decoded_features)) {
                                        $raw_excerpt = implode('. ', array_slice(array_filter($decoded_features), 0, 2));
                                    }
                                }

                                $featured_cards[] = array(
                                    'title'   => $product_entry->name,
                                    'url'     => home_url('/san-pham/' . $product_entry->slug . '/'),
                                    'image'   => $image_url,
                                    'excerpt' => $raw_excerpt ? wp_trim_words(wp_strip_all_tags($raw_excerpt), 14, '&hellip;') : '',
                                );
                            }
                        }
                    }

                    // Fallback: use recent posts if custom product table not available or empty
                    if (empty($featured_cards)) {
                        $fallback_args = array(
                            'post_type'           => 'post',
                            'posts_per_page'      => 4,
                            'post_status'         => 'publish',
                            'ignore_sticky_posts' => true,
                        );

                        if ($has_categories) {
                            $fallback_args['tax_query'] = array(
                                array(
                                    'taxonomy'         => 'category',
                                    'field'            => 'term_id',
                                    'terms'            => wp_list_pluck($categories, 'term_id'),
                                    'include_children' => true,
                                ),
                            );
                        }

                        $fallback_query = new WP_Query($fallback_args);

                        if ($fallback_query->have_posts()) {
                            $active_product_count = (int) $fallback_query->found_posts;

                            while ($fallback_query->have_posts()) {
                                $fallback_query->the_post();
                                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                                if (!$image_url) {
                                    $image_url = get_template_directory_uri() . '/assets/images/placeholder.jpg';
                                }
                                $featured_cards[] = array(
                                    'title'   => get_the_title(),
                                    'url'     => get_permalink(),
                                    'image'   => $image_url,
                                    'excerpt' => wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 18, '&hellip;'),
                                );
                            }

                            wp_reset_postdata();
                        }
                    }

                    if ($has_categories || !empty($featured_cards)) {
                        echo '<div class="dropdown-content product-mega-menu">';
                        echo '<div class="product-mega-inner">';

                        if ($has_categories) {
                            echo '<div class="product-mega-categories">';

                            foreach ($categories as $category) {
                                $parent_link = get_term_link($category);
                                if (is_wp_error($parent_link)) {
                                    continue;
                                }

                                $child_categories = get_terms(array(
                                    'taxonomy'   => 'category',
                                    'hide_empty' => false,
                                    'parent'     => $category->term_id,
                                    'orderby'    => 'name',
                                    'order'      => 'ASC',
                                ));

                                $badge_text = '';
                                $potential_badges = array(
                                    'virical_category_badge',
                                    'category_badge',
                                    'category_label',
                                );

                                foreach ($potential_badges as $badge_key) {
                                    $meta_value = get_term_meta($category->term_id, $badge_key, true);
                                    if (!empty($meta_value)) {
                                        $badge_text = $meta_value;
                                        break;
                                    }
                                }

                                echo '<div class="product-mega-column">';
                                echo '<div class="mega-column-header">';
                                echo '<a href="' . esc_url($parent_link) . '" class="mega-column-title">' . esc_html($category->name) . '</a>';
                                if (!empty($badge_text)) {
                                    echo '<span class="product-mega-badge">' . esc_html($badge_text) . '</span>';
                                }
                                echo '</div>';

                                if (!is_wp_error($child_categories) && !empty($child_categories)) {
                                    echo '<ul class="mega-column-list">';
                                    foreach ($child_categories as $child_category) {
                                        $child_link = get_term_link($child_category);
                                        if (is_wp_error($child_link)) {
                                            continue;
                                        }
                                        echo '<li class="mega-column-item"><a href="' . esc_url($child_link) . '">' . esc_html($child_category->name) . '</a></li>';
                                    }
                                    echo '</ul>';
                                }

                                echo '</div>';
                            }

                            echo '</div>'; // .product-mega-categories
                        }

                        if (!empty($featured_cards)) {
                            $active_label = $active_product_count > 0 ? sprintf(
                                /* translators: %d: number of active products */
                                __('Trực tuyến %d sản phẩm', 'virical'),
                                $active_product_count
                            ) : __('Sản phẩm nổi bật', 'virical');

                            echo '<div class="product-mega-featured">';
                            echo '<div class="product-mega-featured-header">';
                            echo '<span class="product-mega-featured-title">' . esc_html($active_label) . '</span>';
                            echo '<a class="product-mega-featured-link" href="' . esc_url(home_url('/san-pham/')) . '">' . esc_html__('Xem tất cả', 'virical') . '</a>';
                            echo '</div>';
                            echo '<div class="product-mega-featured-grid">';

                            foreach ($featured_cards as $card) {
                                echo '<a class="product-mega-featured-item" href="' . esc_url($card['url']) . '">';
                                echo '<div class="product-mega-featured-thumb"><img src="' . esc_url($card['image']) . '" alt="' . esc_attr($card['title']) . '"></div>';
                                echo '<div class="product-mega-featured-info">';
                                echo '<h4 class="product-mega-featured-name">' . esc_html($card['title']) . '</h4>';
                                if (!empty($card['excerpt'])) {
                                    echo '<p class="product-mega-featured-desc">' . esc_html($card['excerpt']) . '</p>';
                                }
                                echo '</div>';
                                echo '</a>';
                            }

                            echo '</div>'; // .product-mega-featured-grid
                            echo '</div>'; // .product-mega-featured
                        }

                        echo '</div>'; // .product-mega-inner
                        echo '</div>'; // .product-mega-menu
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