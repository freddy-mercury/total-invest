<?php

$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT . '/includes/authorization.php');
include_once(LIB_ROOT.'/html_page.class.php');
$action = isset($_REQUEST['action']) && !empty($_REQUEST['action']) ? $_REQUEST['action'] : '';

switch ($action) {
	case 'edit':
		$id = intval($_REQUEST['id']);
		$html_page = new HtmlPage($id);
		Project::getInstance()->getSmarty()->assign('page', $html_page->toArray());
		Project::getInstance()->getSmarty()->display('../index/administrator/page_profile.tpl');
		break;
	case 'save':
		$html_page = new HtmlPage();
		$html_page->setData($_POST);
		$html_page->save();
		location($_SERVER['PHP_SELF'], '<p class="imp">Html page <u>' . htmlspecialchars($html_page->name) . '</u> saved!</p>');
		break;
	case 'delete':
		$id = intval($_REQUEST['id']);
		$html_page = new HtmlPage($id, FALSE);
		$html_page->delete();
		location($_SERVER['PHP_SELF'], '<p class="imp">Html page <u>' . htmlspecialchars($html_page->name) . '</u> deleted!</p>');
		break;
	default:
		$query = 'SELECT * FROM ' . HtmlPage::table . ' ORDER BY name';
		$html_pages_list = sql_rows($query);
		Project::getInstance()->getSmarty()->assign('pages', $html_pages_list);
		Project::getInstance()->getSmarty()->display('../index/administrator/pages.tpl');
		break;
}