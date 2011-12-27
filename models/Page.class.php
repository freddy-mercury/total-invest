<?php

/**
 * @property $id
 * @property $name
 * @property $content
 * @property $lang
 */
class Page extends AbstractActiveRecord {
	public function tableName() {
		return 'pages';
	}


}