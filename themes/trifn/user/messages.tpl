<div class="wrapper">
<div id="line_top"></div>
	<div id="page_name">
		{t}Messages{/t}
		</div>
		<table width="100%" cellspacing="1" bgcolor="#cccccc">
			<tr>
				<td class="head" bgcolor="#f8f8f8"><b>#</b></td>
				<td class="head" bgcolor="#f8f8f8"><b>{t}From{/t}</b></td>
				<td class="head" bgcolor="#f8f8f8"><b>{t}Title{/t}</b></td>
				<td class="head" bgcolor="#f8f8f8"><b>{t}Date{/t}</b></td>
				<td class="head" bgcolor="#f8f8f8"><b>{t}Action{/t}</b></td>
			</tr>
			{assign var="i" value="1"}
			{foreach from=$messages item=message}
				<tr>
					<td class="{$class}" bgcolor="#f8f8f8">{$i++}</td>
					<td class="{$class}" bgcolor="#f8f8f8">
						{t}Support{/t}{if $message.readed==0}<sup class="imp"><small>NEW</small></sup>{/if}
					</td>
					<td class="{$class}" bgcolor="#f8f8f8">
						{$message.title|escape}
					</td>
					<td class="{$class}" bgcolor="#f8f8f8">{$message.stamp|date_format:"%b %e, %Y %H:%M"}</td>
					<td class="list" bgcolor="#f8f8f8">
						<a href="{$smarty.server.PHP_SELF}?action=read&id={$message.id}" class="blue">{t}Read{/t}</a> |
						<a href="{$smarty.server.PHP_SELF}?action=delete&id={$message.id}" class="blue">{t}Delete{/t}</a>
					</td>
				</tr>
			{/foreach}
		</table>
</div>