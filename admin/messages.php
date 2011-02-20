<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT.'/includes/authorization.php');

$user_messages_list = new UserMessageList(Project::getInstance()->getCurUser());
Project::getInstance()->getSmarty()->assign('messages', $user_messages_list->getList());
Project::getInstance()->getSmarty()->display('../default/admin/messages.tpl');