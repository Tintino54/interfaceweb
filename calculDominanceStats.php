<?php
/* 
Compare les valeurs de deux algorithmes
si l'algo 1 domine l'algo 2 renvoie 1
si l'algo 2 domine l'ago 2 renvoie 2
sinon renvoie 0
*/
function comparaison($tab1,$tab2){
	$test_binomial=52;
	$taille=count($tab1);
	$compteur1=0;
	$compteur2=0;
	for($i=0;$i<$taille;$i++){
		$valeurAlgo1=strstr($tab1[$i],"0.");
		$valeurAlgo2=strstr($tab2[$i],"0.");

		if($valeurAlgo1>$valeurAlgo2){
			$compteur1++;
		}

		else if($valeurAlgo2<$valeurAlgo1){
			$compteur2++;
		}
	}
	if($compteur1>$test_binomial){
		return 1;
	}
	else if($compteur2>$test_binomial){
		return 2;
	}
	else{
		return 0;
	}
}

function calculDominance($instance,$algo1,$algo2){
	$tabResultat["algo1"]=array();
	$tabResultat["algo2"]=array();

	$indiceAlgo1=0;
	$indiceAlgo2=0;

	//ouverture des fichiers de traces des algorithmes et stockage dans une 
	$tracesAlgo1=scandir('problemeNK/traces/'.$algo1.'/'.$instance);
	$tracesAlgo2=scandir('problemeNK/traces/'.$algo2.'/'.$instance);
	for($i=2;$i<count($tracesAlgo1);$i++){
		$linesAlgo1[$i-2]=file('problemeNK/traces/'.$algo1.'/'.$instance.'/'.$tracesAlgo1[$i]);
		$linesAlgo2[$i-2]=file('problemeNK/traces/'.$algo2.'/'.$instance.'/'.$tracesAlgo2[$i]);
	}
 
	$taille=count($linesAlgo1);
	for($i=0;$i<$taille;$i++){
		$currentValuesAlgo1[$i]=$linesAlgo1[$i][0];
		$currentValuesAlgo2[$i]=$linesAlgo2[$i][0];
	}

	$termine=false;
	$valeurPrecedente=-1;
	$j=0;
	while(!$termine){
		$termine=true;
		$valueChanged=false;
		for($i=0;$i<$taille;$i++){
			$num=strstr($currentValuesAlgo1[$i],' ',true);

			if(isset($linesAlgo1[$i][$num+1])){
				$termine=false;
				if($linesAlgo1[$i][$num+1]<=$j){
					$valueChanged=true;
					$currentValuesAlgo1[$i]=($num+1).' '.strstr($linesAlgo1[$i][$num+1],'0.');
				}
			}

			$num=strstr($currentValuesAlgo2[$i],' ',true);
			if(isset($linesAlgo2[$i][$num+1])){
				$termine=false;
				if($linesAlgo2[$i][$num+1]<=$j){
					$valueChanged=true;
					$currentValuesAlgo2[$i]=($num+1).' '.strstr($linesAlgo2[$i][$num+1],'0.');
				}
			}
		}
	/*	echo $j." ".comparaison($currentValuesAlgo1,$currentValuesAlgo2)."\r\n";
		echo "<br />";*/

		if(comparaison($currentValuesAlgo1,$currentValuesAlgo2)==1){
			if($valeurPrecedente==1||$valeurPrecedente==0){
				$tabResultat["algo1"][$indiceAlgo1]->fin++;
			}
			else{
				$indiceAlgo1++;
				$tabResultat["algo1"][$indiceAlgo1]->debut=$j;
				$tabResultat["algo1"][$indiceAlgo1]->fin=$j;
			}
			$valeurPrecedente=1;
		}

		else if(comparaison($currentValuesAlgo1,$currentValuesAlgo2)==2){
			if($valeurPrecedente==2||$valeurPrecedente==0){
				$tabResultat["algo2"][$indiceAlgo2]->fin++;
			}
			else{
				$indiceAlgo2++;
				$tabResultat["algo2"][$indiceAlgo2]->debut=$j;
				$tabResultat["algo2"][$indiceAlgo2]->debut=$j;
			}
			$valeurPrecedente=2;
		}

		else{
			if($valeurPrecedente==-1){
				$tabResultat["algo2"][$indiceAlgo2]->debut=$j;
				$tabResultat["algo2"][$indiceAlgo2]->fin=$j;
				$tabResultat["algo1"][$indiceAlgo1]->debut=$j;
				$tabResultat["algo1"][$indiceAlgo1]->fin=$j;

			}
			else if($valeurPrecedente==1){
				$tabResultat["algo1"][$indiceAlgo1]->fin++;	
				$indiceAlgo2++;
				$tabResultat["algo2"][$indiceAlgo2]->debut=$j;
				$tabResultat["algo2"][$indiceAlgo2]->fin=$j;
			}
			else if($valeurPrecedente==2){
				$tabResultat["algo2"][$indiceAlgo2]->fin++;
				$indiceAlgo1++;
				$tabResultat["algo1"][$indiceAlgo1]->debut=$j;
				$tabResultat["algo1"][$indiceAlgo1]->fin=$j;
			}
			else{
				$tabResultat["algo2"][$indiceAlgo2]->fin++;
				$tabResultat["algo1"][$indiceAlgo1]->fin++;
			}
			$valeurPrecedente=0;
		}
		$j++;
	}
	print_r($tabResultat);
}

calculDominance("nk_128_8_0","algo1","algo2");

?>