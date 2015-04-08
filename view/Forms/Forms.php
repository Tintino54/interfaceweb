<?php
Class Forms{
	private $m_name;
	private $m_action;
	private $m_method;
	private $m_fieldsets;//champs du formulaire
	private $m_javascript;

	function __construct($name,$action,$method="POST",$javascript=""){
		$this->m_name=$name;
		$this->m_action=$action;
		$this->m_method=$method;
		$this->m_fieldsets=array();
		$this->m_javascript=$javascript;
	}

	function addFieldset($fieldset){
		array_push($this->m_fieldsets,$fieldset);
	}

	function generate(){
		echo '<form name='.'"'.$this->m_name.'" ';
		echo 'action='.'"'.$this->m_action.'" ';
		echo 'method='.'"'.$this->m_method.'" '; 
		echo 'javascript='.'"'.$this->m_javascript.'" ';
		echo ">";
		foreach ($this->m_fieldsets as $key => $fieldset) {
			$fieldset->generate();
		}
		echo '</form>';
	}
}


?>