<?php

class Logger {
	/**
	 * @var integer
	 */
	private $user_id;
	public function __construct($user_id = 0) {
		if (intval($user_id)) {
			$this->user_id = $user_id;
		}
	}
	public function log($line = '') {
		global $dbh;
		$dbh->query('
			insert into logger set 
			id = 0,
			user_id = "'.$this->user_id.'",
			stamp = "'.time().'",
			url = "'.$_SERVER['REQUEST_URI'].'",
			text = "'.$line.'"
		');
	}
	public function getLog() {
		global $dbh;
		return $dbh->fetchAll($dbh->query('select * from logger where user_id="'.$this->user_id.'" order by stamp desc'));
	}
}