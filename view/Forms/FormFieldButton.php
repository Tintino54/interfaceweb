<?php
require_once('FormField.php');
	class FormFieldButton extends FormField{
		function __construct($name,$value,$label,$javascript){
			parent::__construct($name,$value,$label,$javascript);
		}

		function generate(){
			if($this->m_label!=""){
				echo '<label>'.$this->m_label;
				echo '</label>';
			}
			echo '<input type="button" ';
			echo 'name='.'"'.$this->m_name.'" ';
			echo 'value='.'"'.$this->m_value.'" ';
			echo 'javascript'.'"'.$this->m_javascript.'" ';
			echo "/>";
		}
	}


?>