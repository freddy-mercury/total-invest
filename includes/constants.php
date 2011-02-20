<?php
/** ACCESS LEVELS **/
define('ACCESS_LEVEL_GUEST', 0);
define('ACCESS_LEVEL_USER', 1);
define('ACCESS_LEVEL_ADMIN', 2);

/** USER STATUSES **/
define('USER_STATUS_BLOCKED', 0);
define('USER_STATUS_ACTIVE', 1);
define('USER_STATUS_HOLD', 2);
$USERS_FIELDS = array(
	'users.id',
	'users.fullname',
	'users.login',
	'users.email',
	'users.payment_system',
	'users.pm_member_id',
	'users.account',
	'users.status',
	'users.access',
	'users.monitor',
	'users.reg_date',
	'users.referral',
	'users.access_notify',
	'users.change_notify',
	'users.deposit_notify',
	'users.withdrawal_notify',
	'users.withdrawal_limit',
	'users.daily_withdrawal_limit',
	'users.question',
	'users.question_answer',
	'users.lang',
);

/** WHITHDRAWAL **/
define('WITHDRAWAL_DELAY', 30);

$MY_IPS = array(
	'195.68.140.*',
	'127.0.0.*',
	'95.220.*.*',
);

$TPL_CFG = array(
	'login_pin' => array(
		'length' => 5,
	),
	'master_pin' => array(
		'length' => 5,
	),
);
