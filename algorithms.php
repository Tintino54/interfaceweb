<?php
require_once("view/Document.php");
$document = new Document("view/style.css", "", "utf8");
$document->begin();
$document->header();
$document->beginSection("corpPage", "formdiv");
$path=$_GET['var1'];
$path.='/instancesNK';
//print($path.'/'.'instanceNK');
$tabDir=scandir($path);
//print_r($tabDir);
echo '<ul>';
for($i=2;$i<count($tabDir);$i++) {
	echo '<li>';
		echo '<a href='.'"'.'downloadInstanceNK.php?var1='.$path.'/'.$tabDir[$i].'"'.'>'.$tabDir[$i].'</a>';
	echo '</li>';
}
echo '</ul>';

$document->endSection();
$document->end();
?>