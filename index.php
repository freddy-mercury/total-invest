<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;
require_once(DOC_ROOT.'/includes/authorization.php');
$index_ctrl = new IndexController();
$index_ctrl->run();