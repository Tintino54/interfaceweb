<?php
require_once('Ligne.php');
Class Tableau{
	private $m_name;
	private $m_id;
	private $m_javascript;
	private $m_lignes;

	public function __construct($name,$id){
		$this->m_name;
		$this->m_id;
		$this->m_javascript;
		$this->m_lignes=array();
	}

	function addLigne($ligne){
		array_push($this->m_lignes,$ligne);
	}

	public function generate(){
		echo '<table ';
		echo 'name='.'"'.$this->m_name.'" ';
		echo 'id='.'"'.$this->m_id.'" ';
		echo 'javascript='.'"'.$this->m_javascript.'" ';
		echo ">";
		foreach ($this->m_lignes as $key => $lignes) {
			$lignes->generate();
		}

		echo '</table>';
	}

}

$Tab=new Tableau('nom','id');
	$l1=new Ligne('l1','l1');
	$Tab->addLigne($l1);
		$c1=new Colonne('c1','c1');
		$l1->addColonne($c1);
$Tab->generate();
?>