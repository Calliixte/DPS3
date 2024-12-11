<?php
          
    Class ControleurGroupe{
        
        public static function getGroupe(){
            $idGroupe = $_GET['id'];
            
            return $_SESSION['utilisateurCourant']->getGroupe($idGroupe);
        }

        public static function afficherGrandGroupe(){
            $groupe = ControleurGroupe::getGroupe();
            $_SESSION['groupeCourant']=$groupe; //attention à ça ça peut causer des problemes
            $nomG = $groupe->get("nomGroupe");
            $titre= $nomG;
            $styleSpecial = '';
            include('vues/debut.php');
            ControleurApplication::afficherHeader();
            echo '<main>';
            echo "<h1> $nomG </h1>";
            echo "Récent <br/>";
            $liste=$groupe->get("listeVote");
            for($i = 0;$i<count($liste);$i++){
                $idVote = $liste[$i]->get("idVote");
                $titreVote = $liste[$i]->get("titreVote");
                $listeEtiquette = $liste[$i]->get("listeEtiquettes");
                //$dateCreation = $liste[$i]->get("dateCreation");
                $description = $liste[$i]->getDescription(); 
                $idvkw=$i;
                $url = "routeur.php?controleur=controleurVote&action=afficherVoteGros&id=$idvkw";
                include('vues/petitVote.php');
                
            }
            $groupe->display();
            echo '</main>';
            include('vues/footer.html');
            include('vues/popups/addGroup.html');
            include('vues/fin.html');

            // include("vue/groupe.php");
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherVotes> afficher les votes </a> ";
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherRegle> afficher les regles </a> ";
        }

        public static function afficherVotes(){
            $groupe = ControleurGroupe::getGroupe();
            $listeVote = $groupe->get('listeVote');
            // include("vue/listeVote.php");
            foreach($listeVote as $vote){
                $vote->display();
            }
            echo "afficher votes du groupe numéro $idGroupe";
        }
        
        public static function afficherRegle(){
            $groupe = ControleurGroupe::getGroupe();
            $regles = $groupe->get('regles');
            // include("vue/regles.php");
            echo "les règles du groupe numéro $idGroupe";
        }

        public static function afficherPetitGroupe(){
            $groupe = ControleurGroupe::getGroupe();
            $id = $groupe->get('idGroupe');

            echo "petit groupe $i";
            // include("vue/petitGroupe.php");
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherGrandGroupe> rejoindre un groupe </a>";
        }
    }
?>