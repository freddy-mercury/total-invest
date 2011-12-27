<?php

//include_once LIB_ROOT.'/auth_controller.php';
//Project::getInstance()->resetCurUser(intval($_SESSION['CUR_USER']['id']));
//Project::getInstance()->logPost();
//App::get()->smarty->assign('authorized', 0);
//if (AuthController::getInstance()->isAuthorized()) {
//	//if got logout action
//	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'logout') {
//		session_destroy();
//		header('Location: /index.php');
//	}
//	//if got pin action
//	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'pin') {
//		$last_visit = sql_row('SELECT INET_NTOA(ip) as ip, stamp, user_id FROM visits WHERE user_id="'.Project::getInstance()->getCurUser()->id.'" ORDER BY stamp DESC LIMIT 1');
//		if ($_REQUEST['pin'] == get_auth_pin($last_visit['stamp'])) {
//			include_once(LIB_ROOT.'/users/ip_controller.class.php');
//			$ip_ctrl = new IpController(Project::getInstance()->getCurUser()->id);
//			$ip_ctrl->saveIp();
//		}
//	}
//	if (Project::getInstance()->getCurUser()->isAdmin()) {
//		$last_visit = sql_row('SELECT INET_NTOA(ip) as ip, stamp, user_id FROM visits WHERE user_id="'.Project::getInstance()->getCurUser()->id.'" ORDER BY stamp DESC LIMIT 1');
//		if ($last_visit['ip'] != $_SERVER['REMOTE_ADDR']) {
//			mail(get_setting('project_email'), 'Auth PIN', get_auth_pin($last_visit['stamp']));
//			App::get()->showPage('pin_warning.tpl');
//			exit;
//		}
//	}
//	if (Project::getInstance()->getCurUser()->access < $GLOBALS['ACCESS_LEVEL']) {
//		App::get()->showPage('login_warning.tpl');
//		exit();
//	}
//	App::get()->smarty->assign('authorized', 1);
//}
//else {
//	//if got login action
//	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'login') {
//		AuthController::getInstance()->authorize($_REQUEST['login'], $_REQUEST['password'], $_REQUEST['secpin']);
//		if (AuthController::getInstance()->isAuthorized()) {
//			if (Project::getInstance()->getCurUser()->access_notify) {
//				include_once(LIB_ROOT.'/emails.class.php');
//				//%user_fullname%, %user_login%, %access_time%, %access_ip%, %project_name%, %project_email
//				$params = array(
//					'%user_fullname%' => Project::getInstance()->getCurUser()->fullname,
//					'%user_login%' => Project::getInstance()->getCurUser()->login,
//					'%user_password%' => Project::getInstance()->getCurUser()->password,
//					'%project_name%' => get_setting('project_name'),
//					'%project_email%' => get_setting('project_email'),
//					'%access_time%' => date('d.m.Y H:i', Project::getInstance()->getNow()),
//					'%access_ip%' => $_SERVER['REMOTE_ADDR']
//				);
//				$email = new Emails(Project::getInstance()->getCurUser()->id, 'access_notify', $params);
//				$email->send();
//			}
//			if (Project::getInstance()->getCurUser()->isAdmin()) {
//				$last_visit = sql_row('SELECT INET_NTOA(ip) as ip, stamp, user_id FROM visits WHERE user_id="'.Project::getInstance()->getCurUser()->id.'" ORDER BY stamp DESC LIMIT 1');
//				if ($last_visit != $_SERVER['REMOTE_ADDR']) {
//					mail(get_setting('project_email'), 'Auth PIN', get_auth_pin($last_visit['stamp']));
//					App::get()->showPage('pin_warning.tpl');
//					exit;
//				}
//			}
//			include_once(LIB_ROOT.'/users/ip_controller.class.php');
//			$ip_ctrl = new IpController(Project::getInstance()->getCurUser()->id);
//			$ip_ctrl->saveIp();
//			location('/user/account.php');
//		}
//		else {
//			location('/user/account.php', '<p class="imp"><strong>Alert:</strong> Authorization failed!</p>');
//			exit;
//		}
//	}
//	//if got pin action
//	elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'pin') {
//		$last_visit = sql_row('SELECT INET_NTOA(ip) as ip, stamp, user_id FROM visits WHERE user_id="'.Project::getInstance()->getCurUser()->id.'" ORDER BY stamp DESC LIMIT 1');
//		if ($_REQUEST['pin'] == get_auth_pin($last_visit['stamp'])) {
//			include_once(LIB_ROOT.'/users/ip_controller.class.php');
//			$ip_ctrl = new IpController(Project::getInstance()->getCurUser()->id);
//			$ip_ctrl->saveIp();
//			location('/user/account.php');
//		}
//	}
//	else {
//		//if guest & ACCESS_LEVEL > guest
//		if ($GLOBALS['ACCESS_LEVEL'] > ACCESS_LEVEL_GUEST) {
//			App::get()->showPage('login_warning.tpl');
//			exit;
//		}
//	}
//}
//Project::getInstance()->processEarnings();
//
//function get_auth_pin($stamp) {
//	if (empty ($stamp)) {
//		return '';
//	}
//	return substr($stamp, 0, 3) . '-' . substr($stamp, 6, 3);
//}