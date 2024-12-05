<?php
require_once("../config/connexion.php");
require_once("../modele/utilisateur.php");

Connexion::connect();
$idU = (int)$_GET["id"];
$UserJSON = Utilisateur::getJSON($idU);
 //classe purement pour du debug, à ne pas utiliser, GET fonctionne très bien sans 

echo $UserJSON;


?>
