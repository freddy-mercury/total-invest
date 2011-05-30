<div class="wrapper">
<div id="line_top"></div>
<div id="page_name">
	{t}Personal information{/t}
		</div>
		<div>
			<div style="padding: 0pt 0.7em;" class="ui-state-highlight">
				<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
				{t}Please make sure all the information and personal data entered correctly{/t}
				</p>
			</div>
		</div><br>
		{get_notification}
		<form action="" method="POST">
		<input type="hidden" name="action" value="save">
		<table cellpadding="5" cellspacing="1" border="0" align="center">
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
			</table><br>
			<table cellpadding="5" cellspacing="1" border="0" align="center">
				<tr>
					<td>{t}Your name{/t}:</td>
					<td><input type="text" name="fullname" value="{if $smarty.post.fullname!=''}{$smarty.post.fullname}{else}{$user->fullname}{/if}"></td>
				</tr>
				<tr>
					<td nowrap>{t}Payment system{/t}:</td>
					<td>
						<select name="payment_system" disabled>
							<option value="LR" {if $smarty.post.payment_system=='LR' || $user->payment_system=='LR'}selected{/if}>Liberty Reserve</option>
							<option value="PM" {if $smarty.post.payment_system=='PM' || $user->payment_system=='PM'}selected{/if}>Perfect Money</option>
						</select>
					</td>
					<td class="hint"></td>
				</tr>
				{if $smarty.post.payment_system=='PM' || $user->payment_system=='PM'}
				<tr>
					<td>{t}Member ID{/t}:</td>
					<td><input type="text" name="pm_member_id" value="{if $smarty.post.pm_member_id!=''}{$smarty.post.pm_member_id}{else}{$user->pm_member_id}{/if}"></td>
					<td nowrap class="hint">{t}Your Perfect Money member ID{/t}</td>
				</tr>
				{/if}
				<tr>
					<td>{t}Account number{/t}:</td>
					<td><input type="text" name="account" value="{if $smarty.post.account!=''}{$smarty.post.account}{else}{$user->account}{/if}"></td>
					<td nowrap class="hint">{t}Your account number{/t}</td>
				</tr>
				<tr>
					<td>{t}Email address{/t}:</td>
					<td><input type="text" name="email" value="{if $smarty.post.email!=''}{$smarty.post.email}{else}{$user->email}{/if}"></td>
					<td nowrap class="hint">{t}Your valid e-mail address{/t}</td>
				</tr>
				{if $smarty.const.MASTER_PIN}
				<tr valign="top">
					<td colspan="3" align="center">{t}Security pin{/t}:
						{get_pin_input_field name="masterpin" length=$tpl_cfg.master_pin.length}
					</td>
				</tr>
				{/if}
				<tr>
					<td colspan="3" align="center"><input type="submit" value="{t}Save{/t}" class="button"></td>
				</tr>
			</table>
		</form>
</div>
