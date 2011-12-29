<h3>Summary</h3>
<p>
	Welcome, <?php echo htmlspecialchars($member->lastname . ' ' . $member->firstname) ?>!
</p>
<p>
<style>
	table tr th {
		text-align: right;
	}
</style>
<table>
	<tr>
		<th>Balance:</th>
		<td>1000</td>
	</tr>
	<tr>
		<th>Current deposits:</th>
		<td></td>
	</tr>
	<tr>
		<th>Pending withdrawals:</th>
		<td></td>
	</tr>
	<tr>
		<th>Deposits made:</th>
		<td></td>
	</tr>
	<tr>
		<th>Withdrawals made:</th>
		<td></td>
	</tr>
	<tr>
		<th>Interest earned:</th>
		<td></td>
	</tr>
	<tr>
		<th>Referral commission earned:</th>
		<td></td>
	</tr>
</table>
</p>