{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Bad withdrawals
				</div>
				<table width="100%">
							<tr>
								<td class="head"><b>ID</b></td>
								<td class="head"><b>Amount</b></td>
								<td class="head"><b>System Balance</b></td>
								<td class="head"><b>Datetime</b></td>
							</tr>
				{foreach from=$bads item=bad_withdrawal}
							<tr valign="top">
								<td class="list">{$bad_withdrawal.id}</td>
								<td class="list">
									{$bad_withdrawal.amount}
								</td>
								<td class="list">{$bad_withdrawal.gw_balance}</td>
								<td class="list">{$bad_withdrawal.stamp|date_format:"%d.%m.%Y %H:%I:%S"}</td>
							</tr>
				{/foreach}
				</table>
		</td>
	</tr>
</table>
