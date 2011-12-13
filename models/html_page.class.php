<?php

/**
 * @class HtmlPage
 * @parent AbstractActiveRecord
 *
 * @property $keyword
 * @property $title
 * @property $content
 * @property $lang
 * @property $published
 */
class HtmlPage extends AbstractActiveRecord {
	/**
	 * @return string name of database table
	 */
	public function tableName() {
		return 'html_pages';
	}

	/**
	 * @static
	 * @return HtmlPage
	 */
	public static function model() {
		return parent::model();
	}


}
