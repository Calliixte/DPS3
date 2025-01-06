<!-- pour afficher l'interieur du profil  -->

<?php

class controleurUtilisateur{
    
    public static function afficherPetitUtilisateur(){
        echo "petitUtilisateur";
        echo "<a href=routeur.php?controleur=controleurUtilisateur&action=afficherProfilUtilisateur> profil </a> ";
    }
    public static function afficherProfilUtilisateur(){
        $titre = 'DPS3';
        
        include('vues/debut.php');
        self::afficherHeader();
        echo '<main>';
        if(isset($_SESSION["utilisateurCourant"])){
            echo $_SESSION["utilisateurCourant"]; 
        }else{ 
            self::afficherConnexion();
            $_SESSION["previous"]="connexion";
        }
        echo '</main>';
        include('vues/footer.html');
        include('vues/popups/addGroup.html');
        include('vues/fin.html');
    }

}

?>