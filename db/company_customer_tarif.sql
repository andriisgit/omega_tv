-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.37-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table omega_tv.company_customer_tarif
CREATE TABLE IF NOT EXISTS `company_customer_tarif` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `tarif_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `customer_id` (`customer_id`),
  KEY `tarif_id` (`tarif_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table omega_tv.company_customer_tarif: ~7 rows (approximately)
/*!40000 ALTER TABLE `company_customer_tarif` DISABLE KEYS */;
INSERT INTO `company_customer_tarif` (`id`, `company_id`, `customer_id`, `tarif_id`) VALUES
	(1, 1, 1, 3),
	(2, 1, 3, 4),
	(3, 4, 3, 2),
	(4, 3, 1, 1),
	(5, 4, 4, 3),
	(6, 3, 4, 2),
	(7, 4, 1, 1);
/*!40000 ALTER TABLE `company_customer_tarif` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
