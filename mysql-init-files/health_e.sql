# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.8.3-MariaDB-1:10.8.3+maria~jammy)
# Database: health_e
# Generation Time: 2023-09-17 03:29:45 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table addressdetails
# ------------------------------------------------------------

DROP TABLE IF EXISTS `addressdetails`;

CREATE TABLE `addressdetails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `address_line_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `addressdetails__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table assigneddevices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `assigneddevices`;

CREATE TABLE `assigneddevices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_unique_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_user_id` bigint(20) unsigned NOT NULL,
  `assigned_by_user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assigneddevices__uid_unique` (`_uid`),
  UNIQUE KEY `assigneddevices_device_unique_id_unique` (`device_unique_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `assigneddevices` WRITE;
/*!40000 ALTER TABLE `assigneddevices` DISABLE KEYS */;

INSERT INTO `assigneddevices` (`id`, `_uid`, `device_unique_id`, `patient_user_id`, `assigned_by_user_id`, `created_at`, `updated_at`)
VALUES
	(1,'0f8a782c-913c-41ac-bb9d-c44985cc225d','866901061284651',101,101,'2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `assigneddevices` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table bgreadings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bgreadings`;

CREATE TABLE `bgreadings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `glucose` int(11) NOT NULL,
  `readingPeriod` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bgreadings__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

# random comment here to mark a change

# Dump of table bpreadings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bpreadings`;

CREATE TABLE `bpreadings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `systolic` int(11) NOT NULL,
  `diastolic` int(11) NOT NULL,
  `pulse` int(11) NOT NULL,
  `arrhythmia` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bpreadings__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table contactclasses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contactclasses`;

CREATE TABLE `contactclasses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contactclasses__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contactclasses` WRITE;
/*!40000 ALTER TABLE `contactclasses` DISABLE KEYS */;

INSERT INTO `contactclasses` (`id`, `_uid`, `contact_class`, `created_at`, `updated_at`)
VALUES
	(1,'98d687b9-8fac-4999-9be6-8688b6dff16b','Primary','2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(2,'b4adff14-cb60-494b-838c-08430448215c','Secondary','2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(3,'5e11a260-dd0d-4c73-b7d3-af3df9392be1','Tertiary','2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `contactclasses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contactmodes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contactmodes`;

CREATE TABLE `contactmodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contactmodes__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contactmodes` WRITE;
/*!40000 ALTER TABLE `contactmodes` DISABLE KEYS */;

INSERT INTO `contactmodes` (`id`, `_uid`, `contact_mode`, `created_at`, `updated_at`)
VALUES
	(1,'b0f6df54-fb04-4001-af6e-4e1d3c394986','Email','2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(2,'5500b7cb-f6dd-43a7-b397-e902195963a2','Phone','2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `contactmodes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contacttypes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacttypes`;

CREATE TABLE `contacttypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contacttypes` WRITE;
/*!40000 ALTER TABLE `contacttypes` DISABLE KEYS */;

INSERT INTO `contacttypes` (`id`, `_uid`, `contact_type`, `created_at`, `updated_at`)
VALUES
	(1,'b541c68c-18c7-44ac-9043-81fb94996203','Cell','2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(2,'358ad7f1-52cf-479a-95dd-c338801763e4','Home','2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(3,'54544796-898c-4ba8-968f-bb2cf3778d2d','Work','2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `contacttypes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table countries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table devices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `devices`;

CREATE TABLE `devices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_type_id` int(10) unsigned NOT NULL,
  `imei` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devices__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;

INSERT INTO `devices` (`id`, `_uid`, `device_type_id`, `imei`, `created_at`, `updated_at`)
VALUES
	(1,'a540b6f5-35a7-4da1-90b4-40bcfa187bb2',1,1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(2,'b2775fc2-d13d-479f-bc96-52979c8ae045',2,2,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(3,'341c10c3-4283-403a-9a96-29a5a79fa6e8',3,2,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(4,'89e94de1-4647-44f1-afbd-62843fd9e1f9',4,2,'2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table devicestocks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `devicestocks`;

CREATE TABLE `devicestocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `date_stock_added` date DEFAULT NULL,
  `amount_to_add` int(11) NOT NULL,
  `previous_balance` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `added_by_user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devicestocks__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `devicestocks` WRITE;
/*!40000 ALTER TABLE `devicestocks` DISABLE KEYS */;

INSERT INTO `devicestocks` (`id`, `_uid`, `device_id`, `date_stock_added`, `amount_to_add`, `previous_balance`, `total`, `added_by_user_id`, `created_at`, `updated_at`)
VALUES
	(1,'fa11214b-8f07-350e-8962-5531bf859bb8',1,'2023-09-16',41,66,107,102,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(2,'fe59cf22-2c33-346c-90fd-925a6e258a6c',2,'2023-09-16',72,39,111,102,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(3,'9babe860-dea5-3fe4-be49-cab918d65ead',3,'2023-09-16',53,82,135,102,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(4,'261cde72-12f5-399b-8a61-66f2552298db',4,'2023-09-16',46,48,94,102,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(5,'d2bed92f-816f-3e20-9683-be30c23f6172',5,'2023-09-16',30,16,46,102,'2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `devicestocks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table familyrelationships
# ------------------------------------------------------------

DROP TABLE IF EXISTS `familyrelationships`;

CREATE TABLE `familyrelationships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relationship` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `familyrelationships__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table genders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `genders`;

CREATE TABLE `genders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `genders__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `genders` WRITE;
/*!40000 ALTER TABLE `genders` DISABLE KEYS */;

INSERT INTO `genders` (`id`, `gender`, `_uid`, `created_at`, `updated_at`)
VALUES
	(1,'Male','708b084d-b072-40a0-8f0e-82ecebc06967','2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(2,'Female','c099e48a-be49-47c6-b545-9cb393bcce3e','2023-09-16 22:26:54','2023-09-16 22:26:54');

/*!40000 ALTER TABLE `genders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table healthprofessionaldetails
# ------------------------------------------------------------

DROP TABLE IF EXISTS `healthprofessionaldetails`;

CREATE TABLE `healthprofessionaldetails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `credentials` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `details_validated` tinyint(1) NOT NULL,
  `validated_by_user_id` bigint(20) unsigned NOT NULL,
  `date_validated` date NOT NULL,
  `contracted_to_health_e` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `healthprofessionaldetails__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table illnesses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `illnesses`;

CREATE TABLE `illnesses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `illness` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `illnesses__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `illnesses` WRITE;
/*!40000 ALTER TABLE `illnesses` DISABLE KEYS */;

INSERT INTO `illnesses` (`id`, `_uid`, `illness`, `abbreviation`, `created_at`, `updated_at`)
VALUES
	(1,'ca4ecff5-1daf-4a09-bdc4-c8e70ec1965d','Diabetes','Diabetes','2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(2,'3c1d7d0b-97eb-4e5b-bc7c-34bd9d0c3b8f','Hypertension','Hypertension','2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `illnesses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table manufacturers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `manufacturers`;

CREATE TABLE `manufacturers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manufacturer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `manufacturers__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `manufacturers` WRITE;
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;

INSERT INTO `manufacturers` (`id`, `_uid`, `manufacturer_name`, `abbreviation`, `created_at`, `updated_at`)
VALUES
	(1,'227ef913-3dfc-44e4-a207-c68b3ee40054','Telli Health','tellihealth','2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(2,'e3099313-1df3-43e0-9b99-eaac7f2c4641','Bioland','bioland','2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `manufacturers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table maritalstatuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `maritalstatuses`;

CREATE TABLE `maritalstatuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `maritalstatuses` WRITE;
/*!40000 ALTER TABLE `maritalstatuses` DISABLE KEYS */;

INSERT INTO `maritalstatuses` (`id`, `_uid`, `marital_status`, `created_at`, `updated_at`)
VALUES
	(1,'376e9395-01d9-47ac-91dc-53c727968dc0','Married','2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(2,'20c08be7-2388-4a10-b04d-f90a125baa16','Divorced','2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(3,'c66b5e1d-50c1-4947-b266-676247af2066','Single','2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(4,'d5f04a95-0b0d-4348-912a-9ac751db7849','Widowed','2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(5,'8b75bb1d-ffbd-4046-b690-f4276d61b62b','Separated','2023-09-16 22:26:54','2023-09-16 22:26:54');

/*!40000 ALTER TABLE `maritalstatuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2019_08_19_000000_create_failed_jobs_table',1),
	(4,'2022_10_30_161717_create_genders_table',1),
	(5,'2022_11_02_140920_create_permissions_table',1),
	(6,'2022_11_02_144623_create_roles_table',1),
	(7,'2022_11_02_144934_create_permissions_roles_table',1),
	(8,'2022_11_02_151732_create_roles_users_table',1),
	(9,'2023_06_09_105302_create_personaldetails_table',1),
	(10,'2023_06_16_075716_create_addressdetails_table',1),
	(11,'2023_06_16_080132_create_countries_table',1),
	(12,'2023_06_16_082152_create_healthprofessionaldetails_table',1),
	(13,'2023_06_16_093935_create_devices_table',1),
	(14,'2023_06_16_211752_create_illnesses_table',1),
	(15,'2023_06_17_105512_create_devicestocks_table',1),
	(16,'2023_06_17_120702_create_assigneddevices_table',1),
	(17,'2023_07_27_114937_create_manufacturers_table',1),
	(18,'2023_08_01_230018_create_patientprns_table',1),
	(19,'2023_08_01_230318_create_patientcontactinformation_table',1),
	(20,'2023_08_01_230453_create_contactmodes_table',1),
	(21,'2023_08_01_230757_create_contactclasses_table',1),
	(22,'2023_08_01_232417_create_patientdevicereadings_table',1),
	(23,'2023_08_01_233214_create_familyrelationships_table',1),
	(24,'2023_08_08_161610_create_patients_illnesses_table',1),
	(25,'2023_08_14_151914_create_maritalstatuses_table',1),
	(26,'2023_08_15_144442_create_physician_patients_table',1),
	(27,'2023_08_16_101452_create_contacttypes_table',1),
	(28,'2023_08_20_221942_create_readingtypes_table',1),
	(29,'2023_08_20_222015_create_bpreadings_table',1),
	(30,'2023_08_21_083714_create_bgreadings_table',1),
	(31,'2023_08_22_112759_create_devicetypes_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table patientcontactinformation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `patientcontactinformation`;

CREATE TABLE `patientcontactinformation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `contact_type_id` int(10) unsigned NOT NULL,
  `contact_mode_id` int(10) unsigned NOT NULL,
  `contact_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_class_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patientcontactinformation__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table patientprns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `patientprns`;

CREATE TABLE `patientprns` (
  `patient_id` bigint(20) unsigned NOT NULL,
  `prn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `patientprns_patient_id_unique` (`patient_id`),
  UNIQUE KEY `patientprns_prn_unique` (`prn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table patients_illnesses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `patients_illnesses`;

CREATE TABLE `patients_illnesses` (
  `patient_id` bigint(20) unsigned NOT NULL,
  `illness_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



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
	(1,'See Devices Menu','see-devices-menu','2021-03-30 00:32:27','2021-03-30 00:32:27'),
	(2,'View All Pharmacists','view-all-pharmacists','2021-03-30 00:32:27','2021-03-30 00:32:27'),
	(3,'View All Nurses','view-all-nurses','2021-03-30 00:32:27','2021-03-30 00:32:27'),
	(4,'See Users Menu','see-users-menu',NULL,NULL),
	(5,'Add Health-e User','add-health-e-user',NULL,NULL),
	(6,'Edit Health-e User','edit-health-e-user',NULL,NULL),
	(7,'See Manage Data Menu','see-manage-data-menu',NULL,NULL),
	(8,'Update Device Stock','update-device-stock',NULL,NULL),
	(9,'View All Health-e Users','view-all-health-e-users',NULL,NULL),
	(10,'View All Patients','view-all-patients',NULL,NULL),
	(11,'See Permissions Menu','see-permissions-menu',NULL,NULL),
	(12,'View Permissions','view-permissions',NULL,NULL),
	(13,'Add Permission','add-permission',NULL,NULL),
	(14,'See Patient Address Details','see-patient-address-details','2021-03-31 03:16:52','2021-03-31 03:16:52'),
	(15,'Edit Permission','edit-permission','2021-03-31 03:17:47','2021-03-31 03:17:47'),
	(16,'View All Physicians','view-all-physicians','2021-03-31 03:21:23','2021-03-31 03:21:23'),
	(17,'Edit User Profile','edit-user-profile','2021-03-31 03:21:35','2021-03-31 03:21:35'),
	(18,'Add A Device','add-a-device','2021-03-31 03:21:48','2021-03-31 03:21:48'),
	(19,'View All Devices','view-all-devices','2021-03-31 03:21:54','2021-03-31 03:21:54'),
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
	(49,'Add A Patient','add-a-patient',NULL,NULL),
	(50,'See Patients Menu','see-patients-menu',NULL,NULL),
	(51,'View Device Details','view-device-details',NULL,NULL),
	(52,'Edit Device Details','edit-device-details',NULL,NULL),
	(53,'View Device Stock','view-device-stock',NULL,NULL),
	(54,'View Patient Contact Information','view-patient-contact-information',NULL,NULL),
	(55,'Add Patient Contact Information','add-patient-contact-information',NULL,NULL),
	(56,'Edit Patient Contact Information','edit-patient-contact-information',NULL,NULL),
	(57,'View Patient PRN','view-patient-prn',NULL,NULL),
	(58,'View Family Relationships','view-family-relationships',NULL,NULL),
	(59,'Add Family Relationship','add-family-relationship',NULL,NULL),
	(60,'Edit Family Relationship','edit-family-relationship',NULL,NULL),
	(61,'View Patients Device Readings','view-patients-device-readings',NULL,NULL),
	(62,'View Patients Device Reading Details','view-patients-device-reading-details',NULL,NULL),
	(63,'Sign up Patient','sign-up-patient',NULL,NULL);

/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table permissions_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permissions_roles`;

CREATE TABLE `permissions_roles` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permissions_roles_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `permissions_roles` WRITE;
/*!40000 ALTER TABLE `permissions_roles` DISABLE KEYS */;

INSERT INTO `permissions_roles` (`permission_id`, `role_id`)
VALUES
	(1,5),
	(2,5),
	(3,5),
	(4,5),
	(5,5),
	(6,5),
	(7,5),
	(8,5),
	(9,5),
	(10,2),
	(10,5),
	(11,5),
	(12,5),
	(13,5),
	(14,5),
	(15,5),
	(16,5),
	(17,5),
	(18,5),
	(19,5),
	(20,5),
	(21,5),
	(22,5),
	(23,5),
	(24,5),
	(25,5),
	(26,5),
	(27,5),
	(28,5),
	(29,2),
	(29,4),
	(29,5),
	(30,5),
	(31,5),
	(32,5),
	(33,5),
	(34,5),
	(35,5),
	(36,5),
	(37,5),
	(38,5),
	(39,5),
	(40,5),
	(41,5),
	(42,5),
	(43,5),
	(44,5),
	(45,5),
	(46,5),
	(47,5),
	(48,5),
	(49,5),
	(50,2),
	(50,5),
	(51,5),
	(52,5),
	(53,5),
	(54,5),
	(55,5),
	(56,5),
	(57,5),
	(58,5),
	(59,5),
	(60,5),
	(61,4),
	(61,5),
	(62,4),
	(62,5),
	(63,2),
	(63,5);

/*!40000 ALTER TABLE `permissions_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table personaldetails
# ------------------------------------------------------------

DROP TABLE IF EXISTS `personaldetails`;

CREATE TABLE `personaldetails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `dob` date DEFAULT NULL,
  `gender_id` int(10) unsigned DEFAULT NULL,
  `maritalstatus_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personaldetails__uid_unique` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `personaldetails` WRITE;
/*!40000 ALTER TABLE `personaldetails` DISABLE KEYS */;

INSERT INTO `personaldetails` (`id`, `_uid`, `user_id`, `dob`, `gender_id`, `maritalstatus_id`, `created_at`, `updated_at`)
VALUES
	(1,'88a244eb-a0b3-4824-8e01-bff73e9b665d',34,'1986-11-19',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(2,'b913e884-d099-428a-b9b7-21e15b31a659',90,'1973-01-30',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(3,'f398bc9b-85c3-45e8-88c8-ab6e4dc48101',14,'1978-07-12',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(4,'00f8c888-db4d-4483-8dc5-640d58e3303d',83,'1995-03-21',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(5,'ffb6c027-b10a-4f9c-a81d-96bc5a3daa45',58,'1993-04-19',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(6,'247e131c-1ddf-4bb8-83c8-fb8b45a53577',59,'1994-04-18',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(7,'ca989143-3c51-46e1-9e61-441d2b39670c',10,'2003-08-07',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(8,'53c54112-6d9f-40ab-a638-e7dad7cdd003',23,'1982-01-02',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(9,'9c9f722f-9a33-4250-99d4-a73202191b8a',11,'1997-11-28',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(10,'93230cf5-4440-47cd-885a-cf92078871ae',86,'1974-07-25',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(11,'58011aa2-548d-4d6f-afee-dbbf7afcabea',95,'1984-04-05',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(12,'30cb1a53-18e9-4616-a76b-1e8ff4071afc',67,'1999-03-17',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(13,'447c2a97-aaa2-45d8-a288-308916e9b966',74,'1963-10-12',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(14,'ac13d9d5-e5ec-40fd-ba6b-a74d00daab7c',16,'2005-08-10',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(15,'797bca7b-1b40-4bd8-a52b-de42c3558623',51,'1980-01-06',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(16,'bc70654a-04e1-41b8-811d-84d342948b50',33,'1999-10-08',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(17,'89a8b6cf-b890-46fd-baf1-125e8e9bb5b8',98,'1972-09-13',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(18,'4fafaadc-6830-4b72-a417-c52ba73bc8a3',7,'1973-07-15',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(19,'d0964434-c78a-42c3-93af-83f33c4ec87d',47,'1979-03-19',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(20,'a07783c7-44c5-4eae-9e9f-3f5b09dd0496',41,'1968-12-17',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(21,'0b28bafe-31f5-4eb2-a54b-d7f626794c11',88,'1983-03-16',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(22,'fe3003d1-8b16-46f4-a833-083b8bbf86c7',75,'1989-03-13',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(23,'0468cf34-70b3-4b16-a260-fdb2b20e283f',15,'1966-05-08',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(24,'c3afba6f-f6d1-49cd-8de4-064bd5ac645e',25,'1989-02-22',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(25,'45cd589f-b065-4317-8591-930be1e3bc5c',32,'2003-03-08',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(26,'6519b74c-af17-40c1-b280-f48d83298d2d',39,'1971-12-21',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(27,'517908e0-b184-4bbf-9f88-8e7ad6dc501b',84,'1978-08-11',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(28,'198d9a82-aaeb-408e-802a-8213a7d9e84c',30,'1969-11-20',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(29,'87a80d31-fe14-4c3e-bc23-20a3696929b1',77,'1988-08-23',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(30,'63ddb808-24dc-465f-88a2-fcdc15211748',49,'1985-11-19',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(31,'2addbf4c-7d07-47d2-b5d2-e76da0523379',42,'1982-11-24',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(32,'09a70f0f-2db9-44b4-869a-49935cca69d1',66,'1967-08-22',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(33,'917972d3-1e61-4ec7-9db2-14d8480bb9d4',82,'1982-04-29',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(34,'ff74f60b-c961-4718-871c-8980887c63d1',18,'1999-07-19',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(35,'97bf7120-fcac-41cb-bc70-ab9928c63e32',43,'1990-11-21',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(36,'d6882dcf-6d89-46a8-ae04-e6962f7ce2b2',19,'1977-06-14',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(37,'3ff73f1a-c4ad-4cff-9707-e14199542e24',94,'2004-02-07',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(38,'1d37ee4c-5b3d-471e-8861-cae1fcce088c',99,'1970-11-23',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(39,'15f156bc-b396-43c9-929e-af6b2757663c',36,'1972-02-10',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(40,'87d142f3-4b94-4ac4-8561-eb44adaa337d',68,'1994-01-31',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(41,'d4ee1dc8-dabb-47c8-8f37-fe8536c7c26a',28,'1986-06-19',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(42,'e99e9fad-ae39-48b9-bba4-dcebf239cc99',6,'1977-06-02',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(43,'d4434454-0b12-4d39-8d01-67adb4e453d0',89,'1978-09-07',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(44,'8fe7f851-ac02-4a51-b977-61d96bde4b60',24,'1968-02-29',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(45,'5ff63283-c787-4daa-ae37-69b90713e15d',70,'1982-09-28',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(46,'dc20675b-ceb9-4a52-adcd-9adfacf8b6d7',103,'1984-11-15',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(47,'baff7d88-9b5b-4f88-98f4-9997b5654204',56,'1980-03-19',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(48,'ea932769-9361-4b8b-adbd-6889bd10b1c6',80,'1978-10-22',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(49,'7c351daa-0abe-4749-8263-96fdd7de5cd8',5,'1991-11-19',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(50,'838e12a0-00e2-49c7-85b5-a87c18e7298d',73,'2001-12-13',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(51,'724f0cbb-e37d-4a11-82fa-99235fd67225',31,'1983-11-24',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(52,'c4281062-cca7-416b-92f9-da492e0e3ac9',38,'1984-08-15',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(53,'29b11b4b-a0f1-4865-adb6-fce0eff8f579',46,'1979-03-12',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(54,'48758f8b-8ea3-4e73-b88d-a63b8af582b2',54,'1974-08-27',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(55,'483b385c-bc63-4330-91da-13fc841e13d8',101,'1985-06-29',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(56,'65cf48b3-9b3a-4069-8734-0500ad3e289f',69,'1972-03-21',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(57,'603a494a-92d0-4ad3-9757-1b0794c393be',3,'1967-07-18',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(58,'8d537c92-57c4-410b-b8ef-280facc13278',48,'1970-01-29',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(59,'d4366d28-c412-4404-8233-23d7c4ecaefc',50,'1992-03-02',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(60,'bec92000-f0fb-4f39-a692-2e65072d9c22',27,'1968-11-05',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(61,'0694c74d-c503-425e-b3f1-b98137e815c7',85,'1973-11-04',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(62,'bbcd4477-ddf3-48b5-b0a3-6a60ab7f1cf7',26,'1991-08-15',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(63,'d65cecbf-a032-4ada-b1c8-83cbc9dd286b',45,'2002-05-30',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(64,'ff6fe66d-b16a-4238-864a-b60b110039de',35,'1987-07-12',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(65,'1301c63e-a564-4823-ba40-243ace8544fb',64,'1975-12-21',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(66,'6a6cefd2-57ef-42e6-abfe-10c4049948c0',57,'1987-12-27',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(67,'05e078ad-0b8d-4542-b67a-e87c381005bb',91,'1997-01-27',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(68,'20c28032-d5de-4350-805a-b92a66d88eca',22,'1993-07-14',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(69,'2117428c-c1ca-4299-8541-311c7a1f6d09',63,'1981-12-13',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(70,'57cc66fa-830a-4f63-b630-d5e6ebef02df',79,'1974-05-28',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(71,'97d04b4b-6613-4655-9046-68a868b94a78',55,'1980-12-22',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(72,'4faee428-416b-4d75-a86e-eb59a345a8fe',4,'2003-07-23',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(73,'c7121d45-f3e3-414b-b15a-c0d678a94ae2',65,'1982-07-29',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(74,'725edbeb-46d5-4398-ae1c-ef8a9d55b49b',78,'1968-04-21',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(75,'75da32cc-3fc9-4199-ba7d-0c345777f0ec',97,'2000-09-05',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(76,'97f11d77-e2ca-4a8d-a413-3c4fa78062c8',20,'2001-08-26',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(77,'8d61f4e0-619f-4d87-8849-cdaadd8a8cd7',17,'1999-03-25',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(78,'6bdc5534-f862-401c-9665-d18436ac97f5',81,'1980-07-23',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(79,'d88e8b6e-8549-4aae-9156-61e956277805',87,'1979-04-29',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(80,'8eac937b-fd2c-4473-b821-5043d9679cb3',62,'1995-10-19',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(81,'1f625c4b-3b68-4891-bf1e-3fb943f96aa0',104,'1969-01-29',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(82,'e706d9ca-35e4-4b36-92e6-2595d9e9ffbb',61,'2000-03-22',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(83,'ae4f952b-5081-42f5-a938-858cd0527d7b',9,'1979-11-03',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(84,'881997eb-a2f1-4f37-aad3-85fb253e8213',60,'1999-01-27',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(85,'69df6329-404c-4183-96ff-8b6c821929c8',13,'1984-02-02',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(86,'ded5ad90-243f-4bc4-bcc5-bf6740410542',21,'1987-10-21',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(87,'81e32b33-40e2-4861-8303-9fabacef6923',8,'1969-11-12',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(88,'1518c382-03f9-4a60-923a-f49c66a82b83',76,'1978-03-19',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(89,'7f32c93b-7206-4815-af40-80369a734e52',96,'1977-01-09',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(90,'78601896-deeb-47d8-9e55-7f865bd1ba1a',53,'1974-07-20',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(91,'ec6ea91a-946a-4579-bf00-ffe0a8ef15d1',92,'1976-06-21',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(92,'9b6facee-c5ee-4d2d-98ed-07b011cf5a8a',102,'1995-05-01',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(93,'1d25c39e-3ed3-4991-b5b3-0d8f38734eea',1,'1994-07-09',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(94,'a0b0f6bc-8469-4bd9-9658-4da2b9415036',52,'1993-03-12',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(95,'cf49d18a-905b-4de4-b6f0-272c8d8d2d0d',100,'1967-03-19',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(96,'1c8d13cb-eb55-4774-873e-ca433f9ab38e',37,'1976-07-13',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(97,'9a8853b3-1a4f-4f65-84ee-6a6faa79d1eb',71,'1982-12-08',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(98,'4b574e1f-8790-440a-8201-921ce8721fff',93,'2001-03-24',2,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(99,'acd9e079-0052-4354-bd09-523bbd653f84',29,'2002-08-27',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(100,'725335b0-d6df-4656-909b-b7b6c729415c',72,'1982-11-07',1,NULL,'2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `personaldetails` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table physicians_patients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `physicians_patients`;

CREATE TABLE `physicians_patients` (
  `physician_id` bigint(20) unsigned NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table readingtypes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `readingtypes`;

CREATE TABLE `readingtypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `role_name`, `slug`, `created_at`, `updated_at`)
VALUES
	(1,'Pharmacist','pharmacist','2023-06-07 16:02:16','2023-06-07 16:02:16'),
	(2,'Physician','physician','2023-06-07 16:02:16','2023-06-07 16:02:16'),
	(3,'Nurse','nurse','2023-06-07 16:02:16','2023-06-07 16:02:16'),
	(4,'Patient','patient','2023-06-07 16:02:16','2023-06-07 16:02:16'),
	(5,'Super Administrator','super-admin','2023-06-07 16:02:16','2023-06-07 16:02:16'),
	(6,'Administrator','administrator',NULL,NULL),
	(7,'Next of Kin','next-of-kin',NULL,NULL),
	(8,'Caregiver','caregiver',NULL,NULL);

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles_users`;

CREATE TABLE `roles_users` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `roles_users_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `roles_users` WRITE;
/*!40000 ALTER TABLE `roles_users` DISABLE KEYS */;

INSERT INTO `roles_users` (`role_id`, `user_id`)
VALUES
	(1,1),
	(1,4),
	(1,6),
	(1,12),
	(1,13),
	(1,17),
	(1,18),
	(1,19),
	(1,21),
	(1,22),
	(1,32),
	(1,33),
	(1,36),
	(1,38),
	(1,39),
	(1,46),
	(1,49),
	(1,52),
	(1,54),
	(1,57),
	(1,62),
	(1,69),
	(1,75),
	(1,76),
	(1,92),
	(2,5),
	(2,11),
	(2,15),
	(2,24),
	(2,25),
	(2,26),
	(2,27),
	(2,30),
	(2,31),
	(2,40),
	(2,42),
	(2,44),
	(2,51),
	(2,58),
	(2,59),
	(2,60),
	(2,61),
	(2,68),
	(2,70),
	(2,78),
	(2,79),
	(2,81),
	(2,84),
	(2,85),
	(2,86),
	(2,97),
	(2,98),
	(2,99),
	(2,101),
	(2,104),
	(3,10),
	(3,14),
	(3,16),
	(3,23),
	(3,28),
	(3,29),
	(3,34),
	(3,41),
	(3,43),
	(3,45),
	(3,48),
	(3,53),
	(3,63),
	(3,64),
	(3,65),
	(3,67),
	(3,72),
	(3,77),
	(3,87),
	(3,88),
	(3,91),
	(3,95),
	(4,2),
	(4,3),
	(4,7),
	(4,8),
	(4,9),
	(4,20),
	(4,35),
	(4,37),
	(4,47),
	(4,50),
	(4,55),
	(4,56),
	(4,66),
	(4,71),
	(4,73),
	(4,74),
	(4,80),
	(4,82),
	(4,83),
	(4,89),
	(4,90),
	(4,93),
	(4,94),
	(4,96),
	(4,100),
	(4,103),
	(5,102);

/*!40000 ALTER TABLE `roles_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users__uid_unique` (`_uid`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `_uid`, `first_name`, `last_name`, `email`, `email_verified_at`, `remember_token`, `password`, `active`, `created_at`, `updated_at`)
VALUES
	(1,'e64aa319-08dc-4113-a960-7ec8a8731086','Eleonore','Wintheiser','eleonore.wintheiser@oneivelabs.com','2023-09-16 22:26:54','ICp4YiQWDx','$2y$10$X6OWFB9qM7zdOWnAIz/JQeNo0w5Dg22MT87Cj8i5Hk2wfAcsYt.gq',1,'2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(2,'ffee7fdb-3f46-4a37-b562-409448d3a040','Montana','White','montana.white@oneivelabs.com','2023-09-16 22:26:54','2AABq5tgYm','$2y$10$w5lhl95p193vW25A4f7xR.ji3c2VWW7aiKuPbw/mDXdb7tpcKfPb.',1,'2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(3,'79759b3b-9e03-41a8-b40c-2c27145efcbe','Dangelo','Blanda','dangelo.blanda@oneivelabs.com','2023-09-16 22:26:54','2OwwZvPow7','$2y$10$CPT4jP4tq6Tbsq44m5nH6e2Nfypgq/sA1bpeHJ365lHJKFrJkTOd2',1,'2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(4,'aa5976fd-4455-446e-85f8-43be55085cd5','Laila','Greenfelder','laila.greenfelder@oneivelabs.com','2023-09-16 22:26:54','3N301z2S4g','$2y$10$dYOaapr1LW2YJM4GFxDlye.OPjGnREJwl9BYgspgijPfZrGApWxw.',1,'2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(5,'60f9d653-7be0-4c9c-8238-bba4f2af5960','Ivah','Spencer','ivah.spencer@oneivelabs.com','2023-09-16 22:26:54','AFcm2VN2gk','$2y$10$YwVDvU/J6pWSREpBkky6J.E.ofl/foTfLbcbXIj3GAarjdbxbfWra',1,'2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(6,'4a1d5b43-932d-4df7-b302-58d929793f1c','Monique','Swift','monique.swift@oneivelabs.com','2023-09-16 22:26:54','xDb7IlAgEF','$2y$10$7IK6Kbt0tDEnbG2CaKRC2.Djb6dcJP0MDyhlyfpVsgzR32Jz3mazu',1,'2023-09-16 22:26:54','2023-09-16 22:26:54'),
	(7,'20e037d0-c56c-4a60-8768-88e8c7e621f2','Neoma','Barton','neoma.barton@oneivelabs.com','2023-09-16 22:26:54','BLCW85fuVj','$2y$10$1uj.gc1iv0Kz7538fYIQI.kJ0OeiKWcaKRUJzBARGLDrIUl9PeoCG',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(8,'ce4908b7-d19c-4aa4-a9f8-a3d909259011','Lonzo','Kshlerin','lonzo.kshlerin@oneivelabs.com','2023-09-16 22:26:55','h9kB919WlM','$2y$10$3MYwyElWizM2C6gB570NZuQBzEq.o52W48QVCtSbdW6StAVq3PdUG',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(9,'bcf6fb35-602f-4914-a63f-002247aff433','Walter','Schaden','walter.schaden@oneivelabs.com','2023-09-16 22:26:55','a4BLlYSkOD','$2y$10$4xe718Lu3g38nV0wX5sVyOSm74ivVWli9IBRwPSZqSXZE3PNwKRFa',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(10,'0ae7f5a9-81f2-4d28-b77a-e6f0bb7b4db6','Juvenal','Bosco','juvenal.bosco@oneivelabs.com','2023-09-16 22:26:55','KVIxBAmHso','$2y$10$CpP38q71LPScDVMw55XwRuEMaNXTdbwOqwyBCFmAEsOuLemhAYMva',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(11,'0efaf5cc-a1e4-449c-8fc8-478d51a9f553','Sydni','Kreiger','sydni.kreiger@oneivelabs.com','2023-09-16 22:26:55','CucaQuEaNI','$2y$10$ogR2pUeBJyDCv6.8epxWL.pJU7fELwcvUcQ5EBiLkoIqXxR1STHJi',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(12,'f9248745-2b81-42a0-9b9a-8a6b1f90acf5','Sydnee','Lemke','sydnee.lemke@oneivelabs.com','2023-09-16 22:26:55','meyutuYoA2','$2y$10$MYpBCWEdYE.t4X4CVOmSVuLsqGXK6Ju2lEIeqtiQZYKxexTMzd6ne',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(13,'c3a854e3-f2d9-4225-acb2-8fdf10c7e928','Ofelia','Balistreri','ofelia.balistreri@oneivelabs.com','2023-09-16 22:26:55','7IKOJNOyZU','$2y$10$VANc4XvaBi2HtM7ms5z3zuU5PS2Oa0VFpzb6dxK5IO7pndlTVW4Zu',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(14,'06bd4919-5cb7-480a-b4d3-9de143442bb2','Benedict','Pollich','benedict.pollich@oneivelabs.com','2023-09-16 22:26:55','y0JTnL08qM','$2y$10$qIn0XDoAvz5tDa0J7CGwPuvBtR47TVySluQCFjScn6lBcNoexAi1.',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(15,'2af4c1c1-b92e-4335-bab6-fbf2f9acc54b','Noe','Leannon','noe.leannon@oneivelabs.com','2023-09-16 22:26:55','1v2Tc4nhkP','$2y$10$w2Tj81dsQxwKfPTBmdjFs.mohdr/TjWtJGCKBKzLLhdnfTIqB6qaO',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(16,'1a017e2f-87c2-4f68-b452-9f4e7a422775','Jimmie','Mann','jimmie.mann@oneivelabs.com','2023-09-16 22:26:55','onp504Yw6A','$2y$10$JbxKKJNi2Vq4S18bJHpiveH.JZ9f.k6DgQEYQ5H4GZKdzCA41fELq',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(17,'af426047-c5cb-4241-bde9-0c02ee99be15','Dortha','Cassin','dortha.cassin@oneivelabs.com','2023-09-16 22:26:55','APxIu09Q27','$2y$10$6H0841F1jB3a6DYr6kRMie5pRYQ40amdBwgKuNbqy5Z5Lvxg02W.a',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(18,'40b3dfa5-c3bb-4fb5-850e-3bbb626afff8','Sadye','Gulgowski','sadye.gulgowski@oneivelabs.com','2023-09-16 22:26:55','eYfoinln4E','$2y$10$G4WqRJGPWUSegYUTpnzmfOMJ8qVRDhywnhjBVOPM08aT8bwBq4yba',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(19,'415e85bf-89d4-429b-b80e-b52d366dcbc4','Betsy','Robel','betsy.robel@oneivelabs.com','2023-09-16 22:26:55','AUsvNk4QB5','$2y$10$nBsQ5w6URsbtPpCxir4gv.18biPDmTBzr8Kc072Cff7xtWTBImsdm',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(20,'ad3267db-240d-4c3d-9bb8-98d385b1b6cb','Richard','Douglas','richard.douglas@oneivelabs.com','2023-09-16 22:26:55','FE4n50GWp0','$2y$10$Xc8gIjRTUeY66H.SLpEDT.sSg6NCSTTkxB0AYLsjiHMB1vGhc9pt6',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(21,'c7ccaa77-cf1b-4cc0-aa24-824dcfc9ed49','Gerda','Connelly','gerda.connelly@oneivelabs.com','2023-09-16 22:26:55','rtMGJvQFSC','$2y$10$h0pyvPBmqRI3eatkIKFfTeOs/JH/Kw9tEylQ8vvo/GovGnAMpvliG',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(22,'9bbc8a28-2927-42ee-8e20-6f8dea732337','Priscilla','Wiza','priscilla.wiza@oneivelabs.com','2023-09-16 22:26:55','wISRJG2wY0','$2y$10$0ccypx6KWY5x3FS7JBxxU.dkv.puXbb5ZTU847XndzZR5l8bu3SKW',1,'2023-09-16 22:26:55','2023-09-16 22:26:55'),
	(23,'0b0e1edb-fb57-46bc-9bc9-9fe65d3f1c3a','Francis','Willms','francis.willms@oneivelabs.com','2023-09-16 22:26:55','yqP9Yv7bYp','$2y$10$i/Xg/fH.AYm9cQ9j/A6Fde79bVgZnk8mPh9twS8Xeapymml4Zyl1K',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(24,'4cea736d-19ec-4d5d-ba99-741faad40507','Sigmund','Hessel','sigmund.hessel@oneivelabs.com','2023-09-16 22:26:56','8n9JtgQSSB','$2y$10$OM4raFFHXZOVNTyJbta4bu4YHptlkjRu.uoD6WqprndwMM8Ap7EFm',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(25,'2ccd313b-c9d9-43ed-bf3d-172c685d50e2','Maryjane','Emmerich','maryjane.emmerich@oneivelabs.com','2023-09-16 22:26:56','7DePK92PQB','$2y$10$jor7TSlhRladeFdxKbAkaORKTxIbj6ZWibLmkRAR0FbI3BO34HQZS',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(26,'8747dcea-f8cc-4e99-947f-2465032f30b6','Oliver','Smith','oliver.smith@oneivelabs.com','2023-09-16 22:26:56','0BadXcDhX3','$2y$10$OB7UfOFLIjuUWKsPqadhQeZ8Zv1u6TsKchUayrKNTQxuOcCg4AeJO',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(27,'81a78a62-186b-48c8-a63c-c9d29a16ac5d','Newton','Brown','newton.brown@oneivelabs.com','2023-09-16 22:26:56','rEZwkYqYkv','$2y$10$L2u4T5ae1obj4mv/1ZPClOqlo.Sn0u1.GqdOSGtusoLsSSZZx7KrG',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(28,'4a103874-0ffa-457f-b3ae-b42c0b22287d','Kennedi','Weber','kennedi.weber@oneivelabs.com','2023-09-16 22:26:56','MMkhoY7SV3','$2y$10$VUyMuTN7IKYAlLnPRl0YpOVf6PtwCPmKRrroj8JPXwPCXZDNKvxja',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(29,'f2f3e40c-1d80-4209-9a33-324d3522ec71','Lila','Boyle','lila.boyle@oneivelabs.com','2023-09-16 22:26:56','uTH3IoGBtd','$2y$10$GvvMtZbnlGumgW7MDlhYKe/BUr5hCHOTjyXkzc/trSdHadh7dAVYu',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(30,'35ca2ae4-e8ae-4ce2-b0df-5f1e45464e6f','Cathy','Fisher','cathy.fisher@oneivelabs.com','2023-09-16 22:26:56','egCChGRFoA','$2y$10$RknEx99XdptGQy.QCS7kp.jgrQdQLBxnZCb.hJOjWWkqk57eDcHQK',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(31,'68eeefb9-9fd5-4f3a-bede-28b7fab272b2','Emanuel','Hagenes','emanuel.hagenes@oneivelabs.com','2023-09-16 22:26:56','RuOmcH0DYT','$2y$10$knhLxvIoWPWB0WDNa.084OIqfrC3va/GhgpQUh0wYLwN/Bb8WFt9i',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(32,'2d125c80-91fc-4833-adc3-e6a9bd74d0ab','Xzavier','Conroy','xzavier.conroy@oneivelabs.com','2023-09-16 22:26:56','pbmSWPutdj','$2y$10$XOTDWF4igLkdjuUuBc6stubZ9vntUJpYNPRx4IijwKiBuWFnA1iGC',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(33,'1d348595-a6b7-4824-a3c7-6e6296496cb8','Kaley','Bosco','kaley.bosco@oneivelabs.com','2023-09-16 22:26:56','sWZNgekYb5','$2y$10$z7px6ci45uC0bRBbdOKi2OYVe/AH329paiMn9azlmdnoxFa8g/sXK',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(34,'0348d7e1-e64b-4f7a-bfa1-ccfba7841007','Joy','Gutkowski','joy.gutkowski@oneivelabs.com','2023-09-16 22:26:56','xSwIzXihNG','$2y$10$fS6cN7PbpZulWKhCobImDOjmWuBCfZwpeZxtrwge1hsoCH7UnSjZW',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(35,'9291dad6-c7de-47c0-960d-879c5548e66c','Annamae','Hill','annamae.hill@oneivelabs.com','2023-09-16 22:26:56','JDq16xl9pb','$2y$10$pDfDi0wcvl5fT0BzTsl4VeaEUm8OqilLn8Rt3ZbpJvT/78sX3H0nO',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(36,'43b5da16-534f-43df-9ea3-668033f1c8dd','Allie','Harvey','allie.harvey@oneivelabs.com','2023-09-16 22:26:56','XYF4wsmQAk','$2y$10$vPA2Q.scHGkyHlEp6xx7D.New.Avar2fBXm2WEG0noIyHfLYXqpX2',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(37,'edd8d32b-8663-4727-9f91-00f3839ecf0a','Jordi','Dibbert','jordi.dibbert@oneivelabs.com','2023-09-16 22:26:56','RhWX1hWmEO','$2y$10$Vs.A6TAkORUF7G/51HUPBuI8n7sSLCIK0AQE0wIucEvXu7nxvUXqy',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(38,'69f901e0-5f14-40b0-903f-844331918de4','Chelsie','Kuhn','chelsie.kuhn@oneivelabs.com','2023-09-16 22:26:56','Hln0ABNkBR','$2y$10$ZOtvb3hyo/BPQsaY/W6YNuNLAmW8WarnhUyQ23g2yB7bl1Q.U71pW',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(39,'2d3d5a03-466c-463f-ba99-b9babe45c2a5','Colby','Zulauf','colby.zulauf@oneivelabs.com','2023-09-16 22:26:56','OIX1Ld9im1','$2y$10$F90AfE.UTISTpkQMea3J4.IGB7yBpO1qXYVQBy0hZw5KiHTBcC85W',1,'2023-09-16 22:26:56','2023-09-16 22:26:56'),
	(40,'f6129323-7f8d-446d-97df-c4535dc8b2a3','Felicity','Steuber','felicity.steuber@oneivelabs.com','2023-09-16 22:26:56','rIA4OaVjEz','$2y$10$0OmMkPN5iJT5ZINo/FbZSO70B60pu.FEieqx2goV.QU5df3kmmc6u',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(41,'25bd6de9-f20f-405e-bf8a-6124a3ca1e52','Trinity','McDermott','trinity.mcdermott@oneivelabs.com','2023-09-16 22:26:57','Hq6JTrKChP','$2y$10$hQo78jxhuERDNOLgHkxH3umz/7q6dSqzoatvZoyfSD6cse3O36y9m',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(42,'3c13884b-6f59-432e-9871-633adb28ccad','Alysa','Schneider','alysa.schneider@oneivelabs.com','2023-09-16 22:26:57','r0HhPnFAIX','$2y$10$e104ntKKG.dsmaTAEsgtP.mgeNKhmCohCrfknCkNnN6EpkO.KGNH.',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(43,'40ba3f35-2c7a-483a-abb7-8e60f4756a9a','Kenyatta','Heidenreich','kenyatta.heidenreich@oneivelabs.com','2023-09-16 22:26:57','j7xxHnkw1F','$2y$10$yLwcd5AkXpoqRrsQpcpTVOgLrJe6a4aUsPMsEDIdbOpijoLN9oa52',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(44,'ff5cfb56-6e29-42af-90fa-45d934d05169','Ramiro','Kohler','ramiro.kohler@oneivelabs.com','2023-09-16 22:26:57','hLO7xtfKju','$2y$10$F9udz0z1Y3j1IddgMmTmD.vUzh/3091Ri5/jL2DVf4T/l.Uc6FqV6',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(45,'8b9d2081-8a85-4172-9a3b-5e7829f8506c','Alize','Ankunding','alize.ankunding@oneivelabs.com','2023-09-16 22:26:57','ThuLGE8QcY','$2y$10$HHgLGWslMdroQHkcv3/ppufcoCECRiDMoUnF5Zjmka9K4AW8F/dL6',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(46,'7031c829-6261-4e0d-9c20-9ddc7c42ffd6','Armando','Kozey','armando.kozey@oneivelabs.com','2023-09-16 22:26:57','PIEGNJv6c6','$2y$10$L8wzsybwiEf.K444Ad2Wxuvhzvhz0hPhUwheBiO.dYU3AMSqAB1uW',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(47,'20fa131f-80ca-47f2-9874-1d28a165156d','Devin','Lehner','devin.lehner@oneivelabs.com','2023-09-16 22:26:57','Xpzyjt5kSa','$2y$10$dgSJDq.umNhwjLy1hDRt.eGEnjRo2z.XYovp7TA.RZKqLJ4HKUvka',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(48,'7a37dbdd-7c85-432a-b3df-04d44a25c7ae','Hipolito','Corwin','hipolito.corwin@oneivelabs.com','2023-09-16 22:26:57','4eq61UH0dO','$2y$10$y/4G9.TeNYfwulfYWOmQq.udbAJM8mfagi05t58uUS/xL.VfOf4ga',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(49,'38d566d8-123a-4d3f-a031-fbbcaa090f8a','Caleb','Halvorson','caleb.halvorson@oneivelabs.com','2023-09-16 22:26:57','Pu8cBYwrzQ','$2y$10$PbCOdRyvgbIiBJwpIAC/Z.TIITqCtUYxSLFt65eEXJtOLwpYLi80.',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(50,'7ab97d43-a409-4536-8458-0a0c83e559cb','Rusty','Wolff','rusty.wolff@oneivelabs.com','2023-09-16 22:26:57','CDHKnw3CVz','$2y$10$hgTIUZyRND4TYWKHy41OqeGvbbgCHCBMHYD.0nHY5Hu52YED9uWme',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(51,'1b1c3378-83ad-4df3-bc93-777d95e7de83','Lindsey','Batz','lindsey.batz@oneivelabs.com','2023-09-16 22:26:57','pR1ZOpqts6','$2y$10$xmAAtFs/MSV2VhmSex/mAu6FFWighPkBlPfGnfA.zq5NQOFBT9MZu',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(52,'e7391b88-5a2b-43c4-bd43-03a38105b4ee','Eldridge','Ward','eldridge.ward@oneivelabs.com','2023-09-16 22:26:57','zRpfBzjB1u','$2y$10$Ot3ZLEcc8dGDq30EHeVdgOdLc/xd0eKuOxIOb/G0l5.WmKNFrjN.m',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(53,'df3e4a2c-d7d1-494e-88bc-c0232b541858','Evalyn','Huel','evalyn.huel@oneivelabs.com','2023-09-16 22:26:57','9HdoJOp4wF','$2y$10$OYHd0hOXvDfofX1BxAe8ROBWOJYfcmw5FOgQEikZKZ1sBpJYVwKyy',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(54,'73e7072f-4c47-49a1-8659-4df7bd1fac47','Vito','Wilkinson','vito.wilkinson@oneivelabs.com','2023-09-16 22:26:57','9t0EEeKor1','$2y$10$yPsvYjTIGHWDneKmT78rQOw0O2vNqWDjYdbdmSluh/0vX3PQC5ZZO',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(55,'a1d2894e-cc31-457b-8540-287b52f2b915','Watson','Reynolds','watson.reynolds@oneivelabs.com','2023-09-16 22:26:57','JaTjMRi4MV','$2y$10$ScLHMn0O8IXiJDTPfi/SI.Yzo/a4YlvEEk.uuD6fHWrYFipRCeJXC',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(56,'591f777b-fa59-4351-9802-8352a724b6fc','Novella','McGlynn','novella.mcglynn@oneivelabs.com','2023-09-16 22:26:57','2bhKcnfEB1','$2y$10$RMTvCje3CrjSV7AB/aeeYe09GhkCzo0/2gKT3rFIKC8tdeOJqPmye',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(57,'97938bf5-2707-4d3d-9e5c-f4285afa839f','Bradley','Miller','bradley.miller@oneivelabs.com','2023-09-16 22:26:57','rFtdsQ7H3d','$2y$10$vC3sMrFMG6vloQo5lD.6IOFmsJP/V1nxvqdPXHylNl.Y1K680Fxt.',1,'2023-09-16 22:26:57','2023-09-16 22:26:57'),
	(58,'0a1883e1-8d7b-47f1-b0f4-91c65c8b28ca','Jeromy','Willms','jeromy.willms@oneivelabs.com','2023-09-16 22:26:57','UhWP5IFnbd','$2y$10$z.S8EAp.skhYc1tHE5Pn/OOY7yaFPL.STDTT6mORsikcg4nJHMud6',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(59,'0a4158c2-8a79-4d22-8751-36fca6f0091d','Ulices','Aufderhar','ulices.aufderhar@oneivelabs.com','2023-09-16 22:26:58','EVbEXiLQt2','$2y$10$/OTPdmDJWT36s2u0HMQ4juGQwBhNO13V6xSvL2Wsv2U5OfMKAhOs.',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(60,'be91ca40-1282-4f03-9039-66fb59b28638','Lauretta','Anderson','lauretta.anderson@oneivelabs.com','2023-09-16 22:26:58','BbDBqkfSfq','$2y$10$eZIYioaFgkX/zPmPUMFqQeaetRtUG6sYb4r5bc3wj3gFrfOX5dZ5e',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(61,'bcb04ea3-0e65-4b89-92c3-705ece014657','Talon','Dicki','talon.dicki@oneivelabs.com','2023-09-16 22:26:58','YHrXLxVzxG','$2y$10$Oln8ypOZNQcMCxskn8XZqet9Cn26PWYWU7mgc0Hc38BVBUfM82MUK',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(62,'b711c5c3-89b7-4627-9e02-e69205ee7640','Marilyne','Ryan','marilyne.ryan@oneivelabs.com','2023-09-16 22:26:58','FsWs38QIKg','$2y$10$clbHv6AffLU/9CQzSdAdOuyZ6XiZPLY9Y9VX4QsHvD0q7hFXIMABa',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(63,'9c233a53-7a15-4545-99a6-3e49ca2cd0bc','Wilfrid','Leffler','wilfrid.leffler@oneivelabs.com','2023-09-16 22:26:58','RQUcdtXudU','$2y$10$C5HvxqzWpaxuDqlxOftaw.aQz9H7gvAN.WkLiFFf2zS0P5y4.67p.',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(64,'92e550ea-4b8b-40c8-8131-21eda8c1bf5e','Dean','Boyle','dean.boyle@oneivelabs.com','2023-09-16 22:26:58','OqmlR4QuEH','$2y$10$RALGkDXAjBkI333LI.i8CeIQ2DPY6jgMDS2nq.hp0oqIqR2mxYAr6',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(65,'aaa7780d-d63f-4a84-a4b0-e1f0b060814d','Orval','Gottlieb','orval.gottlieb@oneivelabs.com','2023-09-16 22:26:58','T9rOLC7Deo','$2y$10$5VWB4owOOW6JvBym6eTr2.sy.5BoX/LZD5l3dAZHVnBVlrYAjZNxG',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(66,'3dad1b76-5a24-4209-84e8-169bacc395b0','Josue','Rosenbaum','josue.rosenbaum@oneivelabs.com','2023-09-16 22:26:58','s4JCVx5kop','$2y$10$bBgIIn.0iMm16pWrPdQcyuNBh2jHWtAtz7q6V.x08sbFcZAKUrTGm',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(67,'166c264c-f4b9-4754-9b46-a7d7d76e2eac','Branson','Gleichner','branson.gleichner@oneivelabs.com','2023-09-16 22:26:58','OBn0dKWOQb','$2y$10$VTX2tRw1GudS94IkZivyjenDBIyx87z7xuNZnBzbcZnj/.xJnhmO.',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(68,'45d7653e-3bc7-48ba-8b9f-f651a7e42e8d','Abbie','Kohler','abbie.kohler@oneivelabs.com','2023-09-16 22:26:58','8RhSaZb6z1','$2y$10$0vMyn5N4ZBVBl46lHTPDa.tl7A4k/pqG2MYbZJNuRGGp6w8i294ku',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(69,'771a92aa-6adf-42d4-a9e8-202d30cee8a0','Clovis','Abernathy','clovis.abernathy@oneivelabs.com','2023-09-16 22:26:58','tHG1mf1U04','$2y$10$ST5kLG8dgmbxgav64o6GGuy1XOFDCTa6IL9kTIJVYixPZBdbOXox.',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(70,'4df98eef-00f3-4ee7-8ced-dbdeae5b9f38','Chad','Gottlieb','chad.gottlieb@oneivelabs.com','2023-09-16 22:26:58','BtGKEWeC1N','$2y$10$kRJcwmGPcaVast.FrxZQOeFfjcdggR7ZQ0w4s8f7hlnE4qc6j7xx.',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(71,'ee549648-5737-439c-8313-a80dacd67503','Carlee','Rosenbaum','carlee.rosenbaum@oneivelabs.com','2023-09-16 22:26:58','TlCjp9Jj4O','$2y$10$Hw07iv6Jwvo3MSP9GGFEXO7mZIUZD135861JXNBYtgmMxCMUe1sWO',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(72,'f4ce3485-8848-43b2-a8b4-af015594e42f','Jacynthe','Monahan','jacynthe.monahan@oneivelabs.com','2023-09-16 22:26:58','9SqOFucIej','$2y$10$xGhDB/RT56tEbalSsO3JuOHxSvdnFk0tlb11vBM6hKXzCwFH8Auqi',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(73,'65a3e159-e57c-41b6-b0ab-262a0b7fdb8d','Justyn','Mills','justyn.mills@oneivelabs.com','2023-09-16 22:26:58','kqS6EhBvot','$2y$10$yk19mAISsjuETSbAxCbZB.br5/f3HzagA0dc90vZmNJG09BOa9AjW',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(74,'18e71576-c8d8-4819-8318-439e8d89004f','Federico','Carter','federico.carter@oneivelabs.com','2023-09-16 22:26:58','W07IheCP2h','$2y$10$prdQDerNxnkz7CZ2MMEcsuimikMEuUel5bHp3fj19bpP1mqurt3RS',1,'2023-09-16 22:26:58','2023-09-16 22:26:58'),
	(75,'2aa686de-e807-45ed-992a-eb3b4ec9f854','Vilma','Toy','vilma.toy@oneivelabs.com','2023-09-16 22:26:58','araiSmn4rT','$2y$10$7RFl6AyKgalRHFD1rBnRLeFQXiZSCXY8PWhd0ihRIXMpfzVptFU8S',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(76,'de3b70a4-e7be-4a49-b670-152ee3246228','Bud','Hirthe','bud.hirthe@oneivelabs.com','2023-09-16 22:26:59','uoMU0Qi3uo','$2y$10$zLDi8UIS2X3vFrbcxnhf6u.AlXxxWX76YbHnfB3DoMkC2oLD1S4Oq',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(77,'37434f8b-c807-4c43-81fe-da6a16f48661','Theodora','Russel','theodora.russel@oneivelabs.com','2023-09-16 22:26:59','QAfjsOLzpj','$2y$10$oPGHOloi5iVeDvcxvJYcSuobIOTdo5q.26cVZrEU8BdWfyKvDwfjy',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(78,'aab6e1fd-1a91-40df-a4dc-b754c4395dad','Ross','Keeling','ross.keeling@oneivelabs.com','2023-09-16 22:26:59','DCkKfGtYDc','$2y$10$6FmVUAemZxMxysZ57IKaWeC.5WL/2tHu5q9ZgsTfR4gKAaaYgdVVq',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(79,'9e8a8aec-c2e8-4ca0-835b-2dcd50e2e631','Hailee','Hermann','hailee.hermann@oneivelabs.com','2023-09-16 22:26:59','NsIuejSCH3','$2y$10$l4tejNARiLtyWWN8uLbWSel49KH1AVKQo0EDTGU1bX.WoH4flqYIa',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(80,'596c93a4-4b01-4f3b-935a-e9d6659a0960','Morris','Marks','morris.marks@oneivelabs.com','2023-09-16 22:26:59','NcJxpxwPeO','$2y$10$12HHbIh.feETffjHThz8meGApkZqXup9mukcnegIYCzdvPjOPHMeC',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(81,'b0a6b568-13b0-4bf8-bea7-5c9a8befc31e','Jaylen','Heller','jaylen.heller@oneivelabs.com','2023-09-16 22:26:59','Wm4yTsCUrQ','$2y$10$v1J9o5.aDMt03e0y2qGDYuxgvromvCJudaz12Ftykb0ouGF/FV1Wy',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(82,'3dd1e93e-ef14-4d3f-8432-bc833303e119','Lavinia','Schneider','lavinia.schneider@oneivelabs.com','2023-09-16 22:26:59','w9ZeKPxxGz','$2y$10$RJ2/BvYe8E5WtpHfZv7CMuhILjcyyMGCR7tuZbmE8poA3oGytvmo6',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(83,'071d3fc5-b08d-4c4b-88ff-8564b761a5b8','Maxie','Schmeler','maxie.schmeler@oneivelabs.com','2023-09-16 22:26:59','F86HBmvNAJ','$2y$10$kCbpWL58gLccju6tEnxCQefSZEqj661uWUZ6Qrwuo3wt9OUAMUuHW',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(84,'34eb7e6f-4e2f-40d5-80ac-a1d90d275bf6','Lizeth','Prosacco','lizeth.prosacco@oneivelabs.com','2023-09-16 22:26:59','54Ks6S7Jn8','$2y$10$AOjZPISPz6NOp9NsFlTYweulvAz52rQNApTaHovMCbNAdpt9xh.pO',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(85,'8695ebb4-e07c-452c-8a24-f7a87f388fcb','Everette','Miller','everette.miller@oneivelabs.com','2023-09-16 22:26:59','4rSF76EiOm','$2y$10$9S0NHafjn1Bi7ubObbY3Tu30ZUwAGgOotHxBQ/rOPKYy6l5kPCffm',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(86,'11e7c62e-3b7f-45cf-8b2e-a6673e4c6572','Julia','Gleichner','julia.gleichner@oneivelabs.com','2023-09-16 22:26:59','qQQBvYfjkN','$2y$10$97pa.lk8.6RXxW6sgMYhBO2NksdWDAAHYAGKOaesYkbaQhtFI9sTS',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(87,'b0eabf14-b3a4-496b-ba31-0f93d3df1cb5','Micheal','Runolfsson','micheal.runolfsson@oneivelabs.com','2023-09-16 22:26:59','AtQhNAyE1D','$2y$10$wXZ2n00oZwtZSVKGr5SSIu6tGCeEIx340nNrplmQUTCTY7HlQhSHu',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(88,'27864c75-196e-4858-b6d6-98a1cbf8e344','Reilly','Bins','reilly.bins@oneivelabs.com','2023-09-16 22:26:59','SZz07j0YhE','$2y$10$gM0jRoclnpBHy9TmN.aoPO6H9jw.tRNe4yE8sAKHW5Pjw4snFOVY6',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(89,'4b39cc12-5149-408c-b74b-944cec29fe68','Godfrey','Gerhold','godfrey.gerhold@oneivelabs.com','2023-09-16 22:26:59','AxmfoxkR2b','$2y$10$sRKy1zSXo4Jf8nFfLEEzieVHr1YDmUwjQ0jPIiwtG3agPLVMwGZPW',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(90,'04bd057d-5b1c-4599-90ac-be9edf9b91f8','Cayla','Feil','cayla.feil@oneivelabs.com','2023-09-16 22:26:59','Q7JMAw0Gke','$2y$10$KNPVv5pUjwdyKRxqOTeEn.agi3/sbkPzEEfopHjhUkyu9AW0Cza7K',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(91,'99f44f0d-cc1d-4547-9396-e6c782f00dcc','Naomi','Schoen','naomi.schoen@oneivelabs.com','2023-09-16 22:26:59','lCT924pFlL','$2y$10$kRBhKBGeUsQumyYTAzw1seP2GEIakGraTaurzeanan0SE9FZD7t22',1,'2023-09-16 22:26:59','2023-09-16 22:26:59'),
	(92,'df811f95-4e70-4121-81af-21d34e09cd38','Davonte','Effertz','davonte.effertz@oneivelabs.com','2023-09-16 22:26:59','gIww5Zi52X','$2y$10$XmcXIuk0zgQgp/5In2TH2.sifk7GCieePbgM0su0g5GkCzsyPcSoS',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(93,'f29a4fbc-f34a-4ca8-a310-645e7b965b6c','Pedro','Farrell','pedro.farrell@oneivelabs.com','2023-09-16 22:27:00','60wzHkPSZs','$2y$10$9QFBiaSNOfPLf7HK/FtmPe3fySlELC1klkSYa0PcyZOpzW3rjQwSy',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(94,'418d7ccf-2428-4b4f-9b83-554cd50aef38','Cora','Kihn','cora.kihn@oneivelabs.com','2023-09-16 22:27:00','asT2J15Gna','$2y$10$.il695ND9ThJdpiHTo6F1OXLewClJIGBp2gOnFWIoKaXi6RX6.eWq',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(95,'132587c3-dfc4-44c1-beba-ff1b559230d5','Tyrese','Cassin','tyrese.cassin@oneivelabs.com','2023-09-16 22:27:00','cJJemqw9Ji','$2y$10$yyZCok6QhQ/iapT3ZC8vhe.N1OjY7MofvJrlvtldO7EtRc6iMAlSW',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(96,'de4b086f-b288-4ea0-9710-472fca1c8e57','Eleanora','Simonis','eleanora.simonis@oneivelabs.com','2023-09-16 22:27:00','0By9CwIash','$2y$10$22lE6x8IjAjhp3aGA1wmiO5VfOaFoPI1D/Rj0MPhhne.mx17rsYQe',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(97,'ab56f7c7-14c5-4468-9912-4c9491e49a0d','Itzel','Hill','itzel.hill@oneivelabs.com','2023-09-16 22:27:00','IvjC6DsH3Y','$2y$10$S5oKGRZfXx3b3NP6nJk6uuSNeQ6ZokDemyhECc2Ul.bgWj8F8K0/e',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(98,'1d83c136-1f88-425f-9d52-096c0da3360b','Ole','Dare','ole.dare@oneivelabs.com','2023-09-16 22:27:00','HZcSf7RG5b','$2y$10$NhdfYbJ00DJL45BGGHkfR.7CVXniS/PLHE8P2xlJx6Arqz6mJvjZy',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(99,'42ba21b3-d45f-4735-9e58-7083db144eba','Bessie','Wisozk','bessie.wisozk@oneivelabs.com','2023-09-16 22:27:00','tlifnsNhdI','$2y$10$qHJsNkmYZYJa2tGf2rCrWOZmmvwxxwW.q4u95K8kFDFs4kgfevDCG',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(100,'ece071f2-7c82-4ed1-8d7b-4f613e3a7198','Lemuel','Conroy','lemuel.conroy@oneivelabs.com','2023-09-16 22:27:00','9h0TSWvg5L','$2y$10$G68jk0nsUsO/gqbntxh1huGEYF6WWvWAy9F0h1NcSTrJ3rjU4LH9y',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(101,'74d60d87-ec5c-4add-9afc-069381f0f0b8','Jerome','Bailey','jerome.bailey@oneivelabs.com','2023-09-16 22:27:00','Z4g8ZF7kCf','$2y$10$kTlWiW.wqfSIq7zCWp2vTekXUmjlToKeZCnrUFXmlTZhMYGpR3Ary',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(102,'e446f8da-b89a-412c-afd9-73d5d18f3963','Khimanie','Blackwood','khimanie.blackwood@oneivelabs.com','2023-09-16 22:27:00','cI6y9a3g8q','$2y$10$xrHS8c8DJhAvBqHCVhzLe..acUOEbeHJRV/nJsl6nhAj0IB7rXuuW',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(103,'5126e436-22c1-4938-978b-d952a670418f','Kristel','Herts','kristel.herts@yahoo.com','2023-09-16 22:27:00','c0YZ6VwCcC','$2y$10$fWhQstmbCpu0r4vLTTcdC.GviSVERe54aTQ7XD.jNxCy52GOn2nPe',1,'2023-09-16 22:27:00','2023-09-16 22:27:00'),
	(104,'b76cc0cd-013c-41a4-b4f5-f808fb0d7e1b','Matthew','Yale','matyale@oneivelabs.com','2023-09-16 22:27:00','SNxKeLdkQX','$2y$10$zmrF06eMA/Ijo1IMjt0j8uOD212XXbF9Dp1Kk4vvn6mhrQB/GVhiS',1,'2023-09-16 22:27:00','2023-09-16 22:27:00');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
