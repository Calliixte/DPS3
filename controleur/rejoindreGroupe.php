<?php
require_once("../config/connexion.php");
Connexion::connect();

if (!isset($_SESSION['utilisateurCourant'])){
    echo "<b>Erreur</b> : vous devez être connecté pour utilser ce lien";
    exit();
}
//considerer crypter les liens
$idU= $_SESSION['utilisateurCourant']->get('idUtilisateur');
$idG = $_GET["idInvit"];     //je pense qu'il faudra hasher a la generation du lien et la on dehash sinon c'est facilement craquable
$requetePreparee = Connexion::pdo()->prepare("INSERT INTO Membre VALUES (:us,:gr,:ro)");
$requetePreparee -> bindParam(':us',$idU);
$requetePreparee -> bindParam(':us',$idG);
$requetePreparee -> bindParam(':ro',0);
try{
    $requetePreparee->execute();
}catch(PDOException $e){
    echo "Vous n'avez pas pu être ajouté.e au groupe";
}

echo "<meta http-equiv=\"refresh\" content=\"1; url= routeur.php\">";

?>