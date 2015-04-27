<?php
require_once("view/Document.php");
$document = new Document("view/style.css", "utf8");
$document->addJavascript("view/javascript/jquery.js");
$document->addJavascript("view/javascript/highcharts.js");
$document->begin();
$document->header();
$document->beginSection("corpPage", "formdiv");
	$instance=$_GET['var1'];
	$algos=scandir('problemeNK/traces');
	echo '<div id="container" style="width:100%; height:400px;"></div>';
	$script="<script>
	$(function () { 
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'score algorithmes'
        },
        xAxis: {
           	text: 'iteration'
        },
        yAxis: {
            title: {
                text: 'Fruit eaten'
            }
        },series: [";
        //création des courbes pour chaque algo
     	for ($i=2; $i < count($algos); $i++) { 
     		$script.='{ name: '.'"'.$algos[$i].'", ';
            $path='problemeNK/traces/'.$algos[$i].'/'.$instance.'/moyenne_algo_trace';
            $fichier=fopen($path,"r");
     		$script.='data: [';
     		fseek($fichier, 0);
            //on récupère l'ensemble des points
     		while($ligne=fgets($fichier)){
                //ajout des coordonnées du point au graphe
                $script.='['.strstr($ligne,' ',true).', '.strstr($ligne,'0.').'],';
     		}
            $script.=' ]}, ';
		}
    	//$script.='{ name: '.'"'.$algos[$i].'", ';
     	$script.="]
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
echo $script;
$document->endSection();
$document->end();
?>