<?php
class Devinfo {
	public function __construct() {
		
	}
	public function getQueries() {
		$OUT = '';
		$OUT.= '<p><table cellpadding="3" cellspacing="1" border="0">'.
				'<tr'.getRowColor().'><th class="devinfo">¹</th><th class="devinfo">Time</th><th class="devinfo">Query</th></tr>';
		$i = 0;
		$total_time = 0;
		foreach ($GLOBALS['queries'] as $query) {
			$time = round($query['time'], 3)<0.001 ? 0.001 : round($query['time'], 3);
			$OUT.= '<tr'.getRowColor().'><td class="devinfo">'.++$i.'</td><td class="devinfo">'.$time.'</td><td class="devinfo">'.nl2br($query).'</td></tr>';
			$total_time+= $time;
		}
		$OUT.= '<tr'.getRowColor().'><td class="devinfo"><b>Total:</b></td><td class="devinfo">'.(round($total_time, 3)<0.001 ? 0.001 : round($total_time, 3)).'</td><td class="devinfo">&nbsp</td></tr>';
		$OUT.= '</table></p>';
		return $OUT;
	}
	public function getWarnings() {
		$OUT = '';
		$OUT.= '<p><table cellpadding="3" cellspacing="1" border="0">'.
				'<tr'.getRowColor().'><th class="devinfo">¹</th><th class="devinfo">Warning</th></tr>';
		$i = 0;
		foreach ($GLOBALS['warnings'] as $warning) {
			$OUT.= '<tr'.getRowColor().'><td class="devinfo">'.++$i.'</td><td class="devinfo">'.$warning.'</td></tr>';
		}
		$OUT.= '<tr'.getRowColor().'><td class="devinfo"><b>Total:</b></td><td class="devinfo">'.$i.'</td></tr>';
		$OUT.= '</table></p>';
		return $OUT;
	}
	public function getPayments() {
		$OUT = '';
		$OUT.= '<p><table cellpadding="3" cellspacing="1" border="0">'.
				'<tr'.getRowColor().'><th class="devinfo">¹</th><th class="devinfo">From</th><th class="devinfo">To</th><th class="devinfo">Amount</th><th class="devinfo">Batch</th></tr>';
		$i = 0;
		foreach ($GLOBALS['payments'] as $payment) {
			$OUT.= '<tr'.getRowColor().'><td class="devinfo">'.++$i.'</td><td class="devinfo">'.$payment['from'].'</td><td class="devinfo">'.$payment['to'].'</td><td class="devinfo">'.$payment['amount'].'</td><td class="devinfo">'.$payment['batch'].'</td></tr>';
		}
		$OUT.= '<tr'.getRowColor().'><td class="devinfo"><b>Total:</b></td><td class="devinfo" colspan="4">'.$i.'</td></tr>';
		$OUT.= '</table></p>';
		return $OUT;
	}
	public function getSession() {
		print_rr($_SESSION);
	}
	public function getPost() {
		print_rr($_POST);
	}
	public function getREQUEST() {
		print_rr($_REQUEST);
	}
}