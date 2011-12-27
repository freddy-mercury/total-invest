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
DEFINE('SSL', 0);
DEFINE('REFERRAL_ONCE', 1);
DEFINE('CAPTCHA', 0);
DEFINE('LOGIN_PIN', 0);
DEFINE('MASTER_PIN', 1);
DEFINE('QUESTIONS', 1);
DEFINE('PAGE_ROWS', 20);

session_start();

set_include_path(get_include_path().PATH_SEPARATOR.DOC_ROOT.'/controllers/'.PATH_SEPARATOR.DOC_ROOT.'/library/'.PATH_SEPARATOR.DOC_ROOT.'/models/');
spl_autoload_extensions('.class.php');
spl_autoload_register();

require_once(LIB_ROOT.'/project.class.php');
require_once(LIB_ROOT.'/smarty_functions.php');

if (isset($_REQUEST['referral'])) $_SESSION['referral'] = $_REQUEST['referral'];