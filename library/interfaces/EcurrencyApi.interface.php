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
	 * @return integer Batch number on success, else 0 (zero).
	 */
	public function makeSpend($to_purse, $amount, $memo, array $params = array());

	/**
	 * Returns balance.
	 *
	 * @abstract
	 *
	 */
	public function getBalance();

	/**
	 * Validates payment.
	 *
	 * @abstract
	 *
	 * @param array $data              Data from $_POST request that came from e-currency server.
	 * @param array $verification_data Verification data to verify with $data.
	 */
	public function validatePayment(array $data, array $verification_data = array());

	/**
	 * Returns history.
	 *
	 * @abstract
	 *
	 * @param array $params Additional parameters to retrieve history.
	 */
	public function getHistory(array $params = array());
}
