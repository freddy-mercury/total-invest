<div class="wrapper">
<div id="line_top"></div>
	<div class="page_name">
		{t}Message{/t}
		</div>

			<table width="100%" cellspacing="1" bgcolor="#cccccc">
				<tr>
					<td bgcolor="#f8f8f8"><b>From:</b></th>
					<td bgcolor="#f8f8f8">{$from}</td>
				</tr>
				<tr>
					<td bgcolor="#f8f8f8"><b>Subject:</b></th>
					<td bgcolor="#f8f8f8">{$title|escape}</td>
				</tr>
				<tr valign="top">
					<td bgcolor="#f8f8f8" height="100px"><b>Message:</b></th>
					<td bgcolor="#f8f8f8" width="100%">
						{$text|nl2br|escape}
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center" bgcolor="#f8f8f8">
						<a href="/user/messages.php">{t}Back to Messages{/t}</a>
					</td>
				</tr>
			</table>

</div>