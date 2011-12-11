<?php
/**
 * User: k.komarov
 * Date: 09.12.11
 * Time: 16:44
 * @package index-new.php
 */
define('ROOT', dirname(__FILE__));
$config = include ROOT.'/config.php';
require_once ROOT . '/library/application.class.php';

App::get($config)->run();