<?php
/**
 * Template Name: Projects Page
 * 
 * @package Virical
 */

get_header();

global $wpdb;

// Get all active project types
$types = $wpdb->get_results("
    SELECT * FROM {$wpdb->prefix}virical_project_types 
    WHERE is_active = 1 
    ORDER BY sort_order, name
");

// Get selected type from URL
$selected_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';

// Build query
$query = "SELECT * FROM {$wpdb->prefix}virical_projects WHERE is_active = 1";
if ($selected_type) {
    $query .= $wpdb->prepare(" AND type = %s", $selected_type);
}
$query .= " ORDER BY is_featured DESC, sort_order, completion_year DESC, id DESC";

$projects = $wpdb->get_results($query);
?>

<style>
/* Projects Page Styles */
:root {
    --virical-gold: #d4af37;
    --virical-dark: #1a1a1a;
    --virical-light: #f8f8f8;
}

.projects-page {
    background-color: #000;
    color: #fff;
    min-height: 100vh;
}

/* Hero Section */
.projects-hero {
    position: relative;
    height: 50vh;
    min-height: 350px;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), 
                url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920') center/cover;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-content {
    text-align: center;
}

.hero-title {
    font-size: 60px;
    font-weight: 700;
    letter-spacing: 8px;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.hero-subtitle {
    font-size: 18px;
    letter-spacing: 3px;
    color: var(--virical-gold);
}

/* Ensure header stays on top */
.site-header {
    z-index: 1001 !important;
}
    text-decoration: none;
    padding: 10px 20px;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    border-bottom: 2px solid transparent;
    position: relative;
}

.filter-tab:hover,
.filter-tab.active {
    color: var(--virical-gold);
    border-bottom-color: var(--virical-gold);
}

/* Projects Grid */
.projects-section {
    padding: 80px 0;
}

.projects-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.project-item {
    position: relative;
    background: var(--virical-dark);
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.project-item:hover {
    transform: translateY(-10px);
}

.project-image {
    position: relative;
    width: 100%;
    height: 350px;
    overflow: hidden;
}

.project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.project-item:hover .project-image img {
    transform: scale(1.1);
}

/* Project Overlay */
.project-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
    padding: 30px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.project-item:hover .project-overlay {
    transform: translateY(0);
}

.project-name {
    font-size: 22px;
    font-weight: 500;
    margin-bottom: 10px;
    letter-spacing: 1px;
}

.project-info {
    font-size: 14px;
    color: #ccc;
    line-height: 1.6;
}

.project-info span {
    display: inline-block;
    margin-right: 15px;
}

/* Project Content (Always Visible) */
.project-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.8);
    padding: 25px;
    backdrop-filter: blur(5px);
}

.project-type {
    color: var(--virical-gold);
    font-size: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.project-title {
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 10px;
    letter-spacing: 0.5px;
}

.project-details {
    font-size: 13px;
    color: #999;
    line-height: 1.6;
}

.project-details p {
    margin: 3px 0;
}

/* Featured Badge */
.featured-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: var(--virical-gold);
    color: #000;
    padding: 5px 15px;
    font-size: 11px;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-weight: 600;
    z-index: 1;
}

/* No Projects Message */
.no-projects {
    text-align: center;
    padding: 100px 20px;
    color: #666;
}

/* Responsive */
@media (max-width: 1024px) {
    .projects-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 36px;
        letter-spacing: 4px;
    }
    
    .projects-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .project-image {
        height: 300px;
    }
    
    .filter-tabs {
        gap: 15px;
    }
    
    .filter-tab {
        font-size: 12px;
        padding: 8px 15px;
    }
}

/* Animations */
.fade-in {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeIn 0.8s ease forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.project-item {
    animation-delay: calc(var(--index) * 0.1s);
}

/* Lightbox for project details */
.project-lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 9999;
    overflow-y: auto;
}

.lightbox-content {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    position: relative;
}

.lightbox-close {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 40px;
    color: #fff;
    cursor: pointer;
    transition: color 0.3s;
}

.lightbox-close:hover {
    color: var(--virical-gold);
}
</style>

<main class="projects-page">
    <!-- Hero Section -->
    <section class="projects-hero">
        <div class="hero-content fade-in">
            <h1 class="hero-title">CÔNG TRÌNH</h1>
            <p class="hero-subtitle">Dự án tiêu biểu của chúng tôi</p>
        </div>
    </section>

    <!-- Include Project Navigation Bar -->
    <?php get_template_part('template-parts/project-navigation'); ?>

    <!-- Projects Grid -->
    <section class="projects-section">
        <div class="projects-container">
            <?php if (!empty($projects)): ?>
                <div class="projects-grid">
                    <?php foreach ($projects as $index => $project): ?>
                        <div class="project-item fade-in" style="--index: <?php echo $index; ?>" 
                             data-project-id="<?php echo $project->id; ?>">
                            <?php if ($project->is_featured): ?>
                                <div class="featured-badge">Nổi bật</div>
                            <?php endif; ?>
                            
                            <div class="project-image">
                                <img src="<?php echo esc_url($project->main_image); ?>" 
                                     alt="<?php echo esc_attr($project->name); ?>">
                            </div>
                            
                            <div class="project-content">
                                <div class="project-type">
                                    <?php
                                    $type_name = '';
                                    foreach ($types as $type) {
                                        if ($type->slug === $project->type) {
                                            $type_name = $type->name;
                                            break;
                                        }
                                    }
                                    echo esc_html($type_name);
                                    ?>
                                </div>
                                <h3 class="project-title"><?php echo esc_html($project->name); ?></h3>
                                <div class="project-details">
                                    <?php if ($project->area): ?>
                                        <p><?php echo esc_html($type_name); ?> | S <?php echo $project->area; ?>m² |</p>
                                    <?php endif; ?>
                                    <?php if ($project->completion_year): ?>
                                        <p>Hoàn thiện <?php echo $project->completion_year; ?></p>
                                    <?php endif; ?>
                                    <?php if ($project->design_company): ?>
                                        <p>Đơn vị thiết kế: <?php echo esc_html($project->design_company); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="project-overlay">
                                <h3 class="project-name"><?php echo esc_html($project->name); ?></h3>
                                <div class="project-info">
                                    <?php if ($project->location): ?>
                                        <span><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($project->location); ?></span>
                                    <?php endif; ?>
                                    <br>
                                    <?php if ($project->description): ?>
                                        <p style="margin-top: 10px;"><?php echo esc_html($project->description); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-projects">
                    <h3>Không có công trình nào<?php echo $selected_type ? ' trong danh mục này' : ''; ?></h3>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<!-- Project Lightbox -->
<div id="project-lightbox" class="project-lightbox">
    <div class="lightbox-content">
        <span class="lightbox-close">&times;</span>
        <div id="lightbox-body"></div>
    </div>
</div>

<script>
// Intersection Observer for animations
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });
});

// Project click handler
document.querySelectorAll('.project-item').forEach(item => {
    item.addEventListener('click', function() {
        const projectId = this.dataset.projectId;
        // You can implement project detail view here
        // For now, just a simple alert
        console.log('Project ID:', projectId);
    });
});

// Lightbox functionality
const lightbox = document.getElementById('project-lightbox');
const lightboxClose = document.querySelector('.lightbox-close');

lightboxClose.addEventListener('click', function() {
    lightbox.style.display = 'none';
    document.body.style.overflow = 'auto';
});

// Close lightbox on outside click
lightbox.addEventListener('click', function(e) {
    if (e.target === lightbox) {
        lightbox.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
});
</script>

<?php get_footer(); ?>