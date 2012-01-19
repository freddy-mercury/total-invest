-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 19, 2012 at 11:29 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `total-invest-old`
--

-- --------------------------------------------------------

--
-- Table structure for table `bad_withdrawals`
--

CREATE TABLE IF NOT EXISTS `bad_withdrawals` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `amount` float NOT NULL DEFAULT '0',
  `gw_balance` float DEFAULT '0',
  `stamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bad_withdrawals`
--


-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `access`, `login`, `password`, `login_pin`, `master_pin`, `email`, `security_question`, `security_answer`, `security_question2`, `security_answer2`, `firstname`, `lastname`, `birthdate`, `country`, `city`, `zip`, `address`, `ecurrency`, `ecurrency_purse`, `referral`, `alert_profile`, `alert_login`, `alert_withdrawal`, `date_registered`, `hash`) VALUES
(1, 2, 'admin', 'admin', '0', '0', '', '', '', '', '', '', '', '0000-00-00', 0, '', '', '', 'LR', '', '0', 1, 1, 1, 0, 'cf425c3cfaa705c9ae26158f277b7497'),
(3, 0, 'qweqwe', 'password', '88888', '777', 'tr222ash@55trash.com', 'Mother''s Maiden Name', 'answer', 'City of Birth', 'answer2', 'Alexander', 'Lemekhov', '2011-12-28', 2, 'Moscow', '404132', 'asdasdasdas asd asd sda\r\naskdjnasdasd\r\nasdlkjasd\r\nasdalksjasd', 'LR', 'U1234567', '', 1, 1, 1, 0, '700a455a4581940d594ea7808f5589c8');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `readed` tinyint(1) NOT NULL DEFAULT '0',
  `stamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `member_id`, `subject`, `body`, `readed`, `stamp`) VALUES
(1, 1, 'Test', 'Test', 1, 1323373784),
(2, 2, 'Test', 'Test', 1, 1306785164);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `datetime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `news`
--


-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `lang` char(3) NOT NULL DEFAULT 'eng',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `content`, `lang`) VALUES
(1, 'Home', '<p><span style="color: #222222; font-family: arial, sans-serif; font-size: 12px; -webkit-border-horizontal-spacing: 2px; -webkit-border-vertical-spacing: 2px;"> \r\n<table style="width: 523px; font-size: 12px;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="font-family: arial, sans-serif; padding-top: 7px; padding-right: 0px; padding-bottom: 7px; padding-left: 0px; margin: 0px;" align="left" valign="top">\r\n<div style="padding-bottom: 7px;"><a style="color: #354258; font-weight: bold;" href="http://www.facebook.com/n/?prosto.ya&amp;mid=407f4e1G4616c871G27d3535G0&amp;bcode=6LVEOhgn&amp;n_m=kirill.komarov%40gmail.com" target="_blank">Elena Novikova</a><span style="padding-left: 7px; color: #888888;">8:43pm Apr 7th</span></div>\r\n<div style="padding-bottom: 7px;">Кирииииил))) Поставь плиз на странице B2B-Center "Мне нравится" (нам нужно 25 голосов набрать), а то мы в поиске плохо ищемся:<a style="color: #354258;" href="http://www.facebook.com/pages/B2B-Center-%D0%AD%D0%BB%D0%B5%D0%BA%D1%82%D1%80%D0%BE%D0%BD%D0%BD%D1%8B%D0%B5-%D1%82%D0%BE%D1%80%D0%B3%D0%B8/192586337429554" target="_blank">http://www.facebook.com/pages/B2B-Center-%D0%AD%D0%BB%D0%B5%D0%BA%D1%82%D1%80%D0%BE%D0%BD%D0%BD%D1%8B%D0%B5-%D1%82%D0%BE%D1%80%D0%B3%D0%B8/192586337429554</a></div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\nsdfsdf </span></p>\r\n<p><span style="color: #222222; font-family: arial, sans-serif; font-size: 12px; -webkit-border-horizontal-spacing: 2px; -webkit-border-vertical-spacing: 2px;">sdfsdfsd</span></p>', 'eng');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `min` float NOT NULL,
  `max` float NOT NULL,
  `percent` float NOT NULL,
  `percent_per` enum('term','periodicity') NOT NULL DEFAULT 'term',
  `periodicity` int(10) NOT NULL DEFAULT '86400',
  `term` int(10) NOT NULL DEFAULT '86400',
  `compounding` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `monfri` tinyint(1) NOT NULL DEFAULT '1',
  `principal_back` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `description`, `min`, `max`, `percent`, `percent_per`, `periodicity`, `term`, `compounding`, `type`, `monfri`, `principal_back`) VALUES
(1, 'Bronze plan', 'This is a plan with small amounts and percents.', 1, 100, 110, 'term', 86400, 864000, 0, 0, 1, 0),
(2, 'Silver plan', 'This is a plan with medium amounts and percents.', 101, 1000, 1, 'periodicity', 86400, 2592000, 1, 0, 1, 1),
(3, 'Gold plan', 'This is a plan with large amounts and percents.', 1001, 10000, 120, 'periodicity', 86400, 864000, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `custom` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `custom`) VALUES
(1, 'project_name', 'HYIP', 0),
(2, 'project_email', 'support@hyip.local', 0),
(3, 'project_title', 'Title', 0),
(4, 'pm_member_id', '', 0),
(5, 'pm_account', '', 0),
(6, 'pm_password', '', 0),
(7, 'pm_altpassword', '', 0),
(8, 'lr_account', '', 0),
(9, 'lr_api', '', 0),
(10, 'lr_api_secword', '', 0),
(11, 'lr_store', '', 0),
(12, 'lr_store_secword', '', 0),
(13, 'home_page_id', '1', 0),
(14, 'terms_page_id', '2', 0),
(15, 'referral_bonus', '10', 0),
(16, 'transaction_limit', '0', 0),
(17, 'daily_limit', '0', 0),
(20, 'theme', 'trifn', 0),
(21, 'langs', 'en', 0),
(41, 'lr_account_deposit', '', 0),
(42, 'signup_notify', '', 0),
(43, 'access_notify', '', 0),
(44, 'change_notify', '', 0),
(45, 'deposit_notify', '', 0),
(46, 'withdrawal_notify', '', 0),
(47, 'forget_email', '', 0),
(50, 'keywords', '', 0),
(49, 'page_footer', '©Footer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `translines`
--

CREATE TABLE IF NOT EXISTS `translines` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `translines`
--


-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE IF NOT EXISTS `visits` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `stamp` int(11) NOT NULL DEFAULT '0',
  `ip` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `user_id`, `stamp`, `ip`) VALUES
(2, 1, 1323460112, 2130706433);
