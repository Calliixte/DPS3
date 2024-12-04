<?php

require_once("../config/connexion.php");
Connexion::connect();
$classe = $_GET["classe"];
require_once("../modele/". $classe . ".php");
$id = (int) $_GET["id"];
if(isset($_GET["idVotant"])){
    $idVotant= (int) $_GET["idVotant"];
    $JSON = $classe::getJSON($id,$idVotant);
}
else{
$JSON = $classe::getJSON($id);
}
echo $JSON;


?>
