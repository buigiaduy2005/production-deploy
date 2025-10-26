<?php
/**
 * The template for displaying single products with a modern design.
 *
 * @package Virical
 */

get_header();


$product_slug = get_query_var('product');
global $wpdb;
$product = $wpdb->get_row($wpdb->prepare(
    "SELECT p.*, p.category as category_name FROM {$wpdb->prefix}virical_products p WHERE p.slug = %s AND p.is_active = 1",
    $product_slug
));

?>
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #FFFFFF;
    }
    .breadcrumb a {
        color: #9CA3AF;
        transition: color 0.2s;
    }
    .breadcrumb a:hover {
        color: #3B82F6;
    }
    .product-image-container {
        position: relative;
        overflow: hidden;
    }
    .product-image {
        transition: transform 0.3s ease;
    }
    .product-image-container:hover .product-image {
        transform: scale(1.05);
    }
    .warranty-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .version-btn {
        border: 1px solid #D1D5DB;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .version-btn.active, .version-btn:hover {
        background-color: #3B82F6;
        color: white;
        border-color: #3B82F6;
    }
    .add-to-cart-btn {
        background-color: #3B82F6;
        color: white;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        text-align: center;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .add-to-cart-btn:hover {
        background-color: #2563EB;
    }
    .buy-now-btn {
        background-color: #F97316;
        color: white;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        text-align: center;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .buy-now-btn:hover {
        background-color: #EA580C;
    }
    .commitment-box {
        background-color: #F3F4F6;
        border: 1px solid #3B82F6;
        border-radius: 8px;
        padding: 1.5rem;
    }
    .store-tabs button {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    .store-tabs button.active {
        background-color: #3B82F6;
        color: white;
    }
    .product-description h3 {
        font-size: 20px;
        font-weight: 600;
        color: #1E40AF;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .product-description ul {
        list-style-type: none;
        padding-left: 0;
    }
    .product-description ul li {
        padding-left: 28px;
        position: relative;
        margin-bottom: 8px;
    }
    .product-description ul li::before {
        content: '✅';
        position: absolute;
        left: 0;
        top: 0;
    }
    .recent-posts-title {
        font-size: 20px;
        font-weight: 700;
        color: #000 !important;
        border-bottom: 2px solid #000;
        padding-bottom: 8px;
        margin-bottom: 16px;
    }
    .recent-post-item {
        display: flex;
        margin-bottom: 15px;
    }
    .recent-post-item img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        margin-right: 15px;
    }
    .recent-post-item-title {
        font-size: 16px;
        font-weight: 600;
        color: #000;
        text-decoration: none;
        transition: color 0.2s;
    }
    .recent-post-item-title:hover {
        color: #1E40AF;
    }
    .recent-post-item-excerpt {
        font-size: 14px;
        color: #6b7280;
    }
</style>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-24">

    <?php if ($product) : ?>

    <!-- Breadcrumb -->
    <nav class="breadcrumb text-sm mb-8">
        <a href="/">Trang chủ</a> &gt;
        <a href="/san-pham">Sản phẩm</a> &gt;
        <span class="text-gray-500"><?php echo esc_html($product->name); ?></span>
    </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- Main Content -->

            <div class="lg:col-span-2">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Left: Product Image -->

                    <div class="product-image-container rounded-lg shadow-sm">

                        <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->name); ?>" class="product-image w-full h-auto object-cover rounded-lg">

                        <div class="warranty-badge">BẢO HÀNH 12 THÁNG</div>

                    </div>

    

                    <!-- Right: Product Info -->

                    <div class="flex flex-col space-y-4">

                        <h1 class="text-3xl font-bold text-black" style="color: black !important;"><?php echo esc_html($product->name); ?></h1>

                        <div class="flex items-center space-x-4 text-sm text-gray-500">

                            <span>Lượt xem: <?php echo esc_html($product->view_count); ?></span>

                            <span class="w-px h-4 bg-gray-300"></span>

                            <span>Tình trạng: <span class="font-semibold <?php echo $product->in_stock ? 'text-green-600' : 'text-red-600'; ?>"><?php echo $product->in_stock ? 'Còn hàng' : 'Hết hàng'; ?></span></span>

                        </div>

    

                        <div class="text-gray-700 space-y-2">

                            <?php echo $product->description; ?>

                        </div>

    

                        <div class="space-y-4 pt-4">

                            <div class="flex items-baseline space-x-2">
                                <span class="text-xl font-semibold text-blue-600">Hãy liên hệ với chúng tôi để được giá ưu đãi nhất</span>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <a href="/lien-he/" class="px-6 py-3 text-center bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-colors w-full">Liên hệ</a>
                            </div>

                        </div>

    

                        <div class="pt-6">

                            <p class="text-sm text-gray-600 mb-2">Để lại số điện thoại, chúng tôi sẽ gọi lại ngay</p>

                            <div class="flex">

                                <input type="tel" placeholder="Nhập số điện thoại" class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                                <button class="px-6 py-2 bg-blue-700 text-white font-semibold rounded-r-md hover:bg-blue-800 transition-colors">Gửi đi</button>

                            </div>

                        </div>

                    </div>

                </div>

    

                            <!-- Product Description Section -->
                            <div class="product-description bg-white p-6 md:p-8 rounded-lg shadow-sm mt-12">
                                <h2 class="text-2xl font-bold text-black mb-4" style="color: black !important;">Mô tả sản phẩm</h2>
                                <div id="description-wrapper" class="relative">
                                    <div id="product-description-content" class="prose max-w-none text-gray-700 leading-relaxed max-h-60 overflow-hidden">
                                        <p>Bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 Module là một sản phẩm công nghệ mới nhất trong lĩnh vực điều khiển ánh sáng thông minh. Với khả năng kết nối đến các đèn led thông qua công nghệ Zigbee 3.0, bộ điều khiển này cho phép bạn kiểm soát ánh sáng từ xa thông qua ứng dụng di động và tạo lịch trình cho ánh sáng theo ý muốn.</p>
                                        <p><em>*Lưu ý sản phẩm này dùng cho các thiết bị đèn âm trần (Downlight), không sử dụng cho đèn LED dây truyền thống</em></p>
                                        <h3>Thông số kỹ thuật</h3>
                                        <ul>
                                            <li>Kích thước sản phẩm :170x40x30mm</li>
                                            <li>Tín hiệu điều khiển: Zigbee</li>
                                            <li>Đầu vào định mức: 100-240V~ 50/60Hz</li>
                                            <li>Điện áp đầu ra: Tối đa 50VDC</li>
                                            <li>Công suất đầu ra: Tối đa 24W；Tối đa 15W</li>
                                            <li>hệ số công suất: 0,9</li>
                                            <li>Chứa: Trình điều khiển x1, hướng dẫn sử dụng x1, gói phụ kiện vít x1</li>
                                        </ul>
                                        <h3>Tính năng nổi bật</h3>
                                        <ul>
                                            <li>Tương thích nhiều loại đèn: Một trong những tính năng nổi bật của Aqara Smart Dimmer T2 là khả năng tương thích với nhiều loại nguồn sáng, bao gồm bóng đèn sợi đốt, đèn LED và đèn huỳnh quang. Tính linh hoạt này đảm bảo rằng bạn có thể dễ dàng tích hợp nó vào hệ thống chiếu sáng hiện tại của mình mà không gặp bất kỳ rắc rối nào. Ngoài ra, thiết kế nhỏ gọn và kiểu dáng đẹp của nó mang lại cảm giác sang trọng cho bất kỳ căn phòng nào.</li>
                                            <li>Kiểm soát từ xa thông qua ứng dụng di động: Với bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2, bạn có thể kiểm soát ánh sáng từ xa thông qua ứng dụng di động. Bạn có thể bật tắt đèn, điều chỉnh độ sáng, và chọn các chế độ ánh sáng theo ý muốn chỉ trong vài thao tác đơn giản trên điện thoại di động của mình, bất kể bạn đang ở đâu.</li>
                                            <li>Tích hợp công nghệ Zigbee 3.0: Bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 Module tích hợp công nghệ Zigbee 3.0, cho phép nó kết nối và điều khiển đèn led thông qua chuẩn kết nối Zigbee. Điều này mang lại một trải nghiệm tốt hơn trong việc kiểm soát ánh sáng mà không cần đến các thiết bị trung gian khác.</li>
                                            <li>Kết hợp với các thiết bị Aqara Home: Bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 Module có khả năng kết hợp với các thiết bị thông minh Aqara trong ngôi nhà của bạn. Bạn có thể tạo lập các kịch bản tự động và kết hợp với các thiết bị như cảm biến chuyển động, nhiệt độ, hoặc công tắc thông minh để tạo ra một hệ thống thông minh toàn diện.</li>
                                        </ul>
                                        <h3>Ứng dụng thực tế</h3>
                                        <p>Việc sử dụng bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 Module mang lại tiện ích và linh hoạt trong việc điều khiển ánh sáng. Bạn không chỉ có thể kiểm soát ánh sáng từ xa thông qua ứng dụng di động, mà còn có khả năng thiết lập các chế độ ánh sáng và tạo lịch trình theo ý muốn.</p>
                                        <ul>
                                            <li>Thiết lập các chế độ ánh sáng: Sau khi cài đặt và kết nối thành công, bạn có thể thiết lập các chế độ ánh sáng thông qua ứng dụng di động. Bạn có thể điều chỉnh độ sáng và ánh sáng theo ý muốn để tạo ra không gian sống phù hợp với sở thích của mình.</li>
                                            <li>Tạo lịch trình cho ánh sáng: Tính năng tạo lịch trình của bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 cho phép bạn thiết lập các thời gian khác nhau trong ngày mà ánh sáng sẽ tự động thay đổi theo. Bạn có thể thiết lập một lịch trình hằng ngày hoặc tùy chỉnh theo các yêu cầu riêng của mình.</li>
                                        </ul>
                                        <h3>Tích hợp và tương thích với hệ sinh thái thông minh hiện có</h3>
                                        <p>Bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 được thiết kế để tích hợp và tương thích với các hệ thống thông minh Aqara Home. Bạn có thể kết hợp nó với các thiết bị thông minh khác như cảm biến, nút bấm thông minh và bộ điều khiển giọng nói để tạo ra một hệ sinh thái thông minh hoàn chỉnh trong ngôi nhà của bạn.</p>
                                    </div>
                                    <div id="description-overlay" class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
                                    <button id="btn-read-more" class="text-blue-600 font-semibold mt-4 hover:underline">Xem thêm</button>
                                    <button id="btn-read-less" class="text-blue-600 font-semibold mt-4 hover:underline hidden">Ẩn bớt</button>
                                </div>
                            </div>

            </div>

    

                        <!-- Sidebar -->

    

                        <div class="lg:col-span-1 space-y-8">

    

            

    

                            <!-- Commitment Box -->

    

                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">

    

                                <h3 class="text-center font-bold text-black uppercase tracking-wider text-sm mb-4" style="color: black !important;">Cam kết chính hiệu bởi</h3>

    

                                <div class="flex items-center justify-center space-x-4 mb-5">

    

                                    <img src="<?php echo get_template_directory_uri() . '/assets/images/logo_virical1.png'; ?>" alt="Virical Logo" class="h-12">

    

                                    <span class="text-gray-700 font-semibold text-sm leading-tight">Phân phối Virical<br>chính hãng tại Việt Nam</span>

    

                                </div>

    

                                <div class="space-y-3 text-gray-600 text-sm">

    

                                    <div class="flex items-center p-3 bg-gray-50 rounded-md">

    

                                        <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 20.417l4.5-4.5M12 14a2 2 0 100-4 2 2 0 000 4z"></path></svg>

    

                                        <span>Hoàn tiền 100% nếu phát hiện hàng giả</span>

    

                                    </div>

    

                                    <div class="flex items-center p-3 bg-gray-50 rounded-md">

    

                                        <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M4 20h5v-5M20 4h-5v5"></path></svg>

    

                                        <span>Đổi trả trong 7 ngày nếu lỗi</span>

    

                                    </div>

    

                                </div>

    

                            </div>

    

            

    

                            <!-- Store System Box -->

    

                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">

    

                                <h3 class="text-center font-bold text-black uppercase tracking-wider text-sm pt-6" style="color: black !important;">Hệ thống cửa hàng</h3>

    

                                <div class="p-6">

    

                                    <div class="flex justify-center bg-gray-100 rounded-lg p-1 mb-4">

    

                                        <button class="w-full text-center px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded-md shadow">Miền Bắc</button>

    

                                        <button class="w-full text-center px-4 py-2 text-sm font-semibold text-gray-500">Miền Trung</button>

    

                                    </div>

    

                                    <div class="space-y-4 text-gray-700 text-sm">

    

                                        <div class="flex items-start">

    

                                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>

    

                                            <span>Số 63A Phố Vọng, Phường Đồng Tâm, Quận Hai Bà Trưng, Hà Nội</span>

    

                                        </div>

    

                                        <div class="flex items-start">

    

                                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>

    

                                            <span>1019 Trần Hưng Đạo, P. Văn Giang, TP Ninh Bình</span>

    

                                        </div>

    

                                    </div>

    

                                </div>

    

                            </div>

    

            

    

                            <!-- Recent Posts Section (kept from original) -->

    

                            <div class="bg-white rounded-lg p-6 shadow-sm">

    

                                <h3 class="recent-posts-title">Bài viết gần đây</h3>

    

                                <?php

    

                                $recent_posts = wp_get_recent_posts(array(

    

                                    'numberposts' => 4,

    

                                    'post_status' => 'publish'

    

                                ));

    

                                if ($recent_posts) :

    

                                    foreach ($recent_posts as $post_item) :

    

                                        $post_id = $post_item['ID'];

    

                                        $post_title = $post_item['post_title'];

    

                                        $post_excerpt = get_the_excerpt($post_id);

    

                                        $post_permalink = get_permalink($post_id);

    

                                        $post_thumbnail = get_the_post_thumbnail_url($post_id, 'thumbnail');

    

                                ?>

    

                                <div class="recent-post-item">

    

                                    <a href="<?php echo esc_url($post_permalink); ?>">

    

                                        <img src="<?php echo esc_url($post_thumbnail ? $post_thumbnail : 'https://via.placeholder.com/80'); ?>" alt="<?php echo esc_attr($post_title); ?>">

    

                                    </a>

    

                                    <div>

    

                                        <a href="<?php echo esc_url($post_permalink); ?>" class="recent-post-item-title"><?php echo esc_html($post_title); ?></a>

    

                                        <p class="recent-post-item-excerpt"><?php echo esc_html(wp_trim_words($post_excerpt, 10, '...')); ?></p>

    

                                    </div>

    

                                </div>

    

                                <?php 

    

                                    endforeach;

    

                                endif;

    

                                ?>

    

                                            </div>

    

                                        </div>

    

                            

    

                                    </div>

    

                            

    

                                <?php else : ?>

    

                                    <p class="text-center text-2xl">Sản phẩm không được tìm thấy.</p>

    

                                <?php endif; ?>

    

                            

    

                            </div>

    

                            

    

                            

    

                            

    

                            <?php

    

                            

    

                            // Fetch related products

    

                            

    

                            global $wpdb;

    

                            

    

                            if ($product) {

    

                            

    

                                $current_product_id = $product->id;

    

                            

    

                                $current_category_name = $product->category_name;

    

                            

    

                            

    

                            

    

                                $related_products = $wpdb->get_results($wpdb->prepare(

    

                            

    

                                    "SELECT * FROM {$wpdb->prefix}virical_products WHERE category = %s AND id != %d AND is_active = 1 ORDER BY RAND() LIMIT 4",

    

                            

    

                                    $current_category_name,

    

                            

    

                                    $current_product_id

    

                            

    

                                ));

    

                            

    

                            }

    

                            

    

                            ?>

    

                            

    

                            

    

                            

    

                            <?php if (!empty($related_products)) : ?>

    

                            

    

                            

    

                            

    

                            <!-- Related Products Section -->

    

                            

    

                            

    

                            

    

                            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 mt-8">

    

                            

    

                            

    

                            

    

                                <h2 class="text-3xl font-bold text-black mb-6" style="color: black !important;">Sản phẩm liên quan</h2>

    

                            

    

                            

    

                            

    

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

    

                            

    

                            

    

                            

    

                                    <?php foreach ($related_products as $related_product) : ?>

    

                            

    

                            

    

                            

    

                                        <div class="bg-white rounded-lg shadow-md overflow-hidden group flex flex-col">

    

                            

    

                            

    

                            

    

                                            <a href="/san-pham/<?php echo esc_attr($related_product->slug); ?>" class="block">

    

                            

    

                            

    

                            

    

                                                <img src="<?php echo esc_url($related_product->image_url); ?>" alt="<?php echo esc_attr($related_product->name); ?>" class="w-full h-48 object-contain">

    

                            

    

                            

    

                            

    

                                            </a>

    

                            

    

                            

    

                            

    

                                            <div class="p-4 text-center flex flex-col flex-grow">

    

                            

    

                            

    

                            

    

                                                <h3 class="font-semibold text-black mb-2 flex-grow"><a href="/san-pham/<?php echo esc_attr($related_product->slug); ?>" class="hover:text-blue-600"><?php echo esc_html($related_product->name); ?></a></h3>

    

                            

    

                            

    

                            

    

                                                <div class="mb-4 mt-auto">

    

                            

    

                            

    

                            

    

                                                    <?php if (isset($related_product->sale_price) && is_numeric($related_product->sale_price) && (float)$related_product->sale_price < (float)$related_product->price): ?>

    

                            

    

                            

    

                            

    

                                                        <span class="text-gray-500 line-through mr-2"><?php echo number_format($related_product->price, 0, ',', '.'); ?>đ</span>

    

                            

    

                            

    

                            

    

                                                        <span class="font-bold text-blue-600"><?php echo number_format($related_product->sale_price, 0, ',', '.'); ?>đ</span>

    

                            

    

                            

    

                            

    

                                                    <?php else: ?>

    

                            

    

                            

    

                            

    

                                                        <span class="font-bold text-blue-600"><?php echo number_format($related_product->price, 0, ',', '.'); ?>đ</span>

    

                            

    

                            

    

                            

    

                                                    <?php endif; ?>

    

                            

    

                            

    

                            

    

                                                </div>

    

                            

    

                            

    

                            

    

                                                <div class="flex flex-col space-y-2">

    

                            

    

                            

    

                            

    

                                                     <a href="/san-pham/<?php echo esc_attr($related_product->slug); ?>" class="px-4 py-2 text-sm border border-blue-600 text-blue-600 rounded-md hover:bg-blue-100 transition-colors">Xem chi tiết</a>

    

                            

    

                            

    

                            

    

                                                     <a href="#" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Liên hệ</a>

    

                            

    

                            

    

                            

    

                                                </div>

    

                            

    

                            

    

                            

    

                                            </div>

    

                            

    

                            

    

                            

    

                                        </div>

    

                            

    

                            

    

                            

    

                                    <?php endforeach; ?>

    

                            

    

                            

    

                            

    

                                </div>

    

                            

    

                            

    

                            

    

                            </div>

    

                            

    

                            

    

                            

    

                            <?php endif; ?>

    

                            

    

                            

    

                            

    

                            

    

                            

    

                            <!-- Service Benefits Section -->

    

                            

    

                            <div class="bg-gray-50 py-12 mt-8">

    

                            

    

                                <div class="container mx-auto px-4">

    

                            

    

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">

    

                            

    

                                        <!-- Benefit 1: Arrow-Repeat Icon -->

    

                            

    

                                        <div class="group flex flex-col items-center p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">

    

                            

    

                                            <svg class="w-12 h-12 text-gray-500 mb-3 transition-colors duration-300 group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">

    

                            

    

                                              <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>

    

                            

    

                                              <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.5a.5.5 0 0 1 0-1h3.5a.5.5 0 0 1 .5.5v3.5a.5.5 0 0 1-1 0V7.5a5.002 5.002 0 0 0-9.192 2.734.5.5 0 1 1-.986-.174A6.002 6.002 0 0 1 8 3zM2.083 9a6.002 6.002 0 0 1 11.834 0H13.5a.5.5 0 0 1 0 1H10a.5.5 0 0 1-.5-.5V6.5a.5.5 0 0 1 1 0v1.966A5.002 5.002 0 0 0 3.05 9.266a.5.5 0 1 1 .986.174A6.002 6.002 0 0 1 2.083 9z"/>

    

                            

    

                                            </svg>

    

                            

    

                                            <p class="font-bold text-black text-sm">Bảo hành 1 đổi 1 trong 15 tháng</p>

    

                            

    

                                        </div>

    

                            

    

                                        <!-- Benefit 2: File-Earmark-Check Icon -->

    

                            

    

                                        <div class="group flex flex-col items-center p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">

    

                            

    

                                            <svg class="w-12 h-12 text-gray-500 mb-3 transition-colors duration-300 group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">

    

                            

    

                                              <path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>

    

                            

    

                                              <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 1a.5.5 0 0 1 .5.5V3a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V2a1 1 0 0 1 1-1h5.5z"/>

    

                            

    

                                            </svg>

    

                            

    

                                            <p class="font-bold text-black text-sm">Bảo hành nhanh chóng</p>

    

                            

    

                                        </div>

    

                            

    

                                        <!-- Benefit 3: Shield-Check Icon -->

    

                            

    

                                        <div class="group flex flex-col items-center p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">

    

                            

    

                                            <svg class="w-12 h-12 text-gray-500 mb-3 transition-colors duration-300 group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">

    

                            

    

                                              <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.058.238.098.333.111.092.012.184.012.276 0 .095-.013.213-.053.333-.111.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.923-.283-1.87-.604-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM14 2.5c.802.16 1.487.455 1.974.744.488.289.843.646 1.098 1.05l.256.415a1.73 1.73 0 0 1 .14 1.052c-.095 1.092-.34 2.317-.72 3.527-1.255 3.916-3.867 6.4-6.2 7.333C8.373 16.802 8.16 16.867 8 16.867s-.373-.065-.51-.17C4.867 15.2 2.255 12.684.999 8.77c-.38-1.21-.625-2.435-.72-3.527a1.73 1.73 0 0 1 .14-1.052l.256-.415c.255-.403.61-.76 1.098-1.05C3.513 2.955 4.198 2.66 5 2.5c1.052-.226 2.264-.43 3-.492.146-.012.292-.012.436 0 .736.062 1.948.266 3 .492z"/>

    

                            

    

                                              <path d="M10.854 5.854a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>

    

                            

    

                                            </svg>

    

                            

    

                                            <p class="font-bold text-black text-sm">Hỗ trợ khách trọn đời</p>

    

                            

    

                                        </div>

    

                            

    

                                        <!-- Benefit 4: Truck Icon -->

    

                            

    

                                        <div class="group flex flex-col items-center p-4 rounded-lg transition-all duration-300 hover:bg-gray-100">

    

                            

    

                                            <svg class="w-12 h-12 text-gray-500 mb-3 transition-colors duration-300 group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">

    

                            

    

                                              <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>

    

                            

    

                                            </svg>

    

                            

    

                                            <p class="font-bold text-black text-sm">Vận chuyển hoả tốc toàn quốc</p>

    

                            

    

                                        </div>

    

                            

    

                                    </div>

    

                            

    

                                </div>

    

                            

    

                            </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('description-wrapper');
    if (!wrapper) return; // Exit if the component isn't on the page

    const content = document.getElementById('product-description-content');
    const readMoreBtn = document.getElementById('btn-read-more');
    const readLessBtn = document.getElementById('btn-read-less');
    const overlay = document.getElementById('description-overlay');

    // Check if content is taller than the max-height to decide if buttons are needed
    // 240px is the value for Tailwind's max-h-60 (15rem * 16px/rem)
    if (content.scrollHeight <= 240) {
        if(readMoreBtn) readMoreBtn.classList.add('hidden');
        if(overlay) overlay.classList.add('hidden');
    } else {
        if(readMoreBtn) readMoreBtn.classList.remove('hidden');
        if(overlay) overlay.classList.remove('hidden');
    }

    if(readMoreBtn) {
        readMoreBtn.addEventListener('click', function() {
            content.classList.remove('max-h-60');
            overlay.classList.add('hidden');
            readMoreBtn.classList.add('hidden');
            readLessBtn.classList.remove('hidden');
        });
    }

    if(readLessBtn) {
        readLessBtn.addEventListener('click', function() {
            content.classList.add('max-h-60');
            overlay.classList.remove('hidden');
            readLessBtn.classList.add('hidden');
            readMoreBtn.classList.remove('hidden');
        });
    }
});
</script>
<?php get_footer(); ?>
