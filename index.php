<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;
require_once(DOC_ROOT.'/includes/authorization.php');
$index_ctrl = new IndexController();
$index_ctrl->run();

if (!file_exists(realpath(dirname(__FILE__)).'/ai-config.php')) {
	header('Location: /installer.php');
}




$action = isset($_REQUEST['action']) && !empty($_REQUEST['action']) ? $_REQUEST['action'] : '';

switch($action) {
	case 'forget':

		break;
	case 'success':
		$page_tpl = 'success.tpl';
		break;
	case 'fail':
		$page_tpl = 'fail.tpl';
		break;
}
App::get()->showPage($page_tpl);
