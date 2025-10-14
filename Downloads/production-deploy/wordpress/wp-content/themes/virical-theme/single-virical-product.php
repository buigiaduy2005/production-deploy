<?php
/**
 * Template Name: Virical Product Detail
 * Description: Template hiển thị chi tiết sản phẩm Virical
 */

get_header();

// Lấy slug từ URL
$product_slug = get_query_var('product_slug');
if (!$product_slug) {
    // Fallback: lấy từ URL path
    $url_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    if (count($url_parts) >= 2 && $url_parts[0] == 'san-pham') {
        $product_slug = $url_parts[1];
    }
}

// Lấy thông tin sản phẩm từ database
global $wpdb;
$table_name = $wpdb->prefix . 'virical_products';
$product = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM $table_name WHERE slug = %s AND status = 'publish'",
    $product_slug
));

if (!$product) {
    ?>
    <div class="container" style="padding: 100px 20px; text-align: center;">
        <h1>Sản phẩm không tìm thấy</h1>
        <p>Xin lỗi, sản phẩm bạn tìm kiếm không tồn tại.</p>
        <a href="<?php echo home_url(); ?>" class="button">Về trang chủ</a>
    </div>
    <?php
    get_footer();
    exit;
}

// Parse JSON data
$features = json_decode($product->features, true) ?: array();
$specifications = json_decode($product->specifications, true) ?: array();
$gallery = json_decode($product->gallery, true) ?: array();
?>

<style>
.product-detail-page {
    padding: 60px 0;
    background: #f8f9fa;
}

.product-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.product-main {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
}

.product-gallery {
    position: relative;
}

.main-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 16px;
    margin-bottom: 20px;
}

.gallery-thumbs {
    display: flex;
    gap: 10px;
    overflow-x: auto;
}

.gallery-thumbs img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.gallery-thumbs img:hover,
.gallery-thumbs img.active {
    border-color: #667eea;
}

.product-info h1 {
    font-size: 2.5rem;
    color: #1a202c;
    margin-bottom: 20px;
}

.product-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    color: #718096;
    font-size: 0.9rem;
}

.product-price {
    margin: 30px 0;
}

.price-original {
    font-size: 1.2rem;
    color: #a0aec0;
    text-decoration: line-through;
    margin-right: 15px;
}

.price-sale {
    font-size: 2rem;
    color: #e53e3e;
    font-weight: 700;
}

.price-regular {
    font-size: 2rem;
    color: #1a202c;
    font-weight: 700;
}

.product-features {
    margin: 30px 0;
}

.product-features h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    color: #2d3748;
}

.features-list {
    list-style: none;
    padding: 0;
}

.features-list li {
    padding: 10px 0;
    padding-left: 30px;
    position: relative;
    color: #4a5568;
}

.features-list li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #48bb78;
    font-weight: bold;
    font-size: 1.2rem;
}

.product-actions {
    margin: 40px 0;
    display: flex;
    gap: 20px;
    align-items: center;
}

.quantity-selector {
    display: flex;
    align-items: center;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
}

.quantity-selector button {
    background: none;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 1.2rem;
    color: #4a5568;
    transition: all 0.3s ease;
}

.quantity-selector button:hover {
    background: #f7fafc;
}

.quantity-selector input {
    border: none;
    width: 60px;
    text-align: center;
    font-size: 1.1rem;
    padding: 10px 0;
}

