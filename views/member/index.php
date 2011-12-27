<h3>Account information</h3>
<table width="100%">
	<tr>
		<td width="50%">
			<p><b>Your name:</b> <?php echo h($member->fullname); ?></p>
			<p>{if $user.payment_system=='LR'}{else}<b>Perfect Money Member ID:</b>{$user.pm_member_id}{/if}</p>
			<p><b>{if $user.payment_system=='LR'}Liberty Reserve purse{else}Perfect Money purse{/if}:</b> {$user.account}</p>
			<p><b>Registration date:</b> {$user.reg_date|date_format}</p>
			<p><b>Referral link:</b> <a href="https://{$smarty.server.HTTP_HOST}/?referral={$user.login}"
class="blue">http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}</a></p>
		</td>
		<td>
			<p><b>Account balace:</b> $ {$user.earning+$user.withdrawal+$user.bonus+$user.referral+$user.reinvest|string_format:"%.3f"}</p>
			<p><b>Deposited:</b> $ {$user.deposit|string_format:"%.3f"}</p>
			<p><b>Earned:</b> $ {$user.earning|string_format:"%.3f"}</p>
			<p><b>Withdrawn:</b> $ {$user.withdrawal|string_format:"%.3f"}</p>
		</td>
	</tr>
</table>
<p><b>HTML Code 468x60:</b></p>
<p><img src="/themes/{get_setting name='theme'}/images/468x60.gif" style="border:1px solid #cccccc"></p>
<p><textarea style="width:400px;height:50px;"><a href="http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}"><img
src="http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/themes/{get_setting name='theme'}/images/468x60.gif" border="0"></a></textarea></p>
<p><b>BB Code:</b></p>
<p><textarea style="width:400px;height:50px;">[url=http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}][img]http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/themes/{get_setting name='theme'}/images/468x60.gif[/img][/url]</textarea></p>

<p><b>HTML Code 728x90:</b></p>
<p><img src="/themes/{get_setting name='theme'}/images/728x90.gif" style="border:1px solid #cccccc"></p>
<p><textarea style="width:400px;height:50px;"><a href="http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}"><img
src="http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/themes/{get_setting name='theme'}/images/728x90.gif" border="0"></a></textarea></p>
<p><b>BB Code:</b></p>
<p><textarea style="width:400px;height:50px;">[url=http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/?referral={$user.login}][img]http{if $smarty.const.SSL}s{/if}://{$smarty.server.HTTP_HOST}/themes/{get_setting name='theme'}/images/728x90.gif[/img][/url]</textarea></p>
