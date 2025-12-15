<?php
/**
 * Template Name: Front Page - Dynamic Aura Design
 * 
 * @package Aura_Lighting
 */

get_header(); ?>

<!-- Hero Slider -->
<section class="hero-slider-section">
    <div class="hero-slider owl-carousel">
        <?php
        // Get slider posts
        $slider_args = array(
            'post_type'      => 'aura_slider',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'post_status'    => 'publish'
        );
        
        $slider_query = new WP_Query( $slider_args );
        
        if ( $slider_query->have_posts() ) :
            while ( $slider_query->have_posts() ) : $slider_query->the_post();
                $slide_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                $slide_subtitle = get_post_meta( get_the_ID(), '_slide_subtitle', true );
                $box_title = get_post_meta( get_the_ID(), '_box_title', true );
                $slide_link = get_post_meta( get_the_ID(), '_slide_link', true );
                
                if ( $slide_image ) : ?>
                    <div class="item" style="background-image: url('<?php echo esc_url( $slide_image ); ?>');">
                        <?php if ( $slide_link ) : ?>
                            <a href="<?php echo esc_url( $slide_link ); ?>" class="slide-link">
                        <?php endif; ?>
                        
                        <div class="slide-overlay">
                            <div class="slide-content">
                                <?php if ( $slide_subtitle ) : ?>
                                    <h2 class="slide-title"><?php echo esc_html( $slide_subtitle ); ?></h2>
                                <?php endif; ?>
                                
                            </div>
                        </div>
                        
                        <?php if ( $slide_link ) : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif;
            endwhile;
            wp_reset_postdata();
        else : ?>
            <!-- Default slides if no custom slides exist -->
            <div class="item" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/2022_collection-Aura.jpg');">
                <div class="slide-overlay">
                    <div class="slide-content">
                        <h2 class="slide-title">BỘ SƯU TẬP 2022</h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Promo Grid Section -->
<section class="promo-grid-section">
    <div class="container">
        <div class="promo-grid">
            <!-- Row 1, Column 1: December Promo -->
            <div class="promo-item promo-highlight">
                <div class="promo-content">
                    <h3 class="promo-title" style="color: #e31e24; font-weight: 700; text-transform: uppercase;">CHƯƠNG TRÌNH KHUYẾN MẠI THÁNG 12</h3>
                    <p class="promo-desc">Tặng ngay Xiaomi Lockin & Aqara Smart Locks</p>
                    <div class="promo-badges">
                        <span class="promo-badge">Trị giá 5.500k</span>
                        <span class="promo-badge">Trị giá 15.500k</span>
                    </div>
                    <p class="promo-terms">Áp dụng từ: 01/12 đến 31/12/2025</p>
                </div>
            </div>
            
            <!-- Row 1, Column 2: Smart Locks -->
            <div class="promo-item">
                <div class="promo-image-placeholder placeholder-bg-1">
                    <div class="promo-overlay">
                        <h3>KHÓA THÔNG MINH</h3>
                        <p>A100 & D100 ZIGBEE - U50</p>
                    </div>
                </div>
            </div>
            
            <!-- Row 2, Column 1: Hubs -->
            <div class="promo-item">
                <div class="promo-image-placeholder placeholder-bg-2">
                    <div class="promo-overlay">
                        <h3>AQARA HUB</h3>
                        <p>M3 & M2 CENTER</p>
                    </div>
                </div>
            </div>
            
            <!-- Row 2, Column 2: Doorbell -->
            <div class="promo-item">
                <div class="promo-image-placeholder placeholder-bg-3">
                    <div class="promo-overlay">
                        <h3>CHUÔNG CỬA THÔNG MINH</h3>
                        <p>G4 VIDEO DOORBELL</p>
                    </div>
                </div>
            </div>
            
            <!-- Row 3, Column 1 -->
            <div class="promo-item">
                <div class="promo-content">
                    <h3>GIẢI PHÁP CHIẾU SÁNG</h3>
                    <p>Thiết kế ánh sáng chuyên nghiệp</p>
                </div>
            </div>
            
            <!-- Row 3, Column 2 -->
            <div class="promo-item">
                <div class="promo-content">
                    <h3>CÔNG TẮC THÔNG MINH</h3>
                    <p>Điều khiển mọi thứ trong tầm tay</p>
                </div>
            </div>
            
            <!-- Row 4, Column 1 -->
            <div class="promo-item">
                <div class="promo-content">
                    <h3>RÈM CỬA TỰ ĐỘNG</h3>
                    <p>Tiện nghi và sang trọng</p>
                </div>
            </div>
            
            <!-- Row 4, Column 2 -->
            <div class="promo-item">
                <div class="promo-content">
                    <h3>CẢM BIẾN AN NINH</h3>
                    <p>Bảo vệ ngôi nhà bạn 24/7</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section - Enhanced -->

