<h3>Make deposit</h3>
<p><?php echo get_notification(); ?></p>
<div class="form">
	<?php
    /* @var $model DepositForm */
	if (count($model->plans)) {
		?>
		<table width="100%">
			<tr>
                <th></th>
				<th>Description</th>
				<th>Min - Max</th>
                <th>Profit</th>
            </tr>
		<?php
        foreach ($model->plans as $plan) {
            ?>
            <tr>
                <td valign="top" align="center"><?php echo Html::input('radio', 'plan', $plan->id); ?></td>
                <td>
                    <strong><?php echo $plan->name; ?></strong><br>
                    <?php echo $plan->description; ?>
                    <p>
                        <?php
                            echo 'Accurals periodicity: ' . time2str($plan->periodicity) . '<br>';
                            echo 'Accurals days: ' . ($plan->monfri ? 'Monday - Friday' : 'Monday - Sunday') . '<br>';
                            echo 'Compounding: '. ($plan->compounding ? 'yes' : 'no');
                        ?>
                    </p>
                </td>
                <td nowrap="nowrap" align="center">$<?php echo number_format($plan->min) . ' &mdash; $' . number_format($plan->max); ?></td>
                <td align="center">
                    <?php
                        echo number_format($plan->percent).'%';
                        if ($plan->percent_per == 'term')
                            echo ' after ' . time2str($plan->term);
                        else
                            echo ' every ' . time2str($plan->periodicity);

                    ?>
                </td>
                <!--td><?php echo ($plan->compounding ? 'yes' : 'no'); ?></td-->
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
	}
?>
</div>