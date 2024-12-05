<?php

require_once("../config/connexion.php");
require_once("../modele/groupe.php");
Connexion::connect();
$classe = $_GET["classe"];
require_once("../modele/". $classe . ".php");
$id = $_GET["id"];

if($classe == "vote"){
    if(!isset($_GET["idVotant"])){
        echo "Vous devez indiquer un idVotant pour recuperer un Vote";
    }
    if(!isset($_GET["idGroupe"])){
        echo "Vous devez indiquer un idGroupe pour recuperer un Vote";
    }
    $idVotant= $_GET["idVotant"];
    $idGroupe= $_GET["idGroupe"];
    $groupe = Groupe::getGroupe($idGroupe);
    $JSON = Vote::getJSON($id,$idVotant,$groupe);
}
else{
$JSON = $classe::getJSON($id);
}


echo $JSON;

?>
