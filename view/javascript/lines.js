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
		text: 'Fruit eaten'
		}
		},series: []
		});
	});
	compteur = 1;
	var gestionDonnees = function(data){
		var chart = $('#container').highcharts();
		var nom = "algo"+compteur;
		var tableau = data.split('\n');
		for(var i = 0; i<tableau.length-1; i++){
			tableau[i] = tableau[i].split(' ');
			for(var j = 0; j<tableau[i].length; j++){
				tableau[i][j] = parseFloat(tableau[i][j]);
			}
		}
		chart.addSeries({
            name: nom,
            data: tableau
        });
        compteur++;
    }
    $.get("./../problemeNK/traces/algo1/nk_128_2_0/moyenne_algo_trace.txt", gestionDonnees);

    

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

