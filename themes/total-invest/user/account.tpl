{include file='header.tpl'}
	<td class="content">
		<div class="wrapper">
		<div class="page_name">
			{t}Account information{/t}
				</div>
				<table width="100%">
					<tr>
						<td width="50%">
							<p><b>{t}Your name{/t}:</b> {$user.fullname|escape}</p>
							<p>{if $user.payment_system=='LR'}{else}<b>{t}Perfect Money Member ID{/t}:</b>{$user.pm_member_id}{/if}</p>
							<p><b>{if $user.payment_system=='LR'}{t}Liberty Reserve purse{/t}{else}{t}Perfect Money purse{/t}{/if}:</b> {$user.account}</p>
							<p><b>{t}Registration date{/t}:</b> {$user.reg_date|date_format}</p>
							<p><b>{t}Referral link{/t}:</b> <a href="https://{$smarty.server.HTTP_HOST}/?referral={$user.login}" 
class="blue">http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}</a></p>
						</td>
						<td>
							<p><b>{t}Account balace{/t}:</b> $ {$user.earning+$user.withdrawal+$user.bonus+$user.referral+$user.reinvest|string_format:"%.3f"}</p>
							<p><b>{t}Deposited{/t}:</b> $ {$user.deposit|string_format:"%.3f"}</p>
							<p><b>{t}Earned{/t}:</b> $ {$user.earning|string_format:"%.3f"}</p>
							<p><b>{t}Withdrawn{/t}:</b> $ {$user.withdrawal|string_format:"%.3f"}</p>
						</td>
					</tr>
				</table>
				<p><b>HTML {t}Code{/t} 468x60:</b></p>
				<p><img src="/themes/{get_setting name='theme'}/images/468x60.gif" style="border:1px solid #cccccc"></p>
				<p><textarea style="width:400px;height:50px;"><a href="http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}"><img 
src="http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/themes/{get_setting name='theme'}/images/468x60.gif" border="0"></a></textarea></p>
				<p><b>BB {t}Code{/t}:</b></p>
				<p><textarea style="width:400px;height:50px;">[url=http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}][img]http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/themes/{get_setting name='theme'}/images/468x60.gif[/img][/url]</textarea></p>
			
				<p><b>HTML {t}Code{/t} 728x90:</b></p>
				<p><img src="/themes/{get_setting name='theme'}/images/728x90.gif" style="border:1px solid #cccccc"></p>
				<p><textarea style="width:400px;height:50px;"><a href="http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}"><img 
src="http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/themes/{get_setting name='theme'}/images/728x90.gif" border="0"></a></textarea></p>
				<p><b>BB {t}Code{/t}:</b></p>
				<p><textarea style="width:400px;height:50px;">[url=http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}][img]http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/themes/{get_setting name='theme'}/images/728x90.gif[/img][/url]</textarea></p>


				
		</div>
	</td>
	<td>{include file='right.tpl'}<img src="/images/spacer.gif" width="{$TD_5_WIDTH}"></td>
</tr>
{include file='footer.tpl'}
