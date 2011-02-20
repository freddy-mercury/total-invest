<?
class Page {
	public $id;
	public $parent_id;
	public $name;
	public $text;
	public $show_in_menu;
	
	public function getAll($show_in_menu = 1) {
		global $dbh, $settings;
		$result = sql_query('select * from pages '.($show_in_menu==0 ? '' : 'WHERE show_in_menu="'.$show_in_menu.'"').' AND lang="'.$_COOKIE['lang'].'" order by id');
		$pages = array();
		while ($row = mysql_fetch_assoc($result)) {
			$pages[] = $row;
		}
		return $pages;
	}
	public function __construct($id = 0) {
		if ($id) {
			$this->load($id);
		}
	}
	private function load($id) {
		$this->seData(sql_row('select * from pages where id="'.$id.'"'));
	}
	private function seData($row) {
		$this->id = $row['id'];
		$this->parent_id = $row['parent_id'];
		$this->name = $row['name'];
		$this->text = $row['text'];
		$this->show_in_menu = $row['show_in_menu'];
	}
}
