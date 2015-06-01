<?php
require_once('../view/Document.php');
$document = new Document();
$document->begin();
$document->header();
	$document->beginSection("corpPage");
	session_start();
	unset($_SESSION);
	session_destroy();
	$document->endSection();
$document->end();
header('Location: ../index.php');
?>