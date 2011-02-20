<?php
if (!file_exists(realpath(dirname(__FILE__)).'/ai-config.php')) {
	header('Location: /installer.php');
}
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;
include_once(LIB_ROOT.'/pages/page.class.php');
include_once(LIB_ROOT.'/plans/plan.class.php');
include_once(DOC_ROOT.'/includes/authorization.php');
$plans = new Plan();
$plans_all = $plans->getAll();
Project::getInstance()->getSmarty()->assign('plans', $plans_all);
$investment_plans = '
<table width="100%">
<tbody>
<tr>
<td class="ui-state-hover"><strong>Name</strong></td>
<td class="ui-state-hover"><strong>Min</strong></td>
<td class="ui-state-hover"><strong>Max</strong></td>
<td class="ui-state-hover"><strong>Percents</strong></td>
<td class="ui-state-hover"><strong>Periodicity</strong></td>
<td class="ui-state-hover"><strong>Term</strong></td>
<td class="ui-state-hover"><strong>Comment</strong></td>
</tr>';
foreach($plans_all as $plan) {
	switch ($plan['periodicy']) {
		case 3600:
			$periodicy = 'h';
		break;
		case 86400:
			$periodicy = 'd';
		break;
		case 604800:
			$periodicy = 'w';
		break;
		case 2592000:
			$periodicy = 'm';
		break;
	}
	
	$investment_plans.= '<tr>
	<td class="list">'.$plan['name'].'</td>
	<td class="list">$'.$plan['min'].'</td>
	<td class="list">$'.$plan['max'].'</td>
	<td class="list">'.$plan['percent'].'%</td>
	<td class="list">'.$plan['periodicy_value'].$periodicy.'</td>
	<td class="list">'.$plan['term'].'days</td>
	<td class="list">'.$plan['comment'].' <br /></td>
	</tr>';
}
$investment_plans.= '</tbody></table>';
Project::getInstance()->getSmarty()->assign('investment_plans', $investment_plans);
if (isset($_REQUEST['page'])) {
	$page_tpl = 'page.tpl';
	if ($cur_page = sql_row('SELECT * FROM pages WHERE (id="'.intval($_REQUEST['page']).'") AND lang="'.$_COOKIE['lang'].'"')) {
		$cur_page = stripslashes_array($cur_page);
		if (Project::getInstance()->getCurUser()->isAdmin()) {
			$cur_page['edit_link'] = '<div style="font-size:9px;color:blue;"><a href="/includes/inlines/admin/page.php?id='.$cur_page['id'].'" target="blank">(edit page)</a></div>';
		}
		Project::getInstance()->getSmarty()->assign('cur_page', $cur_page);
	}
	else {
		$page_tpl = 'main.tpl';
	}
}
elseif (isset($_REQUEST['action'])) {
	switch($_REQUEST['action']) {
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
			$home_page = new Page(Project::getInstance()->getSettings()->setting['home_page_id']);
			if ($home_page->id) {
				$page_tpl = 'page.tpl';
				Project::getInstance()->getSmarty()->assign('cur_page', $home_page);
			}
			else {
				$page_tpl = 'main.tpl';
			}
	}
}
else {
	if ($home_page = sql_row('SELECT * FROM pages WHERE home=1 AND lang="'.$_COOKIE['lang'].'"')) {
		$page_tpl = 'page.tpl';
		$cur_page = stripslashes_array($home_page);
		if (Project::getInstance()->getCurUser()->isAdmin()) {
			$cur_page['edit_link']= '<div style="font-size:9px;color:blue;"><a href="/includes/inlines/admin/page.php?id='.$cur_page['id'].'" target="blank">(edit page)</a></div>';
		}
		Project::getInstance()->getSmarty()->assign('cur_page', $cur_page);
	}
	else {
		$page_tpl = 'main.tpl';
	}
}
Project::getInstance()->getSmarty()->display($page_tpl);
