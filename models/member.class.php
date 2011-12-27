<?php

class Member extends AbstractActiveRecord {

	public function tableName() {
		return 'users';
	}

	/**
	 *
	 * @return Member
	 */
	public static function model() {
		return parent::model();
	}

}

?>
