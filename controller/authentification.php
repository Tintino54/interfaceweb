<?php
require_once("../view/Document.php");
require_once("Requetes.php~");
$document = new Document("view/style.css", "utf8");
$document->begin();
$document->beginSection("corpPage", "formdiv");
//démarrage ou reprise de la session
session_start();
//l'utilisateur n'est pas connecté, tentative d'authetification
if(empty($_SESSION['user'])){
	$id=$_POST['login'];
	$password=$_POST['password'];
	$requete="SELECT name_user,surname_user FROM Users WHERE password_user=? AND id_user=?";
	$res=executerRequetePreparee($requete,array("ss",&$password,&$id));
	//réussite de l'authentification
	if(!empty($res)){
		$_SESSION['user']=$res[0];
	}
	//échec de l'authentification
	else{
		$_SESSION['erreur']="échec de l'authentification";
	}
}
//déconnexion
else{
	unset($_SESSION);
	session_destroy();
}
header('Location: ../index.php');
$document->endSection();
$document->end();
?>