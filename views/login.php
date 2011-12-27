<h3>Authorization</h3>
<?php echo get_notification(); ?>
<form action="/index.php" method="POST">
	<input type="hidden" name="action" value="login" />
	<input type="hidden" name="do" value="authorize" />
	<table>
		<tr>
			<td><label for="login">Login:</label></td>
			<td><input type="text" name="login" size="15"></td>
		</tr>
		<tr>
			<td><label for="password">Password:</label></td>
			<td><input type="password" name="password" size="15"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="checkbox" name="remember" value="1"> Remember me
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<a href="/index.php?action=forget">Forgot your password?</a>
			</td>
		</tr>
		<?php if (LOGIN_PIN) : ?>
		<tr>
			<td colspan="2" align="center" class="login">
				Login pin: <?php echo get_pin_input_field($params); ?>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td colspan="2" align="center" class="login">
				<input type="submit" value="Enter" class="button">
			</td>
		</tr>
	</table>
</form>
