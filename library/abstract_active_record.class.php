<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Asus
 * Date: 12.12.11
 * Time: 21:34
 * To change this template use File | Settings | File Templates.
 */
abstract class AbstractActiveRecord extends AbstractModel implements ArrayAccess {
	private $_attributes;
	private $_new;

	private static $_models;
	private static $_md;

	public function __construct() {
		$this->setIsNew(true);
	}

	public static function model() {
		$classname = get_called_class();
		if (!isset(self::$_models[$classname])) {
			self::$_models[$classname] = new $classname;
		}
		return self::$_models[$classname];
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 *					  An offset to check for.
	 * </p>
	 * @return boolean Returns true on success or false on failure.
	 * </p>
	 * <p>
	 *	   The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists($offset) {
		return isset($this->$offset);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 *					  The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 */
	public function offsetGet($offset) {
		return $this->$offset;
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 *					  The offset to assign the value to.
	 * </p>
	 * @param mixed $value  <p>
	 *					  The value to set.
	 * </p>
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		$this->$offset = $value;
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 *					  The offset to unset.
	 * </p>
	 * @return void
	 */
	public function offsetUnset($offset) {
		unset($this->$offset);
	}

	/**
	 * @abstract
	 * @return string name of database table
	 */
	abstract public function tableName();

	/**
	 * Returns the list of attribute names of the model.
	 * @return array list of attribute names.
	 */
	final public function attributeNames() {
		return array_keys($this->getMetaData()->columns);
	}

	function __sleep() {
		return array_keys($this->_attributes);
	}

	public function __get($name) {
		if (isset($this->_attributes[$name]))
			return $this->_attributes[$name];
		if (array_key_exists($name, $this->getMetaData()->columns))
			return $this->getMetaData()->columns[$name];
		return parent::__get($name);
	}

	public function __set($name, $value) {
		if (in_array($name, $this->attributeNames()))
			$this->_attributes[$name] = $value;
		else
			parent::__set($name, $value);
	}

	public function __isset($name) {
		if (isset($this->_attributes[$name]))
			return true;
		else if (isset($this->getMetaData()->columns[$name]))
			return false;
		return parent::__isset($name);
	}

	public function __unset($name) {
		if (isset($this->getMetaData()->columns[$name]))
			unset($this->_attributes[$name]);
		else
			parent::__unset($name);
	}

	/**
	 * @return TableShema
	 */
	private function getMetaData() {
		if (!isset(self::$_md[$this->tableName()])) {
			self::$_md[$this->tableName()] = new TableShema($this->tableName());
		}
		return self::$_md[$this->tableName()];
	}

	/**
	 * @return array list of primary keys
	 */
	public function primaryKeys() {
		return $this->getMetaData()->primary_keys;
	}

	/**
	 * Set record is new
	 * @param bool $new
	 */
	public function setIsNew($new = true) {
		$this->_new = $new;
	}

	/**
	 * Get record new state
	 * @return bool
	 */
	public function getIsNew() {
		return $this->_new;
	}

	/**
	 * @param $condition Sql condition (WHERE var = "12")
	 * @return AbstractActiveRecord[]
	 */
	public function find($condition = '') {
		$result = App::get()->getDb()->query('SELECT * FROM ' . $this->tableName() . (!empty($condition) ? ' WHERE ' . $condition : ''));
		$found = array();
		foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
			/* @var $c AbstractActiveRecord */
			$c = clone static::model();
			$c->setIsNew(false);
			$c->setAttributes($row);
			$found[] = $c;
			unset($c);
		}
		return $found;
	}

	/**
	 *
	 * @param array $primary_keys
	 * @return AbstractActiveRecord|null
	 */
	public function findByPk($primary_keys) {
		if (count($this->primaryKeys()) != count($primary_keys)) {
			throw new Exception('Primary key be array of ' . count($this->primaryKeys()) . ' values!');
		}
		$condition = array();
		foreach ($primary_keys as $key=> $value) {
			if (in_array($key, $this->primaryKeys()))
				$condition[] = $key . ' = ' . App::get()->getDb()->quote($value);
			else {
				throw new Exception('Invalid primary keys defined!');
			}
		}
		$found = $this->find(implode(' AND ', $condition));
		return !empty($found) ? current($found) : null;
	}

	protected function insert() {
		$values = array();
		foreach ($this->attributeNames() as $name) {
			$values[] = App::get()->getDb()->quote($this->_attributes[$name]);
		}
		if (App::get()->getDb()->query('INSERT INTO ' . $this->tableName()
			. ' (' . implode(',', $this->attributeNames()) . ') VALUES ' . '(' . implode(',', $values) . ')')) {
			if (count($this->primaryKeys()) == 1 && ($insert_id = App::get()->getDb()->lastInsertId())) {
				$primary_key = current($this->primaryKeys());
				$this->_attributes[$primary_key] = $insert_id;
			}
			$this->setIsNew(false);
			return true;
		}
		return false;
	}

	protected function update() {
		$values = array();
		$primary_keys = array();
		foreach ($this->attributeNames() as $name) {
			if (!in_array($name, $this->primaryKeys()))
				$values[] = $name . ' = ' . App::get()->getDb()->quote($this->_attributes[$name]);
			else
				$primary_keys[] = $name . ' = ' . App::get()->getDb()->quote($this->_attributes[$name]);
		}

		if (App::get()->getDb()->query('UPDATE ' . $this->tableName()
			. ' SET ' . implode(',', $values) . ' WHERE ' . implode(' AND ', $primary_keys))) {
			return true;
		}
		return false;
	}

	public function save() {
		return $this->_new ? $this->insert() : $this->update();
	}

	public function delete() {
		if ($this->_new) {
			return false;
		}
		$primary_keys = array();
		foreach ($this->primaryKeys() as $name) {
			$primary_keys[] = $name . ' = ' . App::get()->getDb()->quote($this->_attributes[$name]);
		}
		sql_query('DELETE FROM ' . $this->tableName() . ' WHERE ' . implode(' AND ', $primary_keys));
		$this->_attributes = NULL;
		return true;
	}

	public function getSafeAttributeNames() {
		return $this->attributeNames();
	}


}
