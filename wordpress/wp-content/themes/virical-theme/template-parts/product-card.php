<?php
/**
 * Template part for displaying a product card in a grid.
 *
 * @package Virical
 */
?>
<a href="<?php the_permalink(); ?>" class="product-card-archive-link">
    <div class="product-card-archive">
        <?php if (has_post_thumbnail()) : ?>
            <div class="product-card-archive-img-container">
                <?php the_post_thumbnail('medium_large', ['class' => 'product-card-archive-img']); ?>
            </div>
        <?php endif; ?>
        <div class="product-card-archive-content">
            <h2 class="product-card-archive-title" style="color: #000 !important;"><?php the_title(); ?></h2>
            <span class="product-item-link"><i class="bi bi-truck"></i> Xem chi tiết</span>
        </div>
    </div>
</a>
