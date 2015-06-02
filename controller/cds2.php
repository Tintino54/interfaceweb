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
	$fichierTestBinomial=file("test_binomial/test_binomial_p_".$pvalue.".txt");
	$valeurTestBinomial=strstr($fichierTestBinomial[$taille]," ");
	$compteur1=0;
	$compteur2=0;
	for($i=3;$i<$taille;$i++){
		$valeurAlgo1=strstr($tab1[$i]," ");
		$valeurAlgo2=strstr($tab2[$i]," ");

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

/*on recherche l'itération la petite parmit l'ensemble des lignes des fichiers traces
pointées */
function iterationMinimale(&$algos){
	$minimum=-1;
	foreach ($algos as $i => $algo) {
		foreach ($algo as $j => $trace) {
			//on initialise le minimum à la première valeur trouvée
			if($minimum==-1){
				$pos=ftell($trace);
				$ligne=fgets($trace);
				if(!empty($ligne)){
					$minimum=strstr($ligne," ",true);
				}
				fseek($trace,$pos);
			}
			$pos=ftell($trace);
			$ligne=fgets($trace);
			if(!empty($ligne)){
				if(strstr($ligne," ",true)<=$minimum){
						$minimum=strstr($ligne," ",true);
				}
				fseek($trace, $pos);
			}
			else{
				unset($algos[$i][$j]);
			}
		}
	}
	return $minimum;
}


function regroupement(&$tabResultat,$algo1,$algo2,$iteration,$resultatComp,&$bool){
	$last1=count($tabResultat[$algo1]);
	$last2=count($tabResultat[$algo2]);
	if($resultatComp==1){
		//l'iteration précédente n'était pas en gras
		if($last1==0||(isset($tabResultat[$algo1][$last1-1]->fin)&&!$bool)){
			$tabResultat[$algo1][$last1]=new stdClass();
			$tabResultat[$algo1][$last1]->debut=$iteration;
		}
		if($last2!=0&&!isset($tabResultat[$algo2][$last2-1]->fin)){
			$tabResultat[$algo2][$last2-1]->fin=$iteration-1;
		}
	}

	else if($resultatComp==2){
		$bool=true;
		if($last2==0||isset($tabResultat[$algo2][$last2-1]->fin)){
			$tabResultat[$algo2][$last2]=new stdClass();
			$tabResultat[$algo2][$last2]->debut=$iteration;
		}
		if($last1!=0&&(!isset($tabResultat[$algo1][$last1-1]->fin)&&!$bool)){
				$tabResultat[$algo1][$last1-1]->fin=$iteration-1;
		}
	}
	else{
		if($last1==0||(isset($tabResultat[$algo1][$last1-1]->fin)&&!$bool)){
			$tabResultat[$algo1][$last1]=new stdClass();
			$tabResultat[$algo1][$last1]->debut=$iteration;
		}
		if($last2==0||isset($tabResultat[$algo2][$last2-1]->fin)){
			$tabResultat[$algo2][$last2]=new stdClass();
			$tabResultat[$algo2][$last2]->debut=$iteration;
		}
	}

}

/*pour un problème donné compare l'ensemble des algorithmes sur une une instance.
Renvoie un tableau sous format Json qui pour chaque algorithme contient un ensemble 
d'intervalles correspondant aux zones où ils ne sont pas dominés par un autre algorithme*/
function calculDominance($instance, $prob){
	$timestart=microtime(true);
	if(file_exists("problemes/".$prob."/dominance/".$instance)){
		return 0;
	}
	$fichierResultat=fopen("problemes/".$prob."/dominance/".$instance,"w");
	$path="problemes/".$prob.'/traces';
	$repertoires=array_diff(scandir($path), array('..', '.'));
	$fichiersExclus=array('.','..','moyenne_algo_trace.txt');
	foreach ($repertoires as $key => $rep) {
		$algos[$rep]=array_diff(scandir($path.'/'.$rep.'/'.$instance),$fichiersExclus);
	}
	//ouverture des fichiers traces
	foreach ($algos as $i => $algo) {
		foreach ($algo as $j =>$trace) {
			$algos[$i][$j]=fopen($path.'/'.$i.'/'.$instance.'/'.$trace, "r");
		}
	}

	foreach ($algos as $i => $algo) {
		$tabRes[$i]=array();
	}
	$min=0;
	$iteration=0;
	$termine=false;
	while($min!=-1){
		$iteration=$min;
		foreach ($algos as $i => $algo) {
			foreach ($algo as $j => $trace) {
				$pos=ftell($trace);
				$ligne=fgets($trace);
				if(strstr($ligne," ",true)==$iteration){
					$valeurs[$i][$j]=$ligne;
				}
				else{
					fseek($trace, $pos);
				}
			}
		}
		/*on compare l'ensemble des algos pour l'itération courant à celui
		qui a la meilleure moyenne*/
		$meilleurAlgo=algoMoyenneMax($prob,$instance,$iteration);
		//echo $meilleurAlgo."\r\n";
		$bool=false;
		foreach ($valeurs as $algo=>$test){
			if($algo!=$meilleurAlgo){
				$resultatComp=comparaison($valeurs[$meilleurAlgo],$valeurs[$algo]);
				regroupement($tabRes,$meilleurAlgo,$algo,$iteration,$resultatComp,$bool);
		
				//echo $algo." ".$resultatComp."\r\n";
			}
		}
		$min=iterationMinimale($algos);
	}
	/*on ferme les intervalles de chaque algorithmes*/
	foreach ($tabRes as $algo => $intervalle) {
		$last=count($tabRes[$algo]);
		if($last!=0&&!isset($tabRes[$algo][$last-1]->fin)){
			$tabRes[$algo][$last-1]->fin=$iteration;
		}
	}
	$timeend=microtime(true);
	//echo $time=$timeend-$timestart;
   	$tabRes['nbIt']=$iteration;
   /*	echo "appel";
   	echo "<br />";*/
  	
	fputs($fichierResultat,json_encode($tabRes));

}
//calculDominance("50_10_01_ta041", "Flow-shop");

?>