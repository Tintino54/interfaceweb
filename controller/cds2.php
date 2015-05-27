<?php
require_once("calculsStats.php");

/*algo qui compare deux algorithmes pour une iteration sur un ensemble de traces
renvoie 1 si l'algo domine
renvoie 2 si l'ago 2 domine
renvoie 0 sinon*/
function comparaison($tab1,$tab2){
	$taille=count($tab1);
	$pvalue=95;
	//récupération de la valeur pour le test binomial
	$fichierTestBinomial=file("../test_binomial/test_binomial_p_".$pvalue.".txt");
	$valeurTestBinomial=strstr($fichierTestBinomial[$taille]," ");
	$compteur1=0;
	$compteur2=0;
	for($i=3;$i<$taille;$i++){
		$valeurAlgo1=strstr($tab1[$i],"0.");
		$valeurAlgo2=strstr($tab2[$i],"0.");

		if($valeurAlgo1>$valeurAlgo2){
			$compteur1++;
		}

		else if($valeurAlgo2<$valeurAlgo1){
			$compteur2++;
		}
	}
	if($compteur1<$valeurTestBinomial){
		return 2;
	}
	else if($compteur2<$valeurTestBinomial){
		return 1;
	}
	else{
		return 0;
	}
}


function regroupement($tabResultat,$algo1,$algo2,$iteration,$resultatComp){
	//l'algo 1 domine
	if($resultatComp==1||$resultatComp==0){
		$last=count($tabResultat[$algo1]);
		if(!isset($tabResultat[$algo1][$last])||$tabResultat[$algo1][$last]->fin<$iteration-1){
			//créer un nouvel intervalle
			$last++;
			$tabResultat[$algo1][$last]->debut=$iteration;
			$tabResultat[$algo1][$last]->fin=$iteration;
		}
		else{
			//incrémenter fin
			$tabResultat[$algo1][$last]->fin++;
		}
	}
	//l'algo 2 domine
	if($resultatComp==2||$resultatComp==0){
		$last=count($tabResultat[$algo2]);
		if(!isset($tabResultat[$algo2][$last])||$tabResultat[$algo2][$last]->fin<$iteration-1){
			//créer un nouvel intervalle
			$last++;
			$tabResultat[$algo2][$last]->debut=$iteration;
			$tabResultat[$algo2][$last]->fin=$iteration;
		}
		else{
			//incrémenter fin
			$tabResultat[$algo2][$last]->fin++;
		}

	}

}

/*pour un problème donné compare l'ensemble des algorithmes sur une une instance.
Renvoie un tableau qui pour chaque algorithme contient un ensemble d'intervalles
correspondant aux zones où ils ne sont pas dominés*/
function calculDominance($instance, $prob){
	$timestart=microtime(true);
	$path="../problemes/".$prob.'/traces';
	$repertoires=array_diff(scandir($path), array('..', '.'));
	$fichiersExclus=array('.','..','moyenne_algo_trace.txt');
	foreach ($repertoires as $key => $rep) {
		$algos[$rep]=array_diff(scandir($path.'/'.$rep.'/'.$instance),$fichiersExclus);
	}
	//ouverture des fichiers traces
	foreach ($algos as $i => $algo) {
		foreach ($algo as $j =>$trace) {
			//echo $trace."\r\n";
			$algos[$i][$j]=fopen($path.'/'.$i.'/'.$instance.'/'.$trace, "r");
		}
	}

	$iteration=0;
	$termine=false;
	foreach ($algos as $i => $algo) {
		$tabResultat[$i]=array();
	}
	while(!$termine){
		$termine=true;
		foreach ($algos as $i => $algo) {
			foreach ($algo as $j => $trace) {
				$pos=ftell($trace);
				$ligne=fgets($trace);
				if(!empty($ligne)){
					$termine=false;
					if(strstr($ligne," ",true)<=$iteration){
						$valeurs[$i][$j]=$ligne;
					}
					else{
						fseek($trace, $pos);
					}
				}
				else{
					unset($algos[$i][$j]);
				}
			}
		}
		$meilleurAlgo=algoMoyenneMax($prob,$instance,$iteration);
		foreach ($valeurs as $algo=>$test){
			if($algo!=$meilleurAlgo){
				$resultatComp=comparaison($valeurs[$meilleurAlgo],$valeurs[$algo]);
				echo $iteration.' '.$resultatComp."\r\n";
				regroupement(&$tabResultat,$meilleurAlgo,$algo,$iteration,$resultatComp);
			}
		}
		$iteration++;
	}
	$timeend=microtime(true);
	echo $time=$timeend-$timestart;
	print_r($tabResultat);
	/*print_r($valeurs);
	echo comparaison($valeurs['algo1'],$valeurs['algo2']);*/

}
calculDominance("nk_256_2_0","problemeNK");
?>