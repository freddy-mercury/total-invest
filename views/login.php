<h3>Authorization</h3>
<p><?php echo get_notification(); ?></p>
<div class="form">
	<form action="/index.php?action=login" method="POST">
		<input type="hidden" name="do" value="authorize" />
		<div class="row">
			<label for="login">Login:</label>
			<?php echo Html::input('text', 'login', $model->login, array('size' => 15)); ?>
			<span class="error"><?php echo $model->getError('login'); ?></span>
		</div>
		<div class="row">
			<label for="password">Password:</label>
			<?php echo Html::input('password', 'password', '', array('size' => 15)); ?>
		</div>
		<div class="row">
			<input type="checkbox" name="remember" id="remember" value="1" /> <label for="remember" class="checkbox">Remember me</label>
		</div>
		<div class="row">
			<a href="/index.php?action=forget">Forgot your password?</a>
		</div>
		<?php if (PINS_ENABLED) : ?>
		<div class="row">
			<label for="login_pin">Login pin:</label>
			<?php echo Html::pin('login_pin', LOGIN_PIN_LENGTH) ?>
			<span class="error"><?php echo $model->getError('login_pin'); ?></span>
		</div>
		<?php endif; ?>
		<?php if (CAPTCHA_ENABLED) : ?>
		<div class="row">
			<label for="captcha">Enter CAPTCHA:</label>
			<?php echo Html::captcha(); ?>
			<span class="error"><?php echo $model->getError('captcha'); ?></span>
		</div>
		<?php endif; ?>
		<div class="row">
			<input type="submit" value="Enter" />
		</div>
	</form>
</div>