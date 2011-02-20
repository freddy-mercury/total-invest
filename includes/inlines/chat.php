<?php
$ACCESS_LEVEL = ACCESS_LEVEL_GUEST;
include_once(DOC_ROOT.'/includes/authorization.php');

if (isset($_REQUEST['text']) && !empty($_REQUEST['text'])) {
	$stamp = time();
	$dbh->query('
		insert into chat 
		set 
			user_id="'.intval($_SESSION['CUR_USER']->id).'",
			stamp = "'.$stamp.'",
			message = "'.mysql_escape_string(urlencode($_REQUEST['text'])).'",
			session = "'.session_id().'"
	');
}
$OUT = '';
$posts = $dbh->fetchAll($dbh->query('select * from chat order by stamp desc limit 50'));
foreach ($posts as $post) {
	$user = new User($post['user_id']);
	$user_name = $user->id ? $user->login : 'guest_'.substr($post['session'], 0, 4);
	$OUT.= '<div><b>('.$user_name.')['.date('H:i', $post['stamp']).']:</b> '.htmlspecialchars(stripslashes(urldecode($post['message']))).'</div>';
}
echo $OUT;
