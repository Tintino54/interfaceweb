<?php

function calculMoyenne($tabMoy){
	$taille=count($tabMoy);
	$somme=0;
	for($i=0;$i<$taille;$i++){
		$somme+=strstr($tabMoy[$i],' ');
	}
	return $somme/$taille;
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


	$total=0;
	$traces=scandir($instanceAlgo);
	$lignes=array();
   	if(file_exists($instanceAlgo.'/'.'moyenne_algo_trace.txt')){
        return 0;;
    }

	//ouverture des traces stockées dans le tableau lignes
	for($i=2;$i<count($traces);$i++){
		$lignes[$i-2]=file($instanceAlgo.'/'.$traces[$i]);
	}

	//initialisation du tableau aux valeurs initiales
	$taille=count($lignes);
	$tabMoy=array();

   	$fichier=fopen($instanceAlgo.'/'.'moyenne_algo_trace.txt','w');
   	fseek($fichier, 0);

	for($i=0;$i<$taille;$i++){
		$tabMoy[$i]=$lignes[$i][0];
	}
	$termine=false;
	$j=1;
	while(!$termine){
		$termine=true;
		$valueChanged=false;
		for($i=0;$i<$taille;$i++){
			$num=strstr(trim($tabMoy[$i]),' ',true);
			if(isset($lignes[$i][$num+1])){
				$termine=false;
				if(strstr($lignes[$i][$num+1],' ',true)<=$j){
					$valueChanged=true;
					$tabMoy[$i]=($num+1).' '.trim(strstr($lignes[$i][$num+1],' '));
				}
			}
		}
		if($valueChanged){
			fputs($fichier,$j.' '.calculMoyenne($tabMoy)."\r\n");
		}
		$j++;
	}
	//print_r($tabMoy);
	fclose($fichier);
	//echo $j;
}
/*$timestart=microtime(true);
echo algoMoyenneMax("problemeNK","nk_128_8_0",623);
	$timeend=microtime(true);
	echo $time=$timeend-$timestart;*/
//generationFichierScoreMoyen("../problemes/Flow-shop/traces/algo5_first_neutral/50_10_01_ta041");
//generationFichierScoreMoyen("../problemes/problemeNK/traces/algo1/nk_128_2_0");
?>