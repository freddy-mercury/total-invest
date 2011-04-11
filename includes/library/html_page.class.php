<?php

class HtmlPage {
	const table = 'html_pages';
	const cache_prefix = 'html_page';

	private $fields = array('id' => 0, 'name' => '', 'content' => '', 'lang' => 'eng');
	private $data;

	public function __get($name) {
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
		return NULL;
	}

	public function __set($name, $value) {
		$this->data[$name] = $value;
	}

	public function __construct($id = 0, $load = TRUE) {
		$this->id = intval($id);
		if ($this->id && $load) {
			$this->load();
		}
		elseif (!$this->id) {
			$this->setData($this->fields);
		}
	}

	private function getCacheKey() {
		return self::cache_prefix . '_' . $this->id . '_' . $this->lang;
	}

	public function load() {
		$data = Project::getInstance()->getCache()->get($this->getCacheKey());
		if (!$data) {
			$data = sql_row('SELECT * FROM ' . self::table . ' WHERE id = ' . $this->id);
			if ($data)
				Project::getInstance()->getCache()->save($data);
			else 
				$data = $this->fields;
		}
		$this->setData($data);
	}
	
	public function setData($data) {
		foreach ($this->fields as $column=>$default_value) {
			$this->data[$column] = !empty($data[$column]) ? $data[$column] : $this->fields[$column] ;
		}
	}

	public function save() {
		$data = array();
		$fields = array();
		foreach ($this->fields as $column=>$default_value) {
			$fields[] = $column . '="' . sql_escapeStr($this->data[$column]) . '"';
		}
		$query = 'REPLACE INTO ' . self::table . ' SET ' . implode(',', $fields);
		sql_query($query);
		$this->id = $this->id ? : sql_insert_id();
		Project::getInstance()->getCache()->save($data, $this->getCacheKey());
	}

	public function delete() {
		$query = 'DELETE FROM ' . self::table . ' WHERE id = "' . $this->id . '"';
		sql_query($query);
		Project::getInstance()->getCache()->remove($this->getCacheKey());
	}
	
	public function toArray() {
		$data = array();
		foreach ($this->fields as $column=>$default_value) {
			$data[$column] = $this->data[$column];
		}
		return $data;
	}

}

?>
