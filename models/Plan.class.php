<?php

/**
 * @property $id
 * @property $name
 * @property $description
 * @property $min
 * @property $max
 * @property $percent
 * @property $percent_per
 * @property $periodicity
 * @property $term
 * @property $compounding
 * @property $type
 * @property $monfri
 * @property $principal_back
 */
class Plan extends AbstractActiveRecord {
    const TYPE_PUBLIC = 0;
    const TYPE_MEMBER = 1;
    const TYPE_MONITOR = 2;

	public function tableName() {
		return 'plans';
	}

	public static function model() {
		return parent::model();
	}

}

?>
