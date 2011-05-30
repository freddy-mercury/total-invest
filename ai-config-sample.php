<?php
DEFINE('PRO_VERSION', true);
/** PATHS **/
/**
 * Путь к public_html проекта
 * Здесь будет конфиг, скин и временные директории
 */
define('BASE_ROOT', dirname(__FILE__));
/**
 * Путь к скрипту
 * Он у нас в другом месте
 */
DEFINE('DOC_ROOT', '/home/hyip-script/public_html/total-invest-1.1');
DEFINE('LIB_ROOT', DOC_ROOT.'/includes/library');

/** ERROR REPORTING **/
error_reporting(E_ALL);
include_once(LIB_ROOT.'/functions.php');
set_error_handler('user_log');

/** CONSTANTS **/
require_once(DOC_ROOT.'/includes/constants.php');

/** MYSQL **/
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'db_name');
DEFINE('DB_LOGIN', 'db_login');
DEFINE('DB_PASSWORD', 'db_password');

/** TIMEZONE **/
date_default_timezone_set('Europe/Luxembourg');

/** SETTINGS **/
DEFINE('CACHE_ENABLED', TRUE);
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


if (isset($_REQUEST['referral'])) $_SESSION['referral'] = $_REQUEST['referral'];
/** DEVINFO **/
include_once(LIB_ROOT.'/devinfo.php');
