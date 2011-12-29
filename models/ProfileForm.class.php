<?php

class ProfileForm extends AbstractForm {

	private $_member;

	public $password, $password_repeat, $email, $login_pin, $master_pin;
	public $firstname, $lastname, $birthdate, $address, $zip, $country, $city;
	public $ecurrency, $ecurrency_purse;
	public $alert_profile, $alert_login, $alert_withdrawal;

	public function __construct(Member $member) {
		$this->_member = $member;
		$this->setAttributes($this->_member->getAttributes());
		$this->password = '';
		$this->password_repeat = '';
		$this->login_pin = '';
		$this->master_pin = '';
	}

	protected function requiredAttributes() {
		$attributes = array_flip($this->attributeNames());
		unset($attributes['password'], $attributes['password_repeat']);
		unset($attributes['login_pin'], $attributes['master_pin']);
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
		if ($this->password !== '') {
			if (!preg_match('/.{6,}/', $this->password))
				$this->addError('password', 'Password must be at least 6 symbols!');
			if ($this->password !== $this->password_repeat)
				$this->addError('password_repeat', 'Passwords must match!');
		}
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
			$this->addError('email', 'Invalid e-mail address!');
		if (PINS_ENABLED) {
			if ($this->login_pin !=='' && !preg_match('/\d{' . LOGIN_PIN_LENGTH . '}/', $this->login_pin))
				$this->addError('login_pin', 'Login pin must be ' . LOGIN_PIN_LENGTH . ' digits!');
			if ($this->master_pin !=='' && !preg_match('/\d{' . MASTER_PIN_LENGTH . '}/', $this->login_pin))
				$this->addError('login_pin', 'Master pin must be ' . MASTER_PIN_LENGTH . ' digits!');
		}
		if (!strtotime($this->birthdate))
			$this->addError('birthdate', 'Wrong format or date!');
		else
			$this->birthdate = date('Y-m-d', strtotime($this->birthdate));
		if (!isset($GLOBALS['ecurrencies'][$this->ecurrency]))
			$this->addError('ecurency', 'Invalid e-currency!');
		if (!preg_match('/^(U|X)[0-9]{1,}$/', $this->ecurrency_purse))
			$this->addError('ecurrency_purse', 'Invalid e-currency purse!');
		return parent::validate($attributes);
	}

}

?>
