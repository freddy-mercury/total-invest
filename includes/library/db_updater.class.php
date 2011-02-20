<?php
include_once(LIB_ROOT.'/functions/mysql.php');
class DbUpdater {
	private $db_table = 'db_updates';
	private $db_updates_filename = 'db_updates.php';
	public function setDbUpdatesFile($filename) {
		if (file_exists($filename)) {
			$this->db_updates_filename = $filename;
		}
	}
	public function __construct() {
		if ($this->isInstalled()) {
		}
		else {
			$this->install();
		}
	}
	private function isInstalled() {
		$result = sql_query('show tables');
		while ($table = mysql_fetch_array($result)) {
			if ($table[0] == $this->db_table) {
				return true;
			}
		}
		return false;
	}
	private function install() {
		$sql = 'CREATE TABLE `'.$this->db_table.'` ('
        . ' `id` INT(11) NOT NULL AUTO_INCREMENT, '
        . ' `name` VARCHAR(255) NOT NULL, '
        . ' `stamp` INT(11) NOT NULL, '
        . ' `status` TINYINT(1) NOT NULL,'
        . ' PRIMARY KEY (`id`)'
        . ' )';
        sql_query($sql);
        echo 'Db_updates has been installed.<br>';
	}
	private function getCompleted(){
		$result = sql_query('select name from '.$this->db_table.' where status = 1');
		$names = array();
		while ($row = mysql_fetch_assoc($result)) {
			$names[] = $row['name'];
		}
		return $names;
	}
	public function update() {
		include($this->db_updates_filename);
		$completed = $this->getCompleted();
		$count = 0; $errors = 0;
		foreach ($UPDATES as $update) {
			if (!in_array($update['name'], $completed)) {
				if (sql_query($update['query'])) {
					sql_query('insert into '.$this->db_table.' set name="'.$update['name'].'", stamp="'.time().'", status="1"');
					echo 'Executed <b>'.$update['name'].'</b><br>';
					$count++;
				}
				else {
					sql_query('insert into '.$this->db_table.' set name="'.$update['name'].'", stamp="'.time().'", status="0"');
					echo 'Error at <b>'.$update['name'].'</b><br>';
					$errors++;
				}
			}
		}
		echo 'Db updates comlete: '.$count.' - executed, '.$errors.' - errors!';
	}
}