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

<!-- About Section - Enhanced -->
<section class="content-section about-section">
    <div class="container">
        <div class="section-header">
            <h3 class="section-subtitle"><?php echo esc_html( get_theme_mod( 'aura_about_subtitle', 'VỀ CHÚNG TÔI' ) ); ?></h3>
            <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'aura_about_title', 'VIRICAL - FEELING LIGHT' ) ); ?></h2>
            <div class="section-divider"></div>
            <div class="section-desc">
                <?php echo wp_kses_post( get_theme_mod( 'aura_about_content', 'VIRICAL là thương hiệu đèn chiếu sáng cao cấp, mang đến những giải pháp ánh sáng hoàn hảo cho mọi không gian. Với công nghệ tiên tiến và thiết kế sang trọng, chúng tôi tạo nên những trải nghiệm ánh sáng độc đáo và ấn tượng.' ) ); ?>
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

        <!-- Why Choose Us -->
        <div class="why-choose-section">
            <h3 class="why-title">Tại Sao Chọn VIRICAL?</h3>
            <div class="why-content">
                <div class="why-col">
                    <ul class="why-list">
                        <li><i class="fa fa-check-circle"></i> <strong>Đại lý chính thức</strong> của các thương hiệu chiếu sáng hàng đầu thế giới</li>
                        <li><i class="fa fa-check-circle"></i> <strong>Showroom rộng 500m²</strong> trưng bày hàng ngàn mẫu đèn cao cấp</li>
                        <li><i class="fa fa-check-circle"></i> <strong>Tư vấn thiết kế miễn phí</strong> bởi đội ngũ chuyên gia lighting designer</li>
                    </ul>
                </div>
                <div class="why-col">
                    <ul class="why-list">
                        <li><i class="fa fa-check-circle"></i> <strong>Bảo hành dài hạn</strong> lên đến 5 năm cho tất cả sản phẩm</li>
                        <li><i class="fa fa-check-circle"></i> <strong>Dịch vụ sau bán hàng</strong> chuyên nghiệp, nhanh chóng 24/7</li>
                        <li><i class="fa fa-check-circle"></i> <strong>Giá cạnh tranh nhất</strong> với chính sách ưu đãi hấp dẫn cho dự án lớn</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<?php
$products_args = array(
    'post_type'      => 'aura_product',
    'posts_per_page' => 8,
    'meta_key'       => '_featured',
    'orderby'        => array(
        'meta_value' => 'DESC',
        'date'       => 'DESC'
    ),
    'post_status'    => 'publish'
);

$products_query = new WP_Query( $products_args );

if ( $products_query->have_posts() ) : ?>
    <section class="products-section">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'aura_products_title', 'SẢN PHẨM NỔI BẬT' ) ); ?></h2>
            <div class="products-grid">
                <?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
                    <div class="product-card">
                        <a href="<?php the_permalink(); ?>" class="product-link">
                            <div class="product-image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'aura-product-thumb' ); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            </div>
                            <h3 class="product-name"><?php the_title(); ?></h3>
                            <?php 
                            $product_code = get_post_meta( get_the_ID(), '_product_code', true );
                            if ( $product_code ) : ?>
                                <p class="product-code"><?php echo esc_html( $product_code ); ?></p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="products-cta">
                <a href="<?php echo get_post_type_archive_link( 'aura_product' ); ?>" class="btn-view-all">
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

<!-- Projects -->
<?php
$projects_args = array(
    'post_type'      => 'aura_project',
    'posts_per_page' => -1,
    'meta_key'       => '_featured',
    'orderby'        => array(
        'meta_value' => 'DESC',
        'date'       => 'DESC'
    ),
    'post_status'    => 'publish'
);

$projects_query = new WP_Query( $projects_args );

if ( $projects_query->have_posts() ) : ?>
    <section class="featured-projects-section">
        <div class="container">
            <div class="section-header">
                <h3 class="section-subtitle">PROJECTS</h3>
                <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'aura_projects_title', 'DỰ ÁN TIÊU BIỂU' ) ); ?></h2>
                <div class="section-divider"></div>
            </div>
            
            <div class="projects-slider-wrapper">
                <div class="projects-slider owl-carousel">
                    <?php while ( $projects_query->have_posts() ) : $projects_query->the_post(); 
                        $project_location = get_post_meta( get_the_ID(), '_project_location', true );
                        $project_year = get_post_meta( get_the_ID(), '_project_year', true );
                        $project_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                    ?>
                        <div class="project-slide">
                            <div class="project-slide-container">
                                <div class="project-slide-bg" style="background-image: url('<?php echo esc_url( $project_image ?: get_template_directory_uri() . '/assets/images/placeholder-project.jpg' ); ?>');">
                                    <div class="project-slide-overlay"></div>
                                </div>
                                
                                <div class="project-slide-content">
                                    <div class="project-meta">
                                        <span class="project-category">Dự án</span>
                                    </div>
                                    <h2 class="project-slide-title"><?php the_title(); ?></h2>
                                    
                                    <?php if ( has_excerpt() ) : ?>
                                        <div class="project-slide-desc">
                                            <?php echo get_the_excerpt(); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="project-slide-info">
                                        <div class="info-row">
                                            <div class="info-item">
                                                <div class="info-divider-top"></div>
                                                <div class="info-content">
                                                    <span class="info-label">CHỦ ĐẦU TƯ</span>
                                                    <span class="info-value"><?php echo esc_html( $project_location ?: 'N/A' ); ?></span>
                                                </div>
                                                <div class="info-divider-bottom"></div>
                                            </div>
                                            
                                            <div class="info-item">
                                                <div class="info-divider-top"></div>
                                                <div class="info-content">
                                                    <span class="info-label">NĂM</span>
                                                    <span class="info-value"><?php echo esc_html( $project_year ?: date('Y') ); ?></span>
                                                </div>
                                                <div class="info-divider-bottom"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="project-slide-link">
                                        <span>Xem chi tiết</span>
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- Custom Navigation -->
                <div class="projects-nav">
                    <button class="projects-prev"><i class="fa fa-chevron-left"></i></button>
                    <button class="projects-next"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
            
            <div class="projects-cta">
                <a href="<?php echo get_post_type_archive_link( 'aura_project' ); ?>" class="btn-view-all">
                    Xem tất cả dự án
                </a>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata();
endif; ?>

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
    color: #818181;
    letter-spacing: 2px;
    margin-bottom: 10px;
    font-weight: 300;
}

.section-title {
    font-size: 36px;
    color: #3e3e3e;
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
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 40px;
    margin: 80px 0 60px;
    padding: 60px 0;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
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
    color: #3e3e3e;
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
        grid-template-columns: repeat(2, 1fr);
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
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin: 60px 0 40px;
        padding: 40px 0;
    }

    .core-values {
        grid-template-columns: repeat(2, 1fr);
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

@media (max-width: 768px) {
    .slide-title {
        font-size: 40px;
        letter-spacing: 4px;
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

    .company-highlights {
        grid-template-columns: 1fr;
        gap: 40px;
        margin: 40px 0 30px;
        padding: 30px 0;
    }

    .highlight-number {
        font-size: 42px;
    }

    .core-values {
        grid-template-columns: 1fr;
        gap: 30px;
        margin: 40px 0;
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

<?php get_footer(); ?>