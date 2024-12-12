<?php
require_once("../config/connexion.php");
Connexion::connect();

$listeIdChoisis= array();
foreach ($_POST as $key => $value) {
    // $arr[3] will be updated with each value from $arr...
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
    if($key != "idUtilisateur" && $key !="idGroupe"){
        array_push($listeIdChoisis,$value);
    }
}

if(!isset($idUtilisateur) || !isset($idGroupe) || !isset($idVote)){
    echo "<b>Erreur : </b> aucun utilisateur ou groupe obtenu.";
    exit();
}

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
    // La fonction émet une erreur si aucun vote n'a été supprimé, donc on la récupere mais on l'ignore
}


foreach($listeIdChoisis as $id){
    // echo $id . " ";
    // $requete = "INSERT INTO (`idUtilisateur`, `idGroupe`, `idChoixVote`) VALUES ($idUtilisateur,$idGroupe,$id)";
    // probleme : la table choixMembre reference visiblement une table vote en minuscule donc insertion impossible, il va falloir voir 
    $requete = "INSERT INTO `ChoixMembre`(`idUtilisateur`, `idGroupe`, `idChoixVote`) VALUES (?,?,?)";
    $stmt = Connexion::pdo()->prepare($requete);
    $stmt->bindParam(1, $idUtilisateur, PDO::PARAM_INT);
    $stmt->bindParam(2, $idGroupe, PDO::PARAM_INT);           
    $stmt->bindParam(3, $id, PDO::PARAM_INT);
    $stmt->execute();
}

// $urlBack = "../routeur.php?controleur=controleurGroupe&action=afficherGrandGroupe&id=$idGroupe";
// echo "Votre vote a bien été pris en compte !";
// echo "<meta http-equiv=\"refresh\" content=\"1; url=$urlBack\"> ";

?>