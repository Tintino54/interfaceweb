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
        echo '<h1>Prof</h1>';
        echo '<h2>PHP Rad ORM framework</h2>';
        echo '</div>';
        echo '<ul id="tabs">';
        echo  '<li><a href="../index.php">Home</a></li>';
        echo   '<li><a href="#">About</a></li>';
        echo  '<li><a href="#">Documentation</a></li>';
        echo   '<li><a href="#">Login</a></li>';
        echo '</ul>';
		echo '</header>';
	}
	
	// end <body> and display footer
	public function end() {
		echo '<footer>';
        echo '<hr>';
        echo '<p>© 2015 Alexandre Le Fol | Valentin Ginisty</p>';
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
