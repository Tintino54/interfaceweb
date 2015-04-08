<?php

//require_once("../model/CoreObject.php");
class Document {
	
	// default constructor : calls htmlHeader
	public function __construct($css="",$javascript="",$meta=""){
		echo '<!DOCTYPE html>';
		echo '<html>';
		$this->htmlHeader($css,$javascript,$meta);
	}
	// start the <body> part of the page
	public function begin($level=0){
		echo '<body>';
	}
	// display the <head> part of the page
	public function htmlHeader($css="",$javascript="",$meta=""){
		echo '<head>';
		echo '<meta charset='.'"'.$meta.'"'.' />';
		echo '<link rel="stylesheet" type="text/css" href='.'"'.$css.'"'.' />';
		echo '<script type="text/javascript" ';
		echo 'src="'.$javascript.'"'.' >';
		echo '</script>';
		echo '</head>';
	}
	// header section
	public function header(){
		echo '<header id="mainHeader">';
        echo '<div id="mainTitle">';
        echo '<h1>IPAW</h1>';
        echo '<h2>Interface problem algorithm web</h2>';
        echo '</div>';
        echo '<img src="./view/American-Native3.gif" alt="logo" height="100" width="100" style = "float: right">';
		echo '</header>';
	}
	
	// end <body> and display footer
	public function end() {
		echo '<footer>';
        echo '<hr>';
        echo '<p>04/2015 | Alexandre Le Fol | Valentin Ginisty</p>';
        echo "<p>Création d'interface dans un cadre de projet</p>";
		echo '</footer>';
		echo '</body>';
		echo '</html>';
	}
	// begin a subject section
	public function beginSection($name, $id=""){
		echo '<div ';
		echo 'id ='.'"'.$id.'" ';
		echo 'name='.'"'.$name.'"'.'>';	
	}
	// end a subject section
	public function endSection(){
		echo '</div>';
	}

	public function customSection($section){
		echo $section;
	}
}

?>
