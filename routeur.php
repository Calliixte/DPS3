
<?php 

require_once("config/connexion.php");
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
Connexion::connect();


// $_SESSION['utilisateurCourant'] = Utilisateur::getUtilisateur(2);;

// $controleur="controleurApplication"; //mettre le controleur par défaut (celui de la page d'accueil)
// $action="afficherPagePrincipale"; //mettre l'action que doit faire ce controleur par défaut
// $tableauControleurs = ["controleurApplication","controleurGroupe","controleurMessage","controleurUtilisateur","controleurVote"];

include('vues/debut.php');
include('vues/header.php');
echo '<main>';

// if(isset($_GET["controleur"])){
//     if(in_array($_GET["controleur"],$tableauControleurs)){
//         $controleur=$_GET["controleur"];
//     }
// }
// //require_once("controleur/$controleur.php");
// if(isset($_GET["action"])){
//     if(in_array($_GET["action"],get_class_methods($controleur))){
//     $action=$_GET["action"];
//     }
// }
// $controleur::$action();


// $User = Utilisateur::getUtilisateur(2);

// $User->display();

// $groupe = Groupe::getGroupe(1);

// $groupe->display();

// include('vues/bouton-groupe.php');
echo '</main>';
include('vues/footer.html');
include('vues/fin.html');

?>