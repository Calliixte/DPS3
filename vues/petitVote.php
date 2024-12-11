<style>
  .vote {border:solid black;}
</style>

<?php
    echo"<div class=\"vote\">";
            echo $titreVote;
            echo "<br/>";
            foreach($listeEtiquette as $eti){
                echo $eti;
                echo " ";
            }
            echo "<a href=$url> Voter </a>";
            echo"<br/>";
    echo"</div>";
?>