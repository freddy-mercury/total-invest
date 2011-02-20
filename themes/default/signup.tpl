{include file='header.tpl'}
	<td class="content">
		<div class="wrapper">
		<div class="page_name">
					Signup
				</div>
					<form action="{$smarty.server.PHP_SELF}?action=signup" method="POST">
					<table cellpadding="3" cellspacing="1" align="center">
						<tr>
							<td colspan="3">
							<div class="">
								<div style="padding: 0pt 0.7em;" class="ui-state-highlight"> 
									<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
									Please fill out the form below to complete registration and create the investment account on the site. Before pressing the SIGN UP button, please make sure all the information and personal data entered correctly.
									</p>
								</div>
							</div>
							</td>
						</tr>
						{if $error_message>''}
						<tr>
							<td colspan="3">
							<div class="">
								<div style="padding: 0pt 0.7em;" class="ui-state-error"> 
									<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span> 
									Alert: {$error_message}</p>
								</div>
							</div>
							</td>
						</tr>
						{/if}
						<tr>
							<td nowrap>Fullname<em>*</em>:</td>
							<td><input type="text" name="fullname" value="{$signup.fullname}"></td>
							<td class="hint">Your fullname (ex: John Smith)</td>
						</tr>
						<tr>
							<td nowrap valign="top">Login<em>*</em>:</td>
							<td id="td_login"><input type="text" name="login" id="the_login" value="{$signup.login}" autocomplete="off" onchange="this.style.border='auto'" onkeyup="Signup.CheckLogin(this)"><span id="span_login"></span></td>
							<td class="hint">Login must be at least 3 symbols of letters and digits only</td>
						</tr>
						<tr>
							<td nowrap>Password<em>*</em>:</td>
							<td><input type="password" name="password" value="" autocomplete="off"></td>
							<td class="hint">Password must be at least 6 symbols of letters and digits</td>
						</tr>
						<tr>
							<td nowrap>Confirm password<em>*</em>:</td>
							<td><input type="password" name="repassword" value="" autocomplete="off"></td>
							<td class="hint">Confirm the password</td>
						</tr>
						{if $smarty.const.LOGIN_PIN}
						<tr valign="top">
							<td nowrap>Login pin<em>*</em>:</td>
							<td>
								{get_pin_input_field name="secpin_signup" length=$tpl_cfg.login_pin.length}
							</td>
							<td class="hint">{$tpl_cfg.login_pin.length} digits</td>
						</tr>
						{/if}
						{if $smarty.const.MASTER_PIN}
						<tr valign="top">
							<td nowrap>Security pin<em>*</em>:</td>
							<td>
                                {get_pin_input_field name="masterpin_signup" length=$tpl_cfg.master_pin.length}
							</td>
							<td class="hint">{$tpl_cfg.master_pin.length} digits</td>
						</tr>
						{/if}
						{if $smarty.const.QUESTIONS}
						<tr valign="top">
							<td nowrap>Security question:</td>
							<td>
								<select name="question">
									<option value="Mother's Maiden Name" {if $signup.question=="Mother's Maiden Name"}selected{/if}>Mother's Maiden Name</option>
									<option value="City of Birth" {if $signup.question=='City of Birth'}selected{/if}>City of Birth</option>
									<option value="Highschool Name" {if $signup.question=='Highschool Name'}selected{/if}>Highschool Name</option>
									<option value="Name of Your First Love" {if $signup.question=='Name of Your First Love'}selected{/if}>Name of Your First Love</option>
									<option value="Favorite Pet" {if $signup.question=='Favorite Pet'}selected{/if}>Favorite Pet</option>
									<option value="Favorite Book" {if $signup.question=='Favorite Book'}selected{/if}>Favorite Book</option>
									<option value="Favorite TV Show/Sitcom" {if $signup.question=='Favorite TV Show/Sitcom'}selected{/if}>Favorite TV Show/Sitcom</option>
									<option value="Favorite Movie" {if $signup.question=='Favorite Movie'}selected{/if}>Favorite Movie</option>
									<option value="Favorite Flower" {if $signup.question=='Favorite Flower'}selected{/if}>Favorite Flower</option>
									<option value="Favorite Color" {if $signup.question=='Favorite Color'}selected{/if}>Favorite Color</option>
								</select>
							</td>
							<td class="hint">Security question will help you to remember your password if you lost it.</td>
						</tr>
						<tr valign="top">
							<td nowrap>Answer<em>*</em>:</td>
							<td>
								<input type="text" name="question_answer" value="{$signup.question_answer}">
							</td>
							<td class="hint">Answer on your selected security question</td>
						</tr>
						{/if}
						<tr>
							<td nowrap>E-mail<em>*</em>:</td>
							<td><input type="text" name="email" value="{$signup.email}"></td>
							<td class="hint">Your valid e-mail address</td>
						</tr>
						<tr>
							<td nowrap>Payment system<em>*</em>:</td>
							<td>
								{literal}
								<select name="payment_system" onchange="if (this.value=='LR') {$('#pm_member_id_tr').hide();$('#pm_member_id').attr('disabled','disabled');} else if (this.value=='PM') {$('#pm_member_id_tr').show();$('#pm_member_id').attr('disabled','');}">
								{/literal}
									<option value="LR" {if $signup.payment_system=='LR'}selected{/if}>Liberty Reserve</option>
									<option value="PM" {if $signup.payment_system=='PM'}selected{/if}>Perfect Money</option>
								</select>
							</td>
							<td class="hint">Your account number payment system</td>
						</tr>
						<tr id="pm_member_id_tr" {if $signup.payment_system!='PM'}style="display:none;"{/if}>
							<td nowrap>Member ID<em>*</em>:</td>
							<td><input type="text" name="pm_member_id" id="pm_member_id" value="{$signup.pm_member_id}" {if $signup.payment_system!='PM'}disabled{/if}></td>
							<td class="hint">Your Perfect Money member ID</td>
						</tr>
						<tr>
							<td nowrap>Account number<em>*</em>:</td>
							<td><input type="text" name="account" value="{$signup.account}"></td>
							<td class="hint">Your account number</td>
						</tr>
						<tr>
							<td nowrap>Upline:</td>
							<td>
								{if $smarty.session.referral!=''}
								<u>{$smarty.session.referral}</u>
								<input type="hidden" name="referral" value="{$smarty.session.referral}">
								{else}
								<input type="text" name="referral" value="">
								{/if}
							</td>
							<td class="hint">Your upline account name</td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								<input type="checkbox" name="terms" value="1" class="checkbox"> I agree with <a href="/index.php?page={get_setting name="terms_page_id"}" target="_blank" class="blue">Terms and Conditions</a><em>*</em>
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								<input type="submit" value="Signup" class="button">
								<input type="reset" value="Reset" class="button">
							</td>
						</tr>
					</table>
				</form>
		</div>
	</td>
	<td>{include file='right.tpl'}<img src="/images/spacer.gif" width="{$TD_5_WIDTH}"></td>
</tr>
{include file='footer.tpl'}