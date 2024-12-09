<!-- méthodes : 
afficherVoteGros
afficherListePetitsVotes -->

<?php

class controleurVote{
        public static function afficherVotePetit(){
            echo "afficherVotePetit";
            echo "<a href=routeur.php?controleur=controleurVote&action=afficherVoteGros> afficher le vote </a> ";
        }
        public static function afficherVoteGros(){
            echo "afficherVoteGros";
            echo "<a href=routeur.php> retour </a> ";
        }


















}


?>