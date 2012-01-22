<?php

function sql_query($query) {
	$result = mysql_query($query, App::get()->db);
	$GLOBALS['queries'][] = $query;
	return $result;
}

function sql_row($query) {
	return mysql_fetch_array(sql_query($query));
}

function sql_rows($query) {
	$rows = array();
	$result = sql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$rows[current($row)] = $row;
	}
	return $rows;
}

function sql_get($query) {
	$row = sql_row($query);
	return $row[0];
}

function sql_insert_id() {
	return mysql_insert_id(App::get()->db);
}

function sql_escapeArray($arr = array()) {
	$rs = array();
	if ($arr && is_array($arr)) {
		foreach ($arr as $key => $val) {
			if (is_array($val))
				$rs[$key] = sql_escapeArray($val);
			else
				$rs[$key] = sql_escapeStr($val);
		}
	}
	return $rs;
}

function sql_escapeStr($str = '') {
	return mysql_escape_string($str);
}

function q($unescaped_string) {
	return '"'.  mysql_real_escape_string($unescaped_string).'"';
}

function sql_fetch_assoc($result) {
	return mysql_fetch_assoc($result);
}