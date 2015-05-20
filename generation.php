<?php
require_once("controller/calculsStats.php");
$instance=$_GET['inst'];
$np = $_GET['pb'];
$algos=scandir($np.'/traces');

		$algorithmes = array();
		for ($i=2; $i < count($algos); $i++) {
			$algorithmes[$i-2] = $algos[$i];
		}
		$donnees = array('nomAlgo' => $algorithmes,'nomProbleme' => $np, 'nomInstance' => $instance);
		echo json_encode($donnees);
?>