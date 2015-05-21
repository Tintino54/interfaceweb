<?php
require_once("view/Document.php");
$document = new Document("view/style.css", "utf8");
$document->addJavascript("view/javascript/chargement.js");
$document->begin();
$document->header();
$document->beginSection("corpPage", "formdiv");
$var1 = $_GET['pb'];

echo '<h1 id="titreProbleme">'.$var1.'</h1>';

//liste des instances avec le lien des téléchargements
$instances='problemes/'.$var1.'/instances';
$tabDir=scandir($instances);
echo '<ul>';
for($i=2;$i<count($tabDir);$i++) {
	$page='grapheInstance.php?pb='.$var1.'&inst='.$tabDir[$i];
	echo '<li>';
		echo '<a href="'.$page.'">'.$tabDir[$i].'</a>';
		echo '<a href='.'"'.'downloadInstance.php?var1='.$instances.'/'.$tabDir[$i].'"'.'>';
		echo '<img src="view/ressources/downArrow.gif" height="20" width="20">'; 
		echo '</a>';
		echo '</li>';
}
echo '</ul>';
$document->endSection();
$document->end();
?>