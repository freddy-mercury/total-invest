<?php

/**
 * @property Plan[] $plans
 */
class DepositForm extends AbstractForm {

	public $plan_id, $source, $amount;

	public function getPlans() {
		return Plan::model()->findAll();
	}

	public function validate($attributes = null) {
		if (CAPTCHA_ENABLED && !$this->validateCaptcha()) {
			return FALSE;
		}
		$plan = Plan::model()->findByPk($this->plan_id);
		/* @var $plan Plan */
		if ($plan === null) {
			$this->addError('plan_id', 'You have selected invalid investment plan!');
		}
		else {
			if (!isset($GLOBALS['ecurrencies'][$this->source]) && $this->source != 'BALANCE') {
				$this->addError('source', 'You have defined invalid source!');
			}
			if (
				($this->source == 'BALANCE' && $this->amount > App::get()->member->balance)
				|| ($this->amount < $plan->min || $plan->max < $this->amount)
			) {
				$this->addError('amount', 'You have defined invalid amount!');
			}
		}

		return parent::validate($attributes);
	}

	public function setAttributes($values, $safeOnly = true) {
		$values['amount'] = abs($values['amount']);
		return parent::setAttributes($values, $safeOnly);
	}

}

?>
