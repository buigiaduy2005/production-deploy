<?php
/**
 * The template for displaying the new single product design.
 *
 * @package Virical
 */

// Get product data
$product = get_query_var('current_product');

if (!$product) {
    // This should not happen if included correctly
    return;
}

// Get related products
global $wpdb;
$related_products = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}virical_products WHERE category = %s AND id != %d AND is_active = 1 ORDER BY RAND() LIMIT 3",
    $product->category,
    $product->id
));

// Get recent posts
$recent_posts = get_posts(array(
    'numberposts' => 5,
    'post_status' => 'publish'
));

?>
    <style>
        :root {
            --virical-blue: #0056b3; /* Darker blue for CTA */
            --virical-orange: #ff6600; /* Accent color for price */
        }
        .btn-blue {
            background-color: var(--virical-blue);
            color: white;
            transition: background-color 0.3s;
        }
        .btn-blue:hover {
            background-color: #004494;
        }
        .text-orange {
            color: var(--virical-orange);
        }
    </style>

    <div class="container mx-auto my-12 px-4" style="margin-top: 100px;">
        <!-- Breadcrumb -->
        <div class="breadcrumb mb-8 text-sm text-gray-600">
            <a href="<?php echo home_url(); ?>" class="hover:text-blue-500">Trang chủ</a>
            <span class="separator mx-2">/</span>
            <a href="<?php echo home_url('/san-pham/'); ?>" class="hover:text-blue-500">Sản phẩm</a>
            <span class="separator mx-2">/</span>
            <span><?php echo esc_html($product->name); ?></span>
        </div>

        <!-- ================================================================= -->
        <!-- Main Product Section -->
        <!-- ================================================================= -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 mb-12">
            <!-- Left column: Product Images -->
            <div class="lg:col-span-2">
                <img src="<?php echo esc_url($product->image_url); ?>" alt="<?php echo esc_attr($product->name); ?>" class="w-full rounded-lg shadow-lg mb-4 border">
                <div class="grid grid-cols-4 gap-2">
                    <!-- Assuming you have more images in a gallery -->
                    <img src="<?php echo esc_url($product->image_url); ?>" alt="Thumbnail 1" class="w-full rounded-lg shadow-md cursor-pointer border hover:border-blue-500">
                    <img src="<?php echo esc_url($product->image_url); ?>" alt="Thumbnail 2" class="w-full rounded-lg shadow-md cursor-pointer border hover:border-blue-500">
                    <img src="<?php echo esc_url($product->image_url); ?>" alt="Thumbnail 3" class="w-full rounded-lg shadow-md cursor-pointer border hover:border-blue-500">
                </div>
            </div>

            <!-- Right column: Product Info -->
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h1 class="text-4xl font-bold mb-2 text-black" style="color: black !important;">Đèn Ngoài Trời – Đèn Pha LED Stadium 500W</h1>
                        <p class="text-lg text-gray-600 mb-4">Đèn pha LED công suất siêu cao 500W cho sân vận động, công trình lớn.</p>
                        
                        <p class="text-2xl font-bold text-orange mb-4">Liên hệ để nhận báo giá</p>
                        
                        <p class="text-md mb-6"><strong>Thương hiệu:</strong> <span class="text-blue-600">Virical</span></p>

                                        <a href="<?php echo home_url('/lien-he/'); ?>" class="btn btn-blue px-10 py-4 rounded-lg font-bold text-lg inline-flex items-center shadow-lg">
                                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            LIÊN HỆ
                                        </a>
                        <div class="product-tabs mt-8">
                            <div class="tabs-nav flex border-b">
                                <a href="#specs" class="tab-link active py-2 px-4 bg-white text-gray-800" data-tab="specs">THÔNG SỐ KỸ THUẬT</a>
                                <a href="#installation" class="tab-link py-2 px-4 text-gray-600" data-tab="installation">HƯỚNG DẪN LẮP ĐẶT</a>
                                <a href="#warranty" class="tab-link py-2 px-4 text-gray-600" data-tab="warranty">BẢO HÀNH</a>
                            </div>
                            
                            <div class="tabs-content mt-4 p-4 bg-white border border-t-0 rounded-b-lg">
                                <!-- Specifications Tab -->
                                <div id="specs" class="tab-content-item">
                                    <ul class="space-y-2 text-gray-700">
                                        <li class="flex items-center"><span class="font-bold w-36">Công suất:</span> 500W</li>
                                        <li class="flex items-center"><span class="font-bold w-36">Điện áp:</span> 220–240V</li>
                                        <li class="flex items-center"><span class="font-bold w-36">Chống nước:</span> IP66</li>
                                        <li class="flex items-center"><span class="font-bold w-36">Tuổi thọ:</span> 50.000 giờ</li>
                                    </ul>
                                </div>
                                
                                <!-- Installation Tab -->
                                <div id="installation" class="tab-content-item hidden">
                                    <ul class="space-y-2 text-gray-700 list-disc list-inside">
                                        <li>Ngắt nguồn điện trước khi lắp đặt</li>
                                        <li>Xác định vị trí lắp đặt phù hợp</li>
                                        <li>Kết nối dây điện theo sơ đồ hướng dẫn</li>
                                        <li>Cố định sản phẩm chắc chắn</li>
                                        <li>Kiểm tra và bật nguồn điện</li>
                                        <li><strong>Lưu ý:</strong> Nên sử dụng thợ điện chuyên nghiệp để đảm bảo an toàn.</li>
                                    </ul>
                                </div>
                                
                                <!-- Warranty Tab -->
                                <div id="warranty" class="tab-content-item hidden">
                                    <ul class="space-y-2 text-gray-700">
                                        <li><strong>Thời gian bảo hành:</strong> 2 năm kể từ ngày mua hàng</li>
                                        <li><strong>Điều kiện bảo hành:</strong>
                                            <ul class="list-disc list-inside ml-4">
                                                <li>Sản phẩm còn trong thời hạn bảo hành</li>
                                                <li>Có hóa đơn mua hàng và phiếu bảo hành</li>
                                                <li>Sản phẩm bị lỗi do nhà sản xuất</li>
                                                <li>Không tự ý sửa chữa hoặc thay đổi cấu trúc sản phẩm</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border">
                        <h3 class="text-lg font-bold text-center text-black mb-4" style="color: black !important;">CAM KẾT CHÍNH HIỆU BỞI</h3>
                        <div class="flex items-center justify-center mb-4">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_virical1.png" alt="Virical Logo" class="h-16 mr-4">
                            <span class="text-sm font-semibold">Phân phối Virical chính hãng tại Việt Nam</span>
                        </div>
                        <div class="border-t my-4"></div>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span>Hoàn tiền 100% nếu phát hiện hàng giả</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M4 20h5v-5M20 4h-5v5"></path></svg>
                                <span>Đổi trả trong 7 ngày nếu lỗi</span>
                            </li>
                        </ul>
                        <div class="border-t my-4"></div>
                        <h3 class="text-lg font-bold text-center text-black mb-4" style="color: black !important;">HỆ THỐNG CỬA HÀNG</h3>
                        <div class="store-tabs">
                            <div class="tabs-nav flex justify-center border-b mb-4">
                                <a href="#mien-bac" class="store-tab-link active py-2 px-4 bg-blue-500 text-white rounded-t-lg" data-tab="mien-bac">Miền Bắc</a>
                                <a href="#mien-trung" class="store-tab-link py-2 px-4 text-gray-600" data-tab="mien-trung">Miền Trung</a>
                            </div>
                            <div class="tabs-content">
                                <div id="mien-bac" class="store-tab-content-item space-y-3 text-sm">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-3 text-gray-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span>Số 63A Phố Vọng, Phường Đồng Tâm, Quận Hai Bà Trưng, Hà Nội</span>
                                    </div>
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-3 text-gray-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span>1019 Trần Hưng Đạo, P. Văn Giang, TP Ninh Bình</span>
                                    </div>
                                </div>
                                <div id="mien-trung" class="store-tab-content-item hidden space-y-3 text-sm">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-3 text-gray-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span>(Chưa có cửa hàng)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- Product Description Section -->
        <!-- ================================================================= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="bg-white p-8 rounded-lg shadow-md border">
                    <h2 class="text-3xl font-bold mb-6 text-black" style="color: black !important;">Mô tả sản phẩm</h2>
                    <div id="product-description" class="prose max-w-none text-gray-800 overflow-hidden" style="max-height: 300px; transition: max-height 0.5s ease-in-out;">
                        <p>Đèn pha LED Virical Stadium 500W là giải pháp chiếu sáng ngoài trời mạnh mẽ, được thiết kế để đáp ứng những yêu cầu khắt khe nhất về hiệu suất và độ bền. Với công suất 500W, sản phẩm này cung cấp nguồn sáng vượt trội, lý tưởng cho các không gian rộng lớn, đồng thời tiết kiệm điện năng và có tuổi thọ cao, giúp giảm chi phí vận hành và bảo trì.</p>
                        <p>Sản phẩm được ứng dụng rộng rãi trong nhiều môi trường khác nhau như sân vận động, sân thể thao, nhà xưởng, bãi đỗ xe, công trình xây dựng và các khu vực công cộng lớn. Khả năng chống nước IP66 và vỏ nhôm đúc chắc chắn đảm bảo đèn hoạt động ổn định trong mọi điều kiện thời tiết khắc nghiệt.</p>
                        <ul class="mt-4 space-y-2">
                            <li><strong class="font-semibold">Hiệu suất sáng:</strong> 130 lm/W</li>
                            <li><strong class="font-semibold">Ánh sáng:</strong> Trắng 6000K</li>
                            <li><strong class="font-semibold">Chất liệu:</strong> Vỏ nhôm đúc, sơn tĩnh điện</li>
                            <li><strong class="font-semibold">Lắp đặt:</strong> Dễ dàng, có thể điều chỉnh góc chiếu</li>
                            <li><strong class="font-semibold">Tản nhiệt:</strong> Công nghệ tản nhiệt tiên tiến, đảm bảo hoạt động ổn định</li>
                        </ul>
                        <div class="mt-8">
                            <h2 class="text-2xl font-bold mb-4">Bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 Module</h2>
                            <p>Bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 Module là một sản phẩm công nghệ mới nhất trong lĩnh vực điều khiển ánh sáng thông minh. Với khả năng kết nối đến các đèn led thông qua công nghệ Zigbee 3.0, bộ điều khiển này cho phép bạn kiểm soát ánh sáng từ xa thông qua ứng dụng di động và tạo lịch trình cho ánh sáng theo ý muốn.</p>
                            <p><em>*Lưu ý sản phẩm này dùng cho các thiết bị đèn âm trần (Downlight), không sử dụng cho đèn LED dây truyền thống</em></p>
                            <ul>
                                <li><strong>Kích thước sản phẩm:</strong> 170x40x30mm</li>
                                <li><strong>Tín hiệu điều khiển:</strong> Zigbee</li>
                                <li><strong>Đầu vào định mức:</strong> 100-240V~ 50/60Hz</li>
                                <li><strong>Điện áp đầu ra:</strong> Tối đa 50VDC</li>
                                <li><strong>Công suất đầu ra:</strong> Tối đa 24W；Tối đa 15W</li>
                                <li><strong>hệ số công suất:</strong> 0,9</li>
                                <li><strong>Chứa:</strong> Trình điều khiển x1, hướng dẫn sử dụng x1, gói phụ kiện vít x1</li>
                            </ul>
                            <h3>Tương thích nhiều loại đèn</h3>
                            <p>Một trong những tính năng nổi bật của Aqara Smart Dimmer T2 là khả năng tương thích với nhiều loại nguồn sáng, bao gồm bóng đèn sợi đốt, đèn LED và đèn huỳnh quang. Tính linh hoạt này đảm bảo rằng bạn có thể dễ dàng tích hợp nó vào hệ thống chiếu sáng hiện tại của mình mà không gặp bất kỳ rắc rối nào. Ngoài ra, thiết kế nhỏ gọn và kiểu dáng đẹp của nó mang lại cảm giác sang trọng cho bất kỳ căn phòng nào.</p>
                            <h3>Kiểm soát từ xa thông qua ứng dụng di động</h3>
                            <p>Với bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2, bạn có thể kiểm soát ánh sáng từ xa thông qua ứng dụng di động. Bạn có thể bật tắt đèn, điều chỉnh độ sáng, và chọn các chế độ ánh sáng theo ý muốn chỉ trong vài thao tác đơn giản trên điện thoại di động của mình, bất kể bạn đang ở đâu.</p>
                            <h3>Tích hợp công nghệ Zigbee 3.0</h3>
                            <p>Bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 Module tích hợp công nghệ Zigbee 3.0, cho phép nó kết nối và điều khiển đèn led thông qua chuẩn kết nối Zigbee. Điều này mang lại một trải nghiệm tốt hơn trong việc kiểm soát ánh sáng mà không cần đến các thiết bị trung gian khác.</p>
                            <h3>Kết hợp với các thiết bị Aqara Home</h3>
                            <p>Bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 Module có khả năng kết hợp với các thiết bị thông minh Aqara trong ngôi nhà của bạn. Bạn có thể tạo lập các kịch bản tự động và kết hợp với các thiết bị như cảm biến chuyển động, nhiệt độ, hoặc công tắc thông minh để tạo ra một hệ thống thông minh toàn diện.</p>
                            <p>Việc sử dụng bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 Module mang lại tiện ích và linh hoạt trong việc điều khiển ánh sáng. Bạn không chỉ có thể kiểm soát ánh sáng từ xa thông qua ứng dụng di động, mà còn có khả năng thiết lập các chế độ ánh sáng và tạo lịch trình theo ý muốn.</p>
                            <h3>Thiết lập các chế độ ánh sáng</h3>
                            <p>Sau khi cài đặt và kết nối thành công, bạn có thể thiết lập các chế độ ánh sáng thông qua ứng dụng di động. Bạn có thể điều chỉnh độ sáng và ánh sáng theo ý muốn để tạo ra không gian sống phù hợp với sở thích của mình.</p>
                            <h3>Tạo lịch trình cho ánh sáng</h3>
                            <p>Tính năng tạo lịch trình của bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 cho phép bạn thiết lập các thời gian khác nhau trong ngày mà ánh sáng sẽ tự động thay đổi theo. Bạn có thể thiết lập một lịch trình hằng ngày hoặc tùy chỉnh theo các yêu cầu riêng của mình.</p>
                            <h3>Tích hợp và tương thích với hệ sinh thái thông minh hiện có</h3>
                            <p>Bộ điều khiển độ sáng thông minh Aqara Smart Dimmer T2 được thiết kế để tích hợp và tương thích với các hệ thống thông minh Aqara Home. Bạn có thể kết hợp nó với các thiết bị thông minh khác như cảm biến, nút bấm thông minh và bộ điều khiển giọng nói để tạo ra một hệ sinh thái thông minh hoàn chỉnh trong ngôi nhà của bạn.</p>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button id="read-more-btn" class="text-blue-500 hover:underline hidden">Xem thêm</button>
                        <button id="collapse-btn" class="text-blue-500 hover:underline hidden">Thu gọn</button>
                    </div>
                </div>
            </div>

            <!-- ================================================================= -->
            <!-- Sidebar Section -->
            <!-- ================================================================= -->
            <div class="sidebar">
                <div class="bg-white p-6 rounded-lg shadow-md border">
                    <h3 class="text-2xl font-bold mb-6 text-black" style="color: black !important;">Bài viết gần đây</h3>
                    <?php
                    $recent_posts = get_posts(array(
                        'numberposts' => 4,
                        'post_status' => 'publish'
                    ));
                    if ($recent_posts) {
                        foreach ($recent_posts as $post) : setup_postdata($post);
                    ?>
                        <div class="flex items-start mb-5">
                            <?php if (has_post_thumbnail()) : ?>
                            <div class="w-20 h-20 mr-4 flex-shrink-0">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover rounded-lg']); ?>
                                </a>
                            </div>
                            <?php endif; ?>
                            <div class="flex-grow">
                                <h4 class="font-semibold leading-tight mb-1"><a href="<?php the_permalink(); ?>" class="hover:text-blue-500"><?php the_title(); ?></a></h4>
                                <a href="<?php the_permalink(); ?>" class="text-sm text-blue-500 hover:underline">Xem thêm &rarr;</a>
                            </div>
                        </div>
                    <?php 
                        endforeach; 
                        wp_reset_postdata();
                    } else {
                        echo '<p>Chưa có bài viết nào.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- Mini Banner Section -->
        <!-- ================================================================= -->
        <div class="my-12">
            <div class="bg-gray-100 rounded-lg p-8 text-center shadow-md border border-blue-300">
                <h3 class="text-2xl font-bold" style="color: #93C5FD !important;">Chiếu sáng mạnh mẽ, tiết kiệm điện – Virical Stadium Light 500W.</h3>
            </div>
        </div>

        <section class="bg-white py-12">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center text-center -mx-4">
                    <div class="w-full md:w-1/4 px-4 mb-8">
                        <div class="text-gray-600 mx-auto mb-4">
                            <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-4.243-4.243l3.275-3.275a4.5 4.5 0 00-6.336 4.486c.046.58.193 1.193.357 1.743m-.24 2.496a3.75 3.75 0 10-5.303-5.303l-1.21 1.21a.75.75 0 001.06 1.06l1.21-1.21z" />
                            </svg>
                        </div>
                        <p class="font-bold text-gray-800">Bảo hành 1 đổi 1 trong 15 tháng</p>
                    </div>
                    <div class="w-full md:w-1/4 px-4 mb-8">
                        <div class="text-gray-600 mx-auto mb-4">
                            <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <p class="font-bold text-gray-800">Bảo hành nhanh chóng</p>
                    </div>
                    <div class="w-full md:w-1/4 px-4 mb-8">
                        <div class="text-gray-600 mx-auto mb-4">
                            <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286zm0 13.036h.008v.008h-.008v-.008z" />
                            </svg>
                        </div>
                        <p class="font-bold text-gray-800">Hỗ trợ khách trọn đời</p>
                    </div>
                    <div class="w-full md:w-1/4 px-4 mb-8">
                        <div class="text-gray-600 mx-auto mb-4">
                            <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                        </div>
                        <p class="font-bold text-gray-800">Vận chuyển hoả tốc toàn quốc</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================================================================= -->
        <!-- Related Products Section -->
        <!-- ================================================================= -->
        <div class="my-12">
            <h2 class="text-3xl font-bold mb-6 text-black" style="color: black !important;">Sản phẩm liên quan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php 
                if ($related_products) {
                    foreach ($related_products as $related_product): ?>
                        <div class="border rounded-lg overflow-hidden shadow-lg text-center bg-white hover:shadow-xl transition-shadow">
                            <a href="<?php echo home_url('/san-pham/' . $related_product->slug . '/'); ?>">
                                <img src="<?php echo esc_url($related_product->image_url); ?>" alt="<?php echo esc_attr($related_product->name); ?>" class="w-full h-56 object-contain">
                            </a>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2"><a href="<?php echo home_url('/san-pham/' . $related_product->slug . '/'); ?>" class="hover:text-blue-500"><?php echo esc_html($related_product->name); ?></a></h3>
                                <a href="#contact-form" class="btn btn-blue px-6 py-2 rounded-lg font-semibold text-sm">LIÊN HỆ</a>
                            </div>
                        </div>
                    <?php 
                    endforeach;
                } else {
                    echo '<p>Không có sản phẩm liên quan.</p>';
                }
                ?>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Read more/collapse for product description
    const description = document.getElementById('product-description');
    const readMoreBtn = document.getElementById('read-more-btn');
    const collapseBtn = document.getElementById('collapse-btn');

    if (description.scrollHeight > 300) {
        readMoreBtn.classList.remove('hidden');
    } else {
        readMoreBtn.classList.add('hidden');
    }

    readMoreBtn.addEventListener('click', function() {
        description.style.maxHeight = description.scrollHeight + 'px';
        readMoreBtn.classList.add('hidden');
        collapseBtn.classList.remove('hidden');
    });

    collapseBtn.addEventListener('click', function() {
        description.style.maxHeight = '300px';
        readMoreBtn.classList.remove('hidden');
        collapseBtn.classList.add('hidden');
    });

    // Tabs for product info
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content-item');

    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            tabLinks.forEach(l => {
                l.classList.remove('active', 'bg-white', 'text-gray-800');
                l.classList.add('text-gray-600');
            });
            
            this.classList.add('active', 'bg-white', 'text-gray-800');
            this.classList.remove('text-gray-600');
            
            const tabId = this.getAttribute('data-tab');
            
            tabContents.forEach(content => {
                if (content.id === tabId) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        });
    });

    // Store tabs
    const storeTabLinks = document.querySelectorAll('.store-tab-link');
    const storeTabContents = document.querySelectorAll('.store-tab-content-item');

    storeTabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            storeTabLinks.forEach(l => {
                l.classList.remove('active', 'bg-blue-500', 'text-white', 'rounded-t-lg');
                l.classList.add('text-gray-600');
            });
            
            this.classList.add('active', 'bg-blue-500', 'text-white', 'rounded-t-lg');
            this.classList.remove('text-gray-600');
            
            const tabId = this.getAttribute('data-tab');
            
            storeTabContents.forEach(content => {
                if (content.id === tabId) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        });
    });
});
</script>
<?php
get_footer();
?>