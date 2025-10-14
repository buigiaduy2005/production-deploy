<?php
/**
 * Template Name: Virical Homepage
 * Description: Trang chủ với hiệu ứng ánh sáng thông minh
 */

get_header(); ?>

<div id="virical-homepage" class="virical-light-experience">
    
    <!-- Hero Section với hiệu ứng ánh sáng -->
    <section class="virical-hero virical-section" style="position: relative; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #000; overflow: hidden;">
        <div class="light-rays" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.5;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 0; height: 0; box-shadow: 0 0 200px 100px rgba(255,255,255,0.3);"></div>
        </div>
        
        <div class="hero-content" style="text-align: center; z-index: 10; color: white;">
            <h1 class="virical-glow-text" style="font-size: 4em; margin-bottom: 20px; font-weight: 300;">VIRICAL</h1>
            <p style="font-size: 1.5em; margin-bottom: 30px; opacity: 0.8;">Ánh sáng thông minh cho cuộc sống hiện đại</p>
            <button class="light-demo-btn" style="padding: 15px 40px; font-size: 1.1em; border: 2px solid white; background: transparent; color: white; cursor: pointer; transition: all 0.3s;">
                Trải nghiệm ngay
            </button>
        </div>
        
        <!-- Animated Light Bulb -->
        <div class="floating-bulb" style="position: absolute; top: 20%; right: 10%; width: 100px; height: 100px;">
            <svg viewBox="0 0 100 100" style="width: 100%; height: 100%;">
                <circle cx="50" cy="40" r="30" fill="none" stroke="white" stroke-width="2" opacity="0.5"/>
                <path d="M35 55 Q50 70 65 55" fill="none" stroke="white" stroke-width="2" opacity="0.5"/>
                <rect x="40" y="70" width="20" height="10" fill="white" opacity="0.5"/>
            </svg>
        </div>
    </section>

    <!-- Section Điều khiển ánh sáng -->
    <section class="light-control-section virical-section" style="padding: 100px 0; background: linear-gradient(180deg, #000 0%, #1a1a1a 100%);">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <h2 class="virical-glow-text" style="text-align: center; font-size: 3em; color: white; margin-bottom: 50px;">
                Điều khiển mọi ánh sáng
            </h2>
            
            <div class="light-controls" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
                <!-- Brightness Control -->
                <div class="control-card" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 10px; text-align: center;">
                    <div class="icon" style="font-size: 3em; margin-bottom: 20px;">☀️</div>
                    <h3 style="color: white; margin-bottom: 15px;">Độ sáng</h3>
                    <input type="range" min="0" max="100" value="75" style="width: 100%;">
                    <p style="color: rgba(255,255,255,0.7); margin-top: 10px;">Điều chỉnh từ 0-100%</p>
                </div>
                
                <!-- Color Temperature -->
                <div class="control-card" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 10px; text-align: center;">
                    <div class="icon" style="font-size: 3em; margin-bottom: 20px;">🌡️</div>
                    <h3 style="color: white; margin-bottom: 15px;">Nhiệt độ màu</h3>
                    <div style="display: flex; justify-content: space-around; margin-top: 20px;">
                        <button style="padding: 10px 20px; background: #ff9800; border: none; color: white; border-radius: 5px;">Ấm</button>
                        <button style="padding: 10px 20px; background: #2196f3; border: none; color: white; border-radius: 5px;">Lạnh</button>
                    </div>
                </div>
                
                <!-- RGB Color -->
                <div class="control-card" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 10px; text-align: center;">
                    <div class="icon" style="font-size: 3em; margin-bottom: 20px;">🎨</div>
                    <h3 style="color: white; margin-bottom: 15px;">16 triệu màu</h3>
                    <div class="color-wheel" style="width: 100px; height: 100px; margin: 20px auto; border-radius: 50%; background: conic-gradient(red, yellow, lime, cyan, blue, magenta, red);"></div>
                </div>
                
                <!-- Scenes -->
                <div class="control-card" style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 10px; text-align: center;">
                    <div class="icon" style="font-size: 3em; margin-bottom: 20px;">🎬</div>
                    <h3 style="color: white; margin-bottom: 15px;">Cảnh sẵn có</h3>
                    <select style="width: 100%; padding: 10px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
                        <option>Đọc sách</option>
                        <option>Xem phim</option>
                        <option>Party</option>
                        <option>Thư giãn</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Sản phẩm nổi bật -->
    <section class="featured-products virical-section" style="padding: 100px 0; background: linear-gradient(180deg, #1a1a1a 0%, #2d2d2d 100%);">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <h2 class="virical-glow-text" style="text-align: center; font-size: 3em; color: white; margin-bottom: 50px;">
                Sản phẩm nổi bật
            </h2>
            
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'meta_key' => '_featured',
                'meta_value' => 'yes'
            );
            $products = new WP_Query($args);
            
            if ($products->have_posts()) : ?>
                <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                    <?php while ($products->have_posts()) : $products->the_post(); 
                        global $product; ?>
                        <div class="product-card" style="background: rgba(255,255,255,0.05); border-radius: 15px; overflow: hidden; transition: all 0.3s;">
                            <div class="product-light-effect" style="height: 250px; background: radial-gradient(ellipse at center, rgba(255,255,255,0.1) 0%, transparent 70%); display: flex; align-items: center; justify-content: center;">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('style' => 'max-width: 100%; height: auto;')); ?>
                                <?php else : ?>
                                    <div style="font-size: 5em;">💡</div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info" style="padding: 20px; color: white;">
                                <h3 style="margin-bottom: 10px;"><?php the_title(); ?></h3>
                                <p style="color: rgba(255,255,255,0.7); margin-bottom: 15px;"><?php echo $product->get_short_description(); ?></p>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 1.2em; color: #ffc107;"><?php echo $product->get_price_html(); ?></span>
                                    <a href="<?php the_permalink(); ?>" style="padding: 8px 20px; background: #2196f3; color: white; text-decoration: none; border-radius: 5px;">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif;
            wp_reset_postdata(); ?>
        </div>
    </section>

    <!-- Section Công nghệ -->
    <section class="technology-section virical-section" style="padding: 100px 0; background: linear-gradient(180deg, #2d2d2d 0%, #000 100%);">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <h2 class="virical-glow-text" style="text-align: center; font-size: 3em; color: white; margin-bottom: 50px;">
                Công nghệ tiên tiến
            </h2>
            
            <div class="tech-features" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
                <div class="tech-card" style="text-align: center; color: white;">
                    <div class="tech-icon" style="font-size: 4em; margin-bottom: 20px; filter: drop-shadow(0 0 20px rgba(255,255,255,0.5));">📱</div>
                    <h3 style="margin-bottom: 15px;">App Control</h3>
                    <p style="color: rgba(255,255,255,0.7);">Điều khiển mọi lúc mọi nơi qua smartphone</p>
                </div>
                
                <div class="tech-card" style="text-align: center; color: white;">
                    <div class="tech-icon" style="font-size: 4em; margin-bottom: 20px; filter: drop-shadow(0 0 20px rgba(255,255,255,0.5));">🎤</div>
                    <h3 style="margin-bottom: 15px;">Voice Control</h3>
                    <p style="color: rgba(255,255,255,0.7);">Tương thích Google Home & Alexa</p>
                </div>
                
                <div class="tech-card" style="text-align: center; color: white;">
                    <div class="tech-icon" style="font-size: 4em; margin-bottom: 20px; filter: drop-shadow(0 0 20px rgba(255,255,255,0.5));">⏰</div>
                    <h3 style="margin-bottom: 15px;">Schedule</h3>
                    <p style="color: rgba(255,255,255,0.7);">Lập lịch tự động bật/tắt thông minh</p>
                </div>
                
                <div class="tech-card" style="text-align: center; color: white;">
                    <div class="tech-icon" style="font-size: 4em; margin-bottom: 20px; filter: drop-shadow(0 0 20px rgba(255,255,255,0.5));">🎵</div>
                    <h3 style="margin-bottom: 15px;">Music Sync</h3>
                    <p style="color: rgba(255,255,255,0.7);">Đồng bộ ánh sáng với nhạc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" style="padding: 80px 0; background: #2196f3; text-align: center;">
        <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
            <h2 style="font-size: 2.5em; color: white; margin-bottom: 20px;">Sẵn sàng nâng cấp ngôi nhà của bạn?</h2>
            <p style="font-size: 1.2em; color: rgba(255,255,255,0.9); margin-bottom: 30px;">Trải nghiệm ánh sáng thông minh Virical ngay hôm nay</p>
            <a href="/san-pham" style="display: inline-block; padding: 15px 40px; background: white; color: #2196f3; text-decoration: none; font-size: 1.1em; font-weight: bold; border-radius: 5px;">Khám phá sản phẩm</a>
        </div>
    </section>
</div>

<!-- Load hiệu ứng ánh sáng -->
<script>
<?php echo file_get_contents(get_template_directory() . '/../../../virical-light-effects.js'); ?>
</script>

<style>
/* Additional styling */
.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 40px rgba(255,255,255,0.1);
}

.light-demo-btn:hover {
    background: white;
    color: #000;
}

.control-card {
    transition: all 0.3s ease;
}

.control-card:hover {
    transform: translateY(-5px);
    background: rgba(255,255,255,0.1) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .virical-hero h1 {
        font-size: 3em !important;
    }
    
    h2 {
        font-size: 2em !important;
    }
}
</style>

<?php get_footer(); ?>