<?php

/**
 * @property-read resource $db
 * @property-read Smarty $smarty
 * @property-read array $settings
 * @property-read integer $now
 * @property-read boolean $isGuest
 */
class App extends AbstractComponent {

	private static $_instance;
	private $_member, $_db, $_smarty, $_settings, $_now;

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
		return $this->_member;
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
			require_once(DOC_ROOT . '/library/mysql.php');
			$this->_db = mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD);
			if (!($this->_db && mysql_select_db(DB_NAME, $this->_db)))
				throw new Exception(mysql_error());
		}
		return $this->_db;
	}

	/**
	 *
	 * @return Smarty
	 */
	public function getSmarty() {
		if ($this->_smarty === null) {
			include_once(LIB_ROOT . '/Smarty/Smarty.class.php');
			$this->_smarty = new Smarty();
			$theme = get_setting('theme');
			$theme = !empty($theme) && file_exists(BASE_ROOT . '/themes/' . $theme . '/') ? get_setting('theme') : 'default';
			//$this->settings[17]['value'] = $theme;
			$this->_smarty->template_dir = BASE_ROOT . '/themes/' . $theme . '/';
			$this->_smarty->compile_dir = BASE_ROOT . '/templates_c/';
			$this->_smarty->config_dir = BASE_ROOT . '/configs/';
			$this->_smarty->cache_dir = BASE_ROOT . '/cache/';
			require_once(LIB_ROOT . '/functions/smarty-gettext.php');
			$this->_smarty->register_block('t', 'smarty_translate');
			$this->_smarty->assign('tpl_cfg', $GLOBALS['TPL_CFG']);
		}
		return $this->_smarty;
	}

	/**
	 * @todo Перенести в контроллер
	 * @param type $content
	 */
	public function showPage($content = '') {
		$this->smarty->assign('CONTENT', $this->smarty->fetch($content));
		$this->smarty->display('header.tpl');
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
}

?>
