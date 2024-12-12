<style>
  .vote {border:solid black;}
</style>


<form action="controleur/reponseVote.php" method="POST" enctype="multipart/form-data">

<?php
            echo "<fieldset>";
            $cpt=0;
            foreach($listeChoixVote as $choix){
                  $nomID = "choix$cpt";
                  echo "<br/>";
                  echo "  <div>
                    <input type=\"checkbox\" id=$choix name=$nomID value=$choix />
                    <label for=$choix>$choix</label>";
                  $nbVote = [$choix]["nomProposition"]["nbVote"];
                  echo " : $nbVote votes</div>";
                  $cpt++;
              echo " ";

          }
          echo "</fieldset>"
?>
       <div>
       <button type="submit">Envoyer le vote</button>
       </div>
       </form>
