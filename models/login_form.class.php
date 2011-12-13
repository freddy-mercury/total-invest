<?php

class LoginForm extends AbstractModel {

	public $email;
	public $password;
	public $remember_me;
	public $captcha;

	public $recaptcha_challenge_field;
	public $recaptcha_response_field;

	public function validate($attributes = null) {
		if (App::get()->config['recaptcha']['enabled']) {
			require_once('recaptchalib.php');
			$recaptcha = recaptcha_check_answer (App::get()->config['recaptcha']['private_key'], $_SERVER['REMOTE_ADDR'],
				$this->recaptcha_challenge_field, $this->recaptcha_response_field);
			if (!$recaptcha->is_valid) {
				$this->addError('captcha', 'Captcha is not valid.');
				return false;
			}
		}
		if (!App::get()->identity->authenticate($this->email, $this->password, $this->remember_me)) {
			$this->addError('email', 'E-mail and password are not valid!');
			return false;
		}
		return parent::validate($attributes);
	}


}
