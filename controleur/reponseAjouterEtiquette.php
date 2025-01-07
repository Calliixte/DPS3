<?php

$couleur = $_POST["couleur"];
$nom = $_POST["txtEti"];
$idGroupeActuel = $_SESSION["groupeCourant"]->get("idGroupe");
$requete = "INSERT INTO `Etiquette`(`idGroupe`, `couleur`,`intitulé`) VALUES (,?,?)"; //j'ai pas mis d'idEtiquette pck normalement c'est en autoincremenet
//j'ai pas la composition de la base donc ça s'appelle peut être pas comme ça
$stmt = Connexion::pdo()->prepare($requete);
$stmt->bindParam(1, $idGroupeActuel, PDO::PARAM_INT);
$stmt->bindParam(2, $couleur, PDO::PARAM_STR); //je sais pas si couleur est traité comme un str ou un int jte laisse voir (normalement str)
$stmt->bindParam(3, $nom, PDO::PARAM_STR);         
$stmt->execute();

echo "<meta http-equiv=\"refresh\" content=\"0; url=routeur.php\"> ";
?>