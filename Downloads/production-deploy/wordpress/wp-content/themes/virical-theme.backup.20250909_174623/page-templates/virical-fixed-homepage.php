<?php
/**
 * Template Name: Virical Fixed Homepage
 * Description: Homepage with fixed layout and proper structure
 */

// Remove default WordPress header/footer
remove_action('genesis_header', 'genesis_header_markup_open', 5);
remove_action('genesis_header', 'genesis_do_header');
remove_action('genesis_header', 'genesis_header_markup_close', 15);
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIRICAL - Ánh sáng thông minh</title>
    <?php wp_head(); ?>
    <style>
        /* Reset everything */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Hide all WordPress elements */
        body > *:not(.virical-wrapper) {
            display: none !important;
        }

        .virical-wrapper {
            display: block !important;
        }

        #wpadminbar {
            display: none !important;
        }

        html {
            margin-top: 0 !important;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            background: #0a0a0a !important;
            color: #fff !important;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            overflow-x: hidden !important;
            min-height: 100vh !important;
        }

        /* Main wrapper */
        .virical-wrapper {
            width: 100%;
            min-height: 100vh;
            position: relative;
            background: #0a0a0a;
        }

        /* Header */
        .virical-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1000;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 2rem;
            font-weight: 300;
            letter-spacing: 0.1em;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .main-nav {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .main-nav li {
            list-style: none;
        }

        .main-nav a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .main-nav a:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        /* Main content */
        .virical-main {
            padding-top: 70px;
            min-height: calc(100vh - 300px);
        }

        /* Hero Section */
        .hero-section {
            height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: radial-gradient(ellipse at center, rgba(102, 126, 234, 0.1) 0%, transparent 50%);
        }

        .hero-content {
            text-align: center;
            z-index: 10;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 300;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            opacity: 0.8;
            margin-bottom: 40px;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        /* Canvas for particles */
        #heroCanvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0.5;
        }

        /* Control Section */
        .control-section {
            padding: 100px 0;
            background: #111;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: 20px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            opacity: 0.7;
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .control-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(30px);
            position: relative;
            isolation: isolate;
        }

        .control-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .control-card.visible:hover {
            transform: translateY(-5px);
            border-color: rgba(102, 126, 234, 0.3);
            background: rgba(255, 255, 255, 0.08);
        }

        .control-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .control-title {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        /* Interactive controls */
        .brightness-slider {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            outline: none;
            -webkit-appearance: none;
            margin: 20px 0;
            cursor: pointer;
        }

        .brightness-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 24px;
            height: 24px;
            background: #667eea;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }

        .brightness-value {
            font-size: 1.5rem;
            font-weight: 500;
            color: #667eea;
        }

        .temp-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        .temp-btn {
            padding: 10px 30px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
        }

        .warm-btn {
            background: linear-gradient(135deg, #ff9a56, #ff6a00);
        }

        .cool-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .temp-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .color-wheel {
            width: 120px;
            height: 120px;
            margin: 20px auto;
            border-radius: 50%;
            background: conic-gradient(red, yellow, lime, cyan, blue, magenta, red);
            cursor: pointer;
            transition: transform 0.3s ease;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
        }

        .color-wheel:hover {
            transform: scale(1.1);
        }

        .scene-select {
            width: 100%;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .scene-select option {
            background: #1a1a1a;
            color: #fff;
        }

        /* Products Section */
        .products-section {
            padding: 100px 0;
            background: #0a0a0a;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(30px);
        }

        .product-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .product-image {
            height: 250px;
            background: radial-gradient(ellipse at center, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }

        .product-info {
            padding: 30px;
        }

        .product-name {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .product-desc {
            opacity: 0.7;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-size: 1.3rem;
            color: #667eea;
            font-weight: 500;
        }

        .product-btn {
            padding: 10px 25px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            color: #fff;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        /* Footer */
        .virical-footer {
            background: #000;
            padding: 50px 0 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 0;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #667eea;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column li {
            margin-bottom: 10px;
        }

        .footer-column a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            line-height: 1.8;
            transition: color 0.3s ease;
        }

        .footer-column a:hover {
            color: #667eea;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }

        /* Light overlay */
        .light-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 998;
            opacity: 0;
            background: radial-gradient(ellipse at center, transparent 0%, transparent 100%);
            transition: all 0.5s ease;
        }

        /* Light controller button */
        .light-controller {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            z-index: 999;
        }

        .light-controller:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
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

        /* Responsive */
        @media (max-width: 768px) {
            .main-nav {
                display: none;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .controls-grid,
            .products-grid,
            .footer-content {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Main wrapper -->
    <div class="virical-wrapper">
        <!-- Light Overlay -->
        <div class="light-overlay" id="lightOverlay"></div>

        <!-- Header -->
        <header class="virical-header">
            <div class="header-container">
                <div class="logo">VIRICAL</div>
                <nav>
                    <ul class="main-nav">
                        <li><a href="#home">Trang chủ</a></li>
                        <li><a href="#control">Điều khiển</a></li>
                        <li><a href="#products">Sản phẩm</a></li>
                        <li><a href="#tech">Công nghệ</a></li>
                        <li><a href="/ve-virical">Về Virical</a></li>
                        <li><a href="/lien-he">Liên hệ</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main content -->
        <main class="virical-main">
            <!-- Hero Section -->
            <section class="hero-section" id="home">
                <canvas id="heroCanvas"></canvas>
                <div class="hero-content">
                    <h1 class="hero-title">VIRICAL</h1>
                    <p class="hero-subtitle">Ánh sáng thông minh cho cuộc sống hiện đại</p>
                    <a href="#products" class="cta-button">Khám phá sản phẩm</a>
                </div>
            </section>

            <!-- Control Section -->
            <section class="control-section" id="control">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Điều khiển mọi ánh sáng</h2>
                        <p class="section-subtitle">Trải nghiệm công nghệ điều khiển ánh sáng thông minh</p>
                    </div>
                    
                    <div class="controls-grid">
                        <!-- Brightness Control -->
                        <div class="control-card">
                            <div class="control-icon">☀️</div>
                            <h3 class="control-title">Độ sáng</h3>
                            <input type="range" class="brightness-slider" id="brightnessSlider" min="0" max="100" value="75">
                            <p class="brightness-value" id="brightnessValue">75%</p>
                            <p style="opacity: 0.7; margin-top: 10px;">Điều chỉnh từ 0-100%</p>
                        </div>

                        <!-- Temperature Control -->
                        <div class="control-card">
                            <div class="control-icon">🌡️</div>
                            <h3 class="control-title">Nhiệt độ màu</h3>
                            <div class="temp-buttons">
                                <button class="temp-btn warm-btn" onclick="setWarmLight()">Ấm</button>
                                <button class="temp-btn cool-btn" onclick="setCoolLight()">Lạnh</button>
                            </div>
                            <p style="opacity: 0.7; margin-top: 20px;">2700K - 6500K</p>
                        </div>

                        <!-- Color Control -->
                        <div class="control-card">
                            <div class="control-icon">🎨</div>
                            <h3 class="control-title">16 triệu màu</h3>
                            <div class="color-wheel" id="colorWheel"></div>
                            <p style="opacity: 0.7;">Chạm để chọn màu</p>
                        </div>

                        <!-- Scene Control -->
                        <div class="control-card">
                            <div class="control-icon">🎬</div>
                            <h3 class="control-title">Cảnh sẵn có</h3>
                            <select class="scene-select" id="sceneSelect">
                                <option value="default">Mặc định</option>
                                <option value="reading">Đọc sách</option>
                                <option value="movie">Xem phim</option>
                                <option value="party">Party</option>
                                <option value="relax">Thư giãn</option>
                                <option value="sleep">Ngủ</option>
                            </select>
                            <p style="opacity: 0.7; margin-top: 20px;">Chế độ thông minh</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Products Section -->
            <section class="products-section" id="products">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Sản phẩm nổi bật</h2>
                        <p class="section-subtitle">Khám phá bộ sưu tập đèn thông minh Virical</p>
                    </div>
                    
                    <div class="products-grid">
                        <?php
                        $products = [
                            [
                                'icon' => '💡',
                                'name' => 'Virical Smart Ceiling V1',
                                'desc' => 'Đèn trần thông minh 48W với 16 triệu màu RGB',
                                'price' => '2.990.000₫'
                            ],
                            [
                                'icon' => '🏮',
                                'name' => 'Virical Desk Light Pro',
                                'desc' => 'Đèn bàn học 12W với cảm biến thông minh',
                                'price' => '990.000₫'
                            ],
                            [
                                'icon' => '🔦',
                                'name' => 'Virical Wall RGB Elite',
                                'desc' => 'Đèn tường RGB 24W với Music Sync',
                                'price' => '1.590.000₫'
                            ],
                            [
                                'icon' => '🌟',
                                'name' => 'Virical Solar Garden Pro',
                                'desc' => 'Đèn solar 30W với cảm biến chuyển động',
                                'price' => '2.190.000₫'
                            ]
                        ];
                        
                        foreach($products as $product): ?>
                        <div class="product-card">
                            <div class="product-image"><?php echo $product['icon']; ?></div>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo $product['name']; ?></h3>
                                <p class="product-desc"><?php echo $product['desc']; ?></p>
                                <div class="product-footer">
                                    <span class="product-price"><?php echo $product['price']; ?></span>
                                    <button class="product-btn">Xem chi tiết</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="virical-footer">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>VIRICAL</h3>
                    <p style="opacity: 0.7; line-height: 1.8;">Thương hiệu đèn thông minh hàng đầu Việt Nam. Mang đến giải pháp chiếu sáng hiện đại cho ngôi nhà của bạn.</p>
                </div>
                <div class="footer-column">
                    <h3>Sản phẩm</h3>
                    <ul>
                        <li><a href="#">Đèn trần thông minh</a></li>
                        <li><a href="#">Đèn bàn thông minh</a></li>
                        <li><a href="#">Đèn tường RGB</a></li>
                        <li><a href="#">Đèn ngoài trời</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Hỗ trợ</h3>
                    <ul>
                        <li><a href="#">Hướng dẫn sử dụng</a></li>
                        <li><a href="#">Cài đặt app</a></li>
                        <li><a href="#">Bảo hành</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Liên hệ</h3>
                    <ul>
                        <li><a href="#">📍 123 Nguyễn Văn Linh, Hà Nội</a></li>
                        <li><a href="#">📞 1900 xxxx</a></li>
                        <li><a href="#">✉️ info@virical.vn</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 VIRICAL. All rights reserved. | Designed with 💡 in Vietnam</p>
            </div>
        </footer>

        <!-- Light Controller Button -->
        <div class="light-controller" id="lightController">
            <span style="font-size: 1.5rem;">💡</span>
        </div>
    </div>

    <script>
        // Canvas particles animation
        const canvas = document.getElementById('heroCanvas');
        const ctx = canvas.getContext('2d');
        let particles = [];

        function resizeCanvas() {
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 0.5;
                this.speedX = Math.random() * 2 - 1;
                this.speedY = Math.random() * 2 - 1;
                this.opacity = Math.random() * 0.5 + 0.2;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x > canvas.width || this.x < 0) this.speedX *= -1;
                if (this.y > canvas.height || this.y < 0) this.speedY *= -1;
            }

            draw() {
                ctx.globalAlpha = this.opacity;
                ctx.fillStyle = '#667eea';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function createParticles() {
            particles = [];
            for (let i = 0; i < 50; i++) {
                particles.push(new Particle());
            }
        }

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });
            
            requestAnimationFrame(animateParticles);
        }

        createParticles();
        animateParticles();

        // Brightness control
        const brightnessSlider = document.getElementById('brightnessSlider');
        const brightnessValue = document.getElementById('brightnessValue');
        const lightOverlay = document.getElementById('lightOverlay');

        brightnessSlider.addEventListener('input', function() {
            const value = this.value;
            brightnessValue.textContent = value + '%';
            
            const brightness = 0.5 + (value / 100) * 0.5;
            document.body.style.filter = `brightness(${brightness})`;
            
            lightOverlay.style.opacity = (100 - value) / 200;
            lightOverlay.style.background = `radial-gradient(ellipse at center, rgba(0, 0, 0, ${(100 - value) / 100}) 0%, transparent 70%)`;
        });

        // Temperature control
        function setWarmLight() {
            document.body.style.filter = 'brightness(1) sepia(0.3)';
            lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(255, 152, 0, 0.1) 0%, transparent 70%)';
            lightOverlay.style.opacity = '0.3';
        }

        function setCoolLight() {
            document.body.style.filter = 'brightness(1) saturate(1.2)';
            lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(33, 150, 243, 0.1) 0%, transparent 70%)';
            lightOverlay.style.opacity = '0.3';
        }

        // Color wheel
        const colorWheel = document.getElementById('colorWheel');
        colorWheel.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            const angle = Math.atan2(y, x);
            const hue = ((angle * 180 / Math.PI) + 360) % 360;
            
            document.body.style.filter = `hue-rotate(${hue}deg)`;
            lightOverlay.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.1) 0%, transparent 70%)`;
            lightOverlay.style.opacity = '0.3';
        });

        // Scene control
        const sceneSelect = document.getElementById('sceneSelect');
        sceneSelect.addEventListener('change', function() {
            const scene = this.value;
            
            switch(scene) {
                case 'default':
                    document.body.style.filter = 'none';
                    lightOverlay.style.opacity = '0';
                    break;
                case 'reading':
                    document.body.style.filter = 'brightness(1.2) contrast(1.1)';
                    lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(255, 255, 255, 0.05) 0%, transparent 70%)';
                    lightOverlay.style.opacity = '0.2';
                    break;
                case 'movie':
                    document.body.style.filter = 'brightness(0.7) contrast(1.2) saturate(1.2)';
                    lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(0, 0, 0, 0.3) 0%, transparent 70%)';
                    lightOverlay.style.opacity = '0.5';
                    break;
                case 'party':
                    startPartyMode();
                    break;
                case 'relax':
                    document.body.style.filter = 'brightness(0.9) sepia(0.2)';
                    lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(255, 193, 7, 0.1) 0%, transparent 70%)';
                    lightOverlay.style.opacity = '0.3';
                    break;
                case 'sleep':
                    document.body.style.filter = 'brightness(0.5) sepia(0.1) contrast(0.9)';
                    lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(0, 0, 0, 0.5) 0%, transparent 70%)';
                    lightOverlay.style.opacity = '0.7';
                    break;
            }
        });

        // Party mode
        function startPartyMode() {
            let hue = 0;
            const partyInterval = setInterval(() => {
                hue = (hue + 10) % 360;
                document.body.style.filter = `hue-rotate(${hue}deg) brightness(1.1) saturate(1.5)`;
                lightOverlay.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.2) 0%, transparent 70%)`;
                lightOverlay.style.opacity = '0.4';
            }, 100);
            
            setTimeout(() => {
                clearInterval(partyInterval);
                document.body.style.filter = 'none';
                lightOverlay.style.opacity = '0';
            }, 10000);
        }

        // Light controller
        const lightController = document.getElementById('lightController');
        let lightMode = 0;
        
        lightController.addEventListener('click', () => {
            lightMode = (lightMode + 1) % 5;
            
            switch(lightMode) {
                case 0:
                    document.body.style.filter = 'none';
                    lightOverlay.style.opacity = '0';
                    break;
                case 1:
                    document.body.style.filter = 'brightness(1.3)';
                    lightOverlay.style.opacity = '0';
                    break;
                case 2:
                    document.body.style.filter = 'brightness(0.7)';
                    lightOverlay.style.opacity = '0.3';
                    break;
                case 3:
                    document.body.style.filter = 'sepia(0.3) brightness(1.1)';
                    lightOverlay.style.opacity = '0.2';
                    break;
                case 4:
                    document.body.style.filter = 'hue-rotate(180deg)';
                    lightOverlay.style.opacity = '0.2';
                    break;
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Scroll effects
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const header = document.querySelector('.virical-header');
            
            if (scrolled > 50) {
                header.style.background = 'rgba(10, 10, 10, 0.98)';
                header.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.3)';
            } else {
                header.style.background = 'rgba(10, 10, 10, 0.95)';
                header.style.boxShadow = 'none';
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe elements
        document.querySelectorAll('.control-card, .product-card').forEach(el => {
            observer.observe(el);
        });

        // Loading animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            setTimeout(() => {
                document.body.style.transition = 'opacity 0.5s ease';
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>

    <?php wp_footer(); ?>
</body>
</html>