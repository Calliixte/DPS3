<?php

require_once("../config/connexion.php");
require_once("../config/rest.php");
foreach(glob("../modele/*php") as $fichier){
    require_once($fichier);
}

Connexion::connect();
$lienDocu= "<a href=\"index.html\">documentation</a>";
$listeClasse = array("groupe","message","reaction","utilisateur","vote");
if(!isset($_GET["classe"]) || !isset($_GET["id"])){
    echo "<b>Erreur : </b> Pour utiliser l'API vous devez à minima indiquer une <b>classe</b> et un <b>id</b> dans l'url, vous pouvez consulter la  $lienDocu pour en savoir plus. ";
    exit();
}   
else{ 
    if (!in_array( $_GET["classe"], $listeClasse)){
    echo "<b>Erreur : </b> Votre <b>classe</b> est invalide, vous pouvez consulter la  $lienDocu pour connaitre la liste des classes. ";
    exit();
    } 
}
$classe = $_GET["classe"];
require_once("../modele/". $classe . ".php"); //Potentiellement inutile (l'est actuellement)
$id = $_GET["id"];
if(isset($_GET["votes"])){
    $votes=$_GET["votes"];
    $JSON = Rest::getGroupe($id,$votes);
}else{
    if(isset($_GET["idVotant"])){
    $idVotant= $_GET["idVotant"];
    $JSON = Rest::getVote($id,$idVotant);

}   else{
        $methode = "get$classe";
        $JSON = Rest::$methode($id);
    }
}


echo $JSON;

?>
