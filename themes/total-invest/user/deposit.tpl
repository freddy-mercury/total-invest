{include file='header.tpl'}
	<td class="content">
		<div class="wrapper">
		<div id="line_top"></div>
				<div class="page_name">
					{t}Make deposit{/t}
				</div>
				{get_notification}
				{foreach from=$plans item=plan}
				<form action="{$smarty.server.PHP_SELF}?action=pre_deposit" method="POST">
				<p>
				<table cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
					<tr>
						<th bgcolor="#f8f8f8" rowspan="2">Investment offer</th>
						<th bgcolor="#f8f8f8" colspan="2">Deposit</th>
						<th bgcolor="#f8f8f8" rowspan="2">Interest</th>
						<th bgcolor="#f8f8f8" rowspan="2">Term</th>
						<th bgcolor="#f8f8f8" rowspan="2">Working days</th>
						<th bgcolor="#f8f8f8" colspan="2">Amount</th>
						<th bgcolor="#f8f8f8" rowspan="3"><input type="hidden" name="plan_id" value="{$plan.id}"><input type="button" value="{t}Make deposit{/t}" onclick="if (getElementById('amount{$plan.id}').value=='0') alert('Incorrect amount has been defined!'); else this.form.submit();"></th>
					</tr>
					<tr>
						<th bgcolor="#f8f8f8">Min</th>
						<th bgcolor="#f8f8f8">Max</th>
						<th bgcolor="#f8f8f8">In</th>
						<th bgcolor="#f8f8f8">Out</th>
					</tr>
					<tr>
						<td bgcolor="#f8f8f8" width="100">{$plan.name}</td>
						<td bgcolor="#f8f8f8" width="70"><input type="hidden" id="min{$plan.id}" value="{$plan.min}">$ {$plan.min|string_format:"%.2f"}</td>
						<td bgcolor="#f8f8f8" width="70"><input type="hidden" id="max{$plan.id}" value="{$plan.max}">$ {$plan.max|string_format:"%.2f"}</td>
						<td bgcolor="#f8f8f8" width="50"><input type="hidden" id="percent{$plan.id}" value="{$plan.percent}">{$plan.percent|string_format:"%.2f"}&nbsp;%<input type="hidden" id="percent_per{$plan.id}" value="{$plan.percent_per}"></td>
						<input type="hidden" id="periodicy{$plan.id}" value="{$plan.periodicy}">
						<input type="hidden" id="periodicy_value{$plan.id}" value="{$plan.periodicy_value}">
						<td bgcolor="#f8f8f8" width="50"><input type="hidden" id="term{$plan.id}" value="{$plan.term}">{$plan.term} days</td>
						<td bgcolor="#f8f8f8" width="80"><input type="hidden" id="working_days{$plan.id}" value="{$plan.working_days}">{if $plan.working_days==1}{t}Mon-Fri{/t}{else}{t}Mon-Sun{/t}{/if}</td>
						<td bgcolor="#f8f8f8" width="56">$&nbsp;<input type="text" style="width:40px;" value="{$smarty.get.amount|default:0|string_format:'%.2F'}" name="amount" id="amount{$plan.id}" onkeyup="calc(this.value, '{$plan.id}')"></td>
						<td bgcolor="#f8f8f8" width="50"><span style="font-size:12px; color:#AA0000; font-weight:bold" id="calc{$plan.id}">$&nbsp;0</span></td>
					</tr>
				</table>
					</form>
					{if $smarty.get.amount!=''}
					<script language="Javascript">
						calc({$smarty.get.amount}, '{$plan.id}');
					</script>
					{/if}
					</p>
				{/foreach}
		</div>
	</td>
	<td>{include file='right.tpl'}<img src="/images/spacer.gif" width="{$TD_5_WIDTH}"></td>
</tr>
{include file='footer.tpl'}
