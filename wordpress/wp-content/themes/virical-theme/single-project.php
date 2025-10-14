<?php
/**
 * Template for displaying single project
 */

global $wpdb;
get_header();

// Get project slug from URL or query var
$project_slug = get_query_var('project');
if (!$project_slug) {
    // Try to get from URL path
    $request_uri = $_SERVER['REQUEST_URI'];
    if (preg_match('/cong-trinh\/([^\/]+)\/?/', $request_uri, $matches)) {
        $project_slug = $matches[1];
    }
}

// Get project from database
$project = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}virical_projects WHERE slug = %s AND is_active = 1",
    $project_slug
));

if (!$project) {
    wp_redirect(home_url('/cong-trinh/'));
    exit;
}

// Get project type
$project_type = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}virical_project_types WHERE slug = %s",
    $project->type
));

// Decode JSON fields
$images = !empty($project->gallery_images) ? json_decode($project->gallery_images, true) : [];
$specifications = !empty($project->features) ? json_decode($project->features, true) : [];

// Default image if not set
$default_image = get_template_directory_uri() . '/assets/images/default-project.jpg';
$featured_image = !empty($project->main_image) ? $project->main_image : $default_image;
?>

<div class="single-project-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="<?php echo home_url(); ?>">Trang chủ</a>
            <span>/</span>
            <a href="<?php echo home_url('/cong-trinh/'); ?>">Công trình</a>
            <span>/</span>
            <span><?php echo esc_html($project->name); ?></span>
        </nav>

        <div class="project-main">
            <div class="row">
                <!-- Project Images -->
                <div class="col-md-6">
                    <div class="project-gallery">
                        <div class="main-image">
                            <img src="<?php echo esc_url($featured_image); ?>" 
                                 alt="<?php echo esc_attr($project->name); ?>" 
                                 class="img-fluid">
                        </div>
                        <?php if (!empty($images)): ?>
                            <div class="gallery-thumbs">
                                <?php foreach ($images as $image): ?>
                                    <img src="<?php echo esc_url($image); ?>" 
                                         alt="<?php echo esc_attr($project->name); ?>" 
                                         class="thumb-image">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Project Info -->
                <div class="col-md-6">
                    <div class="project-info">
                        <h1 class="project-title"><?php echo esc_html($project->name); ?></h1>
                        
                        <?php if ($project_type): ?>
                            <div class="project-type">
                                <span class="label">Loại công trình:</span>
                                <span class="value"><?php echo esc_html($project_type->name); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($project->design_company): ?>
                            <div class="project-client">
                                <span class="label">Khách hàng:</span>
                                <span class="value"><?php echo esc_html($project->design_company); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($project->location): ?>
                            <div class="project-location">
                                <span class="label">Địa điểm:</span>
                                <span class="value"><?php echo esc_html($project->location); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($project->completion_year): ?>
                            <div class="project-date">
                                <span class="label">Thời gian:</span>
                                <span class="value"><?php echo date('d/m/Y', strtotime($project->completion_year)); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="project-description">
                            <h3>Mô tả dự án</h3>
                            <?php echo wp_kses_post($project->description); ?>
                        </div>

                        <?php if (!empty($specifications)): ?>
                            <div class="project-specifications">
                                <h3>Thông số kỹ thuật</h3>
                                <ul>
                                    <?php foreach ($specifications as $spec): ?>
                                        <li><?php echo esc_html($spec); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Projects -->
        <?php
        $related_projects = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}virical_projects 
             WHERE project_type = %s AND id != %d AND is_active = 1 
             ORDER BY RAND() LIMIT 4",
            $project->type,
            $project->id
        ));
        
        if ($related_projects): ?>
            <div class="related-projects">
                <h2>Công trình liên quan</h2>
                <div class="row">
                    <?php foreach ($related_projects as $related): ?>
                        <div class="col-md-3">
                            <div class="project-item">
                                <a href="<?php echo home_url('/cong-trinh/' . $related->slug); ?>">
                                    <?php 
                                    $related_image = !empty($related->featured_image) ? $related->featured_image : $default_image;
                                    ?>
                                    <img src="<?php echo esc_url($related_image); ?>" 
                                         alt="<?php echo esc_attr($related->title); ?>" 
                                         class="img-fluid">
                                    <h4><?php echo esc_html($related->title); ?></h4>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.single-project-container {
    padding: 40px 0;
}
.breadcrumb {
    padding: 15px 0;
    margin-bottom: 30px;
}
.breadcrumb a {
    color: #666;
    text-decoration: none;
}
.breadcrumb span {
    margin: 0 10px;
    color: #999;
}
.project-gallery .main-image {
    margin-bottom: 20px;
}
.project-gallery .gallery-thumbs {
    display: flex;
    gap: 10px;
}
.project-gallery .thumb-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
}
.project-gallery .thumb-image:hover {
    border-color: #007cba;
}
.project-info h1 {
    font-size: 32px;
    margin-bottom: 20px;
    color: #333;
}
.project-info > div {
    margin-bottom: 15px;
}
.project-info .label {
    font-weight: bold;
    margin-right: 10px;
}
.project-description {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}
.project-description h3,
.project-specifications h3 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #333;
}
.project-specifications ul {
    list-style: none;
    padding: 0;
}
.project-specifications li {
    padding: 5px 0;
    padding-left: 20px;
    position: relative;
}
.project-specifications li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #28a745;
}
.related-projects {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid #eee;
}
.related-projects h2 {
    font-size: 28px;
    margin-bottom: 30px;
    text-align: center;
}
.project-item {
    margin-bottom: 30px;
    text-align: center;
}
.project-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    margin-bottom: 10px;
}
.project-item h4 {
    font-size: 16px;
    color: #333;
}
.project-item a {
    text-decoration: none;
    color: inherit;
}
</style>

<?php get_footer(); ?>
