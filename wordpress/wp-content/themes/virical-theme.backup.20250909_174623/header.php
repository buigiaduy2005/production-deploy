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
    
    <?php wp_head(); ?>
    
    <style>
        /* Header Styles for Virical Design */
        body {
            font-family: 'Quicksand', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .site-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            height: 80px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
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
            font-size: 22px;
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
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'main-nav',
                    'fallback_cb' => function() {
                        echo '<ul class="main-nav">';
                        echo '<li><a href="' . home_url('/') . '">Trang Chủ</a></li>';
                        echo '<li><a href="' . home_url('/about-us/') . '">Chúng Tôi</a></li>';
                        echo '<li><a href="' . home_url('/san-pham/') . '">Sản Phẩm</a></li>';
                        echo '<li><a href="' . home_url('/cong-trinh/') . '">Công Trình</a></li>';
                        echo '<li><a href="' . home_url('/lien-he/') . '">Liên Hệ</a></li>';
                        echo '</ul>';
                    }
                )
            );
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

<script>
// Header scroll effect
window.addEventListener('scroll', function() {
    const header = document.getElementById('site-header');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
</script>