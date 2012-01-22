<?php
/**
 * Абстрактный класс-модель
 * @class AbstractDomainModel
 * @author k.komarov
 */
abstract class AbstractDomainModel extends AbstractComponent {

	/**
	 * Ошибки валидации свойств (синоним атрибутов) класса
	 * @var array массив ключ-значение (атрибут-значение)
	 */
	private $_errors = array();

	/**
	 * Безопасные атрибуты модели
	 * @var array массив имен атрибутов
	 */
	private $_safe_attribute_names = array();

	/**
	 * Метод, возвращающий имена атрибутов модели.
	 * Возвращает публичные свойства класса.
	 * @return array список имен атрибутов
	 */
	public function attributeNames() {
		$attribute_names = array();
        $reflection = new ReflectionClass(get_class($this));
        /* @var $property ReflectionProperty */
        foreach ($reflection->getProperties() as $property) {
            if ($property->isPublic())
                $attribute_names[] = $property->getName();
        }
		return $attribute_names;
	}

	/**
	 * Метод, выполняющий валидацию
	 *
	 * Для добавления ошибок атрибутам используйте метод {@link addError}.
	 * Ошибки, найденные во время валидации, могут быть получены с помощью метода {@link getErrors}.
	 *
	 * @param array $attributes список имен атрибутов для проверки.
	 * @return boolean
	 */
	public function validate($attributes=null) {
		return!$this->hasErrors();
	}

	/**
	 * Метод, возвращающий признак наличия ошибок валидации.
	 * @param string $attribute список имен атрибутов
	 * @return boolean
	 */
	public function hasErrors($attribute=null) {
		if ($attribute === null)
			return $this->_errors !== array();
		else
			return isset($this->_errors[$attribute]);
	}

	/**
	 * Метод, возвращающий ошибки атрибутов
	 * @param string $attribute имя атрибута
	 * @return array
	 */
	public function getErrors($attribute=null) {
		if ($attribute === null)
			return $this->_errors;
		else
			return isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : array();
	}

	/**
	 * Метод, возвращающий первую ошибку атрибута
	 * @param string $attribute имя атрибута
	 * @return string|null текст ошибки или null
	 */
	public function getError($attribute) {
		return isset($this->_errors[$attribute]) ? reset($this->_errors[$attribute]) : null;
	}

	/**
	 * Метод, добавляющий ошибку атрибуту
	 * @param string $attribute имя атрибута
	 * @param string $error текст ошибки
	 */
	public function addError($attribute, $error) {
		$this->_errors[$attribute][] = $error;
	}

	/**
	 * Метод, добавляющий ошибки
	 * @param array $errors список ошибок. Ключи - имена атрибутов. Значения - тексты ошибок.
	 * Если у атрибута несколько ошибок, то их тексты должны быть массивом.
	 */
	public function addErrors($errors) {
		foreach ($errors as $attribute => $error) {
			if (is_array($error)) {
				foreach ($error as $e)
					$this->_errors[$attribute][] = $e;
			}
			else
				$this->_errors[$attribute][] = $error;
		}
	}

	/**
	 * Метод, делающий сброс всех ошибок
	 * @param string $attribute имя атрибута
	 */
	public function clearErrors($attribute=null) {
		if ($attribute === null)
			$this->_errors = array();
		else
			unset($this->_errors[$attribute]);
	}

	/**
	 * Метод, возвращающий значения атрибутов.
	 * @param array $names список имен атрибутов
	 * По-умолчанию null, т.е. вернутся значения атрибутов из метода {@link attributeNames}.
	 * Если это массив, то вернутся значения атрибутов, указанных в нем.
	 * @return array значения атрибутов (name=>value).
	 */
	public function getAttributes($names=null) {
		$values = array();
		foreach ($this->attributeNames() as $name)
			$values[$name] = $this->$name;

		if (is_array($names)) {
			$values2 = array();
			foreach ($names as $name)
				$values2[$name] = isset($values[$name]) ? $values[$name] : null;
			return $values2;
		}
		else
			return $values;
	}

	/**
	 * Метод, устанавливающий значения атрибутов
	 * @param array $values ассоциативный массив значений атрибутов (name=>value)
	 * @param boolean $safeOnly выполнять ли установку значений атрибутов содержащихся в {@link getSafeAttributeNames}
	 */
	public function setAttributes($values, $safeOnly=true) {
		if (!is_array($values))
			return;
		$attributes = array_flip($safeOnly ? $this->getSafeAttributeNames() : $this->attributeNames());
		foreach ($values as $name => $value) {
			if (isset($attributes[$name]))
				$this->$name = $value;
		}
	}

	/**
	 * Метод, устанавливающий значения атрибутов в null.
	 * @param array $names список имен атрибутов
	 */
	public function unsetAttributes($names=null) {
		if ($names === null)
			$names = $this->attributeNames();
		foreach ($names as $name)
			$this->$name = null;
	}

	/**
	 * Метод, устанавливающий безопасные атрибуты
	 * @param type $attributes список имен атрибутов
	 */
	public function setSafeAttributeNames($attributes=null) {
		$this->_safe_attribute_names = $attributes === null ? array() : (array) $attributes;
	}

	/**
	 * Метод, возвращающий список имен безопасных атрибутов.
	 * По-умолчанию {@link attributeNames()}
	 * @return array список имен атрибутов
	 */
	public function getSafeAttributeNames() {
		return $this->_safe_attribute_names ?: $this->attributeNames();
	}

}

?>
