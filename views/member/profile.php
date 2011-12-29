<h3>Profile</h3>
<?php /* @var $model ProfileForm */ ?>
<?php echo get_notification() ?>
<style>
	div.form fieldset {
		margin-right: 2%;
	}
</style>
<div class="form" style="display: table">
	<form action="/member.php?action=profile" method="POST">
		<input type="hidden" name="do" value="confirm" />
		<fieldset style="float: left;">
			<legend>Personal</legend>
			<div class="row">
				<label for="firstname">First name:</label>
				<?php echo Html::input('text', 'firstname', $model->firstname); ?>
				<span class="error"><?php echo $model->getError('firstname'); ?></span>
			</div>
			<div class="row">
				<label for="lastname">Last name:</label>
				<?php echo Html::input('text', 'lastname', $model->lastname); ?>
				<span class="error"><?php echo $model->getError('lastname'); ?></span>
			</div>
			<div class="row">
				<label for="birthdate">Birth date:</label>
				<?php echo Html::input('text', 'birthdate', $model->birthdate); ?>
				<div class="hint note">Format: MM/DD/YYYY (<?php echo date('m/d/Y'); ?>)</div>
				<span class="error"><?php echo $model->getError('birthdate'); ?></span>
			</div>
			<div class="row">
				<label for="country">Country:</label>
				<?php
				$country_options = array(0 => 'Select your country');
				$country_options = array_merge($country_options, $GLOBALS['countries']);
				echo Html::select('country', $country_options, $model->country);
				?>
				<span class="error"><?php echo $model->getError('country'); ?></span>
			</div>
			<div class="row">
				<label for="city">City:</label>
				<?php echo Html::input('text', 'city', $model->city); ?>
				<span class="error"><?php echo $model->getError('city'); ?></span>
			</div>
			<div class="row">
				<label for="zip">Zip:</label>
				<?php echo Html::input('text', 'zip', $model->zip); ?>
				<span class="error"><?php echo $model->getError('zip'); ?></span>
			</div>
			<div class="row">
				<label for="address">Address:</label>
				<?php echo Html::textarea('address', $model->address, array('rows' => 5, 'cols' => 25)); ?>
				<span class="error"><?php echo $model->getError('address'); ?></span>
			</div>
		</fieldset>
		<fieldset style="float: left;">
			<legend>Security</legend>
			<div class="row">
				<label for="password">Password:</label>
				<?php echo Html::input('password', 'password', $model->password); ?>
				<div class="hint note">Minimum 6 symbols.</div>
				<span class="error"><?php echo $model->getError('password'); ?></span>
			</div>
			<div class="row">
				<label for="password_repeat">Repeat password:</label>
				<?php echo Html::input('password', 'password_repeat', $model->password_repeat); ?>
				<span class="error"><?php echo $model->getError('password_repeat'); ?></span>
			</div>
			<div class="row">
				<label for="email">E-mail address:</label>
				<?php echo Html::input('text', 'email', $model->email); ?>
				<div class="hint note">Valid e-mail address.</div>
				<span class="error"><?php echo $model->getError('email'); ?></span>
			</div>
			<?php if (PINS_ENABLED) : ?>
				<div class="row">
					<label for="login_pin">Login pin:</label>
					<?php echo Html::pin('login_pin', LOGIN_PIN_LENGTH, $model->login_pin); ?>
					<div class="hint note"><?php echo LOGIN_PIN_LENGTH; ?> digits.</div>
					<span class="error"><?php echo $model->getError('login_pin'); ?></span>
				</div>
				<div class="row">
					<label for="master_pin">Master pin:</label>
					<?php echo Html::pin('master_pin', MASTER_PIN_LENGTH, $model->master_pin); ?>
					<div class="hint note"><?php echo MASTER_PIN_LENGTH; ?> digits.</div>
					<span class="error"><?php echo $model->getError('master_pin'); ?></span>
				</div>
			<?php endif; ?>
		</fieldset>

		<fieldset style="float: left;">
			<legend>E-currency</legend>
			<div class="row">
				<label for="country">E-currency:</label>
				<?php
				$ecurrency_options = $GLOBALS['ecurrencies'];
				echo Html::select('ecurrency', $ecurrency_options, $model->ecurrency);
				?>
				<span class="error"><?php echo $model->getError('ecurrency'); ?></span>
			</div>
			<div class="row">
				<label for="ecurrency_purse">E-currency purse:</label>
				<?php echo Html::input('text', 'ecurrency_purse', $model->ecurrency_purse); ?>
				<div class="hint note">USD purse.</div>
				<span class="error"><?php echo $model->getError('ecurrency_purse'); ?></span>
			</div>
		</fieldset>
		<fieldset style="float:left">
			<legend>Alerts</legend>
			<div class="row">
				<?php echo Html::input('checkbox', 'alert_profile', $model->alert_profile); ?>
				<label for="alert_profile" class="checkbox">On profile change</label>
				<span class="error"><?php echo $model->getError('alert_profile'); ?></span>
			</div>
			<div class="row">
				<?php echo Html::input('checkbox', 'alert_login', $model->alert_login); ?>
				<label for="alert_login" class="checkbox">On log in</label>
				<span class="error"><?php echo $model->getError('alert_login'); ?></span>
			</div>
			<div class="row">
				<?php echo Html::input('checkbox', 'alert_withdrawal', $model->alert_withdrawal); ?>
				<label for="alert_withdrawal" class="checkbox">On withdrawal</label>
				<span class="error"><?php echo $model->getError('alert_withdrawal'); ?></span>
			</div>
		</fieldset>
		<br style="clear: both" />
		<?php if (CAPTCHA_ENABLED) : ?>
		<div class="row">
				<label for="captcha">Enter CAPTCHA:</label>
				<?php echo Html::captcha() ?>
				<span class="error"><?php echo $model->getError('captcha'); ?></span>
			</div>
		<?php endif; ?>
		<div class="row">
			<?php echo Html::submit('Save'); ?>
		</div>
	</form>
</div>