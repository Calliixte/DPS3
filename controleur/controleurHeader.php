<?php
    Class ControleurHeader{

        public static function getPhotoProfil(){

        }

        public static function afficherHeader(){
            echo "<header>";
            if(isset($_SESSION["utilisateurCourant"])){
                $idUser = $_SESSION["utilisateurCourant"]->get('idUtilisateur');
                $photoProfil = "img/profilePicture/$idUser.jpg";
                include('vues/header.php');
                foreach($_SESSION['utilisateurCourant']->get('listeGroupes') as $groupe){
                    include('vues/boutonGroupe.php');
                }
                echo "</nav>";
            }
            include('vues/boutonRejoindre.php');
            echo "</header>";
        }
    }
?>