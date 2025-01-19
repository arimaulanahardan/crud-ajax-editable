-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for arimaulanahardan
CREATE DATABASE IF NOT EXISTS `arimaulanahardan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `arimaulanahardan`;

-- Dumping structure for table arimaulanahardan.company_invoices
CREATE TABLE IF NOT EXISTS `company_invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` date NOT NULL,
  `submit_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_invoices_invoice_number_unique` (`invoice_number`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table arimaulanahardan.company_invoices: ~9 rows (approximately)
INSERT INTO `company_invoices` (`id`, `invoice_number`, `company_name`, `delivery_date`, `submit_date`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 'INV-23767923/11', 'PT. Trantow Inc', '1999-06-28', '2012-08-12', 3924.89, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(2, 'INV-35922881/00', 'PT. Heidenreich-Kuphal', '1971-10-02', '1988-12-04', 10571.28, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(3, 'INV-19142776/61', 'PT. Adams-Jast', '2006-09-23', '2012-07-12', 8732.19, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(4, 'INV-63803610/53', 'PT. Medhurst Group', '2003-09-15', '1992-10-18', 8106.93, '2025-01-19 06:29:46', '2025-01-19 06:29:47'),
	(5, 'INV-99006431/95', 'PT. Collins-Ankunding', '2010-10-10', '2015-05-09', 14638.19, '2025-01-19 06:29:46', '2025-01-19 06:29:47'),
	(6, 'INV-36283081/98', 'PT. Homenick LLC', '1986-07-14', '1988-05-02', 11074.49, '2025-01-19 06:29:46', '2025-01-19 06:29:47'),
	(7, 'INV-66951191/54', 'PT. Fritsch, Little and Runolfsdottir', '2002-09-02', '1978-11-28', 9455.52, '2025-01-19 06:29:46', '2025-01-19 06:29:47'),
	(8, 'INV-52442753/52', 'PT. Schultz-Feil', '1986-11-15', '2006-12-02', 6162.12, '2025-01-19 06:29:46', '2025-01-19 06:29:47'),
	(9, 'INV-39371970/73', 'PT. Goodwin-Hudson', '1997-04-13', '1986-09-07', 11289.86, '2025-01-19 06:29:46', '2025-01-19 06:29:47');

-- Dumping structure for table arimaulanahardan.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table arimaulanahardan.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table arimaulanahardan.invoices
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_invoice_id` bigint unsigned NOT NULL,
  `coil_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `thickness` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_company_invoice_id_foreign` (`company_invoice_id`),
  CONSTRAINT `invoices_company_invoice_id_foreign` FOREIGN KEY (`company_invoice_id`) REFERENCES `company_invoices` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table arimaulanahardan.invoices: ~36 rows (approximately)
