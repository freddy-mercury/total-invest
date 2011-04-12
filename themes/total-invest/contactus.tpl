<div class="wrapper">
<div class="page_name">
{t}Contact us{/t}
</div>
<table border="0" width="100%">
	<tr>
		<td align="center">
		<form action="{$smarty.server.PHP_SELF}?action=send" method="POST" id="contact_us_form">
			{get_notification}
				<table>
					<tr>
						<td>{t}Email from{/t}:</td>
						<td>{if $user->login!=''}{$user->login} ({$user->email}){else}<input type="text" name="email">{/if}</td>
					</tr>
					<tr>
						<td>{t}Subject{/t}:</td>
						<td><input type="text" name="subject"></td>
					</tr>
					<tr valign="top">
						<td>{t}Message{/t}:</td>
						<td>
							<textarea name="message" cols="30" rows="5"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<span class="button" style="display: inline-block; width: 100px" onclick="$('#contact_us_form').submit()">
								<em><b>Send</b></em>
							</span>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
</div>