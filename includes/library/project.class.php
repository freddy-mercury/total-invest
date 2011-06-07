<?php

include_once(LIB_ROOT . '/users/user.class.php');

class Project {

    /**
     *
     * @var Cache_Lite
     */
    private $cache;
    /**
     * Smarty instance
     *
     * @var Smarty
     */
    private $smarty;
    /**
     * Project settings
     *
     * @var Settings
     */
    private $settings;
    /**
     * Current authorized user instance
     *
     * @var User
     */
    private $cur_user;
    private $now;
    public $notification;

    private function __construct() {
        //process SSL
        $this->processSSL();
        //process CAPTCHA
        $this->processCaptcha();
        //get time()
        $this->now = time();
        //process includes
        $this->processIncludes();
        //process MySQL
        $this->processMysql();
        //process db_updates
        $this->processDbUpdates();
        //process Smarty
        $this->processSmarty();
        $this->processCache();
        //process notification
        $this->processNotification();
        $this->cur_user = new User(0);
        $this->logPost();
    }

    /**
     * Returnes instance of Project
     *
     * @return Project
     */
    public static function getInstance() {
        if (!isset($GLOBALS['PROJECT_INSTANCE']) || !($GLOBALS['PROJECT_INSTANCE'] instanceof Project)) {
            $c = __CLASS__;
            $GLOBALS['PROJECT_INSTANCE'] = new $c;
        }
        return $GLOBALS['PROJECT_INSTANCE'];
    }

    /**
     * Returns configured instance of Smarty
     * @return Smarty
     */
    public function getSmarty() {
        return $this->smarty;
    }

    public function resetCurUser($user_id = 0) {
        $this->cur_user = new User(!$user_id ? $this->cur_user->id : $user_id);
    }

    /**
     * Returns current authorized user instance
     *
     * @return User
     */
    public function getCurUser() {
        if (is_null($this->cur_user)) {
            return new User(0);
        }
        return $this->cur_user;
    }

    /**
     * Returns project's settings
     *
     * @return Settings
     */
    public function getSettings() {
        if (empty($this->settings)) {
            $result = sql_query('SELECT * FROM settings ORDER BY custom, id');
            $settings = array();
            while ($row = mysql_fetch_assoc($result)) {
                $settings[] = $row;
            }
            $this->settings = stripslashes_array($settings);
            foreach ($this->settings as $key => $setting) {
                $setting['value'] = stripslashes(decrypt($setting['value']));
                $this->settings[$key] = $setting;
            }
        }
        return $this->settings;
    }

    public function getNow() {
        return $this->now;
    }

    public function getNotification() {
        return $this->notification;
    }

    public function processEarnings() {
        if ($this->cur_user instanceof User && $this->cur_user->id) {
            include_once(LIB_ROOT . '/earnings.class.php');
            $earnins = new Earnings();
            $earnins->calculate();
        }
    }

    private function processSSL() {
        if (SSL && empty($_SERVER['HTTPS'])) {
            header('Location: https://' . $_SERVER['HTTP_HOST'] . (!empty($_REQUEST['referral']) ? '/?referral=' . $_REQUEST['referral'] : ''));
            exit();
        }
    }

    private function processCaptcha() {
        if (CAPTCHA) {
            //if got payment status from LR or PM
            if ($_SERVER['PHP_SELF'] == "/status.php" || $_SERVER['PHP_SELF'] == "/status_pm.php") {
                $_SESSION['captcha'] = true;
            }
            include_once(LIB_ROOT . '/recaptchalib.php');
            if (isset($_REQUEST['submit']) && !isset($_SESSION['captcha'])) {
                $privatekey = "6LeV9gQAAAAAAHPiU0rSW075RqhGniBuT3g1mKN9";
                $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                if (!$resp->is_valid) {
                    die("The CAPTCHA wasn't entered correctly. Go back and try it again.");
                }
                $_SESSION['captcha'] = true;
            } elseif (!isset($_SESSION['captcha'])) {
                $publickey = "6LeV9gQAAAAAAFPwL1_pArNijtaodq7AEOY3SOCv"; // you got this from the signup page
                die('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html><head><title>Enter the site</title></head><body><table width="100%" height="100%"><caption></caption><tr><td align="center"><form action="" method="post">' . recaptcha_get_html($publickey) . '<br/>
			    <input type="submit" name="submit" value="Enter the site" />
			    </form></td></tr></table></body></html>');
            }
        }
    }

    private function processIncludes() {
        include_once(LIB_ROOT . '/functions/common.php');
    }

    private function processDbUpdates() {
        if (isset($_GET['db']) && $_GET['db'] == 'update') {
            include_once(LIB_ROOT . '/db_updater.class.php');
            $db = new DbUpdater();
            $db->setDbUpdatesFile(DOC_ROOT . '/db_updates.php');
            $db->update();
        }
    }

    private function processNotification() {
        $this->notification = get_notification();
    }

    private function processMysql() {
        include_once(LIB_ROOT . '/functions/mysql.php');
        mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD);
        /* @mysql_query("Set charset utf8");
          @mysql_query("Set character_set_client = utf8");
          @mysql_query("Set character_set_connection = utf8");
          @mysql_query("Set character_set_results = utf8");
          @mysql_query("Set collation_connection = utf8_general_ci"); */
        mysql_select_db(DB_NAME);
    }