INSERT INTO `invoices` (`id`, `company_invoice_id`, `coil_number`, `width`, `length`, `thickness`, `weight`, `price`, `created_at`, `updated_at`) VALUES
	(1, 1, 'dolores', 9549.79, 2753.47, 4870.53, 8074.67, 1045.05, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(2, 1, 'voluptas', 1864.54, 1368.43, 7557.61, 5611.05, 2879.84, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(3, 1, 'commodi', 9672.39, 2740.02, 3480.02, 5909.10, 9436.19, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(4, 1, 'sapiente', 2634.26, 1772.97, 8934.62, 9354.52, 1592.44, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(5, 2, 'ipsam', 4805.73, 8796.78, 875.08, 9418.44, 5550.27, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(6, 2, 'voluptatem', 2783.04, 950.17, 9566.70, 6910.96, 5021.01, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(7, 2, 'maxime', 5446.28, 3569.45, 2065.74, 5423.89, 1765.13, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(8, 2, 'et', 1692.12, 4471.49, 1113.87, 1579.35, 9761.81, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(9, 3, 'fugit', 1884.58, 4776.57, 552.82, 6686.96, 7709.12, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(10, 3, 'qui', 575.77, 9213.76, 4779.33, 220.17, 1023.07, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(11, 3, 'ut', 1049.54, 2416.98, 4925.93, 3995.34, 1969.26, '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(12, 3, 'fugiat', 8092.28, 6871.49, 2938.06, 6777.37, 8544.66, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(13, 4, 'ratione', 9126.50, 426.75, 6117.70, 3520.99, 6057.10, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(14, 4, 'rerum', 4621.49, 8464.89, 4112.15, 4744.89, 2049.83, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(15, 4, 'tempora', 6589.50, 4585.51, 3712.88, 9653.52, 8524.31, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(16, 4, 'dolor', 2273.85, 2730.24, 1692.48, 4975.54, 1204.89, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(17, 5, 'et', 5957.39, 6194.18, 767.57, 4921.41, 8136.15, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(18, 5, 'repellendus', 6772.19, 6521.49, 4491.11, 8605.03, 6502.04, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(19, 5, 'optio', 4989.19, 3519.61, 8798.61, 8336.70, 7825.33, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(20, 5, 'ratione', 7181.91, 4385.51, 2283.72, 3107.16, 7014.41, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(21, 6, 'modi', 3872.47, 614.28, 651.90, 5324.24, 8215.44, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(22, 6, 'voluptas', 3326.97, 1719.11, 7381.87, 6588.56, 2859.05, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(23, 6, 'placeat', 4167.23, 3525.10, 5572.64, 7439.13, 7144.05, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(24, 6, 'dolores', 1362.95, 76.58, 2857.74, 1732.46, 9666.16, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(25, 7, 'perspiciatis', 64.27, 9532.37, 9372.60, 6648.87, 323.24, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(26, 7, 'aut', 2299.29, 8388.75, 8206.30, 8651.40, 9132.28, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(27, 7, 'enim', 3479.78, 2245.94, 8906.39, 1670.61, 978.92, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(28, 7, 'reprehenderit', 7851.01, 5615.46, 8321.92, 5822.10, 8748.15, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(29, 8, 'asperiores', 80.18, 5772.29, 2952.59, 209.59, 1583.89, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(30, 8, 'voluptatem', 6431.22, 4401.37, 1696.36, 8004.05, 4578.23, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(31, 8, 'qui', 5941.97, 2884.57, 136.90, 2264.25, 3772.87, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(32, 8, 'ut', 4794.09, 7883.81, 9824.19, 3088.87, 3268.08, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(33, 9, 'dolores', 3112.06, 8231.72, 1373.14, 7886.87, 3752.30, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(34, 9, 'quis', 387.21, 3443.62, 7808.17, 908.77, 7537.56, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(35, 9, 'alias', 5752.92, 1799.48, 277.04, 8673.92, 9195.65, '2025-01-19 06:29:47', '2025-01-19 06:29:47'),
	(36, 9, 'facilis', 4420.35, 7059.30, 6992.49, 1406.74, 3626.16, '2025-01-19 06:29:47', '2025-01-19 06:29:47');

-- Dumping structure for table arimaulanahardan.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table arimaulanahardan.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2025_01_19_013545_create_company_invoices_table', 1),
	(7, '2025_01_19_013555_create_invoices_table', 1);

-- Dumping structure for table arimaulanahardan.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table arimaulanahardan.password_resets: ~0 rows (approximately)

-- Dumping structure for table arimaulanahardan.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table arimaulanahardan.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table arimaulanahardan.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table arimaulanahardan.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table arimaulanahardan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table arimaulanahardan.users: ~10 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Madilyn Wilkinson', 'marietta.lakin@example.net', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', '6HAF3H5of3', '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(2, 'Selmer Purdy', 'erna79@example.org', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', 'XVrgHI35XG', '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(3, 'Kelton King', 'dvandervort@example.org', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', 'jf50ScySOJ', '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(4, 'Buddy Orn', 'america65@example.org', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', 'sWsOGzUo27', '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(5, 'Darron Brakus', 'alexanne03@example.net', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', 'BiarGClheB', '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(6, 'Shyann Breitenberg', 'estell.kozey@example.org', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', 'rv3duduIVY', '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(7, 'Miss Florence Osinski', 'desiree.klocko@example.net', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', 'OG5mM3UwrT', '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(8, 'Dax Beatty', 'orolfson@example.org', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', 'toFDrHv84J', '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(9, 'Mrs. Lolita Muller V', 'hortense.welch@example.com', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', 'HV03hoTdHC', '2025-01-19 06:29:46', '2025-01-19 06:29:46'),
	(10, 'Amira Fisher', 'aklein@example.net', '2025-01-19 06:29:46', '$2y$12$r6pvQcrO6nOWS4ZxLQS1j.NN4ChuH2lVaBTPHMLQOGVx5AvG9pUnC', '5JWgZQjvGO', '2025-01-19 06:29:46', '2025-01-19 06:29:46');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
