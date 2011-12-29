-- Adminer 3.3.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bad_withdrawals`;
CREATE TABLE `bad_withdrawals` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `amount` float NOT NULL DEFAULT '0',
  `gw_balance` float DEFAULT '0',
  `stamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `access` tinyint(1) DEFAULT '1',
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `login_pin` varchar(10) DEFAULT NULL,
  `master_pin` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `security_question` varchar(255) DEFAULT NULL,
  `security_answer` varchar(255) DEFAULT NULL,
  `security_question2` varchar(255) DEFAULT NULL,
  `security_answer2` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `country` smallint(3) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `address` text,
  `ecurrency` char(2) DEFAULT 'LR',
  `ecurrency_purse` varchar(255) DEFAULT NULL,
  `referral` varchar(255) DEFAULT NULL,
  `alert_profile` tinyint(1) DEFAULT '1',
  `alert_login` tinyint(1) DEFAULT '1',
  `alert_withdrawal` tinyint(1) DEFAULT '1',
  `date_registered` int(11) DEFAULT NULL,
  `hash` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `members` (`id`, `access`, `login`, `password`, `login_pin`, `master_pin`, `email`, `security_question`, `security_answer`, `security_question2`, `security_answer2`, `firstname`, `lastname`, `birthdate`, `country`, `city`, `zip`, `address`, `ecurrency`, `ecurrency_purse`, `referral`, `alert_profile`, `alert_login`, `alert_withdrawal`, `date_registered`, `hash`) VALUES
(1,	2,	'admin',	'admin',	'0',	'0',	'',	'',	'',	'',	'',	'',	'',	'0000-00-00',	0,	'',	'',	'',	'LR',	'',	'0',	1,	1,	1,	0,	'cf425c3cfaa705c9ae26158f277b7497'),
(3,	0,	'qweqwe',	'password',	'88888',	'777',	'tr222ash@55trash.com',	'Mother\'s Maiden Name',	'answer',	'City of Birth',	'answer2',	'Alexander',	'Lemekhov',	'2011-12-28',	2,	'Moscow',	'404132',	'asdasdasdas asd asd sda\r\naskdjnasdasd\r\nasdlkjasd\r\nasdalksjasd',	'LR',	'U1234567',	'',	1,	1,	1,	0,	'1098e0715328c94d46df726ed580ec7d');

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `readed` tinyint(1) NOT NULL DEFAULT '0',
  `stamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `messages` (`id`, `member_id`, `subject`, `body`, `readed`, `stamp`) VALUES
(1,	1,	'Test',	'Test',	1,	1323373784),
(2,	2,	'Test',	'Test',	1,	1306785164),
(3,	3,	'asdasdasda',	'sdasdasdasdas\nasd\nas\ndas\nda\nda\nsffwerwerwerwerwew',	1,	1306785164);

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `datetime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `lang` char(3) NOT NULL DEFAULT 'eng',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `pages` (`id`, `name`, `content`, `lang`) VALUES
(1,	'Home',	'<p><span style=\"color: #222222; font-family: arial, sans-serif; font-size: 12px; -webkit-border-horizontal-spacing: 2px; -webkit-border-vertical-spacing: 2px;\"> \r\n<table style=\"width: 523px; font-size: 12px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td style=\"font-family: arial, sans-serif; padding-top: 7px; padding-right: 0px; padding-bottom: 7px; padding-left: 0px; margin: 0px;\" align=\"left\" valign=\"top\">\r\n<div style=\"padding-bottom: 7px;\"><a style=\"color: #354258; font-weight: bold;\" href=\"http://www.facebook.com/n/?prosto.ya&amp;mid=407f4e1G4616c871G27d3535G0&amp;bcode=6LVEOhgn&amp;n_m=kirill.komarov%40gmail.com\" target=\"_blank\">Elena Novikova</a><span style=\"padding-left: 7px; color: #888888;\">8:43pm Apr 7th</span></div>\r\n<div style=\"padding-bottom: 7px;\">Кирииииил))) Поставь плиз на странице B2B-Center \"Мне нравится\" (нам нужно 25 голосов набрать), а то мы в поиске плохо ищемся:<a style=\"color: #354258;\" href=\"http://www.facebook.com/pages/B2B-Center-%D0%AD%D0%BB%D0%B5%D0%BA%D1%82%D1%80%D0%BE%D0%BD%D0%BD%D1%8B%D0%B5-%D1%82%D0%BE%D1%80%D0%B3%D0%B8/192586337429554\" target=\"_blank\">http://www.facebook.com/pages/B2B-Center-%D0%AD%D0%BB%D0%B5%D0%BA%D1%82%D1%80%D0%BE%D0%BD%D0%BD%D1%8B%D0%B5-%D1%82%D0%BE%D1%80%D0%B3%D0%B8/192586337429554</a></div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\nsdfsdf </span></p>\r\n<p><span style=\"color: #222222; font-family: arial, sans-serif; font-size: 12px; -webkit-border-horizontal-spacing: 2px; -webkit-border-vertical-spacing: 2px;\">sdfsdfsd</span></p>',	'eng');

DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `min` float NOT NULL,
  `max` float NOT NULL,
  `percent` float NOT NULL,
  `percent_per` tinyint(1) NOT NULL DEFAULT '0',
  `periodicity` int(10) NOT NULL DEFAULT '1',
  `periodicity_value` tinyint(3) NOT NULL DEFAULT '1',
  `term` int(3) NOT NULL DEFAULT '1',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `monfri` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `plans` (`id`, `name`, `description`, `min`, `max`, `percent`, `percent_per`, `periodicity`, `periodicity_value`, `term`, `type`, `monfri`) VALUES
(1,	'Bronze plan',	'',	1,	100,	110,	0,	1,	1,	1,	0,	1),
(2,	'Silver plan',	'',	101,	1000,	115,	0,	1,	1,	1,	0,	1),
(3,	'Gold plan',	'',	1001,	10000,	120,	0,	1,	1,	1,	0,	1);

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `custom` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`id`, `name`, `value`, `custom`) VALUES
(1,	'project_name',	'HYIP',	0),
(2,	'project_email',	'support@hyip.local',	0),
(3,	'project_title',	'Title',	0),
(4,	'pm_member_id',	'',	0),
(5,	'pm_account',	'',	0),
(6,	'pm_password',	'',	0),
(7,	'pm_altpassword',	'',	0),
(8,	'lr_account',	'',	0),
(9,	'lr_api',	'',	0),
(10,	'lr_api_secword',	'',	0),
(11,	'lr_store',	'',	0),
(12,	'lr_store_secword',	'',	0),
(13,	'home_page_id',	'1',	0),
(14,	'terms_page_id',	'2',	0),
(15,	'referral_bonus',	'10',	0),
(16,	'transaction_limit',	'0',	0),
(17,	'daily_limit',	'0',	0),
(20,	'theme',	'trifn',	0),
(21,	'langs',	'en',	0),
(41,	'lr_account_deposit',	'',	0),
(42,	'signup_notify',	'',	0),
(43,	'access_notify',	'',	0),
(44,	'change_notify',	'',	0),
(45,	'deposit_notify',	'',	0),
(46,	'withdrawal_notify',	'',	0),
(47,	'forget_email',	'',	0),
(50,	'keywords',	'',	0),
(49,	'page_footer',	'©Footer',	0);

DROP TABLE IF EXISTS `translines`;
CREATE TABLE `translines` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `plan_id` bigint(20) NOT NULL DEFAULT '0',
  `type` enum('e','r','w','d','b','i') NOT NULL DEFAULT 'e',
  `amount` float NOT NULL DEFAULT '0',
  `stamp` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `batch` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`type`,`stamp`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `visits`;
CREATE TABLE `visits` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `stamp` int(11) NOT NULL DEFAULT '0',
  `ip` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `visits` (`id`, `user_id`, `stamp`, `ip`) VALUES
(2,	1,	1323460112,	2130706433);

-- 2011-12-29 17:44:01