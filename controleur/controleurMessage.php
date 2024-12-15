<?php
    Class ControleurMessage{
        public static function supprimerMessage(){
            $idV=$_GET["id"];
            SupprimerMessage($idV);
            echo "<meta http-equiv=\"refresh\" content=\"0; url=routeur.php\"> "; //rediriger vers la page d'accueil c'est très meh 
        }
    }
?>