<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Asus
 * Date: 10.12.11
 * Time: 16:20
 * To change this template use File | Settings | File Templates.
 */

class View {
	private $_layout;
	private $_views_path;

	public function __construct() {
		$this->_views_path = App::get()->config['views_path'];
		$this->_layout = 'layout';
	}

	function fetchPartial($template, $params = array()) {
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
		return $this->fetchPartial($this->_layout, array('content' => $content));
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
