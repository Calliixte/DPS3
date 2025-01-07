<div id="popup-warning-valider" class="overlay">
    <div class="popup">
        <a class="close" href="#">&times;</a>
        <div class="content">
            <p>Attention, vous allez définir comme gagnant un vote n'ayant pas obtenu le plus de vote</p>
            <a href="#">retour</a> 
            <?php
                $url = "routeur.php?controleur=reponseFormulaire&action=reponse&form=ValiderGagnant&idVoteInList=$idVoteActuel";

                if(isset($_GET["idChoix"])){
                    $url = $url."&idChoix=$_GET[idChoix]";
                }

                echo "<a href=$url>Continuer</a>";
            ?>
        </div>
    </div>
</div>
