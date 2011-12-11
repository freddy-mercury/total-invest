<?php
$ACCESS_LEVEL = ACCESS_LEVEL_USER;
include_once(DOC_ROOT.'/includes/authorization.php');

include_once(LIB_ROOT.'/plans/plan.class.php');
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

if (isset($_REQUEST['action']) && $_REQUEST['action']=='pre_deposit') {
	$plan = stripslashes_array(sql_row('SELECT * FROM plans WHERE id="'.intval($_POST['plan_id']).'"'));
	if ($plan['id']) {
		$user_attempts = sql_get('
			SELECT count(*) FROM translines 
			WHERE user_id="'.$user['id'].'" and plan_id="'.$plan['id'].'" and type="d" and status="2"
		');
		//���� ��������� ���-�� ������� � ���� ����
		if ($plan['attempts']!=0 && $user_attempts >= $plan['attempts']) {
			location($_SERVER['PHP_SELF'], '<p class=imp><strong>Warning:</strong> You have already deposited '.$plan['attempts'].' times in this plan!</p>');
		}
		//���� ��� ������, �� ������ �����������
		elseif (isset($_POST['amount']) && floatval($_POST['amount']) >= $plan['min'] && floatval($_POST['amount']) <= $plan['max']) {
			Project::getInstance()->getSmarty()->assign('plan', $plan);
			Project::getInstance()->getSmarty()->assign('balance', $balance);
			Project::getInstance()->showPage('user/deposit_confirm.tpl');
		}
		else {
			location($_SERVER['PHP_SELF'], '<p class=imp><strong>Warning:</strong> Incorrect amount has been defined!</p>');
		}
	}
	else {
		location($_SERVER['PHP_SELF'], '<p class=imp><strong>Warning:</strong> Investment plan does not exist!</p>');
	}
}
elseif (isset($_REQUEST['action']) && $_REQUEST['action']=='deposit') {
	$plan = stripslashes_array(sql_row('SELECT * FROM plans WHERE id="'.intval($_POST['plan_id']).'"'));
	if ($plan['id']) {
		$user_attempts = sql_get('
			SELECT count(*) FROM translines 
			WHERE user_id="'.$user['id'].'" and plan_id="'.$plan['id'].'" and type="d" and status="2"
		');
		//���� ��������� ���-�� ������� � ���� ����
		if ($plan['attempts']!=0 && $user_attempts >= $plan['attempts']) {
			location($_SERVER['PHP_SELF'], '<p class=imp><strong>Warning:</strong> You have already deposited '.$plan['attempts'].' times in this plan!</p>');
		}
		elseif (isset($_POST['amount']) && floatval($_POST['amount']) >= $plan['min'] && floatval($_POST['amount']) <= $plan['max']) {
			if ($_POST['source'] == '0') {
				if ($_POST['amount'] <= $balance) {
					sql_query('
						INSERT INTO translines 
						SET 
							id=0,
							parent_id=0,
							user_id="'.$user['id'].'",
							plan_id="'.$plan['id'].'",
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
							user_id="'.$user['id'].'", 
							plan_id="'.$plan['id'].'", 
							type="i", 
							amount="-'.floatval($_POST['amount']).'", 
							stamp="'.Project::getInstance()->getNow().'", 
							status="1", 
							batch="[internal]"
					');
					header('Location: /index.php?action=success');
				}
				else {
					location($_SERVER['PHP_SELF'], '<p class=imp><strong>Alert:</strong> You have only '.round($balance, 3).' USD on you balance!</p>');
				}
			}
			else {
				sql_query('
					INSERT INTO translines 
					SET 
						id=0,
						parent_id=0,
						user_id="'.$user['id'].'",
						plan_id="'.$plan['id'].'",
						type="d",
						amount="'.floatval($_POST['amount']).'",
						stamp="'.Project::getInstance()->getNow().'",
						status="0",
						batch="[deposit]"
				');
				if ($_POST['source'] == 'PM') {
					$pm_form = '
						<form action="https://perfectmoney.com/api/step1.asp" method="POST" id="pm_form">
							<input type="hidden" name="PAYEE_ACCOUNT" value="'.get_setting('pm_account').'" />
							<input type="hidden" name="PAYEE_NAME" value="'.get_setting('project_name').'" />
				    		<input type="hidden" name="PAYMENT_AMOUNT" value="'.floatval($_POST['amount']).'" />
						    <input type="hidden" name="PAYMENT_UNITS" value="USD" />
						    <input type="hidden" name="STATUS_URL" value="http'.(SSL ? 's' : '').'://'.$_SERVER['HTTP_HOST'].'/status_pm.php" />
						    <input type="hidden" name="PAYMENT_URL" value="http'.(SSL ? 's' : '').'://'.$_SERVER['HTTP_HOST'].'/index.php?action=success" />
						    <input type="hidden" name="NOPAYMENT_URL" value="http'.(SSL ? 's' : '').'://'.$_SERVER['HTTP_HOST'].'/index.php?action=fail" />
						    <input type="hidden" name="SUGGESTED_MEMO" value="Deposit for account: '.$user['login'].'" />
						    <input type="hidden" name="FORCED_PAYER_ACCOUNT" value="'.$user['pm_member_id'].'" />
						    <input type="hidden" name="BAGGAGE_FIELDS" value="PAYMENT_ID" />
						    <input type="hidden" name="PAYMENT_ID" value="'.sql_insert_id().'" />
						</form>
						<script language="Javascript">
						$("#pm_form").submit();
						</script>
					';
					location($_SERVER['PHP_SELF'], $pm_form);
				}
				elseif ($_POST['source'] == 'LR') {
					header('Location: https://sci.libertyreserve.com/?lr_acc='.get_setting('lr_account_deposit').'&lr_acc_from='.$user['account'].'&lr_amnt='.floatval($_POST['amount']).'&lr_currency=LRUSD&lr_comments='.urlencode('Deposit for account: '.$user['login']).'&lr_success_url='.urlencode('http'.(SSL ? 's' : '').'://'.$_SERVER['HTTP_HOST'].'/index.php?action=success').'&lr_success_url_method=GET&lr_fail_url='.urlencode('http'.(SSL ? 's' : '').'://'.$_SERVER['HTTP_HOST'].'/index.php?action=fail').'&lr_fail_url_method=GET&lr_store='.get_setting('lr_store').'&lr_status_url='.urlencode('http'.(SSL ? 's' : '').'://'.$_SERVER['HTTP_HOST'].'/status.php').'&lr_status_url_method=GET&payment_id='.sql_insert_id());
				}
			}
		}
		else {
			location($_SERVER['PHP_SELF'], '<p class=imp><strong>Warning:</strong> Incorrect amount has been defined!</p>');
		}
	}
	else {
		location($_SERVER['PHP_SELF'], '<p class=imp><strong>Warning:</strong> Investment plan does not exist!</p>');
	}
}
else {
	$plans = array();
	$result = sql_query('
		SELECT 
			* 
		FROM plans 
		WHERE type in ('.(Project::getInstance()->getCurUser()->monitor ? '1, 2' : '0,2').')
		ORDER BY id
	');
	while ($row = mysql_fetch_assoc($result)) {
		$plans[] = $row;
	}
	Project::getInstance()->getSmarty()->assign('plans', stripslashes_array($plans));
	Project::getInstance()->showPage('user/deposit.tpl');
}
