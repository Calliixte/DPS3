<?php
    $idUtilisateur = $_SESSION["utilisateurCourant"]->get("idUtilisateur");
    $linkBanniere = Server::uploadImage($_FILES["u_photo"]["tmp_name"], "img/GroupPicture/", basename($_FILES["u_photo"]["name"]), (string)$idUtilisateur);

    // Utilisateur::updateUtilisateur($idUtilisateur, $_POST["nom_utilisateur"],$_POST["prenom_utilisateur"],$_POST["pseudo_utilisateur"],date_format(date_create($_POST["u_ddn"]), 'Y-m-d 0:0:0'), $_POST["adresse_utilisateur"], $_POST["email_utilisateur"]);        
    $url = "routeur.php?action=afficherConnexion&actionConnexion=Connexion";
?>