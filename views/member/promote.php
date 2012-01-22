<h3>Promote yourself</h3>
<p>
	Invite your friends and get referral commission to your account!
</p>
<p>
	You referral link:
	<a href="<?php echo htmlspecialchars(App::get()->base_url . '/?referral=' . $model->login); ?>">
		<?php echo htmlspecialchars(App::get()->base_url . '/?referral=' . $model->login); ?>
	</a>
</p>
<p><b>HTML Code 468x60:</b></p>
<p><img src="images/468x60.gif" style="border:1px solid #cccccc"></p>
<p><?php echo Html::textarea('img468x60', '<a href="' . App::get()->base_url . '/?referral=' . $model->login . '"><img src="'
				. App::get()->base_url . 'images/468x60.gif" border="0"></a>', array('rows' => 3, 'cols' => 70)) ?></p>
<p><b>BB Code:</b></p>
<p><?php echo Html::textarea('bb468x60', '[url=' . App::get()->base_url . '/?referral=' . $model->login . '][img]'
			. App::get()->base_url . '/images/468x60.gif[/img][/url]', array('rows' => 3, 'cols' => 70)) ?></p>

<p><b>HTML Code 728x90:</b></p>
<p><img src="images/728x90.gif" style="border:1px solid #cccccc"></p>
<p><?php echo Html::textarea('img728x90', '<a href="' . App::get()->base_url . '/?referral="><img src="'
			. App::get()->base_url . '/images/728x90.gif" border="0"></a>', array('rows' => 3, 'cols' => 70)) ?></p>
<p><b>BB Code:</b></p>
<p><?php echo Html::textarea('bb728x90', '[url=' . App::get()->base_url . '/?referral=' . $model->login . '][img]'
			. App::get()->base_url . '/images/728x90.gif[/img][/url]', array('rows' => 3, 'cols' => 70)) ?></p>
