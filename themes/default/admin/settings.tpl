{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Settings
				</div>
				{get_notification}
				<form action="" method="POST">
				<input type="hidden" name="action" value="save">
					<table>
						{foreach from=$settings item=setting}
						<tr>
							<td width="200"><b>{$setting.name}</b></td>
							<td><input type="text" name="settings[{$setting.id}]" value="{$setting.value|escape}"></td>
							<td>{if $setting.custom == '1'}<a href="{$smarty.server.PHP_SELF}?action=delete&id={$setting.id}">X</a>{/if}</td>
						</tr>
						{/foreach}
						<tr>
							<td colspan="3" align="center"><input type="submit" value="Save" class="button"></td>
						</tr>
					</table>
				</form>
				<a name="set"></a>
				<form action="" method="POST">
				<input type="hidden" name="action" value="add">
					<table>
						<tr>
							<td><b>Name:</b></td><td><input type="text" name="name" value="{$smarty.post.name}"></td>
						</tr>
						<tr>
							<td><b>Value:</b></td><td><input type="text" name="value" value="{$smarty.post.value}"></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" value="Add" class="button"></td>
						</tr>
					</table>
				</form>
		</td>
	</tr>
</table>