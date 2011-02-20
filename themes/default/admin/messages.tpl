{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" class="content" border="0"  cellspacing="0">
	<tr valign="top">
		<td class="side">
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Messages
				</div>
				<table width="100%" cellspacing="1">
					<tr>
						<td class="head"><b>#</b></td>
						<td class="head"><b>From</b></td>
						<td class="head"><b>To</b></td>
						<td class="head"><b>Title</b></td>
						<td class="head"><b>Date</b></td>
						<td class="head"><b>Action</b></td>
					</tr>
					{assign var="i" value="1"}
					{foreach from=$messages item=message}
						{if $message.readed==0}{assign var="class" value="list_b"}{else}{assign var="class" value="list"}{/if}
						<tr>
							<td class="{$class}">{$i++}</td>
							<td class="{$class}">
								Support
							</td>
							<td class="{$class}">{$message.user_login}</td>
							<td class="{$class}">
								{$message.title|escape}
							</td>
							<td class="{$class}">{$message.stamp|date_format:"%b %e, %Y %H:%M"}</td>
							<td class="list">
								<a href="#" onclick="$('#message_{$message.id}').toggle();">View</a>
							</td>
						</tr>
						<tr style="display:none" id="message_{$message.id}" valign="top">
							<td class="{$class}"></td>
							<td class="{$class}">Text:</td>
							<td colspan="4" class="{$class}" style="text-align:left">{$message.message|nl2br|escape}</td>
						</tr>
					{/foreach}
				</table>
		</td>
	</tr>
</table>
