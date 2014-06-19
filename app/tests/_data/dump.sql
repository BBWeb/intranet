# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Värd: 127.0.0.1 (MySQL 5.5.37-0ubuntu0.14.04.1)
# Databas: homestead
# Genereringstid: 2014-06-19 14:17:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Tabelldump migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_01_12_164147_create_users_table',1),
	('2014_01_12_191729_add_apikey_to_user_table',1),
	('2014_01_16_132455_create_tasks_table',1),
	('2014_01_31_162100_add_reported_date_to_tasks_table',1),
	('2014_01_31_170331_add_name_to_users_table',1),
	('2014_03_16_141059_create_projects_table',1),
	('2014_03_16_152116_add_ref_to_projects_for_tasks_table',1),
	('2014_03_20_193908_add_adjusted_time_to_tasks',1),
	('2014_03_26_170441_create_timereport_table',1),
	('2014_04_04_133619_add_payed_attr_to_subreports',1),
	('2014_04_07_135130_add_softdeletes_to_subreport',1),
	('2014_06_04_173851_add_remember_token_to_users_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Tabelldump projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;

INSERT INTO `projects` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(5021418151028,'TestA','2014-06-17 16:17:46','2014-06-17 16:17:46'),
	(5021418151034,'TestB','2014-06-17 16:17:47','2014-06-17 16:17:47'),
	(9952541257649,'TestC','2014-06-17 16:17:49','2014-06-17 16:17:49'),
	(9952541257650,'','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;


# Tabelldump subreports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subreports`;

CREATE TABLE `subreports` (
  `task_id` int(11) NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL DEFAULT '0',
  `reported_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payed` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subreports_task_id_index` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `subreports` WRITE;
/*!40000 ALTER TABLE `subreports` DISABLE KEYS */;

INSERT INTO `subreports` (`task_id`, `id`, `time`, `reported_date`, `created_at`, `updated_at`, `payed`, `deleted_at`)
VALUES
	(4,1,1,'2014-06-18','2014-06-18 10:42:48','2014-06-18 10:42:48',0,NULL),
	(4,2,30,'2014-06-19','2014-06-19 14:14:12','2014-06-19 14:14:12',0,NULL);

/*!40000 ALTER TABLE `subreports` ENABLE KEYS */;
UNLOCK TABLES;


# Tabelldump tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `asana_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `task` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time_worked` int(11) NOT NULL DEFAULT '0',
  `status` enum('reported','invoiced','notreported') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'notreported',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reported_date` date NOT NULL,
  `project_id` bigint(20) NOT NULL,
  `adjusted_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;

INSERT INTO `tasks` (`id`, `user_id`, `asana_id`, `project`, `task`, `time_worked`, `status`, `created_at`, `updated_at`, `reported_date`, `project_id`, `adjusted_time`)
VALUES
	(1,1,'7696166719045','','Gör så att vi kan köra cap deploy lokalt på servern',0,'notreported','2014-06-17 16:17:46','2014-06-17 16:17:46','0000-00-00',5021418151028,0),
	(2,1,'8600732740424','','Bugg: Case-sensitive sortering av personal och medlemmar i arbetsgrupp',0,'notreported','2014-06-18 16:17:47','2014-06-17 16:17:47','0000-00-00',5021418151034,0),
	(3,1,'9482645773835','','Tillfälligt ändra längd på baffel',0,'notreported','2014-06-17 16:17:48','2014-06-17 16:17:48','0000-00-00',5021418151034,0),
	(4,1,'10092773593336','','Kundrapporteringsvy [4h]',0,'notreported','2014-06-17 16:17:49','2014-06-17 16:17:49','0000-00-00',9952541257649,0);

/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;


# Tabelldump users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `admin`, `created_at`, `updated_at`, `api_key`, `name`, `remember_token`)
VALUES
	(1,'niklas@bbweb.se','$2y$10$Dt0emBDP3u.eCVREnn3iXuni9WCZMGgQFKX.aGTazE/b1vjMuUuxa',1,'2014-06-17 15:36:44','2014-06-17 16:15:42','1oHa8yxA.GQ48H9ins9Q6edNGopwo2kJ','Niklas Andréasson',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
