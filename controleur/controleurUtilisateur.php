<!-- pour afficher l'interieur du profil  -->

<?php
class controleurUtilisateur{
    
    public static function afficherPetitUtilisateur(){
        echo "petitUtilisateur";
        echo "<a href=routeur.php?controleur=controleurUtilisateur&action=afficherProfil> profil </a> ";
    }
    
    public static function afficherProfil(){
        $infoUtilisateur=$_SESSION["utilisateurCourant"]->getAllInfoUtilisateur();
        $p=$infoUtilisateur["pseudo"];
        $styleSpecial = "profil";
        $titre="Profil de $p";
        include('vues/debut.php');
        ControleurApplication::afficherHeader();
        echo '<main>';
        include('vues/profil.php');
    
    
        echo '</main>';
        include('vues/footer.html');
        include('vues/popups/addGroup.php');
        include('vues/fin.html');
    }

}

?>