<?php
    Class ControleurHeader{

        public static function getPhotoProfil(){

        }

        public static function afficherHeader(){
            $idUser = $_SESSION["utilisateurCourant"]->get('idUtilisateur');
            $photoProfil = "img/profilePicture/$idUser.jpg";

            include('vues/header.php');
        }
    }
?>