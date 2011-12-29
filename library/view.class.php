<?php

class View {

	private $_layout;
	private $_views_path;
	private $_controller;

	public function __construct($controller = null) {
		$this->_controller = $controller;
		$this->_views_path = DOC_ROOT . '/views';
		$this->_layout = 'layouts/columns1';
	}

	function fetchPartial($template, $params = array()) {
		$params['controller'] = $this->_controller;
		extract($params);
		ob_start();
		require $this->_views_path . '/' . $template . '.php';
		return ob_get_clean();
	}

	function renderPartial($template, $params = array()) {
		echo $this->fetchPartial($template, $params);
	}

	function fetch($template, $params = array()) {
		$content = $this->fetchPartial($template, $params);
		return $this->fetchPartial('layouts/layout', array('content' => $this->fetchPartial($this->_layout, array('content' => $content))));
	}

	function render($template, $params = array()) {
		echo $this->fetch($template, $params);
	}

	public function setViewsPath($views_path) {
		$this->_views_path = $views_path;
	}

	public function setLayout($layout) {
		$this->_layout = $layout;
	}

}
