<?
$str = 
  $_REQUEST["lr_paidto"].":".
  $_REQUEST["lr_paidby"].":".
  stripslashes($_REQUEST["lr_store"]).":".
  $_REQUEST["lr_amnt"].":".
  $_REQUEST["lr_transfer"].":".
  $_REQUEST["lr_currency"].":".
  get_setting('lr_store_secword');
  
//Calculating hash
if (!extension_loaded('mhash')) {
	$hash = strtoupper(hash('sha256', $str));    
}
else {
	$hash = strtoupper(bin2hex(mhash(MHASH_SHA256, $str)));
}

//Let's check that all parameters exist and match and that the hash 
//string we computed matches the hash string that was sent by LR system.
if (isset($_REQUEST["lr_paidto"]) &&  
    $_REQUEST["lr_paidto"] == strtoupper(get_setting('lr_account_deposit')) &&
    isset($_REQUEST["lr_store"]) && 
    stripslashes($_REQUEST["lr_store"]) == get_setting('lr_store') &&
    isset($_REQUEST["lr_encrypted"]) &&
    $_REQUEST["lr_encrypted"] == $hash) {

// Response was validated and you can use this verified information to 
// complete selling process.
// Enter any code here that you want to be executed after a successful 
// payment.
	$payment_id = intval($_REQUEST['payment_id']);
	$line = stripslashes_array(sql_row('select * from translines where id="'.$payment_id.'"'));
	if ($line['amount'] == $_REQUEST['lr_amnt']) {
		$query = 'update translines set stamp="'.Project::getInstance()->getNow().'", status="1", batch="'.$_REQUEST["lr_transfer"].'" where id="'.$payment_id.'"';
		sql_query($query);
		$user = stripslashes_array(sql_row('SELECT * FROM users WHERE id="'.$line['user_id'].'"'));
		if ($user['deposit_notify']) {
			include_once(LIB_ROOT.'/emails.class.php');
			$plan = stripslashes_array(sql_row('SELECT * FROM plans WHERE id="'.$line['plan_id'].'"'));
			//%user_fullname%, %user_login%, %amount%, %batch%, %access_time%, %account%, %plan_name%, %project_name%, %project_email%
			$params = array(
				'%user_fullname%' => htmlspecialchars($user['fullname']), 
				'%user_login%' => $user['login'],
				'%account%' => $_REQUEST['lr_paidby'],
				'%amount%' => $_REQUEST['lr_amnt'], 
				'%batch%' => $_REQUEST['lr_transfer'],
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
}
else {

// This block is for the code in case that the payment verification has 
// failed.
// In our example write the response to the body of the email we are 
// going to send.
  $msgBody = "Invalid response. Sent hash didn't match the computed hash.\n";
}

// Let's get all the data sent by LR and add it to our email.
$msgBody .= "Received data\n";
$reqKeys = array_keys ($_REQUEST);
foreach($reqKeys as &$key) {
  $msgBody .= $key." = ".$_REQUEST[$key].(ereg("^lr_[a-z_]*$", $key) ? " (LR)" : "")."\n";
}
// Our example sends email with the result of verification and all the 
// variables sent to this page.
if (get_setting('project_email') != "") {
  mail(get_setting('project_email'), "LR SCI Status", $msgBody.$ref_msg);
  mail('cyril.kamaro@gmail.com', "LR SCI Status", $msgBody.$ref_msg."\n");
}
