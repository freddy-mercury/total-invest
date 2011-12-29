<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" href="style.css" rel="stylesheet" />
		<link type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
		<script>
			$(function(){
				$("input:submit").button();
			});
		</script>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<h1>Header</h1>
			</div>
			<div id="navigation">
				<ul>
					<?php if (App::get()->isGuest) { ?>
					<li><a href="/index.php?action=login">Login</a></li>
					<li><a href="/index.php?action=register">Register</a></li>
					<?php } else {?>
					<li><a href="/index.php?action=logout">Logout</a></li>
					<li><a href="/member.php">Member area</a></li>
					<?php } ?>
					<li><a href="/index.php?action=contactus">Contact us</a></li>
				</ul>

			</div>
			<?php echo $content ?>
			<div id="footer" >
				<h1>Footer</h1>
			</div>
		</div>
	</body>
</html>