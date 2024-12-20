
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
            echo "<div class=\"baseVote\">";
            include ("vues/baseGrandVote.php");
            // if (date + delai > sysdate : afficher votes fermés else : faire ce programme
            include("vues/choixGrandVote.php");
            echo "</div>";

            //puis
            include ("vues/discussionGrandVote.php");
            echo "<a href=routeur.php> retour </a> ";
            echo '</main>';
            include('vues/footer.html');
            include('vues/popups/addGroup.html');
            include('vues/fin.html');
            
        }

        public static function supprimerVote(){
            $idVoteActuel=$_GET["id"];
            $vote =  $_SESSION['groupeCourant']->get("listeVote")[$idVoteActuel];
            $idV= $vote->get("idVote");
            Vote::SupprimerVote($idV);
            echo "<meta http-equiv=\"refresh\" content=\"0; url=routeur.php\"> "; //rediriger vers la page d'accueil c'est très meh 
        }
    }

?>