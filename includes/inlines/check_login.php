<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;
include_once(DOC_ROOT.'/includes/authorization.php');
if (!empty($_REQUEST['login'])) {
	include_once(LIB_ROOT.'/users/user.class.php');
	if (User::loginExist($_REQUEST['login'])) {
            echo '<span style="color:red;">This login is not free</span>';
	}
        else {
            echo '<span style="color:green;">This login is free</span>';
        }
}
else {
    if (empty ($_REQUEST['login'])) {
        echo '';
    }
    else {
        echo '<span style="color:green;">This login is free</span>';
    }
}