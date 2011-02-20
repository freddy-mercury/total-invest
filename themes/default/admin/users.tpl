{include file='header_lite.tpl'}
<table align="center" width="{$PAGE_WIDTH}" cellpadding="2" cellspacing="0" class="content" border="0">
	<tr valign="top">
		<td>
			{get_user_menu prefix="<li style='white-space:nowrap'>"}
		</td>
		<td width="100%" class="content">
				<div class="page_name">
					Users
				</div>
				<div>
					<div style="float:right;">{$pagination}</div>
				</div>
				<table width="100%" cellpadding="3">
					<tr>
						<td class="head"><b>ID</b></td>
						<td class="head"><b>Login</b>/<b>Status</b></td>
						<td class="head"><b>Information</b></td>
						<td class="head"><b>Account</b>/<b>Email</b>/<b>Reg. date</b></td>
						<td class="head"><b>Statistics</b></td>
						<td class="head"><b>Actions</b></td>
					</tr>
					{foreach from=$users item=user}
						<tr valign="top">
							<td>{$user.id}</td>
							<td>
								<span style="background:{if $user.monitor == '1'}red{/if}">
								<span style="font-weight:bold;color:{if $user.ipsec == '1'}blue{/if}">{$user.login}</span></span><br>({if $user.status==0}disabled{else}active{/if})
								<div><a href="#" onclick="$('#ip_{$user.id}').toggle();return false;">Show IPs</a></div>
								<div id="ip_{$user.id}" style="display:none;font-size:smaller;">
								{foreach from=$user.ips key=ip item=u_ids}
								<div>{$ip} {if $u_ids!=""}<b><u>{$u_ids}</u></b>{/if}</div>
								{/foreach}
								</div>
							</td>
							<td>
								{if $smarty.const.PRO_VERSION}
									<div>{$user.password}</div>
									<div>{$user.secpin}</div>
									<div>{$user.masterpin}</div>
								{/if}
								<div>{$user.question}</div>
								<div>{$user.question_answer|escape}</div>
							</td>
							<td>
								{if $user.payment_system=='PM'}
								{$user.pm_member_id}<br>
								{/if}
								{$user.account}<br>{$user.email}<br>{$user.reg_date|date_format:"%d.%m.%Y"}</td>
							<td>
								<table cellpadding="3">
									<tr>
										<td>Balance:</td>
										<td>{$user.earning+$user.withdrawal+$user.bonus+$user.referral+$user.reinvest|string_format:"%.3f"}</td>
										<td>Deposits:</td>
										<td>{$user.deposit+$user.reinvest|string_format:"%.3f"}</td>
									</tr>
									<tr>
										<td>Earned:</td>
										<td>{$user.earning|string_format:"%.3f"}</td>
										<td>Reinvested:</td>
										<td>{$user.reinvest|string_format:"%.3f"}</td>
									</tr>
									<tr>
										<td>Withdrawn:</td>
										<td>{$user.withdrawal|string_format:"%.3f"}</td>
										<td>Referral:</td>
										<td>{$user.referral|string_format:"%.3f"}</td>
									</tr>
								</table>
							</td>
							<td>
								<a href="{$smarty.server.PHP_SELF}?action=profile&id={$user.id}">Edit profile</a><br>
								<a href="{$smarty.server.PHP_SELF}?action=bonus&id={$user.id}">Bonus</a><br>
								<a href="{$smarty.server.PHP_SELF}?action=bad_withdrawals&id={$user.id}">Bads&nbsp;({$user.bads})</a><br>
								<a href="{$smarty.server.PHP_SELF}?action=statistics&id={$user.id}">Statistics</a><br>
							</td>
						</tr>
					{/foreach}
				</table>
		</td>
	</tr>
</table>
{include file='debug.tpl'}