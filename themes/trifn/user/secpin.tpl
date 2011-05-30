<div class="wrapper">
<div id="line_top"></div>
	<div id="page_name">
		{t}Login pin{/t}
		</div>
		{get_notification}
		<form action="{$smarty.server.PHP_SELF}?change=secpin&do=save" method="POST">
				<table cellpadding="5" cellspacing="1" border="0" align="center">
					<tr valign="top">
						<td nowrap><b>{t}Old Login pin{/t}:</b></td>
						<td>
							{get_pin_input_field name="oldsecpin" length=$tpl_cfg.login_pin.length}
						</td>
					</tr>
					<tr valign="top">
						<td nowrap><b>{t}New Login pin{/t}:</b></td>
						<td>
							{get_pin_input_field name="secpin" length=$tpl_cfg.login_pin.length}
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