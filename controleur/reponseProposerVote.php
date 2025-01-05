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
require_once("../config/connexion.php");
require_once("../modele/vote.php");

Connexion::connect(); //Fichier appelé en dehors du routeur, on doit donc relancer une connexion

if(isset($_POST['nbEtiquettes'])){
    $cpt = $_POST['nbEtiquettes']; //On récupère le nombre d'étiquettes
}else{
    $cpt = 0;
}

$listeEtiquette = array();

$i = 0;
while(isset($_POST["etiquette$i"])){
    $listeEtiquette[$i] = $_POST["etiquette$i"]; //On récupère les étiquettes
    $i++;
}

if(isset($_POST['nbChoix'])){
    $nbChoix = $_POST['nbChoix']; //On récupère le nombre de choix (Pour l'instant 4 à chaque fois)
}else{
    $nbChoix = 0;
}

$listeChoix = array();

for($i=0; $i < $nbChoix; $i++){
    $nomID = "choix$i";
    if($_POST[$nomID] != ""){
        $listeChoix[$i] = $_POST[$nomID]; //On récupère les Choix
    }
}



// Vote blanc étant une checkbox dans le formulaire, il ne sera transmis que si elle est cochée
if(isset($_POST["voteBlanc"])){ //On vérifie si elle est cochée
    $voteBlanc = 1; //Si oui on met à true 
}else{
    $voteBlanc = 0; //Sinon on met à false 
}


//Même chose avec les choix multiples
if(isset($_POST["multiChoix"])){ //On vérifie si elle est cochée
    $multiChoix = 1; //Si oui on met à true 
}else{
    $multiChoix = 0; //Sinon on met à false 
}

$idCreateur = $_POST["idCreateur"]; //On récupère l'id du créateur du vote


if(count($listeChoix) < 2){ //Si il y a moins de deux choix, on refuse le vote et on redirige vers le formulaire
    $url = "../routeur.php?controleur=controleurGroupe&action=nouvelleProposition";

    echo "Erreur, un vote doit avoir au moins deux options";
    echo " <meta http-equiv=\"refresh\" content=\"1; url=$url\"> ";
} else {
    //On insère le vote
    $idVote = Vote::insererVote($_POST["titre"],$_POST["delaiDiscussion"],$_POST["delaiVote"],$_POST["description"],$voteBlanc,$multiChoix,$_POST["idGroupe"], $listeEtiquette, $listeChoix, $idCreateur);

    
    if(isset($_POST["photo"])){ //On vérifie qu'une image a été donnée

        //On upload l'image sur le serveur 
        $target_dir = "../img/groupPicture/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $rename=$target_dir . (string) $idVote; 
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $rename=$target_dir . (string) $idVote .'.'.$imageFileType; 

        print_r($_FILES);
        
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) //On met le fichier dans le bon répertoire et on vérifie que ça a fonctionné
        {
            echo "The file " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        rename($target_file,$rename); //On renomme le fichier de la manière standard "idVote.jpg"
    }

    $url = "../routeur.php";
    echo "Proposition enregistrée !";
    echo " <meta http-equiv=\"refresh\" content=\"1; url=$url\"> "; //redirige vers l'url donnée au bout de 0 secondes, modifier le 0 ou commenter la ligne si on veut voir la page de debug
}
?>
</pre>
</body>
</html>