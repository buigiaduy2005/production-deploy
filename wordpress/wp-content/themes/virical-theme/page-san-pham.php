<?php
/**
 * Template for San Pham page (slug: san-pham)
 * This template is automatically used for pages with slug "san-pham"
 */

// Ensure scripts are modified before wp_head() outputs them
add_action('wp_enqueue_scripts', function() {
    // Dequeue original header behavior
    wp_dequeue_script('virical-header-script');
    wp_deregister_script('virical-header-script');
    
    // Enqueue products page override (no scroll color change)
    wp_enqueue_script(
        'products-header-override',
        get_template_directory_uri() . '/assets/js/products-header-override.js',
        array('jquery'),
        '1.0.0',
        true
    );
}, 100);

get_header();
?>
<style>
/* Force black text color for all header elements on products page */
body .site-header,
body .site-header *,
body .site-header a,
body .site-header .main-navigation,
body .site-header .main-navigation *,
body .site-header .main-navigation a,
body .site-header .main-navigation ul,
body .site-header .main-navigation li,
body .site-header .main-navigation li a,
body .site-header.scrolled .main-navigation a,
body .site-header.scrolled .main-navigation a:hover {
    color: #000000 !important;
    text-shadow: none !important;
    -webkit-text-fill-color: #000000 !important;
}

/* Extra strong specificity for the actual header container */
#site-header .main-navigation a,
#site-header .main-navigation a:hover,
#site-header .main-navigation a:focus,
#site-header .main-navigation a:active,
#site-header .main-navigation li a,
#site-header.scrolled .main-navigation a,
#site-header.scrolled .main-navigation a:hover {
    color: #000000 !important;
    -webkit-text-fill-color: #000000 !important;
    text-shadow: none !important;
}

/* Override hover effects to keep black color */
body .site-header .main-navigation a:hover,
body .site-header .main-navigation a:focus,
body .site-header .main-navigation a:active {
    color: #000000 !important;
    text-shadow: none !important;
    -webkit-text-fill-color: #000000 !important;
}

/* Override any specific navigation styles */
body .main-navigation a,
body .main-navigation a:hover,
body .main-navigation a:focus,
body .main-navigation a:active {
    color: #000000 !important;
    text-shadow: none !important;
    -webkit-text-fill-color: #000000 !important;
}

/* Explicitly handle link states */
body .main-navigation a:link,
body .main-navigation a:visited,
body .main-navigation a:active {
    color: #000000 !important;
    -webkit-text-fill-color: #000000 !important;
}

/* Disable all header transitions and effects */
body .site-header,
body .site-header *,
body .site-header .main-navigation,
body .site-header .main-navigation * {
    transition: none !important;
    animation: none !important;
}

/* Force header to never change background or text color */
body .site-header.scrolled,
body .site-header.scrolled *,
body .site-header.scrolled .main-navigation,
body .site-header.scrolled .main-navigation *,
body .site-header.scrolled .main-navigation a,
body .site-header.scrolled .main-navigation a:hover {
    color: #000000 !important;
    text-shadow: none !important;
    background: transparent !important;
    -webkit-text-fill-color: #000000 !important;
}
</style>



<?php
global $wpdb;

// --- DATA FETCHING ---
$categories_table = $wpdb->prefix . 'virical_product_categories';
$products_table = $wpdb->prefix . 'virical_products';

