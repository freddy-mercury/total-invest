<?php
/**
 * Created by JetBrains PhpStorm.
 * User: k.komarov
 * Date: 09.12.11
 * Time: 16:07
 */
abstract class AbstractFrontController {

	protected $parameters;
	protected $breadcrumbs;

	/**
	 * @return string
	 */
	protected function actionParameterName() {
		return 'action';
	}

	final protected function setPageHeader($page_header) {

	}

	final protected function setBreadcrumbs(array $breadcrumbs) {

	}

	/**
	 * @param array|NULL $parameters
	 */
	public function __construct($parameters = NULL) {
		$this->parameters = is_null($parameters) ? (array) $_REQUEST : (array) $parameters;
		$this->init();
	}

	protected function init() {
	}

	/**
	 * Default action method
	 */
	protected function actionDefault() {

	}

	/**
	 * @return string
	 */
	final protected function getAction() {
		return isset($this->parameters[$this->actionParameterName()]) && !empty($this->parameters[$this->actionParameterName()]) ? $this->parameters[$this->actionParameterName()] : 'Default';
	}

	/**
	 * @return string
	 */
	final protected function getActionMethod() {
		$words = explode('_', strtolower($this->getAction()));
		return 'action' . implode('', array_map('ucfirst', $words));
	}

	final protected function getActionUrl($action = '', $parameters = array()) {
		$parameters[$this->actionParameterName()] = $action ?: ($this->getAction() === 'Default' ? '' : $this->getAction()) ;
		return replace_uri_parameter($_SERVER['PHP_SELF'], $parameters);
	}

	/**
	 * @param string $name
	 * @return mixed|NULL
	 */
	final protected function getParam($name) {
		return isset($this->parameters[$name]) ? $this->parameters[$name] : NULL;
	}

	public function run() {
		if ($this->getAction() && method_exists($this, $this->getActionMethod())) {
			$action_method = $this->getActionMethod();
			$this->$action_method();
			$this->renderPage();
		} else {
			$this->renderError(404);
		}
	}

	protected function renderPage() {
	}

	protected function renderError($code = 404) {
		switch ($code) {

		}
	}

}

?>
