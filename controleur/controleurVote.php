
<?php

class controleurVote{
        public static function afficherVoteGros(){
            $idVoteActuel=$_GET["id"];
            $vote =  $_SESSION['groupeCourant']->get("listeVote")[$idVoteActuel];
            
            $titreVote= $vote->get("titreVote");
            $titre=$titreVote;            
            $styleSpecial = '';
            include('vues/debut.php');
            ControleurApplication::afficherHeader();
            echo '<main>';

            $vote->fillChoixVote($_SESSION["utilisateurCourant"]->get("idUtilisateur")); //met a jour l'objet vote
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

            echo '</main>';
            include('vues/footer.html');
            include('vues/popups/addGroup.html');
            include('vues/fin.html');

            //passer l'idVote
            //todo faire une methode avec select * qui prendra les données et affichera tout l'objet comme prévu, avec un include comme avant tout ça
            
            echo "<a href=routeur.php> retour </a> ";
        }


















}


?>