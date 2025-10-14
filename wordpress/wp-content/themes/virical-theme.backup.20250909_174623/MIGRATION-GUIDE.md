# Hướng dẫn Migration từ Aura sang Virical

## Tổng quan
Hệ thống đã được chuẩn bị để chuyển đổi từ Aura (WordPress Custom Post Type) sang Virical (Custom Tables). Quá trình này được thiết kế để an toàn và không mất dữ liệu.

## Các bước thực hiện

### 1. Backup Database (Quan trọng!)
```bash
# Backup toàn bộ database trước khi migration
mysqldump -u [username] -p [database_name] > backup_before_migration.sql
```

### 2. Chạy Migration Tool

1. Vào WordPress Admin
2. Navigate đến: **Sản phẩm Virical** → **Migration Tool**
3. Xem thống kê hiện tại của cả 2 hệ thống
4. Click **"Run Migration"** để bắt đầu
5. Đợi quá trình hoàn tất và xem kết quả

### 3. Cập nhật Menu Links

1. Vào **Sản phẩm Virical** → **Update Menus**
2. Click **"Update Menu Links"** để cập nhật tất cả menu
3. Kiểm tra các menu đã được cập nhật đúng

### 4. Kiểm tra và Verify

#### 4.1 Kiểm tra Products Page
- Truy cập `/san-pham/` - trang sản phẩm mới
- Verify hiển thị đúng categories và products
- Test filter by category

#### 4.2 Kiểm tra Product Details
- Click vào từng sản phẩm
- Verify thông tin hiển thị đầy đủ:
  - Tên sản phẩm
  - Hình ảnh
  - Mô tả
  - Thông số kỹ thuật
  - Tabs (Thông số, Hướng dẫn, Bảo hành)

#### 4.3 Test Redirects
- Truy cập URL cũ: `/products/[product-name]/`
- Verify tự động redirect sang: `/san-pham/[product-name]/`

#### 4.4 Test Search
- Sử dụng search box
- Tìm kiếm sản phẩm theo tên
- Verify kết quả tìm kiếm chính xác

### 5. Cleanup (Tùy chọn)

Sau khi đã verify mọi thứ hoạt động tốt:

1. Vào **Migration Tool**
2. Click **"Preview Cleanup"** để xem trước
3. Click **"Execute Cleanup"** để dọn dẹp dữ liệu cũ

### 6. Tắt Aura Post Type

Edit file `functions.php`, comment out hoặc xóa:

```php
// Comment out these lines after successful migration
// add_action( 'init', 'aura_register_products_post_type' );
// add_action( 'init', 'aura_register_product_categories' );
```

## Các tính năng mới

### 1. Dual System Support
- Hệ thống tự động detect và sử dụng Virical nếu có data
- Có thể force sử dụng system cụ thể: `?system=virical` hoặc `?system=aura`

### 2. Smart Redirects
- Tự động redirect từ URLs cũ sang mới
- SEO-friendly với 301 redirects
- Redirect map được lưu và quản lý

### 3. Enhanced Search
- Search trong custom tables nhanh hơn
- AJAX search với live results
- Search shortcode: `[virical_search]`

### 4. Menu Auto-Update
- Tự động filter và update menu URLs
- Support cả frontend và backend

## Troubleshooting

### Issue: Migration không thành công
- Kiểm tra database permissions
- Verify tables tồn tại: `wp_virical_products`, `wp_virical_product_categories`
- Check error logs trong Migration summary

### Issue: Redirects không hoạt động
- Flush permalinks: Settings → Permalinks → Save
- Clear cache nếu sử dụng caching plugin
- Verify .htaccess writable

### Issue: Search không tìm thấy products
- Verify products đã được migrate (is_active = 1)
- Check AJAX URL trong browser console
- Clear browser cache

### Issue: Menu links sai
- Run Menu Updater tool lại
- Manually check và update nếu cần
- Clear menu cache

## Rollback Plan

Nếu cần rollback:

1. Restore database từ backup
2. Uncomment Aura post type registration
3. Remove hoặc rename các files:
   - `/includes/migrate-aura-to-virical.php`
   - `/includes/product-redirects.php`
   - `/includes/menu-updater.php`
   - `/includes/virical-search.php`

## Support

Nếu gặp vấn đề:
1. Check WordPress debug log
2. Verify database structure
3. Test với theme mặc định để loại trừ conflicts

## Checklist

- [ ] Backup database
- [ ] Run migration tool
- [ ] Update menu links
- [ ] Test product pages
- [ ] Test product details
- [ ] Test redirects
- [ ] Test search functionality
- [ ] Verify SEO URLs
- [ ] Update any hardcoded links
- [ ] Clear all caches
- [ ] Monitor 404 errors
- [ ] Cleanup old data (optional)
- [ ] Disable Aura post type (final step)