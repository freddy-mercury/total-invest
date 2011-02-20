<?php
include_once(LIB_ROOT.'/functions/common.php');
$GLOBALS['row'] = 0;
$GLOBALS['warnings'] = array();
$GLOBALS['stamps'] = array();
$ERROR_CODES = array(
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
	E_STRICT=>'E_STRICT'
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
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '195.68.140.26') {
    	$GLOBALS['warnings'][] = $GLOBALS['ERROR_CODES'][$errno].':'.$errmsg.'|'.$file.' at Line: <b>'.$line.'</b>';
    	print_rr($err_str);
    }
    else {
    	if ($errno != E_NOTICE) {
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
