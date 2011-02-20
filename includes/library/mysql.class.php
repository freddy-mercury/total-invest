<?php
include_once(dirname(__FILE__).'/functions.php');
class Mysql {
	public $dbh;
	public $errorInfo;
	public $queries = array();
	public $total_sql_time = 0;
	public $die = false;
	public function __construct($host, $login, $password, $dbname) {
		$this->dbh = @mysql_connect($host, $login, $password);
		if (!$this->dbh) {
			$this->errorInfo = 'MySQL settings are not valid!';
		}
		else {
			@mysql_select_db($dbname);
			$this->errorInfo = @mysql_error($this->dbh);
		}
	}
	public function query($query) {
		$start = getmicrotime();
		$result = mysql_query($query, $this->dbh);
		$end = getmicrotime();
		$this->errorInfo = mysql_error($this->dbh);
		if ($this->die && !empty($this->errorInfo)) die($query.'<br>'.$this->errorInfo);
		$this->queries[] = array('time'=>number_format(($end-$start), 3), 'sql' => $query);
		$this->total_sql_time+= ($end-$start);
		return $result;
	}
	public function fetch($result) {
		return mysql_fetch_array($result);
	}
	public function fetchAll($result) {
		$rows = array();
		while ($row = $this->fetch($result)) {
			$rows[] = $row;
		}
		return $rows;
	}
	public function fetched_rows($result) {
		return mysql_num_rows($result);
	}
	public function insert_id() {
		return mysql_insert_id($this->dbh);
	}
	public function calc_rows() {
		$count = $this->fetch($this->query('select found_rows()'));
		return $count[0];
	}
	public function get($query) {
		$row = $this->fetch($this->query($query));
		return $row[0];
	}
}
