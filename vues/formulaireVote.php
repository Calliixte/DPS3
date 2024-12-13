<div id="default">
    <h1>Inscription à DPS3</h1>
    <form action="controleur/reponseInscription.php" method="POST" enctype="multipart/form-data">
        <label for="title">
            Titre
        </label>
        <input id="title"
            name="titre"
            type="text"
            placeholder=""
        />

        <?php
            $cpt = 0;
            foreach($listeEtiquette as $etiquette){
                $nomID = "etiquette$cpt";
                echo "<input type=\"checkbox\" id=$nomID name=$nomID value=$etiquette/>";
                echo "<label for=$nomID>$etiquette</label>"; 
                $cpt++;
            }
        ?>

        <label for="date">Délais de discussion</label>
        <input type="date" id="u_birthdate" name="u_ddn"/>

        <!-- TODO liste de mode de scrutin -->

        <label for="imageUpload">ajouter une photo :</label>
        <input type="file" id="imageUpload" name="u_photo" accept="image/*" required>

        <input id="u_description"
            name="description"
            type="text"
            placeholder="écrire une description"
        />

        <input id="submit" type="submit" value="S'inscrire">
    </form>
</div>
