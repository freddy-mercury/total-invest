<?php
DEFINE('PRO_VERSION', true);
/** PATHS **/
DEFINE('DOC_ROOT', dirname(__FILE__));
DEFINE('LIB_ROOT', DOC_ROOT.'/includes/library');

/** ERROR REPORTING **/
error_reporting(E_ALL);
include_once(LIB_ROOT.'/functions.php');
set_error_handler('user_log');

/** CONSTANTS **/
require_once(DOC_ROOT.'/includes/constants.php');

/** MYSQL **/
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'hyip_delomare');
DEFINE('DB_LOGIN', 'hyip_delomare');
DEFINE('DB_PASSWORD', 'p7pJFChdAv9sxuG9');

/** TIMEZONE **/
date_default_timezone_set('Europe/Luxembourg');

/** SETTINGS **/
DEFINE('SSL', 0);
DEFINE('REFERRAL_ONCE', 1);
DEFINE('CAPTCHA', 0);
DEFINE('LOGIN_PIN', 0);
DEFINE('MASTER_PIN', 1);
DEFINE('QUESTIONS', 1);
DEFINE('PAGE_ROWS', 20);

session_start();
require_once(LIB_ROOT.'/project.class.php');
require_once(LIB_ROOT.'/smarty_functions.php');

Project::getInstance()->setupLang();
Project::getInstance()->setupSmarty();

$GLOBALS['row'] = 0;
$GLOBALS['queries'] = array();
$GLOBALS['warnings'] = array();

/*
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
if (isset($_REQUEST['referral'])) $_SESSION['referral'] = $_REQUEST['referral'];
/** DEVINFO **/
include_once(LIB_ROOT.'/devinfo.php');
