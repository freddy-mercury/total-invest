<?php

/**
 * @class   PerfectMoneyApi
 * @details Class implements basic API functions for Perfect Money payment system.
 * @see     http://perfectmoney.com/documents/perfectmoney-api.doc
 *
 * Usage example:
 * <code>
 * <?php
 * $api = new PerfectMoneyApi(array(
 *      'account_id' => '1234567'
 *      'passphrase' => 'passphrase',
 *      'purse' => 'U123456'));
 * echo $api->getBalance();
 * if (($batch = $api->makeSpend('U7654321', 10.01, 'Spend of 10.01', array('payment_id' => 'PI-1'))))
 *      echo 'Spend made with batch: ' . $batch;
 * else
 *     echo 'Unsuccessful spend!';
 * ?>
 * </code>
 *
 * @author  Kirill Komarov
 * @link    http://kkomarov.wordpress.com
 */
class PerfectMoneyApi implements EcurrencyApi {

	private $_api_base_url = 'https://perfectmoney.com/acct';

	private $_account_id, $_passphrase, $_purse, $_altrnate_passphrase_hash;

	/**
	 * Keys: account_id, passphrase, purse, alternate_passphrase_hash (md5) are required.
	 *
	 * @param array $init_data Key-value array with initialization data ('purse' => 'U1234567').
	 */
	public function __construct(array $init_data) {
		$this->_account_id = $init_data['account_id'];
		$this->_passphrase = $init_data['passphrase'];
		$this->_purse = $init_data['purse'];
		$this->_altrnate_passphrase_hash = strtoupper($init_data['alternate_passphrase_hash']);
	}

	/**
	 * Returns response from requested url.
	 *
	 * @param $url
	 *
	 * @return mixed
	 * @throws Exception
	 */
	private function _getCurlResponse($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if (($response = curl_exec($ch)) == FALSE)
			throw new Exception(curl_error($ch));
		curl_close($ch);
		return $response;
	}

	/**
	 * Returns purse balance. {@link http://perfectmoney.com/documents/perfectmoney-api.doc}
	 *
	 * @return float
	 */
	public function getBalance() {
		$url = $this->_api_base_url . '/balance.asp'
			. '?AccountID=' . intval($this->_account_id)
			. '&PassPhrase=' . urlencode($this->_passphrase);
		$balance = $this->_getParsedHiddens($this->_getCurlResponse($url));
		return floatval($balance[$this->_purse]);
	}

	/**
	 * Makes spend. {@link http://perfectmoney.com/documents/perfectmoney-api.doc}
	 *
	 * @param string       $to_purse   Payee purse number.
	 * @param float        $amount     Amount to spend.
	 * @param string       $memo       Memo string. Max length 100 symbols.
	 * @param array        $params     Key-value array with additional parameters: PAYMENT_ID, code, period.
	 *
	 * @return integer Batch number on success, else 0 (zero).
	 */
	public function makeSpend($to_purse, $amount, $memo = '', array $params = array()) {
		$url = $this->_api_base_url . '/confirm.asp'
			. '?AccountID=' . intval($this->account)
			. '&PassPhrase=' . urlencode($this->_passphrase)
			. '&Payer_Account=' . $this->_purse
			. '&Payee_Account=' . $to_purse
			. '&Amount=' . floatval($amount)
			. '&Memo=' . urlencode(substr($memo, 0, 100))
			. (isset($params['PAYMENT_ID'])
				? '&PAYMENT_ID=' . urlencode(substr($params['PAYMENT_ID'], 0, 50))
				: ''
			);
		if (isset($params['code']))
			$url .= '&code=' . urlencode(substr($params['code'], 0, 20));
		if (isset($params['period']) && ($period = intval($params['period'])))
			if ($period >= 1 && $period <= 365)
				$url .= '&period=' . $period;
		$response = $this->_getParsedHiddens($this->_getCurlResponse($url));
		return $response['PAYMENT_BATCH_NUM'] ? : 0;
	}

	/**
	 * Returns key-value array of parsed hidden fields.
	 *
	 * @param string $content
	 *
	 * @return array
	 * @throws Exception
	 */
	private function _getParsedHiddens($content) {
		if (!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $content, $result, PREG_SET_ORDER))
			throw new Exception('Invalid response.');
		$ar = array();
		foreach ($result as $item) {
			$key = $item[1];
			$ar[$key] = $item[2];
		}
		return $ar;
	}

	/**
	 * Validates SCI payment. {@link http://perfectmoney.com/documents/perfectmoney-api.doc}
	 *
	 * @param array $data              Data from request that came from PerfectMoney server.
	 * @param array $verification_data Verification data array with keys: PAYMENT_AMOUNT, PAYEE_ACCOUNT, PAYMENT_UNITS.
	 *
	 * @return bool
	 */
	public function validatePayment(array $data, array $verification_data) {
		$string = $data['PAYMENT_ID'] . ':' . $data['PAYEE_ACCOUNT'] . ':' . $data['PAYMENT_AMOUNT'] . ':'
			. $data['PAYMENT_UNITS'] . ':' . $data['PAYMENT_BATCH_NUM'] . ':' . $data['PAYER_ACCOUNT'] . ':'
			. $this->_altrnate_passphrase_hash . ':' . $data['TIMESTAMPGMT'];

		$hash = strtoupper(md5($string));

		return ($hash == $data['V2_HASH']
			&& $data['PAYMENT_AMOUNT'] == $verification_data['PAYMENT_AMOUNT']
			&& $data['PAYEE_ACCOUNT'] == $verification_data['PAYEE_ACCOUNT']
			&& $data['PAYMENT_UNITS'] == $verification_data['PAYMENT_UNITS']);
	}

	/**
	 * Returns history. {@link http://perfectmoney.com/documents/perfectmoney-api.doc}
	 *
	 * @param array $params Key-value array with parameters: startday, startmonth, startyear, endday, endmonth,
	 *                      endyear, paymentsmade, paymentsreceived, batchfilter, counterfilter, metalfulter,
	 *                      decs, oldsort, payment_id.
	 *
	 * @return array
	 */
	public function getHistory(array $params) {
		$url = $this->_api_base_url . '/historycsv.asp'
			. '?AccountID=' . intval($this->_account_id)
			. '&PassPhrase=' . urlencode($this->_passphrase)
			. '&startmonth=' . $params['startmonth']
			. '&startday=' . $params['startday']
			. '&startyear=' . $params['startyear']
			. '&endmonth=' . $params['endmonth']
			. '&endday=' . $params['endday']
			. '&endyear=' . $params['endyear'];

		$response = $this->_getCurlResponse($url);
		$lines = explode("\n", $response);
		if ($lines[0] != 'Time,Type,Batch,Currency,Amount,Fee,Payer Account,Payee Account,Memo')
			throw new Exception('Invalid response.');
		else {
			$ar = array();
			$n = count($lines);
			for ($i = 1; $i < $n; $i++) {
				$item = explode(',', $lines[$i], 9);
				if (count($item) != 9) continue;
				$item_named['Time'] = $item[0];
				$item_named['Type'] = $item[1];
				$item_named['Batch'] = $item[2];
				$item_named['Currency'] = $item[3];
				$item_named['Amount'] = $item[4];
				$item_named['Fee'] = $item[5];
				$item_named['Payer Account'] = $item[6];
				$item_named['Payee Account'] = $item[7];
				$item_named['Memo'] = $item[8];
				array_push($ar, $item_named);
			}
		}
		return $ar;
	}

}