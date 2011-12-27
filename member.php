<?php
$ACCESS_LEVEL = ACCESS_LEVEL_USER;
require_once(DOC_ROOT.'/includes/authorization.php');
$member_ctrl = new MemberController();
$member_ctrl->run();