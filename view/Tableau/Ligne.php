<?php
Class Ligne {
	private $m_item;
	public function __construct($item){
		$this->m_item = $item;
	}

	public function generate(){
		echo '<td>';
		echo $this->m_item;
		echo '</td>';
	}
}

?>