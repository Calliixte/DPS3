<?php
require_once("../config/connexion.php");
require_once("../modele/vote.php");
require_once("../modele/groupe.php");
Connexion::connect();

$id = $_GET["id"];
$idVotant= $_GET["idVotant"];
$idGroupe= $_GET["idGroupe"];
$groupe = Groupe::getGroupe($idGroupe);
$JSON = Vote::getJSON($id,$idVotant,$groupe);

echo $JSON;


?>
