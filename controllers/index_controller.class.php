<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Asus
 * Date: 10.12.11
 * Time: 15:49
 * To change this template use File | Settings | File Templates.
 */
class IndexController extends AbstractController {
	protected function actionIndex() {
		$page = HtmlPage::model()->findByPk(array('lang'    => 'en',
												  'keyword' => 'home'));
		$this->_view->render('index', array('page' => $page));
	}

	protected function actionLogin() {
		$login_form = new LoginForm();
		if (isset($_POST['Login'])) {
			$login_form->setAttributes($_POST['Login']);
			if ($login_form->validate()) {
				//@TODO checking identity
			}
		}
		$this->_view->render('login', array('login_form' => $login_form, 'post' => $_POST));
	}
}
