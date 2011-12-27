<?php
/**
 * Checks if email address is valid
 *
 * @param string $email - email address
 * @param boolean $strict
 * @return boolean
 */
function check_email($email = '', $strict = false) {
$regex = $strict? 
  '/^([.0-9a-z_-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i' : 
   '/^([*+!.&#$�\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i' 
; 
if (preg_match($regex, trim($email), $matches)) { 
	return array($matches[1], $matches[2]); 
}
return false; 
}
/**
 * Returns HTML representation of PIN control
 *
 * @param string $name - input name
 * @param int $length - maxlength of PIN
 * @return string
 */
function pin_input_field($name, $length, $direction = 1) {
	$buttons = array('1','2','3','4','5','6','7','8','9','0');
	shuffle($buttons);
	$out = ' 
	<input type="password" name="'.$name.'" id="'.$name.'" value="" readonly style="width:50px" onfocus="document.getElementById(\'kbd_'.$name.'\').style.display=\'block\'" maxlength="'.$length.'" autocomplete="off">
	<div style="display:none;padding-top:5px;'.(!$direction ? 'float: left;' : '').'" id="kbd_'.$name.'">
	';
	foreach ($buttons as $i=>$button) {
		if ($i==5 && $direction) {
			$out.= '<br>';
		}
		$out.= '<input type="button" value="'.$button.'" onclick="document.getElementById(\''.$name.'\').value+=\''.$button.'\';check_length(\''.$name.'\', '.$length.');" style="width:27px;margin:1px;">';
	}
	$out.= $direction ? '<br>' : '';
	$out.= '<input type="button" value="Clear" onclick="document.getElementById(\''.$name.'\').value=\'\'" style="width:50px;">
	</div>';
	return $out;
}
function encrypt($data = '') {
	/*if (substr($data, 0, 3) != 'A@H') {
		include_once(LIB_ROOT.'/crypter.class.php');
		$crypter = new Crypter();
		return 'A@H'.$crypter->encrypt($data);
	}*/
	$out = '';
	for ($i=0; $i < strlen($data); $i++) {
		$out.= $data[$i].chr(rand(65,90)).chr(rand(65,90));
	}
	return $out;
}
function decrypt($data = '') {
	/*if (substr($data, 0, 3) == 'A@H') {
		$data = substr($data,3);
		include_once(LIB_ROOT.'/crypter.class.php');
		$crypter = new Crypter();
		return $crypter->encrypt($data);
	}*/
	$out = '';
	for ($i=0; $i < strlen($data); $i+=3) {
		$out.= $data[$i];
	}
	return $out;
}
