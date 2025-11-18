<?php
/**
 * Template Name: Virical Product Detail Redesign v2
 * Description: Template hiển thị chi tiết sản phẩm Virical với thiết kế mới (v2)
 */

get_header();

// Lấy thông tin sản phẩm (giữ nguyên logic cũ)
global $wpdb;
$product_slug = get_query_var('product');
if (!$product_slug) {
    $url_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    if (count($url_parts) >= 2 && $url_parts[0] == 'san-pham') {
        $product_slug = $url_parts[1];
    }
}
$table_name = $wpdb->prefix . 'virical_products';
$product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE slug = %s AND status = 'publish'", $product_slug));

if (!$product) {
    get_template_part('template-parts/content', 'none');
    get_footer();
    exit;
}

// Parse JSON data
$specifications = json_decode($product->specifications, true) ?: [];
$versions = json_decode($product->versions, true) ?: [];
$gallery = json_decode($product->gallery, true) ?: [];

?>
<style>
/* Benefits Section */
.benefits-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    background-color: #f3f4f6; /* nền sáng */
    padding: 30px;
    border-radius: 8px;
    margin-top: 30px;
}
.benefit-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.benefit-item svg {
    width: 48px;
    height: 48px;
    color: #6c757d; /* biểu tượng màu xám */
    margin-bottom: 15px;
}
.benefit-item p {
    font-weight: bold; /* chữ mô tả đậm */
    color: #333;
    font-size: 15px;
}


/* General */
body {
    font-family: 'Inter', 'Roboto', sans-serif;
    background-color: #FFFFFF;
    color: #333;
}

.product-page-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Breadcrumb */
.breadcrumb-container {
    padding: 15px 0;
    font-size: 14px;
    color: #999;
}

.breadcrumb-container a {
    color: #999;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-container a:hover {
    color: #1A73E8;
}

/* Product Layout */
.product-detail-layout {
    display: grid;
    grid-template-columns: 3fr 2fr;
    gap: 30px;
}

.product-main-column {
    /* Takes up 2/3 of the space */
}

.product-sidebar {
    /* Takes up 1/3 of the space */
}

.product-core-info {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 30px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

/* Product Gallery */
.product-gallery .main-image-wrapper {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
}

.product-gallery .main-image-wrapper .main-product-image {
    width: 100% !important;
    display: block;
    transition: transform 0.3s ease;
}

.main-image-wrapper:hover .main-product-image {
    transform: scale(1.05);
}

.warranty-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background-color: rgba(0,0,0,0.6);
    color: #fff;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 4px;
}

/* Product Details */
.product-details .product-name {
    font-size: 28px;
    font-weight: 700;
    color: #1A73E8; /* Blue */
    margin-bottom: 10px;
}

.product-meta {
    display: flex;
    gap: 20px;
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.stock-status.in-stock {
    color: #28a745;
}

.stock-status.out-of-stock {
    color: #dc3545;
}

.version-selector {
    margin-bottom: 20px;
}

.version-buttons {
    display: flex;
    gap: 10px;
}

.version-btn {
    padding: 8px 15px;
    border: 1px solid #ccc;
    border-radius: 20px;
    background-color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
}

.version-btn.active {
    background-color: #1A73E8;
    color: #fff;
    border-color: #1A73E8;
}

.product-features {
    list-style-type: disc;
    padding-left: 20px;
    margin-bottom: 20px;
}

.price-section {
    margin-bottom: 20px;
}

.original-price {
    text-decoration: line-through;
    color: #999;
    font-size: 18px;
    margin-right: 10px;
}

.sale-price {
    color: #1A73E8;
    font-size: 28px;
    font-weight: 700;
}

.action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 20px;
}

