<?php
require_once("calculsStats.php");
require_once("cds2.php");
$instance=$_GET['inst'];
$np = $_GET['pb'];
$algos=scandir('problemes/'.$np.'/traces');

	//création des courbes pour chaque algo
	for ($i=2; $i < count($algos); $i++) {
		$path='problemes'.$np.'/traces/'.$algos[$i].'/'.$instance.'/moyenne_algo_trace.txt';
		if(!file_exists($path)){
			$nf = 'problemes/'.$np.'/traces/'.$algos[$i].'/'.$instance;
			generationFichierScoreMoyen($nf);
		}
	}

?>