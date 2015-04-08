<?php
Class colonne {
	private $m_item;
	public function __construct($item){
		$this->m_item=$item;
	}

	public function generate(){
		echo '<td>';
		//$this->m_item->generate();
		echo '</td>';
	}
}



?>