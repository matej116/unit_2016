-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL,
  `authorEmail` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


INSERT INTO `users` (`id`, `username`, `password`) VALUES
(2,	'a',	'$2y$10$ML.08UKoSDXBjcVF0IrZWOr2fHRXLSoALma.Jd4jHL0PQpnOkyjV.');

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `email` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_message_id` (`email`,`message_id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2016-04-19 08:50:50
