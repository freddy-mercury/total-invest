<?php
/**
 * @class   LibertyReserveApi
 * @details Class implements basic API functions for Liberty Reserve payment system.
 *
 * Usage example:
 * <code>
 * <?php
 * $api = new LibertyReserveApi(array(
 *      'api' => 'api'
 *      'secword' => 'secword',
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
class LibertyReserveApi implements EcurrencyApi {

	private $_api_base_url = 'https://api2.libertyreserve.com/xml';

	private $_api, $_secword, $_purse;

	/**
	 * Keys: api, secword, purse required.
	 *
	 * @param array $init_data Key-value array with initialization data ('purse' => 'U1234567').
	 */
	public function __construct(array $init_data) {
		$this->_api = $init_data['api'];
		$this->_secword = $init_data['secword'];
		$this->_purse = $init_data['purse'];
	}

	/**
	 * @return string
	 */
	private function _generateId() {
		return time() . rand(0, 9999);
	}

	/**
	 * Creates authentication token.
	 *
	 * @return string Authentication token.
	 */
	private function _getAuthToken() {
		$auth_string = $this->_secword . ":" . gmdate("Ymd") . ":" . gmdate("H");
		return !extension_loaded('mhash')
			? strtoupper(hash('sha256', $auth_string))
			: strtoupper(bin2hex(mhash(MHASH_SHA256, $auth_string)));
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
	 * Returns balance.
	 *
	 * @return float
	 */
	public function getBalance() {
		$request = '<BalanceRequest id="' . $this->_generateId() . '"><Auth><ApiName>' . $this->_api
			. '</ApiName><Token>' . $this->_getAuthToken() . '</Token></Auth>'
			. '<Balance><CurrencyId>LRUSD</CurrencyId><AccountId>' . $this->_purse . '</AccountId>'
			. '</Balance></BalanceRequest>';
		$url = 'https://api.libertyreserve.com/xml/balance.aspx?req=' . urlencode($request);
		$response = $this->_getCurlResponse($url);
		$xml = simplexml_load_string($response);
		return $xml !== false ? floatval($xml->Balance->Value) : 0;
	}

	/**
	 * Makes spend. {@link http://www.libertyreserve.com/en/help/xmlapiguide}
	 *
	 * @param string       $to_purse   Payee purse number.
	 * @param float        $amount     Amount to spend.
	 * @param string       $memo       Memo string. Max length 100 symbols.
	 * @param array        $params     Key-value array with additional parameters: TransferId, CurencyId.
	 *
	 * @return integer Batch number on success, else 0 (zero).
	 */
	public function makeSpend($to_purse, $amount, $memo, array $params) {
		$payment_purpose = isset($params['PaymentPurpose']) && in_array($params['PaymentPurpose'], array('service',
		                                                                                                'salary'))
			? $params['PaymentPurpose'] : 'service';
		$request = '<TransferRequest id="' . $this->_generateId() . '">'
			. '<Auth><AccountId>' . $this->_purse . '</AccountId><ApiName>' . $this->_api
			. '</ApiName><Token>' . $this->_getAuthToken() . '</Token></Auth>'
			. '<Transfer>' . (isset($params['TransferId']) ? '<TransferId>' . $params['TransferId']
			. '</TransferId>' : '')
			. '<TransferType>transfer</TransferType><PaymentPurpose>' . $payment_purpose . '</PaymentPurpose>'
			. '<Payee>' . $to_purse . '</Payee><CurrencyId>'
			. (isset($params['CurrencyId']) ? $params['CurrencyId'] : 'usd') . '</CurrencyId>'
			. '<Amount>' . floatval($amount) . '</Amount><Memo>' . $memo . '</Memo><Anonymous>anonymous</Anonymous>'
			. '</Transfer></TransferRequest>';
		$url = $this->_api_base_url . '/transfer.aspx?req=' . urlencode($request);
		$response = $this->_getCurlResponse($url);
		$xml = simplexml_load_string($response);
		if (isset($xml->Receipt->ReceiptId)) return $xml->Receipt->ReceiptId; else return 0;
	}

	/**
	 * Validates payment.
	 *
	 * @param array $data              Data from $_POST request that came from e-currency server.
	 * @param array $verification_data Verification data to compare with $data.
	 */
	public function validatePayment(array $data, array $verification_data) {
		// TODO: Implement validatePayment() method.
	}

	/**
	 * Returns history.
	 *
	 *
	 * @param array $params
	 */
	public function getHistory(array $params) {
		// TODO: Implement getHistory() method.
	}
}
