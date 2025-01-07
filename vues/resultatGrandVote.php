<h2> résultat </h2>
<fieldset>
  <?php
    $userRole = $_SESSION["utilisateurCourant"]->get("role"); 
    $idGagnant = $_SESSION["voteCourant"]->get("idChoixGagnant") ?? -1;

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
        echo "<a href='routeur.php?controleur=reponseFormulaire&action=reponse&form=ValiderGagnant&idChoix=$idChoix&idVoteInList=$idVoteActuel'>Valider Choix Gagnant</a>";
      }
    }
  ?>
</fieldset>
