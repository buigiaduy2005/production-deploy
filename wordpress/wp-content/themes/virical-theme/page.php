<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aura_Lighting
 */

get_header();
?>
<style>
/* Dark Theme for Contact Page - HIGH SPECIFICITY */
body.page-id-13 .site-main,
body.page-id-13 .site-main article#post-13 {
    background-color: #121212 !important;
}

/* Target common form wrappers and content divs */
body.page-id-13 .entry-content,
body.page-id-13 div[class*="contact-form"], /* Target any div with 'contact-form' in the class */
body.page-id-13 form {
    background: #1e1e1e !important;
    color: #ffffff !important;
    padding: 40px;
    border-radius: 8px;
}

body.page-id-13 h1, body.page-id-13 h2, body.page-id-13 h3 {
    color: #ffffff !important;
}

/* Style form inputs */
body.page-id-13 input[type="text"],
body.page-id-13 input[type="email"],
body.page-id-13 textarea,
body.page-id-13 select {
    background-color: #333 !important;
    color: #ffffff !important;
    border: 1px solid #555 !important;
}

/* Style form labels */
body.page-id-13 label {
    color: #bbbbbb !important;
}

/* Style the submit button */
body.page-id-13 input[type="submit"] {
    background-color: #ffffff !important;
    color: #121212 !important;
    border: none !important;
    padding: 15px 30px;
    cursor: pointer;
}
</style>

<main id="primary" class="site-main">

    <?php
    while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content', 'page' );

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();