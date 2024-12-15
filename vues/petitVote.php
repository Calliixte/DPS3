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
            echo "<a href=$url> $txt </a>";
            if(isset($urlSuppr) && isset($txtSuppr)){
              echo "<a href=$urlSuppr> $txtSuppr </a>";
            }
            echo"<br/>";
    echo"</div>";
?>