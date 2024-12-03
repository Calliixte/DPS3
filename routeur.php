<?php 
    require_once("config/connexion.php");
    require_once("modeles/utilisateur.php");
    
    Connexion::connect();
    
    $User = Utilisateur::getUtilisateur(1);
    
    $User->display();

    // $tabControleur = ['controleurVoiture','controleurUtilisateur'];
    // $tabAction = array(
    //     'controleurVoiture' => 'lireVoiture',
    //     'controleurUtilisateur' => 'lireUtilisateur'
    // );

    // if(!isset($_GET['controleur'])){
    //     require_once("controleur/main.php");
    // }else{
    //     $controleur = $_GET['controleur'];
    //     $action = $_GET['action'];
    //     if(in_array($controleur,$tabControleur) && $tabAction[$controleur] == $action){
    //         require_once("controleur/$controleur.php");
    //         $controleur::$action();
    //     }
    // }
?>