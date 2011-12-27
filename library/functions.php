<?php
function errorHandler($errno, $errmsg, $file, $line) {
    $timestamp = date('d.m.Y H:i:s');
    $err_str = $timestamp.' - ';
    $err_str .= $file.' | ';
    $err_str .= 'Line:'.$line.' - ';
    $err_str .= $errmsg;
    $err_str.="\n\n".print_r(debug_backtrace(), true).'==========================================='."\n\n";
    $file = str_replace(basename($file), '<b>'.basename($file).'</b>', $file);
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
		if (!in_array($errno, array(E_DEPRECATED, E_NOTICE))) {
			print_rr($err_str);
			die();
		}
    }
    else {
    	if (!in_array($errno, array(E_DEPRECATED, E_NOTICE))) {
			mail('kirill.komarov@gmail.com', 'Error:'. $_SERVER['HTTP_HOST'], $GLOBALS['ERROR_CODES'][$errno]
					.':'.$errmsg.'|'.$file.' at Line: <b>'.$line.'</b>'.$err_str);
			echo '<table height="100%" width="100%">
	    	<tr>
	    		<td align="center"><h2>Sorry, the site is in the maintainance mode.</h2><br>Please visit us later.</td>
	    	</tr>
	    </table>';
			exit();
			echo $errmsg;
    	}
    }
}
function exceptionHandler(Exception $exception) {
	$trace = $exception->getTrace();
	$get_trace = function($file, $line) {
		$trace = '';
		for ($i = -3; $i <= 3; $i++) {
			$trace .= ($i == -1 ? '<span style="color:red">' : '') . ($file[$line + $i] ? ($line + $i)
					. $file[$line + $i] : '') . ($i == -1 ? '</span>' : '');
		}
		return '<pre>' . $trace . '</pre>';
	};
	$exception_info = '<fieldset><legend>' . $exception->getMessage() . '</legend>' . $trace[0]['file']
			. '<br>' . $get_trace(file($trace[0]['file']), $trace[0]['line']) . '</fieldset>';
	if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
		mail('kirill.komarov@gmail.com', 'Exception:<br>'. $exception_info);
		echo '<table height="100%" width="100%">
		<tr>
			<td align="center"><h2>Sorry, the site is in the maintainance mode.</h2><br>Please visit us later.</td>
		</tr>
	</table>';
		exit(0);
	}
}
function print_rr($var, $stream = false) {
	if ($stream) {
		return '<pre>'.print_r($var, true).'</pre>';
	}
	else {
		echo '<pre>';
		print_r($var, $stream);
		echo '</pre>';
	}
}
function check_pass($pass, $length) {
	if (strlen($pass)<$length) {
		return false;
	}
	if (!preg_match('/^.*(?=.{'.$length.',})(?=.*\d)(?=.*[a-zA-Z]).*$/', $pass)) {
		return false;
	}
	return true;
}
function location($url, $message = '', $class_attr = 'error') {
	setcookie('notification', serialize(array('message' => $message, 'class_attr' => $class_attr)));
	header('Location: '.$url);
	exit();
}
function stripslashes_array($arr = array()) {
	$rs =  array();
	if ($arr && is_array($arr)) {
		foreach ($arr as $key=>$val) {
			if(is_array($val))
				$rs[$key] = stripslashes_array($val);
			else
				$rs[$key] = stripslashes($val);
		}
	}
	return $rs;
}
function get_notification() {
	if (!empty($_COOKIE['notification'])) {
		$cookie = unserialize($_COOKIE['notification']);
		$message = $cookie['message'];
		$class_attr = $cookie['class_attr'];
		setcookie('notification', '');
		return '<div class="'.$class_attr.'">'.$message.'</div>';
	}
	return '';
}
function h($string) {
	return htmlspecialchars($string);
}