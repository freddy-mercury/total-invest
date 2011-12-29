<?php

class Member extends AbstractActiveRecord {

	private $_messages;

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

	public function getMessages() {
		if ($this->_messages === null) {
			$this->_messages = Message::model()->findAll('member_id='.  q($this->id));
		}
		return $this->_messages;
	}

}

?>
