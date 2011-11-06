<?php
$ACCESS_LEVEL = ACCESS_LEVEL_USER;
define('MIN_WITHDRAW', 0);
include_once(DOC_ROOT.'/includes/authorization.php');

$user = stripslashes_array(sql_row('
			SELECT
				'.(PRO_VERSION ? 'users.*' : implode(',', $GLOBALS['USERS_FIELDS'])).',
				SUM(IF(t.type="d", t.amount, NULL)) as deposit,
				SUM(IF(t.type="w", t.amount, NULL)) as withdrawal,
				SUM(IF(t.type="e", t.amount, NULL)) as earning,
				SUM(IF(t.type="r", t.amount, NULL)) as referral,
				SUM(IF(t.type="i", t.amount, NULL)) as reinvest,
				SUM(IF(t.type="b", t.amount, NULL)) as bonus
			FROM users
			LEFT JOIN translines as t ON t.user_id = users.id AND t.stamp < '.Project::getInstance()->getNow().' AND t.status > 0
			WHERE users.id="'.Project::getInstance()->getCurUser()->id.'"
			GROUP BY users.id
			'));
$balance = floatval($user['earning'] + $user['withdrawal'] + $user['bonus'] + $user['referral'] + $user['reinvest']);
Project::getInstance()->getSmarty()->assign('user', $user);

if (isset($_REQUEST['action']) && $_REQUEST['action']=='withdraw') {
	//���� ������ ��� ������������
	if (MASTER_PIN && $_POST['masterpin'] !== Project::getInstance()->getCurUser()->masterpin) {
		location($_SERVER['PHP_SELF'], '<p class=imp><strong>Alert:</strong> Bad Security pin!</p>');
	}
	//�������� �� �������� � 30 ���
	/**
	 * @todo �������� �� ��������, �.�. ���������� ������������ �����
	 */
	$last_withdrawal_stamp = sql_get('SELECT MAX(stamp) FROM translines WHERE user_id="'.$user['id'].'" AND type="w"');
	if ((Project::getInstance()->getNow() - $last_withdrawal_stamp) < WITHDRAWAL_DELAY) {
		location($_SERVER['PHP_SELF'], '<p class=imp><strong>Attention:</strong> The next withdrawal request can be made within '.WITHDRAWAL_DELAY.' seconds delay.</p>');
	}

	//���� ��� �������
	if (Project::getInstance()->getCurUser()->monitor) {
		$balance = floatval($user['bonus'] + $user['reinvest'] > 0 ? $balance - ($user['bonus'] + $user['reinvest']) : ($balance));
	}
	//���� ������������� ����� ������, ���� ����� �������
	if (floatval($_POST['amount']) > MIN_WITHDRAW && floatval($_POST['amount']) <= $balance) {
		//������� ��������� ����
		if ($user['payment_system'] == 'LR') {
			include_once(LIB_ROOT.'/liberty.class.php');
			$gateway =  new LibertyReserve(get_setting('lr_api'), get_setting('lr_api_secword'));
			$account = get_setting('lr_account');
		}
		elseif ($user['payment_system'] == 'PM') {
			include_once(LIB_ROOT.'/perfect.class.php');
			$gateway =  new PerfectMoney(get_setting('pm_member_id'), get_setting('pm_password'));
			$account = get_setting('pm_account');
		}
		/**
		 * ��������� ������� �� ����������
		 */
		if (get_setting('transaction_limit') == 0 & $user['withdrawal_limit'] == 0) {
			$limit = 0;
		}
		if (get_setting('transaction_limit') == 0 && $user['withdrawal_limit'] > 0) {
			$limit = floatval($user['withdrawal_limit']);
		}
		elseif (get_setting('transaction_limit') > 0 && $user['withdrawal_limit'] == 0) {
			$limit = floatval(get_setting('transaction_limit'));
		}
		elseif (get_setting('transaction_limit') > $user['withdrawal_limit']) {
			$limit = floatval($user['withdrawal_limit']);
		}
		else {
			$limit = floatval(get_setting('transaction_limit'));
		}
		/**
		 * ��������� ������� �� ����� ���������� �� ����
		 */
		if (get_setting('daily_limit') == 0 && $user['daily_withdrawal_limit'] == 0) {
			$daily_limit = 0;
		}
		if (get_setting('daily_limit') == 0 && $user['daily_withdrawal_limit'] > 0) {
			$daily_limit = floatval($user['daily_withdrawal_limit']);
		}
		elseif (get_setting('daily_limit') > 0 && $user['daily_withdrawal_limit'] == 0) {
			$daily_limit = floatval(get_setting('daily_limit'));
		}
		elseif (get_setting('daily_limit') > $user['daily_withdrawal_limit']) {
			$daily_limit = floatval($user['daily_withdrawal_limit']);
		}
		else {
			$daily_limit = floatval(get_setting('daily_limit'));
		}

		$today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$today_end = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
		$withdrawnToday = floatval(sql_get('SELECT ABS(SUM(amount)) FROM translines WHERE user_id="'.$user['id'].'" AND type="w" AND (stamp BETWEEN '.$today_start.' AND '.$today_end.')'));

		if ((floatval($_POST['amount']) <= $limit || $limit == 0) && ((floatval($_POST['amount']) + $withdrawnToday) <= $daily_limit || $daily_limit == 0)) {
			sql_query('
				INSERT INTO translines
				SET
					id=0,
					parent_id=0,
					user_id="'.$user['id'].'",
					plan_id=0,
					type="w",
					amount="-'.abs(floatval($_POST['amount'])).'",
					stamp="'.Project::getInstance()->getNow().'",
					status="0",
					batch=""
			');
			$payment_id = sql_insert_id();
			$reciept_id = $gateway->transfer($account, $user['account'], floatval($_POST['amount']), urlencode('Withdrawal for user '.$user['login'].' on '.date('M d, Y H:i', Project::getInstance()->getNow()).' from '.get_setting('project_name')));
		}
		else {
			$reciept_id = 0;
		}
		if ($reciept_id) {
			sql_query('
				UPDATE translines
				SET
					status="1",
					batch="'.$reciept_id.'"
				WHERE
					id="'.$payment_id.'"'
			);
			if (Project::getInstance()->getCurUser()->withdrawal_notify) {
				include_once(LIB_ROOT.'/emails.class.php');
				//%user_fullname%, %user_login%, %amount%, %batch%, %access_time%, %account%, %project_name%, %project_email%
				$params = array(
					'%user_fullname%' => htmlspecialchars($user['fullname']),
					'%user_login%' => $user['login'],
					'%account%' => $user['account'],
					'%amount%' => floatval($_POST['amount']),
					'%batch%' => $reciept_id,
					'%project_name%' => get_setting('project_name'),
					'%project_email%' => get_setting('project_email'),
					'%access_time%' => date('M d, Y H:i', Project::getInstance()->getNow())
				);
				$email = new Emails(Project::getInstance()->getCurUser()->id, 'withdrawal_notify', $params);
				$email->send();
			}
			location($_SERVER['PHP_SELF'], '<p class=imp><strong>Achievement:</strong> Operation has been completed, check your account!</p>');
		}
		else {
			//���� �� ������ ������, �� ���������� � bad_withdrawals
			$gw_balance = $gateway->getBalance($account);
			if (Project::getInstance()->getCurUser()->payment_system == 'PM') {
				$gw_balance = $gw_balance[get_setting('pm_account')];
			}
			sql_query('
				INSERT INTO bad_withdrawals
				SET
					id=0,
					user_id="'.$user['id'].'",
					amount= "'.floatval($_POST['amount']).'",
					gw_balance="'.floatval($gw_balance).'",
					stamp="'.Project::getInstance()->getNow().'"'
			);
			$withdrawal_details = intval(get_setting('withdrawal_details'));
                        location($_SERVER['PHP_SELF'], '<p class=imp><strong>Notification:</strong> The action can not be done, please try 
again later! '.($withdrawal_details ? 'Get more <a href="/index.php?page='.$withdrawal_details.'">details</a>.' : '').'</p>');
		}
	}
	else {
		location($_SERVER['PHP_SELF'], '<p class=imp><strong>Alert:</strong> You have defined not valid amount or your available balance is too low to request the withdrawal!');
	}
}
else {
	if ($user['monitor'] == 1) {
		$balance = floatval($user['bonus'] + $user['reinvest'] > 0 ? $balance - ($user['bonus'] + $user['reinvest']) : ($balance));
	}
	Project::getInstance()->getSmarty()->assign('balance', $balance);
	Project::getInstance()->showPage('user/withdraw.tpl');
}
