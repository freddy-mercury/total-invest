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
        //get time()
        $this->now = time();
        //process includes
        $this->processIncludes();
        //process Smarty
        $this->processCache();
        //process notification
        $this->processNotification();
        $this->cur_user = new User(0);
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

    private function processIncludes() {
        include_once(LIB_ROOT . '/functions/common.php');
    }

    private function processNotification() {
        $this->notification = get_notification();
    }

    private function processCache() {
        if (CACHE_ENABLED) {
			$cache_dir = '/tmp/' . strtolower($_SERVER['HTTP_HOST']) . '/';
			if (!file_exists($cache_dir)) {
				mkdir($cache_dir, 0755);
			}
            require_once('Cache/Lite.php');
            // Set a few options
            $options = array(
                'cacheDir' => $cache_dir,
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

    public function getCache() {
        return $this->cache;
    }

    public function logPost() {
        if (!empty($_POST) || !empty($_COOKIE)) {
            $log = array(
		'timestamp' => $this->getNow(),
		'date' => date('d.m.Y H:i:s', $this->getNow()),
                'remote_addr' => $_SERVER['REMOTE_ADDR'],
                'request_uri' => $_SERVER['REQUEST_URI'],
                'user' => $this->getCurUser()->login,
                'post' => $_POST,
                'cookie' => $_COOKIE,
            );
            $fp = fopen('/tmp/logs/'.$_SERVER['HTTP_HOST'], 'a+');
            fputs($fp, print_rr($log, TRUE) . "\n");
            fclose($fp);
        }
    }
}
