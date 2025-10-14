<?php
/**
 * Template Name: Virical Bright Homepage
 * Description: Homepage with brighter, more luminous design
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
            background: #f8f9fa !important;
            color: #1a1a1a !important;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            overflow-x: hidden !important;
            min-height: 100vh !important;
        }

        /* Main wrapper */
        .virical-wrapper {
            width: 100%;
            min-height: 100vh;
            position: relative;
            background: linear-gradient(to bottom, #ffffff 0%, #f0f4ff 100%);
        }

        /* Header */
        .virical-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(102, 126, 234, 0.1);
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
            font-weight: 600;
            letter-spacing: 0.05em;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .main-nav {
            display: flex;
            list-style: none;
            gap: 35px;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .main-nav li {
            list-style: none;
        }

        .main-nav a {
            color: #4a5568;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 8px;
        }

        .main-nav a:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.08);
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
            background: radial-gradient(ellipse at top, rgba(102, 126, 234, 0.05) 0%, transparent 50%),
                        linear-gradient(to bottom, #ffffff 0%, #f8fafe 100%);
            overflow: hidden;
        }

        /* Animated light rays */
        .light-rays {
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 200%;
            height: 200%;
            background: conic-gradient(
                from 0deg at 50% 50%,
                transparent 0deg,
                rgba(102, 126, 234, 0.03) 10deg,
                transparent 20deg,
                transparent 40deg,
                rgba(118, 75, 162, 0.03) 50deg,
                transparent 60deg
            );
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            from { transform: translateX(-50%) rotate(0deg); }
            to { transform: translateX(-50%) rotate(360deg); }
        }

        .hero-content {
            text-align: center;
            z-index: 10;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 1s ease-out;
            text-shadow: 0 0 80px rgba(102, 126, 234, 0.3);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: #4a5568;
            margin-bottom: 40px;
            font-weight: 400;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .cta-button {
            display: inline-block;
            padding: 16px 48px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease-out 0.4s both;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
        }

        /* Floating orbs */
        .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.2) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }

        .orb1 {
            width: 300px;
            height: 300px;
            top: 10%;
            left: -150px;
            animation-delay: 0s;
        }

        .orb2 {
            width: 200px;
            height: 200px;
            bottom: 10%;
            right: -100px;
            animation-delay: 5s;
        }

        .orb3 {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 10%;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(40px, 10px) scale(1.05); }
        }

        /* Control Section */
        .control-section {
            padding: 120px 0;
            background: #ffffff;
            position: relative;
        }

        .control-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(102, 126, 234, 0.2), transparent);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #4a5568;
            font-weight: 400;
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .control-card {
            background: #ffffff;
            border: 1px solid rgba(102, 126, 234, 0.1);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
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
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.15);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .control-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            filter: brightness(1.2);
        }

        .control-title {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #1a1a1a;
            font-weight: 600;
        }

        /* Interactive controls */
        .brightness-slider {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
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
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
            border: 3px solid #fff;
        }

        .brightness-value {
            font-size: 1.5rem;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .temp-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        .temp-btn {
            padding: 12px 32px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .warm-btn {
            background: linear-gradient(135deg, #ff9a56, #ff6a00);
        }

        .cool-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .temp-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .color-wheel {
            width: 120px;
            height: 120px;
            margin: 20px auto;
            border-radius: 50%;
            background: conic-gradient(red, yellow, lime, cyan, blue, magenta, red);
            cursor: pointer;
            transition: transform 0.3s ease;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            border: 4px solid #fff;
        }

        .color-wheel:hover {
            transform: scale(1.1) rotate(10deg);
        }

        /* Radio Button Grid Scene Selector */
        .scene-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(105px, 1fr));
            gap: 8px;
            margin-top: 12px;
        }
        
        .scene-radio {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 6px;
            background: #ffffff;
            border: 2px solid rgba(102, 126, 234, 0.1);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        /* Custom Radio Button Circle */
        .scene-radio::after {
            content: '';
            position: absolute;
            top: 6px;
            right: 6px;
            width: 14px;
            height: 14px;
            border: 2px solid #e2e8f0;
            border-radius: 50%;
            background: white;
            transition: all 0.3s ease;
        }
        
        .scene-radio.selected::after {
            border-color: #667eea;
            background: #667eea;
            box-shadow: inset 0 0 0 2px white;
        }
        
        .scene-radio::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
        }
        
        .scene-radio:hover {
            border-color: rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.1);
        }
        
        .scene-radio.selected {
            background: linear-gradient(135deg, #eef2ff 0%, #f7fafc 100%);
            border-color: #667eea;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.15);
        }
        
        .scene-radio.selected::before {
            opacity: 1;
        }
        
        .scene-radio input[type="radio"] {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            white-space: nowrap;
            border: 0;
        }
        
        .scene-radio .scene-icon {
            font-size: 20px;
            margin-bottom: 4px;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .scene-radio:hover .scene-icon {
            transform: scale(1.06);
        }
        
        .scene-radio.selected .scene-icon {
            transform: scale(1.08);
        }
        
        .scene-radio .scene-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.8rem;
            text-align: center;
            margin-bottom: 1px;
            position: relative;
            z-index: 1;
        }
        
        .scene-radio.selected .scene-name {
            color: #667eea;
        }
        
        .scene-radio .scene-desc {
            font-size: 0.65rem;
            color: #718096;
            text-align: center;
            line-height: 1.1;
            position: relative;
            z-index: 1;
        }
        
        .scene-radio.selected .scene-desc {
            color: #5a67d8;
        }

        /* Products Section */
        .products-section {
            padding: 120px 0;
            background: #f8fafe;
            position: relative;
        }

        .products-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(102, 126, 234, 0.2), transparent);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: #ffffff;
            border: 1px solid rgba(102, 126, 234, 0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            opacity: 0;
            transform: translateY(30px);
        }

        .product-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.15);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .product-image {
            height: 250px;
            background: linear-gradient(135deg, #f0f4ff 0%, #e6ebff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            position: relative;
            overflow: hidden;
        }

        .product-image::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 50%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.2); opacity: 1; }
        }

        .product-info {
            padding: 30px;
        }

        .product-name {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #1a1a1a;
            font-weight: 600;
        }

        .product-desc {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-btn {
            padding: 10px 24px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            color: #fff;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .product-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        /* Tech Section */
        .tech-section {
            padding: 120px 0;
            background: #ffffff;
            position: relative;
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
            opacity: 0;
            transform: translateY(30px);
        }

        .tech-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .tech-item:hover {
            transform: translateY(-5px);
        }

        .tech-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
            filter: brightness(1.2);
        }

        .tech-name {
            font-size: 1.3rem;
            margin-bottom: 10px;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .tech-desc {
            color: #4a5568;
            line-height: 1.6;
        }

        /* Footer */
        .virical-footer {
            background: linear-gradient(to bottom, #2d3748 0%, #1a202c 100%);
            color: #fff;
            padding: 60px 0 30px;
            position: relative;
        }

        .footer-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(102, 126, 234, 0.5), transparent);
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-column p {
            line-height: 1.8;
            opacity: 0.8;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column li {
            margin-bottom: 12px;
        }

        .footer-column a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-column a:hover {
            color: #667eea;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.8;
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
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            z-index: 999;
        }

        .light-controller:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
        }

        .light-controller span {
            font-size: 1.5rem;
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
                font-size: 3rem;
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
                <div class="light-rays"></div>
                <div class="floating-orb orb1"></div>
                <div class="floating-orb orb2"></div>
                <div class="floating-orb orb3"></div>
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
                            <input type="range" class="brightness-slider" id="brightnessSlider" min="0" max="100" value="85">
                            <p class="brightness-value" id="brightnessValue">85%</p>
                            <p style="color: #718096; margin-top: 10px;">Điều chỉnh từ 0-100%</p>
                        </div>

                        <!-- Temperature Control -->
                        <div class="control-card">
                            <div class="control-icon">🌡️</div>
                            <h3 class="control-title">Nhiệt độ màu</h3>
                            <div class="temp-buttons">
                                <button class="temp-btn warm-btn" onclick="setWarmLight()">Ấm</button>
                                <button class="temp-btn cool-btn" onclick="setCoolLight()">Lạnh</button>
                            </div>
                            <p style="color: #718096; margin-top: 20px;">2700K - 6500K</p>
                        </div>

                        <!-- Color Control -->
                        <div class="control-card">
                            <div class="control-icon">🎨</div>
                            <h3 class="control-title">16 triệu màu</h3>
                            <div class="color-wheel" id="colorWheel"></div>
                            <p style="color: #718096;">Chạm để chọn màu</p>
                        </div>

                        <!-- Scene Control -->
                        <div class="control-card">
                            <h3 class="control-title" style="margin-top: 20px;">Cảnh sẵn có</h3>
                            <p style="color: #718096; margin-bottom: 15px;">Chế độ thông minh</p>
                            
                            <div class="scene-selector" id="sceneSelector">
                                <label class="scene-radio selected">
                                    <input type="radio" name="scene" value="default" checked onchange="selectScene(this)">
                                    <span class="scene-icon">🏠</span>
                                    <span class="scene-name">Mặc định</span>
                                    <span class="scene-desc">Cân bằng</span>
                                </label>
                                
                                <label class="scene-radio">
                                    <input type="radio" name="scene" value="reading" onchange="selectScene(this)">
                                    <span class="scene-icon">📖</span>
                                    <span class="scene-name">Đọc sách</span>
                                    <span class="scene-desc">Tập trung</span>
                                </label>
                                
                                <label class="scene-radio">
                                    <input type="radio" name="scene" value="movie" onchange="selectScene(this)">
                                    <span class="scene-icon">🎬</span>
                                    <span class="scene-name">Xem phim</span>
                                    <span class="scene-desc">Ấm áp</span>
                                </label>
                                
                                <label class="scene-radio">
                                    <input type="radio" name="scene" value="party" onchange="selectScene(this)">
                                    <span class="scene-icon">🎉</span>
                                    <span class="scene-name">Party</span>
                                    <span class="scene-desc">Sống động</span>
                                </label>
                                
                                <label class="scene-radio">
                                    <input type="radio" name="scene" value="relax" onchange="selectScene(this)">
                                    <span class="scene-icon">🧘</span>
                                    <span class="scene-name">Thư giãn</span>
                                    <span class="scene-desc">Nhẹ nhàng</span>
                                </label>
                                
                                <label class="scene-radio">
                                    <input type="radio" name="scene" value="sleep" onchange="selectScene(this)">
                                    <span class="scene-icon">😴</span>
                                    <span class="scene-name">Ngủ</span>
                                    <span class="scene-desc">Dịu mờ</span>
                                </label>
                            </div>
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

            <!-- Tech Section -->
            <section class="tech-section" id="tech">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Công nghệ tiên tiến</h2>
                        <p class="section-subtitle">Những tính năng làm nên sự khác biệt</p>
                    </div>
                    
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
        </main>

        <!-- Footer -->
        <footer class="virical-footer">
            <div class="footer-glow"></div>
            <div class="footer-content">
                <div class="footer-column">
                    <h3>VIRICAL</h3>
                    <p>Thương hiệu đèn thông minh hàng đầu Việt Nam. Mang đến giải pháp chiếu sáng hiện đại cho ngôi nhà của bạn.</p>
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
        // Brightness control
        const brightnessSlider = document.getElementById('brightnessSlider');
        const brightnessValue = document.getElementById('brightnessValue');
        const lightOverlay = document.getElementById('lightOverlay');

        brightnessSlider.addEventListener('input', function() {
            const value = this.value;
            brightnessValue.textContent = value + '%';
            
            // Lighter approach - increase brightness for bright theme
            const brightness = 0.8 + (value / 100) * 0.4;
            document.body.style.filter = `brightness(${brightness})`;
            
            // Light overlay effect
            if (value < 50) {
                lightOverlay.style.opacity = (50 - value) / 100;
                lightOverlay.style.background = `radial-gradient(ellipse at center, rgba(0, 0, 0, ${(50 - value) / 50}) 0%, transparent 70%)`;
            } else {
                lightOverlay.style.opacity = 0;
            }
        });

        // Temperature control
        function setWarmLight() {
            document.body.style.filter = 'brightness(1.1) sepia(0.2)';
            lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(255, 152, 0, 0.05) 0%, transparent 70%)';
            lightOverlay.style.opacity = '0.1';
        }

        function setCoolLight() {
            document.body.style.filter = 'brightness(1.1) saturate(1.1)';
            lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(33, 150, 243, 0.05) 0%, transparent 70%)';
            lightOverlay.style.opacity = '0.1';
        }

        // Color wheel
        const colorWheel = document.getElementById('colorWheel');
        colorWheel.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            const angle = Math.atan2(y, x);
            const hue = ((angle * 180 / Math.PI) + 360) % 360;
            
            document.body.style.filter = `brightness(1.1) hue-rotate(${hue}deg)`;
            lightOverlay.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.05) 0%, transparent 70%)`;
            lightOverlay.style.opacity = '0.1';
        });

        // Scene Selector Radio Button Functions
        window.selectScene = function(input) {
            const scene = input.value;
            
            // Update UI - remove selected class from all, add to current
            document.querySelectorAll('.scene-radio').forEach(radio => {
                radio.classList.remove('selected');
            });
            input.parentElement.classList.add('selected');
            
            // Apply scene
            switch(scene) {
                case 'default':
                    document.body.style.filter = 'none';
                    lightOverlay.style.opacity = '0';
                    break;
                case 'reading':
                    document.body.style.filter = 'brightness(1.2) contrast(1.05)';
                    lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(255, 255, 255, 0.02) 0%, transparent 70%)';
                    lightOverlay.style.opacity = '0.1';
                    break;
                case 'movie':
                    document.body.style.filter = 'brightness(0.85) contrast(1.1) saturate(1.1)';
                    lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(0, 0, 0, 0.2) 0%, transparent 70%)';
                    lightOverlay.style.opacity = '0.3';
                    break;
                case 'party':
                    startPartyMode();
                    break;
                case 'relax':
                    document.body.style.filter = 'brightness(1.05) sepia(0.1)';
                    lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(255, 193, 7, 0.05) 0%, transparent 70%)';
                    lightOverlay.style.opacity = '0.15';
                    break;
                case 'sleep':
                    document.body.style.filter = 'brightness(0.7) sepia(0.05) contrast(0.95)';
                    lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(0, 0, 0, 0.4) 0%, transparent 70%)';
                    lightOverlay.style.opacity = '0.5';
                    break;
            }
        };

        // Party mode
        function startPartyMode() {
            let hue = 0;
            const partyInterval = setInterval(() => {
                hue = (hue + 10) % 360;
                document.body.style.filter = `hue-rotate(${hue}deg) brightness(1.15) saturate(1.3)`;
                lightOverlay.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.1) 0%, transparent 70%)`;
                lightOverlay.style.opacity = '0.2';
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
                    document.body.style.filter = 'brightness(1.2)';
                    lightOverlay.style.opacity = '0';
                    break;
                case 2:
                    document.body.style.filter = 'brightness(0.9)';
                    lightOverlay.style.opacity = '0.2';
                    break;
                case 3:
                    document.body.style.filter = 'sepia(0.15) brightness(1.05)';
                    lightOverlay.style.opacity = '0.1';
                    break;
                case 4:
                    document.body.style.filter = 'hue-rotate(30deg) brightness(1.1)';
                    lightOverlay.style.opacity = '0.1';
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
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.boxShadow = '0 4px 30px rgba(102, 126, 234, 0.15)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = '0 2px 20px rgba(102, 126, 234, 0.1)';
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                }
            });
        }, observerOptions);

        // Observe elements
        document.querySelectorAll('.control-card, .product-card, .tech-item').forEach(el => {
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