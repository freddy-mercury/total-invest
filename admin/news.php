<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT.'/includes/authorization.php');

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'save') {
    if (empty ($_POST['title']) || empty ($_POST['text']) || !strtotime($_POST['datetime'])) {
        //location($_SERVER['PHP_SELF'], '<p class="imp">All fields must be valid!</p>');
    }
    else {
        $_POST = sql_escapeArray($_POST);
        sql_query('REPLACE news SET id="'.intval($_REQUEST['id']).'", title="'.$_POST['title'].'", text="'.$_POST['text'].'", datetime="'.strtotime($_POST['datetime']).'"');
        location($_SERVER['PHP_SELF'], '<p class="imp">News <u>'.$_POST['title'].'</u> has been saved!</p>');
    }
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {
   sql_query('DELETE FROM news WHERE id="'.intval($_REQUEST['id']).'"');
   location($_SERVER['PHP_SELF'], '<p class="imp">News has been deleted!</p>');
}
$result = sql_query('SELECT * FROM news ORDER by datetime DESC');
$news = array();
while ($row = mysql_fetch_assoc($result)) {
	$row = stripslashes_array($row);
    $news[$row['id']] = $row;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
    if (isset($news[intval($_REQUEST['id'])])) {
        $_POST = $news[intval($_REQUEST['id'])];
        $_POST['datetime'] = date('d.m.Y', $_POST['datetime']);
    }
}
if (empty($_POST['datetime'])) {
	$_POST['datetime'] = date('d.m.Y');
}
Project::getInstance()->getSmarty()->assign('news', $news);
Project::getInstance()->getSmarty()->display('../default/admin/news.tpl');