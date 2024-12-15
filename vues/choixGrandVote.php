
<form action="controleur/reponseVote.php" method="POST" enctype="multipart/form-data">

<?php
            echo "<fieldset>";
            $cpt=0;
            foreach($listeChoixVote as $idCv =>$choix){
                  $nomID = "choix$cpt";
                  $nom= $choix["intitule"];
                  echo "<div class=\"boiteChoixVote\">";
                  echo"<input type=\"checkbox\" id=$idCv name=$nomID value=$idCv ";
                  if($choix["aVote"]){   //potentiellement faire des radioButton au lieu de faire des checkBox
                   echo" checked";
                  }
                  echo "/>";
                  echo"<label for=$idCv>$nom</label>";
                  $nbVote = $choix["nbVote"];
                  echo " : $nbVote votes";
                  if($choix["aVote"]){
                    echo "           |Votre vote est enregistré sur cette option";
                  }
                  echo "</div>";
                  $cpt++;
              echo " ";
          }
          echo "<div class=\"boiteChoixVote\">";
          echo"<input type=\"checkbox\" id=voteBlacn name=voteBlanc value=voteBlanc />"; 
          echo"<label for=voteBlanc>Vote blanc</label>";
          echo "</div>";
          echo "</fieldset>";
          $idVotant = $_SESSION["utilisateurCourant"]->get("idUtilisateur");
          $idGroupeVotant = $_SESSION["groupeCourant"]->get("idGroupe");
          $idVoteTraite= $vote->get('idVote');
          echo "<input id=\"idUtilisateur\" name=\"idUtilisateur\" type=\"hidden\" value=$idVotant />";
          echo "<input id=\"idGroupe\" name=\"idGroupe\" type=\"hidden\" value=$idGroupeVotant />";
          echo "<input id=\"idVote\" name=\"idVote\" type=\"hidden\" value=$idVoteTraite />";
?>
       <div>
       <button type="submit">Envoyer le vote</button>
       </div>
</form>
