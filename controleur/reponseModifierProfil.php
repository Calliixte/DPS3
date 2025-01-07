<?php
    $idUtilisateur = $_SESSION["utilisateurCourant"]->get("idUtilisateur");
    $link = Server::uploadImage($_FILES["u_photo"]["tmp_name"], "img/profilePicture/", basename($_FILES["u_photo"]["name"]), (string)$idUtilisateur);

    if(!is_null($link)){
        $servUrl = "https://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);

        $path = $servUrl.$link;
    }else{
        $path = null;
    }

    Utilisateur::updateUtilisateur($idUtilisateur, $_POST["nom_utilisateur"],$_POST["prenom_utilisateur"],$_POST["pseudo_utilisateur"],date_format(date_create($_POST["u_ddn"]), 'Y-m-d 0:0:0'), $_POST["adresse_utilisateur"], $_POST["email_utilisateur"], $path);        
    
    echo "information mises à jour";
    $url = "routeur.php?action=afficherConnexion&actionConnexion=Connexion";
?>