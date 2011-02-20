{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Edit plan: {$plan.name}
				</div>
				{get_notification}
				<form action="" method="POST">
				<input type="hidden" name="id" value="{$plan.id}">
				<input type="hidden" name="do" value="save">
					<table cellpadding="3" cellspacing="1">
						<tr>
							<td>Plan name:</td>
							<td><input type="text" name="name" value="{$plan.name}"></td>
						</tr>
						<tr>
							<td>Plan type:</td>
							<td>
								<select name="type">
									<option value="0" {if $plan.type == 0}selected{/if}>User's</option>
									<option value="1" {if $plan.type == 1}selected{/if}>Monitor's</option>
									<option value="2" {if $plan.type == 2}selected{/if}>Public</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Min:</td>
							<td><input type="text" name="min" value="{$plan.min}">$</td>
						</tr>
						<tr>
							<td>Max:</td>
							<td><input type="text" name="max" value="{$plan.max}">$</td>
						</tr>
						<tr>
							<td>Percents:</td>
							<td>
								<input type="text" name="percent" value="{$plan.percent}">%
								<select name="percent_per">
									<option value="term" {if $plan.percent_per == 'term'}selected{/if}>term</option>
									<option value="periodicity" {if $plan.percent_per == 'periodicity'}selected{/if}>periodicity</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Periodicy:</td>
							<td>
								<input type="text" name="periodicy_value" value="{$plan.periodicy_value}">
								<select name="periodicy">
									<option value="3600" {if $plan.periodicy == 3600}selected{/if}>hour(s)</option>
									<option value="86400" {if $plan.periodicy == 86400}selected{/if}>day(s)</option>
									<option value="604800" {if $plan.periodicy == 604800}selected{/if}>week(s)</option>
									<option value="2592000" {if $plan.periodicy == 2592000}selected{/if}>month(s)</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Term:</td>
							<td><input type="text" name="term" value="{$plan.term}"> days</td>
						</tr>
						<tr>
							<td>Working days:</td>
							<td><input type="checkbox" name="working_days" value="1" {if $plan.working_days==1}checked{/if}></td>
						</tr>
						<tr>
							<td>Deposit times:</td>
							<td><input type="text" name="attempts" value="{$plan.attempts}"> </td>
						</tr>
						<tr>
							<td>Comment:</td>
							<td><input type="text" name="comment" value="{$plan.comment}"></td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" value="Save" class="button"></td>
						</tr>
					</table>
				</form>
		</td>
		</tr>
</table>