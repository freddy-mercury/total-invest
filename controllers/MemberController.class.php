<?php

class MemberController extends AbstractFrontController {
	protected function actionIndex() {
		$this->_view->render('member/index');
	}
}

?>
