<?php

class HintsController {
	private $hint_exists = false;
	private $hint;
	private static $instance;
    private function __construct() {
    	
    }
    /**
     * GetInstance
     *
     * @return HintsController
     */
	public static function getInstance() {
		if (!isset($GLOBALS[HC_INSTANCE]) || !($GLOBALS[HC_INSTANCE] instanceof HintsController)) {
			$c = __CLASS__;
			$GLOBALS[HC_INSTANCE] = new $c;
		}
		return $GLOBALS[HC_INSTANCE];
	}
	private function getHintByKeyword($keyword) {
		global $dbh;
		$query = "SELECT * FROM hints WHERE keyword='$keyword' LIMIT 1";
		$result = $dbh->query($query);
		if ($dbh->fetched_rows($result)) {
			$this->hint = $dbh->fetch($result);
			$this->hint_exists = true;
		}
		else {
			$this->hint_exists = false;
		}
	}
	private function getHelpLink($keyword) {
		if (IS_DEVELOPER) {
			return ' (<a href="javascript:popupHint(\''.$keyword.'\')">?</a>)';
		}
		else return '';
	}
	public function getHintText($keyword, $link = true) {
		$this->getHintByKeyword($keyword);
		if ($this->hint_exists) {
			return $this->hint['text'].($link ? $this->getHelpLink($keyword) : '');
		}
		else return ''.($link ? $this->getHelpLink($keyword) : '');		
	}
	public function getHintTitle($keyword, $link = true) {
		$this->getHintByKeyword($keyword);
		if ($this->hint_exists) {
			return $this->hint['title'].($link ? $this->getHelpLink($keyword) : '');
		}
		else return ''.($link ? $this->getHelpLink($keyword) : '');
	}
	public function updateHint($keyword, $hint_title, $hint_text) {
		global $dbh;
		$this->getHintByKeyword($keyword);
		if ($this->hint_exists) {
			echo 'Подсказка сохранена';
			$query = "
				UPDATE hints
				SET
					hint='$hint_title',
					text='$hint_text'
				WHERE keyword = '$keyword'
			";
		}
		else {
			echo 'Подсказка создана';
			$query = "
				INSERT INTO hints (keyword, title, text)
				VALUES ('$keyword', '$hint_title', '$hint_text')
			";
		}
		$dbh->query($query);
	}
	public function deleteHint($keyword) {
		global $dbh;
		$query = "
			DELETE FROM hints WHERE keyword='$keyword'
		";
		$this->getHintByKeyword($keyword);
		if ($this->hint_exists) {
			echo 'Посказка удалена';
			$dbh->query($query);
		}
	}
}