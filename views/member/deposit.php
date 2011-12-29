<h3>Make deposit</h3>
<p><?php echo get_notification(); ?></p>
<div class="form">
<?php
foreach ($model->plans as $plan) {
	?>
		<table width="100%">
			<tr>
				<th>Name:</th>
				<td><?php echo htmlspecialchars($plan->name); ?></td>
			</tr>
			<tr>
				<th>Minimum:</th>
				<td><?php echo floatval($plan->min); ?></td>
			</tr>
			<tr>
				<th>Maximum:</th>
				<td><?php echo floatval($plan->max); ?></td>
			</tr>
			<tr>
				<th>Percent:</th>
				<td><?php echo floatval($plan->percent); ?></td>
			</tr>
			<tr>
				<th>Periodicity:</th>
				<td><?php echo intval($plan->periodicity); ?></td>
			</tr>
			<tr>
				<th>Term:</th>
				<td><?php echo intval($plan->term); ?></td>
			</tr>
			<tr>
				<th>Days of accrual</th>
				<td><?php echo ($plan->monfri ? 'Mon - Fri' : 'Mon - Sun'); ?></td>
			</tr>
			<tr>
				<th>Minimum</th>
				<td><?php echo floatval($plan->min); ?></td>
			</tr>
		</table>
	</fieldset>
	<?php
}
?>
</div>