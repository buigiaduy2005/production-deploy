<?php get_header(); ?>

<style>
    /* Modern E-commerce Interface for Virical */
    body {
        background-color: #fff;
        font-family: 'Montserrat', sans-serif; /* Elegant typography */
    }

    .product-archive-container {
        display: flex;
        gap: 2rem;
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .product-archive-sidebar {
        flex: 0 0 280px;
    }

    .product-archive-main {
        flex: 1;
    }

    .widget-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #111;
    }

    .product-categories-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.5rem; /* Space between buttons */
    }

    .product-categories-list a {
        display: block;
        padding: 0.75rem 1.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px; /* Soft rounded buttons */
        text-decoration: none;
        color: #374151;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
        background-color: #f9fafb;
    }

    .product-categories-list a:hover {
        border-color: #d1d5db;
        background-color: #f3f4f6;
        color: #000;
    }

    .product-categories-list a.active {
        background-color: #3b82f6; /* Highlighted in blue */
        color: #fff;
        border-color: #3b82f6;
        font-weight: 600;
    }

    .product-grid-archive {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Three product cards aligned horizontally */
        gap: 1.5rem;
    }

    .product-card-archive {
        background-color: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        text-align: center;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .product-card-archive:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        transform: translateY(-5px);
    }

    .product-card-archive-img-container {
        aspect-ratio: 1 / 1;
        overflow: hidden;
        background-color: #f3f4f6;
    }

    .product-card-archive-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-card-archive-content {
        padding: 1.5rem;
    }

    .product-card-archive-title {
        font-size: 1.125rem;
        font-weight: 700; /* Bold product name */
        margin: 0 0 1rem 0;
        color: #111827;
    }

    .product-item-link {
        display: inline-block;
        padding: 0.6rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #fff;
        background-color: #3b82f6;
        border: none;
        border-radius: 50px; /* Rounded button */
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .product-item-link:hover {
        background-color: #2563eb;
    }

</style>

<main id="primary" class="site-main">
    <div class="product-archive-container">
        <aside class="product-archive-sidebar">
            <h2 class="widget-title">Danh mục sản phẩm</h2>
                <ul class="product-categories-list">
                    <?php
                    // Add "All Products" button first
                    $all_products_link = get_post_type_archive_link('product');
                    $is_active = is_post_type_archive('product');
                    echo '<li><a href="' . esc_url($all_products_link) . '" class="' . ($is_active ? 'active' : '') . '">Tất cả sản phẩm</a></li>';

                    // Get all categories
                    $all_categories = get_terms(array(
                        'taxonomy' => 'category',
                        'hide_empty' => false,
                    ));

                    $current_cat = get_queried_object();

                    if (!is_wp_error($all_categories)) {
                        foreach ($all_categories as $category) {
                            $active_class = ($current_cat && property_exists($current_cat, 'term_id') && $current_cat->term_id == $category->term_id) ? 'active' : '';
                            echo '<li><a href="' . esc_url(get_term_link($category)) . '" class="' . $active_class . '">' . esc_html($category->name) . '</a></li>';
                        }
                    }
                    ?>
                </ul>
        </aside>

        <div class="product-archive-main">
            <div id="product-grid-container" class="product-grid-archive">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part('template-parts/product-card'); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>