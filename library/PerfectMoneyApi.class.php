<?php

class PerfectMoneyApi extends AbstractDomainModel {

	public $account_id, $purse, $passphrase;

	/**
	 * @param $url
	 * @return mixed
	 * @throws Exception
	 */
	private function getCurlResponse($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if (($response = curl_exec($ch)) == FALSE)
			throw new Exception(curl_error($ch));
		curl_close($ch);
		return $response;
	}

	/**
	 * @return float
	 */
	public function getBalance() {
		$url = 'https://perfectmoney.com/acct/balance.asp?AccountID=' . urlencode($this->account_id)
			. '&PassPhrase=' . urlencode($this->passphrase);
		$balance = $this->getParsedHiddens($this->getCurlResponse($url));
		return floatval($balance[$this->purse]);
	}

	/**
	 * @param $payto_account
	 * @param $amount
	 * @param string $memo
	 * @param string $pay_in
	 * @param string $payment_id
	 * @return bool
	 */
	public function makeSpend($payto_account, $amount, $memo = '', $pay_in = '1', $payment_id = '') {
		$url = 'https://perfectmoney.com/acct/confirm.asp?AccountID=' . $this->account
			. '&PassPhrase=' . $this->passphrase . '&Payer_Account=' . $this->purse . '&Payee_Account=' . $payto_account
			. '&Amount=' . $amount . '&PAY_IN=' . $pay_in . '&PAYMENT_ID=' . $payment_id . '&Memo=' . substr(urlencode($memo), 0, 40);
		$response = $this->getParsedHiddens($this->getCurlResponse($url));
		return $response['PAYMENT_BATCH_NUM'] ?: false;
	}

	/**
	 * @param $content
	 * @return array
	 * @throws Exception
	 */
	private function getParsedHiddens($content) {
		// searching for hidden fields
		if(!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $content, $result, PREG_SET_ORDER))
			throw new Exception('Invalid response.');
		// putting data to array
		$ar = array();
		foreach($result as $item){
			$key = $item[1];
			$ar[$key] = $item[2];
		}
		return $ar;
	}
}
