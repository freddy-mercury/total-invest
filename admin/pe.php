<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
require_once(DOC_ROOT.'/includes/authorization.php');

$my_project = Project::getInstance();

Project::getInstance()->getCurUser()->id = intval($_GET['id']);
Project::getInstance()->getCurUser()->monitor = 0;


Project::getInstance()->processEarnings();


