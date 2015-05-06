 <?php
require_once("view/Document.php");
require_once("creation.php");

$document = new Document("view/style.css", "utf8");
$document->addJavascript("view/javascript/jquery.js");
$document->addJavascript("view/javascript/highcharts.js");
$document->addJavascript("view/javascript/lines.js");
$document->begin();
$document->header();
$document->beginSection("corpPage", "formdiv");



echo '<div id="container" style="width:100%; height:400px;"></div>
		<canvas id="myCanvas" width="800" height="400">
			Your browser does not support the HTML5 canvas tag.
		</canvas> ';
 	$document->endSection();
	$document->end();
?>