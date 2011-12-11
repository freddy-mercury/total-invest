<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT.'/includes/authorization.php');

if (isset($_REQUEST['submit'])) {
	$payment_system = $_REQUEST['payment_system'];
	$subject = $_REQUEST['subject'];
	$body = $_REQUEST['body'];

	switch ($payment_system) {
		case 'LR':
			$user_ids = sql_rows('SELECT id FROM users WHERE payment_system="LR"');
			break;
		case 'PM':
			$user_ids = sql_rows('SELECT id FROM users WHERE payment_system="PM"');
			break;
		default:
			$user_ids = sql_rows('SELECT id FROM users');
			break;
	}
	$user_message = new UserMessage();
	foreach ($user_ids as $user_id) {
		$user_message->id = 0;
		$user_message->message = $body;
		$user_message->title = $subject;
		$user_message->user_id = $user_id['id'];
		$user_message->stamp = Project::getInstance()->getNow();
		$user_message->save();
	}
	location($_SERVER['PHP_SELF'], '<p class="imp">'.count($user_ids).' sent.</p>');
}

$user_messages_list = new UserMessageList(Project::getInstance()->getCurUser());
Project::getInstance()->getSmarty()->assign('messages', $user_messages_list->getList());
Project::getInstance()->getSmarty()->display('../index/administrator/messages.tpl');