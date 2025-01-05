<div id="default">
    <h1>Proposer un Vote</h1>
    <form action="controleur/reponseProposerVote.php" method="POST" enctype="multipart/form-data">
        <label for="title">
            Titre
        </label>
        <input id="title" name="titre" type="text" placeholder="" required>

        <div class="scrollableWindow">
            <?php
                $cpt = 0;
                foreach($listeEtiquette as $etiquette){
                    $nomID = "etiquette$cpt";
                    $value = $etiquette['idEtiquette'];
                    $label = $etiquette['labelEtiquette'];
                    echo "<input type=\"checkbox\" id=$nomID name=$nomID value=$value>";
                    echo "<label for=$nomID>$label</label>"; 
                    $cpt++;
                }
            ?>
        </div>

        <?php
            for($i = 0; $i < $nbChoix; $i++){
                $nomID = "choix$i";
                echo "<input type=\"text\" id=$nomID name=$nomID placeholder=\"choix $i\"/>";
            }

            echo "<input type='hidden' name='nbChoix' value=$nbChoix>";

            echo "<input type='hidden' name='idGroupe' value=$idGroupe>";

            echo "<input type='hidden' name='idCreateur' value=$idCreateur>";
        ?>

        <label for="delaiDiscussion">Délais de discussion</label>
        <input type="range" min=1 max=30 step=1 id="delaiDiscussion" name="delaiDiscussion">

        <label for="delaiVote">Durée du vote</label>
        <input type="range" min=1 max=30 step=1 id="delaiVote" name="delaiVote">

        <label for="voteBlanc">Autoriser le vote blanc</label>
        <input id="voteBlanc" type="Checkbox" name="voteBlanc" value=1>

        <label for="multiChoix">Vote à choix multiples</label>
        <input id="multiChoix" type="Checkbox" name="multiChoix" value=1>

        <!-- TODO liste de mode de scrutin -->
        <div class="scrollableWindow">
            <?php
                foreach($listeCodeSuffrage as $codeSuffrage){
                    echo "<input type=\"radio\" id=$codeSuffrage name=\"codeSuffrage\" value=$codeSuffrage required>";
                    echo "<label for=$codeSuffrage>$codeSuffrage</label>"; 
                }
            ?>
        </div>

        <label for="imageUpload">ajouter une photo</label>
        <input type="file" id="imageUpload" name="photo" accept="image/*">

        <textarea id="description" name="description" maxlength="500" placeholder="écrire une description"></textarea>

        <input id="submit" type="submit" value="envoyer">
    </form>
</div>
