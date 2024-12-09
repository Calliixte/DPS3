<?php
    Class ControleurGroupe{
        public static function afficherGrandGroupe(){
            echo "afficher groupe numéro x";
            // include("vue/groupe.php");
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherVotes> afficher les votes </a> ";
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherRegle> afficher les regles </a> ";
        }

        public static function afficherVotes(){
            echo "afficher votes du groupe numéro x";
        }
        
        public static function afficherRegle(){
            echo "les règles du groupe numéro x";
        }

        public static function afficherPetitGroupe(){
            echo " le groupe x en petit";
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherGrandGroupe> rejoindre un groupe </a> ";
        }
    }
?>