{include file='header_lite.tpl'}
<!-- TinyMCE -->
<script type="text/javascript" src="/javascripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/javascripts/tiny_mce/tiny_init.js"></script>
<!-- /TinyMCE -->
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Edit page: {$page.name}
				</div>
				{get_notification}
				<form action="" method="POST">
				<input type="hidden" name="id" value="{$page.id}">
				<input type="hidden" name="do" value="save">
					<table cellpadding="3" cellspacing="1" width="100%">
						<tr>
							<td nowrap>Show in menu:</td>
							<td width="100%">
								<select name="show_in_menu">
									<option value="1" {if $page.show_in_menu==1}selected{/if}>Yes</option>
									<option value="0" {if $page.show_in_menu==0}selected{/if}>No</option>
								</select>
							</td>
						</tr>
                                                {foreach from=$langs item=lang}
                                                <tr>
							<td nowrap>Page name:</td>
							<td width="100%"><input type="text" name="text[{$lang}][name]" value="{$page.text[$lang].name}"></td>
						</tr>
                                                <tr>
							<td nowrap>Language:</td>
							<td width="100%">{$lang}</td>
						</tr>
						<tr>
							<td colspan="2">
                                                                <input type="hidden" name="text[{$lang}][id]" value="{$page.text[$lang].id}">
								<textarea name="text[{$lang}][text]" style="width:100%;height:300px">
								{$page.text[$lang].text|stripslashes|escape}
								</textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" value="Save" class="button"></td>
						</tr>
                                                {/foreach}
					</table>
				</form>
		</td>
	</tr>
</table>
{include file=debug.tpl}