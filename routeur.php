<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <title>DPS3</title>
        <link rel='stylesheet' href='css/style.css'/>
    </head>
    <body>
        <main>
            <h2>DPS3</h2>
            <?php 

            require_once("config/connexion.php");
            
            require_once("modele/message.php");
            require_once("modele/reaction.php");
            require_once("modele/utilisateur.php");
            require_once("modele/groupe.php");
            require_once("modele/vote.php");
            require_once("controleur/controleurApplication.php");
            Connexion::connect();
    

            // $controleur="defaut"; //mettre le controleur par défaut (celui de la page d'accueil)
            // $action="action par def de ce controleur"; //mettre l'action que doit faire ce controleur par défaut
            // $tableauControleurs = ["controleurApplication","controleurGroupe","controleurMessage","controleurUtilisateur","controleurVote"];


            // if(isset($_GET["controleur"])){
            //     if(in_array($_GET["controleur"],$tableauControleurs)){
            //         $controleur=$_GET["controleur"];
            //     }
            // }
            // require_once("controleur/$controleur.php");
            // if(isset($_GET["action"])){
            //     if(in_array($_GET["action"],get_class_methods($controleur))){
            //     $action=$_GET["action"];
            //     }
            // }
            // $controleur::$action();
            

            // $User = Utilisateur::getUtilisateur(2);

            // $User->display();

            $groupe = Groupe::getGroupe(1);

            // $groupe->display();

            include('vues/bouton-groupe.php');


            ?>
        </main>
        <footer>this hell of a footer, such a banger</footer>
    </body>
</html>