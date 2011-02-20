<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT.'/includes/authorization.php');

include_once(LIB_ROOT.'/users/statistics.class.php');
$stats = new Statistics();
$stats->select = ' sum(amount) as sum ';
$deposited = $stats->getLines(array('d'), 2);
$reinvested = $stats->getLines(array('i'), 1);
$earned = $stats->getLines(array('e'), 1);
$withdrawn = $stats->getLines(array('w'), 1);
$referral_bonuses = $stats->getLines(array('r'), 1);
Project::getInstance()->getSmarty()->assign('deposited', $deposited[0]['sum'] - abs($reinvested[0]['sum']));
Project::getInstance()->getSmarty()->assign('reinvested', $reinvested[0]['sum']);
Project::getInstance()->getSmarty()->assign('earned', $earned[0]['sum']);
Project::getInstance()->getSmarty()->assign('withdrawn', $withdrawn[0]['sum']);
Project::getInstance()->getSmarty()->assign('referral_bonuses', $referral_bonuses[0]['sum']);
include_once(LIB_ROOT.'/liberty.class.php');
$LR = new LibertyReserve(get_setting('lr_api'), get_setting('lr_api_secword'));
Project::getInstance()->getSmarty()->assign('lr_balance', $LR->getBalance(get_setting('lr_account')));
include_once(LIB_ROOT.'/perfect.class.php');
$PM = new PerfectMoney(get_setting('pm_member_id'), get_setting('pm_password'));
$balance = $PM->getBalance();
Project::getInstance()->getSmarty()->assign('pm_balance', $balance[get_setting('pm_account')]);
include_once(LIB_ROOT.'/php-ofc-library/open-flash-chart-object.php');
Project::getInstance()->getSmarty()->assign('chart', open_flash_chart_object_str( 1000 , 500, 'chart-data.php', false, '/admin/')); 
Project::getInstance()->getSmarty()->display('../default/admin/statistics.tpl');