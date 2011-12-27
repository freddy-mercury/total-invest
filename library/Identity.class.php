<?php

class Identity extends AbstractComponent {

	const DURATION = 2592000;

	public function authorize() {
		if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_hash'])) {
			return $this->restore($_COOKIE['user_id'], $_COOKIE['user_hash']);
		}
		return FALSE;
	}

	public function login($login, $password, $secpin = '', $remember = true) {
		$member = reset(Member::model()->find('login=' . q($login) . ' AND password=' . q($password)));
		if ($member) {
			setcookie('user_id', $member->id, self::DURATION, '/');
			$_COOKIE['user_id'] = $member->id;
			if ($remember)
				$this->remember($member);
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
		setcookie('user_hash', $hash, self::DURATION, '/');
		$_COOKIE['user_hash'] = $hash;
		$member->hash = $hash;
		$member->save();
	}

	private function restore($user_id, $hash) {
		$member = Member::model()->findByPk($user_id);
		if ($member !== null && $member->hash == $hash) {
			return TRUE;
		}
		return FALSE;
	}

}

?>
