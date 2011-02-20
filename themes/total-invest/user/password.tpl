<div class="wrapper">
<div id="line_top"></div>
<div class="page_name">
	{t}Password{/t}
		</div>
		{get_notification}
		<form action="{$smarty.server.PHP_SELF}?change=password&do=save" method="POST">
			<table cellpadding="5" cellspacing="1" border="0" align="center">
				<tr valign="top">
					<td nowrap><b>{t}Old Password{/t}:</b></td>
					<td>
						<input type="password" name="oldpassword" autocomplete="off">
					</td>
				</tr>
				<tr valign="top">
					<td nowrap><b>{t}New Password{/t}:</b></td>
					<td>
						<input type="password" name="password" autocomplete="off">
					</td>
				</tr>
				{if $smarty.const.MASTER_PIN}
				<tr valign="top">
					<td colspan="2" align="center">{t}Security pin{/t}:
						{get_pin_input_field name="masterpin" length=$tpl_cfg.master_pin.length}
					</td>
				</tr>
				{/if}
				<tr>
					<td colspan="3" align="center"><input type="submit" value="{t}Save{/t}" class="button"></td>
				</tr>
			</table>
		</form>
</div>