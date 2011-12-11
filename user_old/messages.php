<?
$ACCESS_LEVEL = 1;
include_once(DOC_ROOT.'/includes/authorization.php');

Project::getInstance()->getSmarty()->assign('user', Project::getInstance()->getCurUser());
if (isset($_REQUEST['id'])) {
	$message = new UserMessage(intval($_REQUEST['id']));
	if ($message->id) {
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'read') {
			Project::getInstance()->getSmarty()->assign('from', 'Support');
			Project::getInstance()->getSmarty()->assign('title', $message->title);
			Project::getInstance()->getSmarty()->assign('text', nl2br($message->message));
			Project::getInstance()->showPage('user/message.tpl');
			$message->readed = 1;
			$message->save();
		}
		elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {
			$message->delete();
			header('Location: /user/messages.php');
		}
	}
}
else {
	$user_messages_list = new UserMessageList(Project::getInstance()->getCurUser());
	Project::getInstance()->getSmarty()->assign('messages', $user_messages_list->getList());
	Project::getInstance()->showPage('user/messages.tpl');
}