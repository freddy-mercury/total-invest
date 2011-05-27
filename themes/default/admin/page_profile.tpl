{include file='header_lite.tpl'}
<!-- TinyMCE -->
<script language="Javascript">
var theme = '{get_setting name="theme"}';
</script>
<script type="text/javascript" src="/javascripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/javascripts/tiny_mce/tiny_init.js"></script>
<!-- /TinyMCE -->
<table align="center" width="100%" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>{get_user_menu prefix="<li style='white-space:nowrap'>"}</td>
		<td class="content">
				{get_notification}
				<form action="" method="POST">
				<input type="hidden" name="action" value="save">
				<input type="hidden" name="id" value="{$page.id}">
					<table cellpadding="3" cellspacing="1" width="100%">
                        <tr>
							<td nowrap>Page name:</td>
							<td width="100%"><input type="text" name="name" value="{$page.name|stripslashes|escape}"></td>
						</tr>
                        <tr>
							<td nowrap>Language:</td>
							<td width="100%">{$page.lang}</td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="content" style="width:100%;height:300px">
								{$page.content|stripslashes|escape}
								</textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="submit" value="Save" class="button"> 
							</td>
						</tr>
					</table>
				</form>
		</td>
	</tr>
</table>
{include file='debug.tpl'}