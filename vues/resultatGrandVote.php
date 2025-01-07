<h2> résultat </h2>
<fieldset>
  <?php
    $userRole = $_SESSION["utilisateurCourant"]->get("role"); 
    $idGagnant = $_SESSION["voteCourant"]->get("idChoixGagnant") ?? -1;
    $maxVote = $_SESSION["voteCourant"]->getIdMaxChoix();

    foreach( $listeChoixVote as $choix){
      $idChoix = $choix["idChoixVote"];
      $intitule = $choix["intitule"];
      $nbVote = $choix["nbVote"];
      $class = 'boiteChoixVote';

      if( $idGagnant == $idChoix ){
        $class = $class.'Gagnant';
      }

      echo "<div class=$class><p>$intitule : $nbVote</p></div>";

      if($userRole == Utilisateur::ADMIN || $userRole == Utilisateur::ASSESSEUR) {
        if($choix["nbVote"] < $maxVote){
          $url = "routeur.php?controleur=controleurVote&action=afficherVoteGros&id=$idVoteActuel&idChoix=$idChoix#popup-warning-valider";
        }else{
          $url = "routeur.php?controleur=reponseFormulaire&action=reponse&form=ValiderGagnant&idChoix=$idChoix&idVoteInList=$idVoteActuel";
        }

        echo "<a href=$url>Valider Choix Gagnant</a>";
      }
    }
  ?>
</fieldset>
