<?php
/**
 * Virical Products Functions
 * Thêm vào file functions.php của theme
 */

// Thêm rewrite rules cho sản phẩm
add_action('init', 'virical_products_rewrite_rules');
function virical_products_rewrite_rules() {
    // Rule cho trang danh sách sản phẩm
    add_rewrite_rule(
        '^san-pham/?$',
        'index.php?pagename=san-pham',
        'top'
    );
    
    // Rule cho chi tiết sản phẩm
    add_rewrite_rule(
        '^san-pham/([^/]+)/?$',
        'index.php?pagename=chi-tiet-san-pham&product_slug=$matches[1]',
        'top'
    );
    
    // Thêm query var
    add_rewrite_tag('%product_slug%', '([^&]+)');
}

// Flush rewrite rules khi cần
add_action('after_switch_theme', 'virical_flush_rewrite_rules');
function virical_flush_rewrite_rules() {
    virical_products_rewrite_rules();
    flush_rewrite_rules();
}

// Function helper để lấy sản phẩm nổi bật cho homepage
function virical_get_featured_products($limit = 3) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_products';
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name 
        WHERE is_featured = 1 AND status = 'publish' 
        ORDER BY created_at DESC 
        LIMIT %d",
        $limit
    ));
}

// Function để render product card
function virical_render_product_card($product) {
    $features = json_decode($product->features, true) ?: array();
    $discount = 0;
    if ($product->sale_price && $product->sale_price < $product->price) {
        $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
    }
    ?>
    <div class="product-card" data-aos="fade-up">
        <?php if ($discount > 0): ?>
            <div class="product-badge">-<?php echo $discount; ?>%</div>
        <?php endif; ?>
        
        <div class="product-image">
            <img src="<?php echo esc_url($product->image_url); ?>" 
                 alt="<?php echo esc_attr($product->name); ?>">
            
            <div class="product-overlay">
                <a href="<?php echo home_url('/san-pham/' . $product->slug); ?>" class="btn-view-product">
                    Xem chi tiết
                </a>
            </div>
        </div>
        
        <div class="product-info">
            <h3 class="product-title">
                <a href="<?php echo home_url('/san-pham/' . $product->slug); ?>">
                    <?php echo esc_html($product->name); ?>
                </a>
            </h3>
            
            <p class="product-description">
                <?php echo esc_html($product->short_description); ?>
            </p>
            
            <?php if (!empty($features)): ?>
                <ul class="product-features">
                    <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                        <li><?php echo esc_html($feature); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <div class="product-footer">
                <div class="product-price">
                    <?php if ($product->sale_price && $product->sale_price < $product->price): ?>
                        <span class="price-old"><?php echo number_format($product->price); ?>đ</span>
                        <span class="price-new"><?php echo number_format($product->sale_price); ?>đ</span>
                    <?php else: ?>
                        <span class="price-new"><?php echo number_format($product->price); ?>đ</span>
                    <?php endif; ?>
                </div>
                
                <button class="btn-quick-buy" onclick="quickBuy(<?php echo $product->id; ?>)">
                    Mua ngay
                </button>
            </div>
        </div>
    </div>
    <?php
}

// AJAX handler cho quick buy
add_action('wp_ajax_virical_quick_buy', 'virical_handle_quick_buy');
add_action('wp_ajax_nopriv_virical_quick_buy', 'virical_handle_quick_buy');
function virical_handle_quick_buy() {
    $product_id = intval($_POST['product_id']);
    
    // TODO: Implement cart/checkout logic
    
    wp_send_json_success(array(
        'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
        'cart_url' => home_url('/gio-hang')
    ));
}

