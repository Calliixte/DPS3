<?php

require_once("../config/connexion.php");
Connexion::connect();
$classe = $_GET["classe"];
require_once("../modele/". $classe . ".php");
$id = $_GET["id"];
$JSON = $classe::getJSON($id);

echo $JSON;


?>
