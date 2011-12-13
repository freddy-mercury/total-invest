<?php
	if (!App::get()->identity->isGuest()) {
		echo 'Welcome, '. App::get()->identity->getUser()->fullname . ' (<a href="/index/index/logout">Logout</a>)';
	}
?>