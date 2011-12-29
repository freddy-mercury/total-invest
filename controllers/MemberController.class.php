<?php

class MemberController extends AbstractFrontController {

	/**
	 *
	 * @var Member
	 */
	protected $_member;
	private $_menu;

	protected function init() {
		$this->_view->setLayout('layouts/columns2');
		$this->_member = App::get()->member;
		$this->_menu = array(
			'/member.php' => 'Summary',
			'/member.php?action=deposit' => 'Make deposit',
			'/member.php?action=withdrawal' => 'Request withdrawal',
			'/member.php?action=history' => 'History',
			'/member.php?action=messages' => 'Messages ('.count($this->_member->messages).')',
			'/member.php?action=promote' => 'Promote yourself',
			'/member.php?action=profile' => 'Profile',
		);
	}

	protected function actionIndex() {
		$this->_view->render('member/index', array('member' => App::get()->member));
	}

	protected function getMenu() {
		$items = array();
		foreach ($this->_menu as $link => $item) {
			$items[] = '<li><a href="' . $link . '">' . htmlspecialchars($item) . '</a></li>';
		}
		return '<ul>' . implode('', $items) . '</ul>';
	}

	public function actionProfile() {
		$profile_form = new ProfileForm($this->_member);
		if ($this->getParam('do') == 'confirm') {
			$profile_form->setAttributes($_POST);
			if ($profile_form->validate()) {
				$this->_member->setAttributes($profile_form->getAttributes());
				if ($this->_member->save())
					location('/member.php?action=profile', 'Profile has been saved!', 'success');
			}
		}
		$this->_view->render('member/profile', array('model' => $profile_form));
	}

	public function actionPromote() {
		$this->_view->render('member/promote', array('model' => $this->_member));
	}

	public function actionMessages() {
		$this->_view->render('member/messages', array('messages' => $this->_member->messages));
	}

}

?>
