<?php

/**
 * Description of B2BComponent
 *
 * @author k.komarov
 */
abstract class AbstractComponent {

	/**
	 * Returns a property value.
	 * Do not call this method. This is a PHP magic method that we override
	 * to allow using the following syntax to read a property:
	 * <pre>
	 * $value=$component->propertyName;
	 * </pre>
	 * @param string $name the property name
	 * @return mixed the property value
	 * @see __set
	 */
	public function __get($name) {
		$getter = 'get' . $name;
		if (method_exists($this, $getter))
			return $this->$getter();
		$getter = 'get' . $this->getCamelName($name);
		if (method_exists($this, $getter))
			return $this->$getter();
		throw new Exception('Property "'.get_class($this).'.'.$name.'" is not defined.');
	}

	private function getCamelName($name) {
		return implode('', array_map('ucfirst', explode('_', $name)));
	}

	/**
	 * Sets value of a component property.
	 * Do not call this method. This is a PHP magic method that we override
	 * to allow using the following syntax to set a property
	 * <pre>
	 * $this->propertyName=$value;
	 * </pre>
	 * @param string $name the property name
	 * @param mixed $value the property value or callback
	 * @return mixed
	 * @see __get
	 */
	public function __set($name, $value) {
		$setter = 'set' . $name;
		if (method_exists($this, $setter))
			return $this->$setter($value);
		$setter = 'set' . $this->getCamelName($name);
		if (method_exists($this, $setter))
			return $this->$setter($value);
		if (method_exists($this, 'get' . $name))
			throw new Exception('Property "'.get_class($this).'.'.$name.'" is read only.');
		else
			throw new Exception('Property "'.get_class($this).'.'.$name.'" is not defined.');
	}

	/**
	 * Checks if a property value is null.
	 * Do not call this method. This is a PHP magic method that we override
	 * to allow using isset() to detect if a component property is set or not.
	 * @param string $name the property name
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
	 * Sets a component property to be null.
	 * Do not call this method. This is a PHP magic method that we override
	 * to allow using unset() to set a component property to be null.
	 * @param string $name the property name
	 * @return mixed
	 */
	public function __unset($name) {
		$setter = 'set' . $name;
		if (method_exists($this, $setter))
			$this->$setter(null);
		elseif (($setter = 'set' . $this->getCamelName($name)) && method_exists($this, $setter))
			$this->$setter(null);
		else if (method_exists($this, 'get' . $name) || method_exists($this, 'get' . $this->getCamelName($name)))
			throw new Exception('Property "'.get_class($this).'.'.$name.'" is read only.');
	}

	/**
	 * Calls the named method which is not a class method.
	 * Do not call this method. This is a PHP magic method that we override
	 * to implement the Closure feature.
	 * @param string $name the method name
	 * @param array $parameters method parameters
	 * @return mixed the method return value
	 */
	public function __call($name, $parameters) {
		if (class_exists('Closure', false) && $this->canGetProperty($name) && $this->$name instanceof Closure)
			return call_user_func_array($this->$name, $parameters);
		throw new Exception(get_class($this).' do not have a method or closure named "'.$name.'".');
	}

	/**
	 * Determines whether a property is defined.
	 * A property is defined if there is a getter or setter method
	 * defined in the class. Note, property names are case-insensitive.
	 * @param string $name the property name
	 * @return boolean whether the property is defined
	 * @see canGetProperty
	 * @see canSetProperty
	 */
	public function hasProperty($name) {
		return method_exists($this, 'get' . $name) || method_exists($this, 'set' . $name)
			|| method_exists($this, 'get' . $this->getCamelName($name)) || method_exists($this, 'set' . $this->getCamelName($name));
	}

	/**
	 * Determines whether a property can be read.
	 * A property can be read if the class has a getter method
	 * for the property name. Note, property name is case-insensitive.
	 * @param string $name the property name
	 * @return boolean whether the property can be read
	 * @see canSetProperty
	 */
	public function canGetProperty($name) {
		return method_exists($this, 'get' . $name) || method_exists($this, 'get' . $this->getCamelName($name));
	}

	/**
	 * Determines whether a property can be set.
	 * A property can be written if the class has a setter method
	 * for the property name. Note, property name is case-insensitive.
	 * @param string $name the property name
	 * @return boolean whether the property can be written
	 * @see canGetProperty
	 */
	public function canSetProperty($name) {
		return method_exists($this, 'set' . $name) || method_exists($this, 'set' . $this->getCamelName($name));
	}

}

?>
