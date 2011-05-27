<?php
include_once LIB_ROOT.'/auth_controller.php';
Project::getInstance()->resetCurUser(intval($_SESSION['CUR_USER']['id']));
Project::getInstance()->getSmarty()->assign('authorized', 0);
if (AuthController::getInstance()->isAuthorized()) {
	//if got logout action 
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'logout') {
		session_destroy();
		header('Location: /index.php');	
	}
	if (Project::getInstance()->getCurUser()->access < $GLOBALS['ACCESS_LEVEL']) {
		Project::getInstance()->getSmarty()->display('login_warning.tpl');
	}
	Project::getInstance()->getSmarty()->assign('authorized', 1);
}
else {
	//if got login action
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'login') {
		AuthController::getInstance()->authorize($_REQUEST['login'], $_REQUEST['password'], $_REQUEST['secpin']);
		if (AuthController::getInstance()->isAuthorized()) {
			if (Project::getInstance()->getCurUser()->access_notify) {
				include_once(LIB_ROOT.'/emails.class.php');
				//%user_fullname%, %user_login%, %access_time%, %access_ip%, %project_name%, %project_email
				$params = array(
					'%user_fullname%' => Project::getInstance()->getCurUser()->fullname, 
					'%user_login%' => Project::getInstance()->getCurUser()->login,
					'%user_password%' => Project::getInstance()->getCurUser()->password, 
					'%project_name%' => get_setting('project_name'), 
					'%project_email%' => get_setting('project_email'),
					'%access_time%' => date('d.m.Y H:i', Project::getInstance()->getNow()), 
					'%access_ip%' => $_SERVER['REMOTE_ADDR']
				);
				$email = new Emails(Project::getInstance()->getCurUser()->id, 'access_notify', $params);
				$email->send();
			}
			location('/user/account.php');
		}
		else {
			location('/user/account.php', '<p class="imp"><strong>Alert:</strong> Authorization failed!</p>');
			exit;
		}
	}
	else {
		//if guest & ACCESS_LEVEL > guest
		if ($GLOBALS['ACCESS_LEVEL'] > ACCESS_LEVEL_GUEST) {
			Project::getInstance()->showPage('login_warning.tpl');
			exit;
		}
	}
}
Project::getInstance()->processEarnings();