.btn-add-cart {
    flex: 1;
    padding: 15px 40px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-add-cart:hover {
    background: #5a67d8;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.btn-buy-now {
    padding: 15px 40px;
    background: #ed8936;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-buy-now:hover {
    background: #dd6b20;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(237, 137, 54, 0.3);
}

.product-tabs {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.tabs-nav {
    display: flex;
    border-bottom: 2px solid #e2e8f0;
    margin-bottom: 30px;
}

.tab-button {
    padding: 15px 30px;
    background: none;
    border: none;
    font-size: 1.1rem;
    font-weight: 600;
    color: #718096;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.tab-button.active {
    color: #667eea;
}

.tab-button.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: #667eea;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.specifications-table {
    width: 100%;
    border-collapse: collapse;
}

.specifications-table tr {
    border-bottom: 1px solid #e2e8f0;
}

.specifications-table td {
    padding: 15px 0;
}

.specifications-table td:first-child {
    font-weight: 600;
    color: #4a5568;
    width: 40%;
}

.specifications-table td:last-child {
    color: #2d3748;
}

.stock-status {
    display: inline-block;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.stock-status.in-stock {
    background: #c6f6d5;
    color: #276749;
}

.stock-status.out-stock {
    background: #fed7d7;
    color: #9b2c2c;
}

.stock-status.low-stock {
    background: #feebc8;
    color: #7b341e;
}

.related-products {
    margin-top: 60px;
}

.related-products h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 40px;
    color: #1a202c;
}

@media (max-width: 768px) {
    .product-main {
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 20px;
    }
    
    .main-image {
        height: 300px;
    }
    
    .product-info h1 {
        font-size: 1.8rem;
    }
    
    .product-actions {
        flex-direction: column;
    }
    
    .quantity-selector {
        width: 100%;
        justify-content: center;
    }
    
    .btn-add-cart,
    .btn-buy-now {
        width: 100%;
    }
}
</style>

<div class="product-detail-page">
    <div class="product-container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" style="margin-bottom: 30px;">
            <a href="<?php echo home_url(); ?>">Trang chủ</a> / 
            <a href="<?php echo home_url('/san-pham'); ?>">Sản phẩm</a> / 
            <span><?php echo esc_html($product->name); ?></span>
        </nav>
        
        <!-- Main Product Section -->
        <div class="product-main">
            <!-- Gallery -->
            <div class="product-gallery">
                <?php $product_image_url = virical_get_product_image_url($product); ?>
                <img src="<?php echo esc_url($product_image_url); ?>" 
                     alt="<?php echo esc_attr($product->name); ?>" 
                     class="main-image" 
                     id="mainImage">
                
                <?php if (!empty($gallery)): ?>
                <div class="gallery-thumbs">
                    <img src="<?php echo esc_url($product->image_url); ?>" 
                         alt="<?php echo esc_attr($product->name); ?>" 
                         class="active"
                         onclick="changeImage(this.src)">
                    <?php foreach ($gallery as $image): ?>
                        <img src="<?php echo esc_url($image); ?>" 
                             alt="<?php echo esc_attr($product->name); ?>" 
                             onclick="changeImage(this.src)">
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Product Info -->
            <div class="product-info">
                <h1><?php echo esc_html($product->name); ?></h1>
                
                <div class="product-meta">
                    <span>SKU: <?php echo esc_html($product->sku); ?></span>
                    <span>|</span>
                    <span>Danh mục: <?php echo esc_html(ucfirst($product->category)); ?></span>
                </div>
                
                <p style="font-size: 1.1rem; color: #4a5568; margin: 20px 0;">
                    <?php echo esc_html($product->short_description); ?>
                </p>
                
                <!-- Price -->
                <div class="product-price">
                    <?php if ($product->sale_price && $product->sale_price < $product->price): ?>
                        <span class="price-original"><?php echo number_format($product->price); ?>đ</span>
                        <span class="price-sale"><?php echo number_format($product->sale_price); ?>đ</span>
                        <span style="background: #e53e3e; color: white; padding: 5px 10px; border-radius: 5px; font-size: 0.9rem; margin-left: 10px;">
                            -<?php echo round((($product->price - $product->sale_price) / $product->price) * 100); ?>%
                        </span>
                    <?php else: ?>
                        <span class="price-regular"><?php echo number_format($product->price); ?>đ</span>
                    <?php endif; ?>
                </div>
                
                <!-- Stock Status -->
                <div style="margin: 20px 0;">
                    <?php if ($product->stock_quantity > 10): ?>
                        <span class="stock-status in-stock">✓ Còn hàng</span>
                    <?php elseif ($product->stock_quantity > 0): ?>
                        <span class="stock-status low-stock">Chỉ còn <?php echo $product->stock_quantity; ?> sản phẩm</span>
                    <?php else: ?>
                        <span class="stock-status out-stock">Hết hàng</span>
                    <?php endif; ?>
                </div>
                
                <!-- Features -->
                <?php if (!empty($features)): ?>
                <div class="product-features">
                    <h3>Tính năng nổi bật</h3>
                    <ul class="features-list">
                        <?php foreach ($features as $feature): ?>
                            <li><?php echo esc_html($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <!-- Actions -->
                <div class="product-actions">
                    <div class="quantity-selector">
                        <button onclick="changeQuantity(-1)">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="<?php echo $product->stock_quantity; ?>">
                        <button onclick="changeQuantity(1)">+</button>
                    </div>
                    
                    <button class="btn-add-cart" onclick="addToCart(<?php echo $product->id; ?>)">
                        Thêm vào giỏ hàng
                    </button>
                    
                    <button class="btn-buy-now" onclick="buyNow(<?php echo $product->id; ?>)">
                        Mua ngay
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Tabs Section -->
        <div class="product-tabs">
            <div class="tabs-nav">
                <button class="tab-button active" onclick="switchTab('description')">Mô tả</button>
                <button class="tab-button" onclick="switchTab('specifications')">Thông số kỹ thuật</button>
                <button class="tab-button" onclick="switchTab('reviews')">Đánh giá</button>
            </div>
            
            <div class="tab-content active" id="tab-description">
                <?php echo wp_kses_post($product->description); ?>
            </div>
            
            <div class="tab-content" id="tab-specifications">
                <?php if (!empty($specifications)): ?>
                <table class="specifications-table">
                    <?php foreach ($specifications as $key => $value): ?>
                    <tr>
                        <td><?php echo esc_html(ucfirst(str_replace('_', ' ', $key))); ?></td>
                        <td><?php echo esc_html($value); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
            
            <div class="tab-content" id="tab-reviews">
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            </div>
        </div>
        
        <!-- Related Products -->
        <div class="related-products">
            <h2>Sản phẩm liên quan</h2>
            <?php
            // Lấy sản phẩm cùng category
            $related = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM $table_name 
                WHERE category = %s AND id != %d AND status = 'publish' 
                ORDER BY RAND() LIMIT 4",
                $product->category,
                $product->id
            ));
            
            if ($related): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
                    <?php foreach ($related as $item): ?>
                        <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                            <a href="<?php echo home_url('/san-pham/' . $item->slug); ?>" style="text-decoration: none; color: inherit;">
                                <img src="<?php echo esc_url($item->image_url); ?>" 
                                     alt="<?php echo esc_attr($item->name); ?>"
                                     style="width: 100%; height: 200px; object-fit: cover;">
                                <div style="padding: 20px;">
                                    <h3 style="font-size: 1.1rem; margin-bottom: 10px;"><?php echo esc_html($item->name); ?></h3>
                                    <p style="color: #718096; font-size: 0.9rem; margin-bottom: 15px;">
                                        <?php echo esc_html($item->short_description); ?>
                                    </p>
                                    <div style="font-weight: bold; color: #667eea;">
                                        <?php echo number_format($item->sale_price ?: $item->price); ?>đ
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
    
    // Update active thumb
    document.querySelectorAll('.gallery-thumbs img').forEach(img => {
        img.classList.remove('active');
        if (img.src === src) {
            img.classList.add('active');
        }
    });
}

function changeQuantity(delta) {
    const input = document.getElementById('quantity');
    const newValue = parseInt(input.value) + delta;
    const max = parseInt(input.max);
    
    if (newValue >= 1 && newValue <= max) {
        input.value = newValue;
    }
}

function switchTab(tab) {
    // Update buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Update content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.getElementById('tab-' + tab).classList.add('active');
}

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    
    // Gửi AJAX request để thêm vào giỏ hàng
    alert('Đã thêm ' + quantity + ' sản phẩm vào giỏ hàng!');
    
    // TODO: Implement actual cart functionality
}

function buyNow(productId) {
    const quantity = document.getElementById('quantity').value;
    
    // Redirect to checkout
    alert('Chuyển đến trang thanh toán với ' + quantity + ' sản phẩm!');
    
    // TODO: Implement checkout redirect
}
</script>

<?php get_footer(); ?>