<?php
/**
 * Single Product Template
 * 
 * @package Virical
 */

get_header();

// Get product data
$product_code = get_post_meta(get_the_ID(), 'product_code', true);
$product_price = get_post_meta(get_the_ID(), 'product_price', true);
$product_features = get_post_meta(get_the_ID(), 'product_features', true);
$product_specifications = get_post_meta(get_the_ID(), 'product_specifications', true);
$product_image_url = get_post_meta(get_the_ID(), 'product_image_url', true);

// Get product category
$product_categories = get_the_terms(get_the_ID(), 'product_category');
$category_name = '';
if ($product_categories && !is_wp_error($product_categories)) {
    $category_name = $product_categories[0]->name;
}
?>

<style>
/* Single Product Styles */
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

.single-product-page {
    background-color: #000;
    color: #fff;
    min-height: 100vh;
    padding-top: 80px;
}

/* Breadcrumb */
.breadcrumb-section {
    padding: 20px 0;
    background: var(--virical-dark);
    border-bottom: 1px solid rgba(212, 175, 55, 0.2);
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
    color: #999;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb a:hover {
    color: var(--virical-gold);
}

.breadcrumb .separator {
    color: #666;
}

.breadcrumb .current {
    color: var(--virical-gold);
}

/* Product Main Section */
.product-main {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
    display: grid;
    grid-template-columns: 550px 1fr;
    gap: 60px;
    align-items: start;
}

/* Product Gallery */
.product-gallery {
    position: sticky;
    top: 100px;
}

.main-image {
    width: 100%;
    height: 550px;
    background: #000;
    overflow: hidden;
    position: relative;
}

.main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.main-image:hover img {
    transform: scale(1.05);
}

.gallery-thumbs {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-top: 20px;
}

.thumb-item {
    width: 100%;
    height: 100px;
    background: #000;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid #333;
    transition: all 0.3s ease;
}

.thumb-item:hover,
.thumb-item.active {
    border-color: var(--virical-gold);
}

.thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Info */
.product-info {
    padding-top: 20px;
}

.product-category {
    color: #999;
    font-size: 14px;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 15px;
}

.product-title {
    font-size: 42px;
    font-weight: 300;
    letter-spacing: 2px;
    margin-bottom: 20px;
    line-height: 1.2;
    color: var(--virical-gold);
    text-transform: uppercase;
}

