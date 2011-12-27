<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;

include_once(DOC_ROOT.'/includes/authorization.php');

if (AuthController::getInstance()->isAuthorized()) {
	$user = new User(Project::getInstance()->getCurUser()->id);
	App::get()->smarty->assign('user', $user);
}
include_once(LIB_ROOT.'/recaptchalib.php');
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'send') {
	$privatekey = "6LcNwsQSAAAAAMKYE64_1FChTxf1MkF5OQBNm-t7";
	$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
	if (!$resp->is_valid) {
	  location($_SERVER['PHP_SELF'], '<p  style="color:red; font-weight:bold;">The CAPTCHA wasn\'t entered correctly. Go back and try it again.</p>');
	}
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

App::get()->smarty->assign('captcha', recaptcha_get_html('6LcNwsQSAAAAAGlQU25aUQDDUs1wFbv_j3XHZZ8b'));
App::get()->showPage('contactus.tpl');