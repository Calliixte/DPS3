<?php

//methode afficher accueil
// <!-- on mettra les methodes de connexion /inscription dedans  -->
class controleurApplication{

public static function afficherPagePrincipale(){
    echo "main";
    echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherGrandGroupe&id=1> voir la nav nan ? </a> ";
}


// public static function afficherNav(){
//     echo "Nav";
//     controleurApplication::afficherListeGroupe();
//     controleurUtilisateur::afficherPetitUtilisateur();
// }
// NE SERT A RIEN MAIS ARCHIVES HASSOUL
// public static function afficherListeGroupe(){
//     echo "listeGroupe";
//     //foreach dans listeGroupe de utilisateur 
//     for($i=0; $i<3; $i++){
//     controleurGroupe::afficherPetitGroupe();
// }
//     echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherPetitGroupe&id=$i> rejoindre un groupe </a> ";
// }

/*
methodes : 

    afficherGroupe()    
fonctionnera comme la méthode lireObjet, quand on clique sur un bouton de groupe ça passe son id dans le tableau get/post 
et la premiere chose c'est de le prendre pour afficher le groupe correspondant,
ensuite cette méthode doit appeller les vues classiques (header,nav,footer,main) puis 
afficher la structure (banniere + nom +les boutons à droite)
appeller avec un for 4x la vue qui affiche un vote en petit pour la page tendance
[potentiellement, avoir une nav DANS groupe qui propose tendance et tout et qui marche pareil]



APRES REFLEXION 
je pense que le raisonnement se prend pour construire d'autres pages MAIS ici pas besoin pour afficher les groupes, imo on fait
/groupe.php?id=x&action=[tendance,tous,trier]
cliquer sur un des groupes de la nav nous redirige vers /groupe.php?id=x 

pareil pour les votes dans le groupe 
/vote.php?id=x
pour voter on pourrait faire un fichier vote.php/voter (controleur aussi)
qui aurait un parametre vote.php/voter?choix=x



*/

}

?>