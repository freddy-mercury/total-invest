<?
class Statistics {
	public $user_id = 0;
	public $select = '*';
	public $where = '';
	public $limit = '';
	
	public $last_deposit;
	public $last_withdrawal;
	
	public function __construct($user_id = 0) {
		if ($user_id) {
			$this->user_id = $user_id;
			$this->load();
		}
	}
	private function load() {
		$this->last_deposit = $this->getLastDeposit();
		$this->last_withdrawal = $this->getLastWithdrawal();
	}
	public function getLines($types = array('e', 'r', 'd', 'w', 'b', 'i'), $status = 1, $stamp_from = 0, $stamp_to = 0) {
        $types = array_intersect($types, array('e', 'r', 'd', 'w', 'b', 'i'));
		$where_user = $this->user_id != 0 ? ' and translines.user_id="'.$this->user_id.'"' : '';
		$where_status = ' and translines.status in'.(is_array($status) ? ' ("'.implode('", "', $status).'")' : ' ("'.$status.'")');
		$where_stamp_from = $stamp_from > 0 ? ' and translines.stamp>'.$stamp_from : '';
		$where_stamp_to = ' and translines.stamp<'.($stamp_to > 0 ? $stamp_to : Project::getInstance()->getNow());
		$query = '
			select 
				'.$this->select.', plans.name as name
			from translines 
			left join plans on plans.id=translines.plan_id
			where 
				1=1
				'.$where_user.'
				 and translines.type in ("'.implode('", "', $types).'") 
				'.$where_status.'
				'.$where_stamp_from.'
				'.$where_stamp_to.'
				'.$this->where.'
			order by stamp desc '.$this->limit;
		$result = sql_query($query);
		$lines = array();
		while ($row = mysql_fetch_assoc($result)) {
			$lines[] = $row;
		}
		return $lines;
	}
	public function getLastDeposit() {
		$query = '
			select 
				amount, stamp
			from translines
			where 
				translines.user_id="'.$this->user_id.'" and 
				translines.status = "2" and
				translines.type="d" and
				translines.stamp<'.Project::getInstance()->getNow().'
			order by translines.stamp desc
			limit 1
		';
		$sum = sql_row($query);
		return (empty($sum[0]) ? 0 : $sum[0]).($sum[1]>0 ? ' on '.date('M d, Y H:i', $sum[1]) : '');
	}
	public function getLastWithdrawal() {
		$query = '
			select 
				amount, stamp
			from translines
			where 
				translines.user_id="'.$this->user_id.'" and 
				translines.status = "1" and
				translines.type="w" and
				translines.stamp<'.Project::getInstance()->getNow().'
			order by translines.stamp desc
			limit 1
		';
		$sum = sql_row($query);
		return (empty($sum[0]) ? 0 : $sum[0]).($sum[1]>0 ? ' on '.date('M d, Y H:i', $sum[1]) : '');
	}
	public function getNextEarningTime() {
		$now = Project::getInstance()->getNow();
		$earning = sql_row('select stamp from translines where user_id="'.$this->user_id.'" and type="e" and stamp>'.$now.' order by stamp asc limit 1');
		$earning[1] = $now;
		return $earning;
	}
	public function getXML() {
		$dates = sql_row('select min(stamp), max(stamp) from translines where type in ("w", "d") and status in (1, 2)');
		$start_date = $dates[0];
		$end_date = $dates[1];
		$first_day = mktime(0, 0, 0, date('m', $start_date), date('d', $start_date), date('Y', $start_date));
		$step = 86400*7; //1day
		$i = $first_day;
		$data = array();
		while ($i < $end_date+$step) {
			$this->select = 'sum(amount) as s';
			$deposited = $this->getLines(array('d'), 2, $i, $i+$step);
			$reinvested = $this->getLines(array('i'), 1, $i, $i+$step);
			$withrawn = $this->getLines(array('w'), 1, $i, $i+$step);
			$data[$i] = array($deposited[0]['s']-abs($reinvested[0]['s']), abs($withrawn[0]['s']));
			$i+=$step;
		}
		array_pop($data);
		$fp = fopen('stats.xml', 'w');
		$xml = "<chart>
   		<axis_category orientation='diagonal_up' size='10' step='1' />
   		<chart_type>
   			<string>line</string>
   			<string>line</string>
   		</chart_type>
   		<chart_grid_h alpha='10' thickness='1' />
		<chart_guide horizontal='true' vertical='true' thickness='1' alpha='25' type='dashed' text_h_alpha='0' text_v_alpha='0' />
		<chart_pref line_thickness='2' point_shape='circle' point_size='7' fill_shape='false' />
		<series_color>
			<color>ff4422</color>
			<color>00FF00</color>
		</series_color>
		<filter>
			<shadow id='medium' distance='2' angle='45' alpha='40' blurX='7' blurY='7' />
			<bevel id='note' angle='45' blurX='10' blurY='10' distance='3' highlightAlpha='60' shadowAlpha='15' />
		</filter>
		<chart_data><row><null/>";
		$xml.= '';
		foreach ($data as $key=>$value) {
				$xml.= '<string>'.date('d.m.Y', $key).'</string>';
		}
		$xml.= '</row><row><string>Deposits per day</string>';
		foreach ($data as $key=>$value) {
			if (is_null($value[0])) $value[0] = 0;
			if (is_null($value[1]) || $value[1] == 0) $value[1] = 1;
			$xml.= '<number tooltip="$'.$value[0].'" '.($value[0]>0 ? 'note="'.number_format(($value[0]/$value[1]*100), 2).'"' : '').'>'.$value[0].'</number>';
		}
		$xml.='</row><row><string>Withdrawals per day</string>';
		foreach ($data as $key=>$value) {
			if (is_null($value[1])) $value[1] = 0;
			$xml.= '<number tooltip="$'.$value[1].'">'.$value[1].'</number>';
		}
		$xml.='</row>';
		$xml.="</chart_data></chart>";
		fputs($fp, $xml);
		fclose($fp);
	}
	public function getAttemptsCount($plan_id) {
		return sql_get("
			SELECT count(*) FROM translines 
			WHERE user_id='{$this->user_id}' and plan_id='{$plan_id}' and type='d' and status='2'
		");
	}
	public function getSums() {
		$query = '
			select type, sum(amount) as sum from translines where 
				translines.user_id="'.$this->user_id.'" and 
				translines.status > 0 and 
				translines.stamp < '.Project::getInstance()->getNow().' 
			group by translines.type
		';
		$result = sql_query($query);
		$sums = array();
		while ($row = mysql_fetch_assoc($result)) {
			$sums[$row['type']] = $row['sum'];
		}
		return $sums;
	}
}
?>