<section class="content-section about-section">
    <div class="container">
        <div class="section-header">
            <h3 class="section-subtitle"><?php echo esc_html( get_option( 'aura_about_intro_title', 'VỀ VIRICAL' ) ); ?></h3>
            <h2 class="section-title"><?php echo esc_html( get_option( 'aura_about_hero_subtitle', 'Virical - SMARTHOME' ) ); ?></h2>
            <div class="section-divider"></div>
            <div class="section-desc">
                <?php echo wp_kses_post( get_option( 'aura_about_intro_content', 'VIRICAL là thương hiệu đèn chiếu sáng cao cấp, mang đến những giải pháp ánh sáng hoàn hảo cho mọi không gian. Với công nghệ tiên tiến và thiết kế sang trọng, chúng tôi tạo nên những trải nghiệm ánh sáng độc đáo và ấn tượng.' ) ); ?>
            </div>
            <div class="section-divider"></div>
        </div>

        <!-- Company Highlights -->
        <div class="company-highlights">
            <div class="highlight-item">
                <div class="highlight-number">15+</div>
                <div class="highlight-label">Năm Kinh Nghiệm</div>
                <div class="highlight-desc">Trong lĩnh vực chiếu sáng chuyên nghiệp</div>
            </div>
            <div class="highlight-item">
                <div class="highlight-number">500+</div>
                <div class="highlight-label">Dự Án Hoàn Thành</div>
                <div class="highlight-desc">Các công trình lớn nhỏ trên toàn quốc</div>
            </div>
            <div class="highlight-item">
                <div class="highlight-number">1000+</div>
                <div class="highlight-label">Khách Hàng Tin Tưởng</div>
                <div class="highlight-desc">Từ dân dụng đến thương mại cao cấp</div>
            </div>
            <div class="highlight-item">
                <div class="highlight-number">100%</div>
                <div class="highlight-label">Cam Kết Chất Lượng</div>
                <div class="highlight-desc">Sản phẩm chính hãng, bảo hành toàn diện</div>
            </div>
        </div>

        <!-- Core Values -->
        <div class="core-values">
            <div class="value-item">
                <div class="value-icon">
                    <i class="fa fa-lightbulb"></i>
                </div>
                <h3 class="value-title">Đổi Mới Sáng Tạo</h3>
                <p class="value-desc">Không ngừng nghiên cứu và ứng dụng công nghệ chiếu sáng tiên tiến nhất, mang đến những giải pháp ánh sáng đột phá và độc đáo.</p>
            </div>
            <div class="value-item">
                <div class="value-icon">
                    <i class="fa fa-award"></i>
                </div>
                <h3 class="value-title">Chất Lượng Vượt Trội</h3>
                <p class="value-desc">Cam kết cung cấp sản phẩm đạt chuẩn quốc tế, được kiểm định nghiêm ngặt và bảo hành dài hạn, đảm bảo sự hài lòng tuyệt đối.</p>
            </div>
            <div class="value-item">
                <div class="value-icon">
                    <i class="fa fa-leaf"></i>
                </div>
                <h3 class="value-title">Bền Vững Môi Trường</h3>
                <p class="value-desc">Ưu tiên các giải pháp chiếu sáng tiết kiệm năng lượng, thân thiện môi trường, góp phần xây dựng tương lai xanh và bền vững.</p>
            </div>
            <div class="value-item">
                <div class="value-icon">
                    <i class="fa fa-users"></i>
                </div>
                <h3 class="value-title">Tư Vấn Chuyên Nghiệp</h3>
                <p class="value-desc">Đội ngũ chuyên gia giàu kinh nghiệm, luôn sẵn sàng tư vấn và thiết kế giải pháp chiếu sáng phù hợp nhất cho từng dự án.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section (Dynamically from gemini-product-manager) -->
