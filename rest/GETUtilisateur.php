<?php
require_once("../config/connexion.php");
require_once("../modele/utilisateur.php");

Connexion::connect();
$idU = (int)$_GET["id"];
$UserJSON = Utilisateur::getJSON($idU);

echo "<pre>" ;
echo $UserJSON;
echo "<pre>";

?>
