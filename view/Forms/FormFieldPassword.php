<?php
require_once('FormField.php');
class FormFieldPassword extends FormField{
	private $m_size;
	private $m_maxlength;
	function __construct($name,$value,$label,$javascript,$size,$maxlength){
		parent::__construct($name,$value,$label,$javascript);
		$this->m_size=$size;
		$this->m_maxlength=$maxlength;
	}
	//génére la la balise input password
	function generate(){
		if($this->m_label!=""){
			echo '<label>'.$this->m_label;
			echo '</label>';
		}
		echo '<input type="password" ';
		echo 'name='.'"'.$this->m_name.'" ';
		echo 'value='.'"'.$this->m_value.'" ';
		echo 'size='.'"'.$this->m_size.'" ';
		echo 'maxlength='.'"'.$this->m_maxlength.'" ';
		echo $this->m_javascript;
		echo "/>";
		echo "<br />";
	}

}

?>