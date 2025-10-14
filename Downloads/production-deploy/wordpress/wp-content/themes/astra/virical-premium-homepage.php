<?php
/**
 * Template Name: Virical Premium Homepage
 * Description: Giao diện cao cấp với hiệu ứng mượt mà
 */

get_header(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php wp_head(); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables */
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --bg-dark: #0a0a0a;
            --bg-section: #0f0f0f;
            --card-bg: rgba(255, 255, 255, 0.03);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --border-color: rgba(255, 255, 255, 0.08);
            --glow-color: rgba(102, 126, 234, 0.5);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            overflow-x: hidden;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Hide WordPress defaults */
        #wpadminbar,
        .site-header:not(.virical-header),
        .site-footer:not(.virical-footer) {
            display: none !important;
        }

        html {
            margin-top: 0 !important;
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            border-radius: 5px;
        }

        /* Header */
        .virical-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            z-index: 1000;
            transition: var(--transition);
        }

        .virical-header.scrolled {
            background: rgba(10, 10, 10, 0.95);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .logo {
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            cursor: pointer;
            transition: var(--transition);
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .main-nav {
            display: flex;
            list-style: none;
            gap: 40px;
            align-items: center;
        }

        .main-nav a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .main-nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transition: width 0.3s ease;
        }

        .main-nav a:hover {
            color: var(--text-primary);
        }

        .main-nav a:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: radial-gradient(ellipse at center, rgba(102, 126, 234, 0.15) 0%, transparent 50%);
        }

        .hero-bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.3;
        }

        .hero-content {
            text-align: center;
            z-index: 10;
            padding: 0 20px;
            max-width: 900px;
        }

        .hero-badge {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 30px;
            animation: fadeInDown 0.8s ease-out;
        }

        .hero-title {
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeInUp 0.8s ease-out;
            letter-spacing: -0.03em;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: var(--text-secondary);
            margin-bottom: 40px;
            animation: fadeInUp 0.8s ease-out 0.2s both;
            font-weight: 300;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 18px 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            font-size: 1.1rem;
            transition: var(--transition);
            animation: fadeInUp 0.8s ease-out 0.4s both;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        /* Control Section */
        .control-section {
            padding: 120px 0;
            background: var(--bg-section);
            position: relative;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-label {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 20px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            color: var(--primary-color);
            font-weight: 500;
        }

        .section-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .control-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 40px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .control-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(102, 126, 234, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: -1;
        }

        .control-card:hover {
            transform: translateY(-5px);
            border-color: rgba(102, 126, 234, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .control-card:hover::before {
            opacity: 1;
        }

        .control-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 24px;
        }

        .control-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .control-desc {
            color: var(--text-secondary);
            margin-bottom: 24px;
            font-size: 0.95rem;
        }

        /* Brightness Slider */
        .brightness-container {
            margin-top: 24px;
        }

        .brightness-slider {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            outline: none;
            -webkit-appearance: none;
            cursor: pointer;
            position: relative;
        }

        .brightness-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
            transition: var(--transition);
        }

        .brightness-slider::-webkit-slider-thumb:hover {
            transform: scale(1.2);
        }

        .brightness-value {
            display: block;
            text-align: center;
            margin-top: 16px;
            font-size: 2rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Temperature Buttons */
        .temp-buttons {
            display: flex;
            gap: 16px;
            margin-top: 24px;
        }

        .temp-btn {
            flex: 1;
            padding: 16px 24px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .temp-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .temp-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .warm-btn {
            background: linear-gradient(135deg, #ff9a56, #ff6a00);
            color: white;
        }

        .warm-btn::before {
            background: rgba(255, 255, 255, 0.2);
        }

        .cool-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .cool-btn::before {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Color Wheel */
        .color-wheel-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
        }

        .color-wheel {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(
                from 0deg,
                #ff0000,
                #ff8800,
                #ffff00,
                #00ff00,
                #00ffff,
                #0000ff,
                #ff00ff,
                #ff0000
            );
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .color-wheel::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 30px;
            height: 30px;
            background: white;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .color-wheel:hover {
            transform: scale(1.05) rotate(180deg);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        /* Scene Selector */
        .scene-select {
            width: 100%;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 24px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23ffffff' d='M6 8L0 0h12z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 20px center;
            padding-right: 50px;
        }

        .scene-select:hover {
            background-color: rgba(255, 255, 255, 0.08);
            border-color: rgba(102, 126, 234, 0.5);
        }

        .scene-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        /* Products Section */
        .products-section {
            padding: 120px 0;
            background: var(--bg-dark);
            position: relative;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 60px;
        }

        .product-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
            group: product;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .product-image {
            height: 280px;
            background: radial-gradient(ellipse at center, rgba(102, 126, 234, 0.1) 0%, transparent 60%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .product-icon {
            font-size: 5rem;
            transition: var(--transition);
        }

        .product-card:hover .product-icon {
            transform: scale(1.2) rotate(10deg);
        }

        .product-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.3) 0%, transparent 70%);
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .product-glow {
            opacity: 1;
        }

        .product-info {
            padding: 32px;
        }

        .product-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .product-desc {
            color: var(--text-secondary);
            margin-bottom: 24px;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .product-btn {
            padding: 12px 28px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .product-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        /* Tech Section */
        .tech-section {
            padding: 120px 0;
            background: var(--bg-section);
            position: relative;
            overflow: hidden;
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .tech-item {
            text-align: center;
            padding: 40px 30px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            transition: var(--transition);
        }

        .tech-item:hover {
            transform: translateY(-5px);
            border-color: rgba(102, 126, 234, 0.3);
            background: rgba(255, 255, 255, 0.05);
        }

        .tech-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            transition: var(--transition);
        }

        .tech-item:hover .tech-icon {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
        }

        .tech-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--primary-color);
        }

        .tech-desc {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Footer */
        .virical-footer {
            background: #000;
            padding: 80px 0 40px;
            border-top: 1px solid var(--border-color);
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-brand h3 {
            font-size: 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        .footer-column h4 {
            font-size: 1.1rem;
            margin-bottom: 24px;
            color: var(--text-primary);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 16px;
        }

        .footer-column a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .footer-column a:hover {
            color: var(--primary-color);
            transform: translateX(5px);
            display: inline-block;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        /* Light Controller */
        .light-controller {
            position: fixed;
            bottom: 40px;
            right: 40px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            transition: var(--transition);
            z-index: 999;
        }

        .light-controller:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .light-controller:active {
            transform: scale(0.95);
        }

        /* Floating Elements */
        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(102, 126, 234, 0.5);
            border-radius: 50%;
            filter: blur(1px);
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

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
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
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        /* Light Overlay */
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

        /* Responsive */
        @media (max-width: 1024px) {
            .header-container,
            .container {
                padding: 0 30px;
            }
            
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
                gap: 40px;
            }
        }

        @media (max-width: 768px) {
            .main-nav {
                display: none;
            }
            
            .hero-title {
                font-size: 3rem;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
            
            .controls-grid,
            .products-grid,
            .tech-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 30px;
            }
            
            .light-controller {
                width: 60px;
                height: 60px;
                bottom: 30px;
                right: 30px;
            }
        }

        /* Loading Animation */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        .loader.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loader-icon {
            width: 60px;
            height: 60px;
            border: 3px solid rgba(102, 126, 234, 0.2);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div class="loader" id="loader">
        <div class="loader-icon"></div>
    </div>

    <!-- Light Overlay -->
    <div class="light-overlay" id="lightOverlay"></div>
    
    <!-- Floating Particles -->
    <div class="floating-particles" id="particles"></div>

    <!-- Header -->
    <header class="virical-header" id="header">
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

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <canvas class="hero-bg-animation" id="heroCanvas"></canvas>
        <div class="hero-content">
            <div class="hero-badge">✨ Công nghệ ánh sáng thông minh</div>
            <h1 class="hero-title">VIRICAL</h1>
            <p class="hero-subtitle">Ánh sáng thông minh cho cuộc sống hiện đại</p>
            <a href="#products" class="cta-button">
                Khám phá sản phẩm
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- Control Section -->
    <section class="control-section" id="control">
        <div class="container">
            <div class="section-header">
                <span class="section-label">ĐIỀU KHIỂN</span>
                <h2 class="section-title">Điều khiển mọi ánh sáng</h2>
                <p class="section-subtitle">Trải nghiệm công nghệ điều khiển ánh sáng thông minh</p>
            </div>
            
            <div class="controls-grid">
                <!-- Brightness Control -->
                <div class="control-card" data-aos="fade-up">
                    <div class="control-icon">☀️</div>
                    <h3 class="control-title">Độ sáng</h3>
                    <p class="control-desc">Điều chỉnh từ 0-100%</p>
                    <div class="brightness-container">
                        <input type="range" class="brightness-slider" id="brightnessSlider" min="0" max="100" value="75">
                        <span class="brightness-value" id="brightnessValue">75%</span>
                    </div>
                </div>

                <!-- Temperature Control -->
                <div class="control-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="control-icon">🌡️</div>
                    <h3 class="control-title">Nhiệt độ màu</h3>
                    <p class="control-desc">2700K - 6500K</p>
                    <div class="temp-buttons">
                        <button class="temp-btn warm-btn" onclick="setWarmLight()">Ấm</button>
                        <button class="temp-btn cool-btn" onclick="setCoolLight()">Lạnh</button>
                    </div>
                </div>

                <!-- Color Control -->
                <div class="control-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="control-icon">🎨</div>
                    <h3 class="control-title">16 triệu màu</h3>
                    <p class="control-desc">Chạm để chọn màu</p>
                    <div class="color-wheel-container">
                        <div class="color-wheel" id="colorWheel"></div>
                    </div>
                </div>

                <!-- Scene Control -->
                <div class="control-card" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="control-title" style="margin-top: 20px;">Cảnh sẵn có</h3>
                    <p class="control-desc">Chế độ thông minh</p>
                    <select class="scene-select" id="sceneSelect">
                        <option value="default">Mặc định</option>
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
    <section class="products-section" id="products">
        <div class="container">
            <div class="section-header">
                <span class="section-label">SẢN PHẨM</span>
                <h2 class="section-title">Sản phẩm nổi bật</h2>
                <p class="section-subtitle">Khám phá bộ sưu tập đèn thông minh Virical</p>
            </div>
            
            <div class="products-grid">
                <div class="product-card" data-aos="fade-up">
                    <div class="product-image">
                        <div class="product-glow"></div>
                        <div class="product-icon">💡</div>
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

                <div class="product-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="product-image">
                        <div class="product-glow"></div>
                        <div class="product-icon">🏮</div>
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

                <div class="product-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-image">
                        <div class="product-glow"></div>
                        <div class="product-icon">🔦</div>
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

                <div class="product-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="product-image">
                        <div class="product-glow"></div>
                        <div class="product-icon">🌟</div>
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
    <section class="tech-section" id="tech">
        <div class="container">
            <div class="section-header">
                <span class="section-label">CÔNG NGHỆ</span>
                <h2 class="section-title">Công nghệ tiên tiến</h2>
                <p class="section-subtitle">Những tính năng làm nên sự khác biệt</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item" data-aos="zoom-in">
                    <div class="tech-icon">📱</div>
                    <h3 class="tech-name">App Control</h3>
                    <p class="tech-desc">Điều khiển mọi lúc mọi nơi qua smartphone</p>
                </div>
                
                <div class="tech-item" data-aos="zoom-in" data-aos-delay="100">
                    <div class="tech-icon">🎤</div>
                    <h3 class="tech-name">Voice Control</h3>
                    <p class="tech-desc">Tương thích Google Home & Alexa</p>
                </div>
                
                <div class="tech-item" data-aos="zoom-in" data-aos-delay="200">
                    <div class="tech-icon">⏰</div>
                    <h3 class="tech-name">Schedule</h3>
                    <p class="tech-desc">Lập lịch tự động bật/tắt thông minh</p>
                </div>
                
                <div class="tech-item" data-aos="zoom-in" data-aos-delay="300">
                    <div class="tech-icon">🎵</div>
                    <h3 class="tech-name">Music Sync</h3>
                    <p class="tech-desc">Đồng bộ ánh sáng với nhạc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="virical-footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h3>VIRICAL</h3>
                <p style="color: var(--text-secondary); line-height: 1.8; margin-top: 16px;">
                    Thương hiệu đèn thông minh hàng đầu Việt Nam. Mang đến giải pháp chiếu sáng hiện đại cho ngôi nhà của bạn.
                </p>
            </div>
            
            <div class="footer-column">
                <h4>Sản phẩm</h4>
                <ul>
                    <li><a href="#">Đèn trần thông minh</a></li>
                    <li><a href="#">Đèn bàn thông minh</a></li>
                    <li><a href="#">Đèn tường RGB</a></li>
                    <li><a href="#">Đèn ngoài trời</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Hỗ trợ</h4>
                <ul>
                    <li><a href="#">Hướng dẫn sử dụng</a></li>
                    <li><a href="#">Cài đặt app</a></li>
                    <li><a href="#">Bảo hành</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Liên hệ</h4>
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

    <!-- Light Controller -->
    <div class="light-controller" id="lightController">
        <span style="font-size: 2rem;">💡</span>
    </div>

    <!-- Scripts -->
    <script>
        // Loader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden');
            }, 500);
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Hero canvas animation
        const canvas = document.getElementById('heroCanvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        const particleCount = 50;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 3 + 1;
                this.speedX = Math.random() * 2 - 1;
                this.speedY = Math.random() * 2 - 1;
                this.opacity = Math.random() * 0.5 + 0.2;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x > canvas.width || this.x < 0) this.speedX = -this.speedX;
                if (this.y > canvas.height || this.y < 0) this.speedY = -this.speedY;
            }

            draw() {
                ctx.fillStyle = `rgba(102, 126, 234, ${this.opacity})`;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function initParticles() {
            for (let i = 0; i < particleCount; i++) {
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

        initParticles();
        animateParticles();

        // Resize canvas
        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        // Floating particles
        function createFloatingParticles() {
            const container = document.getElementById('particles');
            
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (Math.random() * 20 + 20) + 's';
                
                particle.animate([
                    { transform: 'translate(0, 0) scale(0)', opacity: 0 },
                    { transform: `translate(${Math.random() * 200 - 100}px, ${Math.random() * 200 - 100}px) scale(1)`, opacity: 1 },
                    { transform: `translate(${Math.random() * 400 - 200}px, ${Math.random() * 400 - 200}px) scale(0)`, opacity: 0 }
                ], {
                    duration: (Math.random() * 20 + 20) * 1000,
                    iterations: Infinity
                });
                
                container.appendChild(particle);
            }
        }

        createFloatingParticles();

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

        // Color wheel interaction
        const colorWheel = document.getElementById('colorWheel');
        let isColorWheelActive = false;

        colorWheel.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const x = e.clientX - rect.left - centerX;
            const y = e.clientY - rect.top - centerY;
            
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
        let partyInterval;
        function startPartyMode() {
            let hue = 0;
            clearInterval(partyInterval);
            partyInterval = setInterval(() => {
                hue = (hue + 10) % 360;
                document.body.style.filter = `hue-rotate(${hue}deg) brightness(1.1) saturate(1.5)`;
                lightOverlay.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.2) 0%, transparent 70%)`;
                lightOverlay.style.opacity = '0.4';
            }, 100);
            
            setTimeout(() => {
                clearInterval(partyInterval);
                document.body.style.filter = 'none';
                lightOverlay.style.opacity = '0';
                sceneSelect.value = 'default';
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
                    target.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements with data-aos attribute
        document.querySelectorAll('[data-aos]').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            observer.observe(el);
        });
    </script>
</body>
</html>

<?php wp_footer(); ?>