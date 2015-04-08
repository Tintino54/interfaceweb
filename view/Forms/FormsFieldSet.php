<?php
Class FormsFieldSet {
	private $m_fields;
	function __construct(){
		$this->m_fields=array();
	}

	function addField($field){
		array_push($this->m_fields, $field);
	}

	function generate(){
		echo '<fieldset>';
		foreach ($this->m_fields as $key => $fields) {
			$fields->generate();
		}
		echo '</fieldset>';
	}
}

?>