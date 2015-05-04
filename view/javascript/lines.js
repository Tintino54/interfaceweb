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

	var gestionDonne = function(data){
    	
    }

    $.get("doc.txt", gestionDonne);

    

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




