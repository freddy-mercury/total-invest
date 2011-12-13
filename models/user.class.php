<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Asus
 * Date: 13.12.11
 * Time: 23:51
 * To change this template use File | Settings | File Templates.
 */
class User extends AbstractActiveRecord {

	/**
	 * @return string name of database table
	 */
	public function tableName() {
		return 'users';
	}

	/**
	 * @static
	 * @return User
	 */
	public static function model() {
		return parent::model();
	}

}
