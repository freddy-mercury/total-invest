<?php

/**
 * Абстрактный класс, реализующий паттерн Active Record
 * @class AbstractActiveRecord
 * @author k.komarov
 */
abstract class AbstractActiveRecord extends AbstractDomainModel implements ArrayAccess {

	private $_attributes;
	private $_new;
	private static $_models;
	private static $_md;

	public function __construct() {
		$this->setIsNew(true);
	}

	/**
	 * Статический метод, возвращающий экземпляр модели
	 * @static
	 * @return AbstractActiveRecord
	 */
	public static function model() {
		$classname = get_called_class();
		if (!isset(self::$_models[$classname])) {
			self::$_models[$classname] = new $classname;
		}
		return self::$_models[$classname];
	}

	/**
	 * Абстрактный метод, возвращающий название таблицы БД
	 * @abstract
	 * @return string название таблицы БД
	 */
	abstract public function tableName();

	/**
	 * Метод, возвращающий список имен атрибутов модели
	 * @return array
	 */
	final public function attributeNames() {
		return array_keys($this->getMetaData()->columns);
	}

	final public function getPhpDocProperties() {
		$phpdoc = '/**' . "\n";
		foreach ($this->attributeNames() as $attribute_name) {
			$phpdoc.= ' * @property $' . $attribute_name . "\n";
		}
		$phpdoc.= ' */';
		return '<pre>'.$phpdoc.'</pre>';
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
	 * Метод, возвращающий мета-данные о таблице БД
	 * @return TableShema
	 */
	private function getMetaData() {
		if (!isset(self::$_md[$this->tableName()])) {
			self::$_md[$this->tableName()] = new TableShema($this->tableName());
		}
		return self::$_md[$this->tableName()];
	}

	/**
	 * Метод, возвращающий список имен атрибутов, являющихся первичными ключами
	 * @return array
	 */
	public function primaryKeys() {
		return $this->getMetaData()->primary_keys;
	}

	/**
	 * Метод, устанавливающий признак новой записи
	 * @param boolean $new
	 */
	public function setIsNew($new = true) {
		$this->_new = $new;
	}

	/**
	 * Метод, возвращающий признак новой записи
	 * @return boolean
	 */
	public function getIsNew() {
		return $this->_new;
	}

	/**
	 * Метод, возвращающий массив найденных экземпляров модели
	 * @param string $condition SQL условие (colume = "value")
	 * @return array|AbstractActiveRecord[]
	 */
	public function findAll($condition = '') {
		$result = sql_query('SELECT * FROM ' . $this->tableName()
			. (!empty($condition) ? ' WHERE ' . $condition : ''));
		$found = array();
		while ($row = sql_fetch_assoc($result)) {
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
	 * Метод, возвращающий экземляр найденной модели
	 * @param string $condition SQL условие (colume = "value")
	 * @return AbstractActiveRecord |null
	 */
	public function find($condition = '') {
		$found = $this->findAll($condition);
		return empty($found) ? null : reset($found);
	}

	/**
	 * Метод, возвращающий первичный ключ в правильном формате (массив ключей)
	 * @param mixed|array $primary_key значение первичного ключа.
	 * Если первичный ключ составной, то массив (ключ => значение).
	 * @return array
	 */
	protected function getTidyPrimaryKeys($primary_key) {
		if (!is_array($primary_key)) {
			if (count($this->primaryKeys()) == 1)
				$primary_key = array(current($this->primaryKeys()) => $primary_key);
			else
				trigger_error('Invalid primary key defined!', E_USER_ERROR);
		}
		$invalid_keys = array_diff(array_keys($primary_key), $this->primaryKeys());
		if (!empty($invalid_keys))
			trigger_error('Invalid primary keys defined!', E_USER_ERROR);
		return $primary_key;
	}

	/**
	 * Метод, возвращающий SQL условие по первичному ключу
	 * @param mixed|array $primary_key значение первичного ключа.
	 * Если первичный ключ составной, то массив (ключ => значение).
	 * @return string
	 */
	protected function getPrimaryKeyCondition($primary_key) {
		$condition = array();
		foreach ($this->getTidyPrimaryKeys($primary_key) as $key => $value) {
			$condition[] = $key . ' = ' . q($value);
		}
		return '(' . implode(' AND ', $condition) . ')';
	}

	/**
	 * Метод, возвращающий экземпляр модели, найденной по первичному ключу.
	 * @param mixed|array $primary_key значение первичного ключа.
	 * Если первичный ключ составной, то массив (ключ => значение).
	 * @return null|AbstractActiveRecord
	 */
	public function findByPk($primary_key) {
		$found = $this->findAll($this->getPrimaryKeyCondition($primary_key));
		return!empty($found) ? current($found) : null;
	}

	/**
	 * Метод, выполняющий вставку записи в таблицу БД
	 * @return bool
	 */
	protected function insert() {
		$values = array();
		foreach ($this->attributeNames() as $name) {
			$values[] = q($this->_attributes[$name]);
		}
		if (sql_query('INSERT INTO ' . $this->tableName()
				. ' (' . implode(',', $this->attributeNames()) . ') VALUES ' . '(' . implode(',', $values) . ')')) {
			if (count($this->primaryKeys()) == 1 && ($insert_id = sql_insert_id())) {
				$primary_key = current($this->primaryKeys());
				$this->_attributes[$primary_key] = $insert_id;
			}
			$this->setIsNew(false);
			return true;
		}
		return false;
	}

	/**
	 * Метод, выполняющий обновление записи в таблице БД
	 * @return bool
	 */
	protected function update() {
		$values = array();
		$primary_keys = array();
		foreach ($this->attributeNames() as $name) {
			if (!in_array($name, $this->primaryKeys()))
				$values[] = $name . ' = ' . q($this->_attributes[$name]);
			else
				$primary_keys[] = $name . ' = ' . q($this->_attributes[$name]);
		}

		if (sql_query('UPDATE ' . $this->tableName()
				. ' SET ' . implode(',', $values) . ' WHERE ' . implode(' AND ', $primary_keys))) {
			return true;
		}
		return false;
	}

	/**
	 * Метод, выполняющий вставку {@see insert()} или обновление {@see update()} записи
	 * в зависимости от значения признака {@see $this->_new}
	 * @return bool
	 */
	public function save() {
		return $this->_new ? $this->insert() : $this->update();
	}

	/**
	 * Метод, выполняющий удаление записи из таблицы БД
	 * @return bool
	 */
	public function delete() {
		if ($this->_new) {
			return false;
		}
		$primary_keys = array();
		foreach ($this->primaryKeys() as $name) {
			$primary_keys[] = $name . ' = ' . q($this->_attributes[$name]);
		}
		sql_query('DELETE FROM ' . $this->tableName() . ' WHERE ' . implode(' AND ', $primary_keys));
		$this->_attributes = NULL;
		return true;
	}

	/**
	 * Метод, выполняющий удаление записи из БД по первичному ключу
	 * @param mixed|array $primary_key значение первичного ключа.
	 * Если первичный ключ составной, то массив (ключ => значение).
	 * @return boolean
	 */
	public function deleteByPk($primary_key) {
		return sql_query('DELETE FROM ' . $this->tableName() . ' WHERE ' . $this->getPrimaryKeyCondition($primary_key));
	}

	/**
	 * Метод, выполняющий удаление записей из БД по условию
	 * @param string $condition SQL условие
	 */
	public function deleteByCondition($condition = '') {
		if (!empty($condition)) {
			sql_query('DELETE FROM ' . $this->tableName() . ' WHERE ' . $condition);
		}
	}

	/**
	 * Метод, возвращающий кол-во записей по условию
	 * @param string $condition SQL условие
	 * @return integer
	 */
	public function count($condition = '') {
		$sql = 'SELECT COUNT(*) FROM ' . $this->tableName() . (!empty($condition) ? ' WHERE ' . $condition : '');
		$value = sql_get($sql, false, true);
		return intval($value);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Whether a offset exists
	 * @see http://php.net/manual/en/arrayaccess.offsetexists.php
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
	 * @see http://php.net/manual/en/arrayaccess.offsetget.php
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
	 * @see http://php.net/manual/en/arrayaccess.offsetset.php
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
	 * @see http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 *					  The offset to unset.
	 * </p>
	 * @return void
	 */
	public function offsetUnset($offset) {
		unset($this->$offset);
	}

}

?>