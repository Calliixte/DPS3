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
require_once("../modele/vote.php");

if(isset($_POST['nbEtiquettes'])){
    $cpt = $_POST['nbEtiquettes'];
}else{
    $cpt = 0;
}

$listeEtiquette = array();

for($i=0; $i < $cpt; $i++){
    $nomID = "etiquette$i";
    $listeEtiquette[$i] = $_POST[$nomID];
}

if(isset($_POST['nbChoix'])){
    $nbChoix = $_POST['nbChoix'];
}else{
    $nbChoix = 0;
}

$listeChoix = array();

for($i=0; $i < $nbChoix; $i++){
    $nomID = "etiquette$i";
    $listeChoix[$i] = $_POST[$nomID];
}

$idGroupe = $_SESSION['groupeCourant']->get('idGroupe');

Connexion::connect();

Vote::insererVote($_POST["titre"],$_POST["delaiDiscussion"],$_POST["delaiVote"],$_POST["description"],$_POST["voteBlanc"],$_POST["multiChoix"],$idGroupe, $listeEtiquette, $listeChoix);
$url = "../routeur.php";
echo "Vous avez bien été inscrit(e) ! ";
echo " <meta http-equiv=\"refresh\" content=\"1; url=$url\"> " //redirige vers l'url donnée au bout de 0 secondes, modifier le 0 ou commenter la ligne si on veut voir la page de debug
?>
</pre>

<img src="<?=$rename?>"/>

</body>
</html>