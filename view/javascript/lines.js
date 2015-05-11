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

	//définition du graphique
	$(function () {
		$('#container').highcharts({
			chart: {
				type: 'line',
				zoomType: 'xy'
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
				},
			},series: []
		});
	});

	//tableau de noms des algorithmes pour conserver les noms
	var nomAlgo = new Array();
	//compteur
	var a = 0;
	//tableau pour conserver chaque dernière valeur des courbes, on s'en sert pour comparer et prolonger les courbes
	var max = new Array();

	//fonction du traitement des données pour générer graphiquement les courbes
	var gestionDonnees = function(data){
		//récupération du graphique
		var chart = $('#container').highcharts();
		//data correspond à une grande chaine de caractères, chaque ligne représente une abscisse et une ordonnée
		var tableau = data.split('\n');
		// à ce stade on a tableau[x] avec x un entier qui représente une string du style : "15, 0.78"
		//on va séparer les éléments du tableau pour avoir un tableau à deux dimensions
		for(var i = 0; i<tableau.length-1; i++){
			//on sépare chaque chaine au niveau de la virgule
			tableau[i] = tableau[i].split(' ');

			//tous les résultats étant des chaines il faut les parser en float
			for(var j = 0; j<tableau[i].length; j++){
				tableau[i][j] = parseFloat(tableau[i][j]);
			}
		}

		tableau[tableau.length-1] = tableau[tableau.length-2];
		//attribution du maximum
		max[max.length]=tableau[tableau.length-1][0];
		//ajoute la courbe
		chart.addSeries({
			name: nomAlgo[a],
            data: tableau
        });
        a++;
    }

    var prolongationCourbes = function(){
    	//récupère le container
    	var chart = $('#container').highcharts();
    	//boucle pour comparer toutes les courbes et rallonger la plus courte à chaque fois
    	for(var i = 0; i<max.length-1; i++){
    		//compare les maximum
    		if(max[i+1] > max[i]){
    			var taille = chart.series[i].data.length;
    			//ajoute un point à la courbe avec pour abscisse le maximum et comme ordonnée l'ordonnée du dernier point de l'autre courbe
    			chart.series[i].addPoint([max[i+1], chart.series[i].data[taille-1].y]);
    		}
    	}
    }

    //fonction qui prend chaque algo pour lire les données dans le fichier pour générer les courbes
    var gestionInstance = function(donnee){
    	//pour chaqe algo
    	for(var i =0; i<donnee['nomAlgo'].length; i++){
    		nomAlgo[nomAlgo.length] = donnee['nomAlgo'][i];
    		 jQuery.ajax({
        		 url:   "./problemeNK/traces/"+donnee['nomAlgo'][i]+"/"+donnee.nomInstance+"/moyenne_algo_trace.txt",
         		success: gestionDonnees,
         		//permet que les actions se fassent à tour de rôle et non simultanément
         		async: false
    		});      		  
    	}
    	//prolongation des courbes
    	prolongationCourbes();
    }

    //récupération des paramètres
    var param = window.location.href;
    param = (window.location.href).split('?');
    param = param[1];
    var link = "./generation.php?"+param;
    jQuery.ajax({
         url:    link,
         success: gestionInstance,
         dataType: "json",
         async:   true
    });

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