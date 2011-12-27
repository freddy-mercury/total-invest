<h3>Remember forgotten password</h3>
<?php echo get_notification() ?>
<form method="POST">
	<input type="hidden" name="action" value="forget">
	<input type="hidden" name="do" value="confirm">
	<table>
		<tr>
			<td>Your login:</td>
			<td><input type="text" name="login"></td>
		</tr>
		<tr>
			<td>Your e-mail:</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr valign="top">
			<td nowrap>Security question:</td>
			<td>
				<select name="question">
					<option value="Mother's Maiden Name">Mother's Maiden Name</option>
					<option value="City of Birth">City of Birth</option>
					<option value="Highschool Name">Highschool Name</option>
					<option value="Name of Your First Love">Name of Your First Love</option>
					<option value="Favorite Pet">Favorite Pet</option>
					<option value="Favorite Book">Favorite Book</option>
					<option value="Favorite TV Show/Sitcom">Favorite TV Show/Sitcom</option>
					<option value="Favorite Movie">Favorite Movie</option>
					<option value="Favorite Flower">Favorite Flower</option>
					<option value="Favorite Color">Favorite Color</option>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td nowrap>Answer:</td>
			<td>
				<input type="text" name="question_answer" value="">
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
			<input type="submit" value="Remember me" class="button">
			</td>
		</tr>
	</table>
</form>