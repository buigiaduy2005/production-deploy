<?php
function add_product_to_category_archive( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_category() ) {
        $query->set( 'post_type', array( 'post', 'product' ) );
    }
}
add_action( 'pre_get_posts', 'add_product_to_category_archive' );
