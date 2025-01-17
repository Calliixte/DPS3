<?php
//methode afficher accueil
// <!-- on mettra les methodes de connexion /inscription dedans  -->
class controleurApplication{

public static function afficherHeader(){
    echo "<header>";
    if(isset($_SESSION["utilisateurCourant"])){
        $idUser = $_SESSION["utilisateurCourant"]->get('idUtilisateur');

        $listePp = glob("img/profilePicture/$idUser.*"); //renvoie une liste de fichiers qui on le nom idUser.extension
        if (!empty($listePp)) {
            $photoProfil = $listePp[0]; //Dans le cas ou on a trouvé qqch, on prend le premier car ça sera le seul
        }else{
            $photoProfil = "img/profilePicture/0.jpg";
        }
        include('vues/header.php');
        foreach($_SESSION['utilisateurCourant']->get('listeGroupes') as $groupe){
            include('vues/boutonGroupe.php');
        }
        echo "</nav>";
        
    }
    else{
        echo "";
        $photoProfil = "img/profilePicture/0.jpg";
        include('vues/header.php');
    }

    include("vues/boutonOptions.php");
    echo "<a href=routeur.php?action=afficherConnexion> se déconnecter </a> ";
    echo "</header>";
}

public static function afficherConnexion(){
    if(isset($_GET["actionConnexion"])){
        if($_GET["actionConnexion"]=="Inscription"){
            $titre="Inscription à DPS3";
        }else{
            $titre="Connexion à DPS3";
        }
    }else{
        $titre="Connexion à DPS3";
    }

    $_SESSION["utilisateurCourant"] = NULL; // flush l'utilisateur courant (déconnexion)
    $_SESSION["previous"]="connexion";
    $action = 'Connexion';
    $styleSpecial = 'connexion';

    if(isset($_GET['actionConnexion'])){
        $action =$_GET['actionConnexion'];
    }

    include('vues/debut.php');
    echo '<main id="connexion">';

    if($action == 'Connexion'){ 
        include("vues/formulaireConnexion.php");
        echo "<p>pas de compte ? 
                <a href=routeur.php?action=afficherConnexion&actionConnexion=Inscription>s'inscrire</a>
              </p>";
    }else{
        include("vues/formulaireInscription.html");
        echo "<p>Déjà un compte ? 
                <a href=routeur.php?action=afficherConnexion&actionConnexion=Connexion>connexion</a>
              </p>";
    }
    echo "</main>";
    include('vues/footer.html');
    include('vues/popups/addGroup.php');
    include('vues/fin.html');
}

public static function afficherPageAccueil(){
    $titre = 'DPS3';

    include('vues/debut.php');

    self::afficherHeader();
    echo '<main>';
    
    $nomU = $_SESSION["utilisateurCourant"]->get("nom");
    $prenomU = $_SESSION["utilisateurCourant"]->get("prenom");
    $pseudoU = $_SESSION["utilisateurCourant"]->get("pseudo");
    include("vues/accueil.php");

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