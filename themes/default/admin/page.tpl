{include file='header_lite.tpl'}
<!-- TinyMCE -->
<script type="text/javascript" src="/javascripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/javascripts/tiny_mce/tiny_init.js"></script>
<!-- /TinyMCE -->
<table align="center" width="100%" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td class="content">
				{get_notification}
				<form action="/includes/inlines/admin/page.php" method="POST">
				<input type="hidden" name="action" value="save">
				<input type="hidden" name="id" value="{$page.id}">
				<input type="hidden" name="position" value="{$page.position}">
					<table cellpadding="3" cellspacing="1" width="100%">
                        <tr>
							<td nowrap>Page name:</td>
							<td width="100%"><input type="text" name="name" value="{$page.name}"></td>
						</tr>
						<tr>
							<td nowrap>Set home:</td>
							<td width="100%"><input type="checkbox" name="home" value="1" {if $page.home==1}checked{/if}></td>
						</tr>
						<tr>
							<td nowrap>Show in menu:</td>
							<td width="100%"><input type="checkbox" name="menu" value="1" {if $page.show_in_menu==1}checked{/if}></td>
						</tr>
                        <tr>
							<td nowrap>Language:</td>
							<td width="100%">{$smarty.cookies.lang}</td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="text" style="width:100%;height:300px">
								{$page.text|stripslashes|escape}
								</textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" value="Save" class="button"> <input type="submit" name="submit" value="Delete" class="button"> <input type="button" value="Close" class="button" onclick="window.close()"></td>
						</tr>
					</table>
				</form>
		</td>
	</tr>
</table>
{include file=debug.tpl}