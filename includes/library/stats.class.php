<?
class Stats {
	public $days_online;
	public $total_accounts;
	public $total_deposited;
	public $today_deposited;
	public $last_deposit;
	public $today_withdrawal;
	public $total_withdraw;
	public $last_withdrawal;
	public $visitors_online;
	public $members_online;
	public $newest_member;
	
	public function __construct() {
		global $dbh;
		$stats = $dbh->fetch($dbh->query('select * from stats WHERE id="1"'));
		$this->days_online = $stats['days_online'];
		$this->total_accounts = $stats['total_accounts'];
		$this->total_deposited = $stats['total_deposited'];
		$this->today_deposited = $stats['today_deposited'];
		$this->last_deposit = $stats['last_deposit'];
		$this->today_withdrawal = $stats['today_withdrawal'];
		$this->total_withdraw = $stats['total_withdraw'];
		$this->last_withdrawal = $stats['last_withdrawal'];
		$this->visitors_online = $stats['visitors_online'];
		$this->members_online = $stats['members_online'];
		$this->newest_member = $stats['newest_member'];
	}
}