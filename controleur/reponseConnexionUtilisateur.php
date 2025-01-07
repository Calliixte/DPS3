<?php
    Connexion::connect();
    $idUtilisateur;
    $_SESSION["previous"] = "autre";


    $idUtilisateur = Utilisateur::connexion($_POST["login_utilisateur"],$_POST["password_utilisateur"]);
    if($idUtilisateur){
        $_SESSION["utilisateurCourant"] = Utilisateur::getUtilisateur($idUtilisateur);
        $urlRouteur = "routeur.php?controleur=controleurApplication&action=afficherPageAccueil";
        echo "Mot de passe correct ! \n Bienvenue dans DPS3";
        echo "<meta http-equiv=\"refresh\" content=\"1; url=$urlRouteur\"> ";
    }
    else{ 
        $urlErreur = "routeur.php?action=afficherConnexion&actionConnexion=Connexion";
        echo "Mot de passe incorrect, vous allez pouvoir réessayer";
        echo " <meta http-equiv=\"refresh\" content=\"1; url=$urlErreur\"> ";

    }  
?>
