<?php
class Identity extends AbstractComponent {

	private static $_user;

	public function __construct() {
	}

	/**
	 * @return bool
	 */
	public function isGuest() {
		return $this->getUser() === null;
	}

	/**
	 * @return User|null
	 */
	public function getUser() {
		if (self::$_user === null) {
			if (isset($_COOKIE['user_in']) && isset($_COOKIE['user_id']))
				self::$_user = User::model()->findByPk(array('id' => $_COOKIE['user_id']));
			else
				self::$_user = $this->restore();
		}
		return self::$_user;
	}

	/**
	 * @param $email
	 * @param $password
	 * @return bool
	 */
	public function authenticate($email, $password, $remember = false) {
		$users = User::model()->find('email=' . App::get()->db->quote($email) . ' AND password=' . App::get()->db->quote(md5($password)));
		if (!empty($users)) {
			self::$_user = current($users);
			if ($remember) {
				$this->remember(self::$_user);
			}
			setcookie('user_in', true, null, '/');
			setcookie('user_id', self::$_user->id, App::get()->now + 30 * 86400, '/');
			return true;
		}
		return false;
	}

	private function remember(User $user) {
		$hash = md5($_SERVER['REMOTE_ADDR'] . App::get()->now . microtime());
		setcookie('user_hash', $hash, App::get()->now + 30 * 86400, '/');
	}

	public function logout() {
		self::$_user = null;
		setcookie('user_in', null, App::get()->now - 5*3600, '/');
		setcookie('user_id', null, App::get()->now - 5*3600, '/');
		setcookie('user_hash', null, App::get()->now - 5*3600, '/');
		session_destroy();
	}

	/**
	 * @return AbstractActiveRecord|null
	 */
	public function restore() {
		if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_hash'])) {
			$user = User::model()->findByPk(array('id' => $_COOKIE['user_id']));
			if ($user !== null && $_COOKIE['user_hash'] == $user->hash) {
				$this->remember($user);
				return $user;
			}
		}
		return null;

	}
}
