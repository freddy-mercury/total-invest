<?php
/**
 * @property $id
 * @property $access
 * @property $login
 * @property $password
 * @property $login_pin
 * @property $master_pin
 * @property $email
 * @property $security_question
 * @property $security_answer
 * @property $security_question2
 * @property $security_answer2
 * @property $firstname
 * @property $lastname
 * @property $birthdate
 * @property $country
 * @property $city
 * @property $zip
 * @property $address
 * @property $ecurrency
 * @property $ecurrency_purse
 * @property $referral
 * @property $alert_profile
 * @property $alert_login
 * @property $alert_withdrawal
 * @property $date_registered
 * @property $hash
 *
 * @property $balance
 */
class Member extends AbstractActiveRecord {

	public function tableName() {
		return 'members';
	}

	/**
	 *
	 * @return Member
	 */
	public static function model() {
		return parent::model();
	}

	public function __construct() {
		parent::__construct();
		$this->date_registered = App::get()->now;
	}

	public function setAttributes($values, $safeOnly = true) {
		if ($values['password'] === '')
			unset($values['password']);
		if (PINS_ENABLED) {
			if ($values['login_pin'] === '')
				unset($values['login_pin']);
			if ($values['master_pin'] === '')
				unset($values['master_pin']);
		}
		parent::setAttributes($values, $safeOnly);
	}

	public function getBalance() {
		return round(100.02, 2);
	}

}

?>
