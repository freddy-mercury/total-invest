<?php
include_once(LIB_ROOT.'/users/user.class.php');
class Emails {
	/**
	 * User
	 *
	 * @var User
	 */
	private $user;
	/**
	 * Settings
	 *
	 * @var Settings
	 */
	public $body = '';
	public $parameters = array();
	public $subject = '';
	public $from = '';
	
	public function __construct($user_id = 0, $type = '', $parameters = array()) {
		if ($user_id) {
			$this->user = new User($user_id);
		}
		else {
			$this->user = $user_id;
		}
		$this->parameters = $parameters;
		switch($type) {
			case 'signup_notify': 
				$this->body = get_setting('signup_notify'); 
				$this->subject = 'Signup details at '.get_setting('project_name');
			break;
			case 'access_notify': 
				$this->body = get_setting('access_notify'); 
				$this->subject = 'Account access notification at '.get_setting('project_name');
			break;
			case 'change_notify': 
				$this->body = get_setting('change_notify'); 
				$this->subject = 'Account profile change notification at '.get_setting('project_name');
			break;
			case 'deposit_notify': 
				$this->body = get_setting('deposit_notify'); 
				$this->subject = 'Deposit made at '.get_setting('project_name');
			break;
			case 'withdrawal_notify': 
				$this->body = get_setting('withdrawal_notify'); 
				$this->subject = 'Withdrawal requested at '.get_setting('project_name');
			break;
			case 'forget_email':
				$this->body = get_setting('forget_email'); 
				$this->subject = 'Remembered password '.get_setting('project_name');
			break;
		}
	}
	public function send() {
		// Mail it
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: '.$this->user->fullname.' <'.$this->user->email.'>' . "\r\n";
		$headers .= 'From: '.get_setting('project_name').' <'.get_setting('project_email').'>' . "\r\n";
		mail($this->user->email, $this->subject, $this->getMessageBody(), $headers);
	}
	public function sendToSystem() {
		// Mail it
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'From: '.($this->user->id ? $this->user->login.' ('.$this->user->fullname.')' : $this->from).' <'.($this->user->id ? $this->user->email : $this->from).'>' . "\r\n";
		$headers .= 'To: '.get_setting('project_name').' <'.get_setting('project_email').'>' . "\r\n";
		mail(get_setting('project_email'), $this->subject, $this->getMessageBody(), $headers);
	}
	private function getMessageBody() {
		$body = $this->body;
		foreach ($this->parameters as $key=>$value) {
			$body = str_replace($key, $value, $body);
		}
		return htmlspecialchars_decode($body);
	}
}