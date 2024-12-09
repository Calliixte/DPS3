<?php
    Class controleurGroupe{
        public static function afficherGrandGroupe(int $idGroupe){
            echo "afficher groupe numéro $idGroupe";
            // include("vue/groupe.php");
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherVotes> afficher les votes </a> ";
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherRegle> afficher les regles </a> ";
        }

        public static function afficherVotes(int $idGroupe){
            echo "afficher votes du groupe numéro $idGroupe";
        }
        
        public static function afficherRegle(int $idGroupe){
            echo "les règles du groupe numéro $idGroupe";
        }

        public static function afficherPetitGroupe(int $idGroupe){
            echo " le groupe $idGroupe en petit";
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherGrandGroupe> rejoindre un groupe </a> ";
        }
    }
?>