<?php
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
    if($key == "idVoteDansGroupe"){
        $idVoteDansGroupe = $value; //id du vote dans la liste vote du groupe
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
$urlBack = "routeur.php?controleur=controleurVote&action=afficherVoteGros&id=$idVoteDansGroupe";


//Ajouter le message dans l'objet vote
foreach($_SESSION["groupeCourant"]->get("listeVote") as $vote){
    if($vote->get('idVote') == $idVote){ //On trouve le bon Vote
        $message = new Message($nvId, $idUtilisateur, $message, date("Y-m-d H:i:s")); //On crée l'objet vote
        $vote->addMessage($message); //On ajoute le message
    }
}

echo "Message envoyé !";
echo "<meta http-equiv=\"refresh\" content=\"0; url=$urlBack\"> ";
?>