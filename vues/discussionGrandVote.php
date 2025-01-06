<?php
foreach($listeMessage as $message){

            echo $idVotant . " group:  " . $idGroupeVotant;
            $contenu = $message->get("texte");
            //$auteur = $message ->get("auteur")->get("pseudo"); pour l'instant le message n'a pas d'auteur il faut finir la classe
            $datePub = $message->getDateEnvoi();
            $idMsg = $message->get("idMessage");
            $listeReaction = Reaction::getReactionMessage($idMsg);          //  pour l'instant réaction & messages sont un peu bordel donc ça restera comme ça tant que reac est pas fini
            echo "<div class=\"messageVote\"> $datePub  $contenu ";
            foreach ($listeReaction as $reaction){
            //     //implementer un truc pour compter les reactions et les stacker quand y'a les memes (optionnel je pense)
                 echo $reaction->get('emoticone');
            }
            if ($_SESSION['utilisateurCourant']->get('role')==2){ //est administrateur 
            echo "<a href=\"routeur.php?controleur=controleurMessage&action=supprimerMessage&id=$idMsg\">Supprimer ce message</a>"; 
            }
            echo "<div class=\"listeReaction\">";
            echo " Réagir : ";
            $idReacteur = $idVotant;
            $emoji1 = urlencode("😂");
            $emoji2 = urlencode("👍");
            $emoji3 = urlencode("👎");
            $emoji4 = urlencode("👏");
            $url1="controleur/reponseReagirMsg.php?idU=$idReacteur&idG=$idGroupeVotant&emoji=$emoji1&idM=$idMsg";
            $url2="controleur/reponseReagirMsg.php?idU=$idReacteur&idG=$idGroupeVotant&emoji=$emoji2&idM=$idMsg";
            $url3="controleur/reponseReagirMsg.php?idU=$idReacteur&idG=$idGroupeVotant&emoji=$emoji3&idM=$idMsg";
            $url4="controleur/reponseReagirMsg.php?idU=$idReacteur&idG=$idGroupeVotant&emoji=$emoji4&idM=$idMsg";
            echo "<a href=$url1>😂</a>"; 
            echo "<a href=$url2>👍</a>";
            echo "<a href=$url3>👎</a>";
            echo "<a href=$url4>👏</a>";
            echo "</div>";
            echo"</div>";
          } 
?>