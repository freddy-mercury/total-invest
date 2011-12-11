<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?></title>
</head>
<body>
	<?php echo $content; ?>
</body>
</html>
<hr>
<?php
	echo implode('<br>', (array)$GLOBALS['errors']);
?>
