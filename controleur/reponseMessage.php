<?php
require_once("../config/connexion.php");
Connexion::connect();

foreach ($_POST as $key => $value) {
    if($key == "idUtilisateur"){
        $idUtilisateur = $value;
    }
    if($key == "idGroupe"){
        $idGroupe = $value;
    }
    if($key == "idVote"){
        $idVote = $value;
    }
}
$message=$_POST["message"];

$requete = "SELECT max(idMessage)+1 FROM `Message` WHERE 1; ";
$resultat = Connexion::pdo()->query($requete);
$nvId=$resultat->fetchColumn();
$requete = "INSERT INTO `Message`(`idMessage`, `texte`, `dateEnvoi`, `idVote`, `idUtilisateur`, `idGroupe`) VALUES (?,?,SYSDATE(),?,?,?)";
$stmt = Connexion::pdo()->prepare($requete);
$stmt->bindParam(1, $nvId, PDO::PARAM_INT);
$stmt->bindParam(2, $message, PDO::PARAM_STR);           
$stmt->bindParam(3, $idVote, PDO::PARAM_INT);
$stmt->bindParam(4, $idUtilisateur, PDO::PARAM_INT);
$stmt->bindParam(5, $idGroupe, PDO::PARAM_INT);
$stmt->execute();
$urlBack = "../routeur.php?controleur=controleurGroupe&action=afficherGrandGroupe&id=$idGroupe";

$listeVote = $_SESSION["groupeCourant"]->get('listeVote'); //Je sais pas utiliser la variable session

foreach($listeVote as $vote){
    if($vote->get('idVote') == $idVote){
        $message = new Message($nvId, $idUtilisateur, $message, date("Y-m-d H:i:s"));
        $vote->addMessage($message);
    }
}

echo "Message envoyé !";
echo "<meta http-equiv=\"refresh\" content=\"1; url=$urlBack\"> ";
?>