.btn-add-to-cart, .btn-buy-now {
    padding: 15px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-add-to-cart {
    background-color: #1A73E8;
    color: #fff;
}

.btn-buy-now {
    background-color: #ff9900; /* Orange */
    color: #fff;
}

.quick-contact-form {
    margin-top: 20px;
}

.contact-input-group {
    display: flex;
}

.contact-input-group input {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px 0 0 8px;
}

.btn-submit-phone {
    padding: 10px 20px;
    border: none;
    background-color: #1A73E8;
    color: #fff;
    border-radius: 0 8px 8px 0;
    cursor: pointer;
}

/* Sidebar */
.product-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.commitment-box, .store-locator-box {
    background-color: #f5f7fa;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* Commitment Box */
.commitment-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.virical-logo {
    width: 50px;
    height: auto;
}

.commitment-title h4 {
    font-size: 16px;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.commitment-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.commitment-list li {
    color: #6b7280;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.commitment-list .fas {
    color: #1E40AF;
    margin-right: 10px;
}

/* Store Locator Box */
.store-locator-box h4 {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
}

.location-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.location-tab {
    padding: 8px 15px;
    border: 1px solid #ccc;
    border-radius: 20px;
    background-color: #fff;
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
}

.location-tab.active {
    background-color: #1E40AF;
    color: #fff;
    border-color: #1E40AF;
}

.location-pane {
    display: none;
}

.location-pane.active {
    display: block;
}

.location-pane p {
    color: #6b7280;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.location-pane .fas {
    color: #999;
    margin-right: 10px;
}

/* Responsive */
@media (max-width: 1024px) {
    .product-detail-layout {
        grid-template-columns: 1fr;
    }

    .product-sidebar {
        margin-top: 30px;
    }
}

@media (max-width: 768px) {
    .product-core-info {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="product-page-wrapper">
    <div class="breadcrumb-container">
        <a href="<?php echo home_url(); ?>">Trang chủ</a> >
        <a href="<?php echo home_url('/san-pham'); ?>">Sản phẩm</a> >
        <a href="#">Chiếu sáng thông minh</a> >
        <span><?php echo esc_html($product->name); ?></span>
    </div>

    <main class="product-detail-layout">
        <div class="product-main-column">
            <div class="product-core-info">
                <!-- Cột trái: Hình ảnh -->
                <div class="product-gallery">
                    <div class="main-image-wrapper">
                        <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->name); ?>" class="main-product-image">
                        <span class="warranty-badge">BẢO HÀNH 12 THÁNG</span>
                    </div>
                    <?php if (!empty($gallery)) : ?>
                        <div class="thumbnail-container">
                            <?php foreach ($gallery as $image_url) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="Thumbnail" class="thumbnail-image">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Cột phải: Thông tin -->
                <div class="product-details">
                    <h1 class="product-name"><?php echo esc_html($product->name); ?></h1>
                    <div class="product-meta">
                        <span>Lượt xem: <?php echo (int) $product->views; ?></span>
                        <span class="stock-status <?php echo $product->stock_status === 'in_stock' ? 'in-stock' : 'out-of-stock'; ?>">
                            <?php echo $product->stock_status === 'in_stock' ? 'Có hàng' : 'Hết hàng'; ?>
                        </span>
                    </div>

                    <?php if (!empty($versions)) : ?>
                        <div class="version-selector">
                            <p>Chọn phiên bản:</p>
                            <div class="version-buttons">
                                <?php foreach ($versions as $version) : ?>
                                    <button class="version-btn" data-price="<?php echo esc_attr($version['price']); ?>">
                                        <?php echo esc_html($version['name']); ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <ul class="product-features">
                        <li>Công suất: <?php echo esc_html($specifications['cong_suat'] ?? 'N/A'); ?></li>
                        <li>Quang thông: <?php echo esc_html($specifications['quang_thong'] ?? 'N/A'); ?></li>
                        <li>Chỉ số hoàn màu: <?php echo esc_html($specifications['chi_so_hoan_mau'] ?? 'N/A'); ?></li>
                    </ul>

                    <div class="price-section">
                        <span class="original-price"><?php echo number_format($product->regular_price, 0, ',', '.'); ?>đ</span>
                        <span class="sale-price"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                    </div>

                    <div class="action-buttons">
                        <button class="btn-add-to-cart">Thêm vào giỏ hàng</button>
                        <button class="btn-buy-now">Mua ngay</button>
                    </div>

                    <div class="quick-contact-form">
                        <p>Để lại số điện thoại, chúng tôi sẽ gọi lại ngay</p>
                        <div class="contact-input-group">
                            <input type="tel" placeholder="Nhập số điện thoại của bạn">
                            <button class="btn-submit-phone">Gửi đi</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefits Section -->
            <div class="benefits-section">
                <div class="benefit-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 11.667 0l3.181-3.183m-4.991-2.691V5.25a2.25 2.25 0 0 0-2.25-2.25h-4.5a2.25 2.25 0 0 0-2.25 2.25v4.992m2.25 0h4.5" /></svg>
                    <p>Bảo hành 1 đổi 1 trong 15 tháng</p>
                </div>
                <div class="benefit-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z" /></svg>
                    <p>Bảo hành nhanh chóng</p>
                </div>
                <div class="benefit-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.47-1.678 3.122A11.954 11.954 0 0 1 12 21c-2.647 0-5.195-.604-7.422-1.758C3.63 14.47 3 13.268 3 12c0-1.268.63-2.47 1.678-3.122A11.954 11.954 0 0 1 12 3c2.647 0 5.195.604 7.422 1.758C20.37 9.53 21 10.732 21 12z" /></svg>
                    <p>Hỗ trợ khách trọn đời</p>
                </div>
                <div class="benefit-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.13 1.13 0 0 0-.987 1.106v.958m12 0a2.25 2.25 0 0 0-2.25-2.25H5.25a2.25 2.25 0 0 0-2.25 2.25m13.5 0v-4.125c0-.621-.504-1.125-1.125-1.125H4.125a1.125 1.125 0 0 0-1.125 1.125V14.25" /></svg>
                    <p>Vận chuyển hoả tốc toàn quốc</p>
                </div>
            </div>
        </div>

        <!-- Cột bên phải: Sidebar -->
<aside class="product-sidebar">
    <div class="commitment-box">
        <div class="commitment-header">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logoVirical.svg" alt="Virical Logo" class="virical-logo">
            <div class="commitment-title">
                <h4>Phân phối chính hãng tại Việt Nam</h4>
            </div>
        </div>
        <ul class="commitment-list">
            <li><i class="fas fa-check-circle"></i> Hoàn tiền 100% nếu phát hiện hàng giả</li>
            <li><i class="fas fa-sync-alt"></i> Đổi trả trong 7 ngày nếu lỗi</li>
        </ul>
    </div>

    <div class="store-locator-box">
        <h4>Hệ thống cửa hàng</h4>
        <div class="location-tabs">
            <button class="location-tab active" data-location="north">Miền Bắc</button>
            <button class="location-tab" data-location="central">Miền Trung</button>
            <button class="location-tab" data-location="south">Miền Nam</button>
        </div>
        <div class="location-content">
            <div id="location-north" class="location-pane active">
                <p><i class="fas fa-map-marker-alt"></i> Số 63A Phố Vọng, Phường Đồng Tâm, Quận Hai Bà Trưng, Hà Nội</p>
                <p><i class="fas fa-map-marker-alt"></i> 1019 Trần Hưng Đạo, P. Văn Giang, TP Ninh Bình</p>
            </div>
            <div id="location-central" class="location-pane">
                <p><i class="fas fa-map-marker-alt"></i> Địa chỉ Miền Trung 1</p>
            </div>
            <div id="location-south" class="location-pane">
                <p><i class="fas fa-map-marker-alt"></i> Địa chỉ Miền Nam 1</p>
            </div>
        </div>
    </div>
</aside>
    </main>
</div>

<script>
// Script for version selection and location tabs
document.addEventListener('DOMContentLoaded', function() {
    // Version buttons
    const versionButtons = document.querySelectorAll('.version-btn');
    const salePriceElement = document.querySelector('.sale-price');
    const originalPrice = <?php echo (float)$product->price; ?>;

    versionButtons.forEach(button => {
        button.addEventListener('click', () => {
            versionButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            const newPrice = button.dataset.price;
            if (newPrice) {
                salePriceElement.textContent = new Intl.NumberFormat('vi-VN').format(newPrice) + 'đ';
            }
        });
    });

    // Location tabs
    const locationTabs = document.querySelectorAll('.location-tab');
    const locationPanes = document.querySelectorAll('.location-pane');

    locationTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = document.getElementById('location-' + tab.dataset.location);

            locationTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            locationPanes.forEach(p => p.classList.remove('active'));
            target.classList.add('active');
        });
    });
});
</script>

<?php get_footer(); ?>