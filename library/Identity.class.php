<?php

class Identity extends AbstractComponent {

	private static $_member;
	const DURATION = 2592000;

	public function __construct() {
		$this->authorize();
	}

	public function getIsGuest() {
		return self::$_member === null;
	}

	public function authorize() {
		if (self::$_member === null) {
			if (isset($_COOKIE['user_in']))
				self::$_member = Member::model()->findByPk(intval($_COOKIE['user_in']));
			elseif (isset($_COOKIE['user_id']) && isset($_COOKIE['user_hash']))
				$this->restore();
		}
		return $this->isGuest;
	}

	/**
	 *
	 * @param type $login
	 * @param type $password
	 * @param type $secpin
	 * @param type $remember
	 * @return boolean
	 */
	public function login($login, $password, $secpin = '', $remember = true) {
		$members = Member::model()->find('login=' . q($login) . ' AND password=' . q($password));
		$member = reset($members);
		if ($member) {
			setcookie('user_in', true, null, '/');
			if ($remember)
				$this->remember($member);
			self::$_member = $member;
			return TRUE;
		}
		return FALSE;
	}

	/**
	 *
	 * @param Member $member
	 */
	private function remember($member) {
		$hash = md5(sha1($member->login . rand(-1000, 1000) . time()));
		setcookie('user_id', $member->id, App::get()->now + self::DURATION, '/');
		setcookie('user_hash', $hash, App::get()->now + self::DURATION, '/');
		$member->hash = $hash;
		$member->save();
	}

	private function restore() {
		$user_id = $_COOKIE['user_id'];
		$hash = $_COOKIE['user_hash'];
		$member = Member::model()->findByPk($user_id);
		if ($member !== null && $member->hash == $hash) {
			$this->remember($member);
			self::$_member = $member;
		}
	}

	public function logout() {
		setcookie('user_in', null, App::get()->now - 3600);
		setcookie('user_id', null, App::get()->now - 3600);
		setcookie('user_hash', null, App::get()->now - 3600);
		session_destroy();
	}

}

?>