<?php
$products_args = array(
    'post_type'      => 'product',
    'posts_per_page' => 8,
    'meta_key'       => '_is_featured',
    'meta_value'     => '1',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish'
);

$products_query = new WP_Query( $products_args );

if ( $products_query->have_posts() ) : ?>
    <section class="products-section">
        <div class="container">
            <h2 class="section-title">Sản phẩm tiêu biểu</h2>
            <div class="products-grid">
                <?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
                    <div class="product-card">
                        <a href="<?php the_permalink(); ?>" class="product-link">
                            <div class="product-image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium' ); // Changed to medium for consistency ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            </div>
                            <h3 class="product-name"><?php the_title(); ?></h3>
                            <?php 
                            // Display price if available from gemini-product-manager
                            $price = get_post_meta( get_the_ID(), '_price', true );
                            if ( $price ) : ?>
                                <p class="product-price"><?php echo esc_html( number_format($price) ); ?>đ</p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="products-cta">
                <a href="<?php echo get_post_type_archive_link( 'product' ); ?>" class="btn-view-all">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata();
endif; ?>

<!-- Categories -->
<section class="categories">
    <a href="<?php echo home_url('/indoor/'); ?>" class="category">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/2203-lamps-arkoslight-1024x576.jpg" alt="Indoor">
        <div class="category-overlay">
            <h3 class="category-title">INDOOR</h3>
            <span class="category-arrow">→</span>
        </div>
    </a>
    <a href="<?php echo home_url('/outdoor/'); ?>" class="category">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/2203-surface-arkoslight-1024x576.jpg" alt="Outdoor">
        <div class="category-overlay">
            <h3 class="category-title">OUTDOOR</h3>
            <span class="category-arrow">→</span>
        </div>
    </a>
</section>

<!-- Projects Grid Section -->
<?php
$projects_args = array(
    'post_type'      => 'blog_post',
    'posts_per_page' => 4,
    'tax_query'      => array(
        array(
            'taxonomy' => 'blog_category',
            'field'    => 'slug',
            'terms'    => 'cong-trinh',
        ),
    ),
    'meta_key'       => '_is_featured_project',
    'meta_value'     => '1',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish'
);
$projects_query = new WP_Query( $projects_args );
?>
<section class="projects-grid-section">
    <div class="container">
        <h2 class="section-title text-center">Công trình tiêu biểu</h2>
        
        <div class="grid-row-4">
            <?php if ( $projects_query->have_posts() ) : 
                while ( $projects_query->have_posts() ) : $projects_query->the_post(); 
                $thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
            ?>
                <div class="grid-card">
                    <div class="grid-card-img">
                         <img src="<?php echo $thumb ? $thumb : get_template_directory_uri().'/assets/images/placeholder-project.jpg'; ?>" alt="<?php the_title(); ?>">
                    </div>
                    <div class="grid-card-content">
                        <h3 class="grid-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="grid-card-desc"><?php echo wp_trim_words( get_the_excerpt(), 12 ); ?></p>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); else: 
                // Placeholders if no projects found
                for($i=1; $i<=4; $i++): ?>
                <div class="grid-card">
                    <div class="grid-card-img">
                         <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" style="background:#eee;" alt="Project <?php echo $i; ?>">
                    </div>
                    <div class="grid-card-content">
                        <h3 class="grid-card-title">Công trình mẫu <?php echo $i; ?></h3>
                        <p class="grid-card-desc">Mô tả ngắn về công trình tiêu biểu này.</p>
                    </div>
                </div>
            <?php endfor; endif; ?>
        </div>
    </div>
</section>

