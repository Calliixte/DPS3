<style>
  .vote {border:solid black;}
</style>


<!-- supprimer les br /!\ (une fois que css sera fait) -->
<?php
    echo"<div class=\"vote\">";
            echo $titreVote;
            echo "<br/>";
            foreach($listeEtiquette as $eti){
                echo $eti;
                echo " ";
            }
            echo"<br/>";
            echo mb_strimwidth($description, 0, 150, "...");
            echo"<br/>";
            echo "<a href=$url> Voter </a>";
            echo"<br/>";
    echo"</div>";
?>