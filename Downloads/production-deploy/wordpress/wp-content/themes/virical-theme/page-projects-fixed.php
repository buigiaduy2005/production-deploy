<?php
/**
 * Template Name: Projects Page
 * 
 * @package Virical
 */

// Check if this is a single project request
$request_uri = $_SERVER['REQUEST_URI'];
if (preg_match('/cong-trinh\/([^\/]+)\/?$/', $request_uri, $matches)) {
    $project_slug = $matches[1];
    
    // Check if project exists
    global $wpdb;
    $project = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}virical_projects WHERE slug = %s AND is_active = 1",
        $project_slug
    ));
    
    if ($project) {
        // Load single project template
        $single_project = get_template_directory() . '/single-project.php';
        if (file_exists($single_project)) {
            include($single_project);
            exit;
        }
    }
}

// Original page-projects.php content continues below...
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
    --virical-gold: #D4AF37;
    --virical-dark: #1a1a1a;
}

.projects-hero {
    position: relative;
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
</style>

<div class="projects-hero">
    <div class="hero-content">
        <h1 class="hero-title">CÔNG TRÌNH</h1>
        <p class="hero-subtitle">Những dự án tiêu biểu của Virical</p>
    </div>
</div>

<?php get_footer(); ?>
