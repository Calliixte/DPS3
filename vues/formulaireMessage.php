<h3> Contribuez ! </h3>
<form action="routeur.php?controleur=reponseFormulaire&action=reponse&form=Message" method="POST" enctype="multipart/form-data">
    <label for="message">Votre message (500 caractères max) :</label>
    <textarea id="message" name="message" maxlength="500" placeholder="Entrez votre message ici..."></textarea>
 <?php    
          echo "<input id=\"idUtilisateur\" name=\"idUtilisateur\" type=\"hidden\" value=$idVotant />";
          echo "<input id=\"idGroupe\" name=\"idGroupe\" type=\"hidden\" value=$idGroupeVotant />";
          echo "<input id=\"idVote\" name=\"idVote\" type=\"hidden\" value=$idVoteTraite />"; //id du vote dans la base de donnée
          echo "<input id=\"idVoteDansGroupe\" name=\"idVoteDansGroupe\" type=\"hidden\" value=$idVoteActuel />" //id du vote dans la liste vote du groupe courant
          ?>
    <button type="submit">Publier</button>
</form>