<?php
/**
 * Template Name: Single Product - Modern Style
 * 
 * @package Virical
 */

get_header();

// Get the product data prepared by the routing manager
$product = get_query_var('current_product');

// If the product data isn't available, redirect to the main products page.
if (!$product || !is_object($product)) {
    wp_redirect(home_url('/san-pham/'));
    exit;
}

global $wpdb;
// Get product category
$category = null;
if (!empty($product->category)) {
    $category = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}virical_product_categories WHERE slug = %s",
        $product->category
    ));
}

// Consolidate all images. The featured image should be first.
$all_images = [];
if (!empty($product->image_url) && $product->image_url !== get_template_directory_uri() . '/assets/images/placeholder.jpg') {
    $all_images[] = $product->image_url;
}

// Decode the gallery JSON and merge
if (!empty($product->gallery_images)) {
    $gallery_array = json_decode($product->gallery_images, true);
    if (is_array($gallery_array)) {
        foreach($gallery_array as $url) {
            if (!in_array($url, $all_images)) {
                $all_images[] = $url;
            }
        }
    }
}

// If no images are found at all, use a placeholder.
if (empty($all_images)) {
    $all_images[] = get_template_directory_uri() . '/assets/images/project-1.jpg';
}
?>

<style>
/* Modern Product Detail Styles - Aura Inspired */
:root {
    --virical-gold: #d4af37;
    --virical-gold-hover: #b8941f;
    --virical-dark: #1a1a1a;
    --virical-darker: #0f0f0f;
    --virical-white: #ffffff;
    --virical-light: #f8f9fa;
    --virical-gray: #6c757d;
    --virical-light-gray: #f8f9fa;
    --virical-border: #e9ecef;
    --virical-text: #212529;
    --virical-text-muted: #6c757d;
}

.single-product-modern {
    background-color: #ffffff;
    color: #333;
    font-family: 'Montserrat', sans-serif;
    padding-top: 80px;
    min-height: 100vh;
}

/* Breadcrumb */
.breadcrumb-section {
    background: #f8f9fa;
    padding: 20px 0;
    border-bottom: 1px solid #e9ecef;
}

.breadcrumb {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 14px;
}

.breadcrumb a {
    color: #6c757d;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb a:hover {
    color: var(--virical-gold);
}

.breadcrumb .separator {
    color: #adb5bd;
}

.breadcrumb .current {
    color: #212529;
    font-weight: 600;
}

/* Product Hero Section */
.product-hero {
    background: #1a1a1a;
    padding: 60px 0;
    position: relative;
}

.product-hero-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 550px 1fr;
    gap: 60px;
    align-items: start;
}

/* Product Gallery */
.product-gallery-section {
    position: sticky;
    top: 100px;
}

.gallery-main {
    position: relative;
    background: #000;
    border-radius: 0;
    overflow: hidden;
}

.gallery-slider {
    position: relative;
    height: 550px;
    background: #000;
}

.gallery-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.5s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #000;
}

.gallery-slide.active {
    opacity: 1;
}

.gallery-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
}

.gallery-slide:hover img {
    transform: scale(1.05);
}

/* Fallback for missing images */
.gallery-slide .no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 18px;
}

.gallery-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    border: 1px solid #e9ecef;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 20px;
    transition: all 0.3s ease;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.gallery-nav:hover {
    background: var(--virical-gold);
    color: #fff;
    border-color: var(--virical-gold);
}

.gallery-prev {
    left: 20px;
}

.gallery-next {
    right: 20px;
}

.gallery-thumbs {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-top: 20px;
}

.gallery-thumb {
    width: 100%;
    height: 100px;
    border: 2px solid #333;
    border-radius: 0;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #000;
    position: relative;
}

.gallery-thumb:hover {
    border-color: var(--virical-gold);
}

.gallery-thumb.active {
    border-color: var(--virical-gold);
}

.gallery-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.gallery-thumb .no-image {
    width: 100%;
    height: 100%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 12px;
}

/* Product Info */
.product-info-section {
    padding-top: 20px;
}

