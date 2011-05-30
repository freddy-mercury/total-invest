{if !$authorized}
<form action="?action=login" method="POST">
<input type="hidden" name="redirect" value="{$redirect_uri}">
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
			<input type="submit" value="{t}Enter{/t}" class="button">
		</td>
	</tr>
</table>
</form>
{else}
{t}Welcome{/t}, <b>{get_cur_user_login}</b>!
{/if}