$product_categories = $wpdb->get_results("
    SELECT * FROM {$categories_table} 
    WHERE is_active = 1 
    ORDER BY sort_order, name
");

$current_category_slug = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

$sql_select = "SELECT * FROM {$products_table}";
$sql_where = " WHERE is_active = 1";
$sql_params = [];

if ($current_category_slug) {
    $sql_where .= " AND category = %s";
    $sql_params[] = $current_category_slug;
}

$sql_orderby = " ORDER BY is_featured DESC, sort_order, id DESC";

$query = $sql_select . $sql_where . $sql_orderby;

if (!empty($sql_params)) {
    $query = $wpdb->prepare($query, $sql_params);
}

$products = $wpdb->get_results($query);

?>

<script src="https://cdn.tailwindcss.com"></script>
<style>
    .sidebar-content::-webkit-scrollbar { width: 5px; }
    .sidebar-content::-webkit-scrollbar-track { background: #f1f1f1; }
    .sidebar-content::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 5px; }
    .sidebar-content::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="bg-gray-50 font-sans">

    <!-- Mobile Header -->
    <header class="lg:hidden bg-white shadow-md sticky top-20 z-40">
        <div class="container mx-auto flex items-center justify-between p-4">
            <h1 class="text-xl font-bold text-black" style="color: black !important;">Sản phẩm</h1>
            <button id="hamburger-button" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </header>

    <div class="container mx-auto lg:grid lg:grid-cols-[260px_1fr] lg:gap-x-8 relative pt-20">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-white w-[260px] fixed top-0 left-0 h-full z-50 shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:sticky lg:top-8 lg:translate-x-0 lg:shadow-none lg:border-r lg:border-gray-200 lg:h-auto self-start">
            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Danh Mục Sản Phẩm</h3>
                <button id="close-sidebar-button" class="lg:hidden text-gray-500 hover:text-gray-700">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="sidebar-content max-h-[calc(100vh-68px)] overflow-y-auto">
                <nav>
                    <ul>
                        <li class="border-b border-gray-200 last:border-b-0">
                             <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="flex items-center justify-between p-4 hover:bg-gray-100 transition-colors duration-200 <?php echo empty($current_category_slug) ? 'bg-blue-50 text-blue-600' : 'text-gray-700'; ?>">
                                <span class="font-semibold">Tất cả sản phẩm</span>
                            </a>
                        </li>
                        <?php foreach ($product_categories as $category): ?>
                        <li class="border-b border-gray-200 last:border-b-0">
                            <a href="?category=<?php echo $category->slug; ?>" class="flex items-center justify-between p-4 hover:bg-gray-100 transition-colors duration-200 <?php echo $current_category_slug === $category->slug ? 'bg-blue-50 text-blue-600' : 'text-gray-700'; ?>">
                                <span class="font-semibold"><?php echo $category->name; ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        </aside>
        
        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Main Content -->
        <main class="py-8">
            <div class="container mx-auto px-4">
                <div class="hidden lg:block mb-8">
                    <h1 class="text-4xl font-extrabold text-black" style="color: black !important;">Sản phẩm</h1>
                </div>

                <!-- Desktop Grid Layout (4 columns) -->
                <div class="hidden lg:grid lg:grid-cols-4 gap-6">
                    <?php if (!empty($products)):
                        foreach ($products as $product): 
                            // Calculate if product is new (created within last 30 days)
                            $is_new = false;
                            if (!empty($product->created_at)) {
                                $created_date = strtotime($product->created_at);
                                $is_new = (time() - $created_date) < (30 * 24 * 60 * 60);
                            }
                            
                            // Get discount info (if available in meta or calculate from price)
                            $original_price = !empty($product->original_price) ? floatval($product->original_price) : 0;
                            $current_price = !empty($product->price) ? floatval($product->price) : 0;
                            $discount_percent = 0;
                            if ($original_price > 0 && $current_price > 0 && $original_price > $current_price) {
                                $discount_percent = round((($original_price - $current_price) / $original_price) * 100);
                            }
                            
                            $product_url = home_url('/san-pham/' . $product->slug . '/');
                            $image_url = !empty($product->image_url) ? $product->image_url : get_template_directory_uri() . '/assets/images/placeholder.jpg';
                            ?>
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col">
                            <!-- Product Image with Badges -->
                            <div class="relative aspect-square overflow-hidden">
                                <a href="<?php echo esc_url($product_url); ?>" class="block">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->name); ?>" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                </a>
                                <!-- Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    <?php if ($is_new): ?>
                                        <span class="bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded">Mới</span>
                                    <?php endif; ?>
                                    <?php if ($discount_percent > 0): ?>
                                        <span class="bg-orange-500 text-white text-xs font-bold px-2.5 py-1 rounded">Giảm <?php echo $discount_percent; ?>%</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-5 flex flex-col flex-grow">
                                <!-- Product Name -->
                                <a href="<?php echo esc_url($product_url); ?>">
                                    <h3 class="text-center font-bold text-base mb-3 text-gray-900 line-clamp-2 min-h-[48px]"><?php echo esc_html($product->name); ?></h3>
                                </a>
                                
                                <!-- Price -->
                                <div class="text-center mb-4">
                                    <?php if ($current_price > 0): ?>
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-lg font-bold text-orange-500"><?php echo number_format($current_price, 0, ',', '.'); ?> ₫</span>
                                            <?php if ($original_price > 0 && $original_price > $current_price): ?>
                                                <span class="text-sm text-gray-400 line-through"><?php echo number_format($original_price, 0, ',', '.'); ?> ₫</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-600 font-semibold">Liên hệ</span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2 mt-auto">
                                    <a href="<?php echo esc_url($product_url); ?>" class="flex-1 bg-gray-900 text-white text-center py-2.5 px-4 rounded-md font-semibold hover:bg-gray-800 transition-colors text-sm">
                                        Mua ngay
                                    </a>
                                    <a href="<?php echo esc_url($product_url); ?>" class="flex-1 bg-white text-gray-900 border-2 border-gray-900 text-center py-2.5 px-4 rounded-md font-semibold hover:bg-gray-50 transition-colors text-sm">
                                        Tìm hiểu thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-4 text-center py-12">
                            <p class="text-gray-500 text-lg">Không tìm thấy sản phẩm nào.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile List Layout (Vertical) -->
                <div class="lg:hidden space-y-4">
                    <?php if (!empty($products)):
                        foreach ($products as $product): 
                            // Calculate if product is new
                            $is_new = false;
                            if (!empty($product->created_at)) {
                                $created_date = strtotime($product->created_at);
                                $is_new = (time() - $created_date) < (30 * 24 * 60 * 60);
                            }
                            
                            // Get discount info
                            $original_price = !empty($product->original_price) ? floatval($product->original_price) : 0;
                            $current_price = !empty($product->price) ? floatval($product->price) : 0;
                            $discount_percent = 0;
                            if ($original_price > 0 && $current_price > 0 && $original_price > $current_price) {
                                $discount_percent = round((($original_price - $current_price) / $original_price) * 100);
                            }
                            
                            $product_url = home_url('/san-pham/' . $product->slug . '/');
                            $image_url = !empty($product->image_url) ? $product->image_url : get_template_directory_uri() . '/assets/images/placeholder.jpg';
                            ?>
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm flex gap-4 p-4">
                            <!-- Product Image -->
                            <div class="relative flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden">
                                <a href="<?php echo esc_url($product_url); ?>" class="block w-full h-full">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->name); ?>" class="w-full h-full object-cover">
                                </a>
                                <!-- Badges -->
                                <div class="absolute top-1 left-1 flex flex-col gap-1">
                                    <?php if ($is_new): ?>
                                        <span class="bg-green-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">Mới</span>
                                    <?php endif; ?>
                                    <?php if ($discount_percent > 0): ?>
                                        <span class="bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">Giảm <?php echo $discount_percent; ?>%</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1 flex flex-col justify-between min-w-0">
                                <!-- Product Name -->
                                <a href="<?php echo esc_url($product_url); ?>">
                                    <h3 class="font-bold text-base text-gray-900 mb-2 line-clamp-2"><?php echo esc_html($product->name); ?></h3>
                                </a>
                                
                                <!-- Price -->
                                <div class="mb-2">
                                    <?php if ($current_price > 0): ?>
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg font-bold text-orange-500"><?php echo number_format($current_price, 0, ',', '.'); ?> ₫</span>
                                            <?php if ($original_price > 0 && $original_price > $current_price): ?>
                                                <span class="text-sm text-gray-400 line-through"><?php echo number_format($original_price, 0, ',', '.'); ?> ₫</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-600 font-semibold text-sm">Liên hệ</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">Không tìm thấy sản phẩm nào.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Floating Contact Buttons -->
    <div class="fixed right-4 top-1/2 -translate-y-1/2 space-y-3 z-30">
        <a href="#" class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-600 transition-colors">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 2.55 1 4.93 2.66 6.7l-1.5 5.48 5.63-1.48c1.69.93 3.6 1.44 5.58 1.44h.01c5.46 0 9.91-4.45 9.91-9.91s-4.45-9.91-9.91-9.91zm0 18.16c-1.8 0-3.53-.48-5-1.35l-.36-.21-3.72.98.99-3.63-.23-.37c-1-1.65-1.54-3.6-1.54-5.68 0-4.54 3.69-8.23 8.23-8.23 4.54 0 8.23 3.69 8.23 8.23s-3.69 8.23-8.23 8.23zm4.49-5.44c-.25-.12-1.46-.72-1.69-.8s-.39-.12-.56.12c-.17.25-.64.8-.78.97s-.28.17-.53.06c-.25-.12-1.05-.39-2-1.23s-1.45-1.95-1.61-2.28c-.17-.33-.02-.52.11-.64s.25-.28.37-.42c.12-.15.17-.25.25-.42s.04-.3-.02-.42c-.06-.12-.56-1.35-.76-1.84s-.4-.4-.56-.4h-.5c-.17 0-.45.06-.68.3s-.88.86-.88 2.1c0 1.24.9 2.43 1.03 2.6s1.78 2.73 4.33 3.82c.6.25 1.07.4 1.42.52.6.2 1.14.17 1.56.1.48-.09 1.46-.6 1.67-1.18s.2-.54.15-.6c-.05-.07-.17-.12-.42-.24z"/></svg> <!-- Zalo -->
        </a>
        <a href="#" class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition-colors">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c.37 0 .74-.02 1.1-.07l-1.04-3.11c-.49.12-1.01.18-1.56.18-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6c0 .79-.16 1.54-.44 2.22l3.11 1.04c.2-.58.33-1.2.33-1.85 0-5.52-4.48-10-10-10zm4.19 12.81c-1.39 1.39-3.64 1.39-5.04 0s-1.39-3.64 0-5.04c.7-.7 1.62-1.03 2.52-1.03s1.82.33 2.52 1.03c1.39 1.39 1.39 3.65 0 5.04zm-1.2-3.84c-.39-.39-1.02-.39-1.41 0s-.39 1.02 0 1.41.39.39 1.41 0 .39-1.02 0-1.41z"/></svg> <!-- Messenger -->
        </a>
        <a href="#" class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition-colors">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.02.74-.25 1.02l-2.2 2.2z"/></svg> <!-- Call -->
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const hamburgerButton = document.getElementById('hamburger-button');
    const closeSidebarButton = document.getElementById('close-sidebar-button');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    }

    hamburgerButton.addEventListener('click', openSidebar);
    closeSidebarButton.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);
});
</script>

<?php get_footer(); ?>
