<?php
/* 
Compare les valeurs de deux valeurs de deux algorithmes
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

		if($tab1[$i]>$tab2[$i]){
			$compteur1++;
		}

		else if($tab1[$i]<$tab2[$i]){
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
		return ;
	}
}

function calculDominance($instance,$algo1,$algo2){
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
	$j=1;
	$tabResultat=array();
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
		$j++;
		if(comparaison($currentValuesAlgo1,$currentValuesAlgo2)==1){
			//do stuff
		}
		else if(comparaison($currentValuesAlgo1,$currentValuesAlgo2)==2){
			//do stuff
		}
		else{
			//do stuff
		}
	}
	echo $j;
}

calculDominance("nk_128_8_0","algo1","algo2");

?>