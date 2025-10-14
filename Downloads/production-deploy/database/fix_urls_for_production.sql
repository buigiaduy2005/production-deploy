-- ===================================
-- FIX URLs FOR PRODUCTION DEPLOYMENT
-- ===================================
-- This script updates all localhost URLs to production domain
-- Run this AFTER importing database to production hosting
--
-- IMPORTANT: Update 'https://virical.vn' below with your actual production domain
-- IMPORTANT: Update 'http://localhost:8082' if your local port is different
--
-- Usage:
--   mysql -u YOUR_USER -p YOUR_DATABASE < fix_urls_for_production.sql
--
-- Created: 2025-09-30
-- ===================================

-- Set charset to handle Vietnamese characters properly
SET NAMES utf8mb4;

-- Start transaction
START TRANSACTION;

-- ===================================
-- STEP 1: Update WordPress Core URLs
-- ===================================
UPDATE wp_options
SET option_value = 'https://virical.vn'
WHERE option_name IN ('siteurl', 'home');

-- ===================================
-- STEP 2: Update Posts Content
-- ===================================
-- Replace localhost:8082 URLs in post content
UPDATE wp_posts
SET post_content = REPLACE(post_content, 'http://localhost:8082', 'https://virical.vn')
WHERE post_content LIKE '%localhost:8082%';

-- Replace localhost:9000 URLs (if any old URLs exist)
UPDATE wp_posts
SET post_content = REPLACE(post_content, 'http://localhost:9000', 'https://virical.vn')
WHERE post_content LIKE '%localhost:9000%';

-- Replace any non-SSL virical.vn URLs
UPDATE wp_posts
SET post_content = REPLACE(post_content, 'http://virical.vn', 'https://virical.vn')
WHERE post_content LIKE '%http://virical.vn%';

-- ===================================
-- STEP 3: Update Post GUIDs
-- ===================================
-- Note: WordPress documentation says GUIDs should not be changed,
-- but for domain migration it's necessary
UPDATE wp_posts
SET guid = REPLACE(guid, 'http://localhost:8082', 'https://virical.vn')
WHERE guid LIKE '%localhost:8082%';

UPDATE wp_posts
SET guid = REPLACE(guid, 'http://localhost:9000', 'https://virical.vn')
WHERE guid LIKE '%localhost:9000%';

UPDATE wp_posts
SET guid = REPLACE(guid, 'http://virical.vn', 'https://virical.vn')
WHERE guid LIKE '%http://virical.vn%';

-- ===================================
-- STEP 4: Update Post Meta
-- ===================================
UPDATE wp_postmeta
SET meta_value = REPLACE(meta_value, 'http://localhost:8082', 'https://virical.vn')
WHERE meta_value LIKE '%localhost:8082%';

UPDATE wp_postmeta
SET meta_value = REPLACE(meta_value, 'http://localhost:9000', 'https://virical.vn')
WHERE meta_value LIKE '%localhost:9000%';

UPDATE wp_postmeta
SET meta_value = REPLACE(meta_value, 'http://virical.vn', 'https://virical.vn')
WHERE meta_value LIKE '%http://virical.vn%';

-- ===================================
-- STEP 5: Update Custom Tables - Products
-- ===================================
-- Fix virical_products table
UPDATE wp_virical_products
SET image_url = REPLACE(image_url, 'http://localhost:8082', 'https://virical.vn')
WHERE image_url LIKE '%localhost:8082%';

UPDATE wp_virical_products
SET image_url = REPLACE(image_url, 'http://localhost:9000', 'https://virical.vn')
WHERE image_url LIKE '%localhost:9000%';

UPDATE wp_virical_products
SET image_url = REPLACE(image_url, 'http://virical.vn', 'https://virical.vn')
WHERE image_url LIKE '%http://virical.vn%';

-- Fix indoor_products table
UPDATE wp_indoor_products
SET image_url = REPLACE(image_url, 'http://localhost:8082', 'https://virical.vn')
WHERE image_url LIKE '%localhost:8082%';

UPDATE wp_indoor_products
SET image_url = REPLACE(image_url, 'http://localhost:9000', 'https://virical.vn')
WHERE image_url LIKE '%localhost:9000%';

UPDATE wp_indoor_products
SET image_url = REPLACE(image_url, 'http://virical.vn', 'https://virical.vn')
WHERE image_url LIKE '%http://virical.vn%';

