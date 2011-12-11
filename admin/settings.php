<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT.'/includes/authorization.php');
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
switch ($action) {
	case 'save':
		$_POST['settings'] = array_map("encrypt", $_POST['settings']);
		foreach ($_POST['settings'] as $id=>$value) {
			sql_query('UPDATE settings SET value="'.sql_escapeStr($value).'" WHERE id="'.intval($id).'"');
		}
		location($_SERVER['PHP_SELF'], '<p class=imp>Settings has beed saved!</p>');
	break;
	case 'add':
		sql_query('
			INSERT INTO settings
			SET
				id=0,
				name="'.sql_escapeStr($_POST['name']).'",
				value="'.sql_escapeStr(encrypt($_POST['value'])).'",
				custom=1
		');
		location($_SERVER['PHP_SELF'], '<p class=imp>Setting <u>'.htmlspecialchars($_POST['name']).'</u> has beed added!</p>');
	break;
	case 'delete':
		sql_query('
			DELETE FROM settings WHERE id="'.intval($_REQUEST['id']).' AND custom=1"
		');
		location($_SERVER['PHP_SELF'], '<p class=imp>Setting has beed deleted!</p>');
	break;
}
if (isset($_GET['set'])) {
	$_POST['name'] = $_GET['set'];
}
Project::getInstance()->getSmarty()->assign('settings', Project::getInstance()->getSettings());
Project::getInstance()->getSmarty()->display('../index/administrator/settings.tpl');