<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
</head>
<body>

<pre>
<?php
$target_file ="";
require_once("../config/connexion.php");
require_once("../modele/utilisateur.php");

Connexion::connect();
$requete = "SELECT max(idUtilisateur)+1 FROM `Utilisateur` WHERE 1; ";
$resultat = Connexion::pdo()->query($requete);
$idMax=$resultat->fetchColumn();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Specify the directory where images will be uploaded
    
    $target_dir = "../img/profilePicture/";
    $target_file = $target_dir . basename($_FILES["u_photo"]["name"]);
    $rename=$target_dir . (string) $idMax; 
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $rename=$target_dir . (string) $idMax .'.'.$imageFileType; 

    print_r($_FILES);
    
    if (move_uploaded_file($_FILES["u_photo"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["u_photo"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    rename($target_file,$rename);
}
echo "\n";
foreach($_POST as $val ){
    echo $val;
    echo "\n";
}
echo $_POST["adresse_utilisateur"];

Utilisateur::creerUtilisateur($_POST["nom_utilisateur"],$_POST["prenom_utilisateur"],$_POST["pseudo_utilisateur"],$_POST["password_utilisateur"],date_format(date_create($_POST["u_ddn"]), 'Y-m-d H:i:s'),$_POST["email_utilisateur"],$_POST["adresse_utilisateur"],$rename);

?>
</pre>

<img src="<?=$rename?>"/>

</body>
</html>