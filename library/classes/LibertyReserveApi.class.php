<?php
/**
 * @class   LibertyReserveApi
 * @details Class implements basic API functions for Liberty Reserve payment system.
 * @see     http://www.libertyreserve.com/en/help/xmlapiguide
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
		$auth_string = $this->_secword . ':' . gmdate('Ymd') . ':' . gmdate('H');
		return $this->_getHash($auth_string);
	}

	/**
	 * @param string $string
	 *
	 * @return string
	 */
	private function _getHash($string = '') {
		return !extension_loaded('mhash')
			? strtoupper(hash('sha256', $string))
			: strtoupper(bin2hex(mhash(MHASH_SHA256, $string)));
	}

	/**
	 * @return string
	 */
	private function _getXmlAuthTag() {
		return '<Auth>'
			. '<AccountId>' . $this->_purse . '</AccountId>'
			. '<ApiName>' . $this->_api . '</ApiName>'
			. '<Token>' . $this->_getAuthToken() . '</Token>'
			. '</Auth>';
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
	 * @param SimpleXMLElement $xml
	 *
	 * @throws Exception
	 */
	private function _checkError(SimpleXMLElement $xml) {
		$error = $xml->Error;
		if ($error)
			throw new Exception($error->Text . ': ' . $error->Description, (int)$error->Code);
	}

	/**
	 * Returns balance.
	 *
	 * @param array $params Additional parameters: CurrencyId (usd, euro, gold)
	 *
	 * @return float
	 */
	public function getBalance(array $params = array()) {
		$currency_id = (isset($params['CurrencyId']) && in_array($params['CurrencyId'], array('usd', 'euro', 'gold')))
			? $params['CurrencyId'] : 'usd';
		$request = '<BalanceRequest id="' . $this->_generateId() . '">'
			. $this->_getXmlAuthTag()
			. '<Balance><CurrencyId>' . $currency_id . '</CurrencyId>'
			. '</Balance></BalanceRequest>';
		$url = $this->_api_base_url . '/balance?req=' . urlencode($request);
		$response = $this->_getCurlResponse($url);
		$xml = simplexml_load_string($response);
		$this->_checkError($xml);
		return floatval($xml->Balance->Value);
	}

	/**
	 * Makes spend.
	 *
	 * @param string       $to_purse   Payee purse number.
	 * @param float        $amount     Amount to spend.
	 * @param string       $memo       Memo string. Max length 100 symbols.
	 * @param array        $params     Key-value array with additional parameters: TransferId, CurencyId.
	 *
	 * @return integer Batch number on success, else 0 (zero).
	 */
	public function makeSpend($to_purse, $amount, $memo = '', array $params = array()) {
		$payment_purpose = 'service';
		$currency_id = 'usd';
		$anonymous = 'false';
		if (isset($params['PaymentPurpose']) && in_array($params['PaymentPurpose'], array('service', 'salary')))
			$payment_purpose = $params['PaymentPurpose'];
		if (isset($params['CurrencyId']) && in_array($params['CurrencyId'], array('usd', 'euro', 'gold')))
			$currency_id = $params['CurrencyId'];
		if (isset($params['Anonymous']) && in_array($params['Anonymous'], array('true', 'false')))
			$anonymous = $params['Anonymous'];
		$request = '<TransferRequest id="' . $this->_generateId() . '">'
			. $this->_getXmlAuthTag()
			. '<Transfer>'
			. (isset($params['TransferId']) ? '<TransferId>' . $params['TransferId'] . '</TransferId>' : '')
			. '<TransferType>transfer</TransferType>'
			. '<PaymentPurpose>' . $payment_purpose . '</PaymentPurpose>'
			. '<Payee>' . $to_purse . '</Payee>'
			. '<CurrencyId>' . $currency_id . '</CurrencyId>'
			. '<Amount>' . floatval($amount) . '</Amount>'
			. '<Memo>' . $memo . '</Memo>'
			. '<Anonymous>' . $anonymous . '</Anonymous>'
			. '</Transfer></TransferRequest>';
		$url = $this->_api_base_url . '/transfer?req=' . urlencode($request);
		$response = $this->_getCurlResponse($url);
		$xml = simplexml_load_string($response);
		$this->_checkError($xml);
		return $xml->Receipt->ReceiptId;
	}

	/**
	 * Validates payment.
	 *
	 * @param array $data              Data from $_POST request that came from e-currency server.
	 * @param array $verification_data Verification data to compare with $data: sci_store, sci_secword.
	 *
	 * @return boolean
	 * @throws Exception
	 */
	public function validatePayment(array $data, array $verification_data = array()) {
		if (!isset($verification_data['sci_store']) || !isset($verification_data['sci_secword']))
			throw new Exception('Verification error: sci_store or sci_secword not defined!');
		$string = $data['lr_paidto'] . ':' . $data['lr_paidby'] . ':' . $data['lr_store'] . ':'
			. $data['lr_amnt'] . ':' . $data['lr_transfer'] . ':' . $data['lr_currency'] . ':'
			. $verification_data['sci_secword'];
		return (isset($data['lr_paidto']) && $data['lr_paidto'] == strtoupper($this->_purse)
			&& isset($data['lr_store']) && $data['lr_store'] == $verification_data['sci_store']
			&& isset($data['lr_encrypted']) && $data['lr_encrypted'] == $this->_getHash($string)
		);
	}

	/**
	 * Returns history.
	 *
	 *
	 * @param array $params Additional parameters to retrieve history.
	 *
	 * @return array
	 */
	public function getHistory(array $params = array()) {
		// TODO: Implement getHistory() method.
	}
}
