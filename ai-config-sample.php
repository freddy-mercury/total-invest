<?php
/** PATHS **/
DEFINE('DOC_ROOT', dirname(__FILE__));
DEFINE('LIB_ROOT', DOC_ROOT.'/includes/library');

/** ERROR REPORTING **/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include_once(LIB_ROOT.'/functions.php');
set_error_handler('user_log');

/** CONSTANTS **/
require_once(DOC_ROOT.'/includes/constants.php');

/** MYSQL **/
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'test');
DEFINE('DB_LOGIN', 'root');
DEFINE('DB_PASSWORD', '');

/** TIMEZONE **/
date_default_timezone_set('Europe/Luxembourg');

/** SETTINGS **/
DEFINE('CAPTCHA', 0);
DEFINE('PINS', 0);
DEFINE('QUESTIONS', 0);
DEFINE('PAGE_ROWS', 30);
DEFINE('THEME', 'default');

session_start();
require_once(LIB_ROOT.'/project.class.php');
/** SMARTY **/
Project::getInstance()->getSmarty()->template_dir = DOC_ROOT.'/themes/'.THEME.'/';
Project::getInstance()->getSmarty()->compile_dir = DOC_ROOT.'/templates_c/';
Project::getInstance()->getSmarty()->config_dir = DOC_ROOT.'/configs/';
Project::getInstance()->getSmarty()->cache_dir = DOC_ROOT.'/cache/';

$GLOBALS['row'] = 0;
$GLOBALS['queries'] = array();
$GLOBALS['warnings'] = array();

Project::getInstance()->getSmarty()->assign('PAGE_TITLE', Project::getInstance()->getSettings()->setting['page_title']);
Project::getInstance()->getSmarty()->assign('PAGE_FOOTER', Project::getInstance()->getSettings()->setting['page_footer']);
Project::getInstance()->getSmarty()->assign('theme', THEME);
include_once LIB_ROOT.'/smarty_functions.php';

/*
if (isset($_REQUEST['referral'])) $_SESSION['referral'] = $_REQUEST['referral'];

if (AuthController::getInstance()->isAuthorized()) {
	$user = new User($_SESSION['CUR_USER']->id);
	$e = $user->stats->getNextEarningTime();
	if (!empty($e[0])) {
		$smarty->assign('countdown', 'countdown(\'countdown\', '.$e[1].', '.$e[0].');');
	}
	else {
		$smarty->assign('countdown', '');
	}
	include_once LIB_ROOT.'/Logger.php';
	$logger = new Logger($user->id);
}
else {
	$smarty->assign('countdown', '');
}
$notification = get_notification();*/
/** DEVINFO **/
include_once(LIB_ROOT.'/devinfo.php');