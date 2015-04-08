<?php
require_once('Ligne.php');
Class Tableau{
	private $m_name;
	private $m_id;
	private $m_lignes;

	public function __construct($name,$id){
		$this->m_name=$name;
		$this->m_id=$id;
		$this->m_lignes=array();
	}

	function addLigne($ligne){
		array_push($this->m_lignes,$ligne);
	}

	public function generate(){
		echo '<table name="'.$this->m_name.'"'.' id="'.$this->m_id.'"'.' >';
		foreach ($this->m_lignes as $key => $ligne) {
			$ligne->generate();
		}

		echo '</table>';
	}

}
echo '<!DOCTYPE html>';
echo '<html>';
$Tab=new Tableau('tab','tab');
	$l1=new Ligne('l1','l1');
	$Tab->addLigne($l1);
		$c1=new Colonne('c1');
		$c2=new Colonne('c2');
		$l1->addColonne($c1);
		$l1->addColonne($c2);
$Tab->generate();
echo '</html>';
?>