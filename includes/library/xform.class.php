<?php
class XForm {
	/**
	 * Массив элементов формы
	 *
	 * @var array
	 */
    public $rows = array();
    public $rows_required = array();
    public $row_checkers = array();
    public $error_fields = array();
    public $pointer = 0;
   
    public function __construct($attributes = 'action="" method="post"') {
    	$row = array(
    		'type' => 'form',
    		'text' => $attributes,
    		'id' => ''
    	);
    	$this->addRow($row);
    }
    private function addRow($row) {
        array_splice($this->rows, $this->pointer, 0, array($row));
        $this->pointer+=1;
    }
    public function deleteRow($id) {
        if (!$this->movePointerBefore($id)) {
            return false;
        }
        array_splice($this->rows, $this->pointer, 1);
        $this->movePointerToEnd();
        return true;
    }
    public function movePointerAfter($id) {
        $i = 0;
        foreach ($this->rows as $row) {
            $i++;
            if ($row['id'] == $id) {
                $this->pointer = $i;
                return true;
            }
        }
        $this->movePointerToEnd();
        return false;
    }
    public function movePointerBefore($id) {
        if ($this->movePointerAfter($id)) {
            $this->pointer-=1;
            return true;
        }
        return false;
    }
    public function movePointerToEnd() {
        $this->pointer = count($this->rows);
    }
    public function addField($label, $input_field, $id = '', $required = false) {
        $row = array(
            'type' => 'field',
        	'label' => $label,
            'text' => $input_field,
            'id' => $id,
        	'required' => $required
        );
        $this->addRow($row);
    }
	public function addSubmit($input_field) {
        $row = array(
            'type' => 'submit',
            'text' => $input_field
        );
        $this->addRow($row);
    }
    public function modifyRowKeyword($row_id, $label) {
    	foreach($this->rows as $key=>$row) {
    		if ($row['id']==$row_id) {
    			$this->rows[$key]['label'] = $label;
    			break;
    		}
    	}
    }
}
class FormController {
	/**
	 * ObjectForm
	 *
	 * @var XForm
	 */
	protected $form;
	protected $error_fileds = array();
	public function __construct($form, $error_fields = array()) {
		$this->form = $form;
		$this->error_fileds = $error_fields;
	}
	public function out($title = '') {
		$html_form = '<table cellpadding="3" cellspacing="1" align="center">';
		if (!empty($title)) {
			$html_form.= '<caption>'.$title.'</caption>';
		}
		foreach ($this->form->rows as $row) {
			switch($row['type']) {
				case 'form':
					$html_form.= "\n".'<form '.$this->form->rows[0]['text'].'>'; 
				break;
				case 'field':
					$html_form.= '
						<tr '.getRowColor().' valign="top">
							<td>'.$row['label'].'</td>
							<td>'.$row['text'].'</td>
						</tr>'; 
				break; 
				case 'submit':
					$html_form.= '<tr><td colspan="2" align="center">'.$row['text'].'</td></tr>';
				break;
			}
				
		}
		$html_form.= '</form>';
		$html_form.= '</table>';
		return $html_form;
	}
}

function input_select($options, $name, $default_value = '', $attr = '') {
	$select = '<select name="'.$name.'" id="'.$name.'" '.$attr.' style="width:100%">'."\n";
	foreach ($options as $value=>$option) {
		$select.= '<option value="'.$value.'" '.($default_value==$value ? 'selected' : '').'>'.$option.'</option>'."\n";
	}
	$select.= '</select>';
	return $select;
}