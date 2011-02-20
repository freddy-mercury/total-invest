{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Find transaction
				</div>
				<form action="{$smarty.server.PHP_SELF}?action=find" method="POST">
					<table>
						<tr>
							<td colspan="2" align="center">{php}echo $GLOBALS['notification'];{/php}</td>
						</tr>
						<tr>
							<td>Transaction ID:</td>
							<td><input type="text" name="transaction_id"></td>
							<td><input type="submit" value="Find" class="button"></td>
						</tr>
					</table>
				</form>
				{$transaction_details}
		</td>
	</tr>
</table>