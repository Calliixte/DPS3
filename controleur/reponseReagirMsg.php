<?php
$idUser = $_GET["idU"];
$idGroup = $_GET["idG"];
$idMsg = $_GET["idM"];
$emoji = urldecode($_GET["emoji"]);
$idVote = $_GET["idVote"]; //Pas l'id dans la bd mais l'id dans la liste du groupe
echo Message::ajouterReaction($idUser,$idGroup,$idMsg,$emoji);

$url = "routeur.php?controleur=controleurVote&action=afficherVoteGros&id=$idVote";
echo " <meta http-equiv=\"refresh\" content=\"1; url=$url\"> "; //redirige vers l'url donnée au bout de 0 secondes, modifier le 0 ou commenter la ligne si on veut voir la page de debug
?>
