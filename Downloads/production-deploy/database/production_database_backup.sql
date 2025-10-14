-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: aura_db
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `wp_about_achievements`
--

DROP TABLE IF EXISTS `wp_about_achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_about_achievements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suffix` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_about_achievements`
--

LOCK TABLES `wp_about_achievements` WRITE;
/*!40000 ALTER TABLE `wp_about_achievements` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_about_achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_about_page_settings`
--

DROP TABLE IF EXISTS `wp_about_page_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_about_page_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `setting_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_about_page_settings`
--

LOCK TABLES `wp_about_page_settings` WRITE;
/*!40000 ALTER TABLE `wp_about_page_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_about_page_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_about_partners`
--

DROP TABLE IF EXISTS `wp_about_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_about_partners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_about_partners`
--

LOCK TABLES `wp_about_partners` WRITE;
/*!40000 ALTER TABLE `wp_about_partners` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_about_partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_about_story_sections`
--

DROP TABLE IF EXISTS `wp_about_story_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_about_story_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_about_story_sections`
--

LOCK TABLES `wp_about_story_sections` WRITE;
/*!40000 ALTER TABLE `wp_about_story_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_about_story_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_about_team_members`
--

DROP TABLE IF EXISTS `wp_about_team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_about_team_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_about_team_members`
--

LOCK TABLES `wp_about_team_members` WRITE;
/*!40000 ALTER TABLE `wp_about_team_members` DISABLE KEYS */;
INSERT INTO `wp_about_team_members` VALUES (1,'ĐỖ NGỌC PHI','Giám đốc Điều hành / Người đại diện pháp luật','Với hơn 15 năm kinh nghiệm trong ngành chiếu sáng, ông Phi đã dẫn dắt VIRICAL VIET NAM JOINT STOCK COMPANY trở thành thương hiệu hàng đầu tại Việt Nam. Là người đại diện pháp luật của công ty, ông cam kết mang đến những giải pháp chiếu sáng chất lượng cao và dịch vụ tốt nhất cho khách hàng.','https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400','phi@virical.vn','0869995698','https://linkedin.com/in/nguyenvanan',1,1,'2025-09-09 18:41:23','2025-09-11 16:37:11'),(2,'Trần Thị Mai','Giám đốc Sáng tạo','ChuyÃªn gia thiáº¿t káº¿ Ã¡nh sÃ¡ng vá»›i nhiá»u giáº£i thÆ°á»Ÿng quá»‘c táº¿, bÃ  Mai mang Ä‘áº¿n nhá»¯ng giáº£i phÃ¡p chiáº¿u sÃ¡ng Ä‘á»™c Ä‘Ã¡o cho má»i dá»± Ã¡n.','https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400','creative@virical.vn','0903.234.567','https://linkedin.com/in/tranthimai',2,1,'2025-09-09 18:41:23','2025-09-11 16:16:04'),(3,'Phạm Đức Huy','Giám đốc Kỹ thuật','Ká»¹ sÆ° Ä‘iá»‡n vá»›i chuyÃªn mÃ´n cao vá» há»‡ thá»‘ng chiáº¿u sÃ¡ng thÃ´ng minh vÃ  IoT, Ä‘áº£m báº£o cháº¥t lÆ°á»£ng ká»¹ thuáº­t cho má»i sáº£n pháº©m.','https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400','technical@virical.vn','0903.345.678','https://linkedin.com/in/phamduchuy',3,1,'2025-09-09 18:41:23','2025-09-11 16:16:04'),(4,'Lê Thị Hương','Giám đốc Kinh doanh','ChuyÃªn gia tÆ° váº¥n giáº£i phÃ¡p chiáº¿u sÃ¡ng cho doanh nghiá»‡p vá»›i hÆ¡n 10 nÄƒm kinh nghiá»‡m trong lÄ©nh vá»±c B2B.','https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400','sales@virical.vn','0903.456.789','https://linkedin.com/in/lethihuong',4,1,'2025-09-09 18:41:23','2025-09-11 16:16:13');
/*!40000 ALTER TABLE `wp_about_team_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_about_values`
--

DROP TABLE IF EXISTS `wp_about_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_about_values` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_about_values`
--

LOCK TABLES `wp_about_values` WRITE;
/*!40000 ALTER TABLE `wp_about_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_about_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_commentmeta`
--

LOCK TABLES `wp_commentmeta` WRITE;
/*!40000 ALTER TABLE `wp_commentmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_commentmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_author_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_karma` int NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_comments`
--

LOCK TABLES `wp_comments` WRITE;
/*!40000 ALTER TABLE `wp_comments` DISABLE KEYS */;
INSERT INTO `wp_comments` VALUES (1,1,'Một người bình luận WordPress','wapuu@wordpress.example','https://vi.wordpress.org/','','2025-07-28 14:12:54','2025-07-28 14:12:54','Xin chào, đây là một bình luận.\nĐể bắt đầu kiểm duyệt, chỉnh sửa và xóa nhận xét, vui lòng truy cập màn hình Nhận xét trong trang quản trị.\nHình đại diện của người bình luận đến từ <a href=\"https://gravatar.com/\">Gravatar</a>.',0,'1','','comment',0,0);
/*!40000 ALTER TABLE `wp_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_company_registration`
--

DROP TABLE IF EXISTS `wp_company_registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_company_registration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `field_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `field_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `field_name` (`field_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_company_registration`
--

LOCK TABLES `wp_company_registration` WRITE;
/*!40000 ALTER TABLE `wp_company_registration` DISABLE KEYS */;
INSERT INTO `wp_company_registration` VALUES (1,'official_name','VIRICAL VIET NAM JOINT STOCK COMPANY','text',1,'2025-09-11 16:37:53','2025-09-11 16:37:53'),(2,'short_name','VIRICAL.,JSC','text',1,'2025-09-11 16:37:53','2025-09-11 16:37:53'),(3,'legal_representative','ĐỖ NGỌC PHI','text',1,'2025-09-11 16:37:53','2025-09-11 16:37:53'),(4,'establishment_date','2019-06-12','date',1,'2025-09-11 16:37:53','2025-09-11 16:37:53'),(5,'company_type','Công ty cổ phần ngoài NN','text',1,'2025-09-11 16:37:53','2025-09-11 16:37:53'),(6,'registered_address','Số 30 Ngõ 100 Nguyễn Xiển, Phường Hạ Đình, Quận Thanh Xuân, Thành phố Hà Nội, Việt Nam','text',1,'2025-09-11 16:37:53','2025-09-11 16:37:53'),(7,'main_phone','0869995698','phone',1,'2025-09-11 16:37:53','2025-09-11 16:37:53'),(8,'primary_business','Bán buôn đồ dùng khác cho gia đình','text',1,'2025-09-11 16:37:53','2025-09-11 16:37:53'),(9,'business_activities','Bán buôn vali, cặp, túi, ví, hàng da và giả da khác; Bán buôn dược phẩm và dụng cụ y tế; Bán buôn nước hoa, hàng mỹ phẩm và chế phẩm vệ sinh; Bán buôn hàng gốm, sứ, thủy tinh; Bán buôn đồ điện gia dụng, đèn và bộ đèn điện; Bán buôn sách, báo, tạp chí, văn phòng phẩm; Bán buôn dụng cụ thể dục, thể thao','text',1,'2025-09-11 16:37:53','2025-09-11 16:37:53');
/*!40000 ALTER TABLE `wp_company_registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_contact_forms`
--

DROP TABLE IF EXISTS `wp_contact_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_contact_forms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_to` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_contact_forms`
--

LOCK TABLES `wp_contact_forms` WRITE;
/*!40000 ALTER TABLE `wp_contact_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_contact_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_contact_offices`
--

DROP TABLE IF EXISTS `wp_contact_offices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_contact_offices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `is_main` tinyint(1) DEFAULT '0',
  `working_hours` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `is_main` (`is_main`),
  KEY `sort_order` (`sort_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_contact_offices`
--

LOCK TABLES `wp_contact_offices` WRITE;
/*!40000 ALTER TABLE `wp_contact_offices` DISABLE KEYS */;
INSERT INTO `wp_contact_offices` VALUES (1,'Văn phòng chính - Hà Nội (VIRICAL.,JSC)','Số 30 Ngõ 100 Nguyễn Xiển, Phường Hạ Đình, Quận Thanh Xuân, Thành phố Hà Nội, Việt Nam','0869995698','info@virical.vn',21.02851100,105.78244700,1,'Thứ 2 - Thứ 6: 8:00 - 17:30\nThứ 7: 8:00 - 12:00',1,1,'2025-09-09 18:41:49','2025-09-11 16:36:40'),(2,'Showroom Hà Nội','456 Nguyễn Trãi, Thanh Xuân, Hà Nội','024.3555.6789','showroom.hn@virical.vn',20.99837300,105.80952500,0,'Thứ 2 - Chủ nhật: 8:30 - 21:00',2,0,'2025-09-09 18:41:49','2025-09-30 04:09:55'),(3,'Chi nhánh TP.HCM','123 Nguyễn Văn Linh, Quận 7, TP.HCM','028.3777.8888','hcm@virical.vn',10.72971600,106.71982700,0,'Thứ 2 - Thứ 6: 8:00 - 17:30\nThứ 7: 8:00 - 12:00',3,0,'2025-09-09 18:41:49','2025-09-30 04:09:55'),(4,'Showroom TP.HCM','789 Lê Văn Sỹ, Quận 3, TP.HCM','028.3999.5555','showroom.hcm@virical.vn',10.78684000,106.68113000,0,'Thứ 2 - Chủ nhật: 8:30 - 21:00',4,0,'2025-09-09 18:41:49','2025-09-30 04:09:55');
/*!40000 ALTER TABLE `wp_contact_offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_contact_page_settings`
--

DROP TABLE IF EXISTS `wp_contact_page_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_contact_page_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `setting_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_contact_page_settings`
--

LOCK TABLES `wp_contact_page_settings` WRITE;
/*!40000 ALTER TABLE `wp_contact_page_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_contact_page_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_contact_social_links`
--

DROP TABLE IF EXISTS `wp_contact_social_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_contact_social_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `platform` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_contact_social_links`
--

LOCK TABLES `wp_contact_social_links` WRITE;
/*!40000 ALTER TABLE `wp_contact_social_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_contact_social_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_contact_submissions`
--

DROP TABLE IF EXISTS `wp_contact_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_contact_submissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `form_id` int NOT NULL,
  `submission_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `is_read` (`is_read`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_contact_submissions`
--

LOCK TABLES `wp_contact_submissions` WRITE;
/*!40000 ALTER TABLE `wp_contact_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_contact_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_homepage_sections`
--

DROP TABLE IF EXISTS `wp_homepage_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_homepage_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_key` (`section_key`),
  KEY `sort_order` (`sort_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_homepage_sections`
--

LOCK TABLES `wp_homepage_sections` WRITE;
/*!40000 ALTER TABLE `wp_homepage_sections` DISABLE KEYS */;
INSERT INTO `wp_homepage_sections` VALUES (1,'about','About Us',NULL,NULL,'{\"title\":\"About Virical\",\"subtitle\":\"\",\"content\":\"\",\"image\":\"\",\"button_text\":\"Learn More\",\"button_link\":\"\\/about-us\"}',0,1,'2025-08-11 12:29:43'),(2,'products','Featured Products',NULL,NULL,'{\"title\":\"Our Products\",\"subtitle\":\"\",\"count\":8,\"featured_only\":false}',1,1,'2025-08-11 12:29:43'),(3,'projects','Recent Projects',NULL,NULL,'{\"title\":\"Recent Projects\",\"subtitle\":\"\",\"count\":6,\"featured_only\":false}',2,1,'2025-08-11 12:29:43'),(4,'categories','Product Categories',NULL,NULL,'{\"title\":\"Product Categories\",\"subtitle\":\"\",\"categories\":[]}',3,1,'2025-08-11 12:29:43'),(5,'cta','Call to Action',NULL,NULL,'{\"title\":\"Ready to Get Started?\",\"subtitle\":\"\",\"background\":\"\",\"button_text\":\"Contact Us\",\"button_link\":\"\\/contact\"}',4,1,'2025-08-11 12:29:43');
/*!40000 ALTER TABLE `wp_homepage_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_homepage_settings`
--

DROP TABLE IF EXISTS `wp_homepage_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_homepage_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `setting_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_homepage_settings`
--

LOCK TABLES `wp_homepage_settings` WRITE;
/*!40000 ALTER TABLE `wp_homepage_settings` DISABLE KEYS */;
INSERT INTO `wp_homepage_settings` VALUES (1,'hero_height','full','text','2025-08-11 12:29:43'),(2,'hero_overlay','50','text','2025-08-11 12:29:43'),(3,'slider_autoplay','1','text','2025-08-11 12:29:43'),(4,'slider_speed','5000','text','2025-08-11 12:29:43'),(5,'section_animation','1','text','2025-08-11 12:29:43'),(6,'meta_title','','text','2025-08-11 12:29:43'),(7,'meta_description','','text','2025-08-11 12:29:43'),(8,'og_image','','text','2025-08-11 12:29:43'),(9,'schema_type','Organization','text','2025-08-11 12:29:43'),(10,'outdoor_link','/outdoor','url','2025-09-10 13:14:11'),(11,'outdoor_section_title','Outdoor','text','2025-09-10 13:15:11'),(12,'outdoor_section_link','/outdoor','url','2025-09-10 13:15:11'),(13,'indoor_section_link','/indoor','url','2025-09-10 13:15:11'),(14,'company_international_name','VIRICAL VIET NAM JOINT STOCK COMPANY','text','2025-09-11 16:36:50'),(15,'company_short_name','VIRICAL.,JSC','text','2025-09-11 16:36:50'),(16,'company_representative','ĐỖ NGỌC PHI','text','2025-09-11 16:36:50'),(17,'company_phone','0869995698','text','2025-09-11 16:36:50'),(18,'company_established_date','2019-06-12','date','2025-09-11 16:36:50'),(19,'company_type','Công ty cổ phần ngoài NN','text','2025-09-11 16:36:50'),(20,'company_main_business','Bán buôn đồ dùng khác cho gia đình','text','2025-09-11 16:36:50'),(21,'company_address','Số 30 Ngõ 100 Nguyễn Xiển, Phường Hạ Đình, Quận Thanh Xuân, Thành phố Hà Nội, Việt Nam','text','2025-09-11 16:36:50'),(22,'company_business_details','Bán buôn vali, cặp, túi, ví, hàng da và giả da khác; Bán buôn dược phẩm và dụng cụ y tế; Bán buôn nước hoa, hàng mỹ phẩm và chế phẩm vệ sinh; Bán buôn hàng gốm, sứ, thủy tinh; Bán buôn đồ điện gia dụng, đèn và bộ đèn điện; Bán buôn sách, báo, tạp chí, văn phòng phẩm; Bán buôn dụng cụ thể dục, thể thao','text','2025-09-11 16:37:01');
/*!40000 ALTER TABLE `wp_homepage_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_homepage_sliders`
--

DROP TABLE IF EXISTS `wp_homepage_sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_homepage_sliders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_text` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_homepage_sliders`
--

LOCK TABLES `wp_homepage_sliders` WRITE;
/*!40000 ALTER TABLE `wp_homepage_sliders` DISABLE KEYS */;
INSERT INTO `wp_homepage_sliders` VALUES (1,'BỘ SƯU TẬP 2025','Khám phá những mẫu đèn hiện đại nhất','https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=1920&q=80&fit=crop','/san-pham/','Xem Sáº£n Pháº©m',1,1,'2025-09-09 18:42:36','2025-09-30 01:12:21'),(2,'CÔNG NGHỆ LED TIÊN TIẾN','Tiết kiệm 80% điện năng - Tuổi thọ 50,000 giờ','https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1920&q=80&fit=crop','/san-pham/?category=den-led-day','KhÃ¡m PhÃ¡ Ngay',2,1,'2025-09-09 18:42:36','2025-09-30 01:12:21'),(3,'GIẢI PHÁP CHIẾU SÁNG THÔNG MINH','Điều khiển qua App - Tích hợp IoT','https://images.unsplash.com/photo-1558002038-1055907df827?w=1920&q=80&fit=crop','/lien-he/','TÆ° Váº¥n Miá»…n PhÃ­',3,1,'2025-09-09 18:42:36','2025-09-30 01:12:21'),(4,'DỰ ÁN TIÊU BIỂU','Hơn 500 công trình trên toàn quốc','https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920&q=80&fit=crop','/cong-trinh/','Xem Dá»± Ãn',4,1,'2025-09-09 18:42:36','2025-09-30 01:12:21'),(5,'KHUYẾN MÃI ĐẶC BIỆT','Giảm đến 30% cho đơn hàng từ 50 triệu','https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=1920&q=80&fit=crop','/lien-he/','LiÃªn Há»‡ Ngay',5,1,'2025-09-09 18:42:36','2025-09-30 01:12:21');
/*!40000 ALTER TABLE `wp_homepage_sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_indoor_page_settings`
--

DROP TABLE IF EXISTS `wp_indoor_page_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_indoor_page_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `setting_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `setting_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT 'text',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_indoor_page_settings`
--

LOCK TABLES `wp_indoor_page_settings` WRITE;
/*!40000 ALTER TABLE `wp_indoor_page_settings` DISABLE KEYS */;
INSERT INTO `wp_indoor_page_settings` VALUES (6,'page_title','INDOOR LIGHTING','text','2025-09-10 13:04:28','2025-09-10 13:04:28'),(7,'page_subtitle','DOWNLIGHTS AND SPOTLIGHTS','text','2025-09-10 13:04:28','2025-09-10 13:04:28'),(8,'banner_image','http://localhost:9000/wp-content/uploads/2025/01/indoor/banner-indoor.jpg','image','2025-09-10 13:04:28','2025-09-10 13:04:28'),(9,'meta_title','Indoor - Aura Lighting - Feeling Light','text','2025-09-10 13:04:28','2025-09-10 13:04:28'),(10,'meta_description','KhÃ¡m phÃ¡ bá»™ sÆ°u táº­p Ä‘Ã¨n LED Indoor cháº¥t lÆ°á»£ng cao tá»« Aura Lighting','text','2025-09-10 13:04:28','2025-09-10 13:04:28');
/*!40000 ALTER TABLE `wp_indoor_page_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_indoor_product_categories`
--

DROP TABLE IF EXISTS `wp_indoor_product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_indoor_product_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `category_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_slug` (`category_slug`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_indoor_product_categories`
--

LOCK TABLES `wp_indoor_product_categories` WRITE;
/*!40000 ALTER TABLE `wp_indoor_product_categories` DISABLE KEYS */;
INSERT INTO `wp_indoor_product_categories` VALUES (9,'Downlight','downlight',1,1,'2025-09-10 13:04:28','2025-09-10 13:04:28'),(10,'Spotlight','spotlight',2,1,'2025-09-10 13:04:28','2025-09-10 13:04:28'),(11,'Track Light','track-light',3,1,'2025-09-10 13:04:28','2025-09-10 13:04:28'),(12,'Linear Light','linear-light',4,1,'2025-09-10 13:04:28','2025-09-10 13:04:28');
/*!40000 ALTER TABLE `wp_indoor_product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_indoor_products`
--

DROP TABLE IF EXISTS `wp_indoor_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_indoor_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `product_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `product_image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `product_link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_slug` (`product_slug`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_indoor_products`
--

LOCK TABLES `wp_indoor_products` WRITE;
/*!40000 ALTER TABLE `wp_indoor_products` DISABLE KEYS */;
INSERT INTO `wp_indoor_products` VALUES (23,9,'Downlight LED Panel','downlight-led-panel','/wp-content/uploads/2025/01/indoor/HI_00125-1024x1024.png','/san-pham/downlight-led-panel/',1,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(24,9,'Downlight Slim','downlight-slim','/wp-content/uploads/2025/01/indoor/Spotgarden2.jpg','/san-pham/downlight-slim/',2,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(25,9,'Downlight Round','downlight-round','/wp-content/uploads/2025/01/indoor/spot2.jpg','/san-pham/downlight-round/',3,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(26,10,'Spotlight Garden Indoor','spotlight-garden-indoor','/wp-content/uploads/2025/01/indoor/Inground1.jpg','/san-pham/spotlight-garden-indoor/',1,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(27,10,'Spotlight Adjustable','spotlight-adjustable','/wp-content/uploads/2025/01/indoor/Inground3-1024x1024.jpg','/san-pham/spotlight-adjustable/',2,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(28,10,'Spotlight Modern','spotlight-modern','/wp-content/uploads/2025/01/indoor/Inground9.jpg','/san-pham/spotlight-modern/',3,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(29,11,'Track Light System 1','track-light-system-1','/wp-content/uploads/2025/01/indoor/1.png','/san-pham/track-light-system-1/',1,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(30,11,'Track Light System 2','track-light-system-2','/wp-content/uploads/2025/01/indoor/2.png','/san-pham/track-light-system-2/',2,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(31,11,'Track Light System 3','track-light-system-3','/wp-content/uploads/2025/01/indoor/3.png','/san-pham/track-light-system-3/',3,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(32,11,'Track Light System 4','track-light-system-4','/wp-content/uploads/2025/01/indoor/4.png','/san-pham/track-light-system-4/',4,1,'2025-09-10 13:04:45','2025-09-16 14:27:58'),(33,12,'Linear Light Modern','linear-light-modern','/wp-content/uploads/2025/01/indoor/Linear-1024x1024.jpg','/san-pham/linear-light-modern/',1,1,'2025-09-10 13:04:45','2025-09-16 14:27:58');
/*!40000 ALTER TABLE `wp_indoor_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_links` (
  `link_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint unsigned NOT NULL DEFAULT '1',
  `link_rating` int NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_rss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_links`
--

LOCK TABLES `wp_links` WRITE;
/*!40000 ALTER TABLE `wp_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_options` (
  `option_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `option_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `autoload` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`),
  KEY `autoload` (`autoload`)
) ENGINE=InnoDB AUTO_INCREMENT=636 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_options`
--

LOCK TABLES `wp_options` WRITE;
/*!40000 ALTER TABLE `wp_options` DISABLE KEYS */;
INSERT INTO `wp_options` VALUES (1,'cron','a:10:{i:1753711978;a:2:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1753712000;a:3:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:21:\"wp_update_user_counts\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1753712010;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1753712060;a:1:{s:28:\"wp_update_comment_type_batch\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:2:{s:8:\"schedule\";b:0;s:4:\"args\";a:0:{}}}}i:1753715573;a:1:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1753717373;a:1:{s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1753719173;a:1:{s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1753795514;a:1:{s:30:\"wp_delete_temp_updater_backups\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1753798378;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}','on'),(2,'siteurl','http://localhost:8082','on'),(3,'home','http://localhost:8082','on'),(4,'blogname','Virical','on'),(5,'blogdescription','Feeling Light','on'),(6,'users_can_register','0','on'),(7,'admin_email','bibilon89@gmail.com','on'),(8,'start_of_week','1','on'),(9,'use_balanceTags','0','on'),(10,'use_smilies','1','on'),(11,'require_name_email','1','on'),(12,'comments_notify','1','on'),(13,'posts_per_rss','10','on'),(14,'rss_use_excerpt','0','on'),(15,'mailserver_url','mail.example.com','on'),(16,'mailserver_login','login@example.com','on'),(17,'mailserver_pass','','on'),(18,'mailserver_port','110','on'),(19,'default_category','1','on'),(20,'default_comment_status','open','on'),(21,'default_ping_status','open','on'),(22,'default_pingback_flag','0','on'),(23,'posts_per_page','10','on'),(24,'date_format','j F, Y','on'),(25,'time_format','g:i a','on'),(26,'links_updated_date_format','j F, Y g:i a','on'),(27,'comment_moderation','0','on'),(28,'moderation_notify','1','on'),(29,'permalink_structure','/%postname%/','on'),(31,'hack_file','0','on'),(32,'blog_charset','UTF-8','on'),(33,'moderation_keys','','off'),(34,'active_plugins','a:0:{}','on'),(35,'category_base','','on'),(36,'ping_sites','https://rpc.pingomatic.com/','on'),(37,'comment_max_links','2','on'),(38,'gmt_offset','0','on'),(39,'default_email_category','1','on'),(40,'recently_edited','','off'),(41,'template','virical-theme','on'),(42,'stylesheet','virical-theme','on'),(43,'comment_registration','0','on'),(44,'html_type','text/html','on'),(45,'use_trackback','0','on'),(46,'default_role','subscriber','on'),(47,'db_version','60421','on'),(48,'uploads_use_yearmonth_folders','1','on'),(49,'upload_path','','on'),(50,'blog_public','0','on'),(51,'default_link_category','2','on'),(52,'show_on_front','page','on'),(53,'tag_base','','on'),(54,'show_avatars','1','on'),(55,'avatar_rating','G','on'),(56,'upload_url_path','','on'),(57,'thumbnail_size_w','150','on'),(58,'thumbnail_size_h','150','on'),(59,'thumbnail_crop','1','on'),(60,'medium_size_w','300','on'),(61,'medium_size_h','300','on'),(62,'avatar_default','mystery','on'),(63,'large_size_w','1024','on'),(64,'large_size_h','1024','on'),(65,'image_default_link_type','none','on'),(66,'image_default_size','','on'),(67,'image_default_align','','on'),(68,'close_comments_for_old_posts','0','on'),(69,'close_comments_days_old','14','on'),(70,'thread_comments','1','on'),(71,'thread_comments_depth','5','on'),(72,'page_comments','0','on'),(73,'comments_per_page','50','on'),(74,'default_comments_page','newest','on'),(75,'comment_order','asc','on'),(76,'sticky_posts','a:0:{}','on'),(77,'widget_categories','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','auto'),(78,'widget_text','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','auto'),(79,'widget_rss','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','auto'),(80,'uninstall_plugins','a:0:{}','off'),(81,'timezone_string','','on'),(82,'page_for_posts','0','on'),(83,'page_on_front','9','on'),(84,'default_post_format','0','on'),(85,'link_manager_enabled','0','on'),(86,'finished_splitting_shared_terms','1','on'),(87,'site_icon','0','on'),(88,'medium_large_size_w','768','on'),(89,'medium_large_size_h','0','on'),(90,'wp_page_for_privacy_policy','3','on'),(91,'show_comments_cookies_opt_in','1','on'),(92,'admin_email_lifespan','1769263973','on'),(93,'disallowed_keys','','off'),(94,'comment_previously_approved','1','on'),(95,'auto_plugin_theme_update_emails','a:0:{}','off'),(96,'auto_update_core_dev','enabled','on'),(97,'auto_update_core_minor','enabled','on'),(98,'auto_update_core_major','enabled','on'),(99,'wp_force_deactivated_plugins','a:0:{}','on'),(100,'wp_attachment_pages_enabled','0','on'),(101,'initial_db_version','60421','on'),(102,'wp_user_roles','a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:63:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:20:\"manage_virical_theme\";b:1;s:20:\"manage_virical_menus\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}','on'),(103,'fresh_site','0','off'),(104,'WPLANG','vi','auto'),(105,'user_count','1','off'),(106,'widget_block','a:6:{i:2;a:1:{s:7:\"content\";s:19:\"<!-- wp:search /-->\";}i:3;a:1:{s:7:\"content\";s:159:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Bài viết mới</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->\";}i:4;a:1:{s:7:\"content\";s:236:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Bình luận gần đây</h2><!-- /wp:heading --><!-- wp:latest-comments {\"displayAvatar\":false,\"displayDate\":false,\"displayExcerpt\":false} /--></div><!-- /wp:group -->\";}i:5;a:1:{s:7:\"content\";s:148:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Lưu trữ</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->\";}i:6;a:1:{s:7:\"content\";s:150:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Danh mục</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->\";}s:12:\"_multiwidget\";i:1;}','auto'),(107,'sidebars_widgets','a:6:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:8:\"footer-1\";a:0:{}s:8:\"footer-2\";a:0:{}s:8:\"footer-3\";a:0:{}s:13:\"array_version\";i:3;}','auto'),(108,'widget_pages','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(109,'widget_calendar','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(110,'widget_archives','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(111,'widget_media_audio','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(112,'widget_media_image','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(113,'widget_media_gallery','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(114,'widget_media_video','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(115,'widget_meta','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(116,'widget_search','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(117,'widget_recent-posts','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(118,'widget_recent-comments','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(119,'widget_tag_cloud','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(120,'widget_nav_menu','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(121,'widget_custom_html','a:1:{s:12:\"_multiwidget\";i:1;}','auto'),(137,'can_compress_scripts','0','on'),(150,'theme_mods_twentytwentyfive','a:4:{s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1753713278;s:4:\"data\";a:6:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:8:\"footer-1\";a:0:{}s:8:\"footer-2\";a:0:{}s:8:\"footer-3\";a:0:{}s:9:\"sidebar-2\";a:0:{}}}s:19:\"wp_classic_sidebars\";a:4:{s:9:\"sidebar-1\";a:11:{s:4:\"name\";s:7:\"Sidebar\";s:2:\"id\";s:9:\"sidebar-1\";s:11:\"description\";s:17:\"Add widgets here.\";s:5:\"class\";s:0:\"\";s:13:\"before_widget\";s:39:\"<section id=\"%1$s\" class=\"widget %2$s\">\";s:12:\"after_widget\";s:10:\"</section>\";s:12:\"before_title\";s:25:\"<h2 class=\"widget-title\">\";s:11:\"after_title\";s:5:\"</h2>\";s:14:\"before_sidebar\";s:0:\"\";s:13:\"after_sidebar\";s:0:\"\";s:12:\"show_in_rest\";b:0;}s:8:\"footer-1\";a:11:{s:4:\"name\";s:20:\"Footer Widget Area 1\";s:2:\"id\";s:8:\"footer-1\";s:11:\"description\";s:20:\"Footer widget area 1\";s:5:\"class\";s:0:\"\";s:13:\"before_widget\";s:35:\"<div id=\"%1$s\" class=\"widget %2$s\">\";s:12:\"after_widget\";s:6:\"</div>\";s:12:\"before_title\";s:25:\"<h3 class=\"widget-title\">\";s:11:\"after_title\";s:5:\"</h3>\";s:14:\"before_sidebar\";s:0:\"\";s:13:\"after_sidebar\";s:0:\"\";s:12:\"show_in_rest\";b:0;}s:8:\"footer-2\";a:11:{s:4:\"name\";s:20:\"Footer Widget Area 2\";s:2:\"id\";s:8:\"footer-2\";s:11:\"description\";s:20:\"Footer widget area 2\";s:5:\"class\";s:0:\"\";s:13:\"before_widget\";s:35:\"<div id=\"%1$s\" class=\"widget %2$s\">\";s:12:\"after_widget\";s:6:\"</div>\";s:12:\"before_title\";s:25:\"<h3 class=\"widget-title\">\";s:11:\"after_title\";s:5:\"</h3>\";s:14:\"before_sidebar\";s:0:\"\";s:13:\"after_sidebar\";s:0:\"\";s:12:\"show_in_rest\";b:0;}s:8:\"footer-3\";a:11:{s:4:\"name\";s:20:\"Footer Widget Area 3\";s:2:\"id\";s:8:\"footer-3\";s:11:\"description\";s:20:\"Footer widget area 3\";s:5:\"class\";s:0:\"\";s:13:\"before_widget\";s:35:\"<div id=\"%1$s\" class=\"widget %2$s\">\";s:12:\"after_widget\";s:6:\"</div>\";s:12:\"before_title\";s:25:\"<h3 class=\"widget-title\">\";s:11:\"after_title\";s:5:\"</h3>\";s:14:\"before_sidebar\";s:0:\"\";s:13:\"after_sidebar\";s:0:\"\";s:12:\"show_in_rest\";b:0;}}s:18:\"nav_menu_locations\";a:0:{}}','off'),(152,'current_theme','Virical Theme','auto'),(153,'theme_mods_aura-lighting-theme','a:4:{i:0;b:0;s:18:\"nav_menu_locations\";a:1:{s:7:\"primary\";i:3;}s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1753722171;s:4:\"data\";a:5:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:8:\"footer-1\";a:0:{}s:8:\"footer-2\";a:0:{}s:8:\"footer-3\";a:0:{}}}}','on'),(154,'theme_switched','','auto'),(172,'product_category_children','a:0:{}','auto'),(182,'wp_calendar_block_has_published_posts','1','auto'),(194,'recently_activated','a:0:{}','off'),(198,'theme_mods_astra','a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:1:{s:7:\"primary\";i:3;}s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1753722175;s:4:\"data\";a:8:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:15:\"footer-widget-1\";a:0:{}s:15:\"footer-widget-2\";a:0:{}s:24:\"advanced-footer-widget-1\";a:0:{}s:24:\"advanced-footer-widget-2\";a:0:{}s:24:\"advanced-footer-widget-3\";a:0:{}s:24:\"advanced-footer-widget-4\";a:0:{}}}}','off'),(201,'astra-settings','a:2:{s:18:\"theme-auto-version\";s:6:\"4.11.7\";s:22:\"is_theme_queue_running\";b:0;}','auto'),(202,'astra_analytics_installed_time','1753722171','off'),(212,'aura_about_hero_title','VIRICAL','yes'),(213,'aura_about_hero_subtitle','Tiên Phong Chiếu Sáng Thông Minh','yes'),(214,'aura_about_intro_title','GIẢI PHÁP CHIẾU SÁNG THÔNG MINH','yes'),(215,'aura_about_intro_content','<p><strong>Virical</strong> là đơn vị hàng đầu tại Việt Nam trong lĩnh vực <strong>giải pháp chiếu sáng LED thông minh</strong>, tích hợp công nghệ IoT và AI để mang đến trải nghiệm chiếu sáng tối ưu cho mọi không gian sống và làm việc.</p>\n\n<p>Với phương châm <em>\"Feeling Light\"</em>, chúng tôi không chỉ cung cấp ánh sáng mà còn tạo ra những trải nghiệm cảm xúc thông qua ánh sáng thông minh, tiết kiệm năng lượng và thân thiện với môi trường.</p>\n\n<ul class=\"intro-highlights\">\n<li>⚡ <strong>Tiết kiệm 60-80%</strong> năng lượng</li>\n<li>🤖 <strong>Điều khiển AI</strong> tự động</li>\n<li>📱 <strong>App điều khiển</strong> iOS/Android</li>\n<li>🌐 <strong>Tích hợp IoT</strong> Smart Home</li>\n</ul>','yes'),(216,'aura_about_hero_image','https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1920&q=80&fit=crop','yes'),(217,'aura_about_intro_image','https://images.unsplash.com/photo-1558002038-1055907df827?w=800&q=80&fit=crop','yes'),(218,'aura_about_story_sections','a:4:{i:0;a:3:{s:5:\"title\";s:27:\"Công Nghệ Smart Lighting\";s:7:\"content\";s:995:\"<h3>💡 Hệ Thống Chiếu Sáng Thông Minh</h3>\n\n<p>Hệ thống chiếu sáng thông minh của Virical tích hợp công nghệ IoT, AI và Machine Learning để tự động hóa và tối ưu hóa chiếu sáng:</p>\n\n<ul>\n<li><strong>🤖 AI Control:</strong> Tự động điều chỉnh ánh sáng theo thời gian, môi trường và hành vi người dùng</li>\n<li><strong>📱 Mobile App:</strong> Điều khiển toàn bộ hệ thống từ smartphone (iOS/Android)</li>\n<li><strong>🗣️ Voice Control:</strong> Tương thích Google Assistant, Amazon Alexa, Apple Siri</li>\n<li><strong>🌐 IoT Ecosystem:</strong> Kết nối Zigbee, Z-Wave, WiFi, Bluetooth Mesh</li>\n<li><strong>⏰ Scheduling:</strong> Lập lịch tự động theo kịch bản</li>\n<li><strong>📊 Analytics:</strong> Báo cáo và tối ưu năng lượng thời gian thực</li>\n</ul>\n\n<p><strong>Tiết kiệm:</strong> 60-80% điện năng, giảm 1 tấn CO2/năm cho mỗi 100 bóng đèn.</p>\";s:5:\"image\";s:77:\"https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80&fit=crop\";}i:1;a:3:{s:5:\"title\";s:26:\"Tính Năng Vượt Trội\";s:7:\"content\";s:910:\"<h3>🎨 Tính Năng Nổi Bật</h3>\n\n<p>Hệ thống Smart Lighting của Virical mang đến trải nghiệm ánh sáng đỉnh cao:</p>\n\n<ul>\n<li><strong>Tunable White:</strong> Điều chỉnh nhiệt độ màu 2700K-6500K theo circadian rhythm (nhịp sinh học), hỗ trợ giấc ngủ và năng suất làm việc</li>\n<li><strong>RGB/RGBW:</strong> 16 triệu màu sắc cho ánh sáng trang trí và tạo cảm xúc</li>\n<li><strong>Scene Control:</strong> Lưu và kích hoạt kịch bản ánh sáng (Đọc sách, Xem phim, Tiệc tùng, Thư giãn, Làm việc)</li>\n<li><strong>Sensor Integration:</strong> Cảm biến chuyển động, ánh sáng tự nhiên, hiện diện người</li>\n<li><strong>Smooth Dimming:</strong> Điều chỉnh độ sáng 0-100% mượt mà, không nhấp nháy</li>\n<li><strong>Group Control:</strong> Điều khiển theo nhóm phòng/khu vực</li>\n</ul>\";s:5:\"image\";s:77:\"https://images.unsplash.com/photo-1558002038-1055907df827?w=800&q=80&fit=crop\";}i:2;a:3:{s:5:\"title\";s:29:\"Công Nghệ LED Tiên Tiến\";s:7:\"content\";s:947:\"<h3>🔬 Chất Lượng LED Vượt Trội</h3>\n\n<p>Virical sử dụng công nghệ LED thế hệ mới nhất từ các nhà sản xuất hàng đầu thế giới:</p>\n\n<ul>\n<li><strong>Tuổi thọ 50,000 giờ:</strong> Tương đương 17 năm sử dụng (8h/ngày), giảm 90% chi phí thay thế</li>\n<li><strong>CRI >90:</strong> Chỉ số hoàn màu cao, tái tạo màu sắc chân thực như ánh sáng tự nhiên</li>\n<li><strong>Hiệu suất >120 lm/W:</strong> Phát sáng hiệu quả, tiết kiệm tối đa năng lượng</li>\n<li><strong>Không nhấp nháy:</strong> Bảo vệ thị lực, giảm mỏi mắt, tốt cho sức khỏe</li>\n<li><strong>Khởi động tức thì:</strong> Sáng 100% ngay lập tức, không cần thời gian khởi động</li>\n<li><strong>An toàn & Xanh:</strong> Không thủy ngân, không UV, 100% tái chế</li>\n</ul>\n\n<p><strong>Chứng nhận:</strong> CE, RoHS, IP65, IK08</p>\";s:5:\"image\";s:80:\"https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&q=80&fit=crop\";}i:3;a:3:{s:5:\"title\";s:25:\"Giải Pháp Toàn Diện\";s:7:\"content\";s:922:\"<h3>🏢 Ứng Dụng Đa Dạng</h3>\n\n<p>Virical cung cấp giải pháp chiếu sáng thông minh cho mọi không gian:</p>\n\n<ul>\n<li><strong>🏠 Smart Home:</strong> Nhà thông minh với ánh sáng tự động, scene control, tích hợp Smart Home ecosystem</li>\n<li><strong>🏢 Văn Phòng:</strong> Tăng năng suất 15%, giảm 70% chi phí vận hành, ánh sáng tunable white theo giờ làm việc</li>\n<li><strong>🏨 Khách Sạn:</strong> Nâng cao trải nghiệm khách, scene control (Welcome, Bedtime, Wake up), tích hợp PMS</li>\n<li><strong>🏭 Công Nghiệp:</strong> Đèn highbay 100-200W, tự động theo ca làm việc, giảm 70% chi phí điện</li>\n<li><strong>🛍️ Retail:</strong> Spotlight CRI >90, RGB cho không gian sinh động, điều chỉnh theo sự kiện</li>\n</ul>\n\n<p><strong>500+ dự án</strong> triển khai thành công tại Việt Nam và khu vực.</p>\";s:5:\"image\";s:80:\"https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80&fit=crop\";}}','yes'),(219,'aura_about_company_values','a:4:{i:0;a:3:{s:4:\"icon\";s:16:\"fas fa-lightbulb\";s:5:\"title\";s:24:\"Đổi Mới Sáng Tạo\";s:11:\"description\";s:92:\"Luôn tiên phong trong ứng dụng công nghệ IoT và AI vào giải pháp chiếu sáng\";}i:1;a:3:{s:4:\"icon\";s:18:\"fas fa-certificate\";s:5:\"title\";s:30:\"Chất Lượng Vượt Trội\";s:11:\"description\";s:80:\"Cam kết sản phẩm đạt tiêu chuẩn quốc tế: CE, RoHS, ISO 9001:2015\";}i:2;a:3:{s:4:\"icon\";s:12:\"fas fa-users\";s:5:\"title\";s:23:\"Khách Hàng Trung Tâm\";s:11:\"description\";s:82:\"Lắng nghe và đáp ứng mọi nhu cầu, hỗ trợ 24/7, bảo hành 3-5 năm\";}i:3;a:3:{s:4:\"icon\";s:11:\"fas fa-leaf\";s:5:\"title\";s:24:\"Trách Nhiệm Xã Hội\";s:11:\"description\";s:77:\"Góp phần bảo vệ môi trường, giảm 1 triệu tấn CO2 đến 2030\";}}','yes'),(220,'aura_about_team_members','a:0:{}','yes'),(221,'aura_about_achievements','a:6:{i:0;a:3:{s:6:\"number\";s:4:\"500+\";s:5:\"label\";s:21:\"Dự án thành công\";s:4:\"icon\";s:22:\"fas fa-project-diagram\";}i:1;a:3:{s:6:\"number\";s:2:\"17\";s:5:\"label\";s:18:\"Năm kinh nghiệm\";s:4:\"icon\";s:19:\"fas fa-calendar-alt\";}i:2;a:3:{s:6:\"number\";s:6:\"60-80%\";s:5:\"label\";s:28:\"Tiết kiệm năng lượng\";s:4:\"icon\";s:11:\"fas fa-bolt\";}i:3;a:3:{s:6:\"number\";s:7:\"50,000h\";s:5:\"label\";s:25:\"Tuổi thọ sản phẩm\";s:4:\"icon\";s:21:\"fas fa-hourglass-half\";}i:4;a:3:{s:6:\"number\";s:8:\"ISO 9001\";s:5:\"label\";s:30:\"Chứng nhận chất lượng\";s:4:\"icon\";s:12:\"fas fa-award\";}i:5;a:3:{s:6:\"number\";s:6:\"Top 10\";s:5:\"label\";s:27:\"Doanh nghiệp công nghệ\";s:4:\"icon\";s:13:\"fas fa-trophy\";}}','yes'),(222,'aura_about_partners','a:4:{i:0;a:2:{s:4:\"name\";s:16:\"Philips Lighting\";s:4:\"logo\";s:47:\"https://via.placeholder.com/200x80?text=Philips\";}i:1;a:2:{s:4:\"name\";s:5:\"Osram\";s:4:\"logo\";s:45:\"https://via.placeholder.com/200x80?text=Osram\";}i:2;a:2:{s:4:\"name\";s:11:\"Samsung LED\";s:4:\"logo\";s:47:\"https://via.placeholder.com/200x80?text=Samsung\";}i:3;a:2:{s:4:\"name\";s:15:\"Zigbee Alliance\";s:4:\"logo\";s:46:\"https://via.placeholder.com/200x80?text=Zigbee\";}}','yes'),(225,'theme_mods_virical-theme','a:1:{s:18:\"custom_css_post_id\";i:-1;}','auto'),(230,'category_children','a:0:{}','auto'),(338,'recovery_mode_email_last_sent','1757465840','auto'),(339,'recovery_keys','a:3:{s:22:\"jfBCi2j1fU2KObc4kCRvDQ\";a:2:{s:10:\"hashed_key\";s:49:\"$generic$uc9LhYKrCrekTJ-BNysK-4b3Isudq-Kak5eMHZKo\";s:10:\"created_at\";i:1754618149;}s:22:\"WXL2XH1XekUDC49ddJrfsk\";a:2:{s:10:\"hashed_key\";s:49:\"$generic$GaKtW7phlHCm3MsXLsYtjOUo0SQUF8q_wLYd7_ht\";s:10:\"created_at\";i:1754915379;}s:22:\"tAiHpM2egpiAgL8EAc9OBb\";a:2:{s:10:\"hashed_key\";s:49:\"$generic$eQc1TxBZkvtOzRCg8xKzT1p35SPwh0C-fwQJfmle\";s:10:\"created_at\";i:1757465840;}}','off'),(360,'virical_company_info','a:16:{s:12:\"company_name\";s:36:\"VIRICAL VIET NAM JOINT STOCK COMPANY\";s:7:\"tagline\";s:13:\"Feeling Light\";s:19:\"company_description\";s:128:\"Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.\";s:7:\"hotline\";s:12:\"0869995698\";s:5:\"phone\";s:12:\"0869995698\";s:6:\"mobile\";s:12:\"0869995698\";s:5:\"email\";s:15:\"info@virical.vn\";s:7:\"address\";s:94:\"Số 30 Ngõ 100 Nguyễn Xiển, Phường Hạ Đình, Quận Thanh Xuân, Thành phố Hà Nội, Việt Nam\";s:13:\"working_hours\";s:31:\"Thứ 2 - Thứ 6: 8:00 - 17:30\";s:14:\"copyright_text\";s:66:\"© {year} Virical. All Rights Reserved. | Designed by Virical Team\";s:15:\"google_maps_url\";s:0:\"\";s:8:\"facebook\";s:32:\"https://www.facebook.com/virical\";s:7:\"youtube\";s:0:\"\";s:4:\"zalo\";s:0:\"\";s:9:\"instagram\";s:0:\"\";s:8:\"linkedin\";s:0:\"\";}','auto'),(361,'virical_product_info','a:9:{s:15:\"warranty_period\";s:6:\"5 năm\";s:13:\"support_hours\";s:4:\"24/7\";s:20:\"warranty_description\";s:83:\"Bảo hành chính hãng với chế độ 1 đổi 1 trong thời gian bảo hành\";s:24:\"quality_commitment_title\";s:38:\"Cam kết chất lượng từ Virical\";s:24:\"quality_commitment_intro\";s:94:\"Virical tự hào là thương hiệu đèn LED hàng đầu tại Việt Nam với cam kết:\";s:11:\"commitments\";s:363:\"Sản phẩm chính hãng 100% với chất lượng được kiểm định nghiêm ngặt\nBảo hành chính hãng lên đến 5 năm\nĐội ngũ tư vấn chuyên nghiệp, hỗ trợ 24/7\nDịch vụ lắp đặt tận nơi bởi đội ngũ kỹ thuật viên giàu kinh nghiệm\nChính sách đổi trả linh hoạt, đảm bảo quyền lợi khách hàng\";s:21:\"default_product_intro\";s:406:\"{product_name} là một trong những sản phẩm đèn LED cao cấp được thiết kế với công nghệ hiện đại, mang đến giải pháp chiếu sáng hoàn hảo cho không gian của bạn. Với thiết kế sang trọng và hiệu suất vượt trội, sản phẩm này không chỉ đáp ứng nhu cầu chiếu sáng mà còn tạo điểm nhấn thẩm mỹ cho mọi công trình.\";s:16:\"product_benefits\";s:244:\"Tiết kiệm năng lượng lên đến 80% so với đèn truyền thống\nTuổi thọ cao lên đến 50,000 giờ\nÁnh sáng chất lượng cao, không nhấp nháy\nThân thiện với môi trường\nDễ dàng lắp đặt và bảo trì\";s:8:\"cta_text\";s:130:\"Để được tư vấn chi tiết về {product_name} và nhận báo giá tốt nhất, vui lòng liên hệ với chúng tôi:\";}','auto'),(362,'virical_footer_menus','a:8:{s:19:\"product_menu_item_1\";a:2:{s:5:\"title\";s:12:\"Đèn Indoor\";s:3:\"url\";s:21:\"/san-pham/den-indoor/\";}s:19:\"product_menu_item_2\";a:2:{s:5:\"title\";s:13:\"Đèn Outdoor\";s:3:\"url\";s:22:\"/san-pham/den-outdoor/\";}s:19:\"product_menu_item_3\";a:2:{s:5:\"title\";s:15:\"Đèn Downlight\";s:3:\"url\";s:24:\"/san-pham/den-downlight/\";}s:19:\"product_menu_item_4\";a:2:{s:5:\"title\";s:15:\"Đèn Spotlight\";s:3:\"url\";s:24:\"/san-pham/den-spotlight/\";}s:19:\"product_menu_item_5\";a:2:{s:5:\"title\";s:9:\"Đèn Ray\";s:3:\"url\";s:18:\"/san-pham/den-ray/\";}s:20:\"resource_menu_item_1\";a:2:{s:5:\"title\";s:9:\"Catalogue\";s:3:\"url\";s:11:\"/catalogue/\";}s:20:\"resource_menu_item_2\";a:2:{s:5:\"title\";s:24:\"Chính Sách Bảo Hành\";s:3:\"url\";s:21:\"/chinh-sach-bao-hanh/\";}s:20:\"resource_menu_item_3\";a:2:{s:5:\"title\";s:0:\"\";s:3:\"url\";s:0:\"\";}}','auto'),(413,'virical_db_version','1.4','auto'),(422,'virical_homepage_migrated','1','auto'),(430,'theme_mods_twentytwentyfour','a:1:{s:18:\"custom_css_post_id\";i:-1;}','auto'),(443,'virical_admin_menus_migrated','1','auto'),(464,'virical_migration_003_status','completed','auto'),(465,'virical_migration_003_date','2025-09-09 20:02:58','auto'),(466,'virical_migration_004_status','completed','auto'),(467,'virical_migration_004_date','2025-09-09 20:03:07','auto'),(468,'virical_migration_005_status','completed','auto'),(469,'virical_migration_005_date','2025-09-09 20:03:16','auto'),(478,'virical_migration_003_company_info','2025-09-10 00:52:05','auto'),(581,'_transient_doing_cron','1759243023.3653469085693359375000','on'),(582,'_transient_wp_styles_for_blocks','a:2:{s:4:\"hash\";s:32:\"6e6d8de67419046d2621cb7be2aadea2\";s:6:\"blocks\";a:5:{s:11:\"core/button\";s:0:\"\";s:14:\"core/site-logo\";s:0:\"\";s:18:\"core/post-template\";s:120:\":where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}\";s:12:\"core/columns\";s:102:\":where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}\";s:14:\"core/pullquote\";s:69:\":root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}\";}}','on'),(593,'rewrite_rules','a:99:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:20:\"^san-pham/([^/]+)/?$\";s:47:\"index.php?pagename=san-pham&product=$matches[1]\";s:22:\"^cong-trinh/([^/]+)/?$\";s:49:\"index.php?pagename=cong-trinh&project=$matches[1]\";s:29:\"^danh-muc-san-pham/([^/]+)/?$\";s:56:\"index.php?pagename=san-pham&product_category=$matches[1]\";s:27:\"^loai-cong-trinh/([^/]+)/?$\";s:54:\"index.php?pagename=cong-trinh&project_type=$matches[1]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:13:\"favicon\\.ico$\";s:19:\"index.php?favicon=1\";s:12:\"sitemap\\.xml\";s:24:\"index.php??sitemap=index\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:27:\"comment-page-([0-9]{1,})/?$\";s:38:\"index.php?&page_id=9&cpage=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:27:\"[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\"[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\"[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"([^/]+)/embed/?$\";s:37:\"index.php?name=$matches[1]&embed=true\";s:20:\"([^/]+)/trackback/?$\";s:31:\"index.php?name=$matches[1]&tb=1\";s:40:\"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:35:\"([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:28:\"([^/]+)/page/?([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&paged=$matches[2]\";s:35:\"([^/]+)/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&cpage=$matches[2]\";s:24:\"([^/]+)(?:/([0-9]+))?/?$\";s:43:\"index.php?name=$matches[1]&page=$matches[2]\";s:16:\"[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:26:\"[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:46:\"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:22:\"[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";}','auto'),(614,'virical_company_phone','0869995698','on'),(615,'virical_company_mobile','0869995698','on'),(616,'virical_company_email','info@virical.vn','on'),(617,'virical_company_support_email','support@virical.vn','on'),(618,'virical_company_address','Số 30 Ngõ 100 Nguyễn Xiển, Phường Hạ Đình, Quận Thanh Xuân, Thành phố Hà Nội, Việt Nam','on'),(619,'virical_company_address_short','Số 30 Ngõ 100 Nguyễn Xiển, Thanh Xuân, Hà Nội','on'),(620,'virical_company_name','VIRICAL VIET NAM JOINT STOCK COMPANY','on'),(621,'virical_company_short_name','VIRICAL.,JSC','on'),(622,'virical_company_slogan','Feeling Light','on'),(623,'virical_company_description','Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.','on'),(624,'virical_social_facebook','https://www.facebook.com/virical','on'),(625,'virical_social_youtube','https://www.youtube.com/virical','on'),(626,'virical_social_instagram','https://www.instagram.com/virical','on'),(627,'virical_social_linkedin','https://www.linkedin.com/company/virical','on'),(628,'virical_social_zalo','https://zalo.me/virical','on'),(629,'virical_business_hours','Thứ 2 - Thứ 6: 8:00 - 17:30<br>Thứ 7: 8:00 - 12:00','on'),(630,'virical_business_hours_showroom','Thứ 2 - Chủ nhật: 8:30 - 21:00','on'),(631,'virical_hotline','0869995698','on'),(632,'virical_fax','','on'),(633,'virical_google_maps_embed','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8639810699474!2d105.78244699999999!3d21.02851100000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab4c0c00369f%3A0x2b14c0e6f8e8c6f0!2sTon%20That%20Thuyet%2C%20My%20Dinh%2C%20Nam%20Tu%20Liem%2C%20Hanoi%2C%20Vietnam!5e0!3m2!1sen!2s!4v1694755623456!5m2!1sen!2s','on'),(634,'_site_transient_timeout_wp_theme_files_patterns-a69c39950a0642f220e5b1fa0299accb','1759244823','off'),(635,'_site_transient_wp_theme_files_patterns-a69c39950a0642f220e5b1fa0299accb','a:2:{s:7:\"version\";s:3:\"1.0\";s:8:\"patterns\";a:0:{}}','off');
/*!40000 ALTER TABLE `wp_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_outdoor_page_products`
--

DROP TABLE IF EXISTS `wp_outdoor_page_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_outdoor_page_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `product_image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `product_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `product_order` int DEFAULT '0',
  `is_featured` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_section_id` (`section_id`),
  KEY `idx_product_order` (`product_order`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_outdoor_page_products`
--

LOCK TABLES `wp_outdoor_page_products` WRITE;
/*!40000 ALTER TABLE `wp_outdoor_page_products` DISABLE KEYS */;
INSERT INTO `wp_outdoor_page_products` VALUES (1,2,'Spotlight HI-00125','/wp-content/uploads/outdoor/HI_00125-1024x1024.png','High quality spotlight for garden illumination',1,1,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(2,2,'Spot Garden 2','/wp-content/uploads/outdoor/Spotgarden2.jpg','Premium garden spotlight with adjustable beam',2,1,1,'2025-09-10 13:12:09','2025-09-10 13:26:49'),(3,2,'Spot 21','/wp-content/uploads/outdoor/spot2.jpg','Compact spotlight for accent lighting',3,1,1,'2025-09-10 13:12:09','2025-09-10 13:27:07'),(4,3,'Inground Light 1','/wp-content/uploads/outdoor/Inground1.jpg','Durable inground light for pathways',1,1,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(5,3,'Inground Light 3','/wp-content/uploads/outdoor/Inground3-1024x1024.jpg','High power inground uplight',2,0,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(6,3,'Inground Light 9','/wp-content/uploads/outdoor/Inground9.jpg','Decorative inground light with RGB options',3,0,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(7,4,'Bollard Light 1','/wp-content/uploads/outdoor/bollard1.png','Modern bollard light for pathways',1,1,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(8,4,'Bollard Light 2','/wp-content/uploads/outdoor/bollard2.png','Classic bollard design with LED technology',2,0,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(9,4,'Bollard Light 3','/wp-content/uploads/outdoor/bollard3.png','Architectural bollard light',3,0,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(10,4,'Bollard Light 4','/wp-content/uploads/outdoor/bollard4.png','Energy efficient bollard with solar option',4,0,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(11,5,'Linear Light System','/wp-content/uploads/outdoor/Linear-1024x1024.jpg','Flexible linear lighting system for architectural applications',1,1,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(12,2,'Test Upload Product','http://localhost:9000/wp-content/uploads/2025/09/Spotgarden2.jpg','Test product with uploaded image',4,0,1,'2025-09-10 13:36:30','2025-09-10 13:36:30');
/*!40000 ALTER TABLE `wp_outdoor_page_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_outdoor_page_settings`
--

DROP TABLE IF EXISTS `wp_outdoor_page_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_outdoor_page_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `setting_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `setting_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT 'text',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`),
  UNIQUE KEY `idx_setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_outdoor_page_settings`
--

LOCK TABLES `wp_outdoor_page_settings` WRITE;
/*!40000 ALTER TABLE `wp_outdoor_page_settings` DISABLE KEYS */;
INSERT INTO `wp_outdoor_page_settings` VALUES (1,'banner_image','/wp-content/uploads/outdoor/post_gal_0029_r1.jpg','image','2025-09-10 13:12:09','2025-09-10 13:12:09'),(2,'page_title','Outdoor Lighting - Virical','text','2025-09-10 13:12:09','2025-09-10 13:12:09'),(3,'page_slug','outdoor','text','2025-09-10 13:12:09','2025-09-10 13:12:09'),(4,'meta_description','Explore our premium outdoor lighting solutions including spotlights, bollards, inground lights and linear systems','text','2025-09-10 13:12:09','2025-09-10 13:12:09'),(5,'show_cta_button','1','boolean','2025-09-10 13:12:09','2025-09-10 13:12:09'),(6,'cta_button_text','Xem Catalog','text','2025-09-10 13:12:09','2025-09-10 13:12:09'),(7,'cta_button_link','/catalog/outdoor','url','2025-09-10 13:12:09','2025-09-10 13:12:09');
/*!40000 ALTER TABLE `wp_outdoor_page_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_outdoor_product_categories`
--

DROP TABLE IF EXISTS `wp_outdoor_product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_outdoor_product_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_slug` (`category_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_outdoor_product_categories`
--

LOCK TABLES `wp_outdoor_product_categories` WRITE;
/*!40000 ALTER TABLE `wp_outdoor_product_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_outdoor_product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_outdoor_products`
--

DROP TABLE IF EXISTS `wp_outdoor_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_outdoor_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_slug` (`product_slug`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `wp_outdoor_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `wp_outdoor_product_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_outdoor_products`
--

LOCK TABLES `wp_outdoor_products` WRITE;
/*!40000 ALTER TABLE `wp_outdoor_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_outdoor_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_outdoor_sections`
--

DROP TABLE IF EXISTS `wp_outdoor_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_outdoor_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `section_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `section_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_section_order` (`section_order`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_outdoor_sections`
--

LOCK TABLES `wp_outdoor_sections` WRITE;
/*!40000 ALTER TABLE `wp_outdoor_sections` DISABLE KEYS */;
INSERT INTO `wp_outdoor_sections` VALUES (1,'banner','OUTDOOR LIGHTING','SPOTLIGHTS AND BOLLARDS',1,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(2,'spotlight_garden','Spotlight garden','',2,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(3,'inground','Inground','',3,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(4,'bollard','Bollard','',4,1,'2025-09-10 13:12:09','2025-09-10 13:12:09'),(5,'linear','Linear','',5,1,'2025-09-10 13:12:09','2025-09-10 13:12:09');
/*!40000 ALTER TABLE `wp_outdoor_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_postmeta`
--

LOCK TABLES `wp_postmeta` WRITE;
/*!40000 ALTER TABLE `wp_postmeta` DISABLE KEYS */;
INSERT INTO `wp_postmeta` VALUES (3,7,'_edit_lock','1754617880:1'),(4,10,'_wp_page_template','page-gioi-thieu.php'),(5,11,'_wp_page_template','page-products.php'),(6,12,'_wp_page_template','page-projects.php'),(7,13,'_wp_page_template','default'),(9,15,'_menu_item_type','custom'),(10,15,'_menu_item_menu_item_parent','0'),(11,15,'_menu_item_object_id','15'),(12,15,'_menu_item_object','custom'),(13,15,'_menu_item_target',''),(14,15,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),(15,15,'_menu_item_xfn',''),(16,15,'_menu_item_url','http://localhost:8000/'),(17,16,'_menu_item_type','post_type'),(18,16,'_menu_item_menu_item_parent','0'),(19,16,'_menu_item_object_id','10'),(20,16,'_menu_item_object','page'),(21,16,'_menu_item_target',''),(22,16,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),(23,16,'_menu_item_xfn',''),(24,16,'_menu_item_url','http://localhost:9000/about-us/'),(25,17,'_menu_item_type','post_type'),(26,17,'_menu_item_menu_item_parent','0'),(27,17,'_menu_item_object_id','11'),(28,17,'_menu_item_object','page'),(29,17,'_menu_item_target',''),(30,17,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),(31,17,'_menu_item_xfn',''),(32,17,'_menu_item_url',''),(33,18,'_menu_item_type','post_type'),(34,18,'_menu_item_menu_item_parent','0'),(35,18,'_menu_item_object_id','12'),(36,18,'_menu_item_object','page'),(37,18,'_menu_item_target',''),(38,18,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),(39,18,'_menu_item_xfn',''),(40,18,'_menu_item_url',''),(41,19,'_menu_item_type','post_type'),(42,19,'_menu_item_menu_item_parent','0'),(43,19,'_menu_item_object_id','13'),(44,19,'_menu_item_object','page'),(45,19,'_menu_item_target',''),(46,19,'_menu_item_classes','a:1:{i:0;s:0:\"\";}'),(47,19,'_menu_item_xfn',''),(48,19,'_menu_item_url',''),(49,10,'_edit_lock','1754853963:1'),(50,1,'_edit_lock','1754786365:1'),(51,7,'_wp_trash_meta_status','draft'),(52,7,'_wp_trash_meta_time','1754618035'),(53,7,'_wp_desired_post_slug',''),(55,9,'_edit_lock','1754786403:1'),(56,12,'_edit_lock','1754852136:1'),(57,10,'_edit_last','1'),(58,38,'_wp_page_template','page-indoor.php'),(60,39,'_wp_page_template','page-outdoor.php'),(61,40,'_wp_attached_file','2025/09/Spotgarden2.jpg'),(62,40,'_wp_attachment_metadata','a:6:{s:5:\"width\";i:997;s:6:\"height\";i:996;s:4:\"file\";s:23:\"2025/09/Spotgarden2.jpg\";s:8:\"filesize\";i:105184;s:5:\"sizes\";a:3:{s:6:\"medium\";a:5:{s:4:\"file\";s:23:\"Spotgarden2-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:12248;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:23:\"Spotgarden2-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:10299;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:23:\"Spotgarden2-768x767.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:767;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:22618;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"1\";s:8:\"keywords\";a:0:{}}}'),(63,41,'_edit_lock','1757511332:1'),(64,45,'_slide_subtitle','GIẢI PHÁP ÁNH SÁNG HOÀN HẢO'),(65,45,'_slide_link','http://localhost:8082/indoor/'),(66,46,'_wp_attached_file','2025/09/contract_oficinas_arkoslight-899x1024-1.jpg'),(67,46,'_wp_attachment_metadata','a:6:{s:5:\"width\";i:899;s:6:\"height\";i:1024;s:4:\"file\";s:51:\"2025/09/contract_oficinas_arkoslight-899x1024-1.jpg\";s:8:\"filesize\";i:121763;s:5:\"sizes\";a:3:{s:6:\"medium\";a:5:{s:4:\"file\";s:51:\"contract_oficinas_arkoslight-899x1024-1-263x300.jpg\";s:5:\"width\";i:263;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:18167;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:51:\"contract_oficinas_arkoslight-899x1024-1-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:6475;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:51:\"contract_oficinas_arkoslight-899x1024-1-768x875.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:875;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:105813;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),(68,45,'_thumbnail_id','46'),(69,47,'_slide_subtitle','THIẾT KẾ SANG TRỌNG - TINH TẾ'),(70,47,'_slide_link','http://localhost:8082/outdoor/'),(71,48,'_wp_attached_file','2025/09/habitat_home.jpg'),(72,48,'_wp_attachment_metadata','a:6:{s:5:\"width\";i:960;s:6:\"height\";i:1094;s:4:\"file\";s:24:\"2025/09/habitat_home.jpg\";s:8:\"filesize\";i:87928;s:5:\"sizes\";a:4:{s:6:\"medium\";a:5:{s:4:\"file\";s:24:\"habitat_home-263x300.jpg\";s:5:\"width\";i:263;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:12317;}s:5:\"large\";a:5:{s:4:\"file\";s:25:\"habitat_home-899x1024.jpg\";s:5:\"width\";i:899;s:6:\"height\";i:1024;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:86175;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:24:\"habitat_home-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:4782;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:24:\"habitat_home-768x875.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:875;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:67410;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),(73,47,'_thumbnail_id','48'),(74,49,'_slide_subtitle','CHẤT LƯỢNG - UY TÍN - CHUYÊN NGHIỆP'),(75,49,'_slide_link','http://localhost:8082/du-an/'),(76,50,'_wp_attached_file','2025/09/post_gal_0029_r1-1024x576.jpg'),(77,50,'_wp_attachment_metadata','a:6:{s:5:\"width\";i:1024;s:6:\"height\";i:576;s:4:\"file\";s:37:\"2025/09/post_gal_0029_r1-1024x576.jpg\";s:8:\"filesize\";i:101809;s:5:\"sizes\";a:3:{s:6:\"medium\";a:5:{s:4:\"file\";s:37:\"post_gal_0029_r1-1024x576-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:13508;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:37:\"post_gal_0029_r1-1024x576-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:7043;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:37:\"post_gal_0029_r1-1024x576-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:64213;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),(78,49,'_thumbnail_id','50'),(79,51,'_slide_subtitle','ĐỔI MỚI - SÁNG TẠO - BỀN VỮNG'),(80,51,'_slide_link','http://localhost:8082/san-pham/'),(81,52,'_wp_attached_file','2025/09/2022_collection-Aura.jpg'),(82,52,'_wp_attachment_metadata','a:6:{s:5:\"width\";i:1920;s:6:\"height\";i:1080;s:4:\"file\";s:32:\"2025/09/2022_collection-Aura.jpg\";s:8:\"filesize\";i:854604;s:5:\"sizes\";a:5:{s:6:\"medium\";a:5:{s:4:\"file\";s:32:\"2022_collection-Aura-300x169.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:11796;}s:5:\"large\";a:5:{s:4:\"file\";s:33:\"2022_collection-Aura-1024x576.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:576;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:51180;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:32:\"2022_collection-Aura-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:10094;}s:12:\"medium_large\";a:5:{s:4:\"file\";s:32:\"2022_collection-Aura-768x432.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:32331;}s:9:\"1536x1536\";a:5:{s:4:\"file\";s:33:\"2022_collection-Aura-1536x864.jpg\";s:5:\"width\";i:1536;s:6:\"height\";i:864;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:106077;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"1\";s:8:\"keywords\";a:0:{}}}'),(83,51,'_thumbnail_id','52'),(84,53,'_wp_page_template','page-giai-phap-thong-minh.php'),(85,53,'_yoast_wpseo_title','Giải Pháp Chiếu Sáng Thông Minh - VIRICAL'),(86,53,'_yoast_wpseo_metadesc','Hệ thống chiếu sáng thông minh, điều khiển qua app, tiết kiệm năng lượng, tích hợp IoT và AI. Giải pháp hoàn hảo cho nhà ở, văn phòng, khách sạn.');
/*!40000 ALTER TABLE `wp_postmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_posts` (
  `ID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `to_ping` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pinged` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_parent` bigint unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `menu_order` int NOT NULL DEFAULT '0',
  `post_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_count` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_posts`
--

LOCK TABLES `wp_posts` WRITE;
/*!40000 ALTER TABLE `wp_posts` DISABLE KEYS */;
INSERT INTO `wp_posts` VALUES (1,1,'2025-07-28 14:12:54','2025-07-28 14:12:54','<!-- wp:paragraph -->\n<p>Cảm ơn vì đã sử dụng WordPress. Đây là bài viết đầu tiên của bạn. Sửa hoặc xóa nó, và bắt đầu bài viết của bạn nhé!</p>\n<!-- /wp:paragraph -->','Chào tất cả mọi người!','','publish','open','open','','chao-moi-nguoi','','','2025-07-28 14:12:54','2025-07-28 14:12:54','',0,'http://localhost:8000/?p=1',0,'post','',1),(4,1,'2025-07-28 14:13:30','0000-00-00 00:00:00','','Lưu nháp tự động','','auto-draft','open','open','','','','','2025-07-28 14:13:30','0000-00-00 00:00:00','',0,'http://localhost:8000/?p=4',0,'post','',0),(5,1,'2025-07-28 14:13:43','2025-07-28 14:13:43','<!-- wp:page-list /-->','Điều hướng','','publish','closed','closed','','navigation','','','2025-07-28 14:13:43','2025-07-28 14:13:43','',0,'http://localhost:8000/?p=5',0,'wp_navigation','',0),(6,1,'2025-07-28 14:19:28','2025-07-28 14:19:28','{\"version\": 3, \"isGlobalStylesUserThemeJSON\": true }','Custom Styles','','publish','closed','closed','','wp-global-styles-twentytwentyfive','','','2025-07-28 14:19:28','2025-07-28 14:19:28','',0,'http://localhost:8000/?p=6',0,'wp_global_styles','',0),(7,1,'2025-08-08 01:53:55','2025-08-08 01:53:55','<!-- wp:paragraph -->\n<p>sadasd</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>asdasd</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>s</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>đ</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->','','','trash','open','open','','__trashed','','','2025-08-08 01:53:55','2025-08-08 01:53:55','',0,'http://localhost:8000/?p=7',0,'post','',0),(8,1,'2025-07-28 14:22:02','2025-07-28 14:22:02','<!-- wp:paragraph -->\n<p>sadasd</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>asdasd</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>s</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>đ</p>\n<!-- /wp:paragraph -->','','','inherit','closed','closed','','7-revision-v1','','','2025-07-28 14:22:02','2025-07-28 14:22:02','',7,'http://localhost:8000/?p=8',0,'revision','',0),(9,1,'2025-07-28 14:38:42','2025-07-28 14:38:42','','Trang Chủ','','publish','closed','closed','','trang-chu','','','2025-07-28 14:38:42','2025-07-28 14:38:42','',0,'http://localhost:8000/?page_id=9',0,'page','',0),(10,1,'2025-07-28 14:38:42','2025-07-28 14:38:42','<div class=\"gioi-thieu-content\">\n\n<h1>Virical - Tiên Phong Chiếu Sáng Thông Minh</h1>\n\n<div class=\"intro-section\">\n<h2>🌟 Về Virical</h2>\n<p><strong>Virical</strong> là đơn vị hàng đầu tại Việt Nam trong lĩnh vực <strong>giải pháp chiếu sáng LED thông minh</strong>, tích hợp công nghệ IoT và AI để mang đến trải nghiệm chiếu sáng tối ưu cho mọi không gian sống và làm việc.</p>\n\n<p>Với phương châm <em>\"Feeling Light\"</em>, chúng tôi không chỉ cung cấp ánh sáng mà còn tạo ra những trải nghiệm cảm xúc thông qua ánh sáng thông minh, tiết kiệm năng lượng và thân thiện với môi trường.</p>\n</div>\n\n<div class=\"smart-lighting-section\">\n<h2>💡 Chiếu Sáng Thông Minh - Smart Lighting</h2>\n\n<h3>Công Nghệ IoT & AI</h3>\n<p>Hệ thống chiếu sáng thông minh của Virical tích hợp:</p>\n<ul>\n<li><strong>🤖 Điều khiển bằng AI:</strong> Tự động điều chỉnh ánh sáng theo thời gian, môi trường và hành vi người dùng</li>\n<li><strong>📱 Điều khiển qua App:</strong> Quản lý toàn bộ hệ thống chiếu sáng từ smartphone iOS/Android</li>\n<li><strong>🗣️ Voice Control:</strong> Tương thích Google Assistant, Amazon Alexa, Siri</li>\n<li><strong>🌐 IoT Integration:</strong> Kết nối với hệ sinh thái Smart Home (Zigbee, Z-Wave, WiFi, Bluetooth Mesh)</li>\n<li><strong>⏰ Lịch trình tự động:</strong> Lập lịch bật/tắt, điều chỉnh độ sáng theo kịch bản</li>\n<li><strong>📊 Báo cáo tiêu thụ:</strong> Theo dõi và tối ưu hóa năng lượng thời gian thực</li>\n</ul>\n\n<h3>Tính Năng Nổi Bật</h3>\n<ul>\n<li><strong>Tunable White:</strong> Điều chỉnh nhiệt độ màu từ 2700K (ấm) đến 6500K (lạnh) theo circadian rhythm</li>\n<li><strong>RGB/RGBW:</strong> 16 triệu màu sắc cho ánh sáng trang trí và cảm xúc</li>\n<li><strong>Scene Control:</strong> Tạo và lưu các kịch bản ánh sáng (Đọc sách, Xem phim, Tiệc tùng, v.v.)</li>\n<li><strong>Sensor Integration:</strong> Cảm biến chuyển động, ánh sáng tự nhiên, hiện diện người</li>\n<li><strong>Dimming 0-100%:</strong> Điều chỉnh độ sáng mượt mà, không nhấp nháy</li>\n<li><strong>Group Control:</strong> Điều khiển theo nhóm phòng hoặc khu vực</li>\n</ul>\n\n<h3>Tiết Kiệm Năng Lượng</h3>\n<p>Hệ thống chiếu sáng thông minh giúp:</p>\n<ul>\n<li>⚡ <strong>Tiết kiệm 60-80% điện năng</strong> so với hệ thống truyền thống</li>\n<li>📉 Giảm chi phí vận hành lên đến <strong>70%</strong> nhờ tự động hóa</li>\n<li>🌱 Giảm <strong>1 tấn CO2/năm</strong> cho mỗi 100 bóng đèn thông minh</li>\n<li>🔋 Tối ưu hóa tiêu thụ điện theo thời gian thực</li>\n</ul>\n</div>\n\n<div class=\"technology-section\">\n<h2>🔬 Công Nghệ LED Tiên Tiến</h2>\n\n<h3>Chất Lượng Vượt Trội</h3>\n<ul>\n<li><strong>Tuổi thọ 50,000 giờ:</strong> Tương đương 17 năm sử dụng (8h/ngày)</li>\n<li><strong>CRI >90:</strong> Chỉ số hoàn màu cao, tái tạo màu sắc chân thực</li>\n<li><strong>Hiệu suất >120 lm/W:</strong> Phát sáng hiệu quả, tiết kiệm năng lượng</li>\n<li><strong>Không nhấp nháy:</strong> Bảo vệ thị lực, không gây mỏi mắt</li>\n<li><strong>Khởi động tức thì:</strong> Sáng 100% ngay lập tức</li>\n</ul>\n\n<h3>An Toàn & Môi Trường</h3>\n<ul>\n<li>✅ Không chứa thủy ngân, chất độc hại</li>\n<li>✅ Không phát tia UV, an toàn cho sức khỏe</li>\n<li>✅ Nhiệt độ bề mặt thấp, an toàn khi chạm</li>\n<li>✅ 100% có thể tái chế</li>\n<li>✅ Tiêu chuẩn: CE, RoHS, IP65, IK08</li>\n</ul>\n</div>\n\n<div class=\"solutions-section\">\n<h2>🏢 Giải Pháp Cho Mọi Không Gian</h2>\n\n<div class=\"solution-item\">\n<h3>🏠 Smart Home (Nhà Thông Minh)</h3>\n<p>Hệ thống chiếu sáng tích hợp hoàn toàn với Smart Home, điều khiển tập trung qua một ứng dụng duy nhất.</p>\n<ul>\n<li>Phòng khách: Đèn thả, đèn spotlight RGB</li>\n<li>Phòng ngủ: Tunable White cho giấc ngủ tốt hơn</li>\n<li>Bếp: Ánh sáng trắng sáng, tự động bật khi có người</li>\n<li>Sân vườn: Đèn ngoài trời IP65, điều khiển từ xa</li>\n</ul>\n</div>\n\n<div class=\"solution-item\">\n<h3>🏢 Văn Phòng Thông Minh</h3>\n<p>Tăng năng suất làm việc và giảm chi phí vận hành.</p>\n<ul>\n<li>Ánh sáng tunable white theo giờ làm việc</li>\n<li>Tự động tắt khi không có người</li>\n<li>Điều chỉnh theo ánh sáng tự nhiên</li>\n<li>Quản lý tập trung toàn tòa nhà</li>\n</ul>\n</div>\n\n<div class=\"solution-item\">\n<h3>🏨 Khách Sạn & Resort</h3>\n<p>Nâng cao trải nghiệm khách hàng, tiết kiệm vận hành.</p>\n<ul>\n<li>Scene control: Welcome, Bedtime, Wake up</li>\n<li>Tích hợp hệ thống quản lý khách sạn (PMS)</li>\n<li>Tự động tắt khi khách check-out</li>\n<li>Mood lighting cho khu vực công cộng</li>\n</ul>\n</div>\n\n<div class=\"solution-item\">\n<h3>🏭 Nhà Xưởng & Kho Bãi</h3>\n<p>Chiếu sáng công suất cao, tiết kiệm năng lượng.</p>\n<ul>\n<li>Đèn highbay LED 100-200W</li>\n<li>Tự động bật/tắt theo lịch ca làm việc</li>\n<li>Cảm biến chuyển động cho khu vực ít người</li>\n<li>Giảm 70% chi phí điện chiếu sáng</li>\n</ul>\n</div>\n\n<div class=\"solution-item\">\n<h3>🛍️ Showroom & Cửa Hàng</h3>\n<p>Tạo không gian mua sắm hấp dẫn, nâng cao doanh số.</p>\n<ul>\n<li>Spotlight CRI >90 cho trưng bày sản phẩm</li>\n<li>RGB cho không gian sinh động</li>\n<li>Điều chỉnh theo sự kiện khuyến mãi</li>\n<li>Tự động điều chỉnh theo giờ mở cửa</li>\n</ul>\n</div>\n</div>\n\n<div class=\"why-virical-section\">\n<h2>⭐ Tại Sao Chọn Virical?</h2>\n\n<div class=\"reasons\">\n<div class=\"reason-item\">\n<h3>1. Công Nghệ Tiên Tiến</h3>\n<p>Luôn cập nhật và ứng dụng công nghệ chiếu sáng mới nhất từ các nhà sản xuất hàng đầu thế giới.</p>\n</div>\n\n<div class=\"reason-item\">\n<h3>2. Giải Pháp Toàn Diện</h3>\n<p>Từ tư vấn thiết kế, thi công lắp đặt đến bảo hành, bảo trì dài hạn.</p>\n</div>\n\n<div class=\"reason-item\">\n<h3>3. Đội Ngũ Chuyên Nghiệp</h3>\n<p>Kỹ sư giàu kinh nghiệm, được đào tạo bài bản về công nghệ IoT và Smart Lighting.</p>\n</div>\n\n<div class=\"reason-item\">\n<h3>4. Giá Cả Cạnh Tranh</h3>\n<p>ROI (Return on Investment) nhanh chóng nhờ tiết kiệm năng lượng vượt trội.</p>\n</div>\n\n<div class=\"reason-item\">\n<h3>5. Hỗ Trợ 24/7</h3>\n<p>Đội ngũ hỗ trợ kỹ thuật sẵn sàng 24/7 qua hotline, email và remote support.</p>\n</div>\n\n<div class=\"reason-item\">\n<h3>6. Bảo Hành Dài Hạn</h3>\n<p>Bảo hành 3-5 năm cho sản phẩm, cam kết thay thế trong vòng 24h nếu có lỗi.</p>\n</div>\n</div>\n</div>\n\n<div class=\"achievements-section\">\n<h2>🏆 Thành Tựu</h2>\n<ul>\n<li>✅ <strong>500+ dự án</strong> triển khai thành công</li>\n<li>✅ <strong>ISO 9001:2015</strong> - Hệ thống quản lý chất lượng</li>\n<li>✅ <strong>Chứng nhận CE, RoHS</strong> - Tiêu chuẩn Châu Âu</li>\n<li>✅ <strong>Top 10</strong> doanh nghiệp công nghệ chiếu sáng tại Việt Nam</li>\n<li>✅ Đối tác chiến lược của các thương hiệu LED hàng đầu</li>\n</ul>\n</div>\n\n<div class=\"vision-section\">\n<h2>🎯 Tầm Nhìn 2030</h2>\n<p><strong>Trở thành đơn vị dẫn đầu Đông Nam Á về giải pháp chiếu sáng thông minh</strong>, góp phần xây dựng các thành phố thông minh bền vững, tiết kiệm năng lượng và thân thiện môi trường.</p>\n\n<p><em>\"Mỗi bóng đèn LED thông minh chúng tôi lắp đặt không chỉ là ánh sáng, mà còn là đóng góp cho một tương lai xanh, bền vững.\"</em></p>\n</div>\n\n<div class=\"contact-cta\">\n<h2>📞 Liên Hệ Tư Vấn</h2>\n<p>Để được tư vấn miễn phí về giải pháp chiếu sáng thông minh phù hợp với nhu cầu của bạn:</p>\n<ul>\n<li>☎️ Hotline: <strong>1900-xxxx</strong></li>\n<li>📧 Email: <strong>info@virical.vn</strong></li>\n<li>🌐 Website: <strong>www.virical.vn</strong></li>\n<li>📍 Showroom: Xem tại trang <a href=\"/lien-he/\">Liên Hệ</a></li>\n</ul>\n</div>\n\n</div>\n\n<style>\n.gioi-thieu-content {\n    max-width: 1200px;\n    margin: 0 auto;\n    padding: 20px;\n}\n\n.intro-section, .smart-lighting-section, .technology-section,\n.solutions-section, .why-virical-section, .achievements-section,\n.vision-section, .contact-cta {\n    margin-bottom: 40px;\n    padding: 30px;\n    background: #f9f9f9;\n    border-radius: 8px;\n}\n\n.intro-section h2, .smart-lighting-section h2, .technology-section h2,\n.solutions-section h2, .why-virical-section h2, .achievements-section h2,\n.vision-section h2, .contact-cta h2 {\n    color: #d4af37;\n    border-bottom: 3px solid #d4af37;\n    padding-bottom: 10px;\n    margin-bottom: 20px;\n}\n\n.solution-item, .reason-item {\n    background: white;\n    padding: 20px;\n    margin-bottom: 20px;\n    border-left: 4px solid #d4af37;\n    box-shadow: 0 2px 5px rgba(0,0,0,0.1);\n}\n\n.solution-item h3, .reason-item h3 {\n    color: #333;\n    margin-top: 0;\n}\n\nul {\n    line-height: 1.8;\n}\n\nul li {\n    margin-bottom: 10px;\n}\n\nstrong {\n    color: #d4af37;\n}\n\n.contact-cta {\n    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);\n    color: white;\n}\n\n.contact-cta h2 {\n    color: white;\n    border-bottom-color: white;\n}\n\n.contact-cta strong {\n    color: #ffd700;\n}\n\n.contact-cta a {\n    color: #ffd700;\n    text-decoration: underline;\n}\n</style>','Giá»›i Thiá»‡u','','publish','closed','closed','','gioi-thieu','','','2025-09-30 02:00:19','2025-09-30 02:00:19','',0,'http://localhost:8082/gioi-thieu/',0,'page','',0),(11,1,'2025-07-28 14:38:42','2025-07-28 14:38:42','\n<!-- wp:template-part {\"slug\":\"page-products-dynamic\"} /-->','Sản Phẩm','','publish','closed','closed','','san-pham','','','2025-07-28 14:38:42','2025-07-28 14:38:42','',0,'http://localhost:8000/?page_id=11',0,'page','',0),(12,1,'2025-07-28 14:38:42','2025-07-28 14:38:42','','Công Trình','','publish','closed','closed','','cong-trinh','','','2025-07-28 14:38:42','2025-07-28 14:38:42','',0,'http://localhost:8000/?page_id=12',0,'page','',0),(13,1,'2025-07-28 14:38:42','2025-07-28 14:38:42','','Liên Hệ','','publish','closed','closed','','lien-he','','','2025-07-28 14:38:42','2025-07-28 14:38:42','',0,'http://localhost:8000/?page_id=13',0,'page','',0),(15,0,'2025-07-28 14:38:42','2025-07-28 14:38:42','','Trang Chủ','','publish','closed','closed','','menu-item-15','','','2025-07-28 14:38:42','2025-07-28 14:38:42','',0,'http://localhost:8000/?p=15',1,'nav_menu_item','',0),(16,0,'2025-07-28 14:38:42','2025-07-28 14:38:42',' ','Chúng Tôi','','publish','closed','closed','','menu-item-16','','','2025-07-28 14:38:42','2025-07-28 14:38:42','',0,'http://localhost:8000/?p=16',2,'nav_menu_item','',0),(17,0,'2025-07-28 14:38:42','2025-07-28 14:38:42',' ','Sản Phẩm','','publish','closed','closed','','menu-item-17','','','2025-07-28 14:38:42','2025-07-28 14:38:42','',0,'http://localhost:8000/?p=17',3,'nav_menu_item','',0),(18,0,'2025-07-28 14:38:42','2025-07-28 14:38:42',' ','Công Trình','','draft','closed','closed','','menu-item-18','','','2025-07-28 14:38:42','2025-07-28 14:38:42','',0,'http://localhost:8000/?p=18',4,'nav_menu_item','',0),(19,0,'2025-07-28 14:38:42','2025-07-28 14:38:42',' ','Liên Hệ','','publish','closed','closed','','menu-item-19','','','2025-07-28 14:38:42','2025-07-28 14:38:42','',0,'http://localhost:8000/?p=19',5,'nav_menu_item','',0),(36,1,'2025-08-08 01:53:55','2025-08-08 01:53:55','<!-- wp:paragraph -->\n<p>sadasd</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>asdasd</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>s</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>đ</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->','','','inherit','closed','closed','','7-revision-v1','','','2025-08-08 01:53:55','2025-08-08 01:53:55','',7,'http://localhost:8000/?p=36',0,'revision','',0),(37,1,'2025-08-10 19:22:05','2025-08-10 19:22:05','<h2>Về Aura Lighting</h2><p>Aura Lighting là thương hiệu hàng đầu trong lĩnh vực chiếu sáng tại Việt Nam.</p>','Chúng Tôi','','inherit','closed','closed','','10-revision-v1','','','2025-08-10 19:22:05','2025-08-10 19:22:05','',10,'http://localhost:8000/?p=37',0,'revision','',0),(38,0,'2025-09-10 12:38:04','2025-09-10 12:38:04','','Indoor','','publish','closed','closed','','indoor','','','2025-09-10 12:38:04','2025-09-10 12:38:04','',0,'http://localhost:9000/indoor/',0,'page','',0),(39,1,'2025-09-10 13:14:11','2025-09-10 13:14:11','','Outdoor','','publish','closed','closed','','outdoor','','','2025-09-10 13:14:11','2025-09-10 13:14:11','',0,'http://localhost:9000/outdoor/',0,'page','',0),(40,1,'2025-09-10 13:35:40','2025-09-10 13:35:40','','Spotgarden2','','inherit','open','closed','','spotgarden2','','','2025-09-10 13:35:40','2025-09-10 13:35:40','',0,'http://localhost:9000/wp-content/uploads/2025/09/Spotgarden2.jpg',0,'attachment','image/jpeg',0),(41,1,'2025-09-10 13:37:54','0000-00-00 00:00:00','','Lưu nháp tự động','','auto-draft','open','open','','','','','2025-09-10 13:37:54','0000-00-00 00:00:00','',0,'http://localhost:9000/?p=41',0,'post','',0),(42,1,'2025-09-30 01:50:20','2025-09-30 01:50:20','<h1>Về Virical</h1>\n\n<h2>Câu chuyện khởi nguồn</h2>\n<p>Virical được thành lập với sứ mệnh mang đến giải pháp chiếu sáng thông minh, tiết kiệm năng lượng và thân thiện với môi trường cho mọi không gian sống và làm việc tại Việt Nam.</p>\n\n<h2>Lịch sử phát triển</h2>\n<p>Từ những bước đi đầu tiên, Virical đã không ngừng đổi mới và phát triển, trở thành một trong những đơn vị tiên phong trong lĩnh vực chiếu sáng LED và công nghệ IoT tại Việt Nam.</p>\n\n<h2>Đội ngũ</h2>\n<p>Với đội ngũ kỹ sư giàu kinh nghiệm và am hiểu công nghệ chiếu sáng, Virical cam kết mang đến những sản phẩm và dịch vụ chất lượng cao nhất.</p>\n\n<h2>Văn hóa doanh nghiệp</h2>\n<ul>\n<li><strong>Đổi mới sáng tạo:</strong> Luôn đi đầu trong ứng dụng công nghệ mới</li>\n<li><strong>Chất lượng:</strong> Cam kết sản phẩm đạt tiêu chuẩn quốc tế</li>\n<li><strong>Khách hàng là trung tâm:</strong> Lắng nghe và đáp ứng mọi nhu cầu</li>\n<li><strong>Trách nhiệm xã hội:</strong> Góp phần bảo vệ môi trường</li>\n</ul>\n\n<h2>Thành tựu & Chứng nhận</h2>\n<p>Virical tự hào đạt được nhiều giải thưởng và chứng nhận uy tín:</p>\n<ul>\n<li>Chứng nhận ISO 9001:2015 về Hệ thống Quản lý Chất lượng</li>\n<li>Chứng nhận sản phẩm đạt tiêu chuẩn Châu Âu (CE)</li>\n<li>Giải thưởng \"Doanh nghiệp tiêu biểu\" trong lĩnh vực công nghệ</li>\n<li>Hơn 500 dự án triển khai thành công</li>\n</ul>','Về Virical','','publish','closed','closed','','ve-virical','','','2025-09-30 01:50:20','2025-09-30 01:50:20','',10,'http://localhost:8082/gioi-thieu/ve-virical/',0,'page','',0),(43,1,'2025-09-30 01:50:20','2025-09-30 01:50:20','<h1>Công nghệ chiếu sáng LED tiên tiến</h1>\n\n<h2>Công nghệ LED hiện đại</h2>\n<p>Virical sử dụng công nghệ LED thế hệ mới nhất từ các nhà sản xuất hàng đầu thế giới, đảm bảo chất lượng ánh sáng tốt nhất và tuổi thọ cao.</p>\n\n<h2>Ưu điểm vượt trội</h2>\n\n<h3>1. Tiết kiệm năng lượng</h3>\n<ul>\n<li>Tiết kiệm đến 80-90% điện năng so với đèn sợi đốt truyền thống</li>\n<li>Giảm 60-70% so với đèn huỳnh quang</li>\n<li>Hiệu suất phát sáng cao (>120 lm/W)</li>\n</ul>\n\n<h3>2. Tuổi thọ vượt trội</h3>\n<ul>\n<li><strong>50,000 giờ</strong> sử dụng (tương đương 17 năm với 8h/ngày)</li>\n<li>Giảm chi phí bảo trì và thay thế</li>\n<li>Độ suy giảm ánh sáng thấp theo thời gian</li>\n</ul>\n\n<h3>3. Chất lượng ánh sáng</h3>\n<ul>\n<li>Chỉ số hoàn màu CRI >80 (tái tạo màu sắc chân thực)</li>\n<li>Nhiệt độ màu linh hoạt: 3000K - 6500K</li>\n<li>Không nhấp nháy, bảo vệ mắt</li>\n<li>Khởi động tức thì, không cần thời gian khởi động</li>\n</ul>\n\n<h3>4. An toàn & Thân thiện môi trường</h3>\n<ul>\n<li>Không chứa thủy ngân hay các chất độc hại</li>\n<li>Nhiệt độ bề mặt thấp, an toàn khi chạm vào</li>\n<li>Không phát tia UV, không gây hại côn trùng</li>\n<li>100% có thể tái chế</li>\n</ul>\n\n<h2>Công nghệ điều khiển thông minh</h2>\n<p>Tích hợp khả năng điều khiển qua:</p>\n<ul>\n<li>Bluetooth Mesh</li>\n<li>Zigbee / Z-Wave</li>\n<li>WiFi</li>\n<li>DALI (Digital Addressable Lighting Interface)</li>\n<li>DMX512 cho chiếu sáng sân khấu</li>\n</ul>\n\n<h2>Tiêu chuẩn & Chứng nhận</h2>\n<ul>\n<li>CE - Tiêu chuẩn Châu Âu</li>\n<li>RoHS - Không chất độc hại</li>\n<li>IP65 - Chống bụi và nước</li>\n<li>IK08 - Chống va đập</li>\n</ul>','Công nghệ chiếu sáng','','publish','closed','closed','','cong-nghe','','','2025-09-30 01:50:20','2025-09-30 01:50:20','',10,'http://localhost:8082/gioi-thieu/cong-nghe/',0,'page','',0),(44,1,'2025-09-30 01:50:20','2025-09-30 01:50:20','<h1>Tầm nhìn & Sứ mệnh Virical</h1>\n\n<h2>🎯 Tầm nhìn</h2>\n<blockquote>\n<p><strong>\"Trở thành đơn vị hàng đầu Việt Nam trong lĩnh vực giải pháp chiếu sáng thông minh, góp phần xây dựng một tương lai bền vững và tiết kiệm năng lượng.\"</strong></p>\n</blockquote>\n\n<p>Đến năm 2030, Virical phấn đấu:</p>\n<ul>\n<li>Dẫn đầu thị trường chiếu sáng LED thông minh tại Việt Nam</li>\n<li>Mở rộng ra thị trường khu vực Đông Nam Á</li>\n<li>Triển khai thành công 10,000+ dự án chiếu sáng thông minh</li>\n<li>Góp phần giảm 1 triệu tấn CO2 thông qua tiết kiệm năng lượng</li>\n</ul>\n\n<h2>🚀 Sứ mệnh</h2>\n\n<h3>1. Mang ánh sáng chất lượng đến mọi không gian</h3>\n<p>Cung cấp giải pháp chiếu sáng LED tiên tiến, chất lượng cao với giá thành hợp lý, giúp mọi người tiếp cận được công nghệ chiếu sáng hiện đại.</p>\n\n<h3>2. Tiên phong công nghệ IoT và Smart Lighting</h3>\n<p>Nghiên cứu và ứng dụng công nghệ chiếu sáng thông minh, tích hợp IoT, AI để tối ưu hóa trải nghiệm người dùng và tiết kiệm năng lượng.</p>\n\n<h3>3. Bảo vệ môi trường</h3>\n<p>Cam kết sử dụng công nghệ xanh, sản phẩm thân thiện môi trường, góp phần giảm lượng khí thải CO2 và bảo vệ hành tinh.</p>\n\n<h3>4. Phát triển bền vững</h3>\n<p>Xây dựng mô hình kinh doanh bền vững, tạo giá trị lâu dài cho khách hàng, đối tác, nhân viên và cộng đồng.</p>\n\n<h2>💎 Giá trị cốt lõi</h2>\n\n<h3>Chất lượng (Quality)</h3>\n<p>Cam kết mang đến sản phẩm và dịch vụ chất lượng cao nhất, đạt tiêu chuẩn quốc tế.</p>\n\n<h3>Đổi mới (Innovation)</h3>\n<p>Không ngừng nghiên cứu, sáng tạo và ứng dụng công nghệ mới vào sản phẩm.</p>\n\n<h3>Tận tâm (Dedication)</h3>\n<p>Lắng nghe, thấu hiểu và đáp ứng mọi nhu cầu của khách hàng với tinh thần trách nhiệm cao nhất.</p>\n\n<h3>Trách nhiệm (Responsibility)</h3>\n<p>Cam kết trách nhiệm với xã hội và môi trường trong mọi hoạt động kinh doanh.</p>\n\n<h3>Hợp tác (Collaboration)</h3>\n<p>Xây dựng mối quan hệ bền vững với khách hàng, đối tác và cộng đồng.</p>\n\n<h2>🌱 Cam kết phát triển bền vững</h2>\n<ul>\n<li><strong>Kinh tế:</strong> Tạo giá trị bền vững cho khách hàng thông qua tiết kiệm năng lượng</li>\n<li><strong>Xã hội:</strong> Tạo việc làm, đào tạo nguồn nhân lực chất lượng cao</li>\n<li><strong>Môi trường:</strong> Giảm thiểu tác động tiêu cực đến môi trường</li>\n</ul>\n\n<blockquote>\n<p><em>\"Mỗi bóng đèn LED chúng tôi lắp đặt không chỉ là ánh sáng, mà còn là đóng góp cho một tương lai xanh, bền vững.\"</em></p>\n<p><strong>- Đội ngũ Virical</strong></p>\n</blockquote>','Tầm nhìn & Sứ mệnh','','publish','closed','closed','','tam-nhin','','','2025-09-30 01:50:20','2025-09-30 01:50:20','',10,'http://localhost:8082/gioi-thieu/tam-nhin/',0,'page','',0),(45,0,'2025-09-30 02:38:20','2025-09-30 02:38:20','','Chiếu Sáng Hiện Đại','','publish','closed','closed','','chieu-sang-hien-dai','','','2025-09-30 02:38:20','2025-09-30 02:38:20','',0,'http://localhost:8082/?p=45',1,'aura_slider','',0),(46,0,'2025-09-30 02:38:21','2025-09-30 02:38:21','','contract_oficinas_arkoslight-899x1024-1.jpg','','inherit','open','closed','','contract_oficinas_arkoslight-899x1024-1-jpg','','','2025-09-30 02:38:21','2025-09-30 02:38:21','',45,'http://localhost:8082/?attachment_id=46',0,'attachment','image/jpeg',0),(47,0,'2025-09-30 02:38:21','2025-09-30 02:38:21','','Không Gian Sống Đẳng Cấp','','publish','closed','closed','','khong-gian-song-dang-cap','','','2025-09-30 02:38:21','2025-09-30 02:38:21','',0,'http://localhost:8082/?p=47',2,'aura_slider','',0),(48,0,'2025-09-30 02:38:21','2025-09-30 02:38:21','','habitat_home.jpg','','inherit','open','closed','','habitat_home-jpg','','','2025-09-30 02:38:21','2025-09-30 02:38:21','',47,'http://localhost:8082/?attachment_id=48',0,'attachment','image/jpeg',0),(49,0,'2025-09-30 02:38:22','2025-09-30 02:38:22','','Dự Án Tiêu Biểu','','publish','closed','closed','','du-an-tieu-bieu','','','2025-09-30 02:38:22','2025-09-30 02:38:22','',0,'http://localhost:8082/?p=49',3,'aura_slider','',0),(50,0,'2025-09-30 02:38:22','2025-09-30 02:38:22','','post_gal_0029_r1-1024x576.jpg','','inherit','open','closed','','post_gal_0029_r1-1024x576-jpg','','','2025-09-30 02:38:22','2025-09-30 02:38:22','',49,'http://localhost:8082/?attachment_id=50',0,'attachment','image/jpeg',0),(51,0,'2025-09-30 02:38:22','2025-09-30 02:38:22','','Bộ Sưu Tập 2024','','publish','closed','closed','','bo-suu-tap-2024','','','2025-09-30 02:38:22','2025-09-30 02:38:22','',0,'http://localhost:8082/?p=51',4,'aura_slider','',0),(52,0,'2025-09-30 02:38:22','2025-09-30 02:38:22','','2022_collection-Aura.jpg','','inherit','open','closed','','2022_collection-aura-jpg','','','2025-09-30 02:38:22','2025-09-30 02:38:22','',51,'http://localhost:8082/?attachment_id=52',0,'attachment','image/jpeg',0),(53,1,'2025-09-30 02:48:08','2025-09-30 02:48:08','','Giải Pháp Thông Minh','','publish','closed','closed','','giai-phap-thong-minh','','','2025-09-30 02:48:08','2025-09-30 02:48:08','',0,'http://localhost:8082/giai-phap-thong-minh/',5,'page','',0);
/*!40000 ALTER TABLE `wp_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_products_page_settings`
--

DROP TABLE IF EXISTS `wp_products_page_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_products_page_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `setting_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_products_page_settings`
--

LOCK TABLES `wp_products_page_settings` WRITE;
/*!40000 ALTER TABLE `wp_products_page_settings` DISABLE KEYS */;
INSERT INTO `wp_products_page_settings` VALUES (1,'page_title','Sản phẩm','text','2025-09-09 11:00:30'),(2,'page_subtitle','Khám phá bộ sưu tập đèn chiếu sáng cao cấp','text','2025-09-09 11:00:30'),(3,'products_per_page','12','text','2025-09-09 11:00:30'),(4,'enable_filter','1','text','2025-09-09 11:00:30'),(5,'enable_search','1','text','2025-09-09 11:00:30'),(6,'enable_sorting','1','text','2025-09-09 11:00:30'),(7,'default_sort','name_asc','text','2025-09-09 11:00:30'),(8,'grid_columns','3','text','2025-09-09 11:00:30'),(9,'show_price','1','text','2025-09-09 11:00:30'),(10,'show_category','1','text','2025-09-09 11:00:30');
/*!40000 ALTER TABLE `wp_products_page_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_project_categories`
--

DROP TABLE IF EXISTS `wp_project_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_project_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_project_categories`
--

LOCK TABLES `wp_project_categories` WRITE;
/*!40000 ALTER TABLE `wp_project_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_project_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_projects_page_settings`
--

DROP TABLE IF EXISTS `wp_projects_page_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_projects_page_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `setting_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_projects_page_settings`
--

LOCK TABLES `wp_projects_page_settings` WRITE;
/*!40000 ALTER TABLE `wp_projects_page_settings` DISABLE KEYS */;
INSERT INTO `wp_projects_page_settings` VALUES (1,'page_title','Công Trình','text','2025-09-09 11:00:30'),(2,'page_subtitle','Các dự án chiếu sáng đã thực hiện','text','2025-09-09 11:00:30'),(3,'projects_per_page','9','text','2025-09-09 11:00:30'),(4,'enable_filter','1','text','2025-09-09 11:00:30'),(5,'enable_type_filter','1','text','2025-09-09 11:00:30'),(6,'grid_columns','3','text','2025-09-09 11:00:30'),(7,'show_location','1','text','2025-09-09 11:00:30'),(8,'show_year','1','text','2025-09-09 11:00:30'),(9,'show_type','1','text','2025-09-09 11:00:30');
/*!40000 ALTER TABLE `wp_projects_page_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_term_relationships` (
  `object_id` bigint unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint unsigned NOT NULL DEFAULT '0',
  `term_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_relationships`
--

LOCK TABLES `wp_term_relationships` WRITE;
/*!40000 ALTER TABLE `wp_term_relationships` DISABLE KEYS */;
INSERT INTO `wp_term_relationships` VALUES (1,1,0),(6,2,0),(7,1,0),(15,3,0),(16,3,0),(17,3,0),(18,3,0),(19,3,0),(20,4,0),(21,4,0),(22,4,0),(23,4,0);
/*!40000 ALTER TABLE `wp_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent` bigint unsigned NOT NULL DEFAULT '0',
  `count` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_taxonomy`
--

LOCK TABLES `wp_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `wp_term_taxonomy` DISABLE KEYS */;
INSERT INTO `wp_term_taxonomy` VALUES (1,1,'category','',0,1),(2,2,'wp_theme','',0,1),(3,3,'nav_menu','',0,5),(4,4,'product_category','Sản phẩm chiếu sáng trong nhà',0,4);
/*!40000 ALTER TABLE `wp_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_termmeta`
--

DROP TABLE IF EXISTS `wp_termmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_termmeta` (
  `meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_termmeta`
--

LOCK TABLES `wp_termmeta` WRITE;
/*!40000 ALTER TABLE `wp_termmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_termmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_terms` (
  `term_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `slug` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `term_group` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_terms`
--

LOCK TABLES `wp_terms` WRITE;
/*!40000 ALTER TABLE `wp_terms` DISABLE KEYS */;
INSERT INTO `wp_terms` VALUES (1,'Chưa phân loại','chua-phan-loai',0),(2,'twentytwentyfive','twentytwentyfive',0),(3,'Main Menu','main-menu',0),(4,'Indoor','indoor',0);
/*!40000 ALTER TABLE `wp_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_usermeta`
--

LOCK TABLES `wp_usermeta` WRITE;
/*!40000 ALTER TABLE `wp_usermeta` DISABLE KEYS */;
INSERT INTO `wp_usermeta` VALUES (1,1,'nickname','nguyen'),(2,1,'first_name',''),(3,1,'last_name',''),(4,1,'description',''),(5,1,'rich_editing','true'),(6,1,'syntax_highlighting','true'),(7,1,'comment_shortcuts','false'),(8,1,'admin_color','fresh'),(9,1,'use_ssl','0'),(10,1,'show_admin_bar_front','true'),(11,1,'locale',''),(12,1,'wp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),(13,1,'wp_user_level','10'),(14,1,'dismissed_wp_pointers',''),(15,1,'show_welcome_panel','0'),(17,1,'wp_dashboard_quick_press_last_post_id','4'),(18,1,'community-events-location','a:1:{s:2:\"ip\";s:9:\"10.89.3.0\";}'),(19,1,'wp_persisted_preferences','a:4:{s:4:\"core\";a:1:{s:26:\"isComplementaryAreaVisible\";b:0;}s:9:\"_modified\";s:24:\"2025-07-28T14:33:12.239Z\";s:14:\"core/edit-post\";a:1:{s:12:\"welcomeGuide\";b:0;}s:17:\"core/edit-widgets\";a:2:{s:26:\"isComplementaryAreaVisible\";b:1;s:12:\"welcomeGuide\";b:0;}}'),(20,1,'nav_menu_recently_edited','3'),(21,1,'managenav-menuscolumnshidden','a:5:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";i:4;s:15:\"title-attribute\";}'),(22,1,'metaboxhidden_nav-menus','a:4:{i:0;s:26:\"add-post-type-aura_product\";i:1;s:26:\"add-post-type-aura_project\";i:2;s:12:\"add-post_tag\";i:3;s:20:\"add-product_category\";}'),(23,1,'session_tokens','a:13:{s:64:\"717ba35610bcfa56b29eaefde5f136b8e8fa2f5478a9f46d60844c261bd00ccb\";a:4:{s:10:\"expiration\";i:1757617689;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757444889;}s:64:\"f1296130e93b032d7219ab8ecdd1b1ce3d674b6ce0ffc587900b85dd0ee56c45\";a:4:{s:10:\"expiration\";i:1757619579;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757446779;}s:64:\"37c55c3ba87b3b296f2bbfdfb1b552250f18fd085b40514e8dfe6311f87276b7\";a:4:{s:10:\"expiration\";i:1757621219;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757448419;}s:64:\"ec7245f478d45f747ac6b3434a4dd50c528f73c162592ec9d349e182facd73b3\";a:4:{s:10:\"expiration\";i:1757621730;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757448930;}s:64:\"9ef245efde20219d4aa8f743fc16f7e66dadcce709f1c5148258b2c740bfcc7a\";a:4:{s:10:\"expiration\";i:1757639089;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757466289;}s:64:\"b90d140c4aee0fa9df75615faea045f5299efad44fff83bde528a2e8cb070be4\";a:4:{s:10:\"expiration\";i:1757681820;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757509020;}s:64:\"b4534a3fbaa140db66d20f60163456644795cbbf6647db60eb0170656b496b03\";a:4:{s:10:\"expiration\";i:1757683333;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757510533;}s:64:\"440c3c71f2153b4063c3019f5dcbb78de08dce8ad6739a3540ed084c8b742f56\";a:4:{s:10:\"expiration\";i:1757683502;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757510702;}s:64:\"4ef857f2141d34fc9f50b9bb4c588c6996e036a37f1d61b6199173c2fe788c80\";a:4:{s:10:\"expiration\";i:1757683856;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757511056;}s:64:\"23f5c65f0951cc2fb34ddefc24494a627763c8b842346cc69b0442db652e255c\";a:4:{s:10:\"expiration\";i:1757684047;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757511247;}s:64:\"a4f3cd34a7187a8301e1be867709d995636e728fa8657ed87a612704a28cd51e\";a:4:{s:10:\"expiration\";i:1757684680;s:2:\"ip\";s:9:\"10.89.3.3\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757511880;}s:64:\"8ab1d50f18d53a3e29249510351d23b6689c9170efcbd8a173cb0e00fa577080\";a:4:{s:10:\"expiration\";i:1757778309;s:2:\"ip\";s:9:\"10.89.3.6\";s:2:\"ua\";s:10:\"curl/8.5.0\";s:5:\"login\";i:1757605509;}s:64:\"e5514216f73fe2d795e1ca140df8140f928f50f2b0dedd18305464bc2d17df53\";a:4:{s:10:\"expiration\";i:1757779103;s:2:\"ip\";s:9:\"10.89.3.6\";s:2:\"ua\";s:101:\"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\";s:5:\"login\";i:1757606303;}}'),(24,1,'wp_user-settings','libraryContent=browse'),(25,1,'wp_user-settings-time','1757511385');
/*!40000 ALTER TABLE `wp_usermeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_users` (
  `ID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int NOT NULL DEFAULT '0',
  `display_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_users`
--

LOCK TABLES `wp_users` WRITE;
/*!40000 ALTER TABLE `wp_users` DISABLE KEYS */;
INSERT INTO `wp_users` VALUES (1,'nguyen','$wp$2y$10$4PDK/6V3xhfLfpe7yXLxRui0FhMpA/mt.UJMDy.UMKRG8dycrmnSu','nguyen','admin@virical.vn','http://localhost:8000','2025-07-28 14:12:54','',0,'nguyen');
/*!40000 ALTER TABLE `wp_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_admin_menus`
--

DROP TABLE IF EXISTS `wp_virical_admin_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_admin_menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent_slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `menu_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `page_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `capability` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT 'manage_options',
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `position` int DEFAULT NULL,
  `callback_function` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `meta_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_slug` (`menu_slug`),
  KEY `idx_parent` (`parent_slug`),
  KEY `idx_active` (`is_active`),
  KEY `idx_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_admin_menus`
--

LOCK TABLES `wp_virical_admin_menus` WRITE;
/*!40000 ALTER TABLE `wp_virical_admin_menus` DISABLE KEYS */;
INSERT INTO `wp_virical_admin_menus` VALUES (1,'virical-products',NULL,'Sản phẩm Virical','Quản lý Sản phẩm','manage_options','dashicons-cart',30,'virical_products_page',1,1,'{\"help_text\": \"Thêm, sửa, xóa sản phẩm\", \"description\": \"Quản lý sản phẩm Virical\", \"original_file\": \"products-admin.php\"}','2025-09-09 10:59:38','2025-09-09 10:59:38'),(2,'virical-categories','virical-products','Danh mục','Danh mục sản phẩm','manage_options',NULL,NULL,'virical_categories_page',1,1,'{\"description\": \"Quản lý danh mục sản phẩm\"}','2025-09-09 10:59:38','2025-09-09 10:59:38'),(3,'virical-projects',NULL,'Công trình Virical','Quản lý Công trình','manage_options','dashicons-building',31,'virical_projects_admin_page',1,2,'{\"description\": \"Quản lý công trình\", \"original_file\": \"projects-admin.php\"}','2025-09-09 10:59:38','2025-09-09 10:59:38'),(4,'virical-project-types','virical-projects','Loại công trình','Loại công trình','manage_options',NULL,NULL,'virical_project_types_page',1,1,'{\"description\": \"Quản lý loại công trình\"}','2025-09-09 10:59:38','2025-09-09 10:59:38'),(5,'virical-about',NULL,'About Page','About Page Settings','manage_options','dashicons-info',32,'aura_about_page_admin_page',0,3,'{\"description\": \"Quản lý trang About\", \"original_file\": \"about-page-admin.php\"}','2025-09-09 10:59:38','2025-09-10 01:11:19'),(6,'virical-settings',NULL,'Cài đặt Virical','Cài đặt hệ thống','manage_options','dashicons-admin-settings',99,'virical_settings_page',1,10,'{\"description\": \"Cài đặt chung cho hệ thống Virical\"}','2025-09-09 10:59:38','2025-09-09 10:59:38'),(7,'virical-company-settings','virical-settings','Company Info','Company Settings','manage_options',NULL,NULL,'virical_company_settings_page',1,1,'{\"description\": \"Thông tin công ty\", \"original_file\": \"company-settings.php\"}','2025-09-09 10:59:38','2025-09-09 10:59:38'),(8,'virical-footer-menu','virical-settings','Footer Menu','Footer Menu Settings','manage_options',NULL,NULL,'virical_footer_menu_settings_page',1,2,'{\"description\": \"Cài đặt menu footer\", \"original_file\": \"footer-menu-settings.php\"}','2025-09-09 10:59:38','2025-09-09 10:59:38'),(9,'virical-product-settings','virical-settings','Product Settings','Product Page Settings','manage_options',NULL,NULL,'virical_product_settings_page',1,3,'{\"description\": \"Cài đặt trang sản phẩm\", \"original_file\": \"product-settings.php\"}','2025-09-09 10:59:38','2025-09-09 10:59:38'),(10,'virical-migration','virical-settings','Migration Tools','Migration Tools','manage_options',NULL,NULL,'virical_migration_admin_page',1,14,'{\"description\": \"Công cụ migration dữ liệu\", \"original_file\": \"migrate-aura-to-virical.php\"}','2025-09-09 10:59:38','2025-09-09 19:37:26'),(11,'virical-week1-migration','virical-migration','Week 1 Migration','Week 1: Quick Fixes','manage_options',NULL,NULL,'virical_week1_migration_page',1,15,'{\"description\": \"Week 1 migration tasks\", \"original_file\": \"migrations/week1-quick-fixes.php\"}','2025-09-09 10:59:38','2025-09-09 19:37:26'),(12,'virical-add-product','virical-products','Thêm mới','Thêm sản phẩm mới','manage_options',NULL,NULL,'virical_add_product_page',1,3,'{\"source\": \"migration_fix\", \"version\": \"1.0.0\"}','2025-09-09 19:37:26','2025-09-09 19:37:26'),(13,'virical-add-project','virical-projects','Thêm mới','Thêm công trình mới','manage_options',NULL,NULL,'virical_add_project_page',1,6,NULL,'2025-09-09 19:37:26','2025-09-09 19:37:26'),(14,'virical-contact',NULL,'Contact Page','Contact Page Settings','manage_options','dashicons-email',33,'virical_contact_page_admin',1,8,NULL,'2025-09-09 19:37:26','2025-09-09 19:37:26'),(15,'virical-homepage',NULL,'Homepage Settings','Homepage Configuration','manage_options','dashicons-admin-home',34,'virical_homepage_settings',1,9,NULL,'2025-09-09 19:37:26','2025-09-09 19:37:26'),(16,'virical-general-settings','virical-settings','Cài đặt chung','Cài đặt chung','manage_options',NULL,NULL,'virical_general_settings_page',1,11,NULL,'2025-09-09 19:37:26','2025-09-09 19:37:26'),(17,'virical-seo-settings','virical-settings','SEO Settings','SEO Configuration','manage_options',NULL,NULL,'virical_seo_settings_page',1,12,NULL,'2025-09-09 19:37:26','2025-09-09 19:37:26'),(18,'virical-cache-settings','virical-settings','Cache Settings','Cache Configuration','manage_options',NULL,NULL,'virical_cache_settings_page',1,13,NULL,'2025-09-09 19:37:26','2025-09-09 19:37:26');
/*!40000 ALTER TABLE `wp_virical_admin_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_company_info`
--

DROP TABLE IF EXISTS `wp_virical_company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_company_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `info_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `info_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `info_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `info_key` (`info_key`),
  KEY `idx_key` (`info_key`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_company_info`
--

LOCK TABLES `wp_virical_company_info` WRITE;
/*!40000 ALTER TABLE `wp_virical_company_info` DISABLE KEYS */;
INSERT INTO `wp_virical_company_info` VALUES (1,'company_name','VIRICAL VIET NAM JOINT STOCK COMPANY','text','2025-09-10 00:52:05','2025-09-11 16:43:23'),(2,'tagline','Feeling Light','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(3,'company_description','Thương hiệu đèn chiếu sáng hàng đầu Việt Nam với các giải pháp chiếu sáng thông minh và hiện đại.','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(4,'hotline','1900 6888','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(5,'phone','0869995698','text','2025-09-10 00:52:05','2025-09-11 16:43:23'),(6,'mobile','0869995698','text','2025-09-10 00:52:05','2025-09-11 16:43:23'),(7,'email','info@virical.vn','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(8,'address','Số 30 Ngõ 100 Nguyễn Xiển, Phường Hạ Đình, Quận Thanh Xuân, Thành phố Hà Nội, Việt Nam','text','2025-09-10 00:52:05','2025-09-11 16:43:23'),(9,'working_hours','Thứ 2 - Thứ 6: 8:00 - 17:30\\\\nThứ 7: 8:00 - 12:00','text','2025-09-10 00:52:05','2025-09-10 00:56:45'),(10,'copyright_text','© 2025 Virical. All Rights Reserved. | Designed by Virical Team','text','2025-09-10 00:52:05','2025-09-10 00:56:45'),(11,'google_maps_url','https://maps.google.com/?q=Số+8+Tôn+Thất+Thuyết+Hà+Nội','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(12,'facebook','https://www.facebook.com/virical','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(13,'youtube','https://www.youtube.com/virical','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(14,'zalo','https://zalo.me/virical','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(15,'instagram','https://www.instagram.com/virical','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(16,'linkedin','https://www.linkedin.com/company/virical','text','2025-09-10 00:52:05','2025-09-10 00:52:05'),(18,'representative','ĐỖ NGỌC PHI','text','2025-09-11 16:43:23','2025-09-11 16:43:23'),(19,'company_short_name','VIRICAL.,JSC','text','2025-09-11 16:43:23','2025-09-11 16:43:23');
/*!40000 ALTER TABLE `wp_virical_company_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_footer_menu`
--

DROP TABLE IF EXISTS `wp_virical_footer_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_footer_menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_section` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `menu_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `menu_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_section` (`menu_section`),
  KEY `idx_active` (`is_active`),
  KEY `idx_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_footer_menu`
--

LOCK TABLES `wp_virical_footer_menu` WRITE;
/*!40000 ALTER TABLE `wp_virical_footer_menu` DISABLE KEYS */;
INSERT INTO `wp_virical_footer_menu` VALUES (1,'products','Đèn Indoor','/indoor/',1,1,'2025-09-10 00:52:05','2025-09-10 00:52:05'),(2,'products','Đèn Outdoor','/outdoor/',2,1,'2025-09-10 00:52:05','2025-09-10 00:52:05'),(3,'products','Đèn Downlight','/san-pham/downlight/',3,1,'2025-09-10 00:52:05','2025-09-10 00:52:05'),(4,'products','Đèn Spotlight','/san-pham/spotlight/',4,1,'2025-09-10 00:52:05','2025-09-10 00:52:05'),(5,'products','Đèn Ray Nam Châm','/san-pham/ray-nam-cham/',5,1,'2025-09-10 00:52:05','2025-09-10 00:52:05'),(6,'info','Về Chúng Tôi','/gioi-thieu/',1,1,'2025-09-10 00:52:05','2025-09-10 00:52:05'),(7,'info','Công Trình','/cong-trinh/',2,1,'2025-09-10 00:52:05','2025-09-10 00:52:05'),(8,'info','Catalogue','/catalogue/',3,1,'2025-09-10 00:52:05','2025-09-10 00:52:05'),(9,'info','Chính Sách Bảo Hành','/chinh-sach-bao-hanh/',4,1,'2025-09-10 00:52:05','2025-09-10 00:52:05'),(10,'info','Liên Hệ','/lien-he/',5,1,'2025-09-10 00:52:05','2025-09-10 00:52:05');
/*!40000 ALTER TABLE `wp_virical_footer_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_navigation_menus`
--

DROP TABLE IF EXISTS `wp_virical_navigation_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_navigation_menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_location` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `item_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `item_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `item_target` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT '_self',
  `item_classes` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `item_icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `item_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `meta_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_location` (`menu_location`),
  KEY `idx_parent` (`parent_id`),
  KEY `idx_active` (`is_active`),
  KEY `idx_order` (`sort_order`),
  CONSTRAINT `wp_virical_navigation_menus_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `wp_virical_navigation_menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_navigation_menus`
--

LOCK TABLES `wp_virical_navigation_menus` WRITE;
/*!40000 ALTER TABLE `wp_virical_navigation_menus` DISABLE KEYS */;
INSERT INTO `wp_virical_navigation_menus` VALUES (6,'footer',NULL,'Chính sách bảo mật','/chinh-sach-bao-mat/','_self',NULL,NULL,NULL,1,1,'{\"source\": \"migration_004\", \"version\": \"1.0.0\"}','2025-09-09 20:03:07','2025-09-09 20:03:07'),(7,'footer',NULL,'Điều khoản sử dụng','/dieu-khoan-su-dung/','_self',NULL,NULL,NULL,1,2,'{\"source\": \"migration_004\", \"version\": \"1.0.0\"}','2025-09-09 20:03:07','2025-09-09 20:03:07'),(8,'footer',NULL,'Hỗ trợ','/ho-tro/','_self',NULL,NULL,NULL,1,3,'{\"source\": \"migration_004\", \"version\": \"1.0.0\"}','2025-09-09 20:03:07','2025-09-09 20:03:07'),(9,'primary',NULL,'Trang chủ','/','_self',NULL,NULL,'Trang chủ Virical',1,1,NULL,'2025-09-30 01:24:09','2025-09-30 01:53:03'),(10,'primary',NULL,'Giới thiệu','/gioi-thieu/','_self',NULL,NULL,'Giới thiệu về Virical',1,2,NULL,'2025-09-30 01:24:09','2025-09-30 01:53:03'),(11,'primary',NULL,'Sản phẩm đèn','/san-pham/','_self',NULL,NULL,'Danh mục sản phẩm đèn LED',1,3,NULL,'2025-09-30 01:24:09','2025-09-30 01:53:03'),(12,'primary',NULL,'Giải pháp thông minh','/giai-phap-thong-minh/','_self',NULL,NULL,'Đèn chiếu sáng thông minh IoT',1,4,NULL,'2025-09-30 01:24:09','2025-09-30 01:53:03'),(13,'primary',NULL,'Dự án','/du-an/','_self',NULL,NULL,'Các dự án tiêu biểu',0,5,NULL,'2025-09-30 01:24:09','2025-09-30 04:00:06'),(14,'primary',NULL,'Liên hệ','/lien-he/','_self',NULL,NULL,'Liên hệ với Virical',1,6,NULL,'2025-09-30 01:24:09','2025-09-30 01:53:03'),(18,'primary',11,'Đèn trong nhà','/san-pham/den-trong-nha/','_self',NULL,NULL,'Đèn LED cho không gian nội thất',0,1,NULL,'2025-09-30 01:24:09','2025-09-30 06:12:57'),(19,'primary',11,'Đèn ngoài trời','/san-pham/den-ngoai-troi/','_self',NULL,NULL,'Đèn đường, đèn sân vườn',0,2,NULL,'2025-09-30 01:24:09','2025-09-30 06:12:57'),(20,'primary',11,'Đèn công nghiệp','/san-pham/den-cong-nghiep/','_self',NULL,NULL,'Đèn cho nhà xưởng, kho bãi',0,3,NULL,'2025-09-30 01:24:09','2025-09-30 06:12:57'),(21,'primary',11,'Đèn trang trí','/san-pham/den-trang-tri/','_self',NULL,NULL,'Đèn LED RGB, đèn dây',0,4,NULL,'2025-09-30 01:24:09','2025-09-30 06:12:57');
/*!40000 ALTER TABLE `wp_virical_navigation_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_page_templates`
--

DROP TABLE IF EXISTS `wp_virical_page_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_page_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `template_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `template_type` enum('page','post','archive','single') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT 'page',
  `template_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `template_settings` json DEFAULT NULL,
  `sections` json DEFAULT NULL,
  `css_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `js_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `version` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT '1.0.0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `template_name` (`template_name`),
  KEY `idx_type` (`template_type`),
  KEY `idx_active` (`is_active`),
  KEY `idx_name` (`template_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_page_templates`
--

LOCK TABLES `wp_virical_page_templates` WRITE;
/*!40000 ALTER TABLE `wp_virical_page_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_virical_page_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_product_categories`
--

DROP TABLE IF EXISTS `wp_virical_product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_product_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT '0',
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`slug`),
  KEY `idx_parent` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_product_categories`
--

LOCK TABLES `wp_virical_product_categories` WRITE;
/*!40000 ALTER TABLE `wp_virical_product_categories` DISABLE KEYS */;
INSERT INTO `wp_virical_product_categories` VALUES (1,'Đèn Ray Nam Châm','den-ray-nam-cham','Hệ thống đèn ray nam châm linh hoạt',NULL,0,10,1),(2,'Đèn Âm Trần','den-am-tran','Đèn downlight âm trần cao cấp',NULL,0,20,1),(3,'Đèn Ốp Nổi','den-op-noi','Đèn ốp trần và tường hiện đại',NULL,0,30,1),(4,'Đèn Ngoài Trời','den-ngoai-troi','Đèn chiếu sáng ngoài trời chống nước',NULL,0,40,1),(5,'Đèn Trang Trí','den-trang-tri','Đèn trang trí nghệ thuật',NULL,0,50,1),(6,'Đèn LED Dây','den-led-day','Đèn LED dây linh hoạt',NULL,0,60,1);
/*!40000 ALTER TABLE `wp_virical_product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_products`
--

DROP TABLE IF EXISTS `wp_virical_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `specifications` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `technical_specs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `downloads` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `view_count` int DEFAULT '0',
  `gallery` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gallery_images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_featured` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`slug`),
  KEY `idx_category` (`category`),
  KEY `idx_featured` (`is_featured`),
  KEY `idx_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_products`
--

LOCK TABLES `wp_virical_products` WRITE;
/*!40000 ALTER TABLE `wp_virical_products` DISABLE KEYS */;
INSERT INTO `wp_virical_products` VALUES (1,'Ray Nam Châm MAGNA Pro 48V','ray-nam-cham-magna-pro-48v','Hệ thống ray nam châm chuyên nghiệp với điện áp 48V an toàn, cho phép di chuyển và điều chỉnh đèn linh hoạt.','den-ray-nam-cham',1500000.00,'http://localhost:8082/wp-content/uploads/2025/01/10.1.png','[\"\\u0110i\\u1ec7n \\u00e1p an to\\u00e0n 48V\",\"D\\u1ec5 d\\u00e0ng l\\u1eafp \\u0111\\u1eb7t v\\u00e0 di chuy\\u1ec3n\",\"Thi\\u1ebft k\\u1ebf t\\u1ed1i gi\\u1ea3n, hi\\u1ec7n \\u0111\\u1ea1i\",\"T\\u01b0\\u01a1ng th\\u00edch v\\u1edbi nhi\\u1ec1u lo\\u1ea1i \\u0111\\u00e8n\"]',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/10.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/10.3.png\"]',1,1,0,'2025-07-28 18:25:32','2025-09-30 05:53:48'),(2,'Đèn Spotlight Ray Nam Châm 15W','den-spotlight-ray-nam-cham-15w','Đèn spotlight gắn ray nam châm công suất 15W, góc chiếu điều chỉnh được.','den-ray-nam-cham',850000.00,'http://localhost:8082/wp-content/uploads/2025/09/42.1_.png','[\"C\\u00f4ng su\\u1ea5t: 15W\",\"Hi\\u1ec7u su\\u1ea5t ph\\u00e1t quang: >90lm\\/W\",\"CRI > 90\",\"G\\u00f3c chi\\u1ebfu: 15\\u00b0 - 60\\u00b0\"]',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/42.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/11.1.png\"]',0,1,0,'2025-07-28 18:25:32','2025-09-30 05:53:48'),(3,'Downlight Âm Trần LUXO 12W','downlight-am-tran-luxo-12w','Đèn downlight âm trần cao cấp, thiết kế siêu mỏng chỉ 25mm.','den-am-tran',650000.00,'http://localhost:8082/wp-content/uploads/2025/09/36.1.png','[\"C\\u00f4ng su\\u1ea5t: 12W\",\"L\\u1ed7 kho\\u00e9t: \\u03a675mm\",\"\\u0110\\u1ed9 d\\u00e0y: 25mm\",\"Tu\\u1ed5i th\\u1ecd: 50,000 gi\\u1edd\"]',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/36.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/den-led-panel-600x600-48w-gia-re_upscayl_5x_upscayl-standard-4x.png\"]',1,1,0,'2025-07-28 18:25:32','2025-09-30 05:53:48'),(4,'Đèn Ốp Trần AURA Circle 40W','den-op-tran-aura-circle-40w','Đèn ốp trần hình tròn phong cách hiện đại, ánh sáng mềm mại.','den-op-noi',1200000.00,'http://localhost:8082/wp-content/uploads/2025/09/32.1.png','[\"C\\u00f4ng su\\u1ea5t: 40W\",\"K\\u00edch th\\u01b0\\u1edbc: \\u03a6500mm\",\"Nhi\\u1ec7t \\u0111\\u1ed9 m\\u00e0u: 3000K\\/4000K\\/6500K\",\"\\u0110i\\u1ec1u khi\\u1ec3n: Remote\\/App\"]',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/32.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/33.1.png\"]',0,1,0,'2025-07-28 18:25:32','2025-09-30 05:53:48'),(5,'Đèn Tường Ngoài Trời WALL-X IP65','den-tuong-ngoai-troi-wall-x-ip65','Đèn tường ngoài trời chống nước IP65, thiết kế hai chiều sáng.','den-ngoai-troi',950000.00,'http://localhost:8082/wp-content/uploads/2025/09/37.1.png','[\"Chu\\u1ea9n ch\\u1ed1ng n\\u01b0\\u1edbc: IP65\",\"V\\u1eadt li\\u1ec7u: Nh\\u00f4m \\u0111\\u00fac\",\"C\\u00f4ng su\\u1ea5t: 2x6W\",\"G\\u00f3c chi\\u1ebfu: L\\u00ean v\\u00e0 xu\\u1ed1ng\"]',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/37.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/38.1.png\"]',1,1,0,'2025-07-28 18:25:32','2025-09-30 05:53:48'),(6,'Đèn Thả Trang Trí CRYSTAL','den-tha-trang-tri-crystal','Đèn thả pha lê cao cấp cho phòng khách, phòng ăn sang trọng.','den-trang-tri',3500000.00,'http://localhost:8082/wp-content/uploads/2025/09/19.1.png','[\"Ch\\u1ea5t li\\u1ec7u: Pha l\\u00ea cao c\\u1ea5p\",\"K\\u00edch th\\u01b0\\u1edbc: \\u03a6600 x H800mm\",\"B\\u00f3ng \\u0111\\u00e8n: E14 x 8\",\"Phong c\\u00e1ch: Luxury modern\"]',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/19.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/19.3.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/19.4.png\"]',0,1,0,'2025-07-28 18:25:32','2025-09-30 05:53:48'),(7,'LED Dây RGB 5050 Pro','led-day-rgb-5050-pro','Đèn LED dây RGB đổi màu, điều khiển qua app smartphone.','den-led-day',450000.00,'http://localhost:8082/wp-content/uploads/2025/09/45.1.png','[\"Chip LED: 5050 RGB\",\"S\\u1ed1 b\\u00f3ng: 60 LED\\/m\",\"\\u0110i\\u1ec1u khi\\u1ec3n: Wifi\\/Bluetooth\",\"Ch\\u1ed1ng n\\u01b0\\u1edbc: IP65\"]',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/45.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/45.3.png\"]',0,1,0,'2025-07-28 18:25:32','2025-09-30 05:53:48'),(8,'Đèn Spotlight Âm Trần COB 12W','den-spotlight-am-tran-cob-12w','Đèn spotlight âm trần công nghệ COB hiện đại, ánh sáng tập trung, chỉ số hoàn màu cao CRI>90','den-am-tran',750000.00,'http://localhost:8082/wp-content/uploads/2025/01/12.1.jpg','CÃ´ng suáº¥t: 12W\nCÃ´ng nghá»‡: COB LED\nCRI > 90\nGÃ³c chiáº¿u: 24Â°',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,1,0,'2025-09-30 05:34:23','2025-09-30 05:55:20'),(9,'Đèn Cột Sân Vườn LED Hiện Đại','den-cot-san-vuon-led','Đèn cột sân vườn thiết kế hiện đại, chống nước IP65, phù hợp cho không gian ngoài trời','den-ngoai-troi',2800000.00,'http://localhost:8082/wp-content/uploads/2025/01/16.1.png','Chiá»u cao: 3.5m\nChá»‘ng nÆ°á»›c: IP65\nVáº­t liá»‡u: NhÃ´m Ä‘Ãºc\nCÃ´ng suáº¥t: 40W',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1,1,0,'2025-09-30 05:34:23','2025-09-30 05:55:20'),(10,'Đèn Đường LED COB 150W','den-duong-led-cob-150w','Đèn đường LED công suất cao 150W với công nghệ COB, tiết kiệm năng lượng, tuổi thọ cao','den-ngoai-troi',1800000.00,'http://localhost:8082/wp-content/uploads/2025/01/21.1.jpg','CÃ´ng suáº¥t: 150W\nCÃ´ng nghá»‡: COB LED\nHiá»‡u suáº¥t: >130lm/W\nChá»‘ng nÆ°á»›c: IP66',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1,1,0,'2025-09-30 05:34:23','2025-09-30 05:55:20'),(11,'Đèn Đường LED Module 200W','den-duong-led-module-200w','Đèn đường LED module công suất 200W, thiết kế module linh hoạt, dễ bảo trì','den-ngoai-troi',2200000.00,'http://localhost:8082/wp-content/uploads/2025/01/24.1.jpg','CÃ´ng suáº¥t: 200W\nThiáº¿t káº¿: Module\nHiá»‡u suáº¥t: >140lm/W\nChá»‘ng nÆ°á»›c: IP66',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1,1,0,'2025-09-30 05:34:23','2025-09-30 05:55:20'),(12,'Đèn Pha LED Stadium 500W','den-pha-led-stadium-500w','Đèn pha LED công suất siêu cao 500W cho sân vận động, công trình lớn','den-ngoai-troi',6500000.00,'http://localhost:8082/wp-content/uploads/2025/01/25.1.jpg','CÃ´ng suáº¥t: 500W\nLumen: 70,000lm\nGÃ³c chiáº¿u: 60Â°/90Â°/120Â°\nChá»‘ng nÆ°á»›c: IP67',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1,1,0,'2025-09-30 05:34:23','2025-09-30 05:55:20'),(13,'Đèn LED Âm Nước RGB Fountain','den-led-am-nuoc-rgb-fountain','Đèn LED âm nước RGB cho đài phun nước, hồ bơi, thiết kế chống thấm hoàn toàn','den-trang-tri',1200000.00,'http://localhost:8082/wp-content/uploads/2025/01/40.2.jpg','Chá»‘ng nÆ°á»›c: IP68\nÄiá»u khiá»ƒn: RGB/RGBW\nVáº­t liá»‡u: ThÃ©p khÃ´ng gá»‰ 316\nCÃ´ng suáº¥t: 12W',NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,1,0,'2025-09-30 05:34:23','2025-09-30 05:55:20');
/*!40000 ALTER TABLE `wp_virical_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_project_types`
--

DROP TABLE IF EXISTS `wp_virical_project_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_project_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_project_types`
--

LOCK TABLES `wp_virical_project_types` WRITE;
/*!40000 ALTER TABLE `wp_virical_project_types` DISABLE KEYS */;
INSERT INTO `wp_virical_project_types` VALUES (1,'Căn hộ','can-ho',NULL,10,1),(2,'Biệt thự','biet-thu',NULL,20,1),(3,'Villa','villa',NULL,30,1),(4,'Penthouse','penthouse',NULL,40,1),(5,'Văn phòng','van-phong',NULL,50,1),(6,'Showroom','showroom',NULL,60,1),(7,'Nhà hàng','nha-hang',NULL,70,1),(8,'Khách sạn','khach-san',NULL,80,1);
/*!40000 ALTER TABLE `wp_virical_project_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_projects`
--

DROP TABLE IF EXISTS `wp_virical_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` int DEFAULT NULL,
  `completion_year` year DEFAULT NULL,
  `design_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `view_count` int DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `project_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `testimonial_author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `testimonial_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `testimonial_avatar` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brochure_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_image` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gallery_images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_featured` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`slug`),
  KEY `idx_type` (`type`),
  KEY `idx_featured` (`is_featured`),
  KEY `idx_year` (`completion_year`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_projects`
--

LOCK TABLES `wp_virical_projects` WRITE;
/*!40000 ALTER TABLE `wp_virical_projects` DISABLE KEYS */;
INSERT INTO `wp_virical_projects` VALUES (1,'Smart City Apartment','smart-city-apartment','can-ho',100,2022,'Minimalist Studio','Vin Smart City, Hà Nội',NULL,NULL,NULL,NULL,0,'Thiết kế nội thất căn hộ phong cách tối giản hiện đại với gam màu trung tính, tối ưu công năng sử dụng.',NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost:8082/wp-content/uploads/2025/09/13.1.png',NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/13.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/14.1.png\"]','[\"Phong c\\u00e1ch thi\\u1ebft k\\u1ebf: Minimalist\",\"H\\u1ec7 th\\u1ed1ng chi\\u1ebfu s\\u00e1ng: Virical Smart Lighting\",\"T\\u00f4ng m\\u00e0u ch\\u1ee7 \\u0111\\u1ea1o: Tr\\u1eafng - X\\u00e1m - G\\u1ed7 s\\u00e1ng\"]',1,1,0,'2025-07-28 18:37:03','2025-09-30 00:44:32'),(2,'Matrix One Apartment','matrix-one-apartment','can-ho',150,2022,'L\'arota Design','Matrix One, Mễ Trì, Hà Nội',NULL,NULL,NULL,NULL,0,'Căn hộ cao cấp với thiết kế sang trọng, kết hợp hài hòa giữa ánh sáng tự nhiên và hệ thống chiếu sáng thông minh.',NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost:8082/wp-content/uploads/2025/09/15.1.png',NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/15.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/16.1.png\"]','[\"Di\\u1ec7n t\\u00edch: 150m\\u00b2\",\"S\\u1ed1 ph\\u00f2ng ng\\u1ee7: 3\",\"H\\u1ec7 th\\u1ed1ng \\u0111\\u00e8n: Ray nam ch\\u00e2m Virical\"]',0,1,0,'2025-07-28 18:37:03','2025-09-30 00:44:32'),(3,'Villa Nan An Khánh','villa-nan-an-khanh','villa',250,2022,'MORE HOME','An Khánh, Hà Nội',NULL,NULL,NULL,NULL,0,'Biệt thự sang trọng với hệ thống chiếu sáng ngoài trời ấn tượng, tạo điểm nhấn cho kiến trúc.',NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost:8082/wp-content/uploads/2025/09/17.1.png',NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/17.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/18.1.png\"]','[\"Phong c\\u00e1ch: Modern Luxury\",\"S\\u00e2n v\\u01b0\\u1eddn: 100m\\u00b2\",\"H\\u1ec7 th\\u1ed1ng chi\\u1ebfu s\\u00e1ng c\\u1ea3nh quan\"]',1,1,0,'2025-07-28 18:37:03','2025-09-30 00:44:32'),(4,'Midtown Phú Mỹ Hưng','midtown-phu-my-hung','can-ho',120,2022,'Maison Décor','Phú Mỹ Hưng, TP.HCM',NULL,NULL,NULL,NULL,0,'Căn hộ phong cách hiện đại với hệ thống chiếu sáng accent tạo điểm nhấn cho các tác phẩm nghệ thuật.',NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost:8082/wp-content/uploads/2025/09/20.1.png',NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/20.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/46.1.png\"]','[\"View s\\u00f4ng S\\u00e0i G\\u00f2n\",\"H\\u1ec7 th\\u1ed1ng Smart Home\",\"\\u0110\\u00e8n c\\u1ea3m bi\\u1ebfn th\\u00f4ng minh\"]',0,1,0,'2025-07-28 18:37:03','2025-09-30 00:44:32'),(5,'PenStudio House','penstudio-house','penthouse',100,2022,'1.6 Design','Quận 2, TP.HCM',NULL,NULL,NULL,NULL,0,'Penthouse với thiết kế độc đáo, tận dụng tối đa ánh sáng tự nhiên kết hợp chiếu sáng nhân tạo.',NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost:8082/wp-content/uploads/2025/09/47.1.png',NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/47.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/48.1.png\"]','[\"T\\u1ea7ng th\\u01b0\\u1ee3ng ri\\u00eang bi\\u1ec7t\",\"H\\u1ec7 th\\u1ed1ng chi\\u1ebfu s\\u00e1ng RGB\",\"\\u0110i\\u1ec1u khi\\u1ec3n qua app\"]',0,1,0,'2025-07-28 18:37:03','2025-09-30 00:44:32'),(6,'Villa GELEXIMCO','villa-geleximco','biet-thu',290,2022,'Zmili Design','Khu đô thị GELEXIMCO, Hà Nội',NULL,NULL,NULL,NULL,0,'Biệt thự sân vườn với hệ thống chiếu sáng landscape ấn tượng, tạo không gian sống xanh và nghệ thuật.',NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost:8082/wp-content/uploads/2025/09/50.1.png',NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/50.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/51.1.png\"]','[\"S\\u00e2n v\\u01b0\\u1eddn: 150m\\u00b2\",\"H\\u1ed3 b\\u01a1i ri\\u00eang\",\"Chi\\u1ebfu s\\u00e1ng c\\u1ea3nh quan t\\u1ef1 \\u0111\\u1ed9ng\"]',1,1,0,'2025-07-28 18:37:03','2025-09-30 00:44:32'),(7,'The Coffee House','the-coffee-house','nha-hang',200,2023,'Interior Plus','Quận 1, TP.HCM',NULL,NULL,NULL,NULL,0,'Quán café với concept industrial, sử dụng hệ thống đèn ray linh hoạt tạo không gian ấm cúng.',NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost:8082/wp-content/uploads/2025/09/52.1.png',NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/52.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/52.3.png\"]','[\"Phong c\\u00e1ch: Industrial\",\"\\u0110\\u00e8n ray nam ch\\u00e2m Virical\",\"\\u0110i\\u1ec1u ch\\u1ec9nh \\u00e1nh s\\u00e1ng theo th\\u1eddi gian\"]',0,1,0,'2025-07-28 18:37:03','2025-09-30 00:44:32'),(8,'Luxury Hotel Đà Nẵng','luxury-hotel-da-nang','khach-san',5000,2023,'HAD Architects','Bãi biển Mỹ Khê, Đà Nẵng',NULL,NULL,NULL,NULL,0,'Khách sạn 5 sao với hệ thống chiếu sáng sang trọng, tạo trải nghiệm đẳng cấp cho du khách.',NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost:8082/wp-content/uploads/2025/09/8.1.png',NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/8.2.png\",\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/9.1.png\"]','[\"200 ph\\u00f2ng ngh\\u1ec9\",\"H\\u1ec7 th\\u1ed1ng chi\\u1ebfu s\\u00e1ng DALI\",\"Ti\\u1ebft ki\\u1ec7m 60% n\\u0103ng l\\u01b0\\u1ee3ng\"]',0,1,0,'2025-07-28 18:37:03','2025-09-30 00:44:32'),(9,'Tech Office Building','tech-office-building','van-phong',1500,2023,'Modern Space','Quận 7, TP.HCM',NULL,NULL,NULL,NULL,0,'Văn phòng công nghệ với hệ thống chiếu sáng thông minh, tối ưu cho môi trường làm việc sáng tạo.',NULL,NULL,NULL,NULL,NULL,NULL,'http://localhost:8082/wp-content/uploads/2025/09/bo-tri-den-van-phong-_upscayl_5x_upscayl-standard-4x.png',NULL,'[\"http:\\/\\/localhost:8082\\/wp-content\\/uploads\\/2025\\/09\\/moc-den-nha-xuong_upscayl_5x_upscayl-standard-4x.png\"]','[\"Chi\\u1ebfu s\\u00e1ng tunable white\",\"C\\u1ea3m bi\\u1ebfn chuy\\u1ec3n \\u0111\\u1ed9ng\",\"T\\u00edch h\\u1ee3p h\\u1ec7 th\\u1ed1ng BMS\"]',0,1,0,'2025-07-28 18:37:03','2025-09-30 00:44:32');
/*!40000 ALTER TABLE `wp_virical_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_virical_routing_rules`
--

DROP TABLE IF EXISTS `wp_virical_routing_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wp_virical_routing_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pattern` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `rewrite` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `redirect_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `rule_type` enum('rewrite','redirect','custom') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT 'rewrite',
  `priority` int DEFAULT '10',
  `is_active` tinyint(1) DEFAULT '1',
  `conditions` json DEFAULT NULL,
  `meta_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rule_name` (`rule_name`),
  KEY `idx_active` (`is_active`),
  KEY `idx_priority` (`priority`),
  KEY `idx_type` (`rule_type`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_virical_routing_rules`
--

LOCK TABLES `wp_virical_routing_rules` WRITE;
/*!40000 ALTER TABLE `wp_virical_routing_rules` DISABLE KEYS */;
INSERT INTO `wp_virical_routing_rules` VALUES (1,'single_product','^san-pham/([^/]+)/?$','index.php?product=$matches[1]',NULL,'rewrite',1,1,NULL,'{\"query_var\": \"product\", \"description\": \"Single product page URL\"}','2025-09-09 20:03:16','2025-09-09 20:03:16'),(2,'single_project','^cong-trinh/([^/]+)/?$','index.php?project=$matches[1]',NULL,'rewrite',2,1,NULL,'{\"query_var\": \"project\", \"description\": \"Single project page URL\"}','2025-09-09 20:03:16','2025-09-09 20:03:16'),(3,'product_category','^product-category/([^/]+)/?$','index.php?category=$matches[1]',NULL,'rewrite',3,1,NULL,'{\"query_var\": \"category\", \"description\": \"Product category page URL\"}','2025-09-09 20:03:16','2025-09-09 20:03:16'),(4,'products_page','^san-pham/?$','index.php?pagename=san-pham',NULL,'rewrite',4,1,NULL,'{\"description\": \"Products archive page\"}','2025-09-09 20:03:16','2025-09-09 20:03:16'),(5,'projects_page','^cong-trinh/?$','index.php?pagename=cong-trinh',NULL,'rewrite',5,1,NULL,'{\"description\": \"Projects archive page\"}','2025-09-09 20:03:16','2025-09-09 20:03:16'),(6,'old_products_redirect','^products/?$','/san-pham/','301','redirect',10,1,NULL,'{\"description\": \"Redirect old products URL to new URL\"}','2025-09-09 20:03:16','2025-09-09 20:03:16'),(7,'old_projects_redirect','^projects/?$','/cong-trinh/','301','redirect',11,1,NULL,'{\"description\": \"Redirect old projects URL to new URL\"}','2025-09-09 20:03:16','2025-09-09 20:03:16');
/*!40000 ALTER TABLE `wp_virical_routing_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'aura_db'
--

--
-- Dumping routines for database 'aura_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-30 14:39:29
