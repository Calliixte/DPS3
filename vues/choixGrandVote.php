<style>
  .vote {border:solid black;}
</style>


<form action="controleur/reponseVote.php" method="POST" enctype="multipart/form-data">

<?php
            echo "<fieldset>";
            $cpt=0;
            foreach($listeChoixVote as $idCv =>$choix){
                  $nomID = "choix$cpt";
                  echo "<br/>";
                  $nom= $choix["intitule"];
                  echo "  <div>
                    <input type=\"checkbox\" id=$idCv name=$nom value=$idCv />
                    <label for=$idCv>$nom</label>";
                  $nbVote = $choix["nbVote"];
                  if($choix["aVote"]){
                    echo "vous avez voté pour cette option <br/>";
                  }
                  //recup $avote plus tard pour prechck les chkbox
                  echo " : $nbVote votes</div>";
                  $cpt++;
              echo " ";
              // echo "id " . $idCv . " ";
              // foreach($choix as $p){
              //   echo " ".$p;
              // }

          }
          echo "</fieldset>";
          $idVotant = $_SESSION["utilisateurCourant"]->get("idUtilisateur");
          $idGroupeVotant = $_SESSION["groupeCourant"]->get("idGroupe");
          echo "<input id=\"idUtilisateur\" name=\"idUtilisateur\" type=\"hidden\" value=$idVotant />";
          echo "<input id=\"idGroupe\" name=\"idGroupe\" type=\"hidden\" value=$idGroupeVotant />";
          $idVoteTraite= $vote->get('idVote');
          echo "<input id=\"idVote\" name=\"idVote\" type=\"hidden\" value=$idVoteTraite />";
?>
       <div>
       <button type="submit">Envoyer le vote</button>
       </div>
       </form>
