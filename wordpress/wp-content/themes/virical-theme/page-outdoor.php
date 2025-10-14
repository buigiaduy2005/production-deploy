<?php
/**
 * Template Name: Outdoor Page
 * Description: Template for displaying outdoor lighting products
 */

get_header();

global $wpdb;

// Get page settings
$settings_table = $wpdb->prefix . 'outdoor_page_settings';
$settings = $wpdb->get_results("SELECT * FROM $settings_table", OBJECT_K);
$page_settings = [];
foreach ($settings as $setting) {
    $page_settings[$setting->setting_key] = $setting->setting_value;
}

// Get sections
$sections_table = $wpdb->prefix . 'outdoor_sections';
$sections = $wpdb->get_results("
    SELECT * FROM $sections_table 
    WHERE is_active = 1 
    ORDER BY section_order ASC
");

// Get products grouped by section
$products_table = $wpdb->prefix . 'outdoor_page_products';
$products_by_section = [];
foreach ($sections as $section) {
    if ($section->section_name !== 'banner') {
        $products = $wpdb->get_results($wpdb->prepare("
            SELECT * FROM $products_table 
            WHERE section_id = %d AND is_active = 1 
            ORDER BY product_order ASC
        ", $section->id));
        $products_by_section[$section->id] = $products;
    }
}
?>

<style>
    .outdoor-page {
        background: #000;
        color: #fff;
    }
    
    .outdoor-banner {
        position: relative;
        width: 100%;
        height: 80vh;
        min-height: 500px;
        overflow: hidden;
    }
    
    .outdoor-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .outdoor-banner-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 2;
    }
    
    .outdoor-banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }
    
    .outdoor-banner h1 {
        color: #fff;
        font-size: 4rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 20px;
        letter-spacing: 3px;
    }
    
    .outdoor-banner h2 {
        color: #fff;
        font-size: 2rem;
        font-weight: 300;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    
    .outdoor-section {
        padding: 80px 0;
        background: #fff;
    }
    
    .outdoor-section:nth-child(even) {
        background: #f8f8f8;
    }
    
    .outdoor-section-title {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .outdoor-section-title h2 {
        font-size: 2.5rem;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: relative;
        display: inline-block;
        padding-bottom: 15px;
    }
    
    .outdoor-section-title h2:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: #d94948;
    }
    
    .outdoor-products {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .outdoor-product {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .outdoor-product:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    
    .outdoor-product-image {
        position: relative;
        padding-bottom: 100%;
        overflow: hidden;
        background: #f5f5f5;
    }
    
    .outdoor-product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .outdoor-product:hover .outdoor-product-image img {
        transform: scale(1.1);
    }
    
    .outdoor-product-info {
        padding: 20px;
    }
    
    .outdoor-product-name {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .outdoor-product-description {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
    }
    
    .outdoor-cta {
        text-align: center;
        padding: 60px 0;
        background: #111;
    }
    
    .outdoor-cta-button {
        display: inline-block;
        padding: 15px 40px;
        background: #d94948;
        color: #fff;
        text-decoration: none;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 50px;
        transition: background 0.3s ease;
    }
    
    .outdoor-cta-button:hover {
        background: #e93333;
        color: #fff;
    }
    
    @media (max-width: 768px) {
        .outdoor-banner h1 {
            font-size: 2.5rem;
        }
        
        .outdoor-banner h2 {
            font-size: 1.5rem;
        }
        
        .outdoor-section {
            padding: 50px 0;
        }
        
        .outdoor-products {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
    }
    
    @media (max-width: 480px) {
        .outdoor-banner h1 {
            font-size: 2rem;
        }
        
        .outdoor-banner h2 {
            font-size: 1.2rem;
        }
        
        .outdoor-products {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="outdoor-page">
    <!-- Banner Section -->
    <?php 
    $banner_section = null;
    foreach ($sections as $section) {
        if ($section->section_name === 'banner') {
            $banner_section = $section;
            break;
        }
    }
    
    if ($banner_section): ?>
    <section class="outdoor-banner">
        <div class="outdoor-banner-overlay"></div>
        <img src="<?php echo esc_url($page_settings['banner_image'] ?? ''); ?>" alt="<?php echo esc_attr($banner_section->section_title); ?>">
        <div class="outdoor-banner-content">
            <h1><?php echo esc_html($banner_section->section_title); ?></h1>
            <?php if ($banner_section->section_subtitle): ?>
                <h2><?php echo esc_html($banner_section->section_subtitle); ?></h2>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Product Sections -->
    <?php foreach ($sections as $section): 
        if ($section->section_name === 'banner') continue;
        $products = $products_by_section[$section->id] ?? [];
        if (empty($products)) continue;
    ?>
    <section class="outdoor-section" id="<?php echo esc_attr($section->section_name); ?>">
        <div class="outdoor-section-title">
            <h2><?php echo esc_html($section->section_title); ?></h2>
        </div>
        
        <div class="outdoor-products">
            <?php foreach ($products as $product): ?>
            <div class="outdoor-product">
                <div class="outdoor-product-image">
                    <img src="<?php echo esc_url($product->product_image); ?>" 
                         alt="<?php echo esc_attr($product->product_name); ?>">
                </div>
                <div class="outdoor-product-info">
                    <h3 class="outdoor-product-name"><?php echo esc_html($product->product_name); ?></h3>
                    <?php if ($product->product_description): ?>
                        <p class="outdoor-product-description"><?php echo esc_html($product->product_description); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endforeach; ?>
    
    <!-- CTA Section -->
    <?php if (!empty($page_settings['show_cta_button']) && $page_settings['show_cta_button'] == '1'): ?>
    <section class="outdoor-cta">
        <a href="<?php echo esc_url($page_settings['cta_button_link'] ?? '#'); ?>" class="outdoor-cta-button">
            <?php echo esc_html($page_settings['cta_button_text'] ?? 'Xem Catalog'); ?>
        </a>
    </section>
    <?php endif; ?>
</div>

<?php get_footer(); ?>