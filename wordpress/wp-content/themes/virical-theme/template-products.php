<?php
/**
 * Template Name: Products Page
 *
 * This is the template that displays the main products page with a sidebar.
 *
 * @package Virical
 */

get_header();
?>

<div class="container mx-auto flex flex-col lg:flex-row gap-x-8 relative pt-20">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-full lg:w-[260px] border-r border-gray-200">
        <div class="p-5 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Danh Mục Sản Phẩm</h3>
        </div>
        <div class="p-5">
            <ul class="product-categories-list">
                <li><a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>">Tất cả sản phẩm</a></li>
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
    
    <!-- Main Content -->
    <main class="py-8 flex-1">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-extrabold text-black mb-8">Sản phẩm</h1>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php
                $products_query = new WP_Query( array(
                    'post_type' => 'product',
                    'posts_per_page' => 12,
                ) );

                if ( $products_query->have_posts() ) :
                    while ( $products_query->have_posts() ) : $products_query->the_post();
                        get_template_part( 'template-parts/product-card' );
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>Không có sản phẩm nào.</p>';
                endif;
                ?>
            </div>
        </div>
    </main>
</div>

<?php
get_footer();
?>
