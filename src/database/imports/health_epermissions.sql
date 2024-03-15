# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.8.3-MariaDB-1:10.8.3+maria~jammy)
# Database: health_e
# Generation Time: 2023-07-26 20:11:57 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;

INSERT INTO `permissions` (`id`, `permission_name`, `slug`, `created_at`, `updated_at`)
VALUES
	(1,'View Devices Menu','view-devices-menu','2021-03-30 00:32:27','2021-03-30 00:32:27'),
	(2,'View All Pharmacists','view-all-pharmacists','2021-03-30 00:32:27','2021-03-30 00:32:27'),
	(3,'View All Nurses','view-all-nurses','2021-03-30 00:32:27','2021-03-30 00:32:27'),
	(4,'See Users Menu','see-users-menu',NULL,NULL),
	(5,'Add Employee','add-employee',NULL,NULL),
	(6,'Edit User','edit-user',NULL,NULL),
	(7,'See Manage Data Menu','see-manage-data-menu',NULL,NULL),
	(8,'Update Device Stock','update-device-stock',NULL,NULL),
	(9,'View All Users','view-all-users',NULL,NULL),
	(10,'View All Patients','view-all-patients',NULL,NULL),
	(11,'See Permissions Menu','see-permissions-menu',NULL,NULL),
	(12,'View Permissions','view-permissions',NULL,NULL),
	(13,'Add Permission','add-permission',NULL,NULL),
	(14,'See Patient Address Details','see-patient-address-details','2021-03-31 03:16:52','2021-03-31 03:16:52'),
	(15,'Edit Permission','edit-permission','2021-03-31 03:17:47','2021-03-31 03:17:47'),
	(16,'View All Physicians','view-all-physicians','2021-03-31 03:21:23','2021-03-31 03:21:23'),
	(17,'Edit User Profile','edit-user-profile','2021-03-31 03:21:35','2021-03-31 03:21:35'),
	(18,'Add A Device','add-a-device','2021-03-31 03:21:48','2021-03-31 03:21:48'),
	(19,'View Devices','view-devices','2021-03-31 03:21:54','2021-03-31 03:21:54'),
	(20,'Delete A Device','delete-a-device','2021-03-31 03:22:10','2021-03-31 03:22:10'),
	(21,'View Reports','view-reports','2021-03-31 03:22:17','2021-03-31 03:22:17'),
	(22,'Add Device To Patient','add-device-to-patient','2021-03-31 03:22:23','2021-03-31 03:22:23'),
	(23,'View Illnesses','view-illnesses','2021-03-31 03:22:29','2021-03-31 03:22:29'),
	(24,'Assign Permission To Role','assign-permission-to-role','2021-04-08 15:41:15','2021-04-08 15:41:15'),
	(25,'See Roles Menu','see-roles-menu','2021-04-08 15:41:34','2021-04-08 15:41:34'),
	(26,'View Roles','view-roles','2021-04-08 15:41:50','2021-04-08 15:41:50'),
	(27,'Add Role','add-role','2021-04-08 15:41:56','2021-04-08 15:41:56'),
	(28,'Edit Role','edit-role','2021-04-08 15:42:03','2021-04-08 15:42:03'),
	(29,'See Dashboard','see-dashboard','2021-04-12 20:36:42','2021-04-12 20:36:42'),
	(30,'Add Nurse','add-nurse','2021-04-20 20:04:16','2021-04-20 20:04:16'),
	(31,'Add Physician','add-physician','2021-04-20 21:16:22','2021-04-20 21:16:22'),
	(32,'Add Pharmacist','add-pharmacist','2021-04-29 21:33:16','2021-04-29 21:33:16'),
	(33,'Add Patient','add-patient','2021-04-29 21:34:09','2021-04-29 21:34:09'),
	(34,'Add Next Of Kin','add-next-of-kin','2021-04-29 21:35:33','2021-04-29 21:35:33'),
	(35,'Add Next Of Kin To Patient','add-next-of-kin-to-patient','2021-04-29 21:37:16','2021-04-29 21:37:16'),
	(36,'View A Patients Stats','view-a-patients-stats','2021-04-29 21:37:36','2021-04-29 21:37:36'),
	(37,'Edit Pharmacists Profile','edit-pharmacists-profile','2021-05-04 19:02:53','2021-05-04 19:02:53'),
	(38,'Edit Physicians Profile','edit-physicians-profile','2021-05-04 19:03:03','2021-05-04 19:03:03'),
	(39,'Edit Patients Profile','edit-patients-profile','2021-05-04 19:03:13','2021-05-04 19:03:13'),
	(40,'See Reports Menu','see-reports-menu','2021-05-06 00:12:21','2021-05-06 00:12:21'),
	(41,'Edit Next Of Kin Profile','edit-next-of-kin-profile','2021-05-19 16:33:33','2021-05-19 16:33:33'),
	(42,'Reset A Device','reset-a-device','2021-05-19 16:33:41','2021-05-19 16:33:41'),
	(43,'Edit Illness','edit-illness','2021-05-19 16:33:48','2021-05-19 16:33:48'),
	(44,'Edit Nurses Profile','edit-nurses-profile','2021-05-19 17:22:03','2021-05-19 17:22:03'),
	(45,'Change User Password','change-user-password','2021-05-26 19:06:45','2021-05-26 19:06:45'),
	(46,'Add Illness','add-illness','2021-05-26 19:57:09','2021-05-26 19:57:09'),
	(47,'View Patients Address Details','view-patients-address-details','2021-05-26 19:57:26','2021-05-26 19:57:26'),
	(48,'View Assigned Devices','view-assigned-devices',NULL,NULL),
	(49,'Process Application','process-application',NULL,NULL),
	(50,'See Processed Applications By Year','see-processed-applications-by-year',NULL,NULL);

/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
