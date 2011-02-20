<?php
$ACCESS_LEVEL = ACCESS_LEVEL_USER;
include_once(DOC_ROOT.'/includes/authorization.php');
$user = sql_row('
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
			WHERE users.id="'.Project::getInstance()->getCurUser()->id.'"
			GROUP BY users.id
		');
Project::getInstance()->getSmarty()->assign('user', $user);
Project::getInstance()->getSmarty()->display('user/account.tpl');