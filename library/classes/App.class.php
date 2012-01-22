<?php

/**
 * @property-read resource $db
 * @property-read array $settings
 * @property-read integer $now
 * @property-read boolean $isGuest
 * @property-read Member $member
 * @property-read string $base_url
 */
class App extends AbstractComponent {

	private static $_instance;
	private $_db, $_settings, $_now;

	private function __construct() {

	}

	/**
	 *
	 * @return App
	 */
	public static function get() {
		$classname = __CLASS__;
		if (self::$_instance === null || !(self::$_instance instanceof $classname)) {
			self::$_instance = new $classname;
		}
		return self::$_instance;
	}

	public function setMember() {

	}

	/**
	 * @return Member
	 */
	public function getMember() {
		$idenity = new Identity();
		return $idenity->member;
	}

	/**
	 * @return boolean
	 */
	public function getIsGuest() {
		$idenity = new Identity();
		return $idenity->isGuest;
	}

	public function getDb() {
		if ($this->_db === null) {
			$this->_db = mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD);
			if (!($this->_db && mysql_select_db(DB_NAME, $this->_db)))
				throw new Exception(mysql_error());
		}
		return $this->_db;
	}

	public function getSettings() {
		if ($this->_settings === null) {
			$this->_settings = array();
			/* @var $value Setting */
			foreach (Setting::model()->findAll() as $value) {
				$this->_settings[$value->name] = $value->value;
			}
		}
		return $this->_settings;
	}

	public function getNow() {
		if ($this->_now === null) {
			$this->_now = time();
		}
		return $this->_now;
	}

	public function getBaseUrl() {
		return 'http'.($_SERVER['HTTPS'] ? 's' : '').'://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
	}
}

?>
