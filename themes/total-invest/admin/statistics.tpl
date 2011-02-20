{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Statistics
				</div>
				<p>
					<table>
						<tr>
							<td width="170px">Deposited:</td>
							<td>$ {$deposited|string_format:"%.2f"}</td>
						</tr>
					</table>
				</p>
				<p>
					<table>
						<tr>
							<td width="170px">Reinvested:</td>
							<td>$ {$reinvested|string_format:"%.2f"}</td>
						</tr>
					</table>
				</p>
				<p>
					<table>
						<tr>
							<td width="170px">Earned:</td>
							<td>$ {$earned|string_format:"%.2f"}</td>
						</tr>
					</table>
				</p>
				<p>
					<table>
						<tr>
							<td width="170px">Withdrawn:</td>
							<td>$ {$withdrawn|string_format:"%.2f"}</td>
						</tr>
					</table>
				</p>
				<p>
					<table>
						<tr>
							<td width="170px">Referral bonuses:</td>
							<td>$ {$referral_bonuses|string_format:"%.2f"}</td>
						</tr>
					</table>
				</p>
				<p>
					<table>
						<tr>
							<td width="170px">LR Balance:</td>
							<td>$ {$lr_balance|string_format:"%.2f"}</td>
						</tr>
					</table>
				</p>
				<p>
					<table>
						<tr>
							<td width="170px">PM Balance:</td>
							<td>$ {$pm_balance|string_format:"%.2f"}</td>
						</tr>
					</table>
				</p>
				{$chart}
				<div id="my_chart"></div>
		</td>
	</tr>
</table>