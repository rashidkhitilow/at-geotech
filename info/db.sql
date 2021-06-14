-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.17-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table at-geotech.departments
DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table at-geotech.departments: ~3 rows (approximately)
DELETE FROM `departments`;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` (`id`, `title`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'IT', 'Information technologies', '2021-06-11 00:04:48', '2021-06-11 00:05:07', NULL),
	(2, 'HR', 'Human Resources', '2021-06-11 00:05:04', '2021-06-11 00:05:07', NULL),
	(3, 'Finance', NULL, '2021-06-11 00:05:22', NULL, NULL);
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;

-- Dumping structure for table at-geotech.employee_datas
DROP TABLE IF EXISTS `employee_datas`;
CREATE TABLE IF NOT EXISTS `employee_datas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `position_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `department_id` (`department_id`),
  KEY `position_id` (`position_id`),
  CONSTRAINT `FK_employees_departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_employees_positions` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table at-geotech.employee_datas: ~0 rows (approximately)
DELETE FROM `employee_datas`;
/*!40000 ALTER TABLE `employee_datas` DISABLE KEYS */;
INSERT INTO `employee_datas` (`id`, `department_id`, `position_id`, `name`, `surname`, `phone`, `address`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(4, 1, 1, 'Namedsfsdf', 'Surnamedsfsdf', '9348957354', 'Baku, ddf', 3, '2021-06-11 05:11:41', '2021-06-13 13:44:47', NULL),
	(5, 2, 2, 'Ali', 'dgdfgdgf', '90430083495', 'fdssdsmnfdmsf', 1, '2021-06-12 15:02:36', '2021-06-13 13:56:04', NULL),
	(6, 2, 1, 'Rashid', NULL, '+10506601419', NULL, 2, '2021-06-12 21:23:45', '2021-06-13 13:56:18', NULL),
	(7, 3, 2, 'Tural', 'Zaman', '+10506601419', NULL, 3, '2021-06-12 21:27:21', '2021-06-13 12:18:25', NULL),
	(8, 1, NULL, 'Smd', 'cvcxvxc', '9375883945', NULL, 1, '2021-06-13 13:47:09', '2021-06-13 13:47:09', NULL),
	(9, 2, NULL, 'dsfsdf', NULL, NULL, NULL, NULL, '2021-06-13 14:14:19', '2021-06-13 14:14:19', NULL);
/*!40000 ALTER TABLE `employee_datas` ENABLE KEYS */;

-- Dumping structure for table at-geotech.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
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

-- Dumping data for table at-geotech.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table at-geotech.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table at-geotech.migrations: ~8 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2021_06_10_045235_create_permissions_table', 1),
	(5, '2021_06_10_045306_create_roles_table', 1),
	(6, '2021_06_10_045324_create_users_permissions_table', 1),
	(7, '2021_06_10_045339_create_users_roles_table', 1),
	(8, '2021_06_10_045357_create_roles_permissions_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table at-geotech.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table at-geotech.password_resets: ~0 rows (approximately)
DELETE FROM `password_resets`;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table at-geotech.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table at-geotech.permissions: ~4 rows (approximately)
DELETE FROM `permissions`;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'Add employee data', 'add-employee_datas', '2021-06-11 06:44:04', NULL),
	(2, 'Edit employee data', 'edit-employee_datas', '2021-06-11 06:44:04', NULL),
	(3, 'Show employee data', 'show-employee_datas', '2021-06-11 06:44:04', NULL),
	(4, 'Delete employee data', 'delete-employee_datas', '2021-06-11 06:44:04', NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table at-geotech.positions
DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(225) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table at-geotech.positions: ~2 rows (approximately)
DELETE FROM `positions`;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` (`id`, `title`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'HR Specalist', 'HR', '2021-06-11 00:04:25', '2021-06-11 00:04:28', NULL),
	(2, 'Software Developer', 'IT', '2021-06-11 00:04:26', '2021-06-11 00:04:29', NULL);
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;

