

<h1>Accepter une proposition </h1>
<h2>Voulez vous réellement accepter la proposition suivante ? :</h2>
<?php
echo $_GET["titre"];
echo "<a href=\"../controleur/reponseAccepterVote.php?id=$_GET[\"id\"]\"> Oui </a>";
echo "<a href=\"../routeur.php\"> Non </a>";
?>
