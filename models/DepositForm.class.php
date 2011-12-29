<?php

class DepositForm extends AbstractForm {

	public $plan_id, $source, $amount;

	public function getPlans() {
		return Plan::model()->findAll();
	}

}

?>
