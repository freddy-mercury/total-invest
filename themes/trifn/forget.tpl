<div class="wrapper">
	<div id="page_name">
	{t}Remember forgotten password{/t}
	</div>
	<div class="message">
		{$error_message}
	</div>
	<form method="POST">
	<input type="hidden" name="action" value="forget">
	<input type="hidden" name="do" value="confirm">
		<table align="center">
			<tr>
				<td>{t}Your login{/t}:</td>
				<td><input type="text" name="login"></td>
			</tr>
			<tr>
				<td>{t}Your e-mail{/t}:</td>
				<td><input type="text" name="email"></td>
			</tr>
			<tr valign="top">
			<td nowrap>{t}Security question{/t}:</td>
			<td>
				<select name="question">
					<option value="Mother's Maiden Name">{t}Mother's Maiden Name{/t}</option>
					<option value="City of Birth">{t}City of Birth{/t}</option>
					<option value="Highschool Name">{t}Highschool Name{/t}</option>
					<option value="Name of Your First Love">{t}Name of Your First Love{/t}</option>
					<option value="Favorite Pet">{t}Favorite Pet{/t}</option>
					<option value="Favorite Book">{t}Favorite Book{/t}</option>
					<option value="Favorite TV Show/Sitcom">{t}Favorite TV Show/Sitcom{/t}</option>
					<option value="Favorite Movie">{t}Favorite Movie{/t}</option>
					<option value="Favorite Flower">{t}Favorite Flower{/t}</option>
					<option value="Favorite Color">{t}Favorite Color{/t}</option>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td nowrap>{t}Answer{/t}:</td>
			<td>
				<input type="text" name="question_answer" value="">
			</td>
		</tr>
		<tr>
				<td align="center" colspan="2">
				<input type="submit" value="{t}Remember me{/t}" class="button">
				</td>
			</tr>
		</table>
	</form>
</div>