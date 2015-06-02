<?php

function calculMoyenne($valeurs){
	$taille=count($valeurs);
	$somme=0;
	foreach ($valeurs as $i => $value) {
		$somme+=$valeurs[$i];
	}
	return $somme/$taille;
}

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

/*fonction qui détermine l'algorithme ayant la meilleure moyenne de score
pour une iteration */
function RechercheMoyIteration($probleme,$instance,$algo,$iteration){
	$path='problemes/'.$probleme.'/traces/'.$algo.'/'.$instance.'/moyenne_algo_trace.txt';
	$moyennes=file($path);
	//print_r($moyennes);
	$debut=0;
	$fin=count($moyennes);
	$i=0;
	while($debut<$fin){
		$milieu=floor(($debut+$fin)/2);
		$milieu."\r\n";
		$line=$moyennes[$milieu];
		if($iteration==strstr($line," ",true)){
			return strstr($line," ");
		}
		else if($iteration<strstr($line," ",true)){
			$fin=$milieu;
		}
		else{
			$debut=$milieu+1;
		}
		$i++;
		//echo "debut ".$debut." fin ".$fin."\r\n";
	}
	return strstr($line," ");
}

function algoMoyenneMax($probleme,$instance,$iteration){
	$fichierExclus=array('.','..');
	$max=0;
	$algos=array_diff(scandir('problemes/'.$probleme.'/traces'),$fichierExclus);
	foreach ($algos as $key => $algo) {
		$value=RechercheMoyIteration($probleme,$instance,$algo,$iteration);
		if($value>$max){
			$max=$value;
			$algoMax=$algo;
		}
	}
	return $algoMax;
}

function generationFichierScoreMoyen($instanceAlgo){
	//création du fichier de sotckage des moyennes si il n'existe pas déjà
	if(file_exists($instanceAlgo.'/'.'moyenne_algo_trace.txt')){
        return 0;
    }

    $fichier=fopen($instanceAlgo.'/'.'moyenne_algo_trace.txt','w');
   	fseek($fichier, 0);

	$fichiersExclus=array('.','..','moyenne_algo_trace.txt');
	$traces=array_diff(scandir($instanceAlgo),$fichiersExclus);

	//ouverture des traces stockées dans le tableau lignes
	foreach ($traces as $i => $trace) {
		$traces[$i]=fopen($instanceAlgo.'/'.$traces[$i],"r");
	}
	$min=0;
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
/*$timestart=microtime(true);
generationFichierScoreMoyen("../problemes/Flow-shop/traces/algo5_first_neutral/50_10_01_ta041");
$timeend=microtime(true);
echo $time=$timeend-$timestart;*/
?>