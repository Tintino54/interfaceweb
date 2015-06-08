<?php
/*calcul la moyenne à partir d'un tableau de valeur*/
function calculMoyenne($valeurs){
	$taille=count($valeurs);
	$somme=0;
	foreach ($valeurs as $i => $value) {
		$somme+=$valeurs[$i];
	}
	return $somme/$taille;
}

/*retourne l'itération qui à la valeur minimale parmit les valeurs des lignes
 pointées par le tableau de fichiers traces */
function iterationMin(&$traces){
	$min=-1;
	foreach ($traces as $i => $trace) {
		$pos=ftell($trace);
		$ligne=fgets($trace);
		if(!empty($ligne)){
			if(strstr($ligne," ",true)<$min||$min==-1){
				$min=strstr($ligne," ",true);
			}
			fseek($trace,$pos);
		}
		else{
			unset($traces[$i]);
		}
	}
	return $min;
}

/*Génère un fichier de moyenne à partir d'un chemin correspond à l'emplacement 
des fichiers traces d'un algorithme pour un problème*/
function generationFichierScoreMoyen($instanceAlgo){
	//on vérifie que le fichier de moyenne n'existe pas déjà
	if(file_exists($instanceAlgo.'/'.'moyenne_algo_trace.txt')){
        return 0;
    }

    $fichier=fopen($instanceAlgo.'/'.'moyenne_algo_trace.txt','w');
   	fseek($fichier, 0);

	$fichiersExclus=array('.','..','moyenne_algo_trace.txt');
	$traces=array_diff(scandir($instanceAlgo),$fichiersExclus);

	//ouverture des fichiers traces
	foreach ($traces as $i => $trace) {
		$traces[$i]=fopen($instanceAlgo.'/'.$traces[$i],"r");
	}
	$min=0;
	//récupération des lignes 
	while($min!=-1){
		$iteration=$min;
		foreach ($traces as $i => $trace) {
			$pos=ftell($trace);
			$ligne=fgets($trace);
			if(strstr($ligne," ",true)<=$iteration){
				$valeurs[$i]=strstr($ligne," ");
			}
			else{
				fseek($trace,$pos);
			}
		}
		fputs($fichier,$iteration." ".calculMoyenne($valeurs)."\r\n");
		$min=iterationMin($traces);
	}
	fclose($fichier);
}
//$timestart=microtime(true);
//generationFichierScoreMoyen("../problemes/MAXSAT/traces/algo5_first_neutral/bw_large.d");
//$timeend=microtime(true);
//echo $time=$timeend-$timestart;
?>