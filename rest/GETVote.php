<?php
require_once("../config/connexion.php");
require_once("../modele/vote.php");

Connexion::connect();

$idU = $_GET["id"];
$idVotant= $_GET["idVotant"];
$JSON = Vote::getJSON($id,$idVotant);

echo $JSON;


?>
