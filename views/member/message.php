<h3>Message</h3>
<style>
	table tr th {
		text-align: right;
		width: 100px;
	}
</style>
<table width="100%">
	<tr>
		<th>Subject:</th>
		<td><?php echo htmlspecialchars($model->subject); ?></td>
	</tr>
	<tr>
		<th>Date:</th>
		<td><?php echo date('m/d/Y', $model->stamp); ?></td>
	</tr>
	<tr>
		<th>Body:</th>
		<td><?php echo htmlspecialchars($model->body); ?></td>
	</tr>
</table>
<p>
	<a href="member.php?action=messages">Back to messages</a>
</p>
