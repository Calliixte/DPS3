<?php
echo "Discussion <br/>";
foreach($listeMessage as $message){
            $contenu = $message->get("texte");
            //$auteur = $message ->get("auteur")->get("pseudo"); pour l'instant le message n'a pas d'auteur il faut finir la classe
            $datePub = $message ->get("dateEnvoi");
            $idMsg = $message->get("idMessage");
            // $listeReaction = Reaction::getReactionMessage($idVoteActuel);            pour l'instant réaction & messages sont un peu bordel donc ça restera comme ça tant que reac est pas fini
                 
            // echo "<div> $contenu <br/> $datePub";
            // foreach ($listeReaction as $reaction){
            //     //implementer un truc pour compter les reactions et les stacker quand y'a les memes (optionnel je pense)
            //     echo $reaction->__toString();
            // }
            echo"</div>";
          }
            echo "<a href=routeur.php> Voter </a>";
            echo"<br/>";
    echo"</div>";


?>