<?php

require_once("../config/connexion.php");
require_once("../config/rest.php");
foreach(glob("../modele/*php") as $fichier){
    require_once($fichier);
}

Connexion::connect();
$lienDocu= "<a href=\"index.html\">documentation</a>";
if(!isset($_GET["table"])){
    echo "<b>Erreur : </b> Pour utiliser PUT vous devez indiquer une <b>table</b> à modifier, vous pouvez consulter la  $lienDocu pour en savoir plus. ";
    exit();
}
$table = $_GET["table"];
unset($_GET["table"]); //retire table du tableau get pour les traitements qui vont suivre
if(count(array_values($_GET))==1){
    echo "<b>Erreur : </b> Aucune donnée à insérer n'est trouvée, veuillez vérifier votre URL, vous pouvez consulter la $lienDocu pour en savoir plus. ";
    exit();
}
Rest::put($table,array_keys($_GET),array_values($_GET));

//la deuxieme (la premiere etant la table) valeur de l'array GET sera la condition d'update, generalement on voudrait update sur une seule ligne donc ça sera idTable=idLigneVoulue

?>