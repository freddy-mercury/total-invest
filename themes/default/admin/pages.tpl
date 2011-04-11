{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Pages
				</div>
				{get_notification}
				<table width="100%" cellpadding="3">
					<tr>
						<td class="head"><b>ID</b></td>
						<td class="head"><b>Name</b></td>
						<td class="head"><b>Lang</b></td>
						<td class="head"><b>Actions</b></td>
					</tr>
					{foreach from=$pages item=page}
						<tr>
							<td class="list">{$page.id}</td>
							<td class="list">{$page.name}</td>
							<td class="list">{$page.lang}</td>
							<td class="list">
								<a href="{$smarty.server.PHP_SELF}?action=edit&id={$page.id}">Edit</a> |
								<a href="{$smarty.server.PHP_SELF}?action=delete&id={$page.id}" onclick="return confirm('Do you realy want to delete it?')">Delete</a> 
							</td>
						</tr>
					{/foreach}
				</table>
				<p><a href="{$smarty.server.PHP_SELF}?action=edit">Add new</a></p>
		</td>
		</tr>
</table>
{include file='debug.tpl'}