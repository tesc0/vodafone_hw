-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Verzió:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for vodafone
CREATE DATABASE IF NOT EXISTS `vodafone` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `vodafone`;

-- Dumping structure for tábla vodafone.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lastname` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table vodafone.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `lastname`, `firstname`, `email`, `phone`, `created_at`) VALUES
	(1, '﻿Vilhelmina', 'Nathan', 'vnathan0@sakura.ne.jp', '(284) 5771205', '2020-05-09 18:07:46'),
	(2, 'Salomone', 'Cadagan', 'scadagan1@twitter.com', '(633) 9712064', '2020-05-09 18:07:46'),
	(3, 'Robetta', 'Griffitt', 'rgriffitt2@auda.org.au', '(495) 5743185', '2020-05-09 18:07:46'),
	(4, 'Morgan', 'Elwyn', 'melwyn3@mac.com', '(674) 9861185', '2020-05-09 18:07:46'),
	(5, 'Milli', 'Tothacot', 'mtothacot4@wikia.com', '(727) 7094113', '2020-05-09 18:07:46'),
	(6, 'Hamlin', 'Brokenshaw', 'hbrokenshaw5@cyberchimps.com', '(687) 7650593', '2020-05-09 18:07:46'),
	(7, 'Kendrick', 'Tallyn', 'ktallyn6@twitpic.com', '(757) 8357504', '2020-05-09 18:07:46'),
	(8, 'Belinda', 'Koenraad', 'bkoenraad7@mtv.com', '(863) 3313861', '2020-05-09 18:07:46'),
	(9, 'Abigail', 'Prandoni', 'aprandoni8@nydailynews.com', '(821) 4630601', '2020-05-09 18:07:46'),
	(10, 'Lefty', 'Mewitt', 'lmewitt9@ifeng.com', '(155) 5752060', '2020-05-09 18:07:46'),
	(11, 'Mill', 'Mongain', 'mmongaina@ow.ly', '(581) 9066583', '2020-05-09 18:07:46'),
	(12, 'Sallee', 'Hum', 'shumb@princeton.edu', '(299) 2452549', '2020-05-09 18:07:46'),
	(13, 'Perren', 'Hovert', 'phovertc@addthis.com', '(620) 8928611', '2020-05-09 18:07:46'),
	(14, 'Papagena', 'Lothlorien', 'plothloriend@netvibes.com', '(678) 2206864', '2020-05-09 18:07:46'),
	(15, 'Edan', 'Pestricke', 'epestrickee@delicious.com', '(536) 3778725', '2020-05-09 18:07:46'),
	(16, 'Lorne', 'Colleer', 'lcolleerf@usa.gov', '(213) 9826018', '2020-05-09 18:07:46'),
	(17, 'Maximilien', 'Oxx', 'moxxg@aol.com', '(683) 3336376', '2020-05-09 18:07:46'),
	(18, 'Anselma', 'Prawle', 'aprawleh@is.gd', '(128) 3343249', '2020-05-09 18:07:46'),
	(19, 'Evered', 'Carnaman', 'ecarnamani@cmu.edu', '(343) 8834885', '2020-05-09 18:07:46'),
	(20, 'Amerigo', 'Raw', 'arawj@youtube.com', '(366) 8408094', '2020-05-09 18:07:46'),
	(21, 'Cassaundra', 'Studeart', 'cstudeartk@amazon.co.uk', '(882) 7026449', '2020-05-09 18:07:46'),
	(22, 'Dinnie', 'Scandrett', 'dscandrettl@youtu.be', '(698) 9419784', '2020-05-09 18:07:46'),
	(23, 'Carmon', 'Sutterfield', 'csutterfieldm@latimes.com', '(753) 5698039', '2020-05-09 18:07:46'),
	(24, 'Randolph', 'Doxsey', 'rdoxseyn@instagram.com', '(488) 1396525', '2020-05-09 18:07:46'),
	(25, 'Thorn', 'Coverly', 'tcoverlyo@csmonitor.com', '(212) 8855281', '2020-05-09 18:07:46'),
	(26, 'Joscelin', 'Mecozzi', 'jmecozzip@ifeng.com', '(200) 7294070', '2020-05-09 18:07:46'),
	(27, 'Joell', 'O\' Cloney', 'jocloneyq@apache.org', '(506) 5694599', '2020-05-09 18:07:46'),
	(28, 'Lenette', 'Pattillo', 'lpattillor@elpais.com', '(565) 8184521', '2020-05-09 18:07:46'),
	(29, 'Mona', 'Syres', 'msyress@google.cn', '(470) 8045477', '2020-05-09 18:07:46'),
	(30, 'Shannan', 'Beckley', 'sbeckleyt@blogger.com', '(505) 6698686', '2020-05-09 18:07:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
