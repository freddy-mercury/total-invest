<?php
	/* @var $login_form LoginForm */
?>
<h2>Login</h2>
<form action="" method="post">
	<div class="form-element">
		<label for="email">E-mail</label><br>
		<input type="text" name="Login[email]" id="email" value="">
	</div>
	<div class="form-element">
		<label for="password">Password</label><br>
		<input type="password" name="Login[password]" id="password" value="">
	</div>
	<div class="form-element">
		<input type="checkbox" name="Login[remember_me]" id="remember_me" value="1" <?php echo $login_form->remember_me ? 'checked="checked"' : '' ?>>
		<label for="remember_me">Remember me</label>
	</div>
	<?php if (App::get()->config['recaptcha']['enabled']) { ?>
		<div class="form-element">
			<?php
				require_once('recaptchalib.php');
				echo recaptcha_get_html(App::get()->config['recaptcha']['public_key']);
			?>
			<span class="error"><?php echo $login_form->getError('captcha'); ?></span>
		</div>
	<?php } ?>
	<div class="form-element">
		<input type="submit">
	</div>
</form>