.product-code {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.features-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.product-category-badge {
    color: #999;
    font-size: 14px;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 15px;
}

.product-title {
    font-size: 42px;
    font-weight: 300;
    line-height: 1.2;
    margin-bottom: 20px;
    color: #d4af37;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.product-subtitle {
    font-size: 16px;
    color: #ccc;
    margin-bottom: 30px;
    line-height: 1.8;
}

.product-price {
    font-size: 36px;
    color: var(--virical-gold);
    font-weight: 600;
    margin-bottom: 40px;
}

.product-features {
    margin-bottom: 40px;
}

.product-features h3 {
    font-size: 20px;
    margin-bottom: 20px;
    color: #d4af37;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.product-features ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.product-features li {
    padding: 10px 0;
    padding-left: 30px;
    position: relative;
    color: #ccc;
    font-size: 15px;
}

.product-features li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: var(--virical-gold);
    font-size: 18px;
}

.product-actions {
    display: flex;
    gap: 15px;
    margin-top: 40px;
}

.btn-primary,
.btn-secondary {
    padding: 15px 40px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    text-decoration: none;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: 2px solid transparent;
}

.btn-primary {
    background: var(--virical-gold);
    color: #000;
    border-color: var(--virical-gold);
    font-weight: 700;
}

.btn-primary:hover {
    background: transparent;
    color: var(--virical-gold);
    border-color: var(--virical-gold);
}

.btn-secondary {
    background: transparent;
    color: #fff;
    border-color: #fff;
}

.btn-secondary:hover {
    background: #fff;
    color: #000;
    border-color: #fff;
}

/* Specifications Section */
.specifications-section {
    background: #f8f9fa;
    padding: 80px 0;
}

.specifications-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-title {
    font-size: 36px;
    font-weight: 300;
    text-align: center;
    margin-bottom: 50px;
    color: #000 !important;
    text-transform: uppercase;
    letter-spacing: 4px;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: var(--virical-gold);
}

.specifications-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

.spec-group {
    background: #ffffff;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.spec-group-title {
    font-size: 20px;
    font-weight: 500;
    color: var(--virical-gold);
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f8f9fa;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.spec-item {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid #f1f3f5;
}

.spec-item:last-child {
    border-bottom: none;
}

.spec-label {
    color: #6c757d;
    font-size: 15px;
}

.spec-value {
    color: #212529;
    font-size: 15px;
    font-weight: 600;
}

/* Download Section */
.download-section {
    background: #ffffff;
    padding: 80px 0;
}

.download-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.download-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-top: 40px;
}

.download-item {
    background: #f8f9fa;
    padding: 40px 30px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.download-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-color: var(--virical-gold);
}

.download-icon {
    font-size: 48px;
    color: var(--virical-gold);
    margin-bottom: 20px;
}

.download-icon i {
    font-size: 48px;
}

.download-title {
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 15px;
    color: #212529;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.download-link {
    color: var(--virical-gold);
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.download-link:hover {
    color: var(--virical-gold-hover);
}

.download-link i {
    font-size: 12px;
}

/* Applications Section */
.applications-section {
    background: #f8f9fa;
    padding: 80px 0;
}

.applications-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.applications-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-top: 40px;
}

.application-item {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.application-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.application-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    background: #f0f0f0;
}

.application-content {
    padding: 25px;
}

.application-title {
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 10px;
    color: #212529;
}

.application-description {
    color: #6c757d;
    font-size: 14px;
    line-height: 1.6;
}

/* Related Products */
.related-products-section {
    background: #ffffff;
    padding: 80px 0;
}

.related-products-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.related-products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    margin-top: 40px;
}

.related-product-item {
    background: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    text-decoration: none;
    display: block;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.related-product-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.related-product-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    background: #f8f9fa;
    overflow: hidden;
}

.related-product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-product-item:hover .related-product-image img {
    transform: scale(1.1);
}

.related-product-info {
    padding: 20px;
}

.related-product-name {
    font-size: 18px;
    font-weight: 500;
    color: #000 !important;
    margin-bottom: 10px;
}

.related-product-price {
    color: var(--virical-gold);
    font-size: 20px;
    font-weight: 600;
}

/* Product Tabs in Info Section */
.product-tabs {
    margin-top: 40px;
}

.product-tabs .tabs-nav {
    display: flex;
    gap: 0;
    margin-bottom: 30px;
    border-bottom: 1px solid #333;
}

.product-tabs .tab-link {
    padding: 15px 20px;
    color: #999;
    text-decoration: none;
    font-size: 13px;
    letter-spacing: 1px;
    text-transform: uppercase;
    position: relative;
    transition: all 0.3s ease;
    border-bottom: 2px solid transparent;
    margin-bottom: -1px;
}

.product-tabs .tab-link:hover,
.product-tabs .tab-link.active {
    color: var(--virical-gold);
    border-bottom-color: var(--virical-gold);
}

