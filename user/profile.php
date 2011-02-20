<?php
$ACCESS_LEVEL = ACCESS_LEVEL_USER;
include_once(DOC_ROOT.'/includes/authorization.php');
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'save') {
	if (MASTER_PIN && $_POST['masterpin'] !== Project::getInstance()->getCurUser()->masterpin) {
		location($_SERVER['PHP_SELF'], '<p class=imp><strong>Alert:</strong> Bad Security pin!</p>');
	}
	if (empty($_POST['fullname'])) {
		location($_SERVER['PHP_SELF'], '<p class=imp><strong>Alert:</strong> Fullname is empty!</p>');
	}
	/**
	 * LR
	 */
	if (empty($_POST['pm_member_id'])) {
		if (!ereg("^(U|X)[0-9]{1,}$", $_POST['account'])) {
			location($_SERVER['PHP_SELF'], '<p class=imp><strong>Alert:</strong> Invalid account number!</p>');
		}
	}
	/**
	 * PM
	 */
	else {
		if (!ereg("^[0-9]{1,}$", $_POST['pm_member_id'])) {
			location($_SERVER['PHP_SELF'], '<p class=imp><strong>Alert:</strong> Invalid member ID!</p>');
		}
		if (!ereg("^(U|X)[0-9]{1,}$", $_POST['account'])) {
			location($_SERVER['PHP_SELF'], '<p class=imp><strong>Alert:</strong> Invalid account number!</p>');
		}
	}
	/**
	 * email check
	 */
	if (!check_email($_POST['email'])) {
		location($_SERVER['PHP_SELF'], '<p class=imp><strong>Alert:</strong> Invalid e-mail address!</p>');
	}
	/**
	 * if everything OK
	 */
	$_POST = sql_escapeArray($_POST);
	sql_query('
		UPDATE users 
		SET 
			fullname="'.$_POST['fullname'].'", 
			'.(!empty($_POST['pm_member_id']) ? 'pm_member_id="'.$_POST['pm_member_id'].'",' : '').'
			account="'.$_POST['account'].'", 
			email="'.$_POST['email'].'"
		WHERE id="'.Project::getInstance()->getCurUser()->id.'"');
	Project::getInstance()->resetCurUser();
	
	sql_query('
		UPDATE users 
		SET 
			access_notify="'.(isset($_POST['access_notify']) ? '1' : '0').'",
			change_notify="'.(isset($_POST['change_notify']) ? '1' : '0').'",
			deposit_notify="'.(isset($_POST['deposit_notify']) ? '1' : '0').'",
			withdrawal_notify="'.(isset($_POST['withdrawal_notify']) ? '1' : '0').'"
		WHERE id="'.Project::getInstance()->getCurUser()->id.'"');
	Project::getInstance()->resetCurUser();
	if (Project::getInstance()->getCurUser()->change_notify) {
		include_once(LIB_ROOT.'/emails.class.php');
		//%user_fullname%, %user_login%, %access_ip%, %access_time%, %project_name%, %project_email%
		$params = array(
			'%user_fullname%' => htmlspecialchars(Project::getInstance()->getCurUser()->fullname), 
			'%user_login%' => Project::getInstance()->getCurUser()->login,
			'%access_ip%' => $_SERVER['REMOTE_ADDR'],
			/*'%changed_fields%' => $changed_fields,*/
			'%project_name%' => get_setting('project_name'), 
			'%project_email%' => get_setting('project_email'),
			'%access_time%' => date('M d, Y H:i', Project::getInstance()->getNow())
		);
		$email = new Emails(Project::getInstance()->getCurUser()->id, 'change_notify', $params);
		$email->send();
	}
	location($_SERVER['PHP_SELF'], '<p class=imp><strong>Success:</strong> Account has been saved!</p>');
}
else {
	if (isset($_REQUEST['change'])) {
		if ($_REQUEST['change'] == 'secpin') {
			if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
				if ($_POST['masterpin'] !== Project::getInstance()->getCurUser()->masterpin) {
					location($_SERVER['PHP_SELF'].'?change=secpin', '<p class=imp><strong>Alert:</strong> Bad Security pin!</p>');
				}
				if ($_POST['oldsecpin'] !== Project::getInstance()->getCurUser()->secpin) {
					location($_SERVER['PHP_SELF'].'?change=secpin', '<p class=imp><strong>Alert:</strong> Bad old Login pin!</p>');
				}
				if (!preg_match('/\d{'.$GLOBALS['TPL_CFG']['login_pin']['length'].'}/', $_POST['secpin'])) {
					location($_SERVER['PHP_SELF'].'?change=secpin', '<p class=imp><strong>Alert:</strong> Invalid new Login pin!</p>');
				}
				if (LOGIN_PIN) {
					$_POST = sql_escapeArray($_POST);
					sql_query('
						UPDATE users 
						SET 
							secpin="'.$_POST['secpin'].'"
						WHERE id="'.Project::getInstance()->getCurUser()->id.'"');
				}
			}
			else {
				Project::getInstance()->showPage('user/secpin.tpl');
				exit();
			}
		}
		elseif ($_REQUEST['change'] == 'password') {
			if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
				if (MASTER_PIN && $_POST['masterpin'] !== Project::getInstance()->getCurUser()->masterpin) {
					location($_SERVER['PHP_SELF'].'?change=password', '<p class=imp><strong>Alert:</strong> Bad Security pin!</p>');
				}
				if ($_POST['oldpassword'] !== Project::getInstance()->getCurUser()->password) {
					location($_SERVER['PHP_SELF'].'?change=password', '<p class=imp><strong>Alert:</strong> Bad old password!</p>');
				}
				if (!check_pass($_POST['password'], 6)) {
					location($_SERVER['PHP_SELF'].'?change=password', '<p class=imp><strong>Alert:</strong> Password is not strong enough!</p>');
				}
				$_POST = sql_escapeArray($_POST);
				sql_query('
					UPDATE users 
					SET 
						password="'.$_POST['password'].'"
					WHERE id="'.Project::getInstance()->getCurUser()->id.'"');
				Project::getInstance()->resetCurUser();
				if (Project::getInstance()->getCurUser()->change_notify) {
					include_once(LIB_ROOT.'/emails.class.php');
					//%user_fullname%, %user_login%, %access_ip%, %access_time%, %project_name%, %project_email%
					$params = array(
						'%user_fullname%' => htmlspecialchars(Project::getInstance()->getCurUser()->fullname), 
						'%user_login%' => Project::getInstance()->getCurUser()->login,
						'%access_ip%' => $_SERVER['REMOTE_ADDR'],
						/*'%changed_fields%' => $changed_fields,*/
						'%project_name%' => get_setting('project_name'), 
						'%project_email%' => get_setting('project_email'),
						'%access_time%' => date('M d, Y H:i', Project::getInstance()->getNow())
					);
					$email = new Emails(Project::getInstance()->getCurUser()->id, 'change_notify', $params);
					$email->send();
				}
			}
			else {
				Project::getInstance()->showPage('user/password.tpl');
				exit();
			}
		}
		elseif ($_REQUEST['change'] == 'masterpin') {
			if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
				if (!preg_match('/\d{'.$GLOBALS['TPL_CFG']['master_pin']['length'].'}/', $_POST['newmasterpin'])) {
					location($_SERVER['PHP_SELF'].'?change=masterpin', '<p class=imp><strong>Alert:</strong> Invalid new Security pin!</p>');
				}
				if ($_POST['masterpin'] !== Project::getInstance()->getCurUser()->masterpin) {
					location($_SERVER['PHP_SELF'].'?change=masterpin', '<p class=imp><strong>Alert:</strong> Bad Security pin!</p>');
				}
				if (MASTER_PIN) {
					$_POST = sql_escapeArray($_POST);
					sql_query('
						UPDATE users 
						SET 
							masterpin="'.$_POST['newmasterpin'].'"
						WHERE id="'.Project::getInstance()->getCurUser()->id.'"');
					Project::getInstance()->resetCurUser();
					if (Project::getInstance()->getCurUser()->change_notify) {
						include_once(LIB_ROOT.'/emails.class.php');
						//%user_fullname%, %user_login%, %access_ip%, %access_time%, %project_name%, %project_email%
						$params = array(
							'%user_fullname%' => htmlspecialchars(Project::getInstance()->getCurUser()->fullname), 
							'%user_login%' => Project::getInstance()->getCurUser()->login,
							'%access_ip%' => $_SERVER['REMOTE_ADDR'],
							/*'%changed_fields%' => $changed_fields,*/
							'%project_name%' => get_setting('project_name'), 
							'%project_email%' => get_setting('project_email'),
							'%access_time%' => date('M d, Y H:i', Project::getInstance()->getNow())
						);
						$email = new Emails(Project::getInstance()->getCurUser()->id, 'change_notify', $params);
						$email->send();
					}
				}
			}
			else {
				Project::getInstance()->showPage('user/masterpin.tpl');
				exit();
			}
		}
		Project::getInstance()->resetCurUser();
		if (Project::getInstance()->getCurUser()->change_notify) {
			include_once(LIB_ROOT.'/emails.class.php');
			//%user_fullname%, %user_login%, %access_ip%, %access_time%, %project_name%, %project_email%
			$params = array(
				'%user_fullname%' => htmlspecialchars(Project::getInstance()->getCurUser()->fullname), 
				'%user_login%' => $user->login,
				'%access_ip%' => $_SERVER['REMOTE_ADDR'],
				/*'%changed_fields%' => $changed_fields,*/
				'%project_name%' => get_setting('project_name'), 
				'%project_email%' => get_setting('project_email'),
				'%access_time%' => date('M d, Y H:i', Project::getInstance()->getNow())
			);
			$email = new Emails(Project::getInstance()->getCurUser()->id, 'change_notify', $params);
			$email->send();
		}
		location($_SERVER['PHP_SELF'], '<p class=imp>Settings has been saved!</p>');
	}
	$_POST['access_notify'] = Project::getInstance()->getCurUser()->access_notify;
	$_POST['change_notify'] = Project::getInstance()->getCurUser()->change_notify;
	$_POST['deposit_notify'] = Project::getInstance()->getCurUser()->deposit_notify;
	$_POST['withdrawal_notify'] = Project::getInstance()->getCurUser()->withdrawal_notify;
	Project::getInstance()->getSmarty()->assign('user', Project::getInstance()->getCurUser());
	Project::getInstance()->showPage('user/profile.tpl');
}
