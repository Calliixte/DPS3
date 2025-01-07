<?php
    if(isset($_POST["idChoix"])){
        $idChoix = $_POST["idChoix"];
    }else{
        echo "erreur, aucun choix spécifié";
        exit();
    }
    
    $idVote = $_SESSION["voteCourant"]->get("idVote");

    Vote::validerChoix($idChoix, $idVote);

    $_SESSION["voteCourant"]->set("idChoixGagnant", $idChoix);

    echo "vote validé !";

?>