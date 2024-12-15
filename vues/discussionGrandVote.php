<div class="discussionVote">
<h2>Discussion</h2>

<h3> Contribuez ! </h3>
<form action="controleur/reponseMessage.php" method="POST" enctype="multipart/form-data">
    <label for="message">Votre message (500 caractères max) :</label>
    <textarea id="message" name="message" maxlength="500" placeholder="Entrez votre message ici..."></textarea>
 <?php    
 
          $idVotant = $_SESSION["utilisateurCourant"]->get("idUtilisateur");
          $idGroupeVotant = $_SESSION["groupeCourant"]->get("idGroupe");
          $idVoteTraite= $vote->get('idVote');
          echo "<input id=\"idUtilisateur\" name=\"idUtilisateur\" type=\"hidden\" value=$idVotant />";
          echo "<input id=\"idGroupe\" name=\"idGroupe\" type=\"hidden\" value=$idGroupeVotant />";
          echo "<input id=\"idVote\" name=\"idVote\" type=\"hidden\" value=$idVoteTraite />"; ?>
    <button type="submit">Publier</button>
</form>
<?php
foreach($listeMessage as $message){
            $contenu = $message->get("texte");
            //$auteur = $message ->get("auteur")->get("pseudo"); pour l'instant le message n'a pas d'auteur il faut finir la classe
            $datePub = $message ->get("dateEnvoi");
            $idMsg = $message->get("idMessage");
            $listeReaction = Reaction::getReactionMessage($idMsg);          //  pour l'instant réaction & messages sont un peu bordel donc ça restera comme ça tant que reac est pas fini
            $ndate = substr($datePub,0,16);
            echo "<div class=\"messageVote\"> $ndate  $contenu ";
            foreach ($listeReaction as $reaction){
            //     //implementer un truc pour compter les reactions et les stacker quand y'a les memes (optionnel je pense)
                 echo $reaction->get('emoticone');
            }
            if ($_SESSION['utilisateurCourant']->get('role')==2){ //est administrateur 
            echo "<a href=\"routeur.php?controleur=controleurMessage&action=supprimerMessage&id=$idvkw\">Supprimer ce message</a>"; 
            }
            echo "<div class=\"listeReaction\">";
            echo " Réagir : ";
            echo "<a href=/*lien pour aller a un truc qui insert l'emoji*/\"../routeur.php\">😂</a>"; 

            echo "<a href=/*lien pour aller a un truc qui insert l'emoji*/\"../routeur.php\">🤝</a>";
            echo "<a href=/*lien pour aller a un truc qui insert l'emoji*/\"../routeur.php\">👍</a>";
            echo "<a href=/*lien pour aller a un truc qui insert l'emoji*/\"../routeur.php\">👏</a>";
            echo "</div>";
            echo"</div>";
          }
            echo "<a href=routeur.php> Voter </a>";   
?>
</div>