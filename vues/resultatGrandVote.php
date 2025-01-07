<h2> résultat </h2>
<fieldset>
  <?php
    $userRole = $_SESSION["utilisateurCourant"]->get("role");
    if($userRole == Utilisateur::ADMIN || $userRole == Utilisateur::ASSESSEUR) {
      echo "valider résultat<br>";
      foreach( $listeChoixVote as $choix){
        $intitule = $choix["intitule"];
        $nbVote = $choix["nbVote"];
        echo "<div class='boiteChoixVote'><p>$intitule : $nbVote</p></div>";
    }
    } else{
      foreach( $listeChoixVote as $choix){
          $intitule = $choix["intitule"];
          $nbVote = $choix["nbVote"];
          echo "<div class='boiteChoixVote'><p>$intitule : $nbVote</p></div>";
      }
    }
  ?>
</fieldset>
