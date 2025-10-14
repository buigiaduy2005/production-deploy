<?php
/**
 * Custom template tags for this theme
 *
 * @package Aura_Lighting
 */

if ( ! function_exists( 'aura_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time
     */
    function aura_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x( 'Posted on %s', 'post date', 'aura-lighting' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if ( ! function_exists( 'aura_posted_by' ) ) :
    /**
     * Prints HTML with meta information for the current author
     */
    function aura_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x( 'by %s', 'post author', 'aura-lighting' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if ( ! function_exists( 'aura_entry_footer' ) ) :
    /**
     * Prints HTML with meta information for the categories, tags and comments
     */
    function aura_entry_footer() {
        // Hide category and tag text for pages
        if ( 'post' === get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( esc_html__( ', ', 'aura-lighting' ) );
            if ( $categories_list ) {
                /* translators: 1: list of categories. */
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'aura-lighting' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'aura-lighting' ) );
            if ( $tags_list ) {
                /* translators: 1: list of tags. */
                printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'aura-lighting' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'aura-lighting' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Edit <span class="screen-reader-text">%s</span>', 'aura-lighting' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if ( ! function_exists( 'aura_post_thumbnail' ) ) :
    /**
     * Displays an optional post thumbnail
     */
    function aura_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'post-thumbnail',
                    array(
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
                ?>
            </a>

            <?php
        endif; // End is_singular().
    }
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
    /**
     * Shim for sites older than 5.2
     */
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
endif;

/**
 * Display navigation to next/previous set of posts when applicable
 */
function aura_post_navigation() {
    // Don't print empty markup if there's only one page
    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
        return;
    }
    ?>
    <nav class="navigation paging-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'aura-lighting' ); ?></h1>
        <div class="nav-links">

            <?php if ( get_next_posts_link() ) : ?>
            <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'aura-lighting' ) ); ?></div>
            <?php endif; ?>

            <?php if ( get_previous_posts_link() ) : ?>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'aura-lighting' ) ); ?></div>
            <?php endif; ?>

        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
    <?php
}

/**
 * Display navigation to next/previous post when applicable
 */
function aura_single_post_navigation() {
    // Don't print empty markup if there's nowhere to navigate
    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous ) {
        return;
    }
    ?>
    <nav class="navigation post-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'aura-lighting' ); ?></h1>
        <div class="nav-links">
            <?php
            if ( $previous ) {
                echo '<div class="nav-previous">';
                echo '<a href="' . get_permalink( $previous->ID ) . '" rel="prev">';
                echo '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'aura-lighting' ) . '</span> ';
                echo '<span class="screen-reader-text">' . __( 'Previous post:', 'aura-lighting' ) . '</span> ';
                echo '<span class="post-title">' . get_the_title( $previous->ID ) . '</span>';
                echo '</a>';
                echo '</div>';
            }

            if ( $next ) {
                echo '<div class="nav-next">';
                echo '<a href="' . get_permalink( $next->ID ) . '" rel="next">';
                echo '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'aura-lighting' ) . '</span> ';
                echo '<span class="screen-reader-text">' . __( 'Next post:', 'aura-lighting' ) . '</span> ';
                echo '<span class="post-title">' . get_the_title( $next->ID ) . '</span>';
                echo '</a>';
                echo '</div>';
            }
            ?>
        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
    <?php
}