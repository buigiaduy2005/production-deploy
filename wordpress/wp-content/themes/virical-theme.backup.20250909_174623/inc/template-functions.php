<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Aura_Lighting
 */

/**
 * Adds custom classes to the array of body classes
 */
function aura_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    // Add class for transparent header on homepage
    if ( is_front_page() || is_home() ) {
        $classes[] = 'ast-theme-transparent-header';
    }

    // Add page builder template class
    if ( is_page_template( 'page-templates/page-builder.php' ) ) {
        $classes[] = 'ast-page-builder-template';
    }

    return $classes;
}
add_filter( 'body_class', 'aura_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments
 */
function aura_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'aura_pingback_header' );

/**
 * Get custom logo URL
 */
function aura_get_custom_logo_url() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    
    if ( has_custom_logo() ) {
        return esc_url( $logo[0] );
    } else {
        return get_template_directory_uri() . '/assets/images/virical-logo.svg';
    }
}

/**
 * Display custom logo
 */
function aura_custom_logo() {
    if ( has_custom_logo() ) {
        the_custom_logo();
    } else {
        echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
        echo '<img src="' . get_template_directory_uri() . '/assets/images/virical-logo.svg" alt="' . get_bloginfo( 'name' ) . '" style="height: 60px; width: auto;">';
        echo '</a>';
    }
}

/**
 * Check if current page uses transparent header
 */
function aura_is_transparent_header() {
    return is_front_page() || is_home() || is_page_template( 'page-templates/transparent-header.php' );
}

/**
 * Get footer copyright text
 */
function aura_get_footer_copyright() {
    $copyright = get_theme_mod( 'aura_footer_copyright', sprintf( 
        esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'aura-lighting' ),
        date( 'Y' ),
        get_bloginfo( 'name' )
    ) );
    
    return wp_kses_post( $copyright );
}

/**
 * Add async/defer attributes to scripts
 */
function aura_add_async_defer_attributes( $tag, $handle ) {
    // Add async to specific scripts
    $async_scripts = array( 'aura-analytics' );
    
    // Add defer to specific scripts
    $defer_scripts = array( 'aura-main', 'aura-frontend' );
    
    if ( in_array( $handle, $async_scripts ) ) {
        return str_replace( ' src', ' async src', $tag );
    }
    
    if ( in_array( $handle, $defer_scripts ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    
    return $tag;
}
add_filter( 'script_loader_tag', 'aura_add_async_defer_attributes', 10, 2 );

/**
 * Preload key resources
 */
function aura_preload_resources() {
    // Preload fonts
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" as="style">' . "\n";
    
    // Preload logo
    $logo_url = aura_get_custom_logo_url();
    if ( $logo_url ) {
        echo '<link rel="preload" href="' . esc_url( $logo_url ) . '" as="image">' . "\n";
    }
}
add_action( 'wp_head', 'aura_preload_resources', 1 );

/**
 * Add meta tags for SEO
 */
function aura_add_meta_tags() {
    global $post;
    
    if ( is_singular() ) {
        echo '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( get_permalink() ) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        
        if ( has_post_thumbnail() ) {
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
            echo '<meta property="og:image" content="' . esc_url( $thumbnail[0] ) . '">' . "\n";
        }
        
        if ( has_excerpt() ) {
            echo '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '">' . "\n";
            echo '<meta name="description" content="' . esc_attr( get_the_excerpt() ) . '">' . "\n";
        }
    }
}
add_action( 'wp_head', 'aura_add_meta_tags' );

/**
 * Custom pagination
 */
function aura_pagination() {
    global $wp_query;
    $big = 999999999;
    
    $paginate_links = paginate_links( array(
        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'    => '?paged=%#%',
        'current'   => max( 1, get_query_var( 'paged' ) ),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '<span class="screen-reader-text">' . __( 'Previous', 'aura-lighting' ) . '</span>&larr;',
        'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'aura-lighting' ) . '</span>&rarr;',
        'type'      => 'list',
    ) );
    
    if ( $paginate_links ) {
        echo '<nav class="navigation pagination" role="navigation">';
        echo '<h2 class="screen-reader-text">' . __( 'Posts navigation', 'aura-lighting' ) . '</h2>';
        echo $paginate_links;
        echo '</nav>';
    }
}