// Shortcode để hiển thị chi tiết sản phẩm
add_shortcode('virical_product_detail', 'virical_product_detail_shortcode');
function virical_product_detail_shortcode() {
    // Lấy product slug từ URL parameter
    $product_slug = isset($_GET['product']) ? sanitize_text_field($_GET['product']) : '';
    
    if (!$product_slug) {
        return '<p>Vui lòng chọn một sản phẩm để xem chi tiết.</p>';
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'virical_products';
    
    $product = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE slug = %s AND status = 'publish'",
        $product_slug
    ));
    
    if (!$product) {
        return '<p>Sản phẩm không tìm thấy.</p>';
    }
    
    // Parse JSON data
    $features = json_decode($product->features, true) ?: array();
    $specifications = json_decode($product->specifications, true) ?: array();
    
    ob_start();
    ?>
    <style>
    .product-detail {
        margin: 40px 0;
    }
    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 40px;
    }
    .product-image img {
        width: 100%;
        border-radius: 10px;
    }
    .product-info h1 {
        font-size: 2rem;
        margin-bottom: 20px;
    }
    .product-price {
        font-size: 1.8rem;
        color: #667eea;
        font-weight: bold;
        margin: 20px 0;
    }
    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 1.4rem;
        margin-right: 10px;
    }
    .features-list {
        list-style: none;
        padding: 0;
    }
    .features-list li {
        padding: 8px 0;
        padding-left: 25px;
        position: relative;
    }
    .features-list li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #48bb78;
        font-weight: bold;
    }
    .btn-buy {
        background: #667eea;
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-buy:hover {
        background: #5a67d8;
    }
    .product-tabs {
        margin-top: 40px;
    }
    .tab-nav {
        display: flex;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 20px;
    }
    .tab-btn {
        padding: 10px 20px;
        background: none;
        border: none;
        font-size: 1rem;
        cursor: pointer;
        color: #718096;
    }
    .tab-btn.active {
        color: #667eea;
        border-bottom: 3px solid #667eea;
    }
    .tab-content {
        display: none;
        padding: 20px 0;
    }
    .tab-content.active {
        display: block;
    }
    @media (max-width: 768px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
    
    <div class="product-detail">
        <div class="product-detail-grid">
            <div class="product-image">
                <?php if ($product->image_url): ?>
                    <img src="<?php echo esc_url($product->image_url); ?>" 
                         alt="<?php echo esc_attr($product->name); ?>">
                <?php endif; ?>
            </div>
            
            <div class="product-info">
                <h1><?php echo esc_html($product->name); ?></h1>
                
                <p style="font-size: 1.1rem; color: #718096; margin: 20px 0;">
                    <?php echo esc_html($product->short_description); ?>
                </p>
                
                <div class="product-price">
                    <?php if ($product->sale_price && $product->sale_price < $product->price): ?>
                        <span class="old-price"><?php echo number_format($product->price); ?>đ</span>
                        <?php echo number_format($product->sale_price); ?>đ
                    <?php else: ?>
                        <?php echo number_format($product->price); ?>đ
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($features)): ?>
                <div>
                    <h3>Tính năng nổi bật:</h3>
                    <ul class="features-list">
                        <?php foreach ($features as $feature): ?>
                            <li><?php echo esc_html($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <div style="margin-top: 30px;">
                    <button class="btn-buy" onclick="alert('Đã thêm sản phẩm vào giỏ hàng!')">
                        Mua ngay
                    </button>
                </div>
            </div>
        </div>
        
        <div class="product-tabs">
            <div class="tab-nav">
                <button class="tab-btn active" onclick="showTab('desc')">Mô tả</button>
                <button class="tab-btn" onclick="showTab('specs')">Thông số</button>
            </div>
            
            <div class="tab-content active" id="tab-desc">
                <?php echo wp_kses_post($product->description); ?>
            </div>
            
            <div class="tab-content" id="tab-specs">
                <?php if (!empty($specifications)): ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <?php foreach ($specifications as $key => $value): ?>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 10px 0; font-weight: 600;">
                            <?php echo esc_html(ucfirst(str_replace('_', ' ', $key))); ?>
                        </td>
                        <td style="padding: 10px 0;">
                            <?php echo esc_html($value); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
    function showTab(tab) {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        document.getElementById('tab-' + tab).classList.add('active');
    }
    </script>
    <?php
    return ob_get_clean();
}