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

INSERT INTO `messages` (`id`, `timestamp`, `authorEmail`, `text`) VALUES
(2,	'2016-04-19 10:52:38',	'test@test.cz',	'Message text'),
(3,	'2016-04-19 11:02:43',	'test@test.cz',	'Message text'),
(4,	'2016-04-19 11:08:58',	'a@a.cz',	'asasa'),
(5,	'2016-04-19 11:09:40',	'sad',	'zfsdfs');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(2,	'a',	'$2y$10$ML.08UKoSDXBjcVF0IrZWOr2fHRXLSoALma.Jd4jHL0PQpnOkyjV.');

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `email` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `message_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_message_id` (`email`,`message_id`),
  KEY `message_id` (`message_id`),
  CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


INSERT INTO `votes` (`id`, `timestamp`, `email`, `message_id`) VALUES
(2,	'2016-04-19 10:52:38',	'test@test.cz',	'2'),
(3,	'2016-04-19 11:02:43',	'test@test.cz',	'3'),
(4,	'2016-04-19 11:08:58',	'a@a.cz',	'2'),
(6,	'2016-04-19 11:09:40',	'sad',	'3');
(7,	'2016-04-19 11:09:40',	'test@test.cz',	'3');
(8,	'2016-04-19 11:09:40',	'sad',	'4');
-- 2016-04-19 09:49:41
