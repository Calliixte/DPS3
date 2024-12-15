<?php
require_once("../modele/message.php");
require_once("../config/connexion.php");
Connexion::connect();
$idUser = $_GET["idU"];
$idGroup = $_GET["idG"];
$idMsg = $_GET["idM"];
$emoji = urldecode($_GET["emoji"]);
echo Message::ajouterReaction($idUser,$idGroup,$idMsg,$emoji);
?>
<a href="../routeur.php"> retour </a>