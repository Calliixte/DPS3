<?php
    if(isset($_GET["idChoix"])){
        $idChoix = $_GET["idChoix"];
    }else{
        echo "erreur, aucun choix spécifié";
        exit();
    }
    
    $idVote = $_SESSION["voteCourant"]->get("idVote");

    Vote::validerChoix( $idVote,$idChoix);

    $_SESSION["voteCourant"]->set("idChoixGagnant", $idChoix);

    $_SESSION["voteCourant"]->display();

    echo "vote validé !";

?>