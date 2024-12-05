<?php

require_once("../config/connexion.php");
require_once("../modele/groupe.php");
Connexion::connect();
header("Content-Type: text/html; charset=utf-8",true);
function decodeUnicodeEscapeSequences($str) {
    // Recherche des séquences \uXXXX et les remplace par leur caractère Unicode
    return preg_replace_callback('/\\\\u([0-9A-Fa-f]{4})/', function ($matches) {
        // Convertir la séquence hexadécimale en un caractère Unicode
        return mb_convert_encoding('&#x' . $matches[1] . ';', 'UTF-8', 'HTML-ENTITIES');
    }, $str);
}

// Parcourir tous les paramètres $_GET et appliquer la fonction de décodage
foreach ($_GET as $key => $value) {
    // Vérifier si la valeur contient des séquences \u
    if (is_string($value) && preg_match('/\\\\u[0-9A-Fa-f]{4}/', $value)) {
        // Décoder les séquences \u dans la valeur
        $_GET[$key] = decodeUnicodeEscapeSequences($value);
    }
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
    $groupe = Groupe::getGroupe($idGroupe);
    $JSON = Vote::getJSON($id,$idVotant,$groupe);
}
else{
$JSON = $classe::getJSON($id);
}
echo $JSON;

?>
