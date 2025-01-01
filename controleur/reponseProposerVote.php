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

Connexion::connect();

if(isset($_POST['nbEtiquettes'])){
    $cpt = $_POST['nbEtiquettes'];
}else{
    $cpt = 0;
}

$listeEtiquette = array();

$i = 0;
while(isset($_POST["etiquette$i"])){
    $listeEtiquette[$i] = $_POST["etiquette$i"];
    $i++;
}

if(isset($_POST['nbChoix'])){
    $nbChoix = $_POST['nbChoix'];
}else{
    $nbChoix = 0;
}

$listeChoix = array();

for($i=0; $i < $nbChoix; $i++){
    $nomID = "choix$i";
    $listeChoix[$i] = $_POST[$nomID];
}

$voteBlanc = 0;

if(isset($_POST["voteBlanc"])){
    $voteBlanc = 1;
}

$multiChoix = 0;

if(isset($_POST["multiChoix"])){
    $multiChoix = 1;
}

$idCreateur = $_POST["idCreateur"];

Vote::insererVote($_POST["titre"],$_POST["delaiDiscussion"],$_POST["delaiVote"],$_POST["description"],$voteBlanc,$multiChoix,$_POST["idGroupe"], $listeEtiquette, $listeChoix, $idCreateur);
$url = "../routeur.php";
echo "Vous avez bien été inscrit(e) ! ";
echo " <meta http-equiv=\"refresh\" content=\"1; url=$url\"> " //redirige vers l'url donnée au bout de 0 secondes, modifier le 0 ou commenter la ligne si on veut voir la page de debug
?>
</pre>

<img src="<?=$rename?>"/>

</body>
</html>