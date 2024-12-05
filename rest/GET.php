

<?php

require_once("../config/connexion.php");
require_once("../modele/groupe.php");
Connexion::connect();
$lienDocu= "<a href=\"index.html\">documentation</a>";
if(!isset($_GET["classe"]) || !isset($_GET["id"])){
    echo "<b>Erreur : </b> Pour utiliser l'API vous devez à minima indiquer une <b>classe</b> et un <b>id</b> dans l'url, vous pouvez consulter la  $lienDocu pour savoir plus. ";
    exit();
}
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
    $JSON = Vote::getJSON($id,$idVotant,$idGroupe);
}
else{
$JSON = $classe::getJSON($id);
}


echo $JSON;

?>
