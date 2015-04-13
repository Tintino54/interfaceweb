<?php
//script fournissant le lien de téléchargement d'une instance
	$lignes=file($_GET['var1']);
	$somme=0;
	foreach ($lignes as $key => $value) {
		echo $value;
		echo '<br />';
	}
	echo $somme;

?>