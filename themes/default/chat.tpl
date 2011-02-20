<div style="float:left;border:1px dotted navy;width:200px;height:300px;">
	<table width="100%" height="100%">
		<tr>
			<td align="center">Live Chat!</td>
		</tr>
		<tr valign="bottom">
			<td height="100%" style="border:1px solid #cccccc;">
				<div id="chat_text" style="font-size:11px;overflow:auto;height:240px;">
				{get_chat}
				</div>
			</td>
		</tr>
		<tr>
			<td align="center"><input type="text" id="chat_input" style="width:120px;font-size:10px;"> <input type="button" value="Send" style="width:50px; font-size:11px;" class="button" onclick="Chat.Send($('#chat_input').val())"></td>
		</tr>
	</table>
</div>
{literal}
<script language="Javascript">
$(
	function () {
		setInterval("Chat.Refresh()", 5000);
	}
);
</script>
{/literal}