<!-- News Section -->
<?php
$news_args = array(
    'post_type'      => 'blog_post',
    'posts_per_page' => 4,
    'tax_query'      => array(
        array(
            'taxonomy' => 'blog_category',
            'field'    => 'slug',
            'terms'    => 'tin-tuc', // Slug for News category
        ),
    ),
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish'
);
$news_query = new WP_Query( $news_args );
?>
<section class="news-grid-section">
    <div class="container">
        <h2 class="section-title text-center">Tin tức</h2>
        
        <div class="grid-row-4">
            <?php if ( $news_query->have_posts() ) : 
                while ( $news_query->have_posts() ) : $news_query->the_post(); 
                $thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
            ?>
                <div class="grid-card">
                    <div class="grid-card-img">
                         <img src="<?php echo $thumb ? $thumb : get_template_directory_uri().'/assets/images/placeholder.jpg'; ?>" alt="<?php the_title(); ?>">
                    </div>
                    <div class="grid-card-content">
                        <h3 class="grid-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="grid-card-desc"><?php echo wp_trim_words( get_the_excerpt(), 12 ); ?></p>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); else: 
                 // Placeholders if no news found
                for($i=1; $i<=4; $i++): ?>
                <div class="grid-card">
                    <div class="grid-card-img">
                         <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" style="background:#eee;" alt="News <?php echo $i; ?>">
                    </div>
                    <div class="grid-card-content">
                        <h3 class="grid-card-title">Bài viết tin tức <?php echo $i; ?></h3>
                        <p class="grid-card-desc">Tóm tắt nội dung tin tức mới nhất về công nghệ.</p>
                    </div>
                </div>
            <?php endfor; endif; ?>
        </div>
    </div>
</section>

<!-- Guarantee Section Removed -->

<!-- Consulting Section Removed -->

<style>
/* Grid Styles for Projects & News */
.projects-grid-section, .news-grid-section {
    padding: 60px 0;
    background: #fff;
}
.grid-row-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 30px;
}
.grid-card {
    transition: transform 0.3s;
}
.grid-card:hover {
    transform: translateY(-5px);
}
.grid-card-img {
    height: 180px;
    overflow: hidden;
    border-radius: 4px;
    margin-bottom: 15px;
}
.grid-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.5s;
}
.grid-card:hover .grid-card-img img {
    transform: scale(1.1);
}
.grid-card-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    line-height: 1.4;
}
.grid-card-title a {
    color: #333;
    text-decoration: none;
}
.grid-card-desc {
    font-size: 13px;
    color: #666;
    line-height: 1.5;
}

/* Consulting Form Styles */
.consulting-section {
    padding: 60px 0 100px;
    background: #fff;
    text-align: center;
}
.consulting-title {
    margin-bottom: 30px;
    font-size: 24px;
    font-weight: 600;
}
.consulting-form {
    max-width: 500px;
    margin: 0 auto;
}
.form-group {
    display: flex;
    gap: 15px;
}
.form-input {
    flex: 1;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 15px;
    outline: none;
}
.form-input:focus {
    border-color: #007bff;
}
.btn-submit {
    background: #007bff; /* Blue button */
    color: #fff;
    border: none;
    padding: 10px 30px;
    border-radius: 4px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}
.btn-submit:hover {
    background: #0056b3;
}

