<?php

require_once("Tableau/Tableau.php");
class Document {
	
	// default constructor : calls htmlHeader
	public function __construct($css="",$meta=""){
		echo '<!DOCTYPE html>';
		echo '<html>';
		echo '<head>';
		$this->meta($meta);
		$this->css($css);
	}
	// start the <body> part of the page
	public function begin($level=0){
		session_start();
		echo '<body>';
	}
	// display the <head> part of the page

	public function meta($meta=""){
		echo '<meta charset='.'"'.$meta.'"'.' />';
	}

	public function css($css=""){
		echo '<link rel="stylesheet" type="text/css" href='.'"'.$css.'"'.' />';
	}

	//fin head
	public function fh(){
		echo '</head>';
	}

	public function addJavascript($javascript){
		echo '<script type="text/javascript" ';
		echo 'src="'.$javascript.'"'.' >';
		echo '</script>';
	}
	// header section
	public function header(){
		echo '<header id="mainHeader">';
		echo '<table>';
		echo '<tr>';
		echo '<td>';
        echo '<div id="mainTitle">';
        echo '<h1>Résultats d\'instances de problèmes</h1>';
        echo '<h2>Avec outil de comparaison d\'algorithmes</h2>';
        echo '</div>';
        echo '</td>';
        echo '<td id="authentification" >';
        echo 	'<form action="controller/authentification.php" method="post">';
        echo 		'<fieldset>';
        //l'utilisateur est connecté
        if(!empty($_SESSION['user'])){
       		echo 		'Bonjour '.$_SESSION['user']['surname_user'].' '.$_SESSION['user']['name_user'];
        	echo 		'<input type="submit" value="deconnexion" >';
        }
        //l'utilisateur n'est pas connecté
        else{
	        echo 		'<label>login</label>';
	        echo 		'<input name="login" type="text" size="10" />';
	        echo 		'<br />';
	        echo 		'<label>password</label>';
	        echo 		'<input name="password" type="text" size="10" />';
	        echo 		'<br/ >';
	        echo 		'<input type="submit" value="connexion" >';
    	}
        echo 		'</fieldset>';
        echo 	'</form>';
        echo '</td>';
        echo '<td>';
        echo '<img src="./view/American-Native3.gif" alt="logo" height="100" width="100" style = "float: left">';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
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

	public function writeProblems(){
		$nomProbleme = "problemeNK";
		$description = "blabla bla blalalblalblalbal lbla blbla blalblbla blablb bla";
		$tableau = new Tableau("problemes", "prob", 5);
		$ligne = new Ligne('<h5><a href="./algorithms.php?var1='.$nomProbleme.'">'.$nomProbleme.'</a></h5><p>'.$description.'</p>');
		$tableau->addLigne($ligne);
		for($i = 0; $i<12; $i++){
			$probleme = new Ligne('<h5><a>titre problème</a></h5><p>description</p>');
			$tableau->addLigne($probleme);
		}
		$tableau->generate();
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