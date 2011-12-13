<?
$ACCESS_LEVEL = 2;
include_once(LIB_ROOT.'/users/user.class.php');
include_once(DOC_ROOT.'/includes/authorization.php');
if (isset($_REQUEST['action']) && $_REQUEST['action']=='find') {
	$query = "
		SELECT * FROM translines as t
		LEFT JOIN users as u ON u.id = t.user_id
		WHERE t.id='".intval($_REQUEST['transaction_id'])."' and t.status in ('1','2') LIMIT 1
	";
	$transaction = mysql_fetch_assoc($dbh->query($query));
	if ($transaction['id']) {
		$plan = new Plan($transaction['plan_id']);
		$user = new UserOld($transaction['user_id']);
		$details = print_rr($transaction, true).print_rr($plan, true).print_rr($user, true);
	}
	$smarty->assign('transaction_details', $details);
}

$smarty->display('../index/administrator/find_deposit.tpl');