<?php

class IndexController extends AbstractFrontController {

	protected function actionIndex() {
		$page_id = $this->getParam('page')? : get_setting('home_page_id');
		$html_page = Page::model()->findByPk($page_id);
		if ($html_page === null)
			$this->_view->render ('404');
		else {
			$edit_link = Project::getInstance()->getCurUser()->isAdmin() ? '<div style="font-size:9px;color:blue;"><a href="/admin/pages.php?action=edit&id=' . $html_page->id . '" target="blank">(edit page)</a></div>' : '';
			$this->_view->render('index', array('page' => $html_page));
		}
	}

	protected function actionForget() {
		if ($this->getParam('do') == 'confirm') {
			$condition = 'email='.q($this->getParam('email')).' AND login='.q($this->getParam('login'));
			if (QUESTIONS) {
				$condition.= ' AND question='. q($this->getParam('question')).' AND question_answer='.q($this->getParam('question_answer'));
			}
			/* @var $member Member */
			$members = Member::model()->find($condition);
			$member = reset($members);
			if ($member !== null && $member->login != 'admin') {
				$params = array(
					'%user_fullname%' => $member->fullname,
					'%user_login%' => $member->login,
					'%user_password%' => $member->password,
					'%user_secpin%' => $member->secpin,
					'%user_masterpin%' => $member->masterpin,
					'%project_name%' => get_setting('project_name'),
					'%project_email%' => get_setting('project_email')
				);
				include_once(LIB_ROOT.'/emails.class.php');
				$email = new Emails($member->id, 'forget_email', $params);
				$email->send();
			}
			location('/index.php?action=forget', 'Check your email for account info.', 'success');
		}
		$this->_view->render('forget');
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
		if ($this->getParam('do') == 'authorize') {
			$identity = new Identity();
			if ($identity->login($this->getParam('login'), $this->getParam('password'), $this->getParam('secpin'), (bool)$this->getParam('remember'))) {
				location('/member.php');
			}
			location('/index.php?action=login', 'Invalid login or password.');
		}
		$this->_view->render('login');
	}

	protected function actionLogout() {
		$identity = new Identity;
		$identity->logout();
		location('/index.php');
	}
}

?>
