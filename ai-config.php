<?php
/** PATHS **/
/**
 * Путь к public_html проекта
 * Здесь будет конфиг, скин и временные директории
 */
DEFINE('BASE_ROOT', dirname(__FILE__));
/**
 * Путь к скрипту
 * Он у нас в другом месте
 */
DEFINE('DOC_ROOT', dirname(__FILE__));
DEFINE('LIB_ROOT', DOC_ROOT.'/includes/library');

/** ERROR REPORTING **/
error_reporting(E_ALL);
require_once(DOC_ROOT.'/library/functions.php');
require_once(DOC_ROOT.'/library/mysql.php');
set_error_handler('errorHandler');

/** CONSTANTS **/
require_once(DOC_ROOT.'/includes/constants.php');

/** MYSQL **/
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'total-invest-old');
DEFINE('DB_LOGIN', 'root');
DEFINE('DB_PASSWORD', '');

/** TIMEZONE **/
date_default_timezone_set('Europe/Luxembourg');

/** SETTINGS **/
DEFINE('CACHE_ENABLED', TRUE);
DEFINE('CAPTCHA_ENABLED', FALSE);
DEFINE('LOGIN_PIN_ENABLED', TRUE);
DEFINE('MASTER_PIN_ENABLED', TRUE);
DEFINE('PAGE_ROWS', 20);

/** reCAPTCHA **/
DEFINE('RECAPTCHA_PUBLIC_KEY', '6LdHKssSAAAAAKwhRCbS3N0SPYCRC45AmUZDHnKy');
DEFINE('RECAPTCHA_PRIVATE_KEY', '6LdHKssSAAAAAEV--1Xdfrzmun9BOm2uvA1Te4y2');

session_start();

set_include_path(get_include_path().PATH_SEPARATOR.DOC_ROOT.'/controllers/'.PATH_SEPARATOR.DOC_ROOT.'/library/'.PATH_SEPARATOR.DOC_ROOT.'/models/');
spl_autoload_extensions('.class.php');
spl_autoload_register();

require_once(LIB_ROOT.'/project.class.php');
require_once(LIB_ROOT.'/smarty_functions.php');

if (isset($_REQUEST['referral'])) $_SESSION['referral'] = $_REQUEST['referral'];

$GLOBALS['q'] = array(
	'Mother\'s Maiden Name',
	'City of Birth',
	'Highschool Name',
	'Name of Your First Love',
	'Favorite Pet',
	'Favorite Book',
	'Favorite TV Show/Sitcom',
	'Favorite Movie',
	'Favorite Flower',
	'Favorite Color',
);