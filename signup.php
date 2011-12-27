<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;
include_once(DOC_ROOT.'/includes/authorization.php');
$_POST = sql_escapeArray($_POST);
if (isset($_REQUEST['action']) && $_REQUEST['action']=='signup') {
	$valid = true;
	if (empty($_POST['fullname']) && $valid) {
		App::get()->smarty->assign('error_message', 'Fullname is empty!');
		$valid = false;
	}
	if (!preg_match('/^[A-z]{1}[0-9A-z]{2,}/', $_POST['login']) && $valid) {
		App::get()->smarty->assign('error_message', 'Invalid login!');
		$valid = false;
	}
	if (User::loginExist($_POST['login']) && $valid) {
		App::get()->smarty->assign('error_message', 'This login is already in use!');
		$valid = false;
	}
	if (!check_pass($_POST['password'], 6) && $valid) {
		App::get()->smarty->assign('error_message', 'Password is very simple!');
		$valid = false;
	}
	if ($_POST['password']!=$_POST['repassword'] && $valid) {
		App::get()->smarty->assign('error_message', 'Passwords doesn\'t match!');
		$valid = false;
	}
	if (LOGIN_PIN && !preg_match('/\d{'.$GLOBALS['TPL_CFG']['login_pin']['length'].'}/', $_POST['secpin_signup']) && $valid) {
		App::get()->smarty->assign('error_message', 'Not valid Login pin!');
		$valid = false;
	}
	if (MASTER_PIN && !preg_match('/\d{'.$GLOBALS['TPL_CFG']['master_pin']['length'].'}/', $_POST['masterpin_signup']) && $valid) {
		App::get()->smarty->assign('error_message', 'Not valid Security pin!');
		$valid = false;
	}
	if (QUESTIONS && empty($_POST['question_answer']) && $valid) {
		App::get()->smarty->assign('error_message', 'Answer is empty!');
		$valid = false;
	}
	if ((!check_email($_POST['email']) || User::emailExist($_POST['email'])) && $valid) {
		App::get()->smarty->assign('error_message', 'Invalid e-mail address or this email is already used!');
		$valid = false;
	}
	if (empty($_POST['payment_system']) && $valid) {
		App::get()->smarty->assign('error_message', 'Invalid payment system!');
		$valid = false;
	}
	/**
	 * LR
	 */
	if (empty($_POST['pm_member_id']) && $_POST['payment_system'] == 'LR') {
		if (!ereg("^(U|X)[0-9]{1,}$", $_POST['account']) && $valid) {
			App::get()->smarty->assign('error_message', 'Invalid LR account number!');
			$valid = false;
		}
	}
	/**
	 * PM
	 */
	elseif ($_POST['payment_system'] == 'PM') {
		if (!ereg("^[0-9]{1,}$", $_POST['pm_member_id']) && $valid) {
			App::get()->smarty->assign('error_message', 'Invalid PM member ID!');
			$valid = false;
		}
		if (!ereg("^(U|X)[0-9]{1,}$", $_POST['account']) && $valid) {
			App::get()->smarty->assign('error_message', 'Invalid PM account number!');
			$valid = false;
		}
	}
	if (empty($_POST['terms']) && $valid) {
		App::get()->smarty->assign('error_message', 'You should accept Terms and Conditions!');
		$valid = false;
	}
	if ($_POST['login'] == $_POST['referral']) {
		$_POST['referral'] = '';
	}
	if ($valid) {
		$user = new User();
		$_POST['pm_member_id'] = !empty($_POST['pm_member_id']) ? $_POST['pm_member_id'] : '';
		$_POST['secpin'] = $_POST['secpin_signup'];
		$_POST['masterpin'] = $_POST['masterpin_signup'];
		$_POST['reg_date'] = Project::getInstance()->getNow();
		$user->setData(sql_escapeArray($_POST));
		$user->access = ACCESS_LEVEL_USER;
		$user->status = USER_STATUS_ACTIVE;
		if ($user_id = $user->save()) {
			$page_tpl = 'signup_ok.tpl';
			include_once(LIB_ROOT.'/emails.class.php');
			$params = array(
				'%user_fullname%' => $user->fullname, 
				'%user_login%' => $user->login,
				'%user_password%' => $user->password, 
				'%user_secpin%' => $user->secpin,
				'%user_masterpin%' => $user->masterpin,
				'%project_name%' => get_setting('project_name'), 
				'%project_email%' => get_setting('project_email')
			);
			$email = new Emails($user_id, 'signup_notify', $params);
			$email->send();
		}
	}
	else {
		App::get()->smarty->assign('signup', $_POST);
		$page_tpl = 'signup.tpl';
	}
}
else {
	$page_tpl = 'signup.tpl';
	App::get()->smarty->assign('signup', array($_SESSION['referral']));
}
App::get()->showPage($page_tpl);