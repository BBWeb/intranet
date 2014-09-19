-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.14.04.1

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
-- Table structure for table `asana_tasks`
--

DROP TABLE IF EXISTS `asana_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asana_tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completion_date` date NOT NULL,
  `adjusted_time` int(11) NOT NULL DEFAULT '0',
  `project_id` bigint(20) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asana_tasks`
--

LOCK TABLES `asana_tasks` WRITE;
/*!40000 ALTER TABLE `asana_tasks` DISABLE KEYS */;
INSERT INTO `asana_tasks` VALUES (1,'Asana task 1',0,'0000-00-00',0,1,1,'2014-09-19 20:16:18','2014-09-19 20:16:18'),(2,'Asana task 2',0,'0000-00-00',0,1,1,'2014-09-19 20:16:18','2014-09-19 20:16:18');
/*!40000 ALTER TABLE `asana_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_01_12_164147_create_users_table',1),('2014_01_12_191729_add_apikey_to_user_table',1),('2014_01_16_132455_create_tasks_table',1),('2014_01_31_170331_add_name_to_users_table',1),('2014_03_16_141059_create_projects_table',1),('2014_03_26_170441_create_timereport_table',1),('2014_04_04_133619_add_payed_attr_to_subreports',1),('2014_04_07_135130_add_softdeletes_to_subreport',1),('2014_06_04_173851_add_remember_token_to_users_table',1),('2014_06_26_131131_create_modified_date_tasks_table',1),('2014_06_27_132600_create_modified_name_tasks_table',1),('2014_07_23_125339_create_staff_personal_data_table',1),('2014_07_24_113140_create_staff_company_data_table',1),('2014_07_24_121505_create_staff_payment_data_table',1),('2014_08_12_135611_create_private_tasks_table',1),('2014_08_17_150424_add_name_to_subreports_table',1),('2014_08_29_122501_create_asana_tasks_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modified_date_tasks`
--

DROP TABLE IF EXISTS `modified_date_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modified_date_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asana_task_id` int(11) NOT NULL,
  `modified_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `modified_date_tasks_asana_task_id_index` (`asana_task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modified_date_tasks`
--

LOCK TABLES `modified_date_tasks` WRITE;
/*!40000 ALTER TABLE `modified_date_tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `modified_date_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modified_name_tasks`
--

DROP TABLE IF EXISTS `modified_name_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modified_name_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asana_task_id` int(11) NOT NULL,
  `modified_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `modified_name_tasks_asana_task_id_index` (`asana_task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modified_name_tasks`
--

LOCK TABLES `modified_name_tasks` WRITE;
/*!40000 ALTER TABLE `modified_name_tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `modified_name_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `private_tasks`
--

DROP TABLE IF EXISTS `private_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `private_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_worked` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `private_tasks_user_id_foreign` (`user_id`),
  CONSTRAINT `private_tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `private_tasks`
--

LOCK TABLES `private_tasks` WRITE;
/*!40000 ALTER TABLE `private_tasks` DISABLE KEYS */;
INSERT INTO `private_tasks` VALUES (1,1,'Testing',10,'2014-09-19 20:16:18','2014-09-19 20:16:18'),(2,1,'Whatyawant',20,'2014-09-19 20:16:18','2014-09-19 20:16:18');
/*!40000 ALTER TABLE `private_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Test project','2014-09-19 20:16:18','2014-09-19 20:16:18'),(2,'Second test project','2014-09-19 20:16:18','2014-09-19 20:16:18');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_company_data`
--

DROP TABLE IF EXISTS `staff_company_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_company_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `employment_nr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `clearing_nr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_nr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `staff_company_data_user_id_foreign` (`user_id`),
  CONSTRAINT `staff_company_data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_company_data`
--

LOCK TABLES `staff_company_data` WRITE;
/*!40000 ALTER TABLE `staff_company_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_company_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_payment_data`
--

DROP TABLE IF EXISTS `staff_payment_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_payment_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `income_tax` decimal(5,2) NOT NULL DEFAULT '30.00',
  `employer_fee` decimal(5,2) NOT NULL DEFAULT '31.42',
  `hourly_salary` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `staff_payment_data_user_id_foreign` (`user_id`),
  CONSTRAINT `staff_payment_data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_payment_data`
--

LOCK TABLES `staff_payment_data` WRITE;
/*!40000 ALTER TABLE `staff_payment_data` DISABLE KEYS */;
INSERT INTO `staff_payment_data` VALUES (1,1,30.00,31.42,150,'2014-04-15','2014-09-19 20:16:18','2014-09-19 20:16:18'),(2,1,30.00,31.42,200,'2014-09-19','2014-09-19 20:16:18','2014-09-19 20:16:18'),(3,1,30.00,31.42,250,'2016-04-16','2014-09-19 20:16:18','2014-09-19 20:16:18');
/*!40000 ALTER TABLE `staff_payment_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_personal_data`
--

DROP TABLE IF EXISTS `staff_personal_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_personal_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ssn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `staff_personal_data_user_id_foreign` (`user_id`),
  CONSTRAINT `staff_personal_data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_personal_data`
--

LOCK TABLES `staff_personal_data` WRITE;
/*!40000 ALTER TABLE `staff_personal_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_personal_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subreports`
--

DROP TABLE IF EXISTS `subreports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subreports` (
  `task_id` int(11) NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL DEFAULT '0',
  `reported_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payed` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subreports_task_id_index` (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subreports`
--

LOCK TABLES `subreports` WRITE;
/*!40000 ALTER TABLE `subreports` DISABLE KEYS */;
INSERT INTO `subreports` VALUES (1,1,31,'2014-06-11','2014-09-19 20:16:18','2014-09-19 20:16:18',0,NULL,'Cool name'),(1,2,60,'2014-06-05','2014-09-19 20:16:18','2014-09-19 20:16:18',1,NULL,'Programmed'),(1,3,10,'2014-07-14','2014-09-19 20:16:18','2014-09-19 20:16:18',0,NULL,'Stuff');
/*!40000 ALTER TABLE `subreports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `asana_task_id` bigint(20) NOT NULL,
  `status` enum('reported','invoiced','notreported') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'notreported',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,1,1,'notreported','2014-09-19 20:16:18','2014-09-19 20:16:18');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `api_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'niklas@bbweb.se','$2y$10$eBfHqew6YjB9sIV.rx5k3eM392fGTvjDOGn8DmavKn5Lmy5jInC9K',1,'2014-09-19 20:16:18','2014-09-19 20:16:18','123','Niklas Andréasson',NULL),(2,'user@bbweb.se','$2y$10$9BmeuLUWp44JJ7Fh4kyodu7S7cXF8.2qj2S7eg0JNdfRGN7BPdJuy',0,'2014-09-19 20:16:18','2014-09-19 20:16:18','','User Doe',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-19 10:17:05