-- ===================================
-- STEP 6: Update Custom Tables - Projects
-- ===================================
UPDATE wp_virical_projects
SET featured_image = REPLACE(featured_image, 'http://localhost:8082', 'https://virical.vn')
WHERE featured_image LIKE '%localhost:8082%';

UPDATE wp_virical_projects
SET featured_image = REPLACE(featured_image, 'http://localhost:9000', 'https://virical.vn')
WHERE featured_image LIKE '%localhost:9000%';

UPDATE wp_virical_projects
SET featured_image = REPLACE(featured_image, 'http://virical.vn', 'https://virical.vn')
WHERE featured_image LIKE '%http://virical.vn%';

-- ===================================
-- STEP 7: Update Serialized Data in Options
-- ===================================
-- Fix serialized data string lengths (WordPress stores data with string length prefixes)
-- This is a simple approach - for complex serialized data, use WP-CLI or Better Search Replace plugin

-- Common serialized patterns
UPDATE wp_options
SET option_value = REPLACE(option_value, 's:22:"http://localhost:8082"', 's:19:"https://virical.vn"')
WHERE option_value LIKE '%s:22:"http://localhost:8082"%';

UPDATE wp_options
SET option_value = REPLACE(option_value, 's:22:"http://localhost:9000"', 's:19:"https://virical.vn"')
WHERE option_value LIKE '%s:22:"http://localhost:9000"%';

UPDATE wp_options
SET option_value = REPLACE(option_value, 's:18:"http://virical.vn"', 's:19:"https://virical.vn"')
WHERE option_value LIKE '%s:18:"http://virical.vn"%';

-- ===================================
-- STEP 8: Update Indoor Page Settings (if table exists)
-- ===================================
UPDATE wp_indoor_page_settings
SET setting_value = REPLACE(setting_value, 'http://localhost:8082', 'https://virical.vn')
WHERE setting_value LIKE '%localhost:8082%';

UPDATE wp_indoor_page_settings
SET setting_value = REPLACE(setting_value, 'http://localhost:9000', 'https://virical.vn')
WHERE setting_value LIKE '%localhost:9000%';

UPDATE wp_indoor_page_settings
SET setting_value = REPLACE(setting_value, 'http://virical.vn', 'https://virical.vn')
WHERE setting_value LIKE '%http://virical.vn%';

-- ===================================
-- STEP 9: Flush WordPress Caches
-- ===================================
-- Clear transients
DELETE FROM wp_options
WHERE option_name LIKE '%_transient_%';

-- ===================================
-- VERIFICATION QUERIES
-- ===================================
-- Run these after the script to verify all URLs are updated

-- Check wp_options
SELECT 'wp_options' as table_name, option_name, option_value
FROM wp_options
WHERE option_value LIKE '%localhost%'
   OR option_value LIKE '%http://virical.vn%'
LIMIT 10;

-- Check wp_posts
SELECT 'wp_posts' as table_name, ID, post_title, guid
FROM wp_posts
WHERE guid LIKE '%localhost%'
   OR guid LIKE '%http://virical.vn%'
LIMIT 10;

-- Check wp_virical_products
SELECT 'wp_virical_products' as table_name, product_id, product_name, image_url
FROM wp_virical_products
WHERE image_url LIKE '%localhost%'
   OR image_url LIKE '%http://virical.vn%'
LIMIT 10;

-- Check wp_indoor_products
SELECT 'wp_indoor_products' as table_name, id, product_name, image_url
FROM wp_indoor_products
WHERE image_url LIKE '%localhost%'
   OR image_url LIKE '%http://virical.vn%'
LIMIT 10;

-- ===================================
-- Commit transaction
-- ===================================
COMMIT;

-- ===================================
-- SUCCESS MESSAGE
-- ===================================
SELECT 'URL migration completed successfully!' as status,
       'Please verify the results above and test your website.' as next_step;

-- ===================================
-- IMPORTANT NOTES
-- ===================================
-- After running this script:
-- 1. Log into WordPress admin panel
-- 2. Go to Settings > Permalinks and click "Save Changes" (flush rewrite rules)
-- 3. Go to Settings > General and verify site URLs
-- 4. Clear any caching plugins
-- 5. Test all pages, especially:
--    - Homepage
--    - Product pages
--    - Indoor/Outdoor pages
--    - Contact page
--    - Check all images are loading
-- 6. If using CDN, purge CDN cache
--
-- For complex serialized data issues, consider using:
-- - WP-CLI: wp search-replace 'http://localhost:8082' 'https://virical.vn' --all-tables
-- - Better Search Replace plugin
-- ===================================