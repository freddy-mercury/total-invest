<h3>Messages</h3>
<p><?php echo get_notification(); ?></p>
<?php
if (count($messages)) {
	?>
	<table width="100%">
		<tr>
			<th>#</th>
			<th>Subject</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
		<?php
		foreach ($messages as $message) {
			?>
			<tr>
				<td><?php echo $message->id; ?></td>
				<td>
					<?php echo htmlspecialchars($message->subject)
					. (!$message->readed ? '<img src="images/new.png" />' : ''); ?></td>
				<td><?php echo date('m/d/Y', $message->stamp); ?></td>
				<td>
					<a href="member.php?action=messages&do=read&id=<?php echo $message->id; ?>">
						<img src="images/read.png" />
					</a>
					<a href="member.php?action=messages&do=delete&id=<?php echo $message->id; ?>"
					   onclick="return confirm('Delete message #<?php echo $message->id; ?>?')">
						<img src="images/delete.png" />
					</a>
				</td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
} else {
	?>
	There are no messages.
<?php } ?>

