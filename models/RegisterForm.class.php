<?php

class RegisterForm extends ProfileForm {

	public $login, $email, $security_question, $security_answer, $security_question2, $security_answer2, $referral, $terms;

	public function __construct() {
	}

	protected function requiredAttributes() {
		$attributes = array_flip($this->attributeNames());
		if (!PINS_ENABLED) {
			unset($attributes['login_pin'], $attributes['master_pin']);
		}
		unset($attributes['referral'], $attributes['alert_profile'], $attributes['alert_login'], $attributes['alert_withdrawal']);
		return array_flip($attributes);
	}

	public function validate($attributes = null) {
		parent::validate($attributes);
		if (!preg_match('/\w{3,}/', $this->login))
			$this->addError('login', 'Login must be at least 3 symbols!');
		if (array_search($this->security_question, $GLOBALS['q']) === FALSE)
			$this->addError('security_question', 'Invalid security question!');
		if (array_search($this->security_question2, $GLOBALS['q']) === FALSE)
			$this->addError('security_question', 'Invalid alternative security question!');
		if ($this->security_question === $this->security_question2)
			$this->addError('security_question2', 'Matches to "Security question"!');
		if ($this->security_answer === $this->security_answer2)
			$this->addError('security_answer2', 'Matches to "Security answer"!');
		$member = Member::model()->find('login=' . q($this->login) . ' OR email=' . q($this->email));
		if ($member !== null) {
			if ($this->login == $member->login)
				$this->addError('login', 'Login already used!');
			if ($this->email == $member->email)
				$this->addError('email', 'E-mail address already used!');
		}
		if (!(bool) $this->terms)
			$this->addError('terms', 'Terms and conditions must be accepted!');
		return !$this->hasErrors();
	}

}

?>
