<?php
require_once("../config/connexion.php");
Connexion::connect();

$listeIdChoisis= array();
foreach ($_POST as $key => $value) {
    echo "{$key} => {$value} ";
    if($key == "idUtilisateur"){
        $idUtilisateur = $value;
    }
    if($key == "idGroupe"){
        $idGroupe = $value;
    }
    if($key == "idVote"){
        $idVote = $value;
    }
    if($key != "idUtilisateur" && $key !="idGroupe" && $key !="idVote"){
        array_push($listeIdChoisis,$value);
    }
}

if(!isset($idUtilisateur) || !isset($idGroupe) || !isset($idVote)){
    echo "<b>Erreur : </b> aucun utilisateur ou groupe obtenu.";
    exit();
}
$urlBack = "../routeur.php?controleur=controleurGroupe&action=afficherGrandGroupe&id=$idGroupe";
// echo "L'utilisateur  $idUtilisateur";
// echo "Dans le groupe $idGroupe";
// echo "a voté pour les propositions suivantes : ";
try{
$stmt = Connexion::pdo()->prepare("CALL supprimerChoixMembre(?, ?, ?)"); //supprimer les potentiels anciens choix du membre avant d'inserer les nouveaux, pour eviter les votes multiples
$stmt->bindParam(1, $idUtilisateur, PDO::PARAM_INT);
$stmt->bindParam(2, $idGroupe, PDO::PARAM_INT);
$stmt->bindParam(3, $idVote, PDO::PARAM_INT);

$stmt->execute();
}catch (PDOException $e) {
    echo "aucun Vote supprimé";
}


foreach($listeIdChoisis as $id){
    try{
    $requete = "INSERT INTO `ChoixMembre`(`idUtilisateur`, `idGroupe`, `idChoixVote`) VALUES (?,?,?)";
    $stmt = Connexion::pdo()->prepare($requete);
    $stmt->bindParam(1, $idUtilisateur, PDO::PARAM_INT);
    $stmt->bindParam(2, $idGroupe, PDO::PARAM_INT);           
    $stmt->bindParam(3, $id, PDO::PARAM_INT);
    $stmt->execute();
    }
    catch(PDOException $e){
        echo "Vous avez essayé de voter pour plusieurs choix dans un vote à choix unique, seul votre premier vote a été conservé !"; //ne restera pas tout le temps pareil
        echo "<meta http-equiv=\"refresh\" content=\"1; url=$urlBack\"> ";
        exit();
    }
}


echo "Votre vote a bien été pris en compte !";
echo "<meta http-equiv=\"refresh\" content=\"1; url=$urlBack\"> ";

?>