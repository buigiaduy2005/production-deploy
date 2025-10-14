<?php
/**
 * Template Name: Giới Thiệu Simple
 * Simple template for Giới Thiệu page
 */

get_header();
?>

<main id="primary" class="site-main" style="margin-top: 100px; padding: 40px 20px; max-width: 1200px; margin-left: auto; margin-right: auto;">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
?>