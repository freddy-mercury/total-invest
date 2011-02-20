<?php
//pin input field
function pin_input_field($name, $length) {
	$buttons = array('1','2','3','4','5','6','7','8','9','0');
	shuffle($buttons);
	$out = ' 
	<input type="password" name="'.$name.'" id="'.$name.'" value="" readonly style="width:50px" onfocus="document.getElementById(\'kbd_'.$name.'\').style.display=\'block\'" maxlength="'.$length.'" autocomplete="off">
	<div style="display:none;padding-top:5px;" id="kbd_'.$name.'">
	';
	foreach ($buttons as $i=>$button) {
		if ($i==5) {
			$out.= '<br>';
		}
		$out.= '<input type="button" value="'.$button.'" onclick="document.getElementById(\''.$name.'\').value+=\''.$button.'\';check_length(\''.$name.'\', '.$length.');" style="width:27px;margin:1px;">';
	}
	$out.= '<br>
	<input type="button" value="Clear" onclick="document.getElementById(\''.$name.'\').value=\'\'" style="width:50px;">
	</div>';
	return $out;
}