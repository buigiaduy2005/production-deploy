<?php
/**
 * Template Name: Virical Interactive Homepage
 * Description: Trang chủ với hiệu ứng ánh sáng tương tác
 */

get_header(); ?>

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Reset và base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0a0a0a;
            color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        /* Hide default header */
        .site-header,
        .site-footer {
            display: none !important;
        }

        /* Animated background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at center, rgba(46, 49, 146, 0.1) 0%, transparent 70%);
            pointer-events: none;
            z-index: 1;
        }

        /* Light particles */
        .particle {
            position: fixed;
            pointer-events: none;
            opacity: 0;
            z-index: 2;
        }

        /* Hero Section */
        .hero-section {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
        }

        .hero-content {
            text-align: center;
            animation: fadeInUp 1s ease-out;
        }

        .logo-light {
            width: 120px;
            height: 120px;
            margin: 0 auto 40px;
            position: relative;
        }

        .light-bulb {
            width: 100%;
            height: 100%;
            position: relative;
            animation: float 4s ease-in-out infinite;
        }

        .light-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 60%);
            transform: translate(-50%, -50%);
            animation: pulse 2s ease-in-out infinite;
        }

        h1.brand {
            font-size: 5rem;
            font-weight: 300;
            letter-spacing: 0.1em;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        .tagline {
            font-size: 1.5rem;
            opacity: 0.8;
            margin-bottom: 40px;
        }

        .cta-button {
            display: inline-block;
            padding: 18px 50px;
            font-size: 1.1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: transparent;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .cta-button:hover {
            border-color: #667eea;
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.5);
            transform: translateY(-2px);
        }

        /* Control Section */
        .control-section {
            min-height: 100vh;
            padding: 100px 20px;
            position: relative;
            z-index: 10;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 3.5rem;
            text-align: center;
            margin-bottom: 80px;
            font-weight: 300;
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .control-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .control-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: -1;
        }

        .control-card:hover {
            transform: translateY(-10px);
            border-color: rgba(102, 126, 234, 0.5);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .control-card:hover::before {
            opacity: 1;
        }

        .control-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 20px currentColor);
        }

        .control-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: 400;
        }

        /* Brightness slider */
        .brightness-slider {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            outline: none;
            -webkit-appearance: none;
            margin: 20px 0;
        }

        .brightness-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: #667eea;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }

        /* Color buttons */
        .color-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .color-btn {
            padding: 12px 30px;
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

        .color-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* Color wheel */
        .color-wheel {
            width: 150px;
            height: 150px;
            margin: 20px auto;
            border-radius: 50%;
            background: conic-gradient(
                red 0deg,
                orange 60deg,
                yellow 120deg,
                green 180deg,
                cyan 240deg,
                blue 300deg,
                red 360deg
            );
            cursor: pointer;
            transition: transform 0.3s ease;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
        }

        .color-wheel:hover {
            transform: scale(1.1) rotate(180deg);
        }

        /* Scene selector */
        .scene-select {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #fff;
            font-size: 1rem;
            margin-top: 20px;
        }

        .scene-select option {
            background: #1a1a1a;
        }

        /* Products Section */
        .products-section {
            min-height: 100vh;
            padding: 100px 20px;
            position: relative;
            z-index: 10;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .product-image {
            height: 300px;
            background: radial-gradient(ellipse at center, rgba(102, 126, 234, 0.2) 0%, transparent 70%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .product-light {
            font-size: 5rem;
            animation: float 3s ease-in-out infinite;
        }

        .product-info {
            padding: 30px;
        }

        .product-name {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: 400;
        }

        .product-desc {
            opacity: 0.7;
            margin-bottom: 20px;
            line-height: 1.6;
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
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        /* Tech Section */
        .tech-section {
            min-height: 100vh;
            padding: 100px 20px;
            position: relative;
            z-index: 10;
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .tech-item {
            text-align: center;
            padding: 40px 20px;
            transition: transform 0.3s ease;
        }

        .tech-item:hover {
            transform: scale(1.05);
        }

        .tech-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            display: inline-block;
            animation: float 4s ease-in-out infinite;
        }

        .tech-name {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #667eea;
        }

        .tech-desc {
            opacity: 0.7;
            line-height: 1.6;
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

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.5;
                transform: translate(-50%, -50%) scale(1);
            }
            50% {
                opacity: 0.8;
                transform: translate(-50%, -50%) scale(1.2);
            }
        }

        /* Fixed light control button */
        .light-controller {
            position: fixed;
            bottom: 40px;
            right: 40px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .light-controller:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .light-controller span {
            font-size: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1.brand {
                font-size: 3rem;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
            
            .controls-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg" id="animatedBg"></div>
    
    <!-- Light Particles -->
    <div id="particlesContainer"></div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="logo-light">
                <div class="light-glow"></div>
                <div class="light-bulb">
                    <svg viewBox="0 0 100 100" style="width: 100%; height: 100%;">
                        <circle cx="50" cy="40" r="25" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                        <path d="M35 55 Q50 65 65 55" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="2"/>
                        <rect x="42" y="65" width="16" height="10" fill="rgba(255,255,255,0.3)"/>
                        <line x1="45" y1="75" x2="45" y2="80" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                        <line x1="50" y1="75" x2="50" y2="80" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                        <line x1="55" y1="75" x2="55" y2="80" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                    </svg>
                </div>
            </div>
            <h1 class="brand">VIRICAL</h1>
            <p class="tagline">Ánh sáng thông minh cho cuộc sống hiện đại</p>
            <a href="#control" class="cta-button">Trải nghiệm ngay</a>
        </div>
    </section>

    <!-- Control Section -->
    <section class="control-section" id="control">
        <div class="container">
            <h2 class="section-title">Điều khiển mọi ánh sáng</h2>
            
            <div class="controls-grid">
                <!-- Brightness Control -->
                <div class="control-card">
                    <div class="control-icon">☀️</div>
                    <h3 class="control-title">Độ sáng</h3>
                    <input type="range" class="brightness-slider" id="brightnessSlider" min="0" max="100" value="75">
                    <p class="control-desc">Điều chỉnh từ 0-100%</p>
                    <p id="brightnessValue" style="font-size: 1.5rem; margin-top: 10px;">75%</p>
                </div>

                <!-- Color Temperature -->
                <div class="control-card">
                    <div class="control-icon">🌡️</div>
                    <h3 class="control-title">Nhiệt độ màu</h3>
                    <div class="color-buttons">
                        <button class="color-btn warm-btn" onclick="setWarmLight()">Ấm</button>
                        <button class="color-btn cool-btn" onclick="setCoolLight()">Lạnh</button>
                    </div>
                </div>

                <!-- RGB Color -->
                <div class="control-card">
                    <div class="control-icon">🎨</div>
                    <h3 class="control-title">16 triệu màu</h3>
                    <div class="color-wheel" id="colorWheel"></div>
                </div>

                <!-- Scenes -->
                <div class="control-card">
                    <h3 class="control-title" style="margin-top: 20px;">Cảnh sẵn có</h3>
                    <select class="scene-select" id="sceneSelect">
                        <option value="reading">Đọc sách</option>
                        <option value="movie">Xem phim</option>
                        <option value="party">Party</option>
                        <option value="relax">Thư giãn</option>
                        <option value="sleep">Ngủ</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <h2 class="section-title">Sản phẩm nổi bật</h2>
            
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-image">
                        <div class="product-light">💡</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Virical Smart Ceiling V1</h3>
                        <p class="product-desc">Đèn trần thông minh 48W với 16 triệu màu RGB</p>
                        <div class="product-footer">
                            <span class="product-price">2.990.000₫</span>
                            <button class="product-btn">Xem chi tiết</button>
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <div class="product-light">🏮</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Virical Desk Light Pro</h3>
                        <p class="product-desc">Đèn bàn học 12W với cảm biến thông minh</p>
                        <div class="product-footer">
                            <span class="product-price">990.000₫</span>
                            <button class="product-btn">Xem chi tiết</button>
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <div class="product-light">🔦</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Virical Wall RGB Elite</h3>
                        <p class="product-desc">Đèn tường RGB 24W với Music Sync</p>
                        <div class="product-footer">
                            <span class="product-price">1.590.000₫</span>
                            <button class="product-btn">Xem chi tiết</button>
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <div class="product-light">🌟</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Virical Solar Garden Pro</h3>
                        <p class="product-desc">Đèn solar 30W với cảm biến chuyển động</p>
                        <div class="product-footer">
                            <span class="product-price">2.190.000₫</span>
                            <button class="product-btn">Xem chi tiết</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Section -->
    <section class="tech-section">
        <div class="container">
            <h2 class="section-title">Công nghệ tiên tiến</h2>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <div class="tech-icon">📱</div>
                    <h3 class="tech-name">App Control</h3>
                    <p class="tech-desc">Điều khiển mọi lúc mọi nơi qua smartphone</p>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">🎤</div>
                    <h3 class="tech-name">Voice Control</h3>
                    <p class="tech-desc">Tương thích Google Home & Alexa</p>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">⏰</div>
                    <h3 class="tech-name">Schedule</h3>
                    <p class="tech-desc">Lập lịch tự động bật/tắt thông minh</p>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">🎵</div>
                    <h3 class="tech-name">Music Sync</h3>
                    <p class="tech-desc">Đồng bộ ánh sáng với nhạc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fixed Light Controller -->
    <div class="light-controller" id="lightController">
        <span>💡</span>
    </div>

    <script>
        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particlesContainer');
            
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.width = Math.random() * 4 + 'px';
                particle.style.height = particle.style.width;
                particle.style.background = 'rgba(255, 255, 255, 0.8)';
                particle.style.borderRadius = '50%';
                particle.style.boxShadow = '0 0 10px rgba(255, 255, 255, 0.5)';
                
                container.appendChild(particle);
                
                animateParticle(particle);
            }
        }

        function animateParticle(particle) {
            const duration = Math.random() * 20 + 10;
            const delay = Math.random() * 5;
            
            particle.animate([
                { 
                    opacity: 0,
                    transform: 'translate(0, 0) scale(0)'
                },
                { 
                    opacity: 1,
                    transform: `translate(${Math.random() * 200 - 100}px, ${Math.random() * 200 - 100}px) scale(1)`
                },
                { 
                    opacity: 0,
                    transform: `translate(${Math.random() * 400 - 200}px, ${Math.random() * 400 - 200}px) scale(0)`
                }
            ], {
                duration: duration * 1000,
                delay: delay * 1000,
                iterations: Infinity
            });
        }

        // Brightness control
        const brightnessSlider = document.getElementById('brightnessSlider');
        const brightnessValue = document.getElementById('brightnessValue');
        const animatedBg = document.getElementById('animatedBg');

        brightnessSlider.addEventListener('input', function() {
            const value = this.value;
            brightnessValue.textContent = value + '%';
            
            // Change page brightness
            const brightness = 0.3 + (value / 100) * 0.7;
            document.body.style.filter = `brightness(${brightness})`;
            
            // Animate background
            animatedBg.style.background = `radial-gradient(ellipse at center, rgba(102, 126, 234, ${value/200}) 0%, transparent 70%)`;
        });

        // Color temperature functions
        function setWarmLight() {
            document.body.style.filter = 'brightness(1) sepia(0.3)';
            animatedBg.style.background = 'radial-gradient(ellipse at center, rgba(255, 152, 0, 0.2) 0%, transparent 70%)';
        }

        function setCoolLight() {
            document.body.style.filter = 'brightness(1) saturate(1.2)';
            animatedBg.style.background = 'radial-gradient(ellipse at center, rgba(33, 150, 243, 0.2) 0%, transparent 70%)';
        }

        // Color wheel interaction
        const colorWheel = document.getElementById('colorWheel');
        colorWheel.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            const angle = Math.atan2(y, x) * 180 / Math.PI;
            
            const hue = (angle + 360) % 360;
            document.body.style.filter = `hue-rotate(${hue}deg)`;
            animatedBg.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.2) 0%, transparent 70%)`;
        });

        // Scene selector
        const sceneSelect = document.getElementById('sceneSelect');
        sceneSelect.addEventListener('change', function() {
            const scene = this.value;
            
            switch(scene) {
                case 'reading':
                    document.body.style.filter = 'brightness(1.2) contrast(1.1)';
                    animatedBg.style.background = 'radial-gradient(ellipse at center, rgba(255, 255, 255, 0.1) 0%, transparent 70%)';
                    break;
                case 'movie':
                    document.body.style.filter = 'brightness(0.7) contrast(1.2)';
                    animatedBg.style.background = 'radial-gradient(ellipse at center, rgba(0, 0, 0, 0.3) 0%, transparent 70%)';
                    break;
                case 'party':
                    startPartyMode();
                    break;
                case 'relax':
                    document.body.style.filter = 'brightness(0.9) sepia(0.2)';
                    animatedBg.style.background = 'radial-gradient(ellipse at center, rgba(255, 193, 7, 0.15) 0%, transparent 70%)';
                    break;
                case 'sleep':
                    document.body.style.filter = 'brightness(0.5) sepia(0.1)';
                    animatedBg.style.background = 'radial-gradient(ellipse at center, rgba(0, 0, 0, 0.5) 0%, transparent 70%)';
                    break;
            }
        });

        // Party mode animation
        function startPartyMode() {
            let hue = 0;
            const partyInterval = setInterval(() => {
                hue = (hue + 10) % 360;
                document.body.style.filter = `hue-rotate(${hue}deg) brightness(1.1) saturate(1.5)`;
                animatedBg.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.3) 0%, transparent 70%)`;
            }, 100);
            
            // Stop party mode after 10 seconds
            setTimeout(() => {
                clearInterval(partyInterval);
                document.body.style.filter = 'none';
            }, 10000);
        }

        // Scroll effects
        let lastScrollTop = 0;
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / scrollHeight) * 100;
            
            // Change background based on scroll
            const hue = (scrollPercent * 3.6) % 360;
            animatedBg.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.2) 0%, transparent 70%)`;
            
            // Parallax effect for sections
            const sections = document.querySelectorAll('section');
            sections.forEach((section, index) => {
                const speed = 0.5 + (index * 0.1);
                const yPos = -(scrollTop * speed * 0.1);
                section.style.transform = `translateY(${yPos}px)`;
            });
            
            lastScrollTop = scrollTop;
        });

        // Light controller button
        const lightController = document.getElementById('lightController');
        let lightMode = 0;
        
        lightController.addEventListener('click', () => {
            lightMode = (lightMode + 1) % 5;
            
            switch(lightMode) {
                case 0:
                    document.body.style.filter = 'none';
                    break;
                case 1:
                    document.body.style.filter = 'brightness(1.3)';
                    break;
                case 2:
                    document.body.style.filter = 'brightness(0.7)';
                    break;
                case 3:
                    document.body.style.filter = 'sepia(0.3) brightness(1.1)';
                    break;
                case 4:
                    document.body.style.filter = 'hue-rotate(180deg)';
                    break;
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Initialize
        createParticles();
        
        // Add hover effects to product cards
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 0 50px rgba(102, 126, 234, 0.3)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '';
            });
        });
    </script>
</body>
</html>

<?php get_footer(); ?>