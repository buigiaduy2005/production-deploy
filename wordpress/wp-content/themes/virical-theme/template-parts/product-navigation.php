<?php
/**
 * Product Navigation Bar Template
 * 
 * @package Virical
 */
?>

<!-- Product Navigation Bar -->
<style>
:root {
    --virical-gold: #d4af37;
    --virical-dark: #1a1a1a;
}

/* Product Category Navigation - Match Projects Page Style */
.virical-product-nav,
.filter-section {
    background: var(--virical-dark, #1a1a1a);
    padding: 15px 0;
    position: sticky;
    top: 70px;
    z-index: 100;
    border-bottom: 1px solid rgba(212, 175, 55, 0.3);
}

/* Filter container */

.virical-product-nav .filter-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.virical-product-nav .filter-tabs {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    list-style: none;
    margin: 0;
    padding: 0;
}

.virical-product-nav .filter-tab {
    color: #999;
    text-decoration: none;
    padding: 8px 16px;
    font-size: 13px;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    transition: all 0.3s ease;
    border-bottom: 2px solid transparent;
    position: relative;
    font-weight: 500;
}

.virical-product-nav .filter-tab:hover,
.virical-product-nav .filter-tab.active {
    color: var(--virical-gold, #d4af37);
    border-bottom-color: var(--virical-gold, #d4af37);
}

/* Responsive */

@media (max-width: 768px) {
    .virical-product-nav .filter-tabs {
        gap: 10px;
    }
    
    .virical-product-nav .filter-tab {
        font-size: 11px;
        padding: 6px 12px;
    }
}
</style>

<section class="virical-product-nav filter-section" id="productNav">
    <div class="filter-container">
        <div class="filter-tabs">
            <a href="?page_id=<?php echo get_the_ID(); ?>" 
               class="filter-tab <?php echo !isset($_GET['category']) ? 'active' : ''; ?>">
                TẤT CẢ
            </a>
            <a href="?page_id=<?php echo get_the_ID(); ?>&category=den-ray-nam-cham" 
               class="filter-tab <?php echo isset($_GET['category']) && $_GET['category'] === 'den-ray-nam-cham' ? 'active' : ''; ?>">
                ĐÈN RAY NAM CHÂM
            </a>
            <a href="?page_id=<?php echo get_the_ID(); ?>&category=den-am-tran" 
               class="filter-tab <?php echo isset($_GET['category']) && $_GET['category'] === 'den-am-tran' ? 'active' : ''; ?>">
                ĐÈN ÂM TRẦN
            </a>
            <a href="?page_id=<?php echo get_the_ID(); ?>&category=den-op-noi" 
               class="filter-tab <?php echo isset($_GET['category']) && $_GET['category'] === 'den-op-noi' ? 'active' : ''; ?>">
                ĐÈN ỐP NỔI
            </a>
            <a href="?page_id=<?php echo get_the_ID(); ?>&category=den-ngoai-troi" 
               class="filter-tab <?php echo isset($_GET['category']) && $_GET['category'] === 'den-ngoai-troi' ? 'active' : ''; ?>">
                ĐÈN NGOÀI TRỜI
            </a>
            <a href="?page_id=<?php echo get_the_ID(); ?>&category=den-trang-tri" 
               class="filter-tab <?php echo isset($_GET['category']) && $_GET['category'] === 'den-trang-tri' ? 'active' : ''; ?>">
                ĐÈN TRANG TRÍ
            </a>
            <a href="?page_id=<?php echo get_the_ID(); ?>&category=den-led-day" 
               class="filter-tab <?php echo isset($_GET['category']) && $_GET['category'] === 'den-led-day' ? 'active' : ''; ?>">
                ĐÈN LED DÂY
            </a>
        </div>
    </div>
</section>

