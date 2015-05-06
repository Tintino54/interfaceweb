$(document).ready(function () {
 



//valeur de base de la largeur de la ligne
var baseLW = 2;
//valeur de la largeur de la ligne en gras
var increasedLW = 5;
//valeur de la marge à gauche
var marginLeft = 10;
//longueur des lignes
var lenghtLine = 600;
//espacement en hauteur des lignes
var marginTop = 17;

var colorTables = new Array("red","blue","yellow","green","orange","purple");

var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");


/*function MyLine () {
    this.portions = new Array();
    this.setPortion = setLinePortion;
}

function setLinePortion(){

}*/

for(var i=0; i<5 ; i++){
	//trace ligne de base
	ctx.beginPath();
	//récupérer la couleur depuis l'autre javascript
	ctx.strokeStyle = colorTables[i];
	ctx.moveTo(marginLeft, marginTop*(i+1));
	ctx.lineTo(lenghtLine, marginTop*(i+1));
	ctx.lineWidth = baseLW;
	ctx.closePath();
	ctx.stroke();


	//trace le gras

	//à faire en boucle
	//à calculer
	engraisse(i, 15, 60);
	
}

	$(function () {
		$('#container').highcharts({
		chart: {
		type: 'line'
		},
		title: {
		text: 'scores algorithmes'
		},
		xAxis: {
		text: 'iteration'
		},
		yAxis: {
		title: {
		text: 'Scores'
		}
		},series: []
		});
	});

	var nomAlgo = "";

	var gestionDonnees = function(data){
		var chart = $('#container').highcharts();
		var tableau = data.split('\n');
		alert(tableau[tableau.length-2]);
		for(var i = 0; i<tableau.length-1; i++){
			tableau[i] = tableau[i].split(' ');
			for(var j = 0; j<tableau[i].length; j++){
				tableau[i][j] = parseFloat(tableau[i][j]);
			}
		}
		chart.addSeries({
			name: nomAlgo,
            data: tableau
        });
    }

    //récupération des paramètres
    var param = window.location.href;
    param = (window.location.href).split('?');
    param = param[1];
    var link = "./generation.php?"+param;
    $.get(link, function(donnee){
    	alert(donnee.nomInstance);
    	for(var i =0; i<donnee['nomAlgo'].length; i++){
    		nomAlgo = donnee['nomAlgo'][i];
    		$.get("./problemeNK/traces/"+donnee['nomAlgo'][i]+"/"+donnee.nomInstance+"/moyenne_algo_trace.txt", gestionDonnees);
    	}
    } , "json");

    

	//met en gras d'un endroit à un autre
	function engraisse(id, start, end){
		ctx.strokeStyle = colorTables[id];
		ctx.beginPath();
		ctx.moveTo(start, marginTop*(id+1));
		ctx.lineTo(end, marginTop*(id+1));
		ctx.lineWidth = increasedLW;
		ctx.closePath();
		ctx.stroke();
	}

});

