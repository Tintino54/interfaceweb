<?php
require_once("view/Document.php");
$document = new Document("view/style.css", "", "utf8");
$document->begin();
$document->header();
$document->beginSection("corpPage", "formdiv");
$var = $_GET['var1'];
$path=$var;
$path.='/instancesNK';
$tabDir=scandir($path);

echo '<h1 id="titreProbleme">'.$var.'</h1>';

//liste des instances avec le lien des téléchargements 
echo '<ul>';
for($i=2;$i<count($tabDir);$i++) {
	echo '<li>';
		echo '<a href='.'"'.'downloadInstanceNK.php?var1='.$path.'/'.$tabDir[$i].'"'.'>'.$tabDir[$i].'</a>';
		echo '<a href='.'"'.'downloadInstanceNK.php?var1='.$path.'/'.$tabDir[$i].'"'.'>';
		echo '<img src="view/ressources/download.gif" height="20" width="20">'; 
		echo '</a>';
		echo '</li>';
}
echo '</ul>';

//liste des algos
echo '<ul>';

echo '</ul>';

$document->endSection();
$document->end();
?>