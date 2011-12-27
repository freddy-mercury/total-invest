<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(LIB_ROOT.'/users/user.class.php');
include_once(DOC_ROOT.'/includes/authorization.php');
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
switch ($action) {
	case 'profile':
		if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
			$_POST = sql_escapeArray($_POST);
			sql_query('
				update users set
					fullname="'.$_POST['fullname'].'",
					payment_system="'.$_POST['payment_system'].'",
					'.(!empty($_POST['pm_member_id']) ? 'pm_member_id="'.$_POST['pm_member_id'].'",' : '').'
					account="'.$_POST['account'].'",
					email="'.$_POST['email'].'",
					status="'.$_POST['status'].'",
					access="'.$_POST['access'].'",
					withdrawal_limit="'.$_POST['withdrawal_limit'].'",
					daily_withdrawal_limit="'.$_POST['daily_withdrawal_limit'].'",
					monitor="'.$_POST['monitor'].'",
					question="'.$_POST['question'].'",
					question_answer="'.$_POST['question_answer'].'",
					lang="'.$_POST['lang'].'"
				where id="'.$_POST['id'].'"'
			);
			location($_SERVER['PHP_SELF'].'?action=profile&id='.$_POST['id'], '<p class=imp>User profile has been saved!</p>');
		}
		$user = sql_row('
			SELECT
				'.(PRO_VERSION ? 'users.*' : implode(',', $GLOBALS['USERS_FIELDS'])).',
				COUNT(b.user_id) as bads
			FROM users
			LEFT JOIN bad_withdrawals as b ON b.user_id = users.id
			WHERE users.id="'.intval($_REQUEST['id']).'"
			GROUP BY users.id
			');
		App::get()->smarty->assign('user', stripslashes_array($user));
		App::get()->smarty->display('../default/admin/user_profile.tpl');
	break;
	case 'statistics':
		include_once(LIB_ROOT.'/users/statistics.class.php');
		$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'a';
		if ($type == 'a') {
			$types = array('d', 'w', 'e', 'r', 'b');
			$status = array('1', '2');
		}
		elseif ($type == 'd') {
			$types = array('d');
			$status = 2;
		}
		else {
			$types = array($type);
			$status = 1;
		}
		$stats = new Statistics(intval($_REQUEST['id']));
		$stats->select = '*';
		$lines = $stats->getLines($types, $status);
		App::get()->smarty->assign('lines', $lines);
		App::get()->smarty->assign('user_id', intval($_REQUEST['id']));
		App::get()->smarty->display('../default/admin/user_statistics.tpl');
	break;
	case 'bonus':
		if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
			$_POST = sql_escapeArray($_POST);
			sql_query('
				INSERT INTO translines
				SET
					id=0,
					parent_id=0,
					user_id="'.intval($_POST['id']).'",
					plan_id=0,
					type="b",
					amount="'.floatval($_POST['amount']).'",
					stamp='.Project::getInstance()->getNow().',
					status=1,
					batch="'.$_POST['comment'].'"
				');
			if ($_POST['deposit']) {
				sql_query('
					INSERT INTO translines
					SET
						id=0,
						parent_id=0,
						user_id="'.intval($_POST['id']).'",
						plan_id="'.intval($_POST['plan_id']).'",
						type="d",
						amount="'.floatval($_POST['amount']).'",
						stamp="'.Project::getInstance()->getNow().'",
						status="1",
						batch="[reinvested]"
				');
				sql_query('
					INSERT INTO translines
					SET
						id=0,
						parent_id=0,
						user_id="'.intval($_POST['id']).'",
						plan_id="'.intval($_POST['plan_id']).'",
						type="i",
						amount="-'.floatval($_POST['amount']).'",
						stamp="'.Project::getInstance()->getNow().'",
						status="1",
						batch="[internal]"
				');
			}
			location($_SERVER['PHP_SELF'].'?action=profile&id='.$_POST['id'], '<p class=imp>Bonus <u>'.htmlspecialchars($_POST['amount']).'</u> has been added!</p>');
		}
		$plans = array();
		$result = sql_query('
			SELECT * FROM plans ORDER BY id
		');
		while ($row = mysql_fetch_assoc($result)) {
			$plans[] = $row;
		}
		App::get()->smarty->assign('plans', stripslashes_array($plans));
		App::get()->smarty->assign('user_id', intval($_REQUEST['id']));
		App::get()->smarty->display('../default/admin/user_bonus.tpl');
	break;
	case 'bad_withdrawals':
		$result = sql_query('
			SELECT * FROM bad_withdrawals WHERE user_id="'.intval($_REQUEST['id']).'"
		');
		$bads = array();
		while ($row = mysql_fetch_assoc($result)) {
			$bads[] = $row;
		}
		App::get()->smarty->assign('bads', $bads);
		App::get()->smarty->display('../default/admin/user_bad_withdrawals.tpl');
	break;
	case 'message':
		if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'send') {
			$_POST = sql_escapeArray($_POST);
			$message = new UserMessage();
			$message->setData($_POST);
			$message->user_id = intval($_REQUEST['id']);
			$message->stamp = Project::getInstance()->getNow();
			$message->save();
			location($_SERVER['PHP_SELF'].'?action=profile&id='.intval($_REQUEST['id']), '<p class=imp>Message <u>'.htmlspecialchars($message->title).'</u> has been send!</p>');
		}
		App::get()->smarty->assign('user_id', intval($_REQUEST['id']));
		App::get()->smarty->display('../default/admin/user_message.tpl');
	break;
	default:
		$result_ips = sql_query('
			SELECT user_id, INET_NTOA(ip) as ip FROM visits GROUP BY user_id, ip
		');
		$ips = array();
		while ($row_ips = mysql_fetch_assoc($result_ips)) {
			$ips[$row_ips['user_id']][$row_ips['ip']] =  '';
		}
		$users_by_ips = array();
		$users_by_ips_result = sql_query('
			SELECT INET_NTOA(ip) as ip, CONVERT( GROUP_CONCAT( DISTINCT user_id )
			USING  "utf8" )  as user_ids
			FROM  `visits`
			GROUP BY ip');
		while ($users_by_ips_row = mysql_fetch_assoc($users_by_ips_result)) {
			$users_by_ips[$users_by_ips_row['ip']] = explode(',', $users_by_ips_row['user_ids']);
		}
		$bads_result = sql_query('SELECT user_id, COUNT(*) as bads FROM bad_withdrawals GROUP BY user_id');
		$bads = array();
		while ($row = mysql_fetch_assoc($bads_result)) {
			$bads[$row['user_id']] = $row['bads'];
		}
		$result = sql_query('
			SELECT SQL_CALC_FOUND_ROWS
				'.(PRO_VERSION ? 'users.*' : implode(',', $GLOBALS['USERS_FIELDS'])).',
				SUM(IF(t.type="d", t.amount, NULL)) as deposit,
				SUM(IF(t.type="w", t.amount, NULL)) as withdrawal,
				SUM(IF(t.type="e", t.amount, NULL)) as earning,
				SUM(IF(t.type="r", t.amount, NULL)) as referral,
				SUM(IF(t.type="i", t.amount, NULL)) as reinvest,
				SUM(IF(t.type="b", t.amount, NULL)) as bonus
			FROM users
			LEFT JOIN translines as t ON t.user_id = users.id AND t.stamp < '.Project::getInstance()->getNow().' AND t.status > 0
			GROUP BY users.id
			ORDER BY '.(!empty($_REQUEST['order_by']) ? addslashes($_REQUEST['order_by']) : 'reg_date DESC').'
			'.get_limit().'
		');
		$users = array();
		while ($row = mysql_fetch_assoc($result)) {
			$row['ips'] = isset($ips[$row['id']]) ? $ips[$row['id']] : array();
			$row['bads'] = isset($bads[$row['id']]) ? intval($bads[$row['id']]) : 0;
			$row['ipsec'] = 0;
			$users[$row['id']] = $row;
		}
		foreach ($users_by_ips as $ip=>$u_ids) {
			if (count($u_ids) > 1) {
				foreach ($u_ids as $u_id) {
					if (!isset($users[$u_id])) continue;
					$users[$u_id]['ipsec'] = 1;
					$users[$u_id]['ips'][$ip] = '('.implode(',', $u_ids).')';
				}
			}
		}
		App::get()->smarty->assign('pagination', pagination(sql_get('SELECT FOUND_ROWS()')));
		App::get()->smarty->assign('users', stripslashes_array($users));
		App::get()->smarty->display('../default/admin/users.tpl');
}
