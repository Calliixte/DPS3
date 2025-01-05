<div id="default">
    <h1>Nouveau groupe</h1>
    <form action="controleur/reponseCreerGroupe.php" method="POST" enctype="multipart/form-data">
        
        <label for="nomGroupe">Nom</label>
        <input id="nomGroupe" name="nomGroupe" type="text" required>

        <label for="description" >Description</label>
        <textarea id="description" name="description" maxlength="500" placeholder="écrire une description"></textarea>

        <label for="regles">Règles</label>
        <textarea id="regles" name="regles" maxlength="500" placeholder="écrire les règles" required></textarea>

        <label for="voteBlancCompte">Compter le vote blanc</label>
        <input id="voteBlancCompte" name="voteBlancCompte" type="checkbox">

        <label for="imageBanniere">Image de bannière</label>
        <input type="file" id="imageBanniere" name="imageBanniere" accept="image/*">

        <label for="imageIcone">Image d'icône</label>
        <input type="file" id="imageIcone" name="imageIcone" accept="image/*">

        <input id="submit" type="submit" value="créer">
    </form>
</div>
