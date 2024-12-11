<style>
  .vote {border:solid black;}
</style>


<form action="../controleur/reponseInscription.php" method="POST" enctype="multipart/form-data">

<?php
            echo "<fieldset>";
            $cpt=0;
            foreach(array_keys($listeChoixVote) as $choix){
                  $nomID = "choix$cpt";
                  echo "<br/>";
                  echo "  <div>
                    <input type=\"checkbox\" id=$nomID name=$nomID value=\"choixPossible\" />
                    <label for=$nomID>$choix</label>
                  </div>";
                  $cpt++;
              echo " ";

          }
          echo "</fieldset>"
?>
       <div>
       <button type="submit">Envoyer le vote</button>
       </div>
       </form>
