<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;
include_once(DOC_ROOT.'/includes/authorization.php');
Project::getInstance()->getSmarty()->display('news.tpl');


