<?php
require_once('Colonne.php');
Class Ligne {
	private $m_name;
	private $m_id;
	private $m_colonnes;

	public function __construct($name,$id){
		$this->m_name=$name;
		$this->m_id=$id;
		$this->m_colonnes=array();
	}

	public function addColonne($colonne){
		array_push($this->m_colonnes,$colonne);
	}

	public function generate(){
		echo '<tr name="'.$this->m_name.'"'.' id="'.$this->m_id.'"'.'>';
		foreach ($this->m_colonnes as $key => $colonne) {
			$colonne->generate();
		}
		echo '</tr>';
	}




}

?>