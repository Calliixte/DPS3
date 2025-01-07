<h2> résultat </h2>
<fieldset>
  <?php
    $userRole = $_SESSION["utilisateurCourant"]->get("role");

    foreach( $listeChoixVote as $choix){
      $idChoix = $choix["idChoixVote"];
      $intitule = $choix["intitule"];
      $nbVote = $choix["nbVote"];
      echo "<div class='boiteChoixVote'><p>$intitule : $nbVote</p></div>";

      if($userRole == Utilisateur::ADMIN || $userRole == Utilisateur::ASSESSEUR) {
        echo "<a href='routeur.php?controleur=reponseFormulaire&action=reponse&form=ValiderGagnant&idChoix=$idChoix&idVoteInList=$idVoteActuel'>Valider Choix Gagnant</a>";
      }
    }
  ?>
</fieldset>
