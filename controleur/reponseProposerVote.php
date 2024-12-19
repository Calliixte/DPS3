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

Connexion::connect();


Vote::insererVote($_POST["titre"],$_POST["delaiDiscussion"],$_POST["description"],$_POST["password_utilisateur"],date_format(date_create($_POST["u_ddn"]), 'Y-m-d 0:0:0'),$_POST["email_utilisateur"],$_POST["adresse_utilisateur"],$rename);
$url = "../routeur.php";
echo "Vous avez bien été inscrit(e) ! ";
echo " <meta http-equiv=\"refresh\" content=\"1; url=$url\"> " //redirige vers l'url donnée au bout de 0 secondes, modifier le 0 ou commenter la ligne si on veut voir la page de debug
?>
</pre>

<img src="<?=$rename?>"/>

</body>
</html>