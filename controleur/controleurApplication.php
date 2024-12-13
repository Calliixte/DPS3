<?php
//methode afficher accueil
// <!-- on mettra les methodes de connexion /inscription dedans  -->
class controleurApplication{

public static function afficherHeader(){
    echo "<header>";
    if(isset($_SESSION["utilisateurCourant"])){
        $idUser = $_SESSION["utilisateurCourant"]->get('idUtilisateur');

        $photoProfil = "img/profilePicture/$idUser.jpg";
        if(!file_exists($photoProfil)){
            $photoProfil = "img/profilePicture/0.jpg";
        }
        
        include('vues/header.php');
        foreach($_SESSION['utilisateurCourant']->get('listeGroupes') as $groupe){
            include('vues/boutonGroupe.php');
        }
        echo "</nav>";
    }
    else{
        $photoProfil = "img/profilePicture/0.jpg";
        include('vues/header.php');
    }
   

    include('vues/boutonRejoindre.php');
    echo "<a href=routeur.php?actionConnexion=Connexion> se déconnecter </a> ";
    echo "</header>";
}

public static function afficherConnexion(){ 
    $_SESSION["utilisateurCourant"] = NULL; // flush l'utilisateur courant (déconnexion)
    $action = 'Connexion';

    if(isset($_GET['actionConnexion'])){
        $action =$_GET['actionConnexion'];
    }

    if($action == 'Connexion'){ 
        include("vues/formulaireConnexion.php");
        echo "<p>pas de compte ? 
                <a href=routeur.php?actionConnexion=Inscription>s'inscrire</a>
              </p>";
    }else{
        include("vues/formulaireInscription.html");
        echo "<p>Déjà un compte ? 
                <a href=routeur.php?actionConnexion=Connexion>connexion</a>
              </p>";
    }
}

public static function afficherPageAccueil(){



    $connected = isset($_SESSION["utilisateurCourant"]) && !isset($_GET['actionConnexion']);
    $titre = 'DPS3';
    $styleSpecial = '';
    
    
    include('vues/debut.php');
    if($connected){
        self::afficherHeader();

    }
    
    echo "<main>"; // Div par défaut dans lequel on affiche la page actuelle

    if($connected){
        echo $_SESSION["utilisateurCourant"]; 
    }else{ 
        self::afficherConnexion();
        $_SESSION["previous"]="connexion";
    }
    echo "</main>";
    include('vues/footer.html');
    include('vues/popups/addGroup.php');
    include('vues/fin.html');
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