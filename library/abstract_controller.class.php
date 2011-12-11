<?php
/**
 * Created by JetBrains PhpStorm.
 * User: k.komarov
 * Date: 09.12.11
 * Time: 16:07
 */
abstract class AbstractController {

	protected $_action;
	protected $_parameters;
	protected $_breadcrumbs;
	/**
	 * @var View
	 */
	protected $_view;

	final protected function breadcrumbs(array $breadcrumbs) {

	}

	/**
	 * @param array $parameters
	 */
	public function __construct($action = 'Index', array $parameters = array()) {
		$this->_action = is_callable(array($this, 'action'.$action)) ? $action : 'Index';
		$this->_parameters = $parameters;
		$this->_view = new View();
	}

	/**
	 * @param string $name
	 * @return mixed|NULL
	 */
	final protected function getParam($name) {
		return isset($this->_parameters[$name]) ? $this->_parameters[$name] : NULL;
	}

	public function run() {
		$action_method = 'action'.$this->_action;
		if (method_exists($this, $action_method)) {
			$this->$action_method();
		}
	}

	protected function actionIndex() {

	}

	protected function getAction() {
		return $this->_action;
	}

}

?>
