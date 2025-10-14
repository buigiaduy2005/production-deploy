<?php
/**
 * Project Navigation Bar Template
 * 
 * @package Virical
 */

global $wpdb;

// Get all active project types
$types = $wpdb->get_results("
    SELECT * FROM {$wpdb->prefix}virical_project_types 
    WHERE is_active = 1 
    ORDER BY sort_order, name
");

// Get selected type from URL
$selected_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';
?>

<!-- Project Navigation Bar -->
<style>
/* Project Category Navigation - Sticky Design */
.project-navigation-bar {
    background-color: rgba(26, 26, 26, 0.98);
    padding: 18px 0;
    position: relative;
    z-index: 998;
    border-bottom: 1px solid rgba(212, 175, 55, 0.3);
    transition: all 0.3s ease;
}

/* Create seamless connection */
.projects-hero + .project-navigation-bar {
    margin-top: 0;
    border-top: none;
}

/* Fixed state */
.project-navigation-bar.is-fixed {
    position: fixed;
    top: 80px; /* Below header */
    left: 0;
    right: 0;
    padding: 15px 0;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    animation: slideDown 0.3s ease-out;
    background-color: rgba(26, 26, 26, 0.98);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

@keyframes slideDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Placeholder to prevent jump */
.project-nav-placeholder {
    display: none;
    height: 65px;
}

.project-nav-placeholder.active {
    display: block;
}

/* Compress header height but keep text size */
body.project-nav-fixed .site-header {
    transition: all 0.3s ease;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1) !important;
    height: 70px !important;
}

body.project-nav-fixed .site-header .header-container {
    padding: 8px 60px !important;
    height: 70px !important;
}

/* Keep original text sizes - no changes */
body.project-nav-fixed .site-header .logo-text {
    /* Keep original size */
}

body.project-nav-fixed .site-header .logo-tagline {
    /* Keep original size */
}

body.project-nav-fixed .site-header .main-navigation a {
    /* Keep original size */
}

/* Adjust fixed nav position for header */
body.project-nav-fixed .project-navigation-bar.is-fixed {
    top: 70px !important;
}

/* Remove gap between header and nav */
.project-navigation-bar {
    margin-top: -1px;
}

.project-nav-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

.project-nav-list {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    flex-wrap: nowrap;
    list-style: none;
    margin: 0;
    padding: 0;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Hide scrollbar */
.project-nav-list::-webkit-scrollbar {
    display: none;
}

.project-nav-list {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.project-nav-item {
    flex-shrink: 0;
}

.project-nav-link {
    display: inline-block;
    color: #bbb;
    text-decoration: none;
    padding: 8px 16px;
    font-size: 12px;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    border-bottom: 2px solid transparent;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
    white-space: nowrap;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.project-nav-link:hover {
    color: #fff;
    border-bottom-color: var(--virical-gold, #d4af37);
    transform: translateY(-1px);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
}

.project-nav-link.active {
    color: var(--virical-gold, #d4af37);
    border-bottom-color: var(--virical-gold, #d4af37);
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
}

/* First item special styling */
.project-nav-item:first-child .project-nav-link.active {
    color: var(--virical-gold, #d4af37);
    font-weight: 700;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .project-nav-list {
        gap: 8px;
    }
    
    .project-nav-link {
        padding: 6px 12px;
        font-size: 11px;
    }
}

@media (max-width: 768px) {
    .project-navigation-bar {
        padding: 15px 0;
    }
    
    .project-nav-list {
        gap: 5px;
        justify-content: flex-start;
        padding: 0 10px;
    }
    
    .project-nav-link {
        padding: 6px 10px;
        font-size: 10px;
        letter-spacing: 0.4px;
    }
}

/* Fade edges for scroll indication */
.project-nav-container {
    position: relative;
}

.project-nav-container::before,
.project-nav-container::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 30px;
    z-index: 1;
    pointer-events: none;
}

.project-nav-container::before {
    left: 0;
    background: linear-gradient(to right, rgba(26, 26, 26, 0.98), transparent);
}

.project-nav-container::after {
    right: 0;
    background: linear-gradient(to left, rgba(26, 26, 26, 0.98), transparent);
}
</style>

<!-- Placeholder -->
<div class="project-nav-placeholder" id="projectNavPlaceholder"></div>

<section class="project-navigation-bar" id="projectNavBar">
    <div class="project-nav-container">
        <ul class="project-nav-list">
            <li class="project-nav-item">
                <a href="?page_id=<?php echo get_the_ID(); ?>" 
                   class="project-nav-link <?php echo !$selected_type ? 'active' : ''; ?>">
                    TẤT CẢ
                </a>
            </li>
            <?php if (!empty($types)): ?>
                <?php foreach ($types as $type): ?>
                    <li class="project-nav-item">
                        <a href="?page_id=<?php echo get_the_ID(); ?>&type=<?php echo esc_attr($type->slug); ?>" 
                           class="project-nav-link <?php echo $selected_type === $type->slug ? 'active' : ''; ?>">
                            <?php echo esc_html(strtoupper($type->name)); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default categories if no types in database -->
                <li class="project-nav-item">
                    <a href="#" class="project-nav-link">CĂN HỘ</a>
                </li>
                <li class="project-nav-item">
                    <a href="#" class="project-nav-link">BIỆT THỰ</a>
                </li>
                <li class="project-nav-item">
                    <a href="#" class="project-nav-link">VILLA</a>
                </li>
                <li class="project-nav-item">
                    <a href="#" class="project-nav-link">PENTHOUSE</a>
                </li>
                <li class="project-nav-item">
                    <a href="#" class="project-nav-link">VĂN PHÒNG</a>
                </li>
                <li class="project-nav-item">
                    <a href="#" class="project-nav-link">SHOWROOM</a>
                </li>
                <li class="project-nav-item">
                    <a href="#" class="project-nav-link">NHÀ HÀNG</a>
                </li>
                <li class="project-nav-item">
                    <a href="#" class="project-nav-link">KHÁCH SẠN</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('projectNavBar');
    const placeholder = document.getElementById('projectNavPlaceholder');
    const navList = document.querySelector('.project-nav-list');
    const activeItem = navList.querySelector('.project-nav-link.active');
    const body = document.body;
    const header = document.querySelector('.site-header');
    
    let navbarOffset = navbar.offsetTop;
    let isFixed = false;
    
    // Scroll active item into view
    if (activeItem) {
        const itemRect = activeItem.getBoundingClientRect();
        const listRect = navList.getBoundingClientRect();
        const scrollLeft = activeItem.offsetLeft - (listRect.width / 2) + (itemRect.width / 2);
        
        navList.scrollTo({
            left: scrollLeft,
            behavior: 'smooth'
        });
    }
    
    // Update navbar offset on resize
    window.addEventListener('resize', function() {
        if (!isFixed) {
            navbarOffset = navbar.offsetTop;
        }
    });
    
    // Sticky navigation on scroll
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const headerHeight = header ? header.offsetHeight : 70;
        
        if (scrollTop > navbarOffset - headerHeight && !isFixed) {
            // Make navigation fixed
            navbar.classList.add('is-fixed');
            body.classList.add('project-nav-fixed');
            placeholder.classList.add('active');
            placeholder.style.height = navbar.offsetHeight + 'px';
            isFixed = true;
            
            // Adjust top position based on header
            setTimeout(() => {
                navbar.style.top = '70px';
            }, 50);
        } else if (scrollTop <= navbarOffset - headerHeight && isFixed) {
            // Remove fixed navigation
            navbar.classList.remove('is-fixed');
            body.classList.remove('project-nav-fixed');
            placeholder.classList.remove('active');
            navbar.style.top = '';
            isFixed = false;
        }
    });
});
</script>