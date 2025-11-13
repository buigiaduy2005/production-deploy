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
    // Remove duplicate menus on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Remove all menus except the first one in .main-navigation
        const navContainer = document.querySelector('.main-navigation');
        if (navContainer) {
            const allMenus = navContainer.querySelectorAll('ul.main-nav');
            // Keep only the first menu, remove all others
            for (let i = 1; i < allMenus.length; i++) {
                console.log('Removing duplicate menu #' + i);
                allMenus[i].remove();
            }
        }
        
        // Remove any WordPress default menus
        const wpMenus = document.querySelectorAll('#menu-primary-menu, .menu-primary-menu-container');
        wpMenus.forEach(function(menu) {
            console.log('Removing WordPress default menu');
            menu.remove();
        });
    });
    </script>
    
    <?php
    wp_head();

    // Load custom menu renderer
    require_once get_template_directory() . '/includes/virical-menu-render.php';
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
        
        /* Compressed header for project pages */
        body.project-nav-fixed .site-header {
            background: rgba(255,255,255,0.98) !important;
        }
        
        .header-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 10px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: padding 0.3s ease;
            height: 80px;
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
            color: #555;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.05);
        }
        
        .main-navigation ul {
            display: flex;
            list-style: none;
            gap: 35px;
            margin: 0;
            padding: 0;
        }
        
        .main-navigation a {
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
            position: relative;
            padding: 5px 0;
        }
        
        .main-navigation a:hover {
            color: #ffd700;
            transform: translateY(-1px);
            text-shadow: 3px 3px 6px rgba(0,0,0,0.8);
        }
        
        .main-navigation a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #ffd700;
            transition: width 0.3s ease;
        }
        
        .main-navigation a:hover::after {
            width: 100%;
        }
        
        .site-header.scrolled .main-navigation a {
            color: #000;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.15);
            font-weight: 700;
        }
        
        .site-header.scrolled .main-navigation a:hover {
            color: #d4af37;
            text-shadow: 2px 2px 3px rgba(0,0,0,0.2);
        }
        
        .site-header.scrolled .main-navigation a::after {
            background-color: #d4af37;
        }

        /* Force hide any duplicate menus */
        .main-navigation ul.main-nav ~ ul.main-nav {
            display: none !important;
        }
        
        /* Hide WordPress default menu if it appears */
        #menu-primary-menu {
            display: none !important;
        }

        /* Dropdown base */
        .main-navigation .menu-item {
            position: relative;
        }

        .main-navigation .dropdown-content {
            position: absolute;
            top: calc(100% + 20px);
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            min-width: 220px;
            padding: 20px;
            background: rgba(255,255,255,0.98);
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(15,23,42,0.18);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, transform 0.25s ease;
            z-index: 900;
        }

        .main-navigation .menu-item-has-children:hover .dropdown-content {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateX(-50%) translateY(0);
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

        /* Product mega menu */
        .menu-item-products .product-mega-menu {
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            width: calc(100% - 120px);
            max-width: 1580px;
            margin: 0 auto;
            padding: 34px 36px 40px;
            background: rgba(255,255,255,0.97);
            border-radius: 0 0 32px 32px;
            box-shadow: 0 25px 50px rgba(15,23,42,0.12);
            transform: translateY(-10px);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, transform 0.25s ease;
            display: block;
        }

        .menu-item-products .product-mega-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: start;
            justify-items: stretch;
        }
        
        .menu-item-products .product-mega-featured {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 100%;
        }

        .menu-item-products .product-mega-categories {
            display: grid;
            grid-template-columns: repeat(4, minmax(220px, 1fr));
            gap: 24px 44px;
        }

        .menu-item-products:hover .product-mega-menu {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0);
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
            border-radius: 0 0 32px 32px;
            border: 1px solid rgba(199,150,0,0.08);
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
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
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
                width: calc(100% - 80px);
                max-width: 1380px;
                padding: 32px 30px 38px;
            }

            .menu-item-products .product-mega-inner {
                grid-template-columns: 1fr 1fr;
                gap: 40px;
            }

            .menu-item-products .product-mega-categories {
                grid-template-columns: repeat(3, minmax(200px, 1fr));
            }
        }

        @media (max-width: 1200px) {
            .menu-item-products .product-mega-menu {
                max-width: 100%;
                width: calc(100% - 60px);
                padding: 30px 26px 36px;
            }

            .menu-item-products .product-mega-inner {
                grid-template-columns: 1fr 1fr;
                gap: 32px;
            }

            .menu-item-products .product-mega-categories {
                grid-template-columns: repeat(2, minmax(220px, 1fr));
                gap: 20px 24px;
            }

            .menu-item-products .product-mega-featured-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 15px 20px;
            }
            
            .main-navigation {
                display: none;
                position: absolute;
                top: 80px;
                left: 0;
                width: 100%;
                background: rgba(255,255,255,0.95);
                padding: 20px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            }
            
            .main-navigation.active {
                display: block;
            }
            
            .main-navigation ul {
                flex-direction: column;
                gap: 10px;
                padding: 0;
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
                background: rgba(255,255,255,0.3);
            }
            

            .menu-toggle {
                display: block;
            }
            
            .logo-text {
                font-size: 20px;
            }
        }

        @media (max-width: 1024px) {
            .menu-item-products .product-mega-menu {
                position: static;
                top: auto;
                left: auto;
                right: auto;
                width: 100%;
                padding: 24px 20px;
                border-radius: 20px;
                box-shadow: none;
                background: rgba(255,255,255,0.92);
                transform: none;
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
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
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="header-container">
        <a href="<?php echo home_url('/'); ?>" class="site-logo">
            <div class="logo-text">VIRICAL</div>
            <div class="logo-tagline">Feeling Light</div>
        </a>
        <nav class="main-navigation">
            <?php
            // Render custom Virical navigation menu with dropdown support
            // Disable WordPress default menu to prevent duplicates
            remove_all_filters('wp_nav_menu_objects');
            remove_all_filters('wp_nav_menu_items');
            remove_all_filters('wp_nav_menu_args');
            virical_render_navigation_menu('primary', 'main-nav');
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
