<?php
/**
 * The template for displaying blog post archives
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
    .blog-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .blog-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .blog-excerpt {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-24">

    <!-- Breadcrumb -->
    <nav class="breadcrumb text-sm mb-8">
        <a href="/">Trang chủ</a> &gt;
        <span class="text-gray-500">Blog</span>
    </nav>

    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-black mb-4" style="color: black !important;">Blog</h1>
        <p class="text-lg text-gray-600">Tin tức và kiến thức về công nghệ chiếu sáng thông minh</p>
    </div>

    <?php if ( have_posts() ) : ?>

    <!-- Blog Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <?php while ( have_posts() ) : the_post(); ?>
        
        <article class="blog-card bg-white rounded-lg shadow-sm overflow-hidden">
            <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) : ?>
                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title(); ?>" class="w-full h-48 object-cover">
                <?php else : ?>
                    <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                        <span class="text-4xl text-blue-500">📝</span>
                    </div>
                <?php endif; ?>
            </a>
            
            <div class="p-6">
                <!-- Meta Info -->
                <div class="flex items-center text-sm text-gray-500 mb-3">
                    <span>📅 <?php echo get_the_date('d/m/Y'); ?></span>
                    <?php if (get_the_terms(get_the_ID(), 'blog_category')) : ?>
                        <span class="mx-2">•</span>
                        <span>📁 
                            <?php 
                            $categories = get_the_terms(get_the_ID(), 'blog_category');
                            echo $categories[0]->name;
                            ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Title -->
                <h2 class="text-xl font-bold text-black mb-3 hover:text-blue-600 transition-colors">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

                <!-- Excerpt -->
                <div class="blog-excerpt text-gray-600 mb-4">
                    <?php 
                    if (has_excerpt()) {
                        the_excerpt();
                    } else {
                        echo wp_trim_words(get_the_content(), 20, '...');
                    }
                    ?>
                </div>

                <!-- Read More -->
                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    Đọc thêm
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Tags -->
                <?php if (get_the_terms(get_the_ID(), 'blog_tag')) : ?>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <?php 
                        $tags = get_the_terms(get_the_ID(), 'blog_tag');
                        foreach(array_slice($tags, 0, 3) as $tag) {
                            echo '<span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded mr-2 mb-1">' . $tag->name . '</span>';
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>

        <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        <?php
        echo paginate_links(array(
            'prev_text' => '← Trước',
            'next_text' => 'Tiếp →',
            'type' => 'list',
            'class' => 'pagination'
        ));
        ?>
    </div>

    <?php else : ?>

    <!-- No Posts Found -->
    <div class="text-center py-12">
        <div class="text-6xl mb-4">📝</div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Chưa có bài viết nào</h2>
        <p class="text-gray-600 mb-6">Hãy quay lại sau để đọc những bài viết mới nhất.</p>
        <a href="/" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            Về trang chủ
        </a>
    </div>

    <?php endif; ?>

</div>

<style>
/* Pagination Styling */
.pagination {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 8px;
}

.pagination li {
    margin: 0;
}

.pagination a,
.pagination span {
    display: block;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    color: #374151;
    transition: all 0.2s;
}

.pagination a:hover {
    background-color: #f3f4f6;
    border-color: #d1d5db;
}

.pagination .current {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.pagination .dots {
    border: none;
    background: none;
    color: #9ca3af;
}
</style>

<?php get_footer(); ?>
