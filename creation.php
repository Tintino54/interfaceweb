<?php
require_once("controller/calculsStats.php");
$instance=$_GET['var1'];
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
	//$moyennes = glob($np."/traces/*/*/moyenne_algo_trace.txt");
	//for($i=0; $i< count($moyennes); $i++){
	//	echo $moyennes[$i]."<br>";
	//}
?>