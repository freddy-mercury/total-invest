<?php
include_once LIB_ROOT.'/users/ip_controller.class.php';
include_once LIB_ROOT.'/users/statistics.class.php';
class User {
	public $id;
	public $fullname;
	public $login;
	public $password;
	public $secpin;
	public $masterpin;
	public $email;
	public $payment_system;
	public $pm_member_id;
	public $account;
	public $status;
	public $access;
	public $reg_date;
	public $referral;
	public $access_notify;
	public $change_notify;
	public $deposit_notify;
	public $withdrawal_notify;
	public $withdrawal_limit;
	public $daily_withdrawal_limit;
	public $monitor;
	public $question;
	public $question_answer;
	public $lang;
	public $ip_ctrl;
	public $ips = array();
	public $color = '#FFFFFF';
	
	public function __construct($id = 0) {
		if (intval($id)) {
			$this->load($id);
		}
	}
	private function load($id) {
		$this->setData(sql_row('select * from users where id="'.$id.'"'));
		$this->ip_ctrl = new IpController($id);
	}
	public function setData($row) {
		$this->id = intval($row['id']);
		$this->fullname = $row['fullname'];
		$this->login = $row['login'];
		$this->password = $row['password'];
		$this->secpin = $row['secpin'];
		$this->masterpin = $row['masterpin'];
		$this->email = $row['email'];
		$this->payment_system = $row['payment_system'];
		$this->pm_member_id = $row['pm_member_id'];
		$this->account = $row['account'];
		$this->status = intval($row['status']);
		$this->access = intval($row['access']);
		$this->reg_date = $row['reg_date'];
		$this->referral = $row['referral'];
		$this->access_notify = intval($row['access_notify']);
		$this->change_notify = intval($row['change_notify']);
		$this->deposit_notify = intval($row['deposit_notify']);
		$this->withdrawal_notify = intval($row['withdrawal_notify']);
		$this->withdrawal_limit = floatval($row['withdrawal_limit']);
		$this->daily_withdrawal_limit = floatval($row['daily_withdrawal_limit']);
		$this->monitor = intval($row['monitor']);
		$this->question = $row['question'];
		$this->question_answer = $row['question_answer'];
		$this->lang = $row['lang'];
	}
	public function save() {
		$query = "
			replace into users set
				id = '{$this->id}',
				fullname = '{$this->fullname}',
				login = '{$this->login}',
				password = '{$this->password}',
				secpin = '{$this->secpin}',
				masterpin = '{$this->masterpin}',
				email = '{$this->email}',
				payment_system = '{$this->payment_system}',
				pm_member_id = '{$this->pm_member_id}',
				account = '{$this->account}',
				status = '{$this->status}',
				access = '{$this->access}',
				reg_date = '{$this->reg_date}',
				referral = '{$this->referral}',
				access_notify = '{$this->access_notify}',
				change_notify = '{$this->change_notify}',
				deposit_notify = '{$this->deposit_notify}',
				withdrawal_notify = '{$this->withdrawal_notify}',
				withdrawal_limit = '{$this->withdrawal_limit}',
				daily_withdrawal_limit = '{$this->daily_withdrawal_limit}',
				monitor = '{$this->monitor}',
				question = '{$this->question}',
				question_answer = '{$this->question_answer}',
				lang = '{$this->lang}'
		";
		sql_query($query);
		return $this->id ? $this->id : sql_insert_id();
	}
	public static function loginExist($login) {
		if (sql_get('select login from users where login="'.$login.'"')) {
			return true;
		}
		return false;
	}
	public static function emailExist($email) {
		if (sql_get('select email from users where email="'.$email.'"')) {
			return true;
		}
		return false;
	}
	public function isAdmin() {
		if ($this->access == ACCESS_LEVEL_ADMIN) {
			return true;
		}
		return false;
	}
	public function getWithdrawnToday() {
		$today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$today_end = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
		$this->stats->select = 'sum(amount)';
		$withdrawn_today = $this->stats->getLines(array('w'), 1, $today_start, $today_end);
		return $withdrawn_today[0][0];
	}
}
class UserMessageList {
	public $list;
	/**
	 * User
	 *
	 * @var User
	 */
	private $user;
	public function __construct($user) {
		$this->user = $user;
		$this->load();
	}
	public function load() {
		$result = sql_query("
			SELECT messages.*, users.login as user_login FROM messages 
			INNER JOIN users ON users.id=messages.user_id
			where 1=1 ".(!$this->user->isAdmin() ? "and user_id='{$this->user->id}'" : "")." order by readed asc,stamp desc");
		$this->list = array();
		while($message = mysql_fetch_assoc($result)) {
			$this->list[] = $message;
		}
	}
	public function getList() {
		if (empty($this->list)) $this->load();
		return $this->list;
	}
	public function getCountUnread() {
		return sql_get("SELECT COUNT(id) FROM messages WHERE user_id='{$this->user->id}' AND readed='0'");
	}
}
class UserMessage {
	public $id;
	public $user_id;
	public $title;
	public $message;
	public $readed;
	public $stamp;
	public function __construct($id = '') {
		if($id) {
			$this->id = $id;
			$this->load();
		}
	}
	public function load() {
		$this->setData(sql_row("select * from messages where id='{$this->id}' limit 1"));
	}
	public function setData($row) {
		$this->id = intval($row['id']);
		$this->user_id = intval($row['user_id']);
		$this->title = $row['title'];
		$this->message = $row['message'];
		$this->readed = intval($row['readed']);
		$this->stamp = $row['stamp'];
	}
	public function delete() {
		sql_query("delete from messages where id='{$this->id}'");
	}
	public function save() {
		$query = "
			REPLACE INTO messages SET
				id='{$this->id}',
				user_id='{$this->user_id}',
				title='".$this->title."',
				message='".$this->message."',
				readed='{$this->readed}',
				stamp='".time()."'
		";
		sql_query($query);
	}
}