.product-code {
    color: #999;
    font-size: 14px;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.product-price {
    font-size: 36px;
    color: var(--virical-gold);
    font-weight: 600;
    margin-bottom: 30px;
}

.product-description {
    font-size: 16px;
    line-height: 1.8;
    color: #ccc;
    margin-bottom: 30px;
}

/* Action Buttons */
.product-actions {
    display: flex;
    gap: 20px;
    margin-bottom: 40px;
}

.btn-primary,
.btn-secondary {
    padding: 15px 40px;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
}

.btn-primary {
    background: var(--virical-gold);
    color: #000;
    border-color: var(--virical-gold);
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

/* Related Products */
.related-products-section {
    padding: 80px 0;
    background: #f8f9fa;
}

.related-products-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-title {
    font-size: 36px;
    font-weight: 300;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 10px;
    color: #212529;
}

.section-line {
    width: 80px;
    height: 3px;
    background: var(--virical-gold);
    margin: 0 auto;
}

.related-products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.related-product-item {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
    text-decoration: none;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.related-product-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.related-product-image {
    width: 100%;
    height: 250px;
    overflow: hidden;
    background: #f8f9fa;
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
    margin-bottom: 10px;
    color: #212529;
    font-weight: 500;
}

.related-product-price {
    color: var(--virical-gold);
    font-size: 20px;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 1024px) {
    .product-main {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .product-gallery {
        position: relative;
        top: 0;
    }
    
    .related-products-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .product-title {
        font-size: 32px;
    }
    
    .product-price {
        font-size: 28px;
    }
    
    .product-actions {
        flex-direction: column;
    }
    
    .btn-primary,
    .btn-secondary {
        width: 100%;
        justify-content: center;
    }
    
    .tabs-nav {
        gap: 20px;
        overflow-x: auto;
    }
    
    .related-products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

@media (max-width: 480px) {
    .related-products-grid {
        grid-template-columns: 1fr;
    }
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
</style>

<main class="single-product-page">
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="breadcrumb">
            <a href="<?php echo home_url(); ?>">Trang chủ</a>
            <span class="separator">›</span>
            <a href="<?php echo get_post_type_archive_link('aura_product'); ?>">Sản phẩm</a>
            <?php if ($category_name): ?>
                <span class="separator">›</span>
                <a href="<?php echo get_post_type_archive_link('aura_product'); ?>?category=<?php echo $product_categories[0]->slug; ?>"><?php echo esc_html($category_name); ?></a>
            <?php endif; ?>
            <span class="separator">›</span>
            <span class="current"><?php the_title(); ?></span>
        </div>
    </section>

    <!-- Product Main Section -->
    <section class="product-main">
        <!-- Product Gallery -->
        <div class="product-gallery">
            <div class="main-image">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('full'); ?>
                <?php elseif ($product_image_url): ?>
                    <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php the_title_attribute(); ?>">
                <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product-placeholder.jpg" alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
            </div>
            
            <!-- Gallery Thumbnails (if you have multiple images) -->
            <div class="gallery-thumbs">
                <div class="thumb-item active">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('thumbnail'); ?>
                    <?php elseif ($product_image_url): ?>
                        <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                </div>
                <!-- Add more thumbnails here if available -->
            </div>
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <?php if ($category_name): ?>
                <div class="product-category"><?php echo esc_html($category_name); ?></div>
            <?php endif; ?>
            
            <h1 class="product-title"><?php the_title(); ?></h1>
            
            <?php if ($product_code): ?>
                <div class="product-code">Mã sản phẩm: <?php echo esc_html($product_code); ?></div>
            <?php endif; ?>
            
            <div class="product-description">
                <?php the_content(); ?>
            </div>
            
            <div class="product-actions">
                <a href="<?php echo home_url('/lien-he/'); ?>" class="btn-primary">
                    <i class="fas fa-phone"></i>
                    LIÊN HỆ BÁO GIÁ
                </a>
                <a href="#" class="btn-secondary" onclick="window.print(); return false;">
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
                            <?php if ($product_specifications): ?>
                                <?php echo wpautop($product_specifications); ?>
                            <?php else: ?>
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
                            <?php endif; ?>
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
    </section>

    <!-- Product Content Section for SEO -->
    <section class="product-content-section">
        <div class="content-container">
            <div class="content-wrapper">
                <h2 class="content-title"><?php the_title(); ?> - Giải pháp chiếu sáng hiện đại</h2>
                
                <div class="content-body">
                    <p><strong><?php the_title(); ?></strong> là một trong những sản phẩm đèn LED cao cấp được thiết kế với công nghệ hiện đại, mang đến giải pháp chiếu sáng hoàn hảo cho không gian của bạn. Với thiết kế sang trọng và hiệu suất vượt trội, sản phẩm này không chỉ đáp ứng nhu cầu chiếu sáng mà còn tạo điểm nhấn thẩm mỹ cho mọi công trình.</p>
                    
                    <h3>Ưu điểm nổi bật của <?php the_title(); ?></h3>
                    <ul>
                        <li><strong>Tiết kiệm năng lượng:</strong> Công nghệ LED tiên tiến giúp tiết kiệm đến 80% điện năng so với đèn truyền thống</li>
                        <li><strong>Tuổi thọ cao:</strong> Lên đến 50,000 giờ sử dụng, giảm chi phí bảo trì và thay thế</li>
                        <li><strong>Ánh sáng chất lượng:</strong> Chỉ số hoàn màu CRI > 90, cho ánh sáng tự nhiên và chân thực</li>
                        <li><strong>An toàn sức khỏe:</strong> Không chứa thủy ngân, không phát tia UV, an toàn cho người sử dụng</li>
                        <li><strong>Đa dạng ứng dụng:</strong> Phù hợp cho nhiều không gian từ nhà ở, văn phòng đến showroom, cửa hàng</li>
                    </ul>
                    
                    <h3>Ứng dụng của sản phẩm</h3>
                    <p><?php the_title(); ?> được ứng dụng rộng rãi trong nhiều không gian khác nhau:</p>
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
                        <p>Để được tư vấn chi tiết về <strong><?php the_title(); ?></strong> và nhận báo giá tốt nhất, vui lòng liên hệ với chúng tôi:</p>
                        <div class="cta-buttons">
                            <a href="<?php echo home_url('/lien-he/'); ?>" class="btn-primary">
                                <i class="fas fa-phone"></i> Hotline: 1900 xxxx
                            </a>
                            <a href="mailto:info@virical.vn" class="btn-secondary">
                                <i class="fas fa-envelope"></i> Email: info@virical.vn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="related-products-section">
        <div class="related-products-container">
            <div class="section-header">
                <h2 class="section-title">Sản phẩm liên quan</h2>
                <div class="section-line"></div>
            </div>
            
            <div class="related-products-grid">
                <?php
                // Get related products
                $related_args = array(
                    'post_type' => 'aura_product',
                    'posts_per_page' => 4,
                    'post__not_in' => array(get_the_ID()),
                    'orderby' => 'rand'
                );
                
                if ($product_categories) {
                    $related_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'product_category',
                            'field' => 'term_id',
                            'terms' => $product_categories[0]->term_id
                        )
                    );
                }
                
                $related_products = new WP_Query($related_args);
                
                if ($related_products->have_posts()):
                    while ($related_products->have_posts()): $related_products->the_post();
                        $related_price = get_post_meta(get_the_ID(), 'product_price', true);
                        $related_image_url = get_post_meta(get_the_ID(), 'product_image_url', true);
                ?>
                    <a href="<?php the_permalink(); ?>" class="related-product-item">
                        <div class="related-product-image">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php elseif ($related_image_url): ?>
                                <img src="<?php echo esc_url($related_image_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else: ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/product-placeholder.jpg" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="related-product-info">
                            <h3 class="related-product-name"><?php the_title(); ?></h3>
                            <?php if ($related_price): ?>
                                <div class="related-product-price"><?php echo number_format($related_price, 0, ',', '.'); ?> VNĐ</div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>
</main>

<script>
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
    
    // Gallery Thumbnails
    const thumbs = document.querySelectorAll('.thumb-item');
    const mainImage = document.querySelector('.main-image img');
    
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            thumbs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const thumbImg = this.querySelector('img');
            if (thumbImg && mainImage) {
                mainImage.src = thumbImg.src;
            }
        });
    });
});
</script>

<?php get_footer(); ?>