{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Edit user: {$user.login}
				</div>
				{get_notification}
				<form action="" method="POST">
				<input type="hidden" name="id" value="{$user.id}">
				<input type="hidden" name="do" value="save">
					<table>
						<tr>
							<td>Fullname:</td>
							<td><input type="text" name="fullname" value="{$user.fullname}"></td>
						</tr>
						{if $smarty.const.QUESTIONS}
						<tr>
							<td nowrap>Security question:</td>
							<td>
								<select name="question">
									<option value="Mother's Maiden Name" {if $user.question=='Mother\'s Maiden Name'}selected{/if}>Mother's Maiden Name</option>
									<option value="City of Birth" {if $user.question=='City of Birth'}selected{/if}>City of Birth</option>
									<option value="Highschool Name" {if $user.question=='Highschool Name'}selected{/if}>Highschool Name</option>
									<option value="Name of Your First Love" {if $user.question=='Name of Your First Love'}selected{/if}>Name of Your First Love</option>
									<option value="Favorite Pet" {if $user.question=='Favorite Pet'}selected{/if}>Favorite Pet</option>
									<option value="Favorite Book" {if $user.question=='Favorite Book'}selected{/if}>Favorite Book</option>
									<option value="Favorite TV Show/Sitcom" {if $user.question=='Favorite TV Show/Sitcom'}selected{/if}>Favorite TV Show/Sitcom</option>
									<option value="Favorite Movie" {if $user.question=='Favorite Movie'}selected{/if}>Favorite Movie</option>
									<option value="Favorite Flower" {if $user.question=='Favorite Flower'}selected{/if}>Favorite Flower</option>
									<option value="Favorite Color" {if $user.question=='Favorite Color'}selected{/if}>Favorite Color</option>
								</select>
							</td>
						</tr>
						<tr>
							<td nowrap>Answer:</td>
							<td>
								<input type="text" name="question_answer" value="{$user.question_answer}">
							</td>
						</tr>
						{/if}
						<tr>
							<td nowrap>Payment system:</td>
							<td>
								{literal}
								<select name="payment_system" onchange="if (this.value=='LR') {$('#pm_member_id_tr').hide();$('#pm_member_id').attr('disabled','disabled');} else if (this.value=='PM') {$('#pm_member_id_tr').show();$('#pm_member_id').attr('disabled','');}">
								{/literal}
									<option value="LR" {if $user.payment_system=='LR'}selected{/if}>Liberty Reserve</option>
									<option value="PM" {if $user.payment_system=='PM'}selected{/if}>Perfect Money</option>
								</select>
							</td>
						</tr>
						<tr id="pm_member_id_tr" {if $user.payment_system!='PM'}style="display:none"{/if}>
							<td>Member ID:</td>
							<td><input type="text" name="pm_member_id" id="pm_member_id" value="{$user.pm_member_id}" {if $user.payment_system!='PM'}disabled{/if}></td>
						</tr>
						<tr>
							<td >Account:</td>
							<td><input type="text" name="account" value="{$user.account}"></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><input type="text" name="email" value="{$user.email}"></td>
						</tr>
						<tr>
							<td>Type:</td>
							<td>
								<select name="monitor">
									<option value="0" {if $user.monitor == 0}selected{/if}>Usual</option>
									<option value="1" {if $user.monitor == 1}selected{/if}>Monitor</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Language:</td>
							<td>
								<select name="lang">
									<option value="en" {if $user.lang == 'en'}selected{/if}>En</option>
									<option value="ru" {if $user.lang == 'ru'}selected{/if}>Ru</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Status:</td>
							<td>
								<select name="status">
									<option value="0" {if $user.status == 0}selected{/if}>Disabled</option>
									<option value="1" {if $user.status == 1}selected{/if}>Active</option>
									<!--option value="2" {if $user.status == 2}selected{/if}>Hold</option>
									<option value="3" {if $user.status == 3}selected{/if}>Hold-Withdraw</option-->
								</select>
							</td>
						</tr>
						<tr>
							<td>Access:</td>
							<td>
								<input type="radio" name="access" value="1" class="radio" {if $user.access == 1}checked{/if}> User
								<input type="radio" name="access" value="2" class="radio" {if $user.access == 2}checked{/if}> Admin
							</td>
						</tr>
						<tr>
							<td>Withdrawal limit:</td>
							<td><input type="text" name="withdrawal_limit" value="{$user.withdrawal_limit}"></td>
						</tr>
						<tr>
							<td>Daily withdrawal limit:</td>
							<td><input type="text" name="daily_withdrawal_limit" value="{$user.daily_withdrawal_limit}"></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<a href="{$smarty.server.PHP_SELF}?action=bonus&id={$user.id}">Add bonus</a> |
								<a href="{$smarty.server.PHP_SELF}?action=bad_withdrawals&id={$user.id}">Bad&nbsp;withdrawals&nbsp;({$user.bads})</a> |
								<a href="{$smarty.server.PHP_SELF}?action=message&id={$user.id}">Message</a> |
								<a href="{$smarty.server.PHP_SELF}?action=statistics&id={$user.id}">Statistics</a>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" value="Save" class="button"></td>
						</tr>
					</table>
				</form>
		</td>
	</tr>
</table>