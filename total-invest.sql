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


DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `readed` tinyint(2) NOT NULL DEFAULT '0',
  `stamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `messages` (`id`, `user_id`, `title`, `message`, `readed`, `stamp`) VALUES
(1,	1,	'Test',	'Test',	1,	1323373784),
(2,	2,	'Test',	'Test',	1,	1306785164);

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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `min` float NOT NULL DEFAULT '0',
  `max` float NOT NULL DEFAULT '0',
  `percent` float NOT NULL DEFAULT '0',
  `percent_per` enum('term','periodicity') NOT NULL DEFAULT 'term',
  `periodicy` int(11) NOT NULL DEFAULT '0',
  `periodicy_value` tinyint(3) NOT NULL DEFAULT '0',
  `term` int(3) NOT NULL DEFAULT '0',
  `attempts` tinyint(2) NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `type` tinyint(1) NOT NULL,
  `working_days` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `plans` (`id`, `name`, `min`, `max`, `percent`, `percent_per`, `periodicy`, `periodicy_value`, `term`, `attempts`, `status`, `comment`, `type`, `working_days`) VALUES
(1,	'11111',	5,	66666,	444,	'term',	3600,	1,	14,	0,	'1',	'',	0,	1);

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


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `access` tinyint(1) DEFAULT '1',
  `fullname` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `login_pin` varchar(10) DEFAULT NULL,
  `master_pin` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `payment_system` enum('LR','PM') DEFAULT 'LR',
  `pm_member_id` varchar(255) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `reg_date` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `referral` varchar(255) DEFAULT '0',
  `access_notify` tinyint(1) DEFAULT '0',
  `change_notify` tinyint(1) DEFAULT '0',
  `deposit_notify` tinyint(1) DEFAULT '0',
  `withdrawal_notify` tinyint(1) DEFAULT '0',
  `withdrawal_limit` float DEFAULT '0',
  `daily_withdrawal_limit` float DEFAULT '0',
  `monitor` tinyint(1) DEFAULT '0',
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL,
  `lang` enum('en','ru') NOT NULL DEFAULT 'en',
  `hash` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `access`, `fullname`, `login`, `password`, `login_pin`, `master_pin`, `email`, `payment_system`, `pm_member_id`, `account`, `reg_date`, `status`, `referral`, `access_notify`, `change_notify`, `deposit_notify`, `withdrawal_notify`, `withdrawal_limit`, `daily_withdrawal_limit`, `monitor`, `security_question`, `security_answer`, `lang`, `hash`) VALUES
(1,	2,	'',	'admin',	'admin',	'0',	'0',	'',	'LR',	'',	'',	0,	1,	'0',	0,	0,	0,	0,	0,	0,	0,	'',	'',	'en',	'8765c586dff6de741d2d84161caeadb1');

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

-- 2011-12-28 03:58:51
