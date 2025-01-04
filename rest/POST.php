<?php

require_once("../config/connexion.php");
require_once("../config/rest.php");
foreach(glob("../modele/*php") as $fichier){
    require_once($fichier);
}
Connexion::connect();
$lienDocu= "<a href=\"index.html\">documentation</a>";
if(!isset($_GET["table"])){
    echo "<b>Erreur : </b> Pour utiliser POST vous devez indiquer une <b>table</b> à modifier et la <b>nature</b> de votre requete (VALUES ou non), vous pouvez consulter la  $lienDocu pour en savoir plus. ";
    exit();
}
$table = $_GET["table"];
$val=0;
if(isset($_GET["VALUES"])){
    $val = $_GET["VALUES"];
    unset($_GET["VALUES"]);
}
unset($_GET["table"]); //retire table du tableau get pour les traitements qui vont suivre
if(count(array_values($_GET))==0){
    echo "<b>Erreur : </b> Aucune donnée à insérer n'est trouvée, veuillez vérifier votre URL, vous pouvez consulter la $lienDocu pour en savoir plus. ";
    exit();
}
if($val){ //l'utilisateur de l'api spécifiera si sa requete doit être executée comme un insert VALUES ou un insert de valeurs spécifiques
    //le seul interet de ceci coté utilisateur est de ne pas avoir a faire attention aux noms donnés avant les valeurs dans get, il devra néanmoins connaitre le nom et l'ordre des colonnes de la tables en conséquence de sa décision
    Rest::post($table,array_keys($_GET));
}else{
    Rest::post($table,array_values($_GET),array_keys($_GET));
}


















?>