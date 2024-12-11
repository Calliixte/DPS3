<style>
  .vote {border:solid black;}
</style>

<?php




    echo"<div class=\"vote\">";
            
            foreach($listeEtiquette as $eti){
              echo $eti;
              echo " ";
          }
            echo "date parution                delai            auteur (on a pas les variables actuellement a voir dmn cmnt on fait)";
            echo $titreVote;
            echo "<br/>";
            echo " [image du vote ] ";
            echo $descriptionVote;

?>