.product-tabs .tab-content {
    display: none;
    background: rgba(255, 255, 255, 0.05);
    padding: 30px;
    border-radius: 0;
}

.product-tabs .tab-content.active {
    display: block;
    animation: fadeIn 0.5s ease;
}

.product-tabs .tab-pane h3 {
    font-size: 18px;
    margin-bottom: 20px;
    color: var(--virical-gold);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.product-tabs .tab-pane p {
    line-height: 1.8;
    color: #ccc;
    margin-bottom: 15px;
}

/* Specs table in tabs */
.specs-table {
    width: 100%;
    margin-top: 20px;
}

.specs-table tr {
    border-bottom: 1px solid #333;
}

.specs-table td {
    padding: 12px 0;
    font-size: 14px;
}

.specs-table td:first-child {
    color: #999;
    width: 40%;
}

.specs-table td:last-child {
    color: #fff;
}

/* Product Content Section */
.product-content-section {
    background: #ffffff;
    padding: 80px 0;
}

.content-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.content-wrapper {
    max-width: 900px;
    margin: 0 auto;
}

.content-title {
    font-size: 36px;
    font-weight: 300;
    margin-bottom: 40px;
    color: #212529;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.content-body {
    font-size: 16px;
    line-height: 1.8;
    color: #495057;
}

.content-body h3 {
    font-size: 24px;
    margin: 40px 0 20px;
    color: #212529;
}

.content-body ul {
    margin: 20px 0;
    padding-left: 30px;
}

.content-body li {
    margin-bottom: 15px;
}

.cta-section {
    background: #f8f9fa;
    padding: 40px;
    border-radius: 8px;
    margin-top: 50px;
    text-align: center;
}

.cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}

