<?php

class IndexController extends AbstractFrontController {

	protected function actionIndex() {
		$page_id = $this->getParam('page')? : get_setting('home_page_id');
		$html_page = Page::model()->findByPk($page_id);
		if ($html_page === null)
			$this->_view->render('404');
		else {
			$edit_link = Project::getInstance()->getCurUser()->isAdmin() ? '<div style="font-size:9px;color:blue;"><a href="/admin/pages.php?action=edit&id=' . $html_page->id . '" target="blank">(edit page)</a></div>' : '';
			$this->_view->render('index', array('page' => $html_page));
		}
	}

	protected function actionForget() {
		$forget_password_form = new ForgetPasswordForm();
		if ($this->getParam('do') == 'confirm') {
			$forget_password_form->setAttributes($_POST);
			if ($forget_password_form->validate()) {
				$forget_password_form->remind();
			}
			location('/index.php?action=forget', 'Check your email for account info.', 'success');
		}
		$this->_view->render('forget', array('model' => $forget_password_form));
	}

	protected function actionSuccess() {
		$this->_view->render('success');
	}

	protected function actionFail() {
		$this->_view->render('fail');
	}

	protected function actionLogin() {
		if (!App::get()->isGuest) {
			$this->actionIndex();
		}
		$login_form = new LoginForm();
		if ($this->getParam('do') == 'authorize') {
			$_POST['captcha_challenge'] = $_POST['recaptcha_challenge_field'];
			$_POST['captcha'] = $_POST['recaptcha_response_field'];
			$login_form->setAttributes($_POST);
			if ($login_form->validate()) {
				location('/member.php');
			}
		}
		$this->_view->render('login', array('model' => $login_form));
	}

	protected function actionLogout() {
		$identity = new Identity;
		$identity->logout();
		location('/index.php');
	}

	protected function actionContactus() {
		$contact_us_form = new ContactUsForm();
		if ($this->getParam('do') == 'send') {
			$_POST['captcha_challenge'] = $_POST['recaptcha_challenge_field'];
			$_POST['captcha'] = $_POST['recaptcha_response_field'];
			$contact_us_form->setAttributes($_POST);
			if ($contact_us_form->validate()) {
				//@todo Реализовать правильную отсылку писем!
				location('/index.php?action=contactus', 'Thank you for contacting us! You will get response in 24 hours.', 'success');
			}
		}
		$this->_view->render('contactus', array('model' => $contact_us_form));
	}

	protected function actionRegister() {
		$register_form = new RegisterForm();
		if ($this->getParam('do') == 'confirm') {
			$register_form->setAttributes($_POST);
			if ($register_form->validate())
				location ('/index.php?action=signup', 'You have registered a member account.', 'success');
		}
		$this->_view->render('register', array('model'=>$register_form));
	}
}

?>
