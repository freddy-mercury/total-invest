<div class="wrapper">
<div id="line_top"></div>
		<div class="page_name">
			{t}Deposit confirmation{/t}
		</div>
		<form action="" method="POST" id="save_form">
		<input type="hidden" name="action" value="deposit">
		<table cellpadding="5" cellspacing="1" align="center">
			<tr>
				<td><b>{t}User{/t}:</b></td>
				<td>{$user.login}</td>
			</tr>
			<tr>
				<td><b>{t}Plan{/t}:</b></td>
				<td>{$plan.name}<input type="hidden" name="plan_id" value="{$plan.id}" /></td>
			</tr>
			<tr>
				<td><b>{t}Amount{/t}:</b></td>
				<td>{$smarty.post.amount|string_format:"%.3F"} USD
					<input type="hidden" name="amount" value="{$smarty.post.amount}">
				</td>
			</tr>
			<tr valign="top">
				<td><b>{t}Source{/t}:</b></td>
				<td>
					<select name="source" id="source">
						{if ($balance)>=$smarty.post.amount}
						<option value="0">{t}Account balance{/t} ({$balance|string_format:"%.3F"} USD)</option>
						{/if}
						{if $user.monitor==0}
							{if $user.payment_system=='LR'}
							<option value="LR">Liberty Reserve - {$user.account}</option>
							{/if}
							{if $user.payment_system=='PM'}
							<option value="PM">Perfect Money - {$user.account}</option>
							{/if}
						{/if}
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<span class="button" style="display: inline-block; width: 100px" onclick="$('#save_form').submit()">
						<em><b>Make deposit</b></em>
					</span>
				</td>
			</tr>
		</table>
		</form>
</div>