{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Statsbar
				</div>
				<form action="{$smarty.server.PHP_SELF}?action=save" method="POST">
					<table>
						<tr>
							<td colspan="2">
								{$error_message}
							</td>
						</tr>
						<tr>
							<td>Days online:</td>
							<td><input type="text" name="days_online" value="{$statistics->days_online}"></td>
						</tr>
						<tr>
							<td>Total accounts:</td>
							<td><input type="text" name="total_accounts" value="{$statistics->total_accounts}"></td>
						</tr>
						<tr>
							<td>Total deposited:</td>
							<td><input type="text" name="total_deposited" value="{$statistics->total_deposited}"></td>
						</tr>
						<tr>
							<td>Today deposited:</td>
							<td><input type="text" name="today_deposited" value="{$statistics->today_deposited}"></td>
						</tr>
						<tr>
							<td>Last deposit:</td>
							<td><input type="text" name="last_deposit" value="{$statistics->last_deposit}"></td>
						</tr>
						<tr>
							<td>Today withdrawal:</td>
							<td><input type="text" name="today_withdrawal" value="{$statistics->today_withdrawal}"></td>
						</tr>
						<tr>
							<td>Total withdraw:</td>
							<td><input type="text" name="total_withdraw" value="{$statistics->total_withdraw}"></td>
						</tr>
						<tr>
							<td>Last withdrawal:</td>
							<td><input type="text" name="last_withdrawal" value="{$statistics->last_withdrawal}"></td>
						</tr>
						<tr>
							<td>Visitors online:</td>
							<td><input type="text" name="visitors_online" value="{$statistics->visitors_online}"></td>
						</tr>
						<tr>
							<td>Members online:</td>
							<td><input type="text" name="members_online" value="{$statistics->members_online}"></td>
						</tr>
						<tr>
							<td>Newest Member:</td>
							<td><input type="text" name="newest_member" value="{$statistics->newest_member}"></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="submit" class="button" value="Save">
							</td>
						</tr>
					</table>
				</form>
		</td>
	</tr>
</table>