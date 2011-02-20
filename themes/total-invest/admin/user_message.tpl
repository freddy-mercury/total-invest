{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" class="content" border="0">
	<tr valign="top">
		<td class="side">
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Message to: {$user->login}
				</div>
				<form action="" method="POST">
				<input type="hidden" name="id" value="{$user_id}">
				<input type="hidden" name="action" value="message">
				<input type="hidden" name="do" value="send">
					<table align="center">
						<tr>
							<td>Subject:</td>
							<td><input type="text" name="title"></td>
						</tr>
						<tr valign="top">
							<td>Message:</td>
							<td>
								<textarea name="message" cols="30" rows="5"></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="submit" value="Send" class="button">
							</td>
						</tr>
					</table>
				</form>
		</td>
	</tr>
</table>