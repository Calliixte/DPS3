<?php
require_once("../modele/utilisateur.php");
require_once("../config/connexion.php");
Connexion::connect();
session_start();
if (!isset($_SESSION['utilisateurCourant'])){
    echo "<b>Erreur</b> : vous devez être connecté pour utiliser ce lien";
    exit();
}
//considerer crypter les liens
$idU= $_SESSION['utilisateurCourant']->get('idUtilisateur');
$idG = $_GET["idInvit"];     //je pense qu'il faudra hasher a la generation du lien et la on dehash sinon c'est facilement craquable
$test=3;
$requetePreparee = Connexion::pdo()->prepare("INSERT INTO Membre VALUES (:us,:gr,:ro)");
$requetePreparee -> bindParam(':us',$idU);
$requetePreparee -> bindParam(':gr',$idG);
$requetePreparee -> bindParam(':ro',$test);
try{
    $requetePreparee->execute();
    // $_SESSION['utilisateurCourant']->addGroupe($idG);
}catch(PDOException $e){
    echo $e->getMessage();
    echo "Vous n'avez pas pu être ajouté.e au groupe";
}

echo "<meta http-equiv=\"refresh\" content=\"1; url= ../routeur.php\">";

?>