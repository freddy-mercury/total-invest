<?
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT.'/includes/authorization.php');
include_once(LIB_ROOT.'/php-ofc-library/open-flash-chart.php');

//$dates = sql_row('select min(stamp), max(stamp) from translines where type in ("w", "d") and status in (1, 2)');
$result = sql_query('
	SELECT
		stamp,
		DATE_FORMAT(FROM_UNIXTIME(stamp),"%u") as week,
		SUM(if ((type="d" and status="2") or (type="i" and status="1"),amount,0)) as deposits,
		SUM(if (type="w" and status="1",amount,0)) as withdrawals
	FROM translines
	WHERE stamp>UNIX_TIMESTAMP("2010-06-29 00:00:00")
	GROUP BY week
	HAVING
		deposits > 0 OR 
		withdrawals > 0
');
$deposits = array();
$withdrawals = array();
$weeks = array();
while ($row = mysql_fetch_assoc($result)) {
	$weeks[] = date('d.m.Y', $row['stamp']);
	$deposits[] = round($row['deposits'], 2);
	$withdrawals[] = -round($row['withdrawals'], 2);
}
//lines
$line1 = new line();
$line1->set_values( $deposits );
$line1->set_colour('#00FF00');
$line2 = new line();
$line2->set_values( $withdrawals );
$line2->set_colour('#FF0000');
//axises
$axis_x = new x_axis();
$axis_x_labels = new x_axis_labels();
$axis_x_labels->set_labels($weeks);
$axis_x->set_labels($axis_x_labels);
$axis_y = new y_axis();
$axis_y->range(0, max(max($deposits), max($withdrawals)), 1000);
//chart
$chart = new open_flash_chart();
$chart->set_y_axis($axis_y);
$chart->set_x_axis($axis_x);
$chart->add_element( $line1 );
$chart->add_element( $line2 );
$chart->set_bg_colour('#FFFFFF');
                    
echo $chart->toPrettyString();
