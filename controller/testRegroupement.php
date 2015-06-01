<?php

function regroupement(&$tabResultat,$algo1,$algo2,$iteration,$resultatComp){
	$last1=count($tabResultat[$algo1]);
	$last2=count($tabResultat[$algo2]);
	echo $last1."\r\n";
	echo $last2."\r\n";
	if($resultatComp==1){
		echo "algo 1 domine\r\n";
		//l'iteration précédente n'était pas en gras
		if($last1==0||(isset($tabResultat[$algo1][$last1-1]->fin)&&$tabResultat[$algo1][$last1-1]->fin!=$iteration-1)){
			echo "création d'un nouvel intervalle pour l'algo1\r\n";
			$tabResultat[$algo1][$last1]=new stdClass();
			$tabResultat[$algo1][$last1]->debut=$iteration;
		}
		if($last2!=0&&!isset($tabResultat[$algo2][$last2-1]->fin)){
			echo "on ferme l'intervalle de l'algo 2\r\n";
			$tabResultat[$algo2][$last2-1]->fin=$iteration-1;
		}	
	}

	else if($resultatComp==2){
		echo "algo 2 domine\r\n";
		if($last2==0||isset($tabResultat[$algo2][$last2-1]->fin)){
			echo "création d'un nouvel intervalle pour l'algo2\r\n";
			$tabResultat[$algo2][$last2]=new stdClass();
			$tabResultat[$algo2][$last2]->debut=$iteration;
		}
		if($last1!=0&&!isset($tabResultat[$algo1][$last1-1]->fin)){
			echo "on ferme l'intervalle de l'algo 1\r\n";
			$tabResultat[$algo1][$last1-1]->fin=$iteration-1;
		}
	}

	else{
		echo "aucun des deux dominent\r\n";
		if($last1==0||isset($tabResultat[$algo1][$last1-1]->fin)){
			$tabResultat[$algo1][$last1]=new stdClass();
			$tabResultat[$algo1][$last1]->debut=$iteration;
		}
		if($last2==0||isset($tabResultat[$algo2][$last2-1]->fin)){
			$tabResultat[$algo2][$last2]=new stdClass();
			$tabResultat[$algo2][$last2]->debut=$iteration;
		}
	}

}

$tabResultat["algo1"]=array();
$tabResultat["algo2"]=array();

$res=array('0','0','1','1','1','2','2','2','1','1');
for($i=0;$i<count($res);$i++){
	regroupement($tabResultat,'algo1','algo2',$i,$res[$i]);
}
print_r($tabResultat);



?>