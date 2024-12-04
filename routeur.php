<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>DPS3</title>
        <link rel='stylesheet' href='css/index.css'/>
    </head>
    <body>
        <main>
            <h2>DPS3<h2>
            <?php 
                require_once("config/connexion.php");
                require_once("modele/utilisateur.php");
                require_once("modele/groupe.php");

                Connexion::connect();
                
                $User = Utilisateur::getUtilisateur(1);

                $Groupe = Groupe::getGroupe(1);
                
                $User->display();
                $Groupe->display();
            ?>
        </main>
        <footer>this hell of a footer, such a banger</footer>
    </body>
</html>