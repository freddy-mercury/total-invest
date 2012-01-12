<?php

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $min
 * @property float $max
 * @property float $percent
 * @property string $percent_per
 * @property int $periodicity
 * @property int $term
 * @property bool $compounding
 * @property string $type
 * @property bool $monfri
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
