<?
$ACCESS_LEVEL = 2;
include_once(LIB_ROOT.'/users/user.class.php');
include_once(DOC_ROOT.'/includes/authorization.php');
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
switch ($action) {
	case 'save':
		$valid = true;
		$_POST = $dbh->escapeArray($_POST);
		if ($valid) {
			$query = '
				UPDATE stats SET
				days_online="'.$_POST['days_online'].'",
				total_accounts="'.$_POST['total_accounts'].'",
				total_deposited="'.$_POST['total_deposited'].'",
				today_deposited="'.$_POST['today_deposited'].'",
				last_deposit="'.$_POST['last_deposit'].'",
				today_withdrawal="'.$_POST['today_withdrawal'].'",
				total_withdraw="'.$_POST['total_withdraw'].'",
				last_withdrawal="'.$_POST['last_withdrawal'].'",
				visitors_online="'.$_POST['visitors_online'].'",
				members_online="'.$_POST['members_online'].'",
				newest_member="'.$_POST['newest_member'].'"
				WHERE id="1"
			';
			$dbh->query($query);
			$smarty->assign('message', '<div class="message">Settings saved!</div>');
			$smarty->assign('statistics', (object)$_POST);
		}
		else {
			$smarty->assign('message', '<div class="message">All fields are required!</div>');
			$smarty->assign('statistics', (object)$_POST);
		}
	break;
	default:
		$smarty->assign('statistics', $statistics);
}
$smarty->display('../default/admin/stats.tpl');