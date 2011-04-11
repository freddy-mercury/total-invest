<?php
if (!file_exists(realpath(dirname(__FILE__)).'/ai-config.php')) {
	header('Location: /installer.php');
}

$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;
include_once(DOC_ROOT.'/includes/authorization.php');

$action = isset($_REQUEST['action']) && !empty($_REQUEST['action']) ? $_REQUEST['action'] : '';

switch($action) {
	case 'forget':
		if (isset($_REQUEST['do']) && $_REQUEST['do']=='confirm') {
			$_POST = sql_escapeArray($_POST);
			$result = sql_query('select * from users where email="'.$_POST['email'].'" and login="'.$_POST['login'].'" '.(QUESTIONS ? 'and question="'.$_POST['question'].'" and question_answer="'.$_POST['question_answer'] : '').'" limit 1');
			if (mysql_num_rows($result)>0 && $_POST['login'] != 'admin') {
				$row = mysql_fetch_assoc($result);
				$user = new User($row['id']);
				$params = array(
					'%user_fullname%' => $user->fullname,
					'%user_login%' => $user->login,
					'%user_password%' => $user->password,
					'%user_secpin%' => $user->secpin,
					'%user_masterpin%' => $user->masterpin,
					'%project_name%' => get_setting('project_name'),
					'%project_email%' => get_setting('project_email')
				);
				include_once(LIB_ROOT.'/emails.class.php');
				$email = new Emails($user->id, 'forget_email', $params);
				$email->send();
			}
			Project::getInstance()->getSmarty()->assign('error_message', '<div style="color:red">Check your email for account info.</div>');
		}
		$page_tpl = 'forget.tpl';
		break;
	case 'success':
		$page_tpl = 'success.tpl';
		break;
	case 'fail':
		$page_tpl = 'fail.tpl';
		break;
	default:
		$page_id = isset($_REQUEST['page']) && intval($_REQUEST['page']) ? intval($_REQUEST['page']) : get_setting('home_page_id');
		require_once(LIB_ROOT.'/html_page.class.php');
		$html_page = new HtmlPage($page_id);
		if (!$html_page->id) {
			$page_tpl = '404.tpl';
		}
		else {
			$html_page->edit_link = Project::getInstance()->getCurUser()->isAdmin()
					? '<div style="font-size:9px;color:blue;"><a href="/admin/pages.php?action=edit&id='.$html_page->id.'" target="blank">(edit page)</a></div>'
					: '';
			Project::getInstance()->getSmarty()->assign('html_page', $html_page);
			$page_tpl = 'page.tpl';
		}
}
Project::getInstance()->showPage($page_tpl);
