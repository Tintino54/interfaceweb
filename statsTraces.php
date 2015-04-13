<?php
require_once("view/Document.php");
require_once("controller/calculsStats.php");
$document = new Document("view/style.css", "", "utf8");
$document->begin();
$document->header();
$document->beginSection("corpPage", "formdiv");
$path = $_GET['var1'];
$instance = $_GET['var2'];
//on récupère la liste des algos
$algorithmes=scandir($path);

echo '<ul>';
for($i=2;$i<count($algorithmes);$i++) {
	echo '<li>';
		echo $algorithmes[$i];
		echo calculScoreMoyen($path.'/'.$algorithmes[$i].'/'.$instance);
	echo '</li>';
}
echo '</ul>';



$document->endSection();
$document->end();
?>