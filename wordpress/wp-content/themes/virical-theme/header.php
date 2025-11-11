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

        /* Enhanced Dropdown Submenu Styles */
        .main-navigation .menu-item {
            position: relative;
        }

        /* Override default dropdown styles for better integration */
        .main-navigation .dropdown-content {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            justify-content: space-evenly !important;
            align-items: center !important;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-navigation .menu-item-has-children:hover .dropdown-content {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
        }

        /* Ensure dropdown items are properly styled */
        .main-navigation .dropdown-item {
            color: #2c3e50 !important;
            text-decoration: none;
        }

        .main-navigation .dropdown-item:hover {
            color: #1a202c !important;
        }

        .main-navigation .dropdown-item img {
            display: block;
            border-radius: 8px;
        }

        .main-navigation .dropdown-item span {
            color: inherit;
            font-weight: 600;
        }
        
        /* Force horizontal layout for dropdown items */
        .main-nav .dropdown-item,
        .main-navigation .dropdown-item {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 120px !important;
            height: 120px !important;
            flex-shrink: 0 !important;
            flex-grow: 0 !important;
        }
        
        /* Ultra force horizontal layout */
        .dropdown-content {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            justify-content: space-evenly !important;
            align-items: center !important;
            gap: 20px !important;
        }
        
        .dropdown-content > * {
            flex: 0 0 auto !important;
        }
        
        /* Debug styles to force horizontal */
        .dropdown-content a {
            display: inline-block !important;
            vertical-align: top !important;
            margin: 0 10px !important;
        }
        
        /* Specific targeting - Full width */
        ul.main-nav .dropdown-content,
        .main-navigation .dropdown-content,
        .main-nav .menu-item-has-children .dropdown-content {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            justify-content: space-evenly !important;
            position: fixed !important;
            top: 80px !important;
            left: 0 !important;
            right: 0 !important;
            width: 100vw !important;
            max-width: none !important;
            padding: 25px 50px !important;
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
