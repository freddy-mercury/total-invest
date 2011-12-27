<?php

class AbstractForm extends AbstractDomainModel {

	public $captcha_challenge, $captcha;

	protected function validateCaptcha() {
		require_once DOC_ROOT . '/library/recaptchalib.php';
		$response = recaptcha_check_answer(RECAPTCHA_PRIVATE_KEY, $_SERVER['REMOTE_ADDR'], $this->captcha_challenge, $this->captcha);
		if (!$response->is_valid) {
			$this->addError('captcha', 'Wrong CAPTCHA!');
			return FALSE;
		}
		return TRUE;
	}

}

?>
