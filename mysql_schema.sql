-- Adminer 3.3.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `html_pages`;
CREATE TABLE `html_pages` (
  `keyword` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `lang` char(2) NOT NULL DEFAULT 'en',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`keyword`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ecurrency_code` char(2) DEFAULT 'lr',
  `ecurrency_purse` varchar(255) DEFAULT NULL,
  `security_pin` varchar(10) DEFAULT NULL,
  `security_question` tinyint(2) DEFAULT '1',
  `security_custom` varchar(255) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT '',
  `lang` char(2) DEFAULT 'en',
  `hash` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `ecurrency_code`, `ecurrency_purse`, `security_pin`, `security_question`, `security_custom`, `security_answer`, `lang`, `hash`) VALUES
(1,	'Root',	'root@hyip-developers.org',	'5f4dcc3b5aa765d61d8327deb882cf99',	'lr',	NULL,	NULL,	1,	NULL,	'',	'en',	NULL);

-- 2011-12-14 02:55:29