 <?php
require_once("view/Document.php");
require_once("controller/creation.php");

$document = new Document("view/style.css", "utf8");
$document->addJavascript("view/javascript/jquery.js");
$document->addJavascript("view/javascript/highcharts.js");
$document->addJavascript("view/javascript/lines.js");
$document->begin();
$document->header();
$document->beginSection("corpPage", "formdiv");



echo '<div id="container" height:400px;"></div>
        <div id="lignes">
		<canvas id="myCanvas" width="500" height="0">
			Your browser does not support the HTML5 canvas tag.
		</canvas>
		</div>';
 	$document->endSection();
	$document->end();
?>