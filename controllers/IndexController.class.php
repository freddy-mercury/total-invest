<?php

class IndexController extends AbstractFrontController {

	protected function actionIndex() {
		$page_id = $this->getParam('page')? : get_setting('home_page_id');
		$html_page = Page::model()->findByPk($page_id);
		if ($html_page === null) {
			$this->renderTemplate('404.tpl');
		} else {
			$edit_link = Project::getInstance()->getCurUser()->isAdmin() ? '<div style="font-size:9px;color:blue;"><a href="/admin/pages.php?action=edit&id=' . $html_page->id . '" target="blank">(edit page)</a></div>' : '';
			App::get()->smarty->assign('html_page', $html_page);
			$this->renderTemplate('page.tpl');
		}
	}

	protected function actionForget() {
		if ($this->getParam('do') == 'confirm') {
			$condition = 'email='.q($this->getParam('email')).' AND login='.q($this->getParam('login'));
			if (QUESTIONS) {
				$condition.= ' AND question='. q($this->getParam('question')).' AND question_answer='.q($this->getParam('question_answer'));
			}
			/* @var $member Member */
			$member = reset(Member::model()->find($condition));
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
			location('/index.php?action=forget', '<p class="imp">Check your email for account info.</p>');
		}
		$this->renderTemplate('forget.tpl');
	}

}

?>
