<?php
/**
 * User: k.komarov
 * Date: 09.12.11
 * Time: 16:28
 * @package application.class.php
 */
class App {
	const ROUTE_PARAMETER = 'r';
	private static $_instance;
	public $config;
	private $_db;

	final private function __construct($config) {
		$this->config = $config;
		error_reporting(E_ALL ^ E_NOTICE);
		set_error_handler(array($this, 'errorHandler'));
		set_exception_handler(array($this, 'exceptionHandler'));
		spl_autoload_register(array($this, 'autoloader'));
		set_include_path(get_include_path() . PATH_SEPARATOR . ROOT . '/library');
		set_include_path(get_include_path() . PATH_SEPARATOR . ROOT . '/models');
		$this->config['views_path'] = (isset($this->config['views_path']) && file_exists($this->config['views_path']))
			? $this->config['views_path']
			: ROOT . '/views';
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
		$error = $errline.'#'.$errfile.'-'.$errstr . '<!--br><pre>' . print_r($errcontext, true) . '</pre-->';
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
		die($exception->getLine() . '#' . $exception->getFile() . '-' . $exception->getMessage() . '<!--br><pre>' . print_r($exception->getTrace(), true) . '</pre-->');
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
		if (($module = array_shift($segments)) && in_array($module, $this->config['modules'])) {
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

	/**
	 * @return PDO
	 */
	public function getDb() {
		if ($this->_db === null) {
			$this->_db = new PDO('mysql:host=localhost;dbname=' . $this->config['db']['database'], $this->config['db']['user'], $this->config['db']['password']);
		}
		return $this->_db;
	}
}
