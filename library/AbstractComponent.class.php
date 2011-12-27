<?php
/**
 * Абстрактный класс-компонента, имплементирующий магические методы __get, __set, __isset, __unset, __call
 * @class AbstractComponent
 * @author k.komarov
 */
abstract class AbstractComponent {

	/**
	 * Возвращает строку вида you_are_camel в виде YouAreCamel
	 * @param $name
	 * @return string
	 */
	protected function getCamelName($name) {
		return implode('', array_map('ucfirst', explode('_', $name)));
	}

	/**
	 * Магический метод, который возвращает значение свойства класса
	 *
	 * @param string $name имя свойства
	 * @return mixed значение свойства
	 */
	public function __get($name) {
		$getter = 'get' . $name;
		if (method_exists($this, $getter))
			return $this->$getter();
		$getter = 'get' . $this->getCamelName($name);
		if (method_exists($this, $getter))
			return $this->$getter();
		trigger_error('Property "'.get_class($this).'.'.$name.'" is not defined.', E_USER_ERROR);
	}

	/**
	 * Магический метод, который устанавливает значение свойства класса
	 * @param string $name имя свойства
	 * @param mixed $value значание свойства
	 * @return mixed
	 */
	public function __set($name, $value) {
		$setter = 'set' . $name;
		if (method_exists($this, $setter))
			return $this->$setter($value);
		$setter = 'set' . $this->getCamelName($name);
		if (method_exists($this, $setter))
			return $this->$setter($value);
		if (method_exists($this, 'get' . $name))
			trigger_error('Property "'.get_class($this).'.'.$name.'" is read only.', E_USER_ERROR);
		else
			trigger_error('Property "'.get_class($this).'.'.$name.'" is not defined.', E_USER_ERROR);
	}

	/**
	 * Магический метод, который проверяет, что значение свойства класса не равно null.
	 * @param string $name имя свойства
	 * @return boolean
	 */
	public function __isset($name) {
		$getter = 'get' . $name;
		if (method_exists($this, $getter))
			return $this->$getter() !== null;
		$getter = 'get' . $this->getCamelName($name);
		if (method_exists($this, $getter))
			return $this->$getter() !== null;
		return false;
	}

	/**
	 * Магический метод, который устанавливает значение свойства класса в null.
	 * @param string $name имя свойства
	 * @return mixed
	 */
	public function __unset($name) {
		$setter = 'set' . $name;
		if (method_exists($this, $setter))
			$this->$setter(null);
		elseif (($setter = 'set' . $this->getCamelName($name)) && method_exists($this, $setter))
			$this->$setter(null);
		else if (method_exists($this, 'get' . $name) || method_exists($this, 'get' . $this->getCamelName($name)))
			trigger_error('Property "'.get_class($this).'.'.$name.'" is read only.', E_USER_ERROR);
	}

	/**
	 * Магический метод, который вызывает метод с указанным именем, не являющимся методом класса.
	 * Применимо, если свойство класса является замыканием.
	 * @param string $name имя метода
	 * @param array $parameters параметры, передаваемые методу в виде массива
	 * @return mixed результат вызова метода
	 */
	public function __call($name, $parameters) {
		if (class_exists('Closure', false) && $this->canGetProperty($name) && $this->$name instanceof Closure)
			return call_user_func_array($this->$name, $parameters);
		trigger_error(get_class($this).' do not have a method or closure named "'.$name.'".', E_USER_ERROR);
	}

	/**
	 * Метод, определяющий наличие свойства с указанным именем.
	 * @param string $name имя свойства
	 * @return boolean
	 */
	public function hasProperty($name) {
		return method_exists($this, 'get' . $name) || method_exists($this, 'set' . $name)
			|| method_exists($this, 'get' . $this->getCamelName($name)) || method_exists($this, 'set' . $this->getCamelName($name));
	}

	/**
	 * Метод, определяющий возможность получить значение свойства класса
	 * @param string $name имя свойства
	 * @return boolean
	 */
	public function canGetProperty($name) {
		return method_exists($this, 'get' . $name) || method_exists($this, 'get' . $this->getCamelName($name));
	}

	/**
	 * Метод, определяющий возможность установить значение свойства класса
	 * @param string $name имя свойства
	 * @return boolean
	 */
	public function canSetProperty($name) {
		return method_exists($this, 'set' . $name) || method_exists($this, 'set' . $this->getCamelName($name));
	}

}

?>
