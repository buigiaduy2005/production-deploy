<?php
/**
 * The template for displaying single products using the standard WordPress loop.
 *
 * @package Virical
 */

get_header();
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
    .product-description h3 {
        font-size: 20px;
        font-weight: 600;
        color: #1E40AF;
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .service-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .related-product-card a {
        text-decoration: none;
    }
    .related-product-card .price {
        font-size: 1.1rem;
    }
    .recent-post-item h4 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4;
        height: calc(1.4em * 2);
    }
    
    /* Product Description Image Styles */
    .product-description img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .product-description .wp-block-image {
        margin: 20px 0;
        text-align: center;
    }
    
    .product-description .wp-block-gallery {
        margin: 20px 0;
    }
    
    .product-description .wp-block-gallery .blocks-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .product-description .wp-block-gallery .blocks-gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    /* Responsive images */
    @media (max-width: 768px) {
        .product-description .wp-block-gallery .blocks-gallery-grid {
            grid-template-columns: 1fr;
        }
        
        .product-description .wp-block-gallery .blocks-gallery-item img {
            height: 250px;
        }
    }
</style>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-24">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <!-- Breadcrumb -->
    <nav class="breadcrumb text-sm mb-8">
        <a href="/">Trang chủ</a> &gt;
        <a href="/san-pham">Sản phẩm</a> &gt;
        <span class="text-gray-500"><?php the_title(); ?></span>
    </nav>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-12">

            <!-- Main Content -->
            <div class="lg:col-span-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Left: Product Image -->
                    <div class="product-image-container rounded-lg shadow-sm">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title_attribute(); ?>" class="product-image w-full h-auto object-cover rounded-lg">
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri() . '/assets/images/default-product.jpg'; ?>" alt="Placeholder Image" class="product-image w-full h-auto object-cover rounded-lg">
                        <?php endif; ?>
                    </div>

                    <!-- Right: Product Info -->
                    <div class="flex flex-col space-y-4">
                        <h1 class="text-3xl font-bold text-black" style="color: black !important;"><?php the_title(); ?></h1>
                        
                        <div class="text-xl font-semibold text-blue-600">
                            Hãy liên hệ với chúng tôi để được giá ưu đãi nhất
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <a href="/lien-he/" class="px-6 py-3 text-center bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 transition-colors w-full">Liên hệ</a>
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
                    <div id="product-description-content" class="prose max-w-none text-gray-700 leading-relaxed" style="max-height: 200px; overflow: hidden; position: relative;">
                        <?php the_content(); ?>
                    </div>
                    <button id="read-more-btn" class="text-blue-600 hover:underline mt-4" style="display: none;">Xem thêm</button>
                </div>

                <!-- Related Products Section -->
                <div class="related-products mt-12">
                    <h2 class="text-2xl font-bold text-black mb-6" style="color: black !important;">Sản phẩm liên quan</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        <?php
                        $related_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()),
                            'orderby' => 'rand'
                        );
                        $related_products = new WP_Query($related_args);
                        if ($related_products->have_posts()) :
                            while ($related_products->have_posts()) : $related_products->the_post();
                        ?>
                        <div class="related-product-card bg-white rounded-lg shadow-sm overflow-hidden text-center transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title(); ?>" class="w-full h-48 object-cover">
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri() . '/assets/images/default-product.jpg'; ?>" alt="Placeholder Image" class="w-full h-48 object-cover">
                                <?php endif; ?>
                            </a>
                            <div class="p-4">
                                <h3 class="font-medium text-black"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="price mt-2">
                                    <span class="font-bold text-blue-600">Liên hệ</span>
                                </div>
                                <div class="buttons mt-4 space-y-2">
                                    <a href="<?php the_permalink(); ?>" class="block w-full bg-white border border-blue-600 text-blue-600 py-2 rounded-md hover:bg-blue-50 transition-colors">Xem chi tiết</a>
                                    <a href="/lien-he/" class="block w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">Mua ngay</a>
                                </div>
                            </div>
                        </div>
                        <?php
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
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
                            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                                <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                            </svg>
                            <span>Hoàn tiền 100% nếu phát hiện hàng giả</span>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-md">
                            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                                <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595L7.5 7.915A1.5 1.5 0 1 1 9.5 6.5"/>
                            </svg>
                            <span>Đổi trả trong 7 ngày nếu lỗi</span>
                        </div>
                    </div>
                </div>

                <!-- Store System -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <h3 class="text-center font-bold text-black uppercase tracking-wider text-sm mb-4" style="color: black !important;">Hệ thống cửa hàng</h3>
                    
                    <!-- Tabs -->
                    <div class="flex mb-4">
                        <button class="store-tab active flex-1 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-l-md" data-region="north">Miền Bắc</button>
                        <button class="store-tab flex-1 px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-r-md" data-region="central">Miền Trung</button>
                    </div>
                    
                    <!-- Store Content -->
                    <div class="store-content">
                        <div class="store-region active" data-region="north">
                            <div class="space-y-3 text-gray-600 text-sm">
                                <div class="flex items-start p-3 bg-gray-50 rounded-md">
                                    <svg class="w-4 h-4 text-gray-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Số 63A Phố Vọng, Phường Đồng Tâm, Quận Hai Bà Trưng, Hà Nội</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="store-region" data-region="central" style="display: none;">
                            <div class="space-y-3 text-gray-600 text-sm">
                                <div class="flex items-start p-3 bg-gray-50 rounded-md">
                                    <svg class="w-4 h-4 text-gray-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>1019 Trần Hưng Đạo, P. Vân Giang, TP Ninh Bình</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="recent-posts-widget bg-white p-6 rounded-lg shadow-sm mt-12">
                    <h3 class="text-xl font-bold text-black mb-4" style="color: #000 !important;">Bài viết gần đây</h3>
                    <div class="space-y-4">
                        <?php
                        $recent_posts_args = array(
                            'post_type' => array('post', 'blog_post'),
                            'posts_per_page' => 6,
                            'post_status' => 'publish',
                        );
                        $recent_posts = new WP_Query($recent_posts_args);
                        if ($recent_posts->have_posts()) :
                            while ($recent_posts->have_posts()) : $recent_posts->the_post();
                        ?>
                        <div class="recent-post-item border-b border-gray-200 pb-4 last:border-b-0">
                            <a href="<?php the_permalink(); ?>" class="flex space-x-4 group">
                                <div class="flex-shrink-0">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php the_post_thumbnail_url(array(80, 80)); ?>" alt="<?php the_title(); ?>" class="w-20 h-20 object-cover rounded-md transition-transform duration-200 group-hover:scale-105">
                                    <?php else : ?>
                                        <div class="w-20 h-20 bg-gray-200 rounded-md"></div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-black leading-tight group-hover:text-blue-600 transition-colors"><?php the_title(); ?></h4>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <span><?php echo get_the_date('d/m/Y'); ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                    <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="block text-center w-full bg-gray-100 text-gray-700 py-2 mt-6 rounded-md hover:bg-gray-200 transition-colors">Xem thêm bài viết</a>
                </div>
            </div>
        </div>

    <?php endwhile; else : ?>

        <p class="text-center text-2xl">Sản phẩm không được tìm thấy.</p>

    <?php endif; ?>

