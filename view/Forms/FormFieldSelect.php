<?php
require_once('FormField.php');
class FormFieldSelect extends FormField{
	private $m_options;
	function __construct($name,$value,$label,$javascript,$options){
		parent::__construct($name,$value,$label,$javascript);
		$this->m_options=array();
		$this->m_options=$options;
	}
	//génére la la balise input password
	function generate(){
		if($this->m_label!="")
			echo '<label>'.$this->m_label;
		echo '<select ';
		echo 'name='.'"'.$this->m_name.'" ';
		echo 'value='.'"'.$this->m_value.'" ';
		echo 'javascript'.'"'.$this->m_javascript.'" ';
		echo '>';
		foreach ($this->m_options as $value => $option) {
			echo '<option ';
			echo 'value='.'"'.$value.'">';
			echo $option;
			echo '</option>' ;
		}
		echo '</select>';
	}

};

?>