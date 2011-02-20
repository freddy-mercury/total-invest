{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Bonus: {$user.login}
				</div>
				<form action="" method="POST">
				<input type="hidden" name="action" value="bonus">
				<input type="hidden" name="do" value="save">
				<input type="hidden" name="id" value="{$user_id}">
					<table>
						<tr>
							<td>Bonus:</td>
							<td><input type="text" name="amount"></td>
						</tr>
						<tr>
							<td>Make deposit?:</td>
							<td><input type="checkbox" name="deposit" value="1">
								<select name="plan_id">
								{foreach from=$plans item=plan}
									<option value="{$plan.id}">{$plan.name}</option>
								{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td>Comment:</td>
							<td><input type="text" name="comment"></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" value="Add" class="button"></td>
						</tr>
					</table>
				</form>
		</td>
	</tr>
</table>