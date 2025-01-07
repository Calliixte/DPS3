
<?php 
require_once("config/date.php");
require_once("config/connexion.php");
require_once("config/server.php");
require_once("modele/message.php");
require_once("modele/reaction.php");
require_once("modele/utilisateur.php");
require_once("modele/groupe.php");
require_once("modele/vote.php");

require_once("controleur/controleurUtilisateur.php");
require_once("controleur/controleurGroupe.php");
require_once("controleur/controleurMessage.php");
require_once("controleur/controleurVote.php");
require_once("controleur/controleurApplication.php");

require_once("controleur/reponseFormulaire.php");

Connexion::connect();
session_start();

$controleur="controleurApplication"; //mettre le controleur par défaut (celui de la page d'accueil)
$action="afficherPageAccueil"; //mettre l'action que doit faire ce controleur par défaut
$tableauControleurs = ["controleurApplication","controleurGroupe","controleurMessage","controleurUtilisateur","controleurVote","reponseFormulaire"];

if(isset($_GET["controleur"])){
    if(in_array($_GET["controleur"],$tableauControleurs)){
        $controleur=$_GET["controleur"];
    }
}

if(isset($_GET["action"])){
    if(in_array($_GET["action"],get_class_methods($controleur))){
        $action=$_GET["action"];
    }
}

$connected = isset($_SESSION["utilisateurCourant"]);
$connecting = (isset($_GET["form"]) && $_GET["form"] != "ConnexionUtilisateur" && $_GET["form"] != "Inscription");

// On vérifie si l'utilisateur et connecté, et qu'il n'est pas en train de s'inscrire ou de se connecter
if(!$connected && !isset($_GET["form"])){   
    $action = "afficherConnexion";
    $controleur="controleurApplication";
}

$controleur::$action();
?>