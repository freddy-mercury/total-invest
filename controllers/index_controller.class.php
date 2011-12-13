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
		$page = HtmlPage::model()->findByPk(array('lang' => 'en', 'keyword' => 'home'));
		$this->_view->render('index', array('page' => $page));
	}

	protected function actionLogin() {
		if (!App::get()->identity->isGuest()) {
			$this->redirect('/index');
		}
		$login_form = new LoginForm();
		if (isset($_POST['Login'])) {
			$login_form->setAttributes($_POST['Login']);
			$login_form->setAttributes(array('recaptcha_challenge_field' => $_POST['recaptcha_challenge_field'], 'recaptcha_response_field' => $_POST['recaptcha_response_field']));
			if ($login_form->validate()) {
				$this->redirect('/index/index/login');
			}
		}
		$this->_view->render('login', array('login_form' => $login_form, 'post' => $_POST));
	}

	protected function actionLogout() {
		App::get()->identity->logout();
		$this->redirect('/index/index/login');
	}
}
