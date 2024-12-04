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
                require_once("modeles/utilisateur.php");

                Connexion::connect();
                
                $User = Utilisateur::getUtilisateur(1);
                
                $User->display();
            ?>
        </main>
        <footer>this hell of a footer, such a banger</footer>
    </body>
</html>