<?php
require_once("controller/calculsStats.php");
require_once("controller/calculDominance.php");
$instance="bmc-ibm-1";
$np='MAXSAT';
$algos=scandir('problemes/'.$np.'/traces');

	//création des courbes pour chaque algo
	try{
	for ($i=2; $i < count($algos); $i++) {
		$path='problemes'.$np.'/traces/'.$algos[$i].'/'.$instance.'/moyenne_algo_trace.txt';
		if(!file_exists($path)){
			$nf = 'problemes/'.$np.'/traces/'.$algos[$i].'/'.$instance;
			generationFichierScoreMoyen($nf);
		}
	}
	calculDominance($instance,$np);
	}	catch(Exception $e){}

?>