.cta-buttons .btn-primary,
.cta-buttons .btn-secondary {
    padding: 15px 30px;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .product-hero-container {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .product-gallery-section {
        position: relative;
        top: 0;
    }
    
    .specifications-grid {
        grid-template-columns: 1fr;
    }
    
    .download-grid,
    .applications-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .related-products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .product-title {
        font-size: 28px;
    }
    
    .gallery-slider {
        height: 350px;
    }
    
    .download-grid,
    .applications-grid,
    .related-products-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .product-actions {
        flex-direction: column;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
    
    .gallery-thumbs {
        overflow-x: auto;
        justify-content: flex-start;
    }
}
</style>

<main class="single-product-modern">
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="breadcrumb">
            <a href="<?php echo home_url(); ?>">Trang chủ</a>
            <span class="separator">›</span>
            <a href="<?php echo home_url('/san-pham/'); ?>">Sản phẩm</a>
            <?php if ($category): ?>
                <span class="separator">›</span>
                <a href="<?php echo home_url('/san-pham/?category=' . $category->slug); ?>"><?php echo esc_html($category->name); ?></a>
            <?php endif; ?>
            <span class="separator">›</span>
            <span class="current"><?php echo esc_html($product->name); ?></span>
        </div>
    </section>
    
    <!-- Product Hero Section -->
    <section class="product-hero">
        <div class="product-hero-container">
            <!-- Product Gallery -->
            <div class="product-gallery-section">
                <div class="gallery-main">
                    <div class="gallery-slider">
                        <?php foreach ($all_images as $index => $image_url): ?>
                            <div class="gallery-slide <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr($product->name); ?> - Image <?php echo $index + 1; ?>"
                                     onerror="this.onerror=null; this.src='http://localhost:8080/wp-content/uploads/2025/01/10.1.png';">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (count($all_images) > 1): ?>
                        <button class="gallery-nav gallery-prev" onclick="changeSlide(-1)">‹</button>
                        <button class="gallery-nav gallery-next" onclick="changeSlide(1)">›</button>
                    <?php endif; ?>
                    
                    <?php if (count($all_images) > 1): ?>
                    <div class="gallery-thumbs">
                        <?php foreach ($all_images as $index => $image_url): ?>
                            <div class="gallery-thumb <?php echo $index === 0 ? 'active' : ''; ?>" onclick="currentSlide(<?php echo $index + 1; ?>)">
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr($product->name); ?> - Thumb <?php echo $index + 1; ?>"
                                     onerror="this.onerror=null; this.src='http://localhost:8080/wp-content/uploads/2025/01/10.1.png';">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="product-info-section">
                <?php if ($category): ?>
                    <div class="product-category-badge"><?php echo esc_html($category->name); ?></div>
                <?php endif; ?>
                
                <h1 class="product-title"><?php echo esc_html($product->name); ?></h1>
                
                <p class="product-subtitle"><?php echo esc_html($product->description); ?></p>
                
                <div class="product-actions">
                    <a href="<?php echo home_url('/lien-he/'); ?>" class="btn-primary">
                        <i class="fas fa-phone"></i>
                        LIÊN HỆ BÁO GIÁ
                    </a>
                    <a href="#download" class="btn-secondary">
                        <i class="fas fa-download"></i>
                        TẢI CATALOGUE
                    </a>
                </div>
                
                <!-- Product Tabs moved here -->
                <div class="product-tabs">
                    <div class="tabs-nav">
                        <a href="#specs" class="tab-link active" data-tab="specs">THÔNG SỐ KỸ THUẬT</a>
                        <a href="#installation" class="tab-link" data-tab="installation">HƯỚNG DẪN LẮP ĐẶT</a>
                        <a href="#warranty" class="tab-link" data-tab="warranty">BẢO HÀNH</a>
                    </div>
                    
                    <div class="tabs-content">
                        <!-- Specifications Tab -->
                        <div id="specs" class="tab-content active">
                            <div class="tab-pane">
                                <h3>Thông số kỹ thuật</h3>
                                <table class="specs-table">
                                    <tr>
                                        <td>Công suất</td>
                                        <td>15W - 50W</td>
                                    </tr>
                                    <tr>
                                        <td>Điện áp</td>
                                        <td>220V - 240V AC</td>
                                    </tr>
                                    <tr>
                                        <td>Nhiệt độ màu</td>
                                        <td>3000K / 4000K / 6500K</td>
                                    </tr>
                                    <tr>
                                        <td>Chỉ số hoàn màu (CRI)</td>
                                        <td>> 90</td>
                                    </tr>
                                    <tr>
                                        <td>Góc chiếu sáng</td>
                                        <td>24° / 36° / 60°</td>
                                    </tr>
                                    <tr>
                                        <td>Tuổi thọ</td>
                                        <td>50,000 giờ</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Installation Tab -->
                        <div id="installation" class="tab-content">
                            <div class="tab-pane">
                                <p>1. Ngắt nguồn điện trước khi lắp đặt</p>
                                <p>2. Xác định vị trí lắp đặt phù hợp</p>
                                <p>3. Kết nối dây điện theo sơ đồ hướng dẫn</p>
                                <p>4. Cố định sản phẩm chắc chắn</p>
                                <p>5. Kiểm tra và bật nguồn điện</p>
                                <p><strong>Lưu ý:</strong> Nên sử dụng thợ điện chuyên nghiệp để đảm bảo an toàn.</p>
                            </div>
                        </div>
                        
                        <!-- Warranty Tab -->
                        <div id="warranty" class="tab-content">
                            <div class="tab-pane">
                                <p><strong>Thời gian bảo hành:</strong> 5 năm kể từ ngày mua hàng</p>
                                <p><strong>Điều kiện bảo hành:</strong></p>
                                <p>- Sản phẩm còn trong thời hạn bảo hành</p>
                                <p>- Có hóa đơn mua hàng và phiếu bảo hành</p>
                                <p>- Sản phẩm bị lỗi do nhà sản xuất</p>
                                <p>- Không tự ý sửa chữa hoặc thay đổi cấu trúc sản phẩm</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Product Content Section for SEO -->
    <section class="product-content-section">
        <div class="content-container">
            <div class="content-wrapper">
                <?php if (!empty($product->content)): ?>
                    <!-- Display content from database -->
                    <div class="product-custom-content">
                        <?php echo wp_kses_post($product->content); ?>
                    </div>
                <?php else: ?>
                    <!-- Default content if no custom content -->
                    <h2 class="content-title"><?php echo esc_html($product->name); ?> - Giải pháp chiếu sáng hiện đại</h2>
                
                <div class="content-body">
                    <p><strong><?php echo esc_html($product->name); ?></strong> là một trong những sản phẩm đèn LED cao cấp được thiết kế với công nghệ hiện đại, mang đến giải pháp chiếu sáng hoàn hảo cho không gian của bạn. Với thiết kế sang trọng và hiệu suất vượt trội, sản phẩm này không chỉ đáp ứng nhu cầu chiếu sáng mà còn tạo điểm nhấn thẩm mỹ cho mọi công trình.</p>
                    
                    <h3>Ưu điểm nổi bật của <?php echo esc_html($product->name); ?></h3>
                    <ul>
                        <li><strong>Tiết kiệm năng lượng:</strong> Công nghệ LED tiên tiến giúp tiết kiệm đến 80% điện năng so với đèn truyền thống</li>
                        <li><strong>Tuổi thọ cao:</strong> Lên đến 50,000 giờ sử dụng, giảm chi phí bảo trì và thay thế</li>
                        <li><strong>Ánh sáng chất lượng:</strong> Chỉ số hoàn màu CRI > 90, cho ánh sáng tự nhiên và chân thực</li>
                        <li><strong>An toàn sức khỏe:</strong> Không chứa thủy ngân, không phát tia UV, an toàn cho người sử dụng</li>
                        <li><strong>Đa dạng ứng dụng:</strong> Phù hợp cho nhiều không gian từ nhà ở, văn phòng đến showroom, cửa hàng</li>
                    </ul>
                    
                    <h3>Ứng dụng của sản phẩm</h3>
                    <p><?php echo esc_html($product->name); ?> được ứng dụng rộng rãi trong nhiều không gian khác nhau:</p>
                    <ul>
                        <li><strong>Không gian thương mại:</strong> Showroom, cửa hàng thời trang, trung tâm thương mại</li>
                        <li><strong>Không gian làm việc:</strong> Văn phòng, phòng họp, khu vực làm việc</li>
                        <li><strong>Không gian gia đình:</strong> Phòng khách, phòng bếp, phòng ngủ</li>
                        <li><strong>Không gian công cộng:</strong> Khách sạn, nhà hàng, quán cafe</li>
                    </ul>
                    
                    <h3>Cam kết chất lượng từ Virical</h3>
                    <p>Virical tự hào là thương hiệu đèn LED hàng đầu tại Việt Nam với cam kết:</p>
                    <ul>
                        <li>Sản phẩm chính hãng 100% với chất lượng được kiểm định nghiêm ngặt</li>
                        <li>Bảo hành chính hãng lên đến 5 năm</li>
                        <li>Đội ngũ tư vấn chuyên nghiệp, hỗ trợ 24/7</li>
                        <li>Dịch vụ lắp đặt tận nơi bởi đội ngũ kỹ thuật viên giàu kinh nghiệm</li>
                        <li>Chính sách đổi trả linh hoạt, đảm bảo quyền lợi khách hàng</li>
                    </ul>
                    
                    <div class="cta-section">
                        <p>Để được tư vấn chi tiết về <strong><?php echo esc_html($product->name); ?></strong> và nhận báo giá tốt nhất, vui lòng liên hệ với chúng tôi:</p>
                        <div class="cta-buttons">
                            <a href="<?php echo home_url('/lien-he/'); ?>" class="btn-primary">
                                <i class="fas fa-phone"></i> Hotline: <?php echo virical_get_company_info('hotline'); ?>
                            </a>
                            <a href="mailto:<?php echo virical_get_company_info('email'); ?>" class="btn-secondary">
                                <i class="fas fa-envelope"></i> Email: <?php echo virical_get_company_info('email'); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Download Section -->
    <section class="download-section" id="download">
        <div class="download-container">
            <h2 class="section-title">Tải xuống</h2>
            
            <div class="download-grid">
                <div class="download-item">
                    <div class="download-icon">📄</div>
                    <h3 class="download-title">IES File</h3>
                    <a href="#" class="download-link">Tải xuống</a>
                </div>
                
                <div class="download-item">
                    <div class="download-icon">📋</div>
                    <h3 class="download-title">Catalog</h3>
                    <a href="#" class="download-link">Tải xuống</a>
                </div>
                
                <div class="download-item">
                    <div class="download-icon">🔧</div>
                    <h3 class="download-title">Hướng dẫn lắp đặt</h3>
                    <a href="#" class="download-link">Tải xuống</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Applications Section -->
    <section class="applications-section">
        <div class="applications-container">
            <h2 class="section-title">Ứng dụng - Công trình</h2>
            
            <div class="applications-grid">
                <div class="application-item">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/project-1.jpg'; ?>" 
                         alt="Không gian sống" 
                         class="application-image">
                    <div class="application-content">
                        <h3 class="application-title">Không gian sống</h3>
                        <p class="application-description">Tạo điểm nhấn cho phòng khách, phòng ngủ với ánh sáng ấm áp, tạo không gian thư giãn và thoải mái.</p>
                    </div>
                </div>
                
                <div class="application-item">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/project-1.jpg'; ?>" 
                         alt="Văn phòng hiện đại" 
                         class="application-image">
                    <div class="application-content">
                        <h3 class="application-title">Văn phòng hiện đại</h3>
                        <p class="application-description">Chiếu sáng chuyên nghiệp cho không gian làm việc, tăng hiệu suất và tạo môi trường làm việc lý tưởng.</p>
                    </div>
                </div>
                
                <div class="application-item">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/project-1.jpg'; ?>" 
                         alt="Showroom & Cửa hàng" 
                         class="application-image">
                    <div class="application-content">
                        <h3 class="application-title">Showroom & Cửa hàng</h3>
                        <p class="application-description">Làm nổi bật sản phẩm với ánh sáng chất lượng cao, thu hút khách hàng và tăng doanh số bán hàng.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Related Products -->
    <section class="related-products-section">
        <div class="related-products-container">
            <h2 class="section-title">Sản phẩm liên quan</h2>
            
            <div class="related-products-grid">
                <?php
                // Get related products from same category
                $related_query = "SELECT * FROM {$wpdb->prefix}virical_products 
                                 WHERE category = %s 
                                 AND id != %d 
                                 AND is_active = 1 
                                 ORDER BY is_featured DESC, RAND() 
                                 LIMIT 4";
                
                $related_products = $wpdb->get_results($wpdb->prepare($related_query, $product->category, $product->id));
                
                if (!empty($related_products)) {
                    foreach ($related_products as $related): ?>
                        <a href="<?php echo home_url('/san-pham/' . $related->slug . '/'); ?>" class="related-product-item">
                            <?php $related_image_url = !empty($related->image_url) ? $related->image_url : get_template_directory_uri() . '/assets/images/project-2.jpg'; ?>
                            <?php if (!empty($related_image_url)): ?>
                                <img src="<?php echo esc_url($related_image_url); ?>" 
                                     alt="<?php echo esc_attr($related->name); ?>" 
                                     class="related-product-image"
                                     onerror="this.src='https://via.placeholder.com/300x200/f0f0f0/999999?text=No+Image'">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x200/f0f0f0/999999?text=No+Image" 
                                     alt="<?php echo esc_attr($related->name); ?>" 
                                     class="related-product-image">
                            <?php endif; ?>
                            <div class="related-product-info">
                                <h3 class="related-product-name"><?php echo esc_html($related->name); ?></h3>
                                <?php if ($related->price): ?>
                                    <div class="related-product-price"><?php echo number_format($related->price, 0, ',', '.'); ?> VNĐ</div>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach;
                } else {
                    // Show placeholder products if no related products found
                    for ($i = 1; $i <= 4; $i++): ?>
                        <div class="related-product-item" style="cursor: default;">
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/project-2.jpg'; ?>" 
                                 alt="Sản phẩm mẫu <?php echo $i; ?>" 
                                 class="related-product-image">
                            <div class="related-product-info">
                                <h3 class="related-product-name">Sản phẩm mẫu <?php echo $i; ?></h3>
                                <div class="related-product-price">Liên hệ</div>
                            </div>
                        </div>
                    <?php endfor;
                }
                ?>
            </div>
        </div>
    </section>
</main>

<script>
// Gallery functionality
let slideIndex = 1;

function changeSlide(n) {
    showSlide(slideIndex += n);
}

function currentSlide(n) {
    showSlide(slideIndex = n);
}

function showSlide(n) {
    let slides = document.getElementsByClassName("gallery-slide");
    let thumbs = document.getElementsByClassName("gallery-thumb");
    
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }
    
    for (let i = 0; i < thumbs.length; i++) {
        thumbs[i].classList.remove("active");
    }
    
    if (slides[slideIndex - 1]) {
        slides[slideIndex - 1].classList.add("active");
    }
    if (thumbs[slideIndex - 1]) {
        thumbs[slideIndex - 1].classList.add("active");
    }
}

// Auto slide
setInterval(() => {
    changeSlide(1);
}, 5000);

// Product Tabs
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all
            tabLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked
            this.classList.add('active');
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        if (!this.classList.contains('tab-link')) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Debug: Log image URLs
console.log('Product image URL:', '<?php echo $product->image_url; ?>');
</script>

<?php get_footer(); ?>