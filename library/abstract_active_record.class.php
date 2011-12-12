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
	private static $_md;

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean Returns true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists($offset) {
		return isset($this->$offset);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
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
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
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
	 * The offset to unset.
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
		parent::__set($name, $value);
	}

	public function __isset($name) {
		if(isset($this->_attributes[$name]))
			return true;
		else if(isset($this->getMetaData()->columns[$name]))
			return false;
		return parent::__isset($name);
	}

	public function __unset($name) {
		if(isset($this->getMetaData()->columns[$name]))
			unset($this->_attributes[$name]);
		else
			parent::__unset($name);
	}

	/**
	 * @return TableShema
	 */
	private function getMetaData() {
		if (!isset(self::$_md[$this->tableName()])) {
			self::$_md[$this->tableName()] =  new TableShema($this->tableName());
		}
		return self::$_md[$this->tableName()];
	}
}
