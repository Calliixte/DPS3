<?php
          
    Class ControleurGroupe{
        
        public static function getGroupe(){
            $idGroupe = $_GET['id'];
            $utilisateurCourant = Utilisateur::getUtilisateur(2);
            return $utilisateurCourant->getGroupe($idGroupe);
        }

        public static function afficherGrandGroupe(){
            $groupe = ControleurGroupe::getGroupe();
            $groupe->display();
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