-- Dumping structure for table at-geotech.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table at-geotech.roles: ~2 rows (approximately)
DELETE FROM `roles`;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin', '2021-06-11 06:46:18', NULL),
	(2, 'User', 'user', '2021-06-11 06:47:01', NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table at-geotech.roles_permissions
DROP TABLE IF EXISTS `roles_permissions`;
CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `roles_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `roles_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `roles_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table at-geotech.roles_permissions: ~6 rows (approximately)
DELETE FROM `roles_permissions`;
/*!40000 ALTER TABLE `roles_permissions` DISABLE KEYS */;
INSERT INTO `roles_permissions` (`role_id`, `permission_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(2, 1),
	(2, 3);
/*!40000 ALTER TABLE `roles_permissions` ENABLE KEYS */;

-- Dumping structure for table at-geotech.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table at-geotech.users: ~3 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Rashid Khitilov', 'rashid.khitilov@gmail.com', '+994506601419', '2021-06-11 07:39:40', '$2y$10$F/O2kAGXasqwWwvZK8Njnu0jIoQm4lvVaoRuU5L/cpc6gn8tyVeae', NULL, '2021-06-11 07:39:44', NULL),
	(7, 'Test User', 'test@test.com', '039483534', NULL, '$2y$10$F/O2kAGXasqwWwvZK8Njnu0jIoQm4lvVaoRuU5L/cpc6gn8tyVeae', NULL, '2021-06-11 03:56:23', '2021-06-11 03:56:23'),
	(8, 'ali', 'ali@d.com', '3453535', NULL, '$2y$10$vpbSHPmzM6Y2riCA5KxicOsEFnc5kj6MEm/n45aqMCKYzFhHERAYG', NULL, '2021-06-11 04:24:20', '2021-06-11 04:24:20');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table at-geotech.users_permissions
DROP TABLE IF EXISTS `users_permissions`;
CREATE TABLE IF NOT EXISTS `users_permissions` (
  `user_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `users_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table at-geotech.users_permissions: ~0 rows (approximately)
DELETE FROM `users_permissions`;
/*!40000 ALTER TABLE `users_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_permissions` ENABLE KEYS */;

-- Dumping structure for table at-geotech.users_roles
DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `users_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table at-geotech.users_roles: ~3 rows (approximately)
DELETE FROM `users_roles`;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
	(1, 1),
	(7, 2),
	(8, 2);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;

-- Dumping structure for table at-geotech.user_department_ids
DROP TABLE IF EXISTS `user_department_ids`;
CREATE TABLE IF NOT EXISTS `user_department_ids` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `FK_user_department_ids_departments` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_user_department_ids_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table at-geotech.user_department_ids: ~4 rows (approximately)
DELETE FROM `user_department_ids`;
/*!40000 ALTER TABLE `user_department_ids` DISABLE KEYS */;
INSERT INTO `user_department_ids` (`id`, `user_id`, `department_id`) VALUES
	(5, 1, 1),
	(10, 7, 2),
	(11, 8, 2),
	(12, 8, 3),
	(13, 1, 2);
/*!40000 ALTER TABLE `user_department_ids` ENABLE KEYS */;

-- Dumping structure for table at-geotech.user_department_ids_and_field_names
DROP TABLE IF EXISTS `user_department_ids_and_field_names`;
CREATE TABLE IF NOT EXISTS `user_department_ids_and_field_names` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_department_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `field_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_ud_and_field_names_user_ids_and_departments_ids` (`user_department_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_ud_and_field_names_user_ids_and_departments_ids` FOREIGN KEY (`user_department_id`) REFERENCES `user_department_ids` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_user_department_ids_and_field_names_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table at-geotech.user_department_ids_and_field_names: ~10 rows (approximately)
DELETE FROM `user_department_ids_and_field_names`;
/*!40000 ALTER TABLE `user_department_ids_and_field_names` DISABLE KEYS */;
INSERT INTO `user_department_ids_and_field_names` (`id`, `user_department_id`, `user_id`, `field_name`) VALUES
	(1, 5, 1, 'id'),
	(2, 5, 1, 'name'),
	(3, 5, 1, 'surname'),
	(4, 5, 1, 'phone'),
	(5, 10, 7, 'id'),
	(6, 10, 7, 'name'),
	(7, 11, 8, 'id'),
	(8, 11, 8, 'name'),
	(9, 12, 8, 'id'),
	(10, 12, 8, 'name'),
	(11, 13, 1, 'id'),
	(12, 13, 1, 'name'),
	(14, 13, 1, 'department_id'),
	(15, 5, 1, 'department_id'),
	(16, 10, 7, 'department_id'),
	(17, 11, 8, 'department_id'),
	(19, 12, 8, 'department_id');
/*!40000 ALTER TABLE `user_department_ids_and_field_names` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
