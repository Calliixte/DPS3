<?php
    if(isset($_GET["idChoix"])){
        $idChoix = $_GET["idChoix"];

        $idVote = $_SESSION["voteCourant"]->get("idVote");

        //Définir le choix gagnant
        Vote::validerChoix($idVote, $idChoix); //insérer le choix dans la base
        $_SESSION["voteCourant"]->set("idChoixGagnant", $idChoix); //Stocker l'id dans le vote

        echo "vote validé !";
    }else{
        echo "erreur, aucun choix spécifié";
        exit();
    }

    if(isset($_GET["idVoteInList"])){
        $url = "routeur.php?controleur=controleurVote&action=afficherVoteGros&id=$_GET[idVoteInList]";
    }else{
        $url = "routeur.php";
    }

    echo $url;

    echo "<meta http-equiv=\"refresh\" content=\"1; url=$url\"> ";
?>