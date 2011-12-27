<?php
class LoginForm extends AbstractForm {
	public $login, $password, $remember, $login_pin, $captcha_challenge, $captcha;

	public function validate($attributes = null) {
		if (CAPTCHA_ENABLED && !$this->validateCaptcha()) {
			return FALSE;
		}
		$identity = new Identity();
		if (!$identity->login($this->login, $this->password, $this->login_pin, $this->remember)) {
			$this->addError('login', 'Wrong credentials!');
		}
		return parent::validate($attributes);
	}
}

?>
