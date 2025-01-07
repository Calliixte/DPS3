<div id="default">
    <h1>Profil</h1>
    <form action="routeur.php?controleur=reponseFormulaire&action=ModifierProfil" method="POST" enctype="multipart/form-data">
        <label for="imageUpload">photo de profil :</label>
        
        <div>
            <img src=<?=$lienPhotoProfil?>>
            <input type="file" id="imageUpload" name="u_photo" accept="image/*">	
        </div>

        <div class="field">
            <label for="u_name">
                Nom
            </label>
            <input id="u_name"
                name="nom_utilisateur"
                type="text"
                value="<?=$infoUtilisateur["nom"]?>"
            />
        </div>

        <div class="field">
            <label for="u_firstname">
                Prenom
            </label>
            <input id="u_firstname"
                name="prenom_utilisateur"
                type="text"
                value="<?=$infoUtilisateur["prenom"]?>"
            />
        </div>

        <div class="field">
            <label for="u_nickname">
                Pseudo
            </label>
            <input id="u_nickname"
                name="pseudo_utilisateur"
                type="text"
                pattern="[^@#$%^&*]+" 
                title="Les caractères @, #, $, %, ^, &, * ne sont pas autorisés." 
                value="<?=$infoUtilisateur["pseudo"]?>"
            />
        </div>

        <div class="field">
            <label for="u_birthdate">Date de Naissance</label>
            <input type="date" id="u_birthdate" name="u_ddn" value="<?=$infoUtilisateur["dateNaissance"]?>">
        </div>

        <div class="field">
            <label for="u_addr">Adresse</label>
            <input type="text" id="u_addr" name="adresse_utilisateur" value="<?=$infoUtilisateur["adresse"]?>">
        </div>

        <div class="field">
            <label for="u_email">Email</label>
            <input type="email" id="u_email" name="email_utilisateur" value="<?=$infoUtilisateur["mail"]?>">
        </div>

        <input id="submit" type="submit" value="modifier">
    </form>
</div>
