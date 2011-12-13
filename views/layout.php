<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="/style.css" type="text/css" />
</head>
<body>
	<div id="body">
		<div id="header">
			<h1>Header here</h1>
		</div>
		<div id="content">
			<?php echo $content; ?>
		</div>
		<div id="footer">
			<h3>Footer here</h3>
		</div>
	</div>
</body>
</html>
<hr>
<?php
	var_dump($_POST);
	var_dump($_GET);
	var_dump($_COOKIE);
	echo implode('<br>', (array)$GLOBALS['errors']);
?>
