<div class="wrapper">
<div id="line_top"></div>
	<div class="page_name">
		{t}Message{/t}
		</div>

			<table width="100%" border="0">
				<tr>
					<th class="head">{t}From{/t}:</th>
					<td style="border-bottom:1px dashed #cccccc">{$from}</td>
				</tr>
				<tr>
					<th class="head">{t}Subject{/t}:</th>
					<td style="border-bottom:1px dashed #cccccc">{$title|escape}</td>
				</tr>
				<tr valign="top">
					<th class="head" height="100px">{t}Message{/t}:</th>
					<td width="100%" style="border-bottom:1px dashed #cccccc">
						{$text|nl2br|escape}
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<a href="/user/messages.php">{t}Back to Messages{/t}</a>
					</td>
				</tr>
			</table>

</div>