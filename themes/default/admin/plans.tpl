{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Plans
				</div>
				{get_notification}
				<table width="100%" cellpadding="3">
					<tr>
						<td class="head"><b>Name</b></td>
						<td class="head"><b>Type</b></td>
						<td class="head"><b>Min</b></td>
						<td class="head"><b>Max</b></td>
						<td class="head"><b>Percents</b></td>
						<td class="head"><b>Percents per periodicity</b></td>
						<td class="head"><b>Periodicity</b></td>
						<td class="head"><b>Term</b></td>
						<td class="head"><b>Working days</b></td>
						<td class="head"><b>Deposit times</b></td>
						<td class="head"><b>Comment</b></td>
						<td class="head"><b>Actions</b></td>
					</tr>
				{foreach from=$plans item=plans}
					<tr>
						<td class="list">{$plans.name}</td>
						<td class="list">
							{if $plans.type == 0}
							User's
							{elseif $plans.type == 1}
							Monitor's
							{elseif $plans.type == 2}
							User's & Monitor's
							{/if}
						</td>
						<td class="list">{$plans.min}$</td>
						<td class="list">{$plans.max}$</td>
						<td class="list">{$plans.percent}%</td>
						<td class="list">
							{if $plans.percent_per == 'term'}
							term
							{elseif $plans.percent_per == 'periodicity'}
							periodicity
							{/if}
						</td>
						<td class="list">
							{$plans.periodicy_value}{if $plans.periodicy == 3600}
							hour(s)
							{elseif $plans.periodicy == 86400}
							day(s)
							{elseif $plans.periodicy == 604800}
							week(s)
							{elseif $plans.periodicy == 2592000}
							month(s)
							{/if}
						</td>
						<td class="list">{$plans.term} days</td>
						<td class="list">{if $plans.working_days==1}yes{else}no{/if}</td>
						<td class="list">{$plans.attempts}</td>
						<td class="list">{$plans.comment}</td>
						<td class="list">
							<a href="{$smarty.server.PHP_SELF}?action=edit&id={$plans.id}">Edit</a> |
							<a href="{$smarty.server.PHP_SELF}?action=delete&id={$plans.id}" onclick="return confirm('Do you realy want to delete it?')">Delete</a> | 
							<a href="{$smarty.server.PHP_SELF}?action=status&id={$plans.id}">
							{if $plans.status==0}Enable{else}Disable{/if}
							</a>
						</td>
					</tr>
				{/foreach}
				</table>
				<p><a href="{$smarty.server.PHP_SELF}?action=add">Add new</a></p>
		</td>
	</tr>
</table>