/* Guarantee Strip Styles */
.guarantee-section {
    padding: 40px 0;
    background: #f9f9f9; /* Light grey background to separate */
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
}
.guarantee-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}
.guarantee-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}
.guarantee-icon-wrapper {
    flex-shrink: 0;
    width: 50px;
    height: 50px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.guarantee-icon-wrapper i {
    font-size: 20px;
    color: #555;
}
.guarantee-content {
    flex: 1;
}
.guarantee-title {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 5px;
    color: #333;
}
.guarantee-desc {
    font-size: 13px;
    color: #777;
    line-height: 1.4;
    margin: 0;
}

@media (max-width: 992px) {
    .grid-row-4 {
        grid-template-columns: repeat(2, 1fr);
    }
    .guarantee-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}
@media (max-width: 576px) {
    .grid-row-4 {
        grid-template-columns: 1fr;
    }
    .guarantee-grid {
        grid-template-columns: 1fr;
    }
    .form-group {
        flex-direction: column;
    }
    .btn-submit {
        width: 100%;
    }
}
</style>

<!-- Styles specific to this page -->
<style>
/* Aura Dynamic Design Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Quicksand', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
    overflow-x: hidden;
    background: #fff;
}

/* Hero Slider Section */
.hero-slider-section {
    position: relative;
    height: 100vh;
    overflow: hidden;
}

.slide-title {
    color: #ffffff !important;
    text-transform: uppercase;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.hero-slider .item {
    position: relative;
    height: 100vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.slide-link {
    display: block;
    width: 100%;
    height: 100%;
}

.slide-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
}

.slide-content {
    text-align: center;
    color: #fff;
    max-width: 1200px;
    padding: 0 40px;
}

.slide-title {
    font-size: 60px;
    font-weight: 300;
    letter-spacing: 8px;
    margin-bottom: 20px;
    text-transform: uppercase;
    animation: fadeInUp 1s ease-out;
}


/* Content Sections */
.content-section {
    padding: 100px 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-subtitle {
    font-size: 18px;
    color: #000000;
    letter-spacing: 2px;
    margin-bottom: 10px;
    font-weight: 300;
}

.section-title {
    font-size: 36px;
    color: #000000 !important;
    font-weight: 400;
    letter-spacing: 3px;
    margin-bottom: 30px;
    text-align: center;
}

.section-divider {
    width: 100px;
    height: 1px;
    background: #000;
    margin: 0 auto 20px;
}

.section-desc {
    font-size: 16px;
    line-height: 1.8;
    color: #666;
    max-width: 800px;
    margin: 0 auto;
}

/* Company Highlights */
.company-highlights {
    display: grid !important;
    grid-template-columns: repeat(4, 1fr) !important;
    gap: 40px !important;
    margin: 80px 0 60px;
    padding: 60px 0;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
    width: 100% !important;
    max-width: 1200px !important;
    margin-left: auto !important;
    margin-right: auto !important;
}

/* Force 4 columns even on smaller screens for desktop view */
@media (min-width: 992px) {
    .company-highlights {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 40px !important;
    }
}

/* Override any flexbox or other display properties */
.company-highlights,
.company-highlights * {
    box-sizing: border-box !important;
}

.company-highlights .highlight-item {
    width: auto !important;
    flex: none !important;
    float: none !important;
    display: block !important;
}

/* Ultra high specificity override */
body .company-highlights,
html body .company-highlights,
div.company-highlights {
    display: grid !important;
    grid-template-columns: repeat(4, 1fr) !important;
    grid-template-rows: 1fr !important;
    gap: 40px !important;
}

/* Ensure all 4 items are in one row */
body .company-highlights .highlight-item:nth-child(1),
body .company-highlights .highlight-item:nth-child(2),
body .company-highlights .highlight-item:nth-child(3),
body .company-highlights .highlight-item:nth-child(4) {
    grid-row: 1 !important;
}

/* Debug: Force exact positioning for each item */
body .company-highlights .highlight-item:nth-child(1) { grid-column: 1 !important; }
body .company-highlights .highlight-item:nth-child(2) { grid-column: 2 !important; }
body .company-highlights .highlight-item:nth-child(3) { grid-column: 3 !important; }
body .company-highlights .highlight-item:nth-child(4) { grid-column: 4 !important; }

/* Force minimum width to prevent wrapping */
@media (min-width: 768px) {
    body .company-highlights {
        min-width: 800px !important;
        grid-template-columns: repeat(4, minmax(150px, 1fr)) !important;
    }
}

.highlight-item {
    text-align: center;
}

.highlight-number {
    font-size: 48px;
    font-weight: 600;
    color: #000;
    margin-bottom: 15px;
    line-height: 1;
}

.highlight-label {
    font-size: 16px;
    font-weight: 500;
    color: #3e3e3e;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.highlight-desc {
    font-size: 14px;
    color: #999;
    line-height: 1.6;
}

/* Core Values */
.core-values {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
    margin: 60px 0;
}

.value-item {
    text-align: center;
    padding: 30px 20px;
    transition: transform 0.3s;
}

.value-item:hover {
    transform: translateY(-10px);
}

.value-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #000;
    border-radius: 50%;
    transition: all 0.3s;
}

.value-item:hover .value-icon {
    background: #000;
    color: #fff;
}

.value-icon i {
    font-size: 32px;
}

.value-title {
    font-size: 18px;
    font-weight: 500;
    color: #3e3e3e;
    margin-bottom: 15px;
    letter-spacing: 0.5px;
}

.value-desc {
    font-size: 14px;
    line-height: 1.8;
    color: #666;
}

/* Why Choose Us */
.why-choose-section {
    margin-top: 80px;
    padding: 60px;
    background: #f9f9f9;
    border-radius: 8px;
}

.why-title {
    font-size: 28px;
    font-weight: 500;
    color: #000 !important;
    text-align: center;
    margin-bottom: 40px;
    letter-spacing: 1px;
}

.why-content {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 60px;
}

.why-list {
    list-style: none;
    padding: 0;
}

.why-list li {
    font-size: 15px;
    line-height: 2;
    color: #555;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    white-space: nowrap;
}

.why-list li i {
    color: #4CAF50;
    font-size: 18px;
    margin-top: 3px;
    flex-shrink: 0;
}

.why-list li strong {
    color: #3e3e3e;
}

/* Products Section */
.products-section {
    padding: 100px 0;
    background: #fafafa;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
    margin-bottom: 50px;
}

.product-card {
    text-align: center;
}

.product-link {
    text-decoration: none;
    color: inherit;
}

.product-image {
    background: #fff;
    height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-image img {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
}

.product-name {
    font-size: 18px;
    font-weight: 400;
    margin-bottom: 5px;
    color: #2a2a2a;
}

.product-code {
    font-size: 13px;
    color: #999;
    letter-spacing: 0.5px;
}

/* Categories */
.categories {
    display: flex;
    height: 600px;
}

.category {
    flex: 1;
    position: relative;
    overflow: hidden;
    text-decoration: none;
}

.category img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #fff;
    transition: background 0.3s;
}

.category:hover .category-overlay {
    background: rgba(0,0,0,0.6);
}

.category-title {
    font-size: 50px;
    font-weight: 300;
    letter-spacing: 8px;
    margin-bottom: 20px;
}

.category-arrow {
    font-size: 30px;
    transition: transform 0.3s;
}

.category:hover .category-arrow {
    transform: translateX(10px);
}

/* Featured Projects Section */
.featured-projects-section {
    padding: 100px 0;
    background: #fff;
}

.projects-slider-wrapper {
    position: relative;
    margin: 60px 0;
}

.projects-slider {
    position: relative;
}

.project-slide {
    position: relative;
}

.project-slide-container {
    position: relative;
    display: flex;
    align-items: center;
    min-height: 700px;
}

.project-slide-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.project-slide-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.8) 50%, rgba(255,255,255,0) 100%);
}

