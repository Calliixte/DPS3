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
                  echo "  <div>
                    <input type=\"checkbox\" id=$idCv name=$choix[\"intitule\"] value=$idCv />
                    <label for=$idCv>$choix[\"intitule\"]</label>";
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
          echo "</fieldset>"
?>
       <div>
       <button type="submit">Envoyer le vote</button>
       </div>
       </form>
