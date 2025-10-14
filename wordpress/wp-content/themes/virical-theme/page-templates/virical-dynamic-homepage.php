<?php
/**
 * Template Name: Virical Dynamic Homepage
 * Description: Homepage with powerful scroll effects and dynamic animations
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
            background: #ffffff !important;
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
            background: #ffffff;
        }

        /* Scroll progress indicator */
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
            z-index: 1001;
            transition: width 0.3s ease;
        }

        /* Header */
        .virical-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background: rgba(255, 255, 255, 0);
            backdrop-filter: blur(0px);
            z-index: 1000;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .virical-header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
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
            font-weight: 700;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
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
            color: #2d3748;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 8px;
            position: relative;
        }

        .main-nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .main-nav a:hover::after {
            width: 80%;
        }

        .main-nav a:hover {
            color: #667eea;
        }

        /* Main content */
        .virical-main {
            min-height: 100vh;
        }

        /* Hero Section with Parallax */
        .hero-section {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #ffffff 0%, #f7fafc 50%, #eef2ff 100%);
        }

        /* Dynamic background shapes */
        .hero-bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.5;
            animation: morphing 20s ease-in-out infinite;
        }

        .shape1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            top: -200px;
            right: -200px;
            animation-delay: 0s;
        }

        .shape2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            bottom: -100px;
            left: -100px;
            animation-delay: 5s;
        }

        .shape3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 10s;
        }

        @keyframes morphing {
            0%, 100% {
                border-radius: 50%;
                transform: rotate(0deg) scale(1);
            }
            25% {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                transform: rotate(90deg) scale(1.1);
            }
            50% {
                border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%;
                transform: rotate(180deg) scale(0.9);
            }
            75% {
                border-radius: 30% 70% 70% 30% / 70% 30% 30% 70%;
                transform: rotate(270deg) scale(1.05);
            }
        }

        .hero-content {
            text-align: center;
            z-index: 10;
            max-width: 800px;
            padding: 0 20px;
            transform: translateY(0);
            transition: transform 0.5s ease;
        }

        .hero-title {
            font-size: 5rem;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2, #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
            transform: scale(1);
            transition: transform 0.3s ease;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: #4a5568;
            margin-bottom: 40px;
            font-weight: 400;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.3s forwards;
        }

        .cta-button {
            display: inline-block;
            padding: 18px 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            transform: translateY(0);
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.6s forwards;
        }

        .cta-button:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
        }

        /* Scroll indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 50px;
            border: 2px solid #667eea;
            border-radius: 20px;
            opacity: 0;
            animation: fadeIn 1s ease-out 1s forwards;
        }

        .scroll-indicator::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 50%;
            width: 4px;
            height: 10px;
            background: #667eea;
            border-radius: 2px;
            transform: translateX(-50%);
            animation: scrollWheel 2s ease-out infinite;
        }

        @keyframes scrollWheel {
            0% { transform: translateX(-50%) translateY(0); opacity: 1; }
            100% { transform: translateX(-50%) translateY(20px); opacity: 0; }
        }

        /* Control Section with Reveal Effects */
        .control-section {
            padding: 120px 0;
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .control-section::before {
            content: '';
            position: absolute;
            top: -100px;
            left: 0;
            right: 0;
            height: 200px;
            background: linear-gradient(to bottom, #f7fafc, transparent);
            z-index: 1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .section-header {
            text-align: center;
            margin-bottom: 80px;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .section-header.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .section-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #1a1a1a, #4a5568);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #4a5568;
            font-weight: 400;
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .control-card {
            background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            opacity: 0;
            transform: translateY(50px);
            overflow: hidden;
            position: relative;
            isolation: isolate;
        }

        .control-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
            z-index: -1;
        }

        .control-card:hover::before {
            opacity: 1;
        }

        .control-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .control-card.visible:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.2);
        }

        .control-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
            display: inline-block;
        }

        .control-title {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #1a1a1a;
            font-weight: 700;
        }

        /* Interactive controls with animations */
        .brightness-slider {
            width: 100%;
            height: 10px;
            background: #e2e8f0;
            border-radius: 5px;
            outline: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 20px 0;
            cursor: pointer;
        }

        .brightness-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 28px;
            height: 28px;
            background: #667eea;
            border: 3px solid #ffffff;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .brightness-slider::-moz-range-thumb {
            width: 28px;
            height: 28px;
            background: #667eea;
            border: 3px solid #ffffff;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .brightness-value {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transform: scale(1);
            transition: transform 0.3s ease;
        }

        .temp-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        .temp-btn {
            padding: 14px 36px;
            border: none;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
        }

        .warm-btn {
            background: linear-gradient(135deg, #ff9a56, #ff6a00);
        }

        .cool-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .temp-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .temp-btn:active {
            transform: translateY(-2px) scale(1.02);
        }

        .color-wheel {
            width: 140px;
            height: 140px;
            margin: 20px auto;
            border-radius: 50%;
            background: conic-gradient(red, yellow, lime, cyan, blue, magenta, red);
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: 5px solid #fff;
            position: relative;
        }

        .color-wheel:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        /* Radio Button Grid Scene Selector */
        .scene-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
            gap: 10px;
            margin-top: 16px;
        }
        
        .scene-radio {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 12px 8px;
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        
        /* Custom Radio Button Circle */
        .scene-radio::after {
            content: '';
            position: absolute;
            top: 8px;
            right: 8px;
            width: 16px;
            height: 16px;
            border: 2px solid #cbd5e0;
            border-radius: 50%;
            background: white;
            transition: all 0.3s ease;
        }
        
        .scene-radio.selected::after {
            border-color: #667eea;
            background: #667eea;
            box-shadow: inset 0 0 0 3px white;
        }
        
        .scene-radio::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
        }
        
        .scene-radio:hover {
            border-color: #cbd5e0;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        }
        
        .scene-radio.selected {
            background: #eef2ff;
            border-color: #667eea;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.15);
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
            font-size: 22px;
            margin-bottom: 6px;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .scene-radio:hover .scene-icon {
            transform: scale(1.08);
        }
        
        .scene-radio.selected .scene-icon {
            transform: scale(1.1);
        }
        
        .scene-radio .scene-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 2px;
            position: relative;
            z-index: 1;
        }
        
        .scene-radio.selected .scene-name {
            color: #667eea;
        }
        
        .scene-radio .scene-desc {
            font-size: 0.7rem;
            color: #718096;
            text-align: center;
            line-height: 1.2;
            position: relative;
            z-index: 1;
        }
        
        .scene-radio.selected .scene-desc {
            color: #5a67d8;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .scene-selector {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                gap: 8px;
            }
            
            .scene-radio {
                padding: 10px 6px;
            }
            
            .scene-radio::after {
                width: 14px;
                height: 14px;
                top: 6px;
                right: 6px;
            }
            
            .scene-radio .scene-icon {
                font-size: 20px;
            }
            
            .scene-radio .scene-name {
                font-size: 0.8rem;
            }
            
            .scene-radio .scene-desc {
                font-size: 0.65rem;
            }
        }

        /* Products Section with 3D Cards */
        .products-section {
            padding: 120px 0;
            background: linear-gradient(180deg, #ffffff 0%, #f7fafc 50%, #eef2ff 100%);
            position: relative;
            overflow: hidden;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            perspective: 1000px;
        }

        .product-card {
            cursor: pointer;
            background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            opacity: 0;
            transform: translateY(50px) rotateX(-10deg);
            transform-style: preserve-3d;
        }

        .product-card.visible {
            opacity: 1;
            transform: translateY(0) rotateX(0);
        }

        .product-card:hover {
            transform: translateY(-15px) rotateX(5deg) scale(1.02);
            box-shadow: 0 30px 60px rgba(102, 126, 234, 0.25);
        }

        .product-image {
            height: 280px;
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            position: relative;
            overflow: hidden;
        }

        .product-image::before {
            content: '';
            position: absolute;
            top: -100%;
            left: -100%;
            width: 300%;
            height: 300%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
        }

        .product-card:hover .product-image::before {
            top: -50%;
            left: -50%;
        }

        .product-info {
            padding: 35px;
        }

        .product-name {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #1a1a1a;
            font-weight: 700;
        }

        .product-desc {
            color: #4a5568;
            margin-bottom: 25px;
            font-size: 1rem;
            line-height: 1.6;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-btn {
            padding: 12px 28px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 30px;
            color: #fff;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            transform: translateX(0);
        }

        .product-btn:hover {
            transform: translateX(5px) scale(1.05);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        /* Tech Section with Floating Elements */
        .tech-section {
            padding: 120px 0;
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .tech-bg-element {
            position: absolute;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
        }

        .tech-bg1 {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .tech-bg2 {
            bottom: 10%;
            right: 10%;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 60px;
            margin-top: 80px;
        }

        .tech-item {
            text-align: center;
            padding: 50px 30px;
            transition: all 0.4s ease;
            opacity: 0;
            transform: translateY(30px) scale(0.9);
            position: relative;
        }

        .tech-item.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .tech-item:hover {
            transform: translateY(-10px) scale(1.05);
        }

        .tech-icon {
            font-size: 4rem;
            margin-bottom: 25px;
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
            animation-play-state: paused;
        }

        .tech-item:hover .tech-icon {
            animation-play-state: running;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .tech-name {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .tech-desc {
            color: #4a5568;
            line-height: 1.6;
            font-size: 1rem;
        }

        /* Footer with Gradient */
        .virical-footer {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: #fff;
            padding: 80px 0 40px;
            position: relative;
            overflow: hidden;
        }

        .footer-wave {
            position: absolute;
            top: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 100'%3E%3Cpath fill='%23ffffff' d='M0,50 C360,100 720,0 1440,50 L1440,0 L0,0 Z'%3E%3C/path%3E%3C/svg%3E") no-repeat;
            background-size: cover;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            margin-bottom: 50px;
            position: relative;
            z-index: 1;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 25px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-column p {
            line-height: 1.8;
            opacity: 0.9;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column li {
            margin-bottom: 15px;
        }

        .footer-column a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 0;
        }

        .footer-column a::before {
            content: '→';
            position: absolute;
            left: -20px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .footer-column a:hover {
            color: #667eea;
            padding-left: 20px;
        }

        .footer-column a:hover::before {
            left: 0;
            opacity: 1;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.9;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }

        /* Light overlay with gradient */
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
            position: fixed !important;
            bottom: 30px !important;
            right: 30px !important;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 9999 !important;
            transform: scale(1);
        }

        .light-controller:hover {
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
            transform: scale(1.1);
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            }
            50% {
                transform: scale(0.95);
                box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            }
        }

        .light-controller:hover {
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
            animation-play-state: paused;
        }

        .light-controller:hover span {
            animation: rotate 0.5s ease-in-out;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .light-controller span {
            font-size: 2rem;
            display: inline-block;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

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
                font-size: 3.5rem;
            }
            
            .section-title {
                font-size: 2.5rem;
            }
            
            .controls-grid,
            .products-grid,
            .footer-content {
                grid-template-columns: 1fr;
            }
            
            .footer-content {
                text-align: center;
            }
            
            .footer-column a::before {
                display: none;
            }
            
            .footer-column a:hover {
                padding-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Main wrapper -->
    <div class="virical-wrapper">
        <!-- Scroll Progress -->
        <div class="scroll-progress" id="scrollProgress"></div>
        
        <!-- Light Overlay -->
        <div class="light-overlay" id="lightOverlay"></div>

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

        <!-- Main content -->
        <main class="virical-main">
            <!-- Hero Section -->
            <section class="hero-section" id="home">
                <div class="hero-bg-shape shape1"></div>
                <div class="hero-bg-shape shape2"></div>
                <div class="hero-bg-shape shape3"></div>
                
                <div class="hero-content">
                    <h1 class="hero-title">VIRICAL</h1>
                    <p class="hero-subtitle">Ánh sáng thông minh cho cuộc sống hiện đại</p>
                    <a href="#products" class="cta-button">Khám phá sản phẩm</a>
                </div>
                
                <div class="scroll-indicator">
                    <span></span>
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
                            <input type="range" class="brightness-slider" id="brightnessSlider" min="0" max="100" value="80">
                            <p class="brightness-value" id="brightnessValue">80%</p>
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
                            <p style="color: #718096; margin-bottom: 20px;">Chế độ thông minh</p>
                            
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
                                    <span class="scene-name">Tiệc tùng</span>
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
                        // Lấy sản phẩm nổi bật từ database
                        global $wpdb;
                        $table_name = $wpdb->prefix . 'virical_products';
                        
                        // Kiểm tra nếu có function thì dùng, không thì query trực tiếp
                        if (function_exists('virical_get_featured_products')) {
                            $products = virical_get_featured_products(4);
                        } else {
                            // Query trực tiếp từ database
                            $products = $wpdb->get_results($wpdb->prepare(
                                "SELECT * FROM $table_name 
                                WHERE is_featured = 1 AND status = 'publish' 
                                ORDER BY created_at DESC 
                                LIMIT %d",
                                4
                            ));
                        }
                        
                        if (!empty($products)):
                            foreach($products as $product): 
                                $features = json_decode($product->features, true) ?: [];
                                $display_price = $product->sale_price && $product->sale_price < $product->price 
                                    ? $product->sale_price 
                                    : $product->price;
                        ?>
                        <div class="product-card" onclick="window.location.href='<?php echo home_url('/?page_id=31&product=' . $product->slug); ?>'" style="cursor: pointer;">
                            <div class="product-image">
                                <?php if ($product->image_url): ?>
                                    <img src="<?php echo esc_url($product->image_url); ?>" 
                                         alt="<?php echo esc_attr($product->name); ?>"
                                         style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">
                                <?php else: ?>
                                    <div style="font-size: 3rem;">💡</div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo esc_html($product->name); ?></h3>
                                <p class="product-desc"><?php echo esc_html($product->short_description); ?></p>
                                <div class="product-footer">
                                    <span class="product-price"><?php echo number_format($display_price); ?>đ</span>
                                    <button class="product-btn" onclick="event.stopPropagation(); window.location.href='<?php echo home_url('/?page_id=31&product=' . $product->slug); ?>'">Xem chi tiết</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; 
                        else: ?>
                        <!-- Hiển thị sản phẩm mẫu nếu chưa có dữ liệu -->
                        <div class="product-card">
                            <div class="product-image">💡</div>
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
                            <div class="product-image">🏮</div>
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
                            <div class="product-image">🔦</div>
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
                            <div class="product-image">🌟</div>
                            <div class="product-info">
                                <h3 class="product-name">Virical Solar Garden Pro</h3>
                                <p class="product-desc">Đèn solar 30W với cảm biến chuyển động</p>
                                <div class="product-footer">
                                    <span class="product-price">2.190.000₫</span>
                                    <button class="product-btn">Xem chi tiết</button>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Tech Section -->
            <section class="tech-section" id="tech">
                <div class="tech-bg-element tech-bg1"></div>
                <div class="tech-bg-element tech-bg2"></div>
                
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
            <div class="footer-wave"></div>
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
                        <?php 
                        $main_office = virical_get_main_office();
                        if ($main_office) {
                            echo '<li><a href="#">📍 ' . esc_html($main_office['address']) . '</a></li>';
                            echo '<li><a href="tel:' . esc_attr($main_office['phone']) . '">📞 ' . esc_html($main_office['phone']) . '</a></li>';
                            echo '<li><a href="mailto:' . esc_attr($main_office['email']) . '">✉️ ' . esc_html($main_office['email']) . '</a></li>';
                        } else {
                            // Fallback if no database data
                            echo '<li><a href="#">📍 Hà Nội, Việt Nam</a></li>';
                            echo '<li><a href="tel:0869995698">📞 0869995698</a></li>';
                            echo '<li><a href="mailto:info@virical.vn">✉️ info@virical.vn</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 VIRICAL. All rights reserved. | Designed with 💡 in Vietnam</p>
            </div>
        </footer>

        <!-- Light Controller Button -->
        <div class="light-controller" id="lightController">
            <span>💡</span>
        </div>
    </div>

    <script>
        // Scroll Progress Bar
        window.addEventListener('scroll', () => {
            const scrollProgress = document.getElementById('scrollProgress');
            const scrollPercent = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            scrollProgress.style.width = scrollPercent + '%';
        });

        // Header scroll effect
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Parallax effect for hero
        const heroContent = document.querySelector('.hero-content');
        const shapes = document.querySelectorAll('.hero-bg-shape');
        
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            
            // Parallax for hero content
            if (heroContent) {
                heroContent.style.transform = `translateY(${scrolled * 0.4}px)`;
            }
            
            // Parallax for shapes
            shapes.forEach((shape, index) => {
                const speed = 0.5 + (index * 0.1);
                shape.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // Dynamic title scaling on scroll
        const heroTitle = document.querySelector('.hero-title');
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const scale = Math.max(0.8, 1 - scrolled * 0.0005);
            if (heroTitle) {
                heroTitle.style.transform = `scale(${scale})`;
            }
        });

        // Global filter state management
        const filterState = {
            brightness: 1.0,
            temperature: 'normal', // 'warm', 'cool', 'normal'
            hue: 0,
            saturation: 1,
            contrast: 1,
            sepia: 0,
            scene: 'default'
        };

        // Combine all filters into a single string
        function combineFilters() {
            let filters = [];
            
            // Brightness
            if (filterState.brightness !== 1.0) {
                filters.push(`brightness(${filterState.brightness})`);
            }
            
            // Temperature
            if (filterState.temperature === 'warm') {
                filters.push('sepia(0.3)');
                filterState.sepia = 0.3;
            } else if (filterState.temperature === 'cool') {
                filters.push('hue-rotate(180deg)');
                filterState.hue = 180;
            }
            
            // Hue from color wheel
            if (filterState.hue !== 0 && filterState.temperature !== 'cool') {
                filters.push(`hue-rotate(${filterState.hue}deg)`);
            }
            
            // Saturation
            if (filterState.saturation !== 1) {
                filters.push(`saturate(${filterState.saturation})`);
            }
            
            // Contrast
            if (filterState.contrast !== 1) {
                filters.push(`contrast(${filterState.contrast})`);
            }
            
            // Sepia (if not from temperature)
            if (filterState.sepia > 0 && filterState.temperature !== 'warm') {
                filters.push(`sepia(${filterState.sepia})`);
            }
            
            return filters.join(' ');
        }

        // Apply combined filters
        function applyFilters() {
            const filterString = combineFilters();
            document.body.style.filter = filterString || 'none';
            document.body.style.transition = 'filter 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
        }

        // Brightness control
        const brightnessSlider = document.getElementById('brightnessSlider');
        const brightnessValue = document.getElementById('brightnessValue');
        const lightOverlay = document.getElementById('lightOverlay');
        
        if (brightnessSlider) {
            // Set initial value
            const initialBrightness = parseInt(brightnessSlider.value);
            brightnessValue.textContent = initialBrightness + '%';
            filterState.brightness = 0.7 + (initialBrightness / 100) * 0.5;
            
            brightnessSlider.addEventListener('input', function() {
                const value = parseInt(this.value);
                brightnessValue.textContent = value + '%';
                
                // Update brightness in filter state
                filterState.brightness = 0.7 + (value / 100) * 0.5;
                applyFilters();
                
                // Update overlay
                if (value < 50) {
                    lightOverlay.style.opacity = (50 - value) / 100;
                    lightOverlay.style.background = `radial-gradient(ellipse at center, rgba(0, 0, 0, ${(50 - value) / 50}) 0%, transparent 70%)`;
                } else {
                    lightOverlay.style.opacity = 0;
                }
            });
        }

        // Temperature control - properly bind functions
        window.setWarmLight = function() {
            filterState.temperature = 'warm';
            filterState.brightness = 1.1;
            filterState.saturation = 1.2;
            applyFilters();
            
            lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(255, 152, 0, 0.15) 0%, transparent 70%)';
            lightOverlay.style.opacity = '0.2';
        };
        
        window.setCoolLight = function() {
            filterState.temperature = 'cool';
            filterState.brightness = 1.1;
            filterState.saturation = 1.3;
            applyFilters();
            
            lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(33, 150, 243, 0.15) 0%, transparent 70%)';
            lightOverlay.style.opacity = '0.2';
        };

        function animateColorChange() {
            document.body.style.transition = 'filter 1s cubic-bezier(0.4, 0, 0.2, 1)';
            setTimeout(() => {
                document.body.style.transition = '';
            }, 1000);
        }

        // Color wheel
        const colorWheel = document.getElementById('colorWheel');
        if (colorWheel) {
            colorWheel.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                const angle = Math.atan2(y, x);
                const hue = ((angle * 180 / Math.PI) + 360) % 360;
                
                filterState.hue = hue;
                filterState.saturation = 1.2;
                filterState.brightness = 1.1;
                filterState.temperature = 'normal'; // Reset temperature
                applyFilters();
                
                lightOverlay.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.15) 0%, transparent 70%)`;
                lightOverlay.style.opacity = '0.2';
                
                // Create ripple effect
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.left = e.offsetX + 'px';
                ripple.style.top = e.offsetY + 'px';
                ripple.style.width = '20px';
                ripple.style.height = '20px';
                ripple.style.background = `hsla(${hue}, 70%, 50%, 0.5)`;
                ripple.style.borderRadius = '50%';
                ripple.style.transform = 'translate(-50%, -50%)';
                ripple.style.animation = 'ripple 0.6s ease-out';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        }

        // Scene Selector Radio Button Functions
        window.selectScene = function(input) {
            const scene = input.value;
            
            // Update UI - remove selected class from all, add to current
            document.querySelectorAll('.scene-radio').forEach(radio => {
                radio.classList.remove('selected');
            });
            input.parentElement.classList.add('selected');
            
            // Apply scene
            filterState.scene = scene;
            
            switch(scene) {
                    case 'default':
                        filterState.brightness = 1;
                        filterState.contrast = 1;
                        filterState.saturation = 1;
                        filterState.sepia = 0;
                        filterState.hue = 0;
                        filterState.temperature = 'normal';
                        lightOverlay.style.opacity = '0';
                        break;
                    case 'reading':
                        filterState.brightness = 1.3;
                        filterState.contrast = 1.1;
                        filterState.saturation = 0.9;
                        lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(255, 255, 255, 0.1) 0%, transparent 70%)';
                        lightOverlay.style.opacity = '0.2';
                        break;
                    case 'movie':
                        filterState.brightness = 0.7;
                        filterState.contrast = 1.3;
                        filterState.saturation = 1.2;
                        lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(0, 0, 0, 0.4) 0%, transparent 70%)';
                        lightOverlay.style.opacity = '0.5';
                        break;
                    case 'party':
                        startPartyMode();
                        return; // Party mode handles its own filters
                    case 'relax':
                        filterState.brightness = 1.05;
                        filterState.sepia = 0.2;
                        filterState.saturation = 1.1;
                        lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(255, 193, 7, 0.2) 0%, transparent 70%)';
                        lightOverlay.style.opacity = '0.25';
                        break;
                    case 'sleep':
                        filterState.brightness = 0.6;
                        filterState.sepia = 0.1;
                        filterState.contrast = 0.9;
                        lightOverlay.style.background = 'radial-gradient(ellipse at center, rgba(0, 0, 0, 0.6) 0%, transparent 70%)';
                        lightOverlay.style.opacity = '0.7';
                        break;
                }
                
                applyFilters();
        };

        // Party mode function
        function startPartyMode() {
            let hue = 0;
            let saturation = 1;
            const partyInterval = setInterval(() => {
                hue = (hue + 15) % 360;
                saturation = 1 + Math.sin(hue * Math.PI / 180) * 0.5;
                
                filterState.hue = hue;
                filterState.brightness = 1.2;
                filterState.saturation = saturation;
                applyFilters();
                
                lightOverlay.style.background = `radial-gradient(ellipse at center, hsla(${hue}, 70%, 50%, 0.3) 0%, transparent 70%)`;
                lightOverlay.style.opacity = '0.4';
            }, 100);
            
            setTimeout(() => {
                clearInterval(partyInterval);
                filterState.brightness = 1;
                filterState.hue = 0;
                filterState.saturation = 1;
                applyFilters();
                lightOverlay.style.opacity = '0';
            }, 10000);
        }

        // Light controller button - fixed position
        const lightController = document.getElementById('lightController');
        let lightMode = 0;
        
        if (lightController) {
            // Remove all animations and ensure fixed position
            lightController.style.animation = 'none';
            lightController.style.position = 'fixed';
            lightController.style.bottom = '30px';
            lightController.style.right = '30px';
            lightController.style.transform = 'scale(1)';
            lightController.style.zIndex = '9999';
            
            lightController.addEventListener('click', function() {
                lightMode = (lightMode + 1) % 6;
                
                // Simple scale animation only
                this.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
                
                // Reset filter state for light modes
                filterState.temperature = 'normal';
                filterState.sepia = 0;
                filterState.hue = 0;
                
                switch(lightMode) {
                    case 0:
                        filterState.brightness = 1;
                        filterState.contrast = 1;
                        filterState.saturation = 1;
                        lightOverlay.style.opacity = '0';
                        break;
                    case 1:
                        filterState.brightness = 1.3;
                        filterState.contrast = 1.1;
                        lightOverlay.style.opacity = '0';
                        break;
                    case 2:
                        filterState.brightness = 0.8;
                        filterState.contrast = 1.2;
                        lightOverlay.style.opacity = '0.3';
                        break;
                    case 3:
                        filterState.sepia = 0.3;
                        filterState.brightness = 1.1;
                        filterState.saturation = 1.2;
                        lightOverlay.style.opacity = '0.2';
                        break;
                    case 4:
                        filterState.hue = 60;
                        filterState.brightness = 1.1;
                        filterState.saturation = 1.3;
                        lightOverlay.style.opacity = '0.15';
                        break;
                    case 5:
                        filterState.hue = -60;
                        filterState.brightness = 1.05;
                        filterState.contrast = 1.1;
                        lightOverlay.style.opacity = '0.2';
                        break;
                }
                
                applyFilters();
            });
            
            // Ensure button stays in place
            setInterval(() => {
                if (lightController.style.bottom !== '30px' || lightController.style.right !== '30px') {
                    lightController.style.bottom = '30px';
                    lightController.style.right = '30px';
                    lightController.style.position = 'fixed';
                    lightController.style.transform = 'scale(1)';
                }
            }, 100);
        }

        // Smooth scroll with easing
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const targetPos = target.offsetTop;
                    const startPos = window.pageYOffset;
                    const distance = targetPos - startPos;
                    const duration = 1000;
                    let start = null;
                    
                    function animation(currentTime) {
                        if (start === null) start = currentTime;
                        const timeElapsed = currentTime - start;
                        const run = ease(timeElapsed, startPos, distance, duration);
                        window.scrollTo(0, run);
                        if (timeElapsed < duration) requestAnimationFrame(animation);
                    }
                    
                    function ease(t, b, c, d) {
                        t /= d / 2;
                        if (t < 1) return c / 2 * t * t + b;
                        t--;
                        return -c / 2 * (t * (t - 2) - 1) + b;
                    }
                    
                    requestAnimationFrame(animation);
                }
            });
        });

        // Advanced Intersection Observer with stagger
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                        
                        // Add fade up animation for control cards
                        if (entry.target.classList.contains('control-card')) {
                            entry.target.style.animation = 'fadeInUp 0.8s ease-out';
                        }
                        
                        // Add 3D flip for product cards
                        if (entry.target.classList.contains('product-card')) {
                            entry.target.style.animation = 'flipIn 0.8s ease-out';
                        }
                    }, index * 150);
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('.section-header, .control-card, .product-card, .tech-item').forEach(el => {
            observer.observe(el);
        });

        // Mouse move parallax for tech section
        const techSection = document.querySelector('.tech-section');
        const techBgElements = document.querySelectorAll('.tech-bg-element');

        techSection.addEventListener('mousemove', (e) => {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            techBgElements.forEach((element, index) => {
                const speed = 50 + (index * 20);
                const xPos = (x - 0.5) * speed;
                const yPos = (y - 0.5) * speed;
                element.style.transform = `translate(${xPos}px, ${yPos}px)`;
            });
        });

        // Loading animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            setTimeout(() => {
                document.body.style.transition = 'opacity 1s ease';
                document.body.style.opacity = '1';
                
                // Trigger hero animations
                document.querySelector('.hero-title').style.animation = 'fadeInUp 1s ease-out, gradientShift 3s ease infinite';
            }, 100);
        });

        // Add ripple animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    width: 100px;
                    height: 100px;
                    opacity: 0;
                }
            }
            
            @keyframes bounce {
                0% { transform: translateY(50px) scale(0.9); }
                50% { transform: translateY(-20px) scale(1.05); }
                100% { transform: translateY(0) scale(1); }
            }
            
            @keyframes flipIn {
                0% { transform: translateY(50px) rotateX(-90deg); opacity: 0; }
                100% { transform: translateY(0) rotateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        
        // Quick buy function
        function quickBuy(productId) {
            if (confirm('Thêm sản phẩm vào giỏ hàng?')) {
                // TODO: Implement cart functionality
                alert('Đã thêm sản phẩm vào giỏ hàng!');
            }
        }
    </script>

    <?php wp_footer(); ?>
</body>
</html>