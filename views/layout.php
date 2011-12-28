<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="header">
			<h1>Header</h1>
		</div>
		<br style="clear: both" />
		<div id="content">
			<?php echo $content ?>
		</div>
		<div id="footer" >
			<h1>Footer</h1>
			<?php if (App::get()->isGuest) { ?>
			<a href="/index.php?action=login">Login</a>
			<?php } else {?>
			<a href="/index.php?action=logout">Logout</a>
			<?php } ?>
			<a href="/index.php?action=contactus">Contact us</a>
			<a href="/index.php?action=register">Register</a>
		</div>
	</body>
</html>