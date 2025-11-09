<?php
/*
Template Name: Giao Dien San Pham Hien Dai
*/

get_header();

<style>
/* Override header for products page only */
body.page-template-page-products .site-header,
body.page-id-products .site-header,
body.page .site-header {
    background: rgba(248, 249, 250, 0.9) !important;
    border-bottom: 1px solid rgba(0,0,0,0.1) !important;
    backdrop-filter: blur(10px) !important;
}

/* Force override with highest specificity */
html body.page-template-page-products .site-header {
    background: rgba(248, 249, 250, 0.9) !important;
    border-bottom: 1px solid rgba(0,0,0,0.1) !important;
}

/* Universal override for this page - NUCLEAR OPTION */
.site-header,
header.site-header,
#site-header,
.header,
nav.site-header {
    background: rgba(248, 249, 250, 0.95) !important;
    background-color: rgba(248, 249, 250, 0.95) !important;
    border-bottom: 1px solid rgba(0,0,0,0.2) !important;
    backdrop-filter: blur(10px) !important;
}

/* Override any inline styles */
.site-header[style*="background"] {
    background: rgba(248, 249, 250, 0.95) !important;
}
</style>

<script>
// Force header style for products page - NUCLEAR OPTION
document.addEventListener('DOMContentLoaded', function() {
    function forceHeaderStyle() {
        const headers = document.querySelectorAll('.site-header, header, #site-header, .header');
        headers.forEach(header => {
            header.style.setProperty('background', 'rgba(248, 249, 250, 0.95)', 'important');
            header.style.setProperty('background-color', 'rgba(248, 249, 250, 0.95)', 'important');
            header.style.setProperty('border-bottom', '1px solid rgba(0,0,0,0.2)', 'important');
            header.style.setProperty('backdrop-filter', 'blur(10px)', 'important');
        });
    }
    
    // Run immediately
    forceHeaderStyle();
    
    // Run after a delay to override any late-loading styles
    setTimeout(forceHeaderStyle, 500);
    setTimeout(forceHeaderStyle, 1000);
    
    // Run on scroll to override any scroll-based changes
    window.addEventListener('scroll', forceHeaderStyle);
});
</script>

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

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <?php if (!empty($products)):
                        foreach ($products as $product): ?>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden group transform hover:-translate-y-1 transition-all duration-300 hover:shadow-lg flex flex-col">
                            <a href="<?php echo home_url('/san-pham/' . $product->slug . '/'); ?>" class="block">
                                <div class="aspect-square overflow-hidden">
                                    <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->name); ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            </a>
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="flex-grow">
                                                                    <a href="<?php echo home_url('/san-pham/' . $product->slug . '/'); ?>">
                                                                        <h3 class="text-gray-900 font-bold text-lg h-14 overflow-hidden mb-2" style="color: black !important;"><?php echo esc_html($product->name); ?></h3>
                                                                    </a>
                                    <?php if (!empty($product->description)): ?>
                                        <p class="text-gray-600 text-sm mb-4"><?php echo esc_html($product->description); ?></p>
                                    <?php endif; ?>

                                    <?php
                                    if (!empty($product->features)) {
                                        $features = json_decode($product->features, true);
                                        if (is_array($features)) {
                                            echo '<ul class="text-sm text-gray-600 list-disc list-inside mb-4">';
                                            foreach ($features as $feature) {
                                                echo '<li>' . esc_html($feature) . '</li>';
                                            }
                                            echo '</ul>';
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="flex items-baseline mb-4">
                                    <span class="text-gray-600 font-semibold">Liên hệ</span>
                                </div>
                                <a href="<?php echo home_url('/san-pham/' . $product->slug . '/'); ?>" class="w-full text-center block bg-white text-gray-800 border-2 border-gray-800 rounded-md py-2 px-4 font-semibold hover:bg-gray-800 hover:text-white transition-all duration-300">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center py-12">
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