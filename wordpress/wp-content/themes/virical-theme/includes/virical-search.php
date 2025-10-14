<?php
/**
 * Virical Search Functionality
 * Adds search support for Virical products
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Modify main search query to include Virical products
 */
add_action('pre_get_posts', 'virical_modify_search_query');
function virical_modify_search_query($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        global $wpdb;
        
        // Check if Virical has products
        $virical_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}virical_products WHERE is_active = 1");
        
        if ($virical_count > 0) {
            // Store the search term
            $search_term = $query->get('s');
            
            // We'll handle the search ourselves
            $query->set('s', '');
            $query->set('post__in', array(0)); // This will make WP query return nothing
            
            // Store search term for later use
            set_query_var('virical_search_term', $search_term);
        }
    }
}

/**
 * Custom search results template
 */
add_filter('template_include', 'virical_search_template');
function virical_search_template($template) {
    if (is_search() && get_query_var('virical_search_term')) {
        $new_template = locate_template(array('search-virical.php'));
        if ($new_template) {
            return $new_template;
        }
    }
    return $template;
}

/**
 * Search Virical products
 */
function virical_search_products($search_term, $limit = -1) {
    global $wpdb;
    
    $search_term = '%' . $wpdb->esc_like($search_term) . '%';
    
    $query = "
        SELECT p.*, c.name as category_name 
        FROM {$wpdb->prefix}virical_products p
        LEFT JOIN {$wpdb->prefix}virical_product_categories c ON p.category = c.slug
        WHERE p.is_active = 1 
        AND (
            p.name LIKE %s 
            OR p.description LIKE %s 
            OR p.features LIKE %s
            OR p.specifications LIKE %s
            OR c.name LIKE %s
        )
        ORDER BY 
            CASE 
                WHEN p.name LIKE %s THEN 1
                WHEN c.name LIKE %s THEN 2
                ELSE 3
            END,
            p.is_featured DESC,
            p.sort_order
    ";
    
    $params = array($search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term);
    
    if ($limit > 0) {
        $query .= " LIMIT %d";
        $params[] = $limit;
    }
    
    $results = $wpdb->get_results($wpdb->prepare($query, $params));
    
    return $results;
}

/**
 * AJAX search handler
 */
add_action('wp_ajax_virical_search', 'virical_ajax_search');
add_action('wp_ajax_nopriv_virical_search', 'virical_ajax_search');
function virical_ajax_search() {
    $search_term = isset($_GET['term']) ? sanitize_text_field($_GET['term']) : '';
    
    if (strlen($search_term) < 2) {
        wp_send_json_error('Search term too short');
    }
    
    $results = virical_search_products($search_term, 10);
    
    $response = array();
    foreach ($results as $product) {
        $response[] = array(
            'id' => $product->id,
            'title' => $product->name,
            'url' => home_url('/san-pham/' . $product->slug . '/'),
            'category' => $product->category_name,
            'price' => $product->price ? number_format($product->price, 0, ',', '.') . ' VNĐ' : '',
            'image' => $product->image_url
        );
    }
    
    wp_send_json_success($response);
}

/**
 * Add search box shortcode
 */
add_shortcode('virical_search', 'virical_search_box_shortcode');
function virical_search_box_shortcode($atts) {
    $atts = shortcode_atts(array(
        'placeholder' => 'Tìm kiếm sản phẩm...',
        'ajax' => 'true'
    ), $atts);
    
    ob_start();
    ?>
    <div class="virical-search-box">
        <form action="<?php echo home_url('/'); ?>" method="get" class="virical-search-form">
            <input type="text" 
                   name="s" 
                   class="virical-search-input" 
                   placeholder="<?php echo esc_attr($atts['placeholder']); ?>"
                   <?php if ($atts['ajax'] === 'true'): ?>data-ajax="true"<?php endif; ?>>
            <button type="submit" class="virical-search-button">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <div class="virical-search-results"></div>
    </div>
    
    <?php if ($atts['ajax'] === 'true'): ?>
    <style>
    .virical-search-box {
        position: relative;
    }
    
    .virical-search-form {
        display: flex;
        align-items: center;
    }
    
    .virical-search-input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px 0 0 4px;
        font-size: 16px;
    }
    
    .virical-search-button {
        padding: 10px 20px;
        background: var(--virical-gold, #d4af37);
        color: #000;
        border: none;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        font-size: 16px;
    }
    
    .virical-search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-top: none;
        max-height: 400px;
        overflow-y: auto;
        display: none;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .virical-search-results.active {
        display: block;
    }
    
    .search-result-item {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
        text-decoration: none;
        color: #333;
        transition: background 0.2s;
    }
    
    .search-result-item:hover {
        background: #f5f5f5;
    }
    
    .search-result-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 15px;
        border-radius: 4px;
    }
    
    .search-result-info {
        flex: 1;
    }
    
    .search-result-title {
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .search-result-meta {
        font-size: 14px;
        color: #666;
    }
    
    .search-no-results {
        padding: 20px;
        text-align: center;
        color: #666;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var searchTimeout;
        var $searchBox = $('.virical-search-box');
        var $searchInput = $searchBox.find('.virical-search-input[data-ajax="true"]');
        var $searchResults = $searchBox.find('.virical-search-results');
        
        $searchInput.on('input', function() {
            clearTimeout(searchTimeout);
            var term = $(this).val();
            
            if (term.length < 2) {
                $searchResults.removeClass('active').empty();
                return;
            }
            
            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'virical_search',
                        term: term
                    },
                    success: function(response) {
                        if (response.success && response.data.length > 0) {
                            var html = '';
                            $.each(response.data, function(i, item) {
                                html += '<a href="' + item.url + '" class="search-result-item">';
                                if (item.image) {
                                    html += '<img src="' + item.image + '" alt="' + item.title + '" class="search-result-image">';
                                }
                                html += '<div class="search-result-info">';
                                html += '<div class="search-result-title">' + item.title + '</div>';
                                html += '<div class="search-result-meta">';
                                if (item.category) {
                                    html += item.category;
                                }
                                if (item.price) {
                                    html += ' • ' + item.price;
                                }
                                html += '</div>';
                                html += '</div>';
                                html += '</a>';
                            });
                            $searchResults.html(html).addClass('active');
                        } else {
                            $searchResults.html('<div class="search-no-results">Không tìm thấy sản phẩm nào</div>').addClass('active');
                        }
                    }
                });
            }, 300);
        });
        
        // Hide results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.virical-search-box').length) {
                $searchResults.removeClass('active');
            }
        });
    });
    </script>
    <?php endif; ?>
    
    <?php
    return ob_get_clean();
}