<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titre</title>
</head>
<body>



<!-- Ce controleur est définitivement pas parfait, que ce soit le return qui je sais pas trop comment on récup
ou les require once de partout, pour l'instant il permet quand meme de tester la structure donc ça va mais
a changer la maniere dont c'est organisé cette affaire  -->

<?php
require_once("../modele/utilisateur.php");
require_once("../config/connexion.php");
Connexion::connect();

echo "bienvenue";
$urlRouteur = "../rest";
$url = "../vues/connexionUtilisateur.html";

if(Utilisateur::connexion($_POST["login_utilisateur"],$_POST["password_utilisateur"]) ){

echo "<meta http-equiv=\"refresh\" content=\"1; url=$urlRouteur\"> "; return $idUtilsateurCourant; /*l'id n'est pas initialisé mais il est return par la fonction donc facile à faire, rien de tout ça n'est parfait mais tout fonctionne*/}
 else{ echo " <meta http-equiv=\"refresh\" content=\"1; url=$url\"> ";}  //je sais quand meme pas trop comment on va repasser la valeur au programme initial, la méthode devrait être dans le routeur, mais pour un mvc ça serait bizarre, en tout cas on a le code y'a plus qu'a le bouger

?>