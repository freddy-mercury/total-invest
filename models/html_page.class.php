<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Asus
 * Date: 12.12.11
 * Time: 21:33
 * To change this template use File | Settings | File Templates.
 */
class HtmlPage extends AbstractActiveRecord {
	/**
	 * @return string name of database table
	 */
	public function tableName() {
		return 'html_pages';
	}

}
