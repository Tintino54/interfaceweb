<?php

require_once("./view/Tableau/Tableau.php");
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

	public function chart(){
		echo '<div id="container" style="width:100%; height:400px;"></div>';
		echo "<script>
		alert($);
	$(function () { 
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Fruit Consumption'
        },
        xAxis: {
            categories: ['Apples', 'Bananas', 'Oranges']
        },
        yAxis: {
            title: {
                text: 'Fruit eaten'
            }
        },
        series: [{
            name: 'Jane',
            data: [1, 0, 4]
        }, {
            name: 'John',
            data: [5, 7, 3]
        }]
    	});
	});

	var chart1; // globally available
	$(function() {
      chart1 = new Highcharts.StockChart({
         chart: {
            renderTo: 'container'
         },
         rangeSelector: {
            selected: 1
         },
         series: [{
            name: 'USD to EUR',
            data: usdtoeur // predefined JavaScript array
         }]
      });
   });
	</script>";
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
