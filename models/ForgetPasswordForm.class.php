<?php

class ForgetPasswordForm extends AbstractForm {
	public $email, $security_question, $security_answer;

	public function validate($attributes = null) {
		if (CAPTCHA_ENABLED && !$this->validateCaptcha()) {
			return FALSE;
		}
		return parent::validate($attributes);
	}

	public function remind() {
		$condition = 'email='.q($this->email).'  AND security_question='. q($this->security_answer).' AND security_answer='.q($this->security_answer);
		/* @var $member Member */
		$members = Member::model()->findAll($condition);
		$member = reset($members);
		if ($member !== null && $member->login != 'admin') {
			$params = array(
				'%user_fullname%' => $member->fullname,
				'%user_login%' => $member->login,
				'%user_password%' => $member->password,
				'%user_secpin%' => $member->secpin,
				'%user_masterpin%' => $member->masterpin,
				'%project_name%' => get_setting('project_name'),
				'%project_email%' => get_setting('project_email')
			);
			include_once(LIB_ROOT.'/emails.class.php');
			$email = new Emails($member->id, 'forget_email', $params);
			$email->send();
		}
	}
}

?>
