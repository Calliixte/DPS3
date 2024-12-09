<?php




require_once("config/connexion.php");

require_once("modele/message.php");
require_once("modele/reaction.php");
require_once("modele/utilisateur.php");
require_once("modele/groupe.php");
require_once("modele/vote.php");

Connexion::connect();

$utilisateur = Utilisateur::getUtilisateur(1);
// $utilisateur->display();

// $groupe = Groupe::getGroupe(1);
// $groupe->display();
// include('vues/boutonGroupe.php');

$titre = 'DPS3';
$styleSpecial = '';

include('vues/debut.php');
include('vues/header.html');
echo '<main>';
echo '<h2>DPS3</h2>';

echo '<p>ici c\'est le main</p>';

echo '</main>';
include('vues/footer.html');
include('vues/fin.html');


?>
