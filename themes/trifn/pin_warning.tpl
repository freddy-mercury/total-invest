<div class="wrapper">
	<div id="page_name">
	{t}Authorization{/t}
	</div>
	{get_notification}
	<form action="?action=pin" method="POST" id="login_form">
	<table cellpadding="3" cellspacing="1" class="login" align="center" border="0">
		<tr>
			<td class="login"><label for="login">Pin code:</label></td>
			<td><input type="text" name="pin" size="10"></td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="login">
				<input type="submit" value="Enter">
				</span>
			</td>
		</tr>
	</table>
	</form>
</div>