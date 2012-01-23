<?php

interface EcurrencyApi {

	/**
	 * @abstract
	 *
	 * @param array $init_data Init API with initialization data such as api name, api swecurity word and etc.
	 */
	public function __construct(array $init_data);

	/**
	 * Makes spend.
	 *
	 * @abstract
	 *
	 * @param string       $to_purse   Payee purse number.
	 * @param float        $amount     Amount to spend.
	 * @param string       $memo       Memo string.
	 * @param array        $params     Additional parameters.
	 *
	 * @return mixed Batch number on success.
	 * @throws Exception
	 */
	public function makeSpend($to_purse, $amount, $memo = '', array $params = array());

	/**
	 * Returns balance.
	 *
	 * @abstract
	 *
	 * @param array $params Additional parameters.
	 *
	 * @return float
	 * @throws Exception
	 */
	public function getBalance(array $params = array());

	/**
	 * Validates payment.
	 *
	 * @abstract
	 *
	 * @param array $data              Data from $_POST request that came from e-currency server.
	 * @param array $verification_data Verification data to verify with $data.
	 *
	 * @return boolean
	 */
	public function validatePayment(array $data, array $verification_data = array());

	/**
	 * Returns history.
	 *
	 * @abstract
	 *
	 * @param array $params Additional parameters to retrieve history.
	 *
	 * @return array
	 */
	public function getHistory(array $params = array());
}
