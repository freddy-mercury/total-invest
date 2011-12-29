<?php

class Message extends AbstractActiveRecord {

	public function tableName() {
		return 'messages';
	}

	/**
	 *
	 * @return Message
	 */
	public static function model() {
		return parent::model();
	}

}

?>
