
<?php

class controleurVote{
        public static function afficherVoteGros(){
            $idVoteActuel=$_GET["id"];
            $vote =  $_SESSION['groupeCourant']->get("listeVote")[$idVoteActuel];
            
            $vote->fillChoixVote();
            $titreVote= $vote->get("titreVote");
            $listeChoixVote = $vote ->get("choixVote");
            //$dateCreation = $vote->get("dateCreation");
            $descriptionVote = $vote ->getDescription(); 
            $listeEtiquette = $vote-> get("listeEtiquettes") ;
            $listeMessage = $vote -> get("listeMessages");
            include ("vues/baseGrandVote.php");
            // if (date + delai > sysdate : afficher votes fermés else : faire ce programme
            include("vues/choixGrandVote.php");

            //puis
            include ("vues/discussionGrandVote.php");



            //passer l'idVote
            //todo faire une methode avec select * qui prendra les données et affichera tout l'objet comme prévu, avec un include comme avant tout ça
            
            echo "<a href=routeur.php> retour </a> ";
        }


















}


?>