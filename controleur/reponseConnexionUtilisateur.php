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

require_once("../modele/message.php");
require_once("../modele/reaction.php");
require_once("../modele/utilisateur.php");
require_once("../modele/groupe.php");
require_once("../modele/vote.php");
require_once("../config/connexion.php");
Connexion::connect();
$idUtilisateur;
$_SESSION["previous"] = "autre";


$idUtilisateur = Utilisateur::connexion($_POST["login_utilisateur"],$_POST["password_utilisateur"]);
if($idUtilisateur){
    session_start();
    $_SESSION["utilisateurCourant"] = Utilisateur::getUtilisateur($idUtilisateur);
    $urlRouteur = "../routeur.php?controleur=controleurApplication&action=afficherPageAccueil";
    echo "Mot de passe correct ! \n Bienvenue dans DPS3";
    echo "<meta http-equiv=\"refresh\" content=\"1; url=$urlRouteur\"> ";
}
else{ 
    $urlErreur = "../routeur.php?actionConnexion=Connexion";
    echo "Mot de passe incorrect, vous allez pouvoir ressayer";
    echo " <meta http-equiv=\"refresh\" content=\"2; url=$urlErreur\"> ";

}  //je sais quand meme pas trop comment on va repasser la valeur au programme initial, la méthode devrait être dans le routeur, mais pour un mvc ça serait bizarre, en tout cas on a le code y'a plus qu'a le bouger

?>