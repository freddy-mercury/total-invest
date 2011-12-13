<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Asus
 * Date: 11.12.11
 * Time: 18:58
 * To change this template use File | Settings | File Templates.
 */
return array(
	'modules' => array('user', 'administrator'),
	'db' => array(
		'host' => 'localhost',
		'database' => 'total-invest',
		'user' => 'root',
		'password' => '',
	),
	'recaptcha' => array(
		'enabled' => true,
		'public_key' => '6LcNwsQSAAAAAGlQU25aUQDDUs1wFbv_j3XHZZ8b',
		'private_key' => '6LcNwsQSAAAAAMKYE64_1FChTxf1MkF5OQBNm-t7'
	),
);