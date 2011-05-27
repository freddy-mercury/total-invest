<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;

include_once(DOC_ROOT.'/includes/authorization.php');

if (AuthController::getInstance()->isAuthorized()) {
	$user = new User(Project::getInstance()->getCurUser()->id);
	Project::getInstance()->getSmarty()->assign('user', $user);
}
include_once(LIB_ROOT.'/recaptchalib.php');
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'send') {
	if (!isset($_SESSION['captcha'])) {
		$privatekey = "6LcNwsQSAAAAAMKYE64_1FChTxf1MkF5OQBNm-t7";
		$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
		if (!$resp->is_valid) {
		  location($_SERVER['PHP_SELF'], '<p  style="color:red; font-weight:bold;">The CAPTCHA wasn\'t entered correctly. Go back and try it again.</p>');
		}
		$_SESSION['captcha'] = true;
	}
	if (empty($_POST['subject']) || empty($_POST['message']) || (empty($_POST['email']) && !$user->id)) {
		$_SESSION['captcha'] = false;
		location($_SERVER['PHP_SELF'], '<p  style="color:red; font-weight:bold;">All fields required!</p>');
	}
	else {
		include_once(LIB_ROOT.'/emails.class.php');
		$emailer = new Emails($user->id);
		$emailer->from = $_POST['email'];
		$emailer->subject = 'From: '.($user->id ? $user->login : $emailer->from).' -> '.$_POST['subject'];
		$emailer->body = $_POST['message'];
		$emailer->sendToSystem();
		$_SESSION['captcha'] = false;
		location($_SERVER['PHP_SELF'], '<p  style="color:red; font-weight:bold;">Your message has been sent to support!</p>');
	}
}

Project::getInstance()->getSmarty()->assign('captcha', recaptcha_get_html('6LcNwsQSAAAAAGlQU25aUQDDUs1wFbv_j3XHZZ8b'));
Project::getInstance()->showPage('contactus.tpl');