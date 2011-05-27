<div class="wrapper">
<div id="line_top"></div>
	<div class="page_name">
			{t}Withdrawal request{/t}
		</div>
		{get_notification}
		<form action="" method="POST">
		<input type="hidden" name="action" value="withdraw">
			<table cellpaddin="5" cellspacing="1" align="center">
				<tr>
					<td><b>{if $user.payment_system=='LR'}LR{else}PM{/if} {t}account{/t}:</b></td>
					<td>{$user.account}</td>
				</tr>
				<tr>
					<td><b>{t}Available balace{/t}:</b></td>
					<td>$ {$balance|string_format:"%.3F"}</td>
				</tr>
				<tr>
					<td><b>{t}Amount to withdraw{/t}:</b></td>
					<td>$ <input type="text" name="amount" value="{$balance|string_format:"%.3F"}" style="width:50px;"> or <a href="/user/deposit.php?amount={$balance|string_format:"%.3F"}">{t}REINVEST{/t}</a></td>
				</tr>
				{if $smarty.const.MASTER_PIN}
				<tr valign="top">
					<td colspan="2" align="center">{t}Security pin{/t}:
						{get_pin_input_field name="masterpin" length=$tpl_cfg.master_pin.length}
					</td>
				</tr>
				{/if}
				<tr>
					<td colspan="2" align="center">
					<span class="button" style="display: inline-block; width: 100px" onclick="$('#save_form').submit()">
						<em><b>Confirm</b></em>
					</span>
					</td>
				</tr>
			</table>
			</form>
</div>