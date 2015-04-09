<?php
require_once("view/Document.php");
$document = new Document("view/style.css", "", "utf8");
$document->begin();
$document->header();
$document->beginSection("corpPage", "formdiv");
$path=$_GET['var1'];
$path.='/instancesNK';
$tabDir=scandir($path);

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