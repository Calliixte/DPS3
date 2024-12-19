<div id="default">
    <h1>Proposer un Vote</h1>
    <form action="controleur/reponseVote.php" method="POST" enctype="multipart/form-data">
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
                    echo "<input type=\"checkbox\" id=$nomID name=$nomID value=$etiquette/>";
                    echo "<label for=$nomID>$etiquette</label>"; 
                    $cpt++;
                }
            ?>
        </div>

        <?php
            for($i = 0; $i < $nbChoix; $i++){
                $numChoix = $i+1;
                echo "<input type=\"text\" id=\"choix$numChoix\" name=\"choix$numChoix\" placeholder=\"choix $numChoix\"/>";
            }
        ?>

        <label for="date">Délais de discussion</label>
        <input type="date" id="delaiDiscussion" name="delaiDiscussion"/>

        <label for="voteBlanc">Autoriser le vote blanc</label>
        <input id="voteBlanc" type="Checkbox" name="voteBlanc" value=0/>

        <!-- TODO liste de mode de scrutin -->

        <label for="imageUpload">ajouter une photo</label>
        <input type="file" id="imageUpload" name="photo" accept="image/*" required>

        <textarea id="description" name="description" maxlength="500" placeholder="écrire une description"></textarea>

        <input id="submit" type="submit" value="envoyer">
    </form>
</div>
