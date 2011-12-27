<?php

class ContactUsForm extends AbstractForm {

	public $from, $subject, $message;

	public function validate($attributes = null) {
		if (CAPTCHA_ENABLED && !$this->validateCaptcha()) {
			return FALSE;
		}
		if (empty($this->from))
			$this->addError ('from', '"From" cannot be blank!');
		if (empty($this->subject))
			$this->addError ('subject', '"Subject" cannot be blank!');
		if (empty($this->message))
			$this->addError ('message', '"Message" cannot be blank!');
		return parent::validate($attributes);
	}
}

?>
