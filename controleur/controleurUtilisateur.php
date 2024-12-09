<!-- pour afficher l'interieur du profil  -->

<?php

class controleurUtilisateur{
    
    public static function afficherPetitUtilisateur(){
        echo "petitUtilisateur";
        echo "<a href=routeur.php?controleur=controleurUtilisateur&action=afficherProfilUtilisateur> profil </a> ";
    }
    public static function afficherProfilUtilisateur(){
        echo "profilUtilisateur";
        echo "<a href=routeur.php> retour </a> ";
    }

}












?>