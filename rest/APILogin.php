<?php
        require_once("../config/connexion.php");
        require_once("../config/rest.php");
        foreach(glob("../modele/*php") as $fichier){
            require_once($fichier);
        }
        Connexion::connect();
        $idUtilisateur = Utilisateur::connexion($_GET["login_utilisateur"],$_GET["password_utilisateur"]);
        if($idUtilisateur){
            http_response_code(200);
            echo $idUtilisateur; //le code java va juste lire le contenu de la page, qui sera l'idUtilisateur
        }
        else{ 
            http_response_code(400);
        }  
?>