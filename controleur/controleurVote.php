
<?php
class controleurVote{
        public static function afficherVoteGros(){
            $idVoteActuel=$_GET["id"];
            $_SESSION["voteCourant"] =  $_SESSION['groupeCourant']->get("listeVote")[$idVoteActuel];
            
            //Variable des messages
            $idVotant = $_SESSION["utilisateurCourant"]->get("idUtilisateur");
            $idGroupeVotant = $_SESSION["groupeCourant"]->get("idGroupe");
            $idVoteTraite= $_SESSION["voteCourant"]->get('idVote');
            
            $titreVote= $_SESSION["voteCourant"]->get("titreVote");
            $titre=$titreVote; 
            $styleSpecial="vote"; 
            include('vues/debut.php');
            ControleurApplication::afficherHeader();
            echo '<main>';

            $_SESSION["voteCourant"]->fillChoixVote($_SESSION["utilisateurCourant"]->get("idUtilisateur")); //met a jour l'objet vote
            $listeChoixVote = $_SESSION["voteCourant"] ->get("choixVote");
            //$dateCreation = $vote->get("dateCreation");
            $descriptionVote = $_SESSION["voteCourant"]->getDescription(); 
            $listeEtiquette = $_SESSION["voteCourant"]->get("listeEtiquettes") ;
            $listeMessage = $_SESSION["voteCourant"]->get("listeMessages");
            echo "<div class=\"baseVote\">";
            include ("vues/baseGrandVote.php");
            
            if($_SESSION["voteCourant"]->get("voteOuvert")){
                include("vues/choixGrandVote.php");
            }else{
                if($_SESSION["voteCourant"]->get("discussionOuverte")){
                    echo "<h2> le vote n'est pas encore ouvert </h2>";
                }else{
                    include("vues/resultatGrandVote.php");
                }
            }
            
            echo "</div>";

            echo "<div class=\"discussionVote\">";
            echo "<h2>Discussion</h2>";

            if($vote->get("discussionOuverte")){
                include ("vues/formulaireMessage.php");
            }

            include ("vues/discussionGrandVote.php");
            echo "</div>";

            echo "<a href=routeur.php> retour </a> ";
            echo '</main>';
            include('vues/footer.html');
            include('vues/popups/addGroup.php');
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