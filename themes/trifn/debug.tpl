<small>
{php}
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
	$devinfo = new Devinfo();
	echo $devinfo->getWarnings();
	echo $devinfo->getQueries();
}
{/php}
</small>