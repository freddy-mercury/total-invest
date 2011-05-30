<div class="wrapper">
<div id="line_top"></div>
<div id="page_name">
	{t}Settings{/t}
		</div>
		{get_notification}
		<form action="{$smarty.server.PHP_SELF}?action=save" method="POST">
			<table cellpadding="5" cellspacing="1" border="0">
				<tr>
					<td>
						<table height="100%" cellpadding="6">
							<tr>
								<td><a href="{$smarty.server.PHP_SELF}?change=password" class="blue">{t}Change <b>Password</b>{/t}</a></td>
							</tr>
							{if $smarty.const.LOGIN_PIN}
							<tr>
								<td><a href="{$smarty.server.PHP_SELF}?change=secpin" class="blue">{t}Change <b>Login PIN</b>{/t}</a></td>
							</tr>
							{/if}
							{if $smarty.const.MASTER_PIN}
							<tr>
								<td><a href="{$smarty.server.PHP_SELF}?change=masterpin" class="blue">{t}Change <b>Security PIN</b>{/t}</a></td>
							</tr>
							{/if}
						</table>
					</td>
					<td>
						<table>
							<tr>
								<td><input type="checkbox" name="access_notify" value="1" class="checkbox" {if $smarty.post.access_notify==1}checked{/if}></td>
								<td>{t}Notify me by e-mail about Account log in{/t}</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="change_notify" value="1" class="checkbox" {if $smarty.post.change_notify==1}checked{/if}></td>
								<td>{t}Notify me by e-mail about Account changes{/t}</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="deposit_notify" value="1" class="checkbox" {if $smarty.post.deposit_notify==1}checked{/if}></td>
								<td>{t}Notify me by e-mail about Deposits details{/t}</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="withdrawal_notify" value="1" class="checkbox" {if $smarty.post.withdrawal_notify==1}checked{/if}></td>
								<td>{t}Notify me by e-mail about Withdrawal details{/t}</td>
							</tr>
						</table>
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