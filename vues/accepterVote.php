

<h1>Accepter une proposition </h1>
<h2>Voulez vous réellement accepter la proposition suivante ? :</h2>
<?php
echo urldecode($_GET["titre"]);
$id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8'); // Échappe les caractères spéciaux pour eviter les injections ça vient de gpt mais tu sais quoi pourquoi pas
echo "<a href=\"../controleur/reponseAccepterVote.php?id=$id\"> Oui </a>";
echo "<a href=\"../routeur.php\"> Non </a>";
?>
