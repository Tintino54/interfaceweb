<?php
require_once("view/Document.php");
require_once("view/Forms/Forms.php");
require_once("view/Forms/FormsFieldSet.php");
require_once("view/Forms/FormFieldText.php");
require_once("view/Forms/FormFieldPassword.php");
require_once("view/Forms/FormFieldSelect.php");
require_once("view/Forms/FormFieldSubmit.php");

$document = new Document("view/style.css", "utf8");
$document->addJavascript("view/javascript/jquery.js");
$document->addJavascript("view/javascript/highcharts.js");
$document->fh();
$document->begin();
$document->header();
$document->beginSection("corpPage", "formdiv");
    $problemes = array_diff(scandir('problemes'),array('.','..'));
	$tableau = new Tableau("problemes", "prob", 5);
	foreach ($problemes as $key => $probleme) {
		$description=file_get_contents("problemes/".$probleme."/description.txt");
		$texte='<h5><a href="./algorithms.php?pb='.$probleme.'">'.$probleme.'</a></h5>';
		$texte.='<p>'.substr($description, 0, 65).'...'.'</p>';
        $ligne = new Ligne($texte);
		$tableau->addLigne($ligne);
	}
	$tableau->generate();

//$document->writeProblems();
$document->end();
$document->endSection();
?>
