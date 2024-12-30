<?php
require_once("../config/connexion.php");
require_once("../config/rest.php");
require_once("../modele/vote.php");
require_once("../modele/groupe.php");
Connexion::connect();
 //classe purement pour du debug, à ne pas utiliser, GET fonctionne très bien sans 
$id = $_GET["id"];
$idVotant= $_GET["idVotant"];
$idGroupe= $_GET["idGroupe"];
$groupe = Groupe::getGroupe($idGroupe);
$JSON = Rest::getVote($id,$idVotant);

echo $JSON;


?>