.project-slide-content {
    position: relative;
    z-index: 2;
    max-width: 600px;
    padding: 80px;
}

.project-meta {
    margin-bottom: 20px;
}

.project-category {
    font-size: 24px;
    color: #818181;
    font-weight: 300;
    letter-spacing: 1px;
    font-family: 'Quicksand', sans-serif;
}

.project-slide-title {
    font-size: 48px;
    color: #3e3e3e;
    margin-bottom: 20px;
    font-weight: 400;
    line-height: 1.2;
    font-family: 'Quicksand', sans-serif;
}

.project-slide-desc {
    font-size: 16px;
    color: #666;
    line-height: 1.6;
    margin-bottom: 40px;
}

.project-slide-info {
    margin: 50px 0;
}

.info-row {
    display: flex;
    gap: 60px;
}

.info-item {
    flex: 1;
}

.info-divider-top,
.info-divider-bottom {
    width: 35%;
    height: 1px;
    background: #000;
    margin: 15px 0;
}

.info-content {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.info-label {
    font-size: 12px;
    color: #999;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.info-value {
    font-size: 18px;
    color: #3e3e3e;
    font-weight: 400;
}

.project-slide-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #000;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    transition: all 0.3s;
    margin-top: 30px;
}

.project-slide-link:hover {
    transform: translateX(10px);
}

.project-slide-link i {
    font-size: 14px;
}

/* Projects Navigation */
.projects-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 40px;
    right: 40px;
    display: flex;
    justify-content: space-between;
    z-index: 10;
    pointer-events: none;
}

.projects-nav button {
    pointer-events: all;
    width: 50px;
    height: 50px;
    border: 2px solid #000;
    background: transparent;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 16px;
}

.projects-nav button:hover {
    background: #000;
    color: #fff;
}

/* Owl Carousel Custom Styles for Projects */
.projects-slider .owl-nav {
    display: none;
}

.projects-slider .owl-dots {
    text-align: center;
    margin-top: 40px;
}

.projects-slider .owl-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    background: #ddd;
    border-radius: 50%;
    margin: 0 5px;
    transition: all 0.3s;
}

.projects-slider .owl-dot.active {
    background: #000;
    width: 30px;
    border-radius: 5px;
}

/* CTA Buttons */
.products-cta,
.projects-cta {
    text-align: center;
    margin-top: 50px;
}

.btn-view-all {
    display: inline-block;
    padding: 15px 40px;
    background: #000;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.3s;
}

