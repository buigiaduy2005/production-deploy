<?php
/**
 * Template Name: Products Page
 * 
 * @package Virical
 */

get_header();

global $wpdb;

// Get all active categories
$categories = $wpdb->get_results("
    SELECT * FROM {$wpdb->prefix}virical_product_categories 
    WHERE is_active = 1 
    ORDER BY sort_order, name
");

// Get selected category from URL
$selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Build query
$query = "SELECT * FROM {$wpdb->prefix}virical_products WHERE is_active = 1";
if ($selected_category) {
    $query .= $wpdb->prepare(" AND category = %s", $selected_category);
}
$query .= " ORDER BY is_featured DESC, sort_order, id DESC";

$products = $wpdb->get_results($query);

// Group products by category if no filter
$products_by_category = [];
if (!$selected_category) {
    foreach ($products as $product) {
        $products_by_category[$product->category][] = $product;
    }
}
?>

<style>
/* Products Page Styles */
:root {
    --virical-gold: #d4af37;
    --virical-dark: #1a1a1a;
    --virical-light: #f8f8f8;
}

.products-page {
    background-color: #000;
    color: #fff;
    min-height: 100vh;
}

/* Hero Section */
.products-hero {
    position: relative;
    height: 60vh;
    min-height: 400px;
    background: url('https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=1920') center/cover;
    display: flex;
    align-items: center;
    justify-content: center;
}

.products-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
}

.hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.hero-title {
    font-size: 60px;
    font-weight: 700;
    letter-spacing: 8px;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.hero-subtitle {
    font-size: 18px;
    letter-spacing: 3px;
    color: var(--virical-gold);
}

/* Ensure header stays on top */
.site-header {
    z-index: 1001 !important; /* Higher than navigation */
}

/* Product sections spacing */
.products-section:first-of-type {
    padding-top: 60px;
}

/* Products Grid */
.products-section {
    padding: 80px 0;
    background: #000;
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
}

.section-line {
    width: 80px;
    height: 2px;
    background: var(--virical-gold);
    margin: 0 auto;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.product-item {
    background: var(--virical-dark);
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.product-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(212, 175, 55, 0.2);
}

.product-image {
    position: relative;
    width: 100%;
    height: 300px;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-item:hover .product-image img {
    transform: scale(1.1);
}

.product-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: var(--virical-gold);
    color: #000;
    padding: 5px 15px;
    font-size: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-weight: 600;
}

.product-info {
    padding: 30px;
}

.product-category {
    color: var(--virical-gold);
    font-size: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.product-name {
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 15px;
    line-height: 1.4;
}

.product-description {
    color: #999;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.product-features {
    list-style: none;
    padding: 0;
    margin: 0 0 20px 0;
}

.product-features li {
    color: #888;
    font-size: 13px;
    padding: 5px 0;
    padding-left: 20px;
    position: relative;
}

.product-features li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--virical-gold);
}

.product-price {
    font-size: 24px;
    font-weight: 600;
    color: var(--virical-gold);
}

.product-link {
    display: inline-block;
    margin-top: 20px;
    color: var(--virical-gold);
    text-decoration: none;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
    position: relative;
    padding-bottom: 5px;
}

.product-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 1px;
    background: var(--virical-gold);
    transition: width 0.3s ease;
}

.product-link:hover::after {
    width: 100%;
}

/* No Products Message */
.no-products {
    text-align: center;
    padding: 100px 20px;
    color: #666;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 36px;
        letter-spacing: 4px;
    }
    
    .filter-tabs {
        gap: 15px;
    }
    
    .filter-tab {
        font-size: 12px;
        padding: 8px 15px;
    }
    
    .products-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}

/* Animations */
.fade-in {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeIn 0.8s ease forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-item {
    animation-delay: calc(var(--index) * 0.1s);
}
</style>

<main class="products-page">
    <!-- Hero Section -->
    <section class="products-hero">
        <div class="hero-content fade-in">
            <h1 class="hero-title">SẢN PHẨM</h1>
            <p class="hero-subtitle">Giải pháp chiếu sáng hiện đại</p>
        </div>
    </section>

    <!-- Include Product Navigation Bar -->
    <?php get_template_part('template-parts/product-navigation'); ?>

    <!-- Products Display -->
    <?php if ($selected_category): ?>
        <!-- Single Category View -->
        <section class="products-section">
            <div class="container">
                <?php if (!empty($products)): ?>
                    <div class="products-grid">
                        <?php foreach ($products as $index => $product): ?>
                            <?php 
                            $features = json_decode($product->features, true);
                            ?>
                            <div class="product-item fade-in" style="--index: <?php echo $index; ?>">
                                <div class="product-image">
                                    <img src="<?php echo esc_url($product->image_url); ?>" 
                                         alt="<?php echo esc_attr($product->name); ?>">
                                    <?php if ($product->is_featured): ?>
                                        <span class="product-badge">Nổi bật</span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <div class="product-category">
                                        <?php
                                        $cat_name = '';
                                        foreach ($categories as $cat) {
                                            if ($cat->slug === $product->category) {
                                                $cat_name = $cat->name;
                                                break;
                                            }
                                        }
                                        echo esc_html($cat_name);
                                        ?>
                                    </div>
                                    <h3 class="product-name"><?php echo esc_html($product->name); ?></h3>
                                    <p class="product-description"><?php echo esc_html($product->description); ?></p>
                                    
                                    <?php if (!empty($features)): ?>
                                        <ul class="product-features">
                                            <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                                                <li><?php echo esc_html($feature); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    
                                    <?php if ($product->price): ?>
                                        <div class="product-price">
                                            <?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ
                                        </div>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo home_url('/san-pham/' . $product->slug . '/'); ?>" class="product-link">Xem chi tiết →</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-products">
                        <h3>Không có sản phẩm nào trong danh mục này</h3>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php else: ?>
        <!-- All Categories View -->
        <?php foreach ($categories as $category): ?>
            <?php if (isset($products_by_category[$category->slug]) && !empty($products_by_category[$category->slug])): ?>
                <section class="products-section">
                    <div class="section-header fade-in">
                        <h2 class="section-title"><?php echo esc_html($category->name); ?></h2>
                        <div class="section-line"></div>
                    </div>
                    
                    <div class="products-grid">
                        <?php foreach ($products_by_category[$category->slug] as $index => $product): ?>
                            <?php 
                            $features = json_decode($product->features, true);
                            ?>
                            <div class="product-item fade-in" style="--index: <?php echo $index; ?>">
                                <div class="product-image">
                                    <img src="<?php echo esc_url($product->image_url); ?>" 
                                         alt="<?php echo esc_attr($product->name); ?>">
                                    <?php if ($product->is_featured): ?>
                                        <span class="product-badge">Nổi bật</span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name"><?php echo esc_html($product->name); ?></h3>
                                    <p class="product-description"><?php echo esc_html($product->description); ?></p>
                                    
                                    <?php if (!empty($features)): ?>
                                        <ul class="product-features">
                                            <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                                                <li><?php echo esc_html($feature); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    
                                    <?php if ($product->price): ?>
                                        <div class="product-price">
                                            <?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ
                                        </div>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo home_url('/san-pham/' . $product->slug . '/'); ?>" class="product-link">Xem chi tiết →</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<script>
// Intersection Observer for fade-in animations
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });
});

// Product item click to detail
document.querySelectorAll('.product-item').forEach(item => {
    item.addEventListener('click', function(e) {
        if (!e.target.closest('.product-link')) {
            const link = this.querySelector('.product-link');
            if (link) {
                link.click();
            }
        }
    });
});
</script>

<?php get_footer(); ?>