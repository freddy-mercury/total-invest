<?php

class IpController {
	private $user_id;
	public function __construct($user_id = 0) {
		if (intval($user_id)) {
			$this->user_id = $user_id;
		}
	}
	public function getIps() {
		$query = 'select INET_NTOA(ip) as ip from visits where user_id="'.$this->user_id.'" group by ip';
		$result = $dbh->query($query);
		$ips = $dbh->fetchAll($result);
		return $ips;
	}
	public function saveIp() {
		if ($this->isLogable($_SERVER['REMOTE_ADDR'])) {
			sql_query('insert into visits set user_id="'.$this->user_id.'", stamp="'.Project::getInstance()->getNow().'", ip=INET_ATON("'.$_SERVER['REMOTE_ADDR'].'")');
		}
	}
	public function getLastVisit() {
		return sql_get('select max(stamp) from visits where user_id="'.$this->user_id.'"');
	}
	
	private function isLogable($remote_ip = '') {
		$logable = true;
		$remote_octets = explode('.', $remote_ip);
		foreach($GLOBALS['MY_IPS'] as $my_ip) {
			$my_octets = explode('.', $my_ip);
			$octets = array(0, 0, 0, 0);
			foreach($my_octets as $i=>$octet) {
				if ($octet == '*' || $octet == $remote_octets[$i]) {
					$octets[$i] = true;
				}
				else {
					$octets[$i] = false;
				}
			}
			if ($octets[0] == true && $octets[1] == true && $octets[2] == true && $octets[3] == true) {
				$logable = false;
			}
		}
		return $logable;
	}
}