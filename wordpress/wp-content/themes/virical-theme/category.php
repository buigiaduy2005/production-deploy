<?php
/**
 * The template for displaying category archive pages.
 * This file mirrors archive-product.php to ensure a consistent layout.
 *
 * @package Virical
 */

get_header();
?>

<style>
    .product-archive-container {
        display: flex;
        gap: 2rem;
    }
    .product-archive-sidebar {
        flex: 0 0 250px; /* Sidebar width */
    }
    .product-archive-main {
        flex: 1;
    }
    .product-grid-archive {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        position: relative;
    }
    .product-grid-archive.loading::before {
        content: 'Đang tải...';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        z-index: 10;
    }
    .widget-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0.5rem;
    }
    .product-categories-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .product-categories-list li {
        margin-bottom: 0.5rem;
    }
    .product-categories-list a {
        display: block;
        padding: 0.5rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        text-decoration: none;
        color: #374151;
        transition: all 0.2s;
        cursor: pointer;
        background-color: #f9fafb;
    }
    .product-categories-list a:hover {
        border-color: #3B82F6;
        background-color: #eff6ff;
        color: #3B82F6;
    }
    .product-categories-list a.active {
        background-color: #3B82F6;
        color: #fff;
        border-color: #3B82F6;
        font-weight: 600;
    }
    .product-card-archive {
        background-color: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        overflow: hidden;
        text-align: center;
    }
    .product-card-archive-img-container {
        aspect-ratio: 1 / 1;
        overflow: hidden;
    }
    .product-card-archive-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-card-archive-content {
        padding: 1rem;
    }
    .product-card-archive-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    .product-card-archive-title a {
        color: #111827;
        text-decoration: none;
    }
    .product-item-link {
        display: inline-block;
        margin-top: 1rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #3B82F6;
        border: 1px solid #3B82F6;
        border-radius: 0.375rem;
        text-decoration: none;
    }
    .product-item-link:hover {
        background-color: #3B82F6;
        color: #fff;
    }
</style>

<main id="primary" class="site-main container mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-24">

    <header class="page-header mb-8">
        <?php the_archive_title( '<h1 class="page-title text-3xl font-bold text-black">', '</h1>' ); ?>
    </header>

    <div class="product-archive-container">
        <aside class="product-archive-sidebar">
            <div class="widget">
                <h2 class="widget-title">Danh mục sản phẩm</h2>
                <ul class="product-categories-list">
                    <li><a href="<?php echo get_post_type_archive_link('product'); ?>">Tất cả sản phẩm</a></li>
                    <?php
                    $all_categories = get_terms( array(
                        'taxonomy' => 'category',
                        'hide_empty' => false,
                    ) );
                    $current_cat_id = get_queried_object_id();

                    if ( ! empty( $all_categories ) && ! is_wp_error( $all_categories ) ) {
                        foreach ( $all_categories as $category ) {
                            $active_class = ($current_cat_id == $category->term_id) ? 'active' : '';
                            echo '<li><a href="' . esc_url( get_term_link( $category ) ) . '" class="' . $active_class . '">' . esc_html( $category->name ) . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </aside>

        <div class="product-archive-main">
            <div id="product-grid-container" class="product-grid-archive">
                <?php if ( have_posts() ) : ?>
                    <?php
                    while ( have_posts() ) : the_post();
                        get_template_part('template-parts/product-card');
                    endwhile;
                    ?>
                <?php else : ?>
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                <?php endif; ?>
            </div>

            <div class="mt-12" id="product-pagination-container">
                <?php 
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => __( 'Trang trước', 'virical' ),
                    'next_text' => __( 'Sau', 'virical' ),
                ) );
                ?>
            </div>
        </div>
    </div>

</main><!-- #primary -->

<?php
get_footer();
