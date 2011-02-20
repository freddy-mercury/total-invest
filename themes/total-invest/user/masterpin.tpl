{include file='header.tpl'}
	<td class="content">
		<div class="wrapper">
		<div id="line_top"></div>
		<div class="page_name">
			{t}Security pin{/t}
				</div>
				{get_notification}
				<form action="{$smarty.server.PHP_SELF}?change=masterpin&do=save" method="POST">
						<table cellpadding="5" cellspacing="1" border="0" align="center">
							<tr valign="top">
								<td nowrap><b>{t}New Security pin{/t}:</b></td>
								<td>
									{get_pin_input_field name="newmasterpin" length=$tpl_cfg.master_pin.length}
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
								<td colspan="2" align="center"><input type="submit" value="{t}Save{/t}" class="button"></td>
							</tr>
						</table>
					</form>
		</div>
	</td>
	<td>{include file='right.tpl'}<img src="/images/spacer.gif" width="{$TD_5_WIDTH}"></td>
</tr>
{include file='footer.tpl'}