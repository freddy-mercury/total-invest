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
DEFINE('PAGE_ROWS', 20);

/** PINS **/
DEFINE('PINS_ENABLED', true);
DEFINE('LOGIN_PIN_LENGTH', 5);
DEFINE('MASTER_PIN_LENGTH', 3);

/** reCAPTCHA **/
DEFINE('CAPTCHA_ENABLED', false);
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
$GLOBALS['ecurrencies'] = array(
	'LR' => 'Liberty Reserve',
	'PM' => 'Perfect Money',
);
$GLOBALS['countries'] = array(
		"Afghanistan",
		"Albania",
		"Algeria",
		"Andorra",
		"Angola",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bhutan",
		"Bolivia",
		"Bosnia and Herzegovina",
		"Botswana",
		"Brazil",
		"Brunei",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Colombi",
		"Comoros",
		"Congo (Brazzaville)",
		"Congo",
		"Costa Rica",
		"Cote d'Ivoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor (Timor Timur)",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Fiji",
		"Finland",
		"France",
		"Gabon",
		"Gambia, The",
		"Georgia",
		"Germany",
		"Ghana",
		"Greece",
		"Grenada",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Honduras",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran",
		"Iraq",
		"Ireland",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, North",
		"Korea, South",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Mauritania",
		"Mauritius",
		"Mexico",
		"Micronesia",
		"Moldova",
		"Monaco",
		"Mongolia",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepa",
		"Netherlands",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Poland",
		"Portugal",
		"Qatar",
		"Romania",
		"Russia",
		"Rwanda",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Vincent",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"Spain",
		"Sri Lanka",
		"Sudan",
		"Suriname",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syria",
		"Taiwan",
		"Tajikistan",
		"Tanzania",
		"Thailand",
		"Togo",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom",
		"United States",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City",
		"Venezuela",
		"Vietnam",
		"Yemen",
		"Zambia",
		"Zimbabwe"
	);