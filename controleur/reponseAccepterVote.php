<?php
require_once("../modele/message.php");
require_once("../modele/reaction.php");
require_once("../modele/utilisateur.php");
require_once("../modele/groupe.php");
require_once("../modele/vote.php");
require_once("../config/connexion.php");
Connexion::connect();


if(Vote::accepterVote($_GET["id"],$_SESSION["utilisateurCourant"]->get("role")) == -1 ){
    echo "Vous n'avez pas les permissions de réaliser cette action ! ";
    exit();
} 
else{
    echo "Proposition acceptée, vous allez être redirigé sur la page des propositions à accepter";
    echo "<meta http-equiv=\"refresh\" content=\"1; url= routeur.php?controleur=controleurVote&action=afficherNonAcceptes\">"
}
//l'id role c'est pour verifier que l'utilisateur qui execute ça a bien les droits de le faire
//dans la fonction ça va vérifier avec le role actuel de l'utilisateur donc ça devrait être fine
//il n'empeche que si l'utilisateur est admin et modifie l'id dans l'url il peut accepter les votes
//qu'il veut donc c'est moyen
                                





?>