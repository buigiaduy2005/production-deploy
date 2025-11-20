<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Google Font - Quicksand & Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
    // Remove duplicate menus on page load - SAFER VERSION
    document.addEventListener('DOMContentLoaded', function() {
        // Only remove WordPress default menus, keep our custom menu
        const wpMenus = document.querySelectorAll('#menu-primary-menu, .menu-primary-menu-container');
        wpMenus.forEach(function(menu) {
            console.log('Removing WordPress default menu');
            menu.remove();
        });
        
        // Debug: Check if our menu exists
        const navContainer = document.querySelector('.main-navigation');
        const ourMenu = navContainer ? navContainer.querySelector('ul.main-nav') : null;
        console.log('Navigation container:', navContainer);
        console.log('Our menu:', ourMenu);
        
        if (navContainer && !ourMenu) {
            console.error('MENU ERROR: Navigation container exists but no menu found!');
        }
    });
    </script>
    
    <?php
    wp_head();

    // Load custom menu renderer
    require_once get_template_directory() . '/includes/virical-menu-render-fixed.php';
    ?>

    <style>
        /* Header Styles for Virical Design */
        body {
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .site-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: transparent;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            height: 80px;
            border-bottom: none;
        }
        
        .site-header.scrolled {
            background: rgba(255,255,255,0.98);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .site-header.product-page-header {
            background-color: #D3D3D3 !important;
        }
        
        /* Compressed header for project pages */
        body.project-nav-fixed .site-header {
            background: rgba(255,255,255,0.98) !important;
        }
        
        .header-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 5px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: padding 0.3s ease;
            height: 80px;
            width: 100%;
            gap: 40px;
        }
        
        /* Compressed header state */
        .site-header.compressed .header-container {
            padding: 8px 60px;
            height: 70px;
        }
        
        .site-logo {
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .logo-text {
            font-size: 24px;
            letter-spacing: 3px;
            color: #fff;
            font-weight: 700;
            display: block;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
            text-align: center;
        }
        
        .logo-tagline {
            font-size: 10px;
            letter-spacing: 1.5px;
            color: #fff;
            display: block;
            margin-top: 1px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
            text-align: center;
            opacity: 0.95;
        }
        
        .site-header.scrolled .logo-text {
            color: #000;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .site-header.scrolled .logo-tagline {
            display: none;
        }
        
        @media (min-width: 769px) {
            .main-navigation {
                display: flex !important;
                align-items: center !important;
                justify-content: flex-end !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                z-index: 999 !important;
                flex: 1 1 auto;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
        
        .main-navigation {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            flex: 1 1 auto;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .main-navigation ul {
            display: flex;
            list-style: none !important;
            gap: 35px !important;
            margin: 0 !important;
            padding: 0 !important;
            visibility: visible !important;
            opacity: 1 !important;
            flex-direction: row !important;
            align-items: center !important;
        }
        
        .main-navigation li {
            display: inline-flex !important;
            align-items: center !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
        }
        
        .main-navigation a {
            color: #ffffff; /* White by default for transparent header */
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: color 0.3s ease, transform 0.2s ease;
            text-transform: uppercase;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5); /* Add shadow for readability */
            position: relative;
            padding: 5px 0;
        }
        
        .main-navigation a:hover {
            color: #ffffff;
            transform: translateY(-1px);
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        
        .main-navigation a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #ffffff;
            transition: width 0.3s ease;
        }
        
        .main-navigation a:hover::after {
            width: 100%;
        }
        
        .site-header.scrolled .main-navigation a {
            color: #000000; /* Black on scrolled header */
            text-shadow: none;
            font-weight: 700;
        }
        
        .site-header.scrolled .main-navigation a:hover {
            color: #000000;
            text-shadow: none;
        }
        
        .site-header.scrolled .main-navigation a::after {
            background-color: #000000;
        }

        /* Force hide any duplicate menus */
        .main-navigation ul.main-nav ~ ul.main-nav {
            display: none !important;
        }
        
        /* Hide WordPress default menu if it appears */
        #menu-primary-menu {
            display: none !important;
        }
        
        /* DEBUG: Force show menu items */
        .main-navigation ul.main-nav {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .main-navigation ul.main-nav li {
            display: inline-flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .main-navigation ul.main-nav li a {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Dropdown base */
        .main-navigation .menu-item {
            position: relative;
        }

        .main-navigation .dropdown-content {
            position: absolute;
            top: 100%; /* Directly below the main menu item */
            left: 0; /* Align to left edge */
            right: 0; /* Align to right edge */
            width: 100%; /* Full width */
            max-width: 100%; /* Ensure full width */
            padding: 20px;
            background: rgba(255,255,255,0.98);
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(15,23,42,0.18);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, transform 0.25s ease;
            z-index: 900;
            display: flex; /* Ensure it's a flex container for horizontal items */
            flex-wrap: wrap; /* Allow items to wrap */
            justify-content: center; /* Center items within the dropdown */
            gap: 20px; /* Add gap between items */
        }

        .main-navigation .menu-item-has-children:hover .dropdown-content {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0); /* No horizontal transform needed */
        }

        .main-navigation .dropdown-content a {
            color: #111827;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 0;
            text-transform: none;
            text-shadow: none;
        }

        .main-navigation .dropdown-content a:hover {
            color: #c58f00;
        }

        .dropdown-item {
            display: flex;
            flex-direction: column !important;
            align-items: center;
            text-align: center;
            text-decoration: none;
        }

        .dropdown-item img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }

        .dropdown-item span {
            color: #333;
        }

        /* Product mega menu */
        .menu-item-products {
            position: relative; /* Keep it relative */
            border-bottom: 20px solid transparent;
            margin-bottom: -20px;
        }

        .menu-item-products > a {
            position: relative;
            z-index: 1200; /* Higher than the mega menu's z-index */
        }
        
        .menu-item-products .product-mega-menu {
            position: fixed !important;
            top: 80px !important; /* Align just below the 80px header */
            left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 32px 40px 36px !important;
            background: rgba(255,255,255,0.97) !important;
            border-radius: 0 !important;
            box-shadow: 0 25px 50px rgba(15,23,42,0.12) !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transition: opacity 0.25s ease, visibility 0.25s ease !important;
            display: block !important;
            z-index: 1100 !important;
        }

        .menu-item-products .product-mega-inner {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 40px;
            align-items: start;
            justify-items: stretch;
            width: 100%;
        }
        
        .menu-item-products .product-mega-featured {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 100%;
            width: 100%;
        }

        .menu-item-products .product-mega-categories {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 20px;
            width: 100%;
            max-height: 300px;
        }
        
        .menu-item-products .product-mega-item {
            display: flex !important;
            flex-direction: column !important;
            align-items: center;
            text-align: center;
            padding: 10px; /* Reduced padding */
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
        }
        
        .menu-item-products .product-mega-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .menu-item-products .product-mega-item img {
            width: 40px; /* Reduced image size */
            height: 40px; /* Reduced image size */
            object-fit: contain;
            margin-bottom: 5px; /* Adjusted margin */
        }
        
        .menu-item-products .product-mega-item-name {
            font-size: 10px; /* Reduced font size */
            font-weight: 500;
            color: #333;
            line-height: 1.2; /* Adjusted line height */
        }

        /* Mobile product category list (text-only) */
        .product-mobile-categories {
            display: none;
            list-style: none;
            margin: 8px 0 0;
            padding: 0;
        }

        .product-mobile-header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 0 12px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 8px;
        }

        .product-mobile-back {
            border: none;
            background: none;
            padding: 0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .product-mobile-back::before {
            content: '\2039'; /* single left angle */
            font-size: 20px;
            line-height: 1;
        }

        .product-mobile-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
        }

        .product-mobile-category-item a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            font-size: 14px;
            font-weight: 500;
            color: #111827;
            text-decoration: none;
        }

        .product-mobile-category-item a::after {
            content: '\203A'; /* single right angle */
            font-size: 16px;
        }

        .product-mobile-category-item a:hover {
            color: #000;
        }

        .menu-item-products:hover .product-mega-menu {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
        }

        .menu-item-products .mega-column-header {
            margin-bottom: 12px;
        }

        .menu-item-products .mega-column-title {
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #1f2937;
            display: inline-block;
            position: relative;
        }

        .menu-item-products .mega-column-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 28px;
            height: 2px;
            background: #c58f00;
            border-radius: 999px;
        }

        .menu-item-products .mega-column-list {
            list-style: none;
            margin: 20px 0 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu-item-products .mega-column-item a {
            font-size: 14px;
            color: #374151;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .menu-item-products .product-mega-badge {
            display: inline-block;
            margin-left: 10px;
            padding: 2px 8px;
            border-radius: 999px;
            background: rgba(197,143,0,0.12);
            color: #ad7f00;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .menu-item-products .mega-column-item a:hover {
            color: #c58f00;
        }

        .menu-item-products .mega-column-item-tag {
            font-size: 11px;
            font-weight: 700;
            color: #c58f00;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .menu-item-products .product-mega-menu::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 0;
            border: 1px solid rgba(199,150,0,0.08);
            border-top: none;
            pointer-events: none;
        }

        .menu-item-products .product-mega-featured {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .menu-item-products .product-mega-featured-header {
            display: block;
            margin-bottom: 4px;
        }

        .menu-item-products .product-mega-featured-title {
            display: block;
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .menu-item-products .product-mega-featured-link {
            font-size: 13px;
            font-weight: 600;
            color: #c58f00;
            text-decoration: none;
        }

        .menu-item-products .product-mega-featured-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            width: 100%;
        }

        .menu-item-products .product-mega-featured-item {
            background: rgba(248,250,252,0.9);
            border-radius: 16px;
            border: 1px solid rgba(148,163,184,0.2);
            overflow: hidden;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 16px 18px;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .menu-item-products .product-mega-featured-item:hover {
            transform: translateY(-4px);
            border-color: #d4af37;
        }

        .menu-item-products .product-mega-featured-thumb {
            width: 100%;
            height: 120px;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-item-products .product-mega-featured-thumb img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .menu-item-products .product-mega-featured-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu-item-products .product-mega-featured-name {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .menu-item-products .product-mega-featured-desc {
            font-size: 12px;
            color: #4b5563;
            margin: 0;
            line-height: 1.45;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
        }
        
        .menu-toggle-icon {
            display: block;
            width: 25px;
            height: 20px;
            position: relative;
        }
        
        .menu-toggle-icon span {
            display: block;
            width: 100%;
            height: 2px;
            background: #fff;
            position: absolute;
            left: 0;
            transition: all 0.3s;
        }
        
        .site-header.scrolled .menu-toggle-icon span {
            background: #000;
        }
        
        .menu-toggle-icon span:nth-child(1) {
            top: 0;
        }
        
        .menu-toggle-icon span:nth-child(2) {
            top: 50%;
            transform: translateY(-50%);
        }
        
        .menu-toggle-icon span:nth-child(3) {
            bottom: 0;
        }
        
        @media (max-width: 1400px) {
            .menu-item-products .product-mega-menu {
                max-width: 1280px;
                padding: 28px 32px 34px;
            }
            .menu-item-products .product-mega-inner {
                grid-template-columns: minmax(0, 1fr) 260px;
                gap: 36px;
            }
            .menu-item-products .product-mega-categories {
                grid-template-columns: repeat(4, minmax(180px, 1fr));
            }
        }

        @media (max-width: 1200px) {
            .menu-item-products .product-mega-menu {
                max-width: 100%;
                padding: 26px 28px 32px;
            }
            .menu-item-products .product-mega-inner {
                grid-template-columns: minmax(0, 1fr) 240px;
                gap: 28px;
            }
            .menu-item-products .product-mega-categories {
                grid-template-columns: repeat(3, minmax(180px, 1fr));
                gap: 20px 24px;
            }
            .menu-item-products .product-mega-featured-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 15px 20px;
                gap: 15px;
            }
            
            .main-navigation {
                display: none !important;
                position: fixed !important;
                top: 80px !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                background: #ffffff !important;
                padding: 20px 24px !important;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
                max-height: calc(100vh - 80px) !important;
                overflow-y: auto !important;
                -ms-overflow-style: none !important;
                scrollbar-width: none !important;
                z-index: 998 !important;
                flex: none !important;
                justify-content: flex-start !important;
            }

            .main-navigation::-webkit-scrollbar {
                width: 0;
                height: 0;
            }
            
            .main-navigation.active {
                display: block !important;
            }
            
            .main-navigation ul {
                flex-direction: column !important;
                align-items: flex-start;
                gap: 10px;
                padding: 0;
            }

            .main-navigation li {
                justify-content: flex-start;
            }

            .main-navigation a {
                color: #111827;
                text-shadow: none;
                font-size: 14px;
                padding: 8px 0;
                text-align: left;
                width: 100%;
            }
            
            .main-navigation .sub-menu {
                position: relative;
                top: auto;
                left: auto;
                width: 100%;
                display: none;
                box-shadow: none;
                border-top: none;
                padding: 0;
                margin-top: 10px;
                background: #ffffff;
            }
            

            .menu-toggle {
                display: block;
            }
            
            .logo-text {
                font-size: 20px;
            }

            .menu-toggle-icon span {
                background: #000;
            }

            /* Hide product mega dropdown on small screens so only main buttons show */
            .menu-item-products .product-mega-menu {
                display: none !important;
            }

            /* Products mobile categories as separate panel */
            .product-mobile-categories {
                display: none;
            }

            .main-navigation.products-panel-open ul.main-nav {
                position: relative;
            }

            .main-navigation.products-panel-open > ul.main-nav > li {
                display: none;
            }

            .main-navigation.products-panel-open > ul.main-nav > li.menu-item-products {
                display: block;
            }

            .main-navigation.products-panel-open .product-mobile-categories.active {
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: #ffffff;
                padding: 12px 4px 12px 0;
                overflow-y: auto;
            }
        }

        @media (max-width: 1024px) {
            .menu-item-products .product-mega-menu {
                position: static !important;
                top: auto !important;
                left: auto !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 24px 20px;
                border-radius: 20px;
                box-shadow: none;
                background: rgba(255,255,255,0.92);
                transform: none;
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }

            .menu-item-products .product-mega-inner {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .menu-item-products .product-mega-categories {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 24px;
            }

            .menu-item-products .product-mega-featured {
                padding: 0;
            }

            .menu-item-products .product-mega-featured-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            }

            .menu-item-products .product-mega-menu::before {
                display: none;
            }

            .menu-item-products .mega-column-title {
                font-size: 14px;
            }

            .menu-item-products .mega-column-list {
                margin-top: 12px;
            }
        }
    /* Ensure logo image stays inside header and properly sized */
        .site-logo { display: flex; flex-direction: column; align-items: flex-start; gap: 4px; text-align: left; }
        .site-logo .logo-image img { height: 80px; width: auto; display: block; }
        .site-header.compressed .site-logo .logo-image img { height: 70px; }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header <?php if (is_post_type_archive('product') || is_page('san-pham')) echo 'product-page-header'; ?>" id="site-header">
    <div class="header-container">
        <a href="<?php echo home_url('/'); ?>" class="site-logo">
            <div class="logo-image"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logoVirical.svg" alt="Virical Logo" /></div>
            <div class="logo-tagline">Feeling Light</div>
        </a>
        <nav class="main-navigation">
            <?php
            // DEBUG: Check if function exists
            if (function_exists('virical_render_navigation_menu')) {
                echo '<!-- VIRICAL MENU: Function exists, rendering... -->';
                // Render custom Virical navigation menu with dropdown support
                // Disable WordPress default menu to prevent duplicates
                remove_all_filters('wp_nav_menu_objects');
                remove_all_filters('wp_nav_menu_items');
                remove_all_filters('wp_nav_menu_args');
                virical_render_navigation_menu('primary', 'main-nav');
                echo '<!-- VIRICAL MENU: Rendering complete -->';
            } else {
                echo '<!-- ERROR: virical_render_navigation_menu function not found! -->';
                // Emergency fallback
                echo '<ul class="main-nav">';
                echo '<li><a href="' . home_url('/') . '">TRANG CHỦ</a></li>';
                echo '<li><a href="' . home_url('/gioi-thieu') . '">GIỚI THIỆU</a></li>';
                echo '<li><a href="' . home_url('/san-pham') . '">SẢN PHẨM</a></li>';
                echo '<li><a href="' . home_url('/lien-he') . '">LIÊN HỆ</a></li>';
                echo '</ul>';
            }
            ?>
        </nav>
        <button class="menu-toggle" aria-label="Menu">
            <span class="menu-toggle-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
    </div>
</header>

<div class="product-categories-mobile-menu" style="display: none;">
    <?php virical_render_mobile_product_category_menu(); ?>
</div>

<style>
    .menu-toggle-products {
        display: none; /* Hidden by default, shown on mobile */
        position: fixed; /* Fixed position */
        top: 80px; /* Below the header */
        right: 20px; /* On the right side */
        z-index: 1001; /* Above the header */
        background: #fff; /* Changed from none to white for visibility */
        border: none;
        cursor: pointer;
        padding: 10px;
    }

    .menu-toggle-icon-products {
        display: block;
        width: 20px; /* Smaller width */
        height: 16px; /* Smaller height */
        position: relative;
    }

    .menu-toggle-icon-products span {
        display: block;
        width: 100%;
        height: 2px;
        background: #000; /* Black lines */
        position: absolute;
        left: 0;
        transition: all 0.3s;
    }

    .menu-toggle-icon-products span:nth-child(1) {
        top: 0;
    }

    .menu-toggle-icon-products span:nth-child(2) {
        top: 50%;
        transform: translateY(-50%);
    }

    .menu-toggle-icon-products span:nth-child(3) {
        bottom: 0;
    }

    .product-categories-mobile-menu {
        display: none;
        position: fixed;
        top: 130px; /* Below the new button */
        left: 0;
        right: 0;
        background: #fff;
        z-index: 1000;
        padding: 20px;
        border-top: 1px solid #eee;
    }

    @media (max-width: 768px) {
        .menu-toggle-products {
            display: block; /* Show on mobile */
        }
    }
</style>

