<div id="default">
    <h1>Profil</h1>
    <form action="controleur/reponseAjouterEtiquette.php" method="POST" enctype="multipart/form-data">
        <div class="field">
        <label for="txtEti">
                Nom de l'etiquette
            </label>
            <input id="txtEti"
                name="txtEti"
                type="text"
            />
        </div>

        <div class="field">
            <label for="couleur">
                Couleur choisie : 
            </label>
            <input id="couleur"
                name="couleur"
                type="color"
            />
        </div>
        <input id="submit" type="submit" value="Creer">
    </form>
</div>
