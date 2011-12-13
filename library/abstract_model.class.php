<?php

require_once 'abstract_component.class.php';

/**
 * Description of B2BModel
 * B2BModel is the base class providing the common features needed by data model objects.
 *
 * @author k.komarov
 */
abstract class AbstractModel extends AbstractComponent {

	private $_errors = array(); // attribute name => array of errors
	private $_safe_attribute_names = array(); //attribute names

	/**
	 * Returns the list of attribute names of the model.
	 * @return array list of attribute names.
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
	 * Performs the validation.
	 *
	 * Use {@link addError} to add error messages to attributes.
	 * Errors found during the validation can be retrieved via {@link getErrors}.
	 *
	 * @param array $attributes list of attributes that should be validated. 
	 * @return boolean whether the validation is successful without any error.
	 */
	public function validate($attributes=null) {
		return!$this->hasErrors();
	}

	/**
	 * Returns a value indicating whether there is any validation error.
	 * @param string $attribute attribute name. Use null to check all attributes.
	 * @return boolean whether there is any error.
	 */
	public function hasErrors($attribute=null) {
		if ($attribute === null)
			return $this->_errors !== array();
		else
			return isset($this->_errors[$attribute]);
	}

	/**
	 * Returns the errors for all attribute or a single attribute.
	 * @param string $attribute attribute name. Use null to retrieve errors for all attributes.
	 * @return array errors for all attributes or the specified attribute. Empty array is returned if no error.
	 */
	public function getErrors($attribute=null) {
		if ($attribute === null)
			return $this->_errors;
		else
			return isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : array();
	}

	/**
	 * Returns the first error of the specified attribute.
	 * @param string $attribute attribute name.
	 * @return string the error message. Null is returned if no error.
	 */
	public function getError($attribute) {
		return isset($this->_errors[$attribute]) ? reset($this->_errors[$attribute]) : null;
	}

	/**
	 * Adds a new error to the specified attribute.
	 * @param string $attribute attribute name
	 * @param string $error new error message
	 */
	public function addError($attribute, $error) {
		$this->_errors[$attribute][] = $error;
	}

	/**
	 * Adds a list of errors.
	 * @param array $errors a list of errors. The array keys must be attribute names.
	 * The array values should be error messages. If an attribute has multiple errors,
	 * these errors must be given in terms of an array.
	 * You may use the result of {@link getErrors} as the value for this parameter.
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
	 * Removes errors for all attributes or a single attribute.
	 * @param string $attribute attribute name. Use null to remove errors for all attribute.
	 */
	public function clearErrors($attribute=null) {
		if ($attribute === null)
			$this->_errors = array();
		else
			unset($this->_errors[$attribute]);
	}

	/**
	 * Returns all attribute values.
	 * @param array $names list of attributes whose value needs to be returned.
	 * Defaults to null, meaning all attributes as listed in {@link attributeNames} will be returned.
	 * If it is an array, only the attributes in the array will be returned.
	 * @return array attribute values (name=>value).
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
	 * Sets the attribute values in a massive way.
	 * @param array $values attribute values (name=>value) to be set.
	 * @param boolean $safeOnly whether the assignments should only be done to the safe attributes.
	 * @see getSafeAttributeNames
	 * @see attributeNames
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
	 * Unsets the attributes.
	 * @param array $names list of attributes to be set null. If this parameter is not given,
	 * all attributes as specified by {@link attributeNames} will have their values unset.
	 * @since 1.1.3
	 */
	public function unsetAttributes($names=null) {
		if ($names === null)
			$names = $this->attributeNames();
		foreach ($names as $name)
			$this->$name = null;
	}

	/**
	 * Sets safe attribute names
	 * @param type $attributes array of attribute names
	 */
	public function setSafeAttributeNames($attributes=null) {
		$this->_safe_attribute_names = $attributes === null ? array() : (array) $attributes;
	}

	/**
	 * Returns the attribute names that are safe to be massively assigned.
	 * @return array safe attribute names
	 */
	public function getSafeAttributeNames() {
		return $this->_safe_attribute_names ?: $this->attributeNames();
	}

}

?>
