{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
	<td class="content" width="100%">
				<div class="page_name">
					Statistics
				</div>
				<form action="" method="GET">
				<input type="hidden" name="action" value="statistics">
				<input type="hidden" name="id" value="{$user_id}">
					<table width="100%">
						<tr>
							<td align="right" colspan="6">
								Show: 
									<select name="type" onchange="this.form.submit()">
										<option value="a" {if $smarty.request.type=='a'}selected{/if}>All</option>
										<option value="d" {if $smarty.request.type=='d'}selected{/if}>Deposits</option>
										<option value="w" {if $smarty.request.type=='w'}selected{/if}>Withdrawn</option>
										<option value="e" {if $smarty.request.type=='e'}selected{/if}>Earnings</option>
										<option value="r" {if $smarty.request.type=='r'}selected{/if}>Referral bonuses</option>
										<option value="b" {if $smarty.request.type=='b'}selected{/if}>Bonuses</option>
									</select>
							</td>
						</tr>
						<tr>
							<td class="head"><b>#</b></td>
							<td class="head"><b>Type</b></td>
							<td class="head"><b>Plan</b></td>
							<td class="head"><b>Amount</b></td>
							<td class="head"><b>Date</b></td>
							<td class="head"><b>Comment</b></td>
						</tr>
						{assign var="i" value="1"}
						{foreach from=$lines item=line}
							<tr>
								<td>{$i++}</td>
								<td>
									{if $line.type == 'd'}
									Deposit
									{elseif $line.type == 'w'}
									Withdrawal
									{elseif $line.type == 'e'}
									Earning
									{elseif $line.type == 'r'}
									Referral bonus
									{elseif $line.type == 'b'}
									Bonus
									{/if}
								</td>
								<td>
									{if $line.name==''}&nbsp;{else}{$line.name}{/if}
								</td>
								<td>{$line.amount|string_format:"%.3f"} $</td>
								<td>{$line.stamp|date_format:"%b %e, %Y %H:%M"}</td>
								<td>{if $line.batch == ''}&nbsp;{else}{$line.batch}{/if}</td>
							</tr>
						{/foreach}
					</table>
				</form>
	</td>
</tr>
</table>