.btn-view-all:hover {
    background: #333;
    transform: translateY(-2px);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Project Slide Animations */
.project-slide-content {
    opacity: 0;
    transform: translateX(-30px);
    transition: all 0.8s ease-out;
}

.project-slide-content.animated {
    opacity: 1;
    transform: translateX(0);
}

.project-slide-content.animated .project-category {
    animation: fadeInUp 0.6s ease-out;
}

.project-slide-content.animated .project-slide-title {
    animation: fadeInUp 0.6s ease-out 0.1s;
    animation-fill-mode: both;
}

.project-slide-content.animated .project-slide-desc {
    animation: fadeInUp 0.6s ease-out 0.2s;
    animation-fill-mode: both;
}

.project-slide-content.animated .project-slide-info {
    animation: fadeInUp 0.6s ease-out 0.3s;
    animation-fill-mode: both;
}

.project-slide-content.animated .project-slide-link {
    animation: fadeInUp 0.6s ease-out 0.4s;
    animation-fill-mode: both;
}

/* Responsive */
@media (max-width: 991px) {
    .products-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .categories {
        flex-direction: column;
        height: auto;
    }

    .category {
        height: 400px;
    }

    .project-slide-content {
        padding: 60px;
    }

    .project-slide-title {
        font-size: 36px;
    }

    .projects-nav {
        left: 20px;
        right: 20px;
    }

    .company-highlights {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 30px !important;
        margin: 60px 0 40px;
        padding: 40px 0;
    }

    .core-values {
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }

    .why-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .why-choose-section {
        padding: 40px 30px;
    }
}

/* Tablet breakpoint for better 4-column layout */
@media (max-width: 900px) and (min-width: 769px) {
    .company-highlights {
        gap: 15px;
        padding: 40px 10px;
    }
    
    .core-values {
        gap: 15px;
    }
    
    .highlight-item {
        padding: 0 5px;
    }
}

@media (max-width: 768px) {
    .slide-title {
        font-size: 40px;
        letter-spacing: 4px;
    }
    
    .company-highlights {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin: 40px 0 30px;
        padding: 30px 0;
    }

    .core-values {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin: 40px 0;
    }

    .section-title {
        font-size: 28px;
    }

    .products-grid {
        grid-template-columns: 1fr;
    }

    .project-slide-container {
        min-height: 500px;
    }

    .project-slide-content {
        padding: 40px;
        max-width: 100%;
    }

    .project-slide-title {
        font-size: 28px;
    }

    .project-slide-overlay {
        background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0.9) 50%, rgba(255,255,255,0.95) 100%);
    }

    .info-row {
        flex-direction: column;
        gap: 30px;
    }

    .projects-nav {
        display: none;
    }

    .category-title {
        font-size: 40px;
    }

    .highlight-number {
        font-size: 42px;
    }

    .why-choose-section {
        padding: 30px 20px;
        margin-top: 60px;
    }

    .why-title {
        font-size: 24px;
    }

    .why-list li {
        font-size: 14px;
    }
}

/* Very small mobile devices */
@media (max-width: 480px) {
    .company-highlights {
        grid-template-columns: 1fr;
        gap: 30px;
        margin: 30px 0 20px;
        padding: 20px 0;
    }

    .core-values {
        grid-template-columns: 1fr;
        gap: 25px;
        margin: 30px 0;
    }
    
    .highlight-item {
        padding: 20px 10px;
    }
    
    .highlight-number {
        font-size: 36px;
    }
    
    .highlight-label {
        font-size: 14px;
    }
    
    .highlight-desc {
        font-size: 13px;
    }
}
</style>

<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<!-- jQuery and Owl Carousel JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
jQuery(document).ready(function($) {
    // Initialize Hero Slider
    $('.hero-slider').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: true,
        dots: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1000
    });
    
    // Initialize Projects Slider
    var projectsSlider = $('.projects-slider').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: false,
        dots: true,
        smartSpeed: 500,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        onInitialized: function() {
            // Add animation to first slide
            $('.projects-slider .owl-item.active .project-slide-content').addClass('animated');
        },
        onChanged: function() {
            // Remove animation from all slides
            $('.projects-slider .project-slide-content').removeClass('animated');
            
            // Add animation to active slide
            setTimeout(function() {
                $('.projects-slider .owl-item.active .project-slide-content').addClass('animated');
            }, 100);
        }
    });
    
    // Custom Navigation for Projects
    $('.projects-prev').click(function() {
        projectsSlider.trigger('prev.owl.carousel');
    });
    
    $('.projects-next').click(function() {
        projectsSlider.trigger('next.owl.carousel');
    });
});
</script>

