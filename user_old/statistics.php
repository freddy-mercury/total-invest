<?
$ACCESS_LEVEL = ACCESS_LEVEL_USER;
include_once(DOC_ROOT.'/includes/authorization.php');
Project::getInstance()->getSmarty()->assign('user', Project::getInstance()->getCurUser());

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
$stats = new Statistics(Project::getInstance()->getCurUser()->id);
$stats->select = '*, translines.type as type';
$lines = $stats->getLines($types, $status);
Project::getInstance()->getSmarty()->assign('lines', $lines);
Project::getInstance()->showPage('user/statistics.tpl');
