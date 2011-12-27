<?php
/**
 * @property $table_name
 * @property $primary_keys
 * @property $columns
 */
class TableShema extends AbstractComponent {
	private $_table_name;
	private $_primary_keys;
	private $_columns;

	public function __construct($table_name) {
		$this->_table_name = $table_name;
		if (!($result = sql_query('DESCRIBE '.$this->_table_name))) {
			trigger_error('Cannot get shema of ' . $this->_table_name.' table!', E_USER_ERROR);
		}
		while($column = sql_fetch_assoc($result)) {
			$this->_columns[$column['Field']] = $column['Default'];
			if ($column['Key'] == 'PRI') {
				$this->_primary_keys[] = $column['Field'];
			}
		}
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
