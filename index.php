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

$document->writeProblems();
$document->chart();
$document->end();
$document->endSection();
?>