<style>
/* Promo Grid Styles */
.promo-grid-section {
    padding: 60px 0;
    background: #fff;
    border-bottom: 1px solid #eaeaea;
}
.promo-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2 Columns as requested */
    gap: 20px;
    margin-top: 40px;
}
.promo-item {
    background: #f8f9fa;
    border-radius: 8px;
    overflow: hidden;
    min-height: 350px;
    position: relative;
    transition: transform 0.3s, box-shadow 0.3s;
}
.promo-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.promo-content {
    padding: 40px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}
.promo-highlight {
    background: #fff;
    border: 2px solid #e31e24; /* Red border for promo */
}
.promo-title {
    font-size: 24px;
    margin-bottom: 15px;
    line-height: 1.4;
    color: #222;
}
.promo-desc {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}
.promo-badges {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    justify-content: center;
}
.promo-badge {
    background: #e31e24;
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}
.promo-terms {
    font-size: 13px;
    color: #999;
}
.promo-image-placeholder {
    width: 100%;
    height: 100%;
    background-color: #ddd;
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: flex-end;
}
.promo-image-placeholder img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    transition: transform 0.5s;
}
.promo-item:hover .promo-image-placeholder img {
    transform: scale(1.05);
}
.promo-overlay {
    position: relative;
    z-index: 2;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    width: 100%;
    padding: 30px;
    color: #fff;
}
.promo-overlay h3 {
    font-size: 22px;
    margin-bottom: 5px;
    font-weight: 600;
    color: #fff !important;
}
.promo-overlay p {
    font-size: 16px;
    color: rgba(255,255,255,0.9);
}

@media (max-width: 768px) {
    .promo-grid {
        grid-template-columns: 1fr; /* Stack on mobile */
    }
}
</style>

<style>
/* Featured Products Tabs Styles */
.featured-products-tabs-section {
    padding: 60px 0 20px;
    background: #fff;
    text-align: center;
}
.product-category-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.tab-btn {
    padding: 8px 20px;
    border: 1px solid #ddd;
    background: #fff;
    border-radius: 20px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 500;
}
.tab-btn:hover, .tab-btn.active {
    background: #000;
    color: #fff;
    border-color: #000;
}
.products-tab-content {
    margin-top: 40px;
}
.product-grid-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}
.product-card-item {
    text-align: center;
    padding: 15px;
    transition: transform 0.3s;
}
.product-card-item:hover {
    transform: translateY(-5px);
}
.product-card-img {
    position: relative;
    margin-bottom: 15px;
    height: 200px; /* Fixed height for consistency */
    display: flex;
    align-items: center;
    justify-content: center;
}
.product-card-img img {
    max-height: 100%;
    max-width: 100%;
}
.discount-badge {
    position: absolute;
    top: 0;
    right: 0;
    background: #e31e24; /* Red discount */
    color: #fff;
    padding: 2px 8px;
    font-size: 12px;
    border-radius: 4px;
}
.product-card-title {
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 10px;
    min-height: 40px; /* Ensure alignment */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.product-card-prices {
    margin-bottom: 15px;
}
.old-price {
    text-decoration: line-through;
    color: #999;
    font-size: 13px;
    margin-right: 10px;
}
.new-price {
    color: #0056b3; /* Blue price */
    font-weight: 700;
    font-size: 16px;
}
.product-card-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}
.btn-detail, .btn-buy {
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 13px;
    text-decoration: none;
    font-weight: 500;
}
.btn-detail {
    border: 1px solid #333;
    color: #333;
}
.btn-buy {
    background: #0056b3;
    color: #fff;
    border: 1px solid #0056b3;
}

/* Ecosystem Support Styles */
.ecosystem-support-section {
    padding: 40px 0 80px;
    text-align: center;
    background: #fff;
}
.ecosystem-logos {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-top: 30px;
}
.eco-logo {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 10px 20px;
    border: 1px solid #eee;
    border-radius: 8px;
    background: #fff;
}
.eco-logo img {
    height: 25px;
    width: auto;
}
.eco-logo strong {
    font-weight: 700;
}

@media (max-width: 992px) {
    .product-grid-row {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 576px) {
    .product-grid-row {
        grid-template-columns: 1fr;
    }
}
</style>
<?php get_footer(); ?>