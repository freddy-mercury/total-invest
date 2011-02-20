<?php
/**
 * @package Perfect Money API class
 * @author Kirill Komarov
 * @version 1.0
 * @since 03-2009
 *
 */
class PerfectMoney {
	public $account;
	public $passphrase;
	/**
	 * If TRUE will cause script to show error message and stop execution.
	 *
	 * @var bool
	 */
	public $debug = false;
	public $error = false;
	public $errorCode;
	private $errorMessages = array(
		0 => 'Account or PassPhrase is not defined',
		1 => 'Error openning URL',
		2 => 'Invalid response returned',
		3 => 'Response error',
		4 => '',
		5 => '',
	);
	/**
	 * Constructor
	 * The AccountID and PassPhrase can be defined here.
	 *
	 * @param string $account
	 * @param string $passphrase
	 */
	public function __construct($account = '', $passphrase = '') {
		if (!empty($account) && !empty($passphrase)) {
			$this->account = $account;
			$this->passphrase = $passphrase;
		}
	}
	/**
	 * Returns the balance of all accounts as assoc. array
	 *
	 * @return array
	 */
	public function getBalance() {
		$this->checkAccountDataIsSet();
		$url = 'https://perfectmoney.com/acct/balance.asp?AccountID='.$this->account.'&PassPhrase='.$this->passphrase;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		if(($response = curl_exec ($ch))==FALSE) die(curl_error($ch));
		curl_close ($ch);
		return $this->getHiddens($response);
	}
	/**
	 * Make spend to another account
	 *
	 * @param string $payer_account
	 * @param string $payee_account
	 * @param float $amount
	 * @param int $pay_in - Currency to pay in
	 * @param string $payment_id
	 * @param string $memo
	 * @return int - Returns BATCH if spend was made, else return FALSE
	 */
	public function transfer($payer_account, $payee_account, $amount, $memo = '', $pay_in = '1', $payment_id = '') {
		$url = 'https://perfectmoney.com/acct/confirm.asp?AccountID='.$this->account.'&PassPhrase='.$this->passphrase.'&Payer_Account='.$payer_account.'&Payee_Account='.$payee_account.'&Amount='.$amount.'&PAY_IN='.$pay_in.'&PAYMENT_ID='.$payment_id.'&Memo='.substr(urlencode($memo), 0, 40);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		if(($response = curl_exec ($ch))==FALSE) die(curl_error($ch));
		curl_close ($ch);
		$response = $this->getHiddens($response);
		return (empty($response['ERROR']) ? $response['PAYMENT_BATCH_NUM'] : false);
	}
	private function checkAccountDataIsSet() {
		if (empty($this->account) || empty($this->passphrase)) {
		   	$this->printError(0);
		   	return false;
		}
		return true;
	}
	private function printError($errorCode, $details = '') {
		if ($this->debug) {
			echo '<div>'.__CLASS__.' error: '.$this->errorMessages[$errorCode].'</div>';
			if (!empty($details)) {
				echo '<div>Details: '.$details.'</div>';
			}
			if ($errorCode == 0) exit;
		}
		else {
			$this->error = true;
			$this->errorCode = $errorCode;
		}
	}
	private function getHiddens($out) {
		// searching for hidden fields
		if(!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $out, $result, PREG_SET_ORDER)){
		   $this->printError(2);
		}
		// putting data to array
		$ar = array();
		foreach($result as $item){
		   $key = $item[1];
		   $ar[$key] = $item[2];
		}
		return $ar;
	}
}