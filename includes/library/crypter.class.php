<?php
class Crypter {
	private $crypter_salt = 1;
	private $crypter_alphabet = '';
	public function __construct() {
		for ($i = 1; $i < 265; $i++) {
			$this->crypter_alphabet.= chr($i);
		}
	}
	public function encrypt($data = '') {
		return $data;
		$encrypted = '';
		for ($i = 0; $i < strlen($data); $i++) {
			$encrypted.= chr(256-ord($data[$i]));
		}
		return $encrypted;
	}
}