<?php
require_once('Ligne.php');
Class Tableau{
	private $m_name;
	private $m_id;
	private $m_lignes;
	private $m_nbColonnes;

	public function __construct($name,$id, $nbColonnes){
		$this->m_name=$name;
		$this->m_id=$id;
		$this->m_lignes=array();
		$this->m_nbColonnes = $nbColonnes;
	}

	function addLigne($ligne){
		array_push($this->m_lignes,$ligne);
	}

	public function generate(){
		echo '<table cellspacing="50" name="'.$this->m_name.'"'.' id="'.$this->m_id.'"'.' >';
		echo '<tr>';
		$compteur = 0;
		foreach ($this->m_lignes as $key => $ligne) {
			$ligne->generate();	
			$compteur++;
			if($compteur % $this->m_nbColonnes == 0){
						echo '</tr><tr>';
						$compteur = 0;
			}
		}
		echo '</tr>';
		echo '</table>';
	}

}
?>