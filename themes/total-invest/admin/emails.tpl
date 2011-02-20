{include file='header_lite.tpl'}
<!-- TinyMCE -->
<script type="text/javascript" src="/javascripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/javascripts/tiny_mce/tiny_init.js"></script>
<!-- /TinyMCE -->
<table align="center" width="100%" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Email templates
				</div>
				{get_notification}
				<form action="{$smarty.server.PHP_SELF}?action=save" method="POST">
				<table cellpadding="3" cellspacing="1" width="100%">
					<tr>
						<td>Signup email template</td>
					</tr>
					<tr>
						<td><b>Variables:</b> <code>%user_fullname%, %user_login%, %user_password%, %user_secpin%, %user_masterpin%, %user_secpin%, %user_masterpin%, %project_name%, %project_email%</code></td>
					</tr>
					<tr>
						<td>
							<textarea name="signup_notify" style="width:100%;height:100px">
							{$signup_notify}
							</textarea>
						</td>
					</tr>
					<tr>
						<td>Account access email template</td>
					</tr>
					<tr>
						<td><b>Variables:</b> <code>%user_fullname%, %user_login%, %access_time%, %access_ip%, %project_name%, %project_email%</code></td>
					</tr>
					<tr>
						<td>
							<textarea name="access_notify" style="width:100%;height:100px">
							{$access_notify}
							</textarea>
						</td>
					</tr>
					<tr>
						<td>Profile change email template</td>
					</tr>
					<tr>
						<td><b>Variables:</b> <code>%user_fullname%, %user_login%,<!-- %changed_fields%,--> %access_ip%, %access_time%, %project_name%, %project_email%</td>
					</tr>
					<tr>
						<td>
							<textarea name="change_notify" style="width:100%;height:100px">
							{$change_notify}
							</textarea>
						</td>
					</tr>
					<tr>
						<td>Deposit email template</td>
					</tr>
					<tr>
						<td><b>Variables:</b> <code>%user_fullname%, %user_login%, %amount%, %batch%, %access_time%, %account%, %plan_name%, %project_name%, %project_email%</code></td>
					</tr>
					<tr>
						<td>
							<textarea name="deposit_notify" style="width:100%;height:100px">
							{$deposit_notify}
							</textarea>
						</td>
					</tr>
					<tr>
						<td>Withdrawal email template</td>
					</tr>
					<tr>
						<td><b>Variables:</b> <code>%user_fullname%, %user_login%, %amount%, %batch%, %access_time%, %account%, %project_name%, %project_email%</code></td>
					</tr>
					<tr>
						<td>
							<textarea name="withdrawal_notify" style="width:100%;height:100px">
							{$withdrawal_notify}
							</textarea>
						</td>
					</tr>
					<tr>
						<td>Forget email template</td>
					</tr>
					<tr>
						<td><b>Variables:</b> <code>%user_fullname%, %user_login%, %user_password%, %user_secpin%, %user_masterpin%, %user_secpin%, %user_masterpin%, %project_name%, %project_email%</code></td>
					</tr>
					<tr>
						<td>
							<textarea name="forget_email" style="width:100%;height:100px">
							{$forget_email}
							</textarea>
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
