<div class="wrapper">
	<div class="page_name">
	{t}Authorization{/t}
	</div>
	{get_notification}
	<form action="?action=login" method="POST" id="login_form">
	<table cellpadding="3" cellspacing="1" class="login" align="center" border="0">
		<tr>
			<td class="login"><label for="login">{t}Login{/t}:</label></td>
			<td><input type="text" name="login" size="10"></td>
		</tr>
		<tr>
			<td class="login"><label for="password">{t}Password{/t}:</label></td>
			<td><input type="password" name="password" size="10"></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<a href="/index.php?action=forget" class="small">{t}Forgot your password?{/t}</a>
			</td>
		</tr>
		{if $smarty.const.LOGIN_PIN}
		<tr>
			<td colspan="2" align="center" class="login">
			{t}Login pin{/t}: {get_pin_input_field name="secpin" length=$tpl_cfg.login_pin.length}
			</td>
		</tr>
		{/if}
		<tr>
			<td colspan="2" align="center" class="login">
				<span class="button" style="display: inline-block; width: 100px" onclick="$('#login_form').submit()">
					<em><b>Enter</b></em>
				</span>
			</td>
		</tr>
	</table>
	</form>
</div>