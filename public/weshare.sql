-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: wordpressdb.ccdf8bmzhl5w.us-west-2.rds.amazonaws.com    Database: weshare
-- ------------------------------------------------------
-- Server version	5.6.35-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment_activities`
--

DROP TABLE IF EXISTS `comment_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment_activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_profile_id` int(10) unsigned NOT NULL,
  `comment_id` int(10) unsigned NOT NULL,
  `type` enum('like','dislike') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_activities_user_profile_id_foreign` (`user_profile_id`),
  KEY `comment_activities_comment_id_foreign` (`comment_id`),
  CONSTRAINT `comment_activities_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_activities_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_activities`
--

LOCK TABLES `comment_activities` WRITE;
/*!40000 ALTER TABLE `comment_activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_profile_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_profile_id_foreign` (`user_profile_id`),
  KEY `comments_post_id_foreign` (`post_id`),
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,3,4,'Guj',NULL,'2018-04-25 11:59:35','2018-04-25 11:59:35'),(2,3,4,'Hi',NULL,'2018-04-25 12:00:02','2018-04-25 12:00:02'),(3,2,12,'hey',NULL,'2018-04-25 12:02:00','2018-04-25 12:02:00'),(4,2,13,'real',NULL,'2018-04-27 05:02:54','2018-04-27 05:02:54'),(5,3,2,'Hi',NULL,'2018-05-09 03:05:30','2018-05-09 03:05:30');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `followables`
--

DROP TABLE IF EXISTS `followables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `followables` (
  `user_profile_id` int(10) unsigned NOT NULL,
  `followable_id` int(10) unsigned NOT NULL,
  `followable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'follow' COMMENT 'folllow/like/subscribe/favorite/',
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `followables_user_profile_id_foreign` (`user_profile_id`),
  KEY `followables_followable_type_index` (`followable_type`),
  CONSTRAINT `followables_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followables`
--

LOCK TABLES `followables` WRITE;
/*!40000 ALTER TABLE `followables` DISABLE KEYS */;
INSERT INTO `followables` VALUES (1,2,'App\\Models\\UserProfile','follow','2018-04-21 04:23:24'),(4,2,'App\\Models\\UserProfile','follow','2018-04-23 05:55:38'),(4,1,'App\\Models\\UserProfile','follow','2018-04-23 05:55:48'),(3,2,'App\\Models\\UserProfile','follow','2018-04-25 12:08:48'),(2,1,'App\\Models\\UserProfile','follow','2018-04-27 05:02:38'),(3,1,'App\\Models\\UserProfile','follow','2018-05-09 03:00:18'),(1,1,'App\\Models\\UserProfile','follow','2018-05-09 06:23:56'),(1,3,'App\\Models\\UserProfile','follow','2018-05-09 06:28:47');
/*!40000 ALTER TABLE `followables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2017_04_10_000000_create_users_table',1),(2,'2017_04_10_000001_create_password_resets_table',1),(3,'2017_04_10_000003_create_roles_table',1),(4,'2017_04_10_000004_create_users_roles_table',1),(5,'2017_11_26_121719_create_user_profiles_table',1),(6,'2017_11_26_132953_create_posts_table',1),(7,'2017_11_26_134901_create_comments_table',1),(8,'2017_11_26_134959_create_post_activities_table',1),(9,'2017_11_26_135007_create_comment_activities_table',1),(10,'2018_01_20_063453_create_save_posts',1),(11,'2018_01_25_063304_create_laravel_follow_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_activities`
--

DROP TABLE IF EXISTS `post_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_profile_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `type` enum('comment','like','dislike') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_activities_user_profile_id_foreign` (`user_profile_id`),
  KEY `post_activities_post_id_foreign` (`post_id`),
  CONSTRAINT `post_activities_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_activities_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_activities`
--

LOCK TABLES `post_activities` WRITE;
/*!40000 ALTER TABLE `post_activities` DISABLE KEYS */;
INSERT INTO `post_activities` VALUES (1,2,2,'like',NULL,'2018-04-17 13:02:28','2018-04-17 13:02:28'),(2,3,4,'comment',NULL,'2018-04-25 11:59:35','2018-04-25 11:59:35'),(3,3,4,'comment',NULL,'2018-04-25 12:00:02','2018-04-25 12:00:02'),(4,3,4,'like',NULL,'2018-04-25 12:01:22','2018-04-25 12:01:22'),(5,2,12,'comment',NULL,'2018-04-25 12:02:00','2018-04-25 12:02:00'),(6,2,13,'like',NULL,'2018-04-27 05:02:47','2018-04-27 05:02:47'),(7,2,13,'comment',NULL,'2018-04-27 05:02:54','2018-04-27 05:02:54'),(8,3,2,'comment',NULL,'2018-05-09 03:05:30','2018-05-09 03:05:30');
/*!40000 ALTER TABLE `post_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_profile_id` int(10) unsigned NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('text','image','video','audio','gif') COLLATE utf8mb4_unicode_ci NOT NULL,
  `share_count` int(11) NOT NULL DEFAULT '0',
  `video_thumbnail_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_location_on_video` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_story` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_profile_id_foreign` (`user_profile_id`),
  CONSTRAINT `posts_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,2,'hey','hi',NULL,'text',0,NULL,NULL,0,NULL,'2018-04-17 08:00:36','2018-04-17 08:00:36'),(2,2,'hi',NULL,'https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180417_133558.jpg?alt=media&token=095b069a-3ed4-4305-b40c-6cbfe17a4554','image',0,NULL,NULL,0,NULL,'2018-04-17 08:06:04','2018-04-17 08:06:04'),(3,2,'hi','hey',NULL,'text',0,NULL,NULL,0,NULL,'2018-04-17 13:03:23','2018-04-17 13:03:23'),(4,2,'random',NULL,'https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180417_183401.jpg?alt=media&token=acf47ed6-1089-44e5-adf7-b048c2f091ac','image',0,NULL,NULL,0,NULL,'2018-04-17 13:04:06','2018-04-17 13:04:06'),(5,2,'store',NULL,'https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180420_115931.jpg?alt=media&token=a93c7915-6589-431e-bb8e-16f2d1a4c7dc','image',0,NULL,NULL,1,NULL,'2018-04-20 06:29:36','2018-04-20 06:29:36'),(6,1,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180421_101920.jpg?alt=media&token=87175dad-9032-4f0c-9aeb-6b711fa68e82','image',0,NULL,NULL,1,NULL,'2018-04-21 04:49:25','2018-04-21 04:49:25'),(7,1,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180421_102630.jpg?alt=media&token=f168b6e1-114e-4e70-8556-8f0a40999a4d','image',0,NULL,NULL,1,NULL,'2018-04-21 04:56:35','2018-04-21 04:56:35'),(8,2,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180421_103332.jpg?alt=media&token=5c915b10-dab1-4a29-a5a3-c7015d1cbc1b','image',0,NULL,NULL,1,NULL,'2018-04-21 05:03:38','2018-04-21 05:03:38'),(9,1,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180421_103551.jpg?alt=media&token=6f96d37a-bb8a-4f00-9942-c63af8642e1e','image',0,NULL,NULL,1,NULL,'2018-04-21 05:05:57','2018-04-21 05:05:57'),(10,3,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180421_132754.jpg?alt=media&token=3c238c57-51a0-4213-9e61-ef8b1ab574b5','image',0,NULL,NULL,1,NULL,'2018-04-21 07:57:59','2018-04-21 07:57:59'),(11,2,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180423_120721.jpg?alt=media&token=d1b1e798-4515-443d-8527-ad4205998dcb','image',0,NULL,NULL,1,NULL,'2018-04-23 06:37:27','2018-04-23 06:37:27'),(12,3,'Yu','Hfh',NULL,'text',0,NULL,NULL,0,NULL,'2018-04-25 12:01:43','2018-04-25 12:01:43'),(13,1,'hmm','nice',NULL,'text',0,NULL,NULL,0,NULL,'2018-04-27 05:02:17','2018-04-27 05:02:17'),(14,1,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180506_091055.jpg?alt=media&token=f41bbf07-e0f4-4c80-adec-85cc0ffbc766','image',0,NULL,NULL,1,NULL,'2018-05-06 03:41:01','2018-05-06 03:41:01'),(15,1,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180506_091747.jpg?alt=media&token=820584d4-8d6f-4c03-a689-0cd48ed8cfa0','image',0,NULL,NULL,1,NULL,'2018-05-06 03:47:53','2018-05-06 03:47:53'),(16,3,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180509_084240.jpg?alt=media&token=b7a92197-d0d7-4e60-97f6-562a1d0a6c23','image',0,NULL,NULL,1,NULL,'2018-05-09 03:12:47','2018-05-09 03:12:47'),(17,1,'StoryTitle','StoryText','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FIMG_20180509_115240.jpg?alt=media&token=6f76ba86-5fb4-4bcd-bed8-942fc7ec6b4a','image',0,NULL,NULL,1,NULL,'2018-05-09 06:22:44','2018-05-09 06:22:44');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrator',0),(2,'authenticated',0);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `save_posts`
--

DROP TABLE IF EXISTS `save_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `save_posts` (
  `user_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `save_posts_user_id_post_id_unique` (`user_id`,`post_id`),
  KEY `save_foreign_post` (`post_id`),
  CONSTRAINT `save_foreign_post` FOREIGN KEY (`post_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `save_foreign_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `save_posts`
--

LOCK TABLES `save_posts` WRITE;
/*!40000 ALTER TABLE `save_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `save_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('m','f') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fcm_registration_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_on_like` tinyint(1) NOT NULL DEFAULT '1',
  `notification_on_dislike` tinyint(1) NOT NULL DEFAULT '1',
  `notification_on_comment` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES (1,'6UtfHpnx3POLTKDJ7PKeRILyWMF3','Seema Sharma','mrs.seema.sharma.mrs@gmail.com','https://lh5.googleusercontent.com/-Y0-VNrLOzx8/AAAAAAAAAAI/AAAAAAAAAAA/ACLGyWD-4VqCGH3qOJBJOitPE7-kVmSsiQ/s96-c/photo.jpg','m','eQzLh5AVcKA:APA91bF_ZNV1huYyoA-4DNgBArqytW8rlilDVzhmBCei1MgPYthPd60Y2UaBS8k6TvOVjzhC6QCQCdo4h0OFEmrAN_TaH6scFIfVWiMA4KDmNYpingRAv1BKOyaw6HqSG6vntylftzWy',1,1,1,0,'2018-04-17 05:10:14','2018-04-30 06:26:21'),(2,'Xsowpc4kotPyIJGY6fRDorM5w7f1','Aman Sharma','dimpiisback@gmail.com','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FdpXsowpc4kotPyIJGY6fRDorM5w7f1?alt=media&token=3340401a-9b4b-4d60-b6dd-07d79eadff50','m','ctUbhDc8oOw:APA91bH25kYbiYLyQjjlswSIzM6E3he5mXNvqrWUQvd2Plkiqag5JfLV1_2lFKYnoJVvgQbkgGZyaevaxQZu55huJ-b-QYkHKwrSvvzGkqCyLd0A0eNzamzP5cKamcSC4_yS5EnWcs0h',1,1,1,0,'2018-04-17 08:00:05','2018-04-21 04:32:16'),(3,'hxzReGVnT7cv91U1ANX7byMMNYN2','Prashant Guptaa','prashant4630@gmail.com','https://firebasestorage.googleapis.com/v0/b/weshare-b0546.appspot.com/o/images%2FdphxzReGVnT7cv91U1ANX7byMMNYN2?alt=media&token=4b244cfe-96ab-48c0-8678-0b6ca78423d7','m','dzBiYXP_H88:APA91bFZ14kytkyPG5O10brArMVOC-BD67x_hH6FBBJv0MWsHVdUixjAwHrxQDW_UEETrakaNjv0yBdMegj2heocrhqT6b6u1A7US4sG3vW6uz4OXKHX0NO4H7ypmYpDSe9BAtxWVsU8',1,1,1,0,'2018-04-21 07:56:38','2018-05-09 03:09:17'),(4,'we54fskh7aT7hndNJ2X0aLxSGxu2','Shruti Sharma','malivefrm1995@gmail.com','https://graph.facebook.com/1679057828798773/picture','m','e0QDjUB0NpA:APA91bHe73zfuFUAkUnEGr2toSlqqVsYKGNPCYGnUww7wzRVtus9ALCZP-8KlYCAPKySglT_8vGYI5WEic1A8cDo1iADwa8bQwjrrlBrgokDODMHSAcc0tkncrWdjyGxE6rv9EO2hfBW',1,1,1,0,'2018-04-23 05:54:49','2018-04-23 05:54:49');
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `confirmation_code` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@example.com','$2y$10$upLWCzcy4b8AkpJaqrknX.5sgh.jiyLdXYbpAXZ/yIW1qUBDbZdti',1,'f04a92cb-3248-44b4-ac0e-37770b3610cc',1,NULL,'2018-04-01 20:50:38','2018-04-01 20:50:38',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `users_roles_user_id_role_id_unique` (`user_id`,`role_id`),
  KEY `foreign_role` (`role_id`),
  CONSTRAINT `foreign_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `foreign_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_roles`
--

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` VALUES (1,1),(1,2);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-09 12:33:56
