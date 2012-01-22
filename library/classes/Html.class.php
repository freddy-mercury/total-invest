<?php

class Html {
	public static function submit($label, $name = 'submit', array $attrs = array()) {
		return self::input('submit', $name, $label, $attrs);
	}

	public static function input($type, $name, $value, array $attrs = array()) {
		$html = '';
		$_attrs = array();
		$attrs['size'] = $attrs['size'] ?: 25;
		if ($type == 'checkbox') {
			if ($value) {
				$attrs['checked'] = 'checked';
			}
			$value = 1;
			$html.= '<input type="hidden" name="' . $name . '" value="0">';
		}
		foreach ($attrs as $k => $v) {
			$_attrs[] = $k . '="' . $v . '"';
		}

		$value = htmlspecialchars($value);
		$html.= '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" value="' . $value . '"'
				. ($_attrs ? ' ' . implode(' ', $_attrs) : '') . ' />';
		return $html;
	}

	public static function select($name, array $options, $value = '', array $attrs = array()) {
		$_attrs = array();
		foreach ($attrs as $k => $v) {
			$_attrs[] = $k . '="' . $v . '"';
		}
		$_options = array();
		foreach ($options as $k => $v) {
			$_options[] = '<option value="' . htmlspecialchars($k) . '"' . (strcmp($k, $value) == 0 ? 'selected' : '')
					. '>' . htmlspecialchars($v) . '</option>';
		}
		return '<select name="' . $name . '" id="' . $name . '"' . ($_attrs ? ' ' . implode(' ', $_attrs) : '')
				. '>' . implode("\n", $_options) . '</select>';
	}

	public static function captcha() {
		require_once DOC_ROOT . '/library/recaptchalib.php';
		return recaptcha_get_html(RECAPTCHA_PUBLIC_KEY);
	}

	public static function pin($name, $length, $value = '') {
		$buttons = range(0, 9);
		shuffle($buttons);
		$out = self::input('password', $name, $value, array(
					'size' => $length,
					'maxlength' => $length,
					'readonly' => 'readonly',
					'autocomplete' => 'off',
					'onfocus' => 'document.getElementById(\'kbd_' . $name . '\').style.display=\'block\';')
				) . '
		<div id="kbd_' . $name . '" style="display:none">
		';
		foreach ($buttons as $i => $button) {
			if ($i == 5)
				$out.= '<br>';
			$out.= self::input('button', 'botton[' . $button . ']', $button, array(
						'onclick' => 'if (document.getElementById(\'' . $name . '\').value.length < ' . $length . ') document.getElementById(\''
						. $name . '\').value+=\'' . $button . '\';'));
		}
		$out.= '<input type="button" value="Clear" onclick="document.getElementById(\'' . $name . '\').value=\'\'" style="width:50px;">
		</div>';
		return $out;
	}

	public static function textarea($name, $value,  array $attrs = array()) {
		$_attrs = array();
		foreach ($attrs as $k => $v) {
			$_attrs[] = $k . '="' . $v . '"';
		}
		$value = htmlspecialchars($value);
		return '<textarea name="' . $name . '" id="' . $name . '"'
				. ($_attrs ? ' ' . implode(' ', $_attrs) : '') . '>'.$value.'</textarea>';
	}
}

?>
