<div id="default">
    <h1>Proposer un Vote</h1>
    <form action="controleur/reponseProposerVote.php" method="POST" enctype="multipart/form-data">
        <label for="title">
            Titre
        </label>
        <input id="title"
            name="titre"
            type="text"
            placeholder=""
        />

        <div class="scrollableWindow">
            <?php
                $cpt = 0;
                foreach($listeEtiquette as $etiquette){
                    $nomID = "etiquette$cpt";
                    $value = $etiquette['idEtiquette'];
                    $label = $etiquette['labelEtiquette'];
                    echo "<input type=\"checkbox\" id=$nomID name=$nomID value=$value/>";
                    echo "<label for=$nomID>$label</label>"; 
                    $cpt++;
                }

                echo "<input type='hidden' id='nbEtiquettes' value=$cpt/>";
            ?>
        </div>

        <?php
            for($i = 0; $i < $nbChoix; $i++){
                $nomID = "choix$i";
                echo "<input type=\"text\" id=$nomID name=$nomID placeholder=\"choix $i\"/>";
            }

            echo "<input type='hidden' id='nbChoix' value=$nbChoix/>";
        ?>

        <label for="date">Délais de discussion</label>
        <input type="date" id="delaiDiscussion" name="delaiDiscussion"/>

        <label for="voteBlanc">Autoriser le vote blanc</label>
        <input id="voteBlanc" type="Checkbox" name="voteBlanc" value=0/>

        <label for="multiChoix">Vote à choix multiples</label>
        <input id="multiChoix" type="Checkbox" name="multiChoix" value=0/>

        <!-- TODO liste de mode de scrutin -->

        <label for="imageUpload">ajouter une photo</label>
        <input type="file" id="imageUpload" name="photo" accept="image/*" required>

        <textarea id="description" name="description" maxlength="500" placeholder="écrire une description"></textarea>

        <input id="submit" type="submit" value="envoyer">
    </form>
</div>
