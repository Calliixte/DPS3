<?php
    Class ControleurGroupe{
        public static function afficherGrandGroupe(int $idGroupe){
            echo "afficher groupe numéro $idGroupe";
            // include("vue/groupe.php");
        }

        public static function afficherVotes(int $idGroupe){
            echo "afficher votes du groupe numéro $idGroupe";
        }
        
        public static function afficherRegle(int $idGroupe){
            echo "les règles du groupe numéro $idGroupe";
        }

        public static function afficherPetitGroupe(int $idGroupe){
            echo " le groupe $idGroupe en petit";
        }
    }
?>