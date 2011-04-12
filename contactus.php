<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;

include_once(DOC_ROOT.'/includes/authorization.php');

if (AuthController::getInstance()->isAuthorized()) {
	$user = new User(Project::getInstance()->getCurUser()->id);
	Project::getInstance()->getSmarty()->assign('user', $user);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'send') {
	if (empty($_POST['subject']) || empty($_POST['message']) || (empty($_POST['email']) && !$user->id)) {
		location($_SERVER['PHP_SELF'], '<p  style="color:red; font-weight:bold;">All fields required!</p>');
	}
	else {
		include_once(LIB_ROOT.'/emails.class.php');
		$emailer = new Emails($user->id);
		$emailer->from = $_POST['email'];
		$emailer->subject = 'From: '.($user->id ? $user->login : $emailer->from).' -> '.$_POST['subject'];
		$emailer->body = $_POST['message'];
		$emailer->sendToSystem();
		location($_SERVER['PHP_SELF'], '<p  style="color:red; font-weight:bold;">Your message has been sent to support!</p>');
	}
}
Project::getInstance()->showPage('contactus.tpl');