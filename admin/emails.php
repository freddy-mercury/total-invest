<?
$ACCESS_LEVEL = 2;
include_once(DOC_ROOT.'/includes/authorization.php');
if (isset($_REQUEST['action']) && $_REQUEST['action']=='save') {
	$_POST = array_map("encrypt", $_POST);
	$_POST = sql_escapeArray($_POST);
	sql_query('REPLACE settings SET  value = "'.htmlspecialchars($_POST['signup_notify']).'", name="signup_notify"');
	sql_query('REPLACE settings SET  value = "'.htmlspecialchars($_POST['access_notify']).'", name="access_notify"');
	sql_query('REPLACE settings SET  value = "'.htmlspecialchars($_POST['change_notify']).'", name="change_notify"');
	sql_query('REPLACE settings SET  value = "'.htmlspecialchars($_POST['deposit_notify']).'", name="deposit_notify"');
	sql_query('REPLACE settings SET  value = "'.htmlspecialchars($_POST['withdrawal_notify']).'", name="withdrawal_notify"');
	sql_query('REPLACE settings SET  value = "'.htmlspecialchars($_POST['forget_email']).'", name="forget_email"');
	location($_SERVER['PHP_SELF'], '<p class=imp>Email templates has been saved!</p>');
}
App::get()->smarty->assign('signup_notify', get_setting('signup_notify'));
App::get()->smarty->assign('access_notify', get_setting('access_notify'));
App::get()->smarty->assign('change_notify', get_setting('change_notify'));
App::get()->smarty->assign('deposit_notify', get_setting('deposit_notify'));
App::get()->smarty->assign('withdrawal_notify', get_setting('withdrawal_notify'));
App::get()->smarty->assign('forget_email', get_setting('forget_email'));

App::get()->smarty->display('../default/admin/emails.tpl');
