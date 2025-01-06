<body>
<?php
echo"<div id=\"verif\">";
if($infoUtilisateur["estVerifie"]){
    echo "<p>Votre profil est vérifié ✅</p>";
}else{
    echo "<p>Votre profil n'est pas vérifié ❌</p>";
}
echo"</div>";
echo "<h2> Mes informations </h2>";
echo"<div>";
$prenom =$infoUtilisateur["prenom"];
$nom =$infoUtilisateur["nom"];
$pseudo = $infoUtilisateur["pseudo"];
$mail =$infoUtilisateur["mail"];
$adresse =$infoUtilisateur["adresse"];
$dateNaissance =$infoUtilisateur["dateNaissance"];

echo "<p>Prénom : $prenom</p>";
echo "<p>Nom : $nom</p>";
echo "<p>Pseudo : $pseudo</p>";
echo "<p>E-mail : $mail</p>";
echo "<p>Adresse : $adresse</p>";
echo "<p>Date de naissance : $dateNaissance</p>";
echo "</div>";
?>

</body>