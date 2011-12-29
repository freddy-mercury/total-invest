<?php

class Plan extends AbstractActiveRecord {

	public function tableName() {
		return 'plans';
	}

	public static function model() {
		return parent::model();
	}

}

?>
