<?php
/**
 * The template for displaying category archive pages with a responsive, collapsible sidebar.
 *
 * @package Virical
 */

get_header();
?>

<!-- Styles loaded from product-archive-layout.css -->

<main id="primary" class="site-main container mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-24">

    <header class="page-header mb-8">
        <?php the_archive_title( '<h1 class="page-title text-3xl font-bold text-black" style="color: #000000 !important;">', '</h1>' ); ?>
    </header>

    <button class="mobile-category-toggle">
        <span class="hamburger-icon"><span></span><span></span><span></span></span>
        <span>Danh mục sản phẩm</span>
    </button>

    <div class="product-archive-container">
        <aside class="product-archive-sidebar">
            <div class="widget">
                <h2 class="widget-title" style="color: #000 !important;">Danh mục sản phẩm</h2>
                <ul class="product-categories-list">
                    <li><a href="<?php echo esc_url(add_query_arg('ver', wp_rand(), get_post_type_archive_link('product'))); ?>">Tất cả sản phẩm</a></li>
                    <?php
                    $parent_categories = get_terms( array(
                        'taxonomy' => 'category',
                        'hide_empty' => false,
                        'parent' => 0,
                    ) );
                    $current_cat_id = get_queried_object_id();

                    if ( ! empty( $parent_categories ) && ! is_wp_error( $parent_categories ) ) {
                        foreach ( $parent_categories as $parent_category ) {
                            $child_categories = get_terms( array(
                                'taxonomy' => 'category',
                                'hide_empty' => false,
                                'parent' => $parent_category->term_id,
                            ) );

                            $has_children = ! empty( $child_categories );
                            $is_current_parent = ($current_cat_id == $parent_category->term_id);
                            $li_class = 'cat-item';
                            if ($has_children) {
                                $li_class .= ' has-children';
                            }
                            if ($is_current_parent) {
                                $li_class .= ' current-cat-parent';
                            }

                            echo '<li class="' . $li_class . '">';
                            echo '<a href="' . esc_url( get_term_link( $parent_category ) ) . '" class="' . ($is_current_parent ? 'active' : '') . '">' . esc_html( $parent_category->name ) . '</a>';

                            if ( $has_children ) {
                                echo '<ul class="children" style="display:none;">';
                                foreach ( $child_categories as $child_category ) {
                                    $is_current_child = ($current_cat_id == $child_category->term_id);
                                    echo '<li class="cat-item ' . ($is_current_child ? 'current-cat' : '') . '">';
                                    echo '<a href="' . esc_url( get_term_link( $child_category ) ) . '" class="' . ($is_current_child ? 'active' : '') . '">' . esc_html( $child_category->name ) . '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            }
                            echo '</li>';
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

<script>
jQuery(document).ready(function($) {
    $('.mobile-category-toggle').on('click', function() {
        $('.product-archive-sidebar').slideToggle();
    });

    // Reset sidebar style on window resize to fix display issue
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $('.product-archive-sidebar').removeAttr('style');
        }
    });

    $('.product-categories-list .has-children > a').on('click', function(e) {
        // Prevent the default link behavior
        e.preventDefault();
        // Toggle the child list
        $(this).siblings('.children').slideToggle();
    });
});
</script>

<?php
get_footer();