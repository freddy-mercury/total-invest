{include file='header.tpl'}
	<td class="content">
		<div class="wrapper">
		<div id="line_top"></div>
			<div class="page_name">
				{t}Statistics{/t}
				</div><br>
				<form action="{$smarty.server.PHP_SELF}" method="GET">
					<table width="100%" cellspacing="1" bgcolor="#cccccc">
						<tr>
							<td align="right" colspan="6" bgcolor="#f8f8f8">
								{t}Show{/t}: 
									<select name="type" onchange="this.form.submit()">
										<option value="a" {if $smarty.request.type=='a'}selected{/if}>{t}All{/t}</option>
										<option value="d" {if $smarty.request.type=='d'}selected{/if}>{t}Deposits{/t}</option>
										<option value="w" {if $smarty.request.type=='w'}selected{/if}>{t}Withdrawn{/t}</option>
										<option value="e" {if $smarty.request.type=='e'}selected{/if}>{t}Earnings{/t}</option>
										<option value="r" {if $smarty.request.type=='r'}selected{/if}>{t}Referral bonuses{/t}</option>
										<option value="b" {if $smarty.request.type=='b'}selected{/if}>{t}Bonuses{/t}</option>
									</select>
							</td>
						</tr>
						<tr>
							<th class="head" bgcolor="#f8f8f8"><b>#</b></th>
							<th class="head" bgcolor="#f8f8f8"><b>{t}Type{/t}</b></th>
							<th class="head" bgcolor="#f8f8f8"><b>{t}Plan{/t}</b></th>
							<th class="head" bgcolor="#f8f8f8"><b>{t}Amount{/t}</b></th>
							<th class="head" bgcolor="#f8f8f8"><b>{t}Date{/t}</b></th>
							<th class="head" bgcolor="#f8f8f8"><b>{t}Comment{/t}</b></th>
						</tr>
						{assign var="i" value="1"}
						{foreach from=$lines item=line}
							<tr>
								<td class="list" bgcolor="#f8f8f8">{$i++}</td>
								<td class="list" bgcolor="#f8f8f8">
									{if $line.type == 'd'}
									{t}Deposit{/t}
									{elseif $line.type == 'w'}
									{t}Withdrawal{/t}
									{elseif $line.type == 'e'}
									{t}Earning{/t}
									{elseif $line.type == 'r'}
									{t}Referral bonus{/t}
									{elseif $line.type == 'b'}
									{t}Bonus{/t}
									{/if}
								</td>
								<td class="list" bgcolor="#f8f8f8">
									{if $line.name==''}&nbsp;{else}{$line.name}{/if}
								</td>
								<td class="list" bgcolor="#f8f8f8">{$line.amount|string_format:"%.3f"} $</td>
								<td class="list" bgcolor="#f8f8f8">{$line.stamp|date_format:"%b %e, %Y %H:%M"}</td>
								<td class="list" bgcolor="#f8f8f8">{if $line.batch == ''}&nbsp;{else}{$line.batch}{/if}</td>
							</tr>
						{/foreach}
					</table>
				</form>
		</div>
	</td>
	<td>{include file='right.tpl'}<img src="/images/spacer.gif" width="{$TD_5_WIDTH}"></td>
</tr>
{include file='footer.tpl'}
