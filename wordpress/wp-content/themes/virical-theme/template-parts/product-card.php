<?php
/**
 * Template part for displaying a product card in a grid.
 *
 * @package Virical
 */
?>
<div class="product-card-archive">
    <?php if (has_post_thumbnail()) : ?>
        <div class="product-card-archive-img-container">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium_large', ['class' => 'product-card-archive-img']); ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="product-card-archive-content">
        <h2 class="product-card-archive-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <a href="<?php the_permalink(); ?>" class="product-item-link">Xem chi tiết</a>
    </div>
</div>
