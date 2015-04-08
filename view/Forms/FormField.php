<?php
abstract class FormField{
// name of field
protected $m_name;
//default value
protected $m_value;
//label that will be displayed
protected $m_label;
//javascript function associated
protected $m_javascript;

function __construct($name,$value,$label,$javascript){
	$this->m_name=$name;
	$this->m_value=$value;
	$this->m_label=$label;
	$this->m_javascript=$javascript;
}

abstract function generate();

};

?>