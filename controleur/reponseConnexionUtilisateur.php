<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion ...</title>
    </head>
    <body>


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
                echo " <meta http-equiv=\"refresh\" content=\"1; url=$urlErreur\"> ";

            }  

            ?>
    </body>
</html>