</div>

<script>
jQuery(document).ready(function($) {
    var descContent = $('#product-description-content');
    var readMoreBtn = $('#read-more-btn');
    var maxHeight = 200;

    // Check if the content is taller than the max height
    if (descContent[0].scrollHeight > maxHeight) {
        readMoreBtn.show(); // Show the button if content is truncated

        readMoreBtn.on('click', function() {
            if (descContent.hasClass('expanded')) {
                // Collapse the content
                descContent.animate({ 'max-height': maxHeight + 'px' }, 200);
                descContent.removeClass('expanded');
                $(this).text('Xem thêm');
            } else {
                // Expand the content
                descContent.animate({ 'max-height': descContent[0].scrollHeight + 'px' }, 200);
                descContent.addClass('expanded');
                $(this).text('Ẩn bớt');
            }
        });
    }

    // Store tabs functionality
    $('.store-tab').on('click', function() {
        var region = $(this).data('region');
        
        // Update tab appearance
        $('.store-tab').removeClass('active bg-blue-600 text-white').addClass('bg-gray-200 text-gray-700');
        $(this).removeClass('bg-gray-200 text-gray-700').addClass('active bg-blue-600 text-white');
        
        // Show/hide content
        $('.store-region').hide().removeClass('active');
        $('.store-region[data-region="' + region + '"]').show().addClass('active');
    });
});
</script>

<?php get_footer(); ?>
