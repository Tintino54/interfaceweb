<?php

function calculMoyenne($tabMoy){
	$taille=count($tabMoy);
	$somme=0;
	for($i=0;$i<$taille;$i++){
		$somme+=strstr($tabMoy[$i],'0.');
	}
	return $somme/$taille;
}

function generationFichierScoreMoyen($instanceAlgo){
	//création du fichier de sotckage des moyennes si il n'existe pas déjà


	$total=0;
	$traces=scandir($instanceAlgo);
	$lignes=array();
    if(file_exists($instanceAlgo.'/'.'moyenne_algo_trace.txt')){
        return 0;
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
			$num=strstr($tabMoy[$i],' ',true);
			if(isset($lignes[$i][$num+1])){
				$termine=false;
				if($lignes[$i][$num+1]<=$j){
					$valueChanged=true;
					$tabMoy[$i]=($num+1).' '.strstr($lignes[$i][$num+1],'0.');
				}
			}
		}
		if($valueChanged){
			fputs($fichier,$j.' '.calculMoyenne($tabMoy)."\r\n");
		}
		$j++;
	}
	fclose($fichier);
	//echo $j;
}
?>