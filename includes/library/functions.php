<?php
function getmicrotime() { 
    list($usec, $sec) = explode(" ", microtime()); 
    return ((float)$usec + (float)$sec); 
}
function getRowColor() {
	if ($GLOBALS['row'] % 2 == 0) {
		$GLOBALS['row']++;
		return ' class="c1"';
	}
	else {
		$GLOBALS['row']++;
		return ' class="c2"';
	}
}
$GLOBALS['ERROR_CODES'] = array(
	E_ERROR=>'ERROR',
	E_WARNING=>'WARNING',
	E_PARSE=>'PARSE ERROR',
	E_NOTICE=>'NOTICE',
	E_CORE_ERROR=>'CORE ERROR',
	E_CORE_WARNING=>'CORE WARNING',
	E_COMPILE_ERROR=>'COMPILE ERROR',
	E_COMPILE_WARNING=>'COMPILE WARNING',
	E_USER_ERROR=>'USER ERROR',
	E_USER_WARNING=>'USER WARNING',
	E_USER_NOTICE=>'USER NOTICE',
	E_STRICT=>'E_STRICT',
	E_DEPRECATED=>'E_DEPRECATED',
	E_USER_DEPRECATED=>'E_USER_DEPRECATED',
	E_ALL=>'E_ALL',
);
function user_log ($errno, $errmsg, $file, $line) {
    // время события
    $timestamp = date('d.m.Y H:i:s');
    //формируем новую строку в логе
    $err_str = $timestamp.' - ';
    $err_str .= $file.' | ';     
    $err_str .= 'Line:'.$line.' - '; 
    $err_str .= $errmsg; 
    $err_str.="\n\n".print_r(debug_backtrace(), true).'==========================================='."\n\n";
    $file = str_replace(basename($file), '<b>'.basename($file).'</b>', $file);
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    	$GLOBALS['warnings'][] = $GLOBALS['ERROR_CODES'][$errno].':'.$errmsg.'|'.$file.' at Line: <b>'.$line.'</b>';
    }
    else {
    	if (!in_array($errno, array(E_DEPRECATED, E_NOTICE))) {
   		mail('kirill.komarov@gmail.com', 'Error:'. $_SERVER['HTTP_HOST'], $GLOBALS['ERROR_CODES'][$errno].':'.$errmsg.'|'.$file.' at Line: <b>'.$line.'</b>'.$err_str);
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
function submenu($submenu) {
	echo '<table align="center">
		<tr>';
	foreach ($submenu as $text=>$link) {
		if ($_SERVER['PHP_SELF'] == $link) {
			$class = 'menu_pressed';
			$a_class = 'navy';
		}
		else {
			$class = 'menu_default';
			$a_class = 'white';
		}
		echo '<td class="'.$class.'"><a href="'.$link.'" class="'.$a_class.'">'.$text.'</a></td>';
	}
	echo '
		</tr>
	</table>';
}
function submenu2($submenu, $key = '', $class_a = 's1', $class_b = 's2') {
	$OUT = '<div>';
	$items = array();
	foreach ($submenu as $i=>$value) {
		if ($i == $key) {
			$class = $class_a;
		}
		else {
			$class = $class_b;
		}
		$items[] = '<span class="'.$class.'"><a href="'.$value['link'].'" class="'.$class.'">'.$value['text'].'</a></span>';
	}
	$OUT.= implode(' | ', $items);
	$OUT.= '</div>';
	return $OUT;
}
function get_limit() {
	if (isset($_REQUEST['from'])) {
            if ($_REQUEST['from'] == 'all') {
                return '';
            }
            return ' LIMIT '.$_REQUEST['from'].','.PAGE_ROWS;
	}
	else {
		return ' LIMIT 0,'.PAGE_ROWS;
	}
}
function pagination($total) {
	$pages = ceil($total/PAGE_ROWS);
	$OUT = '<div>Pages: ';
	for ($i = 1; $i <= $pages; $i++) {
		if (ceil($_REQUEST['from']/PAGE_ROWS)+1==$i && $_REQUEST['from']!='all') {
			$OUT.= '<span style="color:orange">'.$i.'</span> ';
		}
		else {
			$from = $i*PAGE_ROWS-PAGE_ROWS;
			$OUT.= '<span><a href="'.url($_SERVER['REQUEST_URI'], array('from'=>$from)).'">'.$i.'</a></span> ';
		}
	}
	$OUT.= '<span '.($_REQUEST['from']=='all' ? 'style="color:orange"' : '').'><a href="'.url($_SERVER['REQUEST_URI'], array('from'=>'all')).'" '.($_REQUEST['from']=='all' ? 'style="color:orange"' : '').'>ALL</a></span></div>';
	return $OUT;
}
function url($url, $vars = array()) {
	$tmp_url = explode('?', $url);
	$url_vars = explode('&', $tmp_url[1]);
	$url_vars_x = array();
	foreach ($url_vars as $url_var) {
		$tmp = explode('=', $url_var);
		$url_vars_x[$tmp[0]] = $tmp[1];
	}
	foreach ($vars as $key=>$var) {
		$url_vars_x[$key] = $var;
	}
	$url_vars = array();
	foreach ($url_vars_x as $key=>$url_var) {
		if (!empty($url_var)) {
			$url_vars[] = $key.'='.$url_var;
		}	
	}	
	$vars = implode('&', $url_vars);
	return $tmp_url[0].(!empty($vars) ? '?'.$vars : '');
}
function getExt($file) {
	return substr($file['name'], strrpos('.', $file['name']));
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
function location($url, $message = '') {
	setcookie('notification', $message);
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
