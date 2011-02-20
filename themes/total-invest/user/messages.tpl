{include file='header.tpl'}
	<td class="content">
		<div class="wrapper">
		<div id="line_top"></div>
			<div class="page_name">
				{t}Messages{/t}
				</div>
				<table width="100%" cellspacing="1">
					<tr>
						<td class="head"><b>#</b></td>
						<td class="head"><b>{t}From{/t}</b></td>
						<td class="head"><b>{t}Title{/t}</b></td>
						<td class="head"><b>{t}Date{/t}</b></td>
						<td class="head"><b>{t}Action{/t}</b></td>
					</tr>
					{assign var="i" value="1"}
					{foreach from=$messages item=message}
						{if $message.readed==0}{assign var="class" value="list_b"}{else}{assign var="class" value="list"}{/if}
						<tr>
							<td class="{$class}">{$i++}</td>
							<td class="{$class}">
								{t}Support{/t}
							</td>
							<td class="{$class}">
								{$message.title|escape}
							</td>
							<td class="{$class}">{$message.stamp|date_format:"%b %e, %Y %H:%M"}</td>
							<td class="list">
								<a href="{$smarty.server.PHP_SELF}?action=read&id={$message.id}" class="blue">{t}Read{/t}</a> | 
								<a href="{$smarty.server.PHP_SELF}?action=delete&id={$message.id}" class="blue">{t}Delete{/t}</a>
							</td>
						</tr>
					{/foreach}
				</table>
		</div>
	</td>
	<td>{include file='right.tpl'}<img src="/images/spacer.gif" width="{$TD_5_WIDTH}"></td>
</tr>
{include file='footer.tpl'}