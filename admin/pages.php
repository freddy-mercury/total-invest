<?php
exit('Depricated since 05/18/2010');
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT.'/includes/authorization.php');
include_once(LIB_ROOT.'/pages/page.class.php');
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$langs = explode(',', get_setting('langs'));
$langs = array_map('trim', $langs);
Project::getInstance()->getSmarty()->assign('langs', $langs);
switch ($action) {
	case 'edit':
		if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
			$_POST = sql_escapeArray($_POST);
                        foreach($_POST['text'] as $lang=>$text) {
                            if ($lang == 'en') {
                                sql_query('
				REPLACE pages SET
                                        id="'.$_POST['id'].'",
                                        parent_id=0,
					name="'.$text['name'].'",
					text="'.$text['text'].'",
					show_in_menu="'.$_POST['show_in_menu'].'",
					lang="en"
                                ');
                                $parent_id = mysql_insert_id();
                            }
                            else {
                                sql_query('
				REPLACE pages SET
                                        id="'.intval($text['id']).'",
                                        parent_id="'.(!$parent_id ? $_POST['id'] : $parent_id).'",
					name="'.$text['name'].'",
					text="'.$text['text'].'",
					show_in_menu="'.$_POST['show_in_menu'].'",
					lang="'.$lang.'"
                                ');
                            }
                        }
			location($_SERVER['PHP_SELF'], '<p class=imp>Page <u>'.htmlspecialchars($_POST['name']).'</u> has been saved!</p>');
		}
		$page_result = sql_query('
			SELECT * FROM pages 
			WHERE id="'.intval($_REQUEST['id']).'" OR parent_id="'.intval($_REQUEST['id']).'" ORDER BY id
        ');
		$page = array();
		if (intval($_REQUEST['id'])) {
                while($row = mysql_fetch_assoc($page_result)) {
                    if ($row['lang'] == 'en') {
                        $page = $row;
                        $page['text'] = array();
                        $page['text']['en'] = array('id'=>$row['id'], 'text' => $row['text'], 'name' => $row['name']);
                    }
                    else {
                        $page['text'][$row['lang']] = array('id'=>$row['id'], 'text' => $row['text'], 'name' => $row['name']);
                    }
                }
		}
		Project::getInstance()->getSmarty()->assign('page', $page);
		Project::getInstance()->getSmarty()->display('../default/admin/page_profile.tpl');
	break;
	case 'delete':
		sql_query('delete from pages where id="'.intval($_REQUEST['id']).'" and parent_id="'.intval($_REQUEST['id']).'"');
	default:
		$pages = array();
		$result = sql_query('
			SELECT * FROM pages WHERE parent_id=0 ORDER BY id
		');
		while ($row = mysql_fetch_assoc($result)) {
			$pages[] = $row;
		}
		Project::getInstance()->getSmarty()->assign('pages', stripslashes_array($pages));
		Project::getInstance()->getSmarty()->display('../default/admin/pages.tpl');
}