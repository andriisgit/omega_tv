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

-- Dumping structure for table omega_tv.tarif_active
CREATE TABLE IF NOT EXISTS `tarif_active` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cct_id` int(10) unsigned NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `date_end` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cct_id` (`cct_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table omega_tv.tarif_active: ~4 rows (approximately)
/*!40000 ALTER TABLE `tarif_active` DISABLE KEYS */;
INSERT INTO `tarif_active` (`id`, `cct_id`, `is_active`, `date_end`) VALUES
	(1, 2, 1, '2021-04-01 00:00:00'),
	(2, 3, 1, '2021-04-30 00:00:00'),
	(3, 1, 0, '2021-04-01 00:00:00'),
	(4, 4, 0, '2021-04-30 00:00:00'),
	(5, 1, 1, '2021-04-30 00:00:00'),
	(6, 7, 1, '2021-04-30 00:00:00');
/*!40000 ALTER TABLE `tarif_active` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
