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
DEFINE('DB_NAME', 'total-invest');
DEFINE('DB_LOGIN', 'total-invest');
DEFINE('DB_PASSWORD', 'total-invest');

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


if (isset($_REQUEST['referral'])) $_SESSION['referral'] = $_REQUEST['referral'];
/** DEVINFO **/
include_once(LIB_ROOT.'/devinfo.php');
