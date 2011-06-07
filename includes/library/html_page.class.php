<?php

/**
 * @property $id
 * @property $name
 * @property $content
 * @property $lang
 */
class HtmlPage {
    const table = 'html_pages';
    const cache_prefix = 'html_page';

    private $_fields = array('id' => 0, 'name' => '', 'content' => '', 'lang' => 'eng');
    private $_data;
    private $_cache_enebled = FALSE;

    public function __get($name) {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        return NULL;
    }

    public function __set($name, $value) {
        $this->_data[$name] = $value;
    }

    public function __construct($id = 0, $load = TRUE) {
        $this->_cache_enebled = CACHE_ENABLED;
        $this->id = intval($id);
        if ($this->id && $load) {
            $this->load();
        } elseif (!$this->id) {
            $this->setData($this->_fields);
        }
    }

    private function getCacheKey() {
        return self::cache_prefix . '_' . $this->id . '_' . $this->lang;
    }

    public function load() {
        $data = $this->_cache_enebled ? Project::getInstance()->getCache()->get($this->getCacheKey()) : NULL;
        
        if (!$data) {
            $data = sql_row('SELECT * FROM ' . self::table . ' WHERE id = ' . $this->id);
            if ($data && $this->_cache_enebled)
                Project::getInstance()->getCache()->save($data);
            else
                $data = $this->_fields;
        }
        $this->setData($data);
    }

    public function setData($data) {
        foreach ($this->_fields as $column => $default_value) {
            $this->_data[$column] = !empty($data[$column]) ? $data[$column] : $this->_fields[$column];
        }
    }

    public function save() {
        $_data = array();
        $_fields = array();
        foreach ($this->_fields as $column => $default_value) {
            $_fields[] = $column . '="' . sql_escapeStr($this->_data[$column]) . '"';
        }
        $query = 'REPLACE INTO ' . self::table . ' SET ' . implode(',', $_fields);
        sql_query($query);
        $this->id = $this->id ? : sql_insert_id();
        if ($this->_cache_enebled) {
            Project::getInstance()->getCache()->clean();
            Project::getInstance()->getCache()->save($_data, $this->getCacheKey());
        }
    }

    public function delete() {
        $query = 'DELETE FROM ' . self::table . ' WHERE id = "' . $this->id . '"';
        sql_query($query);
        if ($this->_cache_enebled) {
            Project::getInstance()->getCache()->remove($this->getCacheKey());
        }
    }

    public function toArray() {
        $data = array();
        foreach ($this->_fields as $column => $default_value) {
            $data[$column] = $this->_data[$column];
        }
        return $data;
    }

}