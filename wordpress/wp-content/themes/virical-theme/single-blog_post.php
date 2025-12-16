<?php
/**
 * The template for displaying single blog posts
 *
 * @package Virical
 */

get_header();
?>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #FFFFFF;
    }
    .breadcrumb a {
        color: #9CA3AF;
        transition: color 0.2s;
    }
    .breadcrumb a:hover {
        color: #3B82F6;
    }
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .blog-meta {
        color: #6B7280;
        font-size: 14px;
    }
    .blog-tags a {
        background: #F3F4F6;
        color: #374151;
        padding: 4px 12px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 12px;
        margin-right: 8px;
        transition: background-color 0.2s;
    }
    .blog-tags a:hover {
        background: #E5E7EB;
    }
</style>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-24">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <!-- Breadcrumb -->
    <nav class="breadcrumb text-sm mb-8">
        <a href="/">Trang chủ</a> &gt;
        <a href="/blog">Blog</a> &gt;
        <span class="text-gray-500"><?php the_title(); ?></span>
    </nav>

    <div class="max-w-4xl mx-auto">
        <!-- Article Header -->
        <header class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-black mb-4" style="color: black !important;"><?php the_title(); ?></h1>
            
            <div class="blog-meta flex items-center space-x-4 mb-6">
                <span>📅 <?php echo get_the_date('d/m/Y'); ?></span>
                <span>👤 <?php the_author(); ?></span>
                <?php if (get_the_terms(get_the_ID(), 'blog_category')) : ?>
                    <span>📁 
                        <?php 
                        $categories = get_the_terms(get_the_ID(), 'blog_category');
                        $cat_names = array();
                        foreach($categories as $category) {
                            $cat_names[] = $category->name;
                        }
                        echo implode(', ', $cat_names);
                        ?>
                    </span>
                <?php endif; ?>
            </div>

            <?php 
            // Get detail image (custom meta field)
            $detail_image_id = get_post_meta(get_the_ID(), '_blog_detail_image_id', true);
            $detail_image_url = $detail_image_id ? wp_get_attachment_url($detail_image_id) : '';
            
            // Use detail image if available, otherwise fall back to featured image
            if ($detail_image_url) : ?>
                <div class="detail-image mb-8">
                    <img src="<?php echo esc_url($detail_image_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-auto object-cover rounded-lg shadow-lg">
                </div>
            <?php elseif (has_post_thumbnail()) : ?>
                <div class="featured-image mb-8">
                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-auto object-cover rounded-lg shadow-lg">
                </div>
            <?php endif; ?>
        </header>

        <!-- Article Content -->
        <div class="blog-content prose max-w-none mb-8">
            <?php the_content(); ?>
        </div>

        <!-- Tags -->
        <?php if (get_the_terms(get_the_ID(), 'blog_tag')) : ?>
            <div class="blog-tags mb-8">
                <h3 class="text-lg font-semibold mb-3">Thẻ:</h3>
                <?php 
                $tags = get_the_terms(get_the_ID(), 'blog_tag');
                foreach($tags as $tag) {
                    echo '<a href="' . get_term_link($tag) . '">' . $tag->name . '</a>';
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Navigation -->
        <div class="blog-navigation flex justify-between items-center py-8 border-t border-gray-200">
            <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>
            
            <div class="prev-post">
                <?php if ($prev_post) : ?>
                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="flex items-center text-blue-600 hover:text-blue-800">
                        <span class="mr-2">←</span>
                        <div>
                            <div class="text-sm text-gray-500">Bài trước</div>
                            <div class="font-medium"><?php echo wp_trim_words($prev_post->post_title, 8); ?></div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>

            <div class="next-post">
                <?php if ($next_post) : ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="flex items-center text-blue-600 hover:text-blue-800 text-right">
                        <div>
                            <div class="text-sm text-gray-500">Bài tiếp</div>
                            <div class="font-medium"><?php echo wp_trim_words($next_post->post_title, 8); ?></div>
                        </div>
                        <span class="ml-2">→</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Related Posts -->
        <div class="related-posts mt-12">
            <h3 class="text-2xl font-bold text-black mb-6" style="color: black !important;">Bài viết liên quan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $related_args = array(
                    'post_type' => 'blog_post',
                    'posts_per_page' => 3,
                    'post__not_in' => array(get_the_ID()),
                    'orderby' => 'rand'
                );
                $related_posts = new WP_Query($related_args);
                if ($related_posts->have_posts()) :
                    while ($related_posts->have_posts()) : $related_posts->the_post();
                ?>
                <div class="related-post-card bg-white rounded-lg shadow-sm overflow-hidden transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="w-full h-48 object-cover">
                        <?php else : ?>
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">📝</span>
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="p-4">
                        <h4 class="font-medium text-black mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="text-sm text-gray-500"><?php echo get_the_date('d/m/Y'); ?></div>
                    </div>
                </div>
                <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>

    <?php endwhile; else : ?>

        <p class="text-center text-2xl">Bài viết không được tìm thấy.</p>

    <?php endif; ?>

</div>

<?php get_footer(); ?>
