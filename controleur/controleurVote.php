<!-- méthodes : 
afficherVoteGros
afficherListePetitsVotes -->

<?php

class controleurVote{
        public static function afficherVotePetit(){

            echo "<a href=routeur.php?controleur=controleurVote&action=afficherVoteGros> afficher le vote </a> ";
        }
        public static function afficherVoteGros(){
            $id=$_GET["id"];
            echo "afficherVoteGros $id plus tard ça sera l'idVote et affiché a partir de l'idVote faudra pdo select";
            echo "<a href=routeur.php> retour </a> ";
        }


















}


?>