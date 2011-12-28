<?php

class RegisterForm extends AbstractForm {

	public $login, $password, $password_repeat, $email, $login_pin, $master_pin, $security_question,
	$security_answer, $security_question2, $security_answer2;
	public $firstname, $lastname, $birthdate, $address, $zip, $country, $city;
	public $ecurrency, $ecurrency_purse, $referral, $terms;

	private function requiredAttributes() {
		$attributes = $this->attributeNames();
		$attributes = array_flip($attributes);
		unset($attributes['referral']);
		return array_flip($attributes);
	}

	public function validate($attributes = null) {
		if (CAPTCHA_ENABLED && !$this->validateCaptcha()) {
			return FALSE;
		}
		foreach ($this->requiredAttributes() as $attribute_name) {
			if ($this->$attribute_name === '')
				$this->addError($attribute_name, 'Field cannot be blank!');
		}
		//if (!preg_match('/(?=^.{5,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[a-z]).*$/', $this->login))
		if (!preg_match('/\w{3,}/', $this->login))
			$this->addError('login', 'Login must be at least 3 symbols!');
		if (!preg_match('/.{6,}/', $this->password))
			$this->addError('password', 'Password must be at least 3 symbols!');
		if ($this->password !== $this->password_repeat)
			$this->addError('password_repeat', 'Passwords must match!');
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
			$this->addError('email', 'Invalid e-mail address!');
		if (PINS_ENABLED) {
			if (!preg_match('/\d{' . LOGIN_PIN_LENGTH . '}/', $this->login_pin))
				$this->addError('login_pin', 'Login pin must be ' . LOGIN_PIN_LENGTH . ' digits!');
			if (!preg_match('/\d{' . MASTER_PIN_LENGTH . '}/', $this->login_pin))
				$this->addError('login_pin', 'Master pin must be ' . MASTER_PIN_LENGTH . ' digits!');
		}
		if (array_search($this->security_question, $GLOBALS['q']) === FALSE) 
			$this->addError('security_question', 'Invalid security question!');
		if (array_search($this->security_question2, $GLOBALS['q']) === FALSE) 
			$this->addError('security_question', 'Invalid alternative security question!');
		if ($this->security_question === $this->security_question2) 
			$this->addError('security_question2', 'Matches to "Security question"!');
		if ($this->security_answer === $this->security_answer2) 
			$this->addError('security_answer2', 'Matches to "Security answer"!');
		if (!strtotime($this->birthdate)) 
			$this->addError('birthdate', 'Wrong format or date!');
		else
			$this->birthdate = date('Y-m-d', strtotime($this->birthdate));
		if (!isset($GLOBALS['ecurrencies'][$this->ecurrency])) 
			$this->addError('ecurency', 'Invalid e-currency!');
		if (!preg_match('/^(U|X)[0-9]{1,}$/', $this->ecurrency_purse)) 
			$this->addError('ecurrency_purse', 'Invalid e-currency purse!');
		$member = Member::model()->find('login=' . q($this->login) . ' OR email=' . q($this->email));
		if ($member !== null) {
			if ($this->login == $member->login)
				$this->addError('login', 'Login already used!');
			if ($this->email == $member->email)
				$this->addError('email', 'E-mail address already used!');
		}
		if (!(bool) $this->terms) 
			$this->addError('terms', 'Terms and conditions must be accepted!');
		return parent::validate($attributes);
	}

}

?>
