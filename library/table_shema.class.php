<?php
/**
 * @property $table_name
 * @property $primary_keys
 * @property $columns
 */
class TableShema extends AbstractModel {
	private $_table_name;
	private $_primary_keys;
	private $_columns;

	public function __construct($table_name) {
		$this->_table_name = $table_name;
		if (!($result = App::get()->getDb()->query('DESCRIBE '.$this->_table_name))) {
			throw new Exception('Cannot get shema of ' . $this->_table_name.' table!');
		}
		foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $column) {
			$this->_columns[$column['Field']] = $column['Default'];
			if ($column['Key'] == 'PRI') {
				$this->_primary_keys[] = $column['Field'];
			}
		}
	}

	/**
	 * Returns the list of attribute names of the model.
	 * @return array list of attribute names.
	 */
	public function attributeNames() {
		return array('table_name', 'primary_keys', 'columns');
	}

	public function getColumns() {
		return $this->_columns;
	}

	public function getPrimaryKeys() {
		return $this->_primary_keys;
	}

	public function getTableName() {
		return $this->_table_name;
	}


}