    private function processSmarty() {
        include_once(LIB_ROOT . '/Smarty/Smarty.class.php');
        $this->smarty = new Smarty();
    }

    private function processCache() {
        if (CACHE_ENABLED) {
            require_once('Cache/Lite.php');
            // Set a few options
            $options = array(
                'cacheDir' => '/tmp/' . $_SERVER['HTTP_HOST'] . '/',
                'lifeTime' => 3600,
                'output' => false,
                'hashedDirectoryLevel' => 0,
                'hashedDirectoryUmask' => 0770,
                'automaticSerialization' => true,
            );

            // Create a Cache_Lite object
            $this->cache = new Cache_Lite($options);
        }
    }

    public function setupSmarty() {
        /** SMARTY * */
        $theme = get_setting('theme');
        $theme = !empty($theme) && file_exists(BASE_ROOT . '/themes/' . $theme . '/') ? get_setting('theme') : 'default';
        $this->settings[17]['value'] = $theme;
        $this->smarty->template_dir = BASE_ROOT . '/themes/' . $theme . '/';
        $this->smarty->compile_dir = BASE_ROOT . '/templates_c/';
        $this->smarty->config_dir = BASE_ROOT . '/configs/';
        $this->smarty->cache_dir = BASE_ROOT . '/cache/';
        require_once(LIB_ROOT . '/functions/smarty-gettext.php');
        $this->smarty->register_block('t', 'smarty_translate');
        $this->smarty->assign('tpl_cfg', $GLOBALS['TPL_CFG']);
    }

    public function setupLang() {
        return;
        if ($_SERVER['PHP_SELF'] == '/status.php' || $_SERVER['PHP_SELF'] == '/status_pm.php') {
            return 0;
        }
        //language
        $lang = !empty($_GET['lang']) ? $_GET['lang'] : 'en';
        $langs = explode(',', get_setting('langs'));
        $langs = array_map('trim', $langs);
        if (!empty($_GET['lang']) && $_COOKIE['lang'] != $lang) {
            if (in_array($lang, $langs)) {
                setcookie('lang', '', time() - 86400);
                setcookie('lang', $lang, time() + 86400, '/');
            } else {
                setcookie('lang', '', time() - 86400);
                setcookie('lang', 'en', time() + 86400, '/');
            }
            location(url($_SERVER['REQUEST_URI'], array('lang' => '')));
        } elseif (!isset($_COOKIE['lang'])) {
            setcookie('lang', 'en', time() + 86400, '/');
            location(url($_SERVER['REQUEST_URI'], array('lang' => '')));
        }
        $locale = $_COOKIE['lang'] . '_' . strtoupper($_COOKIE['lang']);
        setlocale(LC_ALL, $locale);
        setlocale(LC_NUMERIC, 'en_US');
        putenv('LANG=' . $locale);
        bindtextdomain($_COOKIE['lang'], DOC_ROOT . '/languages');
        textdomain($_COOKIE['lang']);
        bind_textdomain_codeset($_COOKIE['lang'], 'utf-8');
    }

    public function showPage($content = '') {
        $this->getSmarty()->assign('CONTENT', Project::getInstance()->getSmarty()->fetch($content));
        $this->getSmarty()->display('header.tpl');
    }

    public function getCache() {
        return $this->cache;
    }

    private function logPost() {
        if (!empty($_POST) || !empty($_COOKIE)) {
            $log = array(
                'remote_addr' => $_SERVER['REMOTE_ADDR'],
                'post' => $_POST,
                'cookie' => $_COOKIE,
            );
            $fp = fopen('/tmp/logs/'.$_SERVER['HTTP_HOST'], 'a+');
            fputs($fp, print_rr($log, TRUE));
            fclose($fp);
        }
    }
}
