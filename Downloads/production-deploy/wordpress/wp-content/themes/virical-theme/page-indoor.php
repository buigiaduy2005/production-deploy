<?php
/**
 * Template Name: Indoor Page
 * Description: Template for Indoor lighting products page
 * 
 * @package Virical
 */

get_header();

global $wpdb;

// Get page settings
$settings_table = $wpdb->prefix . 'indoor_page_settings';
$settings = $wpdb->get_results("SELECT * FROM $settings_table", OBJECT_K);
$settings_array = [];
foreach ($settings as $setting) {
    $settings_array[$setting->setting_key] = $setting->setting_value;
}

// Get categories and products
$categories_table = $wpdb->prefix . 'indoor_product_categories';
$products_table = $wpdb->prefix . 'indoor_products';

$categories = $wpdb->get_results("
    SELECT * FROM $categories_table 
    WHERE is_active = 1 
    ORDER BY display_order ASC
");
?>

<style>
/* Indoor Page Styles */
.indoor-page {
    background-color: #000000;
    color: #ffffff;
    min-height: 100vh;
}

.indoor-banner {
    width: 100%;
    height: auto;
    max-height: 600px;
    overflow: hidden;
    position: relative;
}

.indoor-banner img {
    width: 100%;
    height: auto;
    object-fit: cover;
}

.indoor-header {
    text-align: center;
    padding: 80px 20px 60px;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
}

.indoor-header h1 {
    font-size: 52px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 4px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
}

.indoor-header h2 {
    font-size: 28px;
    font-weight: 300;
    color: #cccccc;
    letter-spacing: 2px;
}

.indoor-category {
    padding: 60px 0;
    background-color: #000000;
}

.indoor-category:nth-child(even) {
    background-color: #111111;
}

.indoor-category h3 {
    font-size: 36px;
    font-weight: 600;
    color: #ffffff;
    text-align: center;
    margin-bottom: 50px;
    text-transform: uppercase;
    letter-spacing: 3px;
    position: relative;
}

.indoor-category h3:after {
    content: '';
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
}

.indoor-products {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

.indoor-product {
    position: relative;
    overflow: hidden;
    background: #1a1a1a;
    border-radius: 12px;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    border: 1px solid #333;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.indoor-product:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(255, 255, 255, 0.15);
    border-color: #555;
}

.indoor-product a {
    display: block;
    text-decoration: none;
    height: 100%;
}

.indoor-product-image {
    position: relative;
    aspect-ratio: 1;
    overflow: hidden;
}

.indoor-product img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.indoor-product:hover img {
    transform: scale(1.1);
}

.indoor-product-content {
    padding: 25px 20px;
    background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
}

.indoor-product-name {
    color: #ffffff;
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    line-height: 1.4;
    margin: 0;
    transition: color 0.3s ease;
}

.indoor-product:hover .indoor-product-name {
    color: #4ecdc4;
}

.indoor-product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(78, 205, 196, 0.9) 0%, rgba(255, 107, 107, 0.9) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.indoor-product:hover .indoor-product-overlay {
    opacity: 1;
}

.indoor-product-overlay-text {
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-align: center;
}

.product-count {
    text-align: center;
    margin-top: 60px;
    padding: 20px;
}

.product-count span {
    background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
    color: #fff;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    letter-spacing: 1px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .indoor-products {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }
}

@media (max-width: 768px) {
    .indoor-header {
        padding: 60px 20px 40px;
    }
    
    .indoor-header h1 {
        font-size: 36px;
        letter-spacing: 2px;
    }
    
    .indoor-header h2 {
        font-size: 22px;
    }
    
    .indoor-category {
        padding: 40px 0;
    }
    
    .indoor-category h3 {
        font-size: 28px;
        margin-bottom: 40px;
    }
    
    .indoor-products {
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 480px) {
    .indoor-products {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .indoor-header h1 {
        font-size: 28px;
    }
    
    .indoor-header h2 {
        font-size: 18px;
    }
    
    .indoor-category h3 {
        font-size: 24px;
    }
}
</style>

<div class="indoor-page">
    <!-- Banner Image -->
    <?php if (!empty($settings_array['banner_image'])): ?>
    <div class="indoor-banner">
        <img src="<?php echo esc_url($settings_array['banner_image']); ?>" alt="Indoor Lighting">
    </div>
    <?php endif; ?>
    
    <!-- Page Header -->
    <div class="indoor-header">
        <h1><?php echo esc_html($settings_array['page_title'] ?? 'INDOOR LIGHTING'); ?></h1>
        <h2><?php echo esc_html($settings_array['page_subtitle'] ?? 'DOWNLIGHTS AND SPOTLIGHTS'); ?></h2>
    </div>
    
    <?php 
    $total_products = 0;
    foreach ($categories as $category): 
        // Get products for this category
        $products = $wpdb->get_results($wpdb->prepare("
            SELECT * FROM $products_table 
            WHERE category_id = %d AND is_active = 1 
            ORDER BY display_order ASC
        ", $category->id));
        
        if (empty($products)) continue;
        $total_products += count($products);
    ?>
        <div class="indoor-category">
            <div class="container">
                <h3><?php echo esc_html($category->category_name); ?></h3>
                
                <div class="indoor-products">
                    <?php foreach ($products as $product): ?>
                        <div class="indoor-product">
                            <a href="<?php echo esc_url($product->product_link !== '#' ? $product->product_link : 'javascript:void(0);'); ?>">
                                <div class="indoor-product-image">
                                    <?php if ($product->product_image): ?>
                                        <img src="<?php echo esc_url($product->product_image); ?>" 
                                             alt="<?php echo esc_attr($product->product_name); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" 
                                             alt="<?php echo esc_attr($product->product_name); ?>">
                                    <?php endif; ?>
                                    
                                    <div class="indoor-product-overlay">
                                        <div class="indoor-product-overlay-text">Xem chi tiết</div>
                                    </div>
                                </div>
                                
                                <div class="indoor-product-content">
                                    <h4 class="indoor-product-name"><?php echo esc_html($product->product_name); ?></h4>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    
    <!-- Product Count -->
    <div class="product-count">
        <span>Tổng cộng <?php echo $total_products; ?> sản phẩm Indoor</span>
    </div>
</div>

<?php get_footer(); ?>