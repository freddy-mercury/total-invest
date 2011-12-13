<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;
include_once(DOC_ROOT.'/includes/authorization.php');
if (!empty($_REQUEST['login'])) {
	include_once(LIB_ROOT.'/users/user.class.php');
	if (UserOld::loginExist(sql_escapeStr($_REQUEST['login']))) {
            echo '<br /><span style="color:red;"><small>This login is not free</small></span>';
	}
        else {
            echo '<br /><span style="color:green;"><small>This login is free</small></span>';
        }
}
else {
    if (empty ($_REQUEST['login'])) {
        echo '';
    }
    else {
        echo '<br /><span style="color:green;"><small>This login is free</small></span>';
    }
}