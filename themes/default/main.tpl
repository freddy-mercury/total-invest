{include file='header.tpl'}
	<td class="content">
		<div class="wrapper">
			<div class="page_name">
			{eval var=$cur_page.name}
			</div>
			{eval var=$cur_page.text}
		</div>
	</td>
	<td>{include file='right.tpl'}<img src="/images/spacer.gif" width="{$TD_5_WIDTH}"></td>
</tr>
{include file='footer.tpl'}