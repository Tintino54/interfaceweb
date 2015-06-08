<?php

/*algo qui compare deux algorithmes pour une iteration sur un ensemble de traces
renvoie 1 si l'algo domine
renvoie 2 si l'ago 2 domine
renvoie 0 sinon*/
function comparaison($tab1,$tab2){
	$taille=count($tab1);
	$pvalue=95;
	//récupération de la valeur pour le test binomial
	$fichierTestBinomial=file("test_binomial/test_binomial_p_".$pvalue.".txt");
	$valeurTestBinomial=$taille-strstr($fichierTestBinomial[$taille]," ");
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
	if($compteur1>$valeurTestBinomial){
		return 1;
	}
	else if($compteur2>$valeurTestBinomial){
		return 2;
	}
	else{
		return 0;
	}
}

/*retourne la plus grande itération parmi un ensemble de fichiers traces*/
function iterationMax(&$algos,$prob,$inst){
	$max=-1;
	foreach ($algos as $i => $algo) {
		foreach ($algo as $j =>$trace) {
			$tab=file('problemes/'.$prob.'/traces/'.$i.'/'.$inst.'/'.$trace);
			$fin=count($tab)-1;
			$ligne=$tab[$fin];
			if($max==-1||strstr($ligne, " ",true)>$max){
				$max=strstr($ligne, " ",true);
			}
		}
	}
	return $max;
}

/*retourne la valeur d'incrémentation de l'indice de boucle pour limiter
le nombre d'itérations*/
function valeurIncrementation($iterationMax){
	return floor($iterationMax/5000)+1;
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

/*regroupe pour chaque algos les intervalles en gras correspondant aux zones de dominance */ 
function regroupement(&$tabResultat,$algo1,$algo2,$iter,$lastIter,$resComp,&$bool){
	$last1=count($tabResultat[$algo1]);
	$last2=count($tabResultat[$algo2]);
	if($resComp==1){
		//l'iteration précédente n'était pas en gras
		if($last1==0||(isset($tabResultat[$algo1][$last1-1]->fin)&&!$bool)){
			$tabResultat[$algo1][$last1]=new stdClass();
			$tabResultat[$algo1][$last1]->debut=$iter;
		}
		if($last2!=0&&!isset($tabResultat[$algo2][$last2-1]->fin)){
			$tabResultat[$algo2][$last2-1]->fin=$lastIter;
		}
	}

	else if($resComp==2){
		$bool=true;
		if($last2==0||isset($tabResultat[$algo2][$last2-1]->fin)){
			$tabResultat[$algo2][$last2]=new stdClass();
			$tabResultat[$algo2][$last2]->debut=$iter;
		}
		if($last1!=0&&(!isset($tabResultat[$algo1][$last1-1]->fin)&&!$bool)){
				$tabResultat[$algo1][$last1-1]->fin=$lastIter;
		}
	}
	else{
		if($last1==0||(isset($tabResultat[$algo1][$last1-1]->fin)&&!$bool)){
			$tabResultat[$algo1][$last1]=new stdClass();
			$tabResultat[$algo1][$last1]->debut=$iter;
		}
		if($last2==0||isset($tabResultat[$algo2][$last2-1]->fin)){
			$tabResultat[$algo2][$last2]=new stdClass();
			$tabResultat[$algo2][$last2]->debut=$iter;
		}
	}
}

/*pour un problème donné compare l'ensemble des algorithmes sur une une instance.
Renvoie un tableau sous format Json qui pour chaque algorithme contient un ensemble 
d'intervalles correspondant aux zones où ils ne sont pas dominés par un autre algorithme*/
function calculDominance($instance, $prob){
	if(file_exists("problemes/".$prob.'/dominance/'.$instance)){
		return 0;
	}
	$path="problemes/".$prob.'/traces';
	$repertoires=array_diff(scandir($path), array('..', '.'));
	$fichiersExclus=array('.','..','moyenne_algo_trace.txt');
	foreach ($repertoires as $key => $rep) {
		$algos[$rep]=array_diff(scandir($path.'/'.$rep.'/'.$instance),$fichiersExclus);
	}
	$max=iterationMax($algos,$prob,$instance);
	$incr=valeurIncrementation($max);
		
	foreach ($algos as $i => $algo) {
		foreach ($algo as $j =>$trace) {
			$algos[$i][$j]=fopen($path.'/'.$i.'/'.$instance.'/'.$trace, "r");
		}
	}
	foreach ($algos as $i => $algo) {
			$tabRes[$i]=array();
	}
	$iteration=0;
	$lastIter=0;
	while($iteration<=$max){
		//echo $iteration."\r\n";
		$valueChanged=false;
		foreach ($algos as $i => $algo) {
			foreach ($algo as $j => $trace) {
				$pos=ftell($trace);
				$ligne=fgets($trace);
				while(!empty($ligne)&&strstr($ligne," ",true)<=$iteration){
					$valueChanged=true;
					$valeurs[$i][$j]=$ligne;
					$pos=ftell($trace);
					$ligne=fgets($trace);
				}
				if(empty($ligne)){
					fclose($algos[$i][$j]);
					unset($algos[$i][$j]);
				}
				else{
					fseek($trace, $pos);
				}
			}
		}
	/*on compare l'ensemble des algos pour l'itération courant à celui
	qui a la meilleure moyenne*/
	if($valueChanged){
		$meilleurAlgo=algoMoyenneMax($prob,$instance,$iteration);
		$bool=false;
		foreach ($valeurs as $algo=>$test){
			if($algo!=$meilleurAlgo){
				$resComp=comparaison($valeurs[$meilleurAlgo],$valeurs[$algo]);
				regroupement($tabRes,$meilleurAlgo,$algo,$iteration,$lastIter,$resComp,$bool);
			}
			$lastIter=$iteration;
		}
		//$lastIter=$iteration;
	}
	$iteration=$iteration+$incr;
	}
	/*on ferme les intervalles de chaque algorithmes*/
	foreach ($tabRes as $algo => $intervalle) {
		$last=count($tabRes[$algo]);
		if($last!=0&&!isset($tabRes[$algo][$last-1]->fin)){
			$tabRes[$algo][$last-1]->fin=$iteration;
		}
	}
	$tabRes['nbIt']=$iteration;
	$fichierResultat=fopen("problemes/".$prob."/dominance/".$instance,"w");
	fputs($fichierResultat,json_encode($tabRes));
	fclose($fichierResultat);
}

?>