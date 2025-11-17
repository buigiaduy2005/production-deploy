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
        
        // DEBUG: Always render menu for now
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
            // Enhanced fallback menu with product dropdown
            echo '<ul class="' . esc_attr($menu_class) . '">';
            echo '<li><a href="' . home_url('/') . '">TRANG CHỦ</a></li>';
            echo '<li><a href="' . home_url('/gioi-thieu') . '">GIỚI THIỆU</a></li>';
            echo '<li class="menu-item-has-children menu-item-products">';
            echo '<a href="' . home_url('/san-pham') . '">SẢN PHẨM <span class="caret"></span></a>';
            
            // Luôn hiển thị mega menu với grid layout
            echo '<div class="dropdown-content product-mega-menu">';
            echo '<div class="product-mega-inner">';
            
            // Grid sản phẩm bên trái
            echo '<div class="product-mega-categories">';
            
            // Tạo array sản phẩm mẫu với hình ảnh
            $sample_products = array(
                array(
                    'name' => 'Đèn pha LED 500W',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-pha-500w.jpg',
                    'url' => home_url('/san-pham/den-pha-led-500w/')
                ),
                array(
                    'name' => 'Đèn đường LED 200W',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-duong-200w.jpg',
                    'url' => home_url('/san-pham/den-duong-led-200w/')
                ),
                array(
                    'name' => 'Đèn đường LED 150W',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-duong-150w.jpg',
                    'url' => home_url('/san-pham/den-duong-led-150w/')
                ),
                array(
                    'name' => 'Đèn LED âm trần',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-am-tran.jpg',
                    'url' => home_url('/san-pham/den-led-am-tran/')
                ),
                array(
                    'name' => 'Đèn LED panel',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-panel.jpg',
                    'url' => home_url('/san-pham/den-led-panel/')
                ),
                array(
                    'name' => 'Đèn LED bulb',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-bulb.jpg',
                    'url' => home_url('/san-pham/den-led-bulb/')
                ),
                array(
                    'name' => 'Đèn LED dây',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-day.jpg',
                    'url' => home_url('/san-pham/den-led-day/')
                ),
                array(
                    'name' => 'Đèn LED spotlight',
                    'image' => get_template_directory_uri() . '/assets/images/products/spotlight.jpg',
                    'url' => home_url('/san-pham/den-led-spotlight/')
                ),
                array(
                    'name' => 'Đèn LED downlight',
                    'image' => get_template_directory_uri() . '/assets/images/products/downlight.jpg',
                    'url' => home_url('/san-pham/den-led-downlight/')
                ),
                array(
                    'name' => 'Đèn LED tracklight',
                    'image' => get_template_directory_uri() . '/assets/images/products/tracklight.jpg',
                    'url' => home_url('/san-pham/den-led-tracklight/')
                )
            );
            
            // Hiển thị 10 sản phẩm trong grid 5x2
            foreach ($sample_products as $product) {
                echo '<a href="' . esc_url($product['url']) . '" class="product-mega-item">';
                echo '<img src="' . esc_url($product['image']) . '" alt="' . esc_attr($product['name']) . '" onerror="this.src=\'' . get_template_directory_uri() . '/assets/images/placeholder.jpg\'">';
                echo '<span class="product-mega-item-name">' . esc_html($product['name']) . '</span>';
                echo '</a>';
            }
            
            echo '</div>'; // .product-mega-categories
            
            // Sản phẩm nổi bật bên phải
            echo '<div class="product-mega-featured">';
            echo '<div class="product-mega-featured-header">';
            echo '<span class="product-mega-featured-title">Sản phẩm nổi bật</span>';
            echo '<a class="product-mega-featured-link" href="' . home_url('/san-pham/') . '">Xem tất cả</a>';
            echo '</div>';
            echo '<div class="product-mega-featured-grid">';
            
            // Sản phẩm nổi bật mẫu
            $featured_products = array(
                array(
                    'name' => 'Đèn pha LED 500W cao cấp',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-pha-500w.jpg',
                    'url' => home_url('/san-pham/den-pha-led-500w/'),
                    'excerpt' => 'Đèn pha LED công suất siêu cao 500W cho sân vận động, công trình...'
                ),
                array(
                    'name' => 'Đèn đường LED module 200W',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-duong-200w.jpg',
                    'url' => home_url('/san-pham/den-duong-led-200w/'),
                    'excerpt' => 'Đèn đường LED module công suất 200W, thiết kế module linh hoạt...'
                ),
                array(
                    'name' => 'Đèn đường LED COB 150W',
                    'image' => get_template_directory_uri() . '/assets/images/products/den-duong-150w.jpg',
                    'url' => home_url('/san-pham/den-duong-led-150w/'),
                    'excerpt' => 'Đèn đường LED công suất cao 150W với công nghệ COB, tiết kiệm năng...'
                )
            );
            
            foreach ($featured_products as $product) {
                echo '<a class="product-mega-featured-item" href="' . esc_url($product['url']) . '">';
                echo '<div class="product-mega-featured-thumb">';
                echo '<img src="' . esc_url($product['image']) . '" alt="' . esc_attr($product['name']) . '" onerror="this.src=\'' . get_template_directory_uri() . '/assets/images/placeholder.jpg\'">';
                echo '</div>';
                echo '<div class="product-mega-featured-info">';
                echo '<h4 class="product-mega-featured-name">' . esc_html($product['name']) . '</h4>';
                echo '<p class="product-mega-featured-desc">' . esc_html($product['excerpt']) . '</p>';
                echo '</div>';
                echo '</a>';
            }
            
            echo '</div>'; // .product-mega-featured-grid
            echo '</div>'; // .product-mega-featured
            
            echo '</div>'; // .product-mega-inner
            echo '</div>'; // .dropdown-content
            echo '</li>';
            echo '<li><a href="' . home_url('/giai-phap-thong-minh') . '">GIẢI PHÁP THÔNG MINH</a></li>';
            echo '<li><a href="' . home_url('/lien-he') . '">LIÊN HỆ</a></li>';
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

            // Skip rendering if the menu item title is "Danh mục sản phẩm"
            if (trim($parent->item_title) === 'Danh mục sản phẩm') {
                continue;
            }

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
                            }

                            $featured_cards[] = array(
                                'title'   => $product_entry->name,
                                'url'     => home_url('/san-pham/' . $product_entry->slug . '/'),
                                'image'   => $image_url,
                                'excerpt' => $raw_excerpt ? wp_trim_words(wp_strip_all_tags($raw_excerpt), 14, '&hellip;') : '',
                            );
                        }
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