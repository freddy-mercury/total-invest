<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Asus
 * Date: 10.12.11
 * Time: 15:49
 * To change this template use File | Settings | File Templates.
 */
namespace Administrator;
class IndexController extends \AbstractController {
	protected function actionIndex() {
		$this->_view->render('admin/index');
	}

}
