<?
$ACCESS_LEVEL = 1;
include_once(DOC_ROOT.'/includes/authorization.php');

App::get()->smarty->assign('user', Project::getInstance()->getCurUser());
if (isset($_REQUEST['id'])) {
	$message = new UserMessage(intval($_REQUEST['id']));
	if ($message->id) {
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'read') {
			App::get()->smarty->assign('from', 'Support');
			App::get()->smarty->assign('title', $message->title);
			App::get()->smarty->assign('text', nl2br($message->message));
			App::get()->showPage('user/message.tpl');
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
	App::get()->smarty->assign('messages', $user_messages_list->getList());
	App::get()->showPage('user/messages.tpl');
}