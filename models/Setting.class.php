<?php

class Setting extends AbstractActiveRecord {

	public function tableName() {
		return 'settings';
	}

	/**
	 * @return Settings
	 */
	public static function model() {
		return parent::model();
	}

}

?>
