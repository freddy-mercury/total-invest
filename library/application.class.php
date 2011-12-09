<?php
/**
 * User: k.komarov
 * Date: 09.12.11
 * Time: 16:28
 * @package application.class.php
 */
class Application {
	const ROUTE_PARAMETER = 'r';

	/**
	 * @return AbstractFrontController
	 */
	private function getController() {
		if (isset($_REQUEST[self::ROUTE_PARAMETER]) && ($r = $_REQUEST[self::ROUTE_PARAMETER])) {
			$route = explode('/', $r, 3);
			switch (count($route)) {
				case 1:
					return new DefaultController();
					break;
				case 2:

					break;
				case 3:

					break;
			}
		}
		return '';
	}

	public function run() {
		$this->getController()->run();
	}
}
