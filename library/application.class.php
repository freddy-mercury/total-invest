<?php
require_once ROOT . '/library/abstract_component.class.php';

/**
 * @property array $config
 * @property PDO $db
 * @property Identity $identity
 * @property int $now
 */
class App extends AbstractComponent {

	const ROUTE_PARAMETER = 'r';
	private static $_instance;
	private $_config;
	private $_db;
	private $_identity;
	private $_now;

	final private function __construct($config) {
		$this->_config = $config;
		error_reporting(E_ALL ^ E_NOTICE);
		set_error_handler(array($this, 'errorHandler'));
		set_exception_handler(array($this, 'exceptionHandler'));
		spl_autoload_register(array($this, 'autoloader'));
		set_include_path(get_include_path() . PATH_SEPARATOR . ROOT . '/library');
		set_include_path(get_include_path() . PATH_SEPARATOR . ROOT . '/models');

		$this->_config['views_path'] = (isset($this->_config['views_path']) && file_exists($this->_config['views_path']))
			? $this->_config['views_path']
			: ROOT . '/views';

		session_start();
	}

	final private function __clone() {
	}

	/**
	 * @static
	 * @return App
	 */
	public static function get(array $config = array()) {
		if (!self::$_instance instanceof App) {
			$c = new App($config);
			self::$_instance = $c;
		}
		return self::$_instance;
	}

	public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
		$error = 'ERROR: ' . $errline . '#' . $errfile . ' &mdash; ' . $errstr
			. '<!--br><pre>' . print_r($errcontext, true) . '</pre-->';
		if ($errno !== E_NOTICE) {
			if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
				die($error);
			}
			else {
				mail('tmp@tmp.tmp', 'Error', $error);
			}
		}
		else {
			$GLOBALS['errors'][] = $error;
		}
	}

	public function exceptionHandler(Exception $exception) {
		$trace = $exception->getTrace();
		$get_trace = function($file, $line) {
			$trace = '';
			for ($i = -3; $i <= 3; $i++) {
				$trace .= ($i == -1 ? '<span style="color:red">' : '') . ($file[$line + $i] ? ($line + $i) . $file[$line + $i] : '') . ($i == -1 ? '</span>' : '');
			}
			return '<pre>' . $trace . '</pre>';
		};
		echo '<fieldset><legend>' . $exception->getMessage() . '</legend>' . $trace[0]['file'] . '<br>' . $get_trace(file($trace[0]['file']), $trace[0]['line']) . '</fieldset>';
	}

	public function autoloader($classname) {
		$segments = explode('\\', $classname);
		$classname = array_pop($segments);
		$words = array_map('strtolower',
			preg_split('/([[:upper:]][[:lower:]]+)/', $classname, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY));
		$classfile = implode('_', $words) . '.class.php';
		include_once $classfile;
	}

	public function getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}

		if (!empty($_SERVER['PATH_INFO'])) {
			return trim($_SERVER['PATH_INFO'], '/');
		}

		if (!empty($_SERVER['QUERY_STRING'])) {
			return trim($_SERVER['QUERY_STRING'], '/');
		}
	}

	/**
	 * @param $request
	 * @return AbstractController
	 */
	private function getRoutedController($request) {
		$segments = array_map('strtolower', explode('/', $request['path']));
		if (($module = array_shift($segments)) && in_array($module, $this->_config['modules'])) {
			set_include_path(get_include_path() . PATH_SEPARATOR . ROOT . '/modules/' . $module . '/controllers');
			$module = ucfirst($module);
		}
		else {
			$module = '';
			set_include_path(get_include_path() . PATH_SEPARATOR . ROOT . '/controllers');
		}
		$controller = ucfirst((($controller = array_shift($segments)) ? $controller : 'Index') . 'Controller');
		$action = ucfirst((($action = array_shift($segments)) ? $action : 'Index'));
		$classname = $module . '\\' . $controller;
		return new $classname($action, $_REQUEST);
	}

	public function run() {
		$request = parse_url($this->getURI());
		$controller = $this->getRoutedController($request);
		$controller->run();
	}

	public function getConfig() {
		return $this->_config;
	}

	/**
	 * @return PDO
	 */
	public function getDb() {
		if ($this->_db === null) {
			$this->_db = new PDO('mysql:host=localhost;dbname=' . $this->_config['db']['database'], $this->_config['db']['user'], $this->_config['db']['password']);
		}
		return $this->_db;
	}

	/**
	 * @return Identity
	 */
	public function getIdentity() {
		if ($this->_identity === null) {
			$this->_identity = new Identity();
		}
		return $this->_identity;
	}

	public function getNow() {
		if ($this->_now === null) {
			$this->_now = time();
		}
		return $this->_now;
	}

}
