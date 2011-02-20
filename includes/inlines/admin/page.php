<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT.'/includes/authorization.php');
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'save') {
	if ($_REQUEST['submit'] == 'Delete') {
		sql_query('DELETE FROM pages WHERE id="'.intval($_POST['id']).'" AND lang="'.$_COOKIE['lang'].'"');
		location('/includes/inlines/admin/page.php', '<div class=imp>Page deleted</div>');
	}
	$_POST = sql_escapeArray($_POST);
	if (!empty($_POST['name']) && !empty($_POST['text'])) {
		if (intval($_POST['home'])) {
			sql_query('UPDATE pages SET home=0 WHERE home=1 AND lang="'.$_COOKIE['lang'].'"');
		}
		if ($_POST['position']) {
			//если указана позиция то сдвигаем предыдущие на 1 назад
			sql_query('
				UPDATE pages SET position = position+1 WHERE position > '.intval($_POST['position']).' AND lang="'.$_COOKIE['lang'].'"
			');
		}
		sql_query('REPLACE pages SET
                    id="'.intval($_POST['id']).'",
                    position="'.intval($_POST['position']+1).'",
                    home="'.intval($_POST['home']).'",
					name="'.$_POST['name'].'",
					show_in_menu="'.intval($_POST['menu']).'",
					text="'.$_POST['text'].'",
					lang="'.$_COOKIE['lang'].'"');
		if (!intval($_POST['id'])) {
			$_POST['id'] = mysql_insert_id();
		}
		location('/includes/inlines/admin/page.php?id='.$_POST['id'], '<div class=imp>Page saved</div>');
	}
	else {
		location('/includes/inlines/admin/page.php', '<div class=imp>Fill all fields</div>');
	}
}
else {
	$page = sql_row('SELECT * FROM pages WHERE id="'.intval($_REQUEST['id']).'" AND lang="'.$_COOKIE['lang'].'"');
	if (empty($page)) {
		if (!isset($_REQUEST['position'])) {
			$page['position'] = intval(sql_get('SELECT MAX(position) FROM pages'));
		}
		else {
			$page['position'] = intval($_REQUEST['position']);
		}
	}
}
Project::getInstance()->getSmarty()->assign('page', $page);
Project::getInstance()->getSmarty()->display('../default/admin/page.tpl');
