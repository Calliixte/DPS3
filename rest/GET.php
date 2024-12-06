

<?php

require_once("../config/connexion.php");
require_once("../modele/groupe.php");
Connexion::connect();
$lienDocu= "<a href=\"index.html\">documentation</a>";
$listeClasse = array("groupe","message","reaction","utilisateur","vote");
if(!isset($_GET["classe"]) || !isset($_GET["id"])){
    echo "<b>Erreur : </b> Pour utiliser l'API vous devez à minima indiquer une <b>classe</b> et un <b>id</b> dans l'url, vous pouvez consulter la  $lienDocu pour en savoir plus. ";
    exit();
}else{ if (!in_array( $_GET["classe"], $listeClasse)){
    echo "<b>Erreur : </b> Votre <b>classe</b> est invalide, vous pouvez consulter la  $lienDocu pour connaitre la liste des classes. ";
    exit();
} }
$classe = $_GET["classe"];
require_once("../modele/". $classe . ".php");
$id = $_GET["id"];

if($classe == "vote"){
    if(!isset($_GET["idVotant"]) || !isset($_GET["idGroupe"])){
        echo "<b>Erreur : </b> Pour utiliser l'API vous devez à minima indiquer une <b>idVotant</b> et un <b>idGroupe</b> dans l'url, vous pouvez consulter la  $lienDocu pour en savoir plus. ";
        exit();
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
