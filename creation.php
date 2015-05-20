<?php
require_once("controller/calculsStats.php");
require_once("cds.php");
$instance=$_GET['inst'];
$np = "problemeNK";
$algos=scandir($np.'/traces');

	//création des courbes pour chaque algo
	for ($i=2; $i < count($algos); $i++) {
		$path=$np.'/traces/'.$algos[$i].'/'.$instance.'/moyenne_algo_trace.txt';
		if(!file_exists($path)){
			$nf = $np.'/traces/'.$algos[$i].'/'.$instance;
			generationFichierScoreMoyen($nf);
		}
	}

?>