<?
class Plan {
	public $id;
	public $name;
	public $min;
	public $max;
	public $percent;
	public $percent_per;
	public $periodicy;
	public $periodicy_value;
	public $term;
	public $attempts;
	public $comment;
	public $status;
	public $type;
	public $working_days;
	/**
	 * Получаем все планы в виде массива
	 *
	 * @param boolean $disabled выводить ли выключенные планы 
	 * @return array
	 */
	public function getAll($disabled = false) {
		$where = 'where 1=1 ';
		if ($disabled) {
			$where .= '';
		}
		else $where .= ' and status="1"';
		include_once(LIB_ROOT.'/users/user.class.php');
		if (Project::getInstance()->getCurUser()->isAdmin()) {
			$where.= '';
		}
		elseif (Project::getInstance()->getCurUser()->monitor == 1) {
			$where.= ' and type in (1, 2)';
		}
		else {
			$where.= ' and type in (0, 2)';
		}
		$result = sql_query('select * from plans '.$where.' order by id');
		$plans = array();
		while ($row = mysql_fetch_assoc($result)) {
			$plans[] = $row;
 		}
		return $plans;
	}
	public function __construct($id = 0) {
		if ($id) {
			$this->load($id);
		}
	}
	private function load($id) {
		$this->seData(sql_row('select * from plans where id="'.$id.'"'));
	}
	private function seData($row) {
		$this->id = $row['id'];
		$this->name = $row['name'];
		$this->min = $row['min'];
		$this->max = $row['max'];
		$this->percent = $row['percent'];
		$this->percent_per = $row['percent_per'];
		$this->periodicy = $row['periodicy'];
		$this->periodicy_value = $row['periodicy_value'];
		$this->term = $row['term'];
		$this->attempts = $row['attempts'];
		$this->comment = $row['comment'];
		$this->status = $row['status'];
		$this->type = $row['type'];
		$this->working_days = $row['working_days'];
	}
	public function changeStatus() {
		$status = $this->status ? 0 : 1;
		sql_query("update plans set status='{$status}' where id='{$this